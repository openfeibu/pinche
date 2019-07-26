<?php

/**
 * @Description:微信服务类
 * @Author: Danny
 * @Date:   2017-12-14 15:27:25
 * @Last Modified by:   Danny
 * @Last Modified time: 2018-01-10 15:01:02
 */
namespace app\carpool\service;

use app\carpool\model\CarpoolOrder;
use app\carpool\model\UserPay;
use app\carpool\service\UserService;
use app\core\Http;
use app\core\XConfig;
use rap\Aop\EventHook;
use rap\Ioc;
use think\Exception;


class WeixinService {

    private  $userService;

    public function _initialize() {
        $this->userService=Ioc::get(UserService::class);
    }
    private $tradeNoPre = 'cn20180118';
    /**
     * 微信登录
     * @param  int $code  登录编码
     * @return string     微信openid唯一标识
     */
    public function wxLogin($code){
        $appid = XConfig::get('config_pay_wx_small_appid');
        $secret = XConfig::get('config_pay_wx_small_secret');
        $data=Http::get("https://api.weixin.qq.com/sns/jscode2session")
            ->param("appid", $appid)
            ->param("secret", $secret)
            ->param("js_code",$code)
            ->param("grant_type","authorization_code")->json();
        if(!array_key_exists("openid",$data)){
            throw new Exception("获取用户信息失败,请退出后重新进入");
        }
        return $data;
    }

    public function createJsOrder($order_no, $body, $totalFee, $openid, $notify_url = '/carpool/order/wxPaySuccess', $paySource = 1) {
        $inputObj = new \WxPayUnifiedOrder();
        $inputObj -> SetOut_trade_no($this -> tradeNoPre . $order_no);
        $inputObj -> SetBody($body);
        $inputObj -> SetTotal_fee($totalFee);
        $inputObj -> SetTrade_type('JSAPI'); //JSAPI--公众号支付、NATIVE--原生扫码支付、APP--app支付
        $inputObj -> SetNotify_url("https://".$_SERVER['HTTP_HOST']. $notify_url); //付款成功通知地址
        $inputObj -> SetOpenid($openid);
        $inputObj -> SetPaySource($paySource);
        $result = \WxPayApi:: unifiedOrder($inputObj);
        if($result['return_code'] == 'SUCCESS') {
            if($result['result_code'] == 'SUCCESS' && !empty($result['prepay_id'])) {
                $jsApiPay = new \WxPayJsApiPay();
                $jsApiPay -> SetAppid($result['appid']);
                $jsApiPay -> SetNonceStr($result['nonce_str']);
                $jsApiPay -> SetPackage('prepay_id=' . $result['prepay_id']);
                $jsApiPay -> SetTimeStamp(time());
                $jsApiPay -> SetSignType('MD5');
                $jsApiPay -> SetSign();
                return array('appid' => $result['appid'], 'noncestr' => $result['nonce_str'], 'sign' => $jsApiPay -> GetSign(),
                    'package_' => $jsApiPay -> GetPackage(), 'timeStamp' => $jsApiPay -> GetTimeStamp(), 'order_id' =>$order_no);
            } else {
                throw new Exception("微信下单失败,请稍后再试");
            }
        } else {
            throw new Exception("微信下单失败,请稍后再试" . $result['return_msg']);
        }
    }

    public function createAppOrder($order_no, $body, $totalFee, $notify_url) {
        $inputObj = new \WxPayUnifiedOrder();
        $inputObj -> SetOut_trade_no($this -> tradeNoPre . $order_no);
        $inputObj -> SetBody($body);
        $inputObj -> SetTotal_fee($totalFee);
        $inputObj -> SetTrade_type('APP'); //JSAPI--公众号支付、NATIVE--原生扫码支付、APP--app支付
        $inputObj -> SetNotify_url("http://".$_SERVER['HTTP_HOST']. $notify_url); //付款成功通知地址
        $inputObj -> SetPaySource(2);
        $result = \WxPayApi:: unifiedOrder($inputObj);
        if($result['return_code'] == 'SUCCESS') {
            if($result['result_code'] == 'SUCCESS' && !empty($result['prepay_id'])) {
                $appApiPay = new \WxPayAppApiPay();
                $appApiPay -> SetAppid($result['appid']);
                $appApiPay -> SetNoncestr($result['nonce_str']);
                $appApiPay -> SetPackage('Sign=WXPay');
                $appApiPay -> SetPrepayid($result['prepay_id']);
                $appApiPay -> SetPartnerid($result['mch_id']);
                $appApiPay -> SetTimestamp(time());
                $appApiPay -> SetSign();
                return $appApiPay -> GetPayParams();
            } else {
                throw new Exception("微信下单失败,请稍后再试");
            }
        } else {
            throw new Exception("微信下单失败,请稍后再试");
        }

    }

    /**
     * 微信支付成功后回调
     * @param $xml
     * @return string
     * @throws Exception
     */
    public function orderPaySuccess($xml){
        $result = \WxPayResults::Init($xml);
        $outTradeNo =  $result['out_trade_no'];
        $result_code = $result['result_code'];
        $return_code = $result['return_code'];
        $payresponse = new \WxPayResults();
        if($result_code == 'SUCCESS' && $return_code == 'SUCCESS') {
            $outTradeNo = str_replace($this -> tradeNoPre, '', $outTradeNo);
            $payresponse -> SetData('return_code', 'SUCCESS');
            $payresponse -> SetData('return_msg', '');
            //获取充值信息
            $pay = UserPay::get($outTradeNo);
            //支付状态:0-待支付；1-支付成功；2-支付失败；
            $pay -> setStatus(1);
            $pay -> save();
            EventHook::trigger("orderPaySuccess", $pay);
        } else {
            $payresponse -> SetData('return_code', 'FAIL');
            $payresponse -> SetData('return_msg', '');
        }
        return $payresponse -> ToXml();
        throw  new Exception("支付信息错误");
    }

    public function refreshSmallAccessToken() {
        $appid = XConfig::get('config_pay_wx_small_appid');
        $secret = XConfig::get('config_pay_wx_small_secret');
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $secret;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($res, true);
        return $rs;
    }


    public function refreshJsAccessToken() {
        $appid = XConfig::get('config_pay_wx_js_appid');
        $secret = XConfig::get('config_pay_wx_js_secret');
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $secret;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($res, true);
        return $rs;
    }


    /**
     * 刷新jsapi_ticket
     * @param $access_token
     * @return mixed
     */
    public function refreshJsapiTicket($access_token) {
        $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $access_token . '&type=jsapi';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($res, true);
        return $rs;
    }

}