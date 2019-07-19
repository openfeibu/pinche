<?php

/**
 * @Description:用户充值服务类
 * @Author: Danny
 * @Date:   2017-12-22 15:49:13
 * @Last Modified by:   Danny
 * @Last Modified time: 2018-01-14 15:34:49
 */
namespace app\carpool\service;

use app\carpool\model\UserPay;
use app\carpool\model\PaySetting;
use app\carpool\model\CarpoolUser;
use app\carpool\service\WeixinService;
use rap\Aop\EventHook;
use rap\Ioc;

class UserPayService {

    /**
     * @var $wxService WeixinService
     */
    private  $wxService;

    public function _initialize() {
        $this->wxService=Ioc::get(WeixinService::class);
    }
    /**
     * 创建充值记录
     * @param $paySource int 支付来源 //1:小程序、2：微信APP、3：微信JS支付、4、支付宝APP、5、支付宝手机网站
     * @param $userid 用户ID
     * @param $amount 充值金额 
     */
    public function createUserPay($paySource,$userid,$amount){
        //根据充值金额，获取赠送金额
        $paySettings = PaySetting::get(['amount' => $amount]);
        $giveAmount=$paySettings->getGiveAmount();
        //充值
        $info = new UserPay();
        $info->setUserId($userid);
        $info->setAmount($amount);
        $info->setGiveAmount($giveAmount);
        //充值类型：1-现金；2-推广；3-初始化;
        $info->setType(1);
        //支付状态:0-待支付；1-支付成功；2-支付失败；
        $info->setStatus(0);
        $info->setCreateTime(time());
        $info->save();

        $u = CarpoolUser::get(['id' => $info -> getUserId()]);
        $title=$u->getName()."充值";
        $pay_params = [];
        if($paySource == 1 || $paySource == 3) {
            $pay_params = $this -> wxService -> createJsOrder($info->getId(), $title, $amount * 100,
                $u -> getWxOpenId(), '/carpool/order/wxPaySuccess', $paySource);
        } else if($paySource == 2) {
            $pay_params = $this -> wxService -> createAppOrder($info->getId(), $title, $amount * 100, '/carpool/order/wxPaySuccess');
        }
        $pay_params['pay_id'] = $info -> getId();
        return $pay_params;
    }
}