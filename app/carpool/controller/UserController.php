<?php

/**
 * @Description:用户管理接口
 * @Author: Danny
 * @Date:   2017-12-18 09:59:44
 * @Last Modified by:   Danny
 * @Last Modified time: 2018-01-14 17:51:51
 */

namespace app\carpool\controller;


use app\carpool\service\UserService;
use app\carpool\model\CarpoolUser;
use app\carpool\model\UserPay;
use app\core\base\BaseController;
use app\core\comp\Result;
use app\core\comp\UserHolder;
use app\core\XConfig;
use rap\Aop\EventHook;
use rap\Ioc;

class UserController extends BaseController {

    /**
     * @var $userService UserService
     */
    private $userService;
    protected function _initialize() {
        parent::_initialize();
        $this->userService=Ioc::get(UserService::class);
    }
    /**
     * 马甲用户登录
     * @param string $openid 马甲用户openid
     * @param string $name 马甲用户昵称
     * @param string $facurl 马甲用户头像
     * @return mixed
     */
    public function magUserLogin($openid, $name, $head) {
        if(emptys($openid, $name)) {
            return Result::error('登录失败');
        }
        $carpoolUser = CarpoolUser::get(['mag_open_id' => $openid]);
        $token = md5str(time() .$openid. $name. $head);
        if(!$carpoolUser) {
            $carpoolUser = new CarpoolUser();
        }
        $carpoolUser -> setMagOpenId($openid);
        if(!empty($name)) {
            $carpoolUser -> setName($name);
        }
        if(!empty($head)) {
            $carpoolUser -> setHead($head);
        }
        $carpoolUser -> save();
        cache("token_" . $token, $carpoolUser -> getId());
        cookie(md5str("usertoken"), $carpoolUser -> getId());
        session("userid", $carpoolUser -> getId());
        return Result::data(["token" => $token]);
    }
    /***
     * 获取用户账号余额
     * @return Result
     */
    public function getUserAmount() {
        $userid = UserHolder::getUserId();
        if(!empty($userid)) {
            $amount =$this->userService->getUserAmount($userid);
            $amount=$amount?:0;
            return Result::data($amount);
        } 
        else {
            return Result::error('请先登录');
        }
    }
    /**
     * 设置推荐人信息
     * @param $openid 推荐人openId
     */
    public function createExpandInfo($openid)
    {
        //获取当前用户ID
        $userid = UserHolder::getUserId();
        if(!empty($userid)) 
        {
            //关联当前用户的推荐人信息
            $carpoolUser = CarpoolUser::get(['id' => $userid]);
            $source_openid =$carpoolUser-> getWxOpenId();
            //推荐人信息是否存在
            if(empty($carpoolUser-> getTjzOpenId()) && $source_openid!=$openid)
            {
                //设置推荐人openId
                $carpoolUser -> setTjzOpenId($openid);
                 //更新用户推荐人信息
                $carpoolUser -> save();

                // 设置推荐人的账户余额：追加推广金额
                $expandCarpoolUser = CarpoolUser::get(['wx_open_id' => $openid]);
                $appid = XConfig::get('config_pay_wx_small_appid');
                $expandCost = XConfig::get('carpool_expand_cost');
                $user_amount=$expandCarpoolUser-> getAmount();
                $expandCarpoolUser-> setAmount($user_amount+$expandCost);
                $expandCarpoolUser->save();

                //添加充值记录
                $userPay = new UserPay();
                $userPay->setUserId($expandCarpoolUser->getId());
                $userPay->setAmount($expandCost);
                $userPay->setGiveAmount(0);
                //充值类型：1-现金；2-推广；3-赠送(初始化);
                $userPay->setType(2);
                //支付状态:0-待支付；1-支付成功；2-支付失败；
                $userPay->setStatus(1);
                $userPay->setCreateTime(time());
                $userPay->save();
                return Result::success('推荐人添加成功');
            }
            else
            {
                return Result::error('无法添加推荐人');
            }
        }
        else {
            return Result::error('请先登录');
        }
    }
}