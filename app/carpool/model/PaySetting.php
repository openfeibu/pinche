<?php

/**
 * @Description:充值配置实体
 * @Author: Danny
 * @Date:   2017-12-22 10:59:50
 * @Last Modified by:   Danny
 * @Last Modified time: 2018-01-14 15:01:20
 */

namespace app\carpool\model;


use app\core\base\BaseModel;

class PaySetting extends BaseModel {

    protected $table = 'pay_setting';

    public function setId($id) {
        return $this->setAttr("id",$id);
    }

    public function getId() {
        return $this->getAttr("id");
    }

    public function setAmount($amount) {
        return $this->setAttr("amount",$amount);
    }

    public function getAmount() {
        return $this->getAttr("amount");
    }

    public function setGiveAmount($give_amount) {
        return $this->setAttr("give_amount",$give_amount);
    }

    public function getGiveAmount() {
        return $this->getAttr("give_amount");
    }

    public function setSort($sort) {
        return $this->setAttr("sort",$sort);
    }

    public function getSort() {
        return $this->getAttr("sort");
    }
    public function setCreateTime($create_time) {
        return $this->setAttr("create_time",$create_time);
    }

    public function getCreateTime() {
        return $this->getAttr("create_time");
    }

}