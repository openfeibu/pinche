<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/11/10
 * Time: 下午6:36
 */

namespace app\carpool\service;


use app\carpool\model\CarpoolContent;
use app\carpool\model\CarpoolOrder;
use app\carpool\model\CarpoolUser;
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
     * @param CarpoolOrder $order 订单
     */
    public function paySuccess(CarpoolOrder $order) {
        $order_id = $order -> getId();
        $content = CarpoolContent::get(['order_id' => $order_id]);
        if($content) {
            //发帖支付回调
            $content -> setStatus(1) -> save();
            //更新手机号
            $user_id = $content -> getUserId();
            $carpoolUser = CarpoolUser::get(['id' => $user_id]);
            if($carpoolUser) {
                $carpoolUser -> setPhone($content -> getPhone());
                $carpoolUser -> save();
            }
        } else {
            $extra = $order -> getExtraa();
            if(isset($extra['id']) && isset($extra['hour'])) {
                //置顶帖支付回调
                $c = CarpoolContent::get(['id' => $extra['id']]);
                if($c) {
                    $now = time();
                    $time = $c -> getTopTime();
                    if($now > $time) {
                        $time = $now;
                    }
                    $time += $extra['hour'] * 3600;
                    $c -> setTopTime($time) -> save();
                    //更新手机号
                    $user_id = $c -> getUserId();
                    $carpoolUser = CarpoolUser::get(['id' => $user_id]);
                    if($carpoolUser) {
                        $carpoolUser -> setPhone($c -> getPhone());
                        $carpoolUser -> save();
                    }
                }
            }
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





}