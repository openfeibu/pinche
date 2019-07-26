<?php

/**
 * @Description:拼车司机实体类
 * @Author: Danny
 * @Date:   2017-12-18 09:59:44
 * @Last Modified by:   zhangyh
 * @Last Modified time: 2018-01-20 21:30:27
 */

namespace app\carpool\model;


use app\core\base\BaseModel;

class CarpoolDriver extends BaseModel {

    protected $table = 'carpool_driver';

    public function setId($id) {
        return $this->setAttr("id",$id);
    }

    public function getId() {
        return $this->getAttr("id");
    }

    public function setName($name) {
        return $this->setAttr("name",$name);
    }

    public function getName() {
        return $this->getAttr("name");
    }


}