<?php
/**
 * Created by PhpStorm.
 * User: Xsx
 * Date: 2017/1/4
 * Time: 19:40
 */

namespace app\carpool\model;


class WxJsapiData {

    private $jsapi_ticket;

    private $url;

    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string 产生的随机字符串
     */
    public function getNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for( $i = 0; $i < $length; $i++ ) {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    public function setUrl($url) {
        $this -> url = $url;
    }

    public function setJsapiTicket($ticket) {
        $this -> jsapi_ticket = $ticket;
    }

    public function toUrlParams($values) {
        $buff = "";
        foreach ($values as $k => $v) {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    public function makeSign() {
        $rs['noncestr'] = $this -> getNonceStr();
        $rs['jsapi_ticket'] = $this -> jsapi_ticket;
        $rs['timestamp'] = time();
        $rs['url'] = $this -> url;
        ksort($rs);
        $string = $this -> toUrlParams($rs);
        $rs['signature'] = sha1($string);
        return $rs;
    }


}