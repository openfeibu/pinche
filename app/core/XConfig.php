<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/26
 * Time: 下午2:40
 */

namespace app\core;


use app\core\comp\config\SiteConfig;

class XConfig {

    //qq登录的appid
    public static $qq_appid = "site_regist_qq_appid";
    //dz的接口网址
    public static $dz_url = "dz_http_url";
    //dz接口header
    public static $dz_http_header = "dz_http_header";

    //dz的接口网址
    public static $phone_code_type = "phone_code_type";

    public static $phone_code_url = "phone_code_url";

    public static $phone_code_url_key = "phone_code_url_key";

    /**
     * 保存配置
     * @param $key
     * @param $value
     */
    public static function set($key, $value) {
        SiteConfig::instance()->set($key, $value);
    }

    /**
     * 获取配置信息 先获取数据库中的配置,没有会获取项目配置
     * @param $key
     * @param string $def
     * @return mixed
     */
    public static function get($key, $def = "") {
        return SiteConfig::instance()->get($key, $def);
    }

    /**
     *情空缓存
     */
    public static function clearCache(){
        SiteConfig::instance()->clearCache();
    }
}