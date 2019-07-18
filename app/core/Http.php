<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/26
 * Time: 下午3:46
 */

namespace app\core;


use think\Debug;

class Http {
    private $method = "get";
    private $url;
    private $header = [];
    private $params = [];

    public static function get($url) {
        $http = new Http();
        $http->method = "get";
        $http->url = $url;
        return $http;
    }

    public static function post($url) {
        $http = new Http();
        $http->method = "post";
        $http->url = $url;
        return $http;
    }

    public function header($key, $value = "") {
        if (is_array($key)) {
            $this->header = array_merge($this->header, $key);
        } else {
            $this->header[$key] = $value;
        }
        return $this;
    }

    public function param($key, $value = "") {
        if (is_array($key)) {
            $this->params = array_merge($this->params, $key);
        } else {
            $this->params[$key] = $value;
        }
        return $this;
    }

    private function response() {
        Debug::remark('begin');
        $url = $this->url;
        if ($this->method == 'get') {

            if ($this->params) {
                if (!strstr($url, "?")) {
                    $url = $url . "?";
                }
            }
            if (!string_end($url, "&")) {
                if(!string_end($url, "?")){
                    $url = $url . "&";
                }
            }
            foreach ($this->params as $key => $value) {
                $url .= $key . "=" . $value."&";
            }
            $response = \Requests::get($url, $this->header);
        }else{
            $response= \Requests::post($url, $this->header, $this->params);
        }
        Debug::remark('end');
        $time=Debug::getRangeTime('begin','end',6).'s';
        trace("远程调用");
        trace($url);
        trace("远程调用花费".$time);
        trace("远程参数:");
        trace($this->params);
        trace("远程调用请求头:");
        trace($this->header);
        trace("远程调用返回参数");
        trace($response->body);
        return $response;
    }

    public function body() {
        return $this->response()->body;
    }

    public function json() {
        $response = $this->response();
        return json_decode($response->body, true);
    }



}