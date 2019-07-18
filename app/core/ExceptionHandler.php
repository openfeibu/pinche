<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/25
 * Time: 下午6:27
 */

namespace app\core;


use think\Config;
use think\exception\Handle;
use think\exception\HttpException;
use think\Response;

class ExceptionHandler extends Handle {
    public function render(\Exception $e) {
        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
        }
        if (Config::get("app_trace") && isset($_GET['trace']) ? $_GET['trace'] : false) {
            return parent::render($e);
        }
        $data = ["success" => false, "msg" => $e->getMessage(), "code" => $e->getCode()];
        $response = Response::create($data, "json");
        return $response;
    }


}