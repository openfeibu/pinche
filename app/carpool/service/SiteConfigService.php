<?php

/**
 * 同路者
 * User: zhangyahui_0725@163.com
 * Date: 17/12/17
 * Time: 下午5:36
 */
namespace app\carpool\service;

use app\core\XConfig;

class SiteConfigService {

    /**
     * 获取发布信息金额
     * @param $type 类型 1:人找车 2:车找人 3:货找车 4:车找货
     * @return int 发布金额
     */
    public function getCarpoolPostCost($type){
        $post_cost=0;
        switch($type){
            case 1:
                $post_cost = XConfig::get("carpool_customer_post_cost");
                break;
            case 2:
            case 4:
                $post_cost = XConfig::get("carpool_owners_post_cost");
                break;
            case 3:
                $post_cost = XConfig::get("carpool_goods_post_cost");
                break;
            default:
                break;
        }
        return $post_cost;
    }
}