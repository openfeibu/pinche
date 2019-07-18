<?php

namespace app\core\comp\config;

use app\core\CacheKeys;
use think\Cache;
use think\Config;
use think\Exception;
use traits\think\Instance;

/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/26
 * Time: 上午9:40
 */
class SiteConfig {
    use Instance;

    private $config;

    /**
     * 保存配置
     * @param $key
     * @param $value
     * @throws Exception
     */
    public function set($key, $value) {
        $set = Setting::get($key);
        if (!$set) {
            throw new Exception("配置内容不存在");
        }
        $set->setValue($value);
        $set->save();
        //更新缓存数据
        $this->config = Cache::get(CacheKeys::$SiteConfigCacheKey);
        if ($this->config) {
            $this->config[$key] = $value;
            Cache::set(CacheKeys::$SiteConfigCacheKey, $this->config);
        }
    }

    /**
     * 获取配置信息 先获取数据库中的配置,没有会获取项目配置
     * @param $key
     * @param string $def
     * @return mixed
     */
    public function get($key, $def = "") {
        $val = null;
        if (!$this->config) {
            $this->config = Cache::get(CacheKeys::$SiteConfigCacheKey);
        }
        if (!$this->config) {
            $this->config = $this->loadDbSetting();
            Cache::set(CacheKeys::$SiteConfigCacheKey, $this->config);
        }
        if (array_key_exists($key, $this->config)) {
            $val = $this->config[$key];
        }
        if (!$val) {
            $val = Config::get($key);
        }
        if (!$val) {
            $val = $def;
        }
        return $val;
    }

    /**
     * 加载数据库中的配置
     * @return array
     */
    private function loadDbSetting() {
        $settings = Setting::all();
        $config = [];
        /* @var $setting Setting */
        foreach ($settings as $setting) {
            $config[$setting->getKey()] = $setting->getValue();
        }
        return $config;
    }

    public function clearCache(){
        $this->config=null;
        Cache::rm(CacheKeys::$SiteConfigCacheKey);
    }

}