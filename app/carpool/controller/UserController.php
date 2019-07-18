<?php
/**
 * Created by PhpStorm.
 * User: Xsx
 * Date: 2016/12/29
 * Time: 21:51
 */

namespace app\carpool\controller;


use app\carpool\model\CarpoolUser;
use app\core\base\BaseController;
use app\core\comp\Result;

class UserController extends BaseController {

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

}