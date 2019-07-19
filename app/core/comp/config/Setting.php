<?php
namespace app\core\comp\config;

use app\core\base\BaseModel;

/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/10/26
 * Time: 上午9:35
 */
class Setting extends BaseModel {

    protected $pk_auto_increase = false;

    protected $table = 'mag_setting';

    public function setKey($key) {
        return $this->setAttr("key", $key);
    }

    public function getKey() {
        return $this->getAttr("key");
    }

    public function setValue($value) {
        return $this->setAttr("value", $value);
    }

    public function getValue() {
        return $this->getAttr("value");
    }

    public function setName($name) {
        return $this->setAttr("name", $name);
    }

    public function getName() {
        return $this->getAttr("name");
    }

}