<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/9/29
 * Time: 上午10:10
 */

namespace app\core\comp;


class Result {

    public $success;
    public $code;
    public $msg;

    public static function argsMiss($msg = "提交的参数不完整"){
        $result = new Result();
        $result->success = false;
        $result->code = 10000;
        $result->msg = $msg;
        return $result;
    }

    public static function error()
    {
        $result = new Result();
        $args = func_get_args();
        if (count($args) == 0) {
            $args[0] = "10001";
            $args[1] = "提交的内容错误";
        } else if (count($args) == 1) {
            $args[] = $args[0];
            $args[0] = "10001";
        }
        $result->success = false;
        $result->code = $args[0];
        $result->msg = $args[1];
        return $result;
    }

    public static function roleError()
    {
        $result = new Result();
        $args = func_get_args();
        if (count($args) == 0) {
            $args[0] = "10002";
            $args[1] = "权限不足";
        } else if (count($args) == 1) {
            $args[] = $args[0];
            $args[0] = "10002";
        }
        $result->success = false;
        $result->code = $args[0];
        $result->msg = $args[1];
        return $result;
    }


    public static function success($msg = "")
    {
        $result = new Result();
        $args = func_get_args();
        if (count($args) == 1) {
            $args[] = $args[0];
            $args[0] = true;
        }
        $result->success = $args[0];
        $result->code = 101;
        $result->msg = $args[1];
        return $result;
    }

    public static function data()
    {
        $args = func_get_args();

        if (count($args) == 1) {
            $args[] = $args[0];
            $args[0] = "data";
        }
        $result = new Result();
        $result->success = true;
        $result->code = 100;
        $result->$args[0] = $args[1];
        return $result;
    }

    public static function datalist($val)
    {
        $result = new Result();
        $result->success = true;
        $result->code = 100;
        $result->list = $val;
        return $result;
    }

    public function code($code)
    {
        $this->code = $code;
    }

    public function msg($msg)
    {
        $this->msg = $msg;
    }

    public function put($key, $val)
    {
        $this->$key = $val;
        return $this;
    }


}