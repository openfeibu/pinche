<?php
/**
 * @Description:订单服务类
 * @Author: Danny
 * @Date:   2017-12-18 09:59:44
 * @Last Modified by:   Danny
 * @Last Modified time: 2017-12-27 14:15:25
 */

namespace app\carpool\service;


use app\carpool\model\CarpoolContent;
use app\carpool\model\CarpoolOrder;
use app\carpool\model\UserPay;
use app\carpool\model\CarpoolUser;
use app\carpool\service\WeixinService;
use app\carpool\service\UserService;
use app\core\comp\UserHolder;
use rap\Aop\EventHook;
use rap\Ioc;
use think\captcha\Captcha;
use think\Exception;

class OrderService {
    /**
     * @var $wxService WeixinService
     */
    private  $wxService;

    public function _initialize() {
        $this->wxService=Ioc::get(WeixinService::class);
        $this->userService=Ioc::get(UserService::class);
        
    }

    /**
     * 创建订单
     */
    public function createOrder($title, $money, $extra = null){
        $order = new CarpoolOrder();
        $order->setUserId(UserHolder::getUserId());
        $order->setStatus(0);
        $order->setMoney($money);
        $order->setExtraa($extra);
        $order->setTitle($title);
        $order->setCreateTime(time());
        $order->save();
        $u = CarpoolUser::get(['id' => $order -> getUserId()]);
        return $this->wxService->createJsOrder($order->getId(), $title, $money * 100, $u -> getWxOpenId(), '/carpool/order/wxPaySuccess');
    }

    /**
     * 检查订单是否已支付
     * @param $id
     * @return boolean
     */
    public function orderIsPay($id){
        $order=CarpoolOrder::get($id);
        return $order&&$order->getStatus()==1;
    }

    /**
     * 关闭订单
     * @param $id
     */
    public function closeOrder($id){
      $order=CarpoolOrder::get($id);
       if($order&&$order->getStatus()==0){
           $order->setStatus(-1);
           $order->save();
       }
    }

    /***
     *  支付成功后的钩子回调
     * 标志
     * @param CarpoolOrder $pay 订单
     */
    public function paySuccess(UserPay $pay) 
    {
        //更新支付状态成功后，在执行账户余额更新
        if($pay-> getStatus()==1)
        {
            $amount =floatval($pay->getAmount())+floatval($pay->getGiveAmount());
            $user_id = $pay->getUserId();
            //获取账户余额
            $user_amount =$this -> userService -> getUserAmount($user_id);
            $user_amount +=$amount;
            //更新账户余额
            $this->userService->updateUserAmount($user_id,$user_amount);
        }
    }

    /**
     * 创建支付订单
     * @param $paySource int 支付来源 //1:小程序、2：微信APP、3：微信JS支付、4、支付宝APP、5、支付宝手机网站
     * @param $title
     * @param $money
     * @param null $extra
     * @return array
     */
    public function createPayOrder($paySource, $title, $money, $extra = null) {
        $order = new CarpoolOrder();
        $order->setUserId(UserHolder::getUserId());
        $order->setStatus(0);
        $order->setMoney($money);
        $order->setExtraa($extra);
        $order->setTitle($title);
        $order->setCreateTime(time());
        $order->save();
        $pay_params = [];
        if($paySource == 1 || $paySource == 3) {
            $u = CarpoolUser::get(['id' => $order -> getUserId()]);
            $pay_params = $this -> wxService -> createJsOrder($order->getId(), $title, $money * 100,
                $u -> getWxOpenId(), '/carpool/order/wxPaySuccess', $paySource);
        } else if($paySource == 2) {
            $pay_params = $this -> wxService -> createAppOrder($order->getId(), $title, $money * 100, '/carpool/order/wxPaySuccess');
        }
        $pay_params['order_id'] = $order -> getId();
        return $pay_params;
    }
       /**
     * 创建支付成功的订单
     * @param $title
     * @param $money
     * @param null $extra
     * @return array
     */
    public function addOrder( $title, $money, $extra = null) 
    {
        $order = new CarpoolOrder();
        $order->setUserId(UserHolder::getUserId());
        $order->setStatus(1);
        $order->setMoney($money);
        $order->setExtraa($extra);
        $order->setTitle($title);
        $order->setCreateTime(time());
        $order->save();
        return $order -> getId();
    }

}