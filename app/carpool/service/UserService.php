<?php

/**
 * 同路者
 * User: zhangyahui_0725@163.com
 * Date: 17/12/17
 * Time: 下午5:36
 */
namespace app\carpool\service;
use app\carpool\model\CarpoolUser;

class UserService {

    /***
     * 获取用户账号余额
     * @param $userid 用户id
     * @return Result
     */
    public function getUserAmount($userid) {
         $carpoolUser = CarpoolUser::get(['id' => $userid]);
         $amount =0;
         if($carpoolUser) {
            $amount = $carpoolUser -> getAmount();
         }
         return $amount;
    }
    /***
     * 更新用户账号余额
     * @param $userid 用户id 
     * @param $amount 余额
     */
    public function updateUserAmount($userid,$amount) {
         $carpoolUser = CarpoolUser::get(['id' => $userid]);
         if($carpoolUser) {
            $carpoolUser -> setAmount($amount);
         }
         $carpoolUser->save();
    }
}