<?php
/**
 * Created by PhpStorm.
 * User: Xsx
 * Date: 2017/1/1
 * Time: 20:59
 */

namespace app\carpool\controller;


use app\carpool\model\CarpoolUser;
use app\carpool\model\WxJsapiData;
use app\carpool\service\WeixinService;
use app\core\base\BaseController;
use app\core\comp\Result;
use app\core\comp\UserHolder;
use app\core\XConfig;
use rap\Ioc;

class WeixinController extends BaseController {

    /**
     * @var $weixinService WeixinService
     */
    private $weixinService;

    protected function _initialize() {
        parent::_initialize();
        $this -> weixinService = Ioc::get(WeixinService::class);
    }


    public function getAuthUrl($location) {
        $appid = XConfig::get('config_pay_wx_js_appid');
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)
            ? "https://" : "http://";
        $redirect_url = '/wap/views/home.html';
        if($location == 'mypost') {
            $redirect_url = '/wap/views/my-posted.html';
        } else if($location == 'seekcar') {
            $redirect_url = '/wap/views/seek-car.html';
        } else if($location == 'seekperson') {
            $redirect_url = '/wap/views/seek-person.html';
        }
        $redirect_url = $protocol . $_SERVER['HTTP_HOST'] . $redirect_url;
        $authUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid .
            '&redirect_uri=' . $redirect_url . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        return Result::data($authUrl);
    }

    public function getOpenid($code) {
        $appid = XConfig::get('config_pay_wx_js_appid');
        $secret = XConfig::get('config_pay_wx_js_secret');
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='
            . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($res, true);
        $openid = $rs['openid'];
        $access_token = $rs['access_token'];
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token .
            '&openid=' . $openid . '&lang=zh_CN';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($res, true);
        if($rs['openid'] && $rs['nickname']) {
            $carpoolUser = CarpoolUser::get(['wx_open_id' => $openid]);
            if(!$carpoolUser) {
                $carpoolUser = new CarpoolUser();
                $carpoolUser -> setWxOpenId($openid);
                $carpoolUser -> setName($rs['nickname']);
                $carpoolUser -> setHead($rs['headimgurl']);
                $carpoolUser -> setSex($rs['sex']);
                $carpoolUser -> save();
            }
            $token = md5str(time() .$openid. $carpoolUser -> getName() . $carpoolUser -> getHead());
            cache("token_" . $token, $carpoolUser -> getId());
            cookie(md5str("usertoken"), $carpoolUser -> getId());
            session("userid", $carpoolUser -> getId());
            return Result::data(["token" => $token]);
        } else {
            return Result::error('登录失败，请退出重新进入或联系管理员');
        }
    }

    /**
     * 小程序获取access_token
     * @return Result
     */
    public function getSmallAccessToken() {
        $userId = UserHolder::getUserId();
        if($userId > 0) {
            $key = 'small_access_token_user_id_' . $userId;
            $data = cache($key);
            if($data) {
                return Result::data($data);
            } else {
                $rs = $this -> weixinService -> refreshSmallAccessToken();
                if($rs['access_token'] && $rs['expires_in']) {
                    $access_token = $rs['access_token'];
                    $expires_in = $rs['expires_in'];
                    cache($key, $access_token, $expires_in - 60);
                    return Result::data($access_token);
                } else {
                    return Result::error('获取access_token失败');
                }
            }
        } else {
            return Result::error('请先登录');
        }
    }

    /**
     * 微信js获取授权
     * @param strig $url 页面地址
     * @return Result
     */
    public function getJsapiTicket($url) {
        $userId = UserHolder::getUserId();
        if($userId > 0) {
            $key = 'js_access_token_user_id_' . $userId;
            $data = cache($key);
            if(!$data) {
                $rs = $this -> weixinService -> refreshJsAccessToken();
                if($rs['access_token'] && $rs['expires_in']) {
                    $access_token = $rs['access_token'];
                    $expires_in = $rs['expires_in'];
                    cache($key, $access_token, $expires_in - 60);
                    $data = $access_token;
                } else {
                    return Result::error('获取access_token失败');
                }
            }
            $key = 'jsapi_ticket_' . $userId;
            $ticket = cache($key);
            if(!$ticket) {
                $rs = $this -> weixinService -> refreshJsapiTicket($data);
                if($rs['ticket'] && $rs['expires_in']) {
                    $ticket = $rs['ticket'];
                    $expires_in = $rs['expires_in'];
                    cache($key, $ticket, $expires_in - 60);
                }
            }
            $wxJsapiData = new WxJsapiData();
            $wxJsapiData -> setJsapiTicket($ticket);
            $wxJsapiData -> setUrl($url);
            $rs = $wxJsapiData -> makeSign();
            $appid = XConfig::get('config_pay_wx_js_appid');
            $rs['appid'] = $appid;
            return Result::data($rs);
        } else {
            return Result::error('请先登录');
        }
    }

}