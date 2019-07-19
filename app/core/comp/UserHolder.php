<?php
/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/9/29
 * Time: 上午10:10
 */
namespace app\core\comp;

use app\mag\user\model\User;
use app\mag\user\service\UserService;
use rap\Ioc;
use think\Request;

class UserHolder {

    /**
     * 获取当前用户
     */
    public static function getUser() {
        if(static::$user)return static::$user;
        /* @var $service UserService */
        $service = Ioc::get(UserService::class);
        if (session("userid")) {
            static::$user=$service->getUser(session("userid"));
        } else {
            $token=Request::instance()->param("token");
            $token = Request::instance()->header('user-token');
            if (!$token) {
                $token = cookie(md5str("usertoken"));
            }
            if (!$token) {
                $token=Request::instance()->param("token");
            }
            if (!$token) {
                return null;
            }
            $user = User::get(["token" => $token]);
            if ($user) {
                session("userid", $user->getUserId());
                cookie(md5str("usertoken"), $token, 3600000);
            }
            static::$user=$service->getUser(session("userid"));
        }
        return static::$user;
    }

    public static function getUserId()
    {
        if (session("userid")) {
            return session("userid");
        } else {
            $token = Request::instance()->param("token");
            $token = Request::instance()->header('user-token');
            if (!$token) {
                $token = cookie(md5str("usertoken"));
            }
            if (!$token) {
                $token=Request::instance()->param("token");
            }
            if (!$token) {
                return null;
            }
            return cache("token_" . $token);
        }

    }


}