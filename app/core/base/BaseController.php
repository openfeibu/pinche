<?php
/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/9/29
 * Time: 上午9:38
 */

namespace app\core\base;


use think\Controller;

class BaseController extends Controller {



    /**
     * 获取参数数组
     */
    protected function getArgs($method, $args) {
        return getMethodParams($this, $method, $args);
    }

    /**
     * 获取不为空的参数数组
     * @param $method
     * @param $args
     * @return array
     */
    protected function getArgsNotNull($method, $args) {
        $args = getMethodParams($this, $method, $args);
        foreach ($args as $key => $value) {
            if ($value == null) {
                unset($args[$key]);
            }
        }
        return $args;
    }
}