<?php

/**
 * @Description:用户充值实体
 * @Author: Danny
 * @Date:   2017-12-22 10:59:50
 * @Last Modified by:   Danny
 * @Last Modified time: 2018-01-10 14:50:18
 */

namespace app\carpool\model;


use app\core\base\BaseModel;

class UserPay extends BaseModel {

    protected $table = 'user_pay';

    public function setId($id) {
        return $this->setAttr("id",$id);
    }

    public function getId() {
        return $this->getAttr("id");
    }
    public function setUserId($user_id) {
        return $this->setAttr("user_id",$user_id);
    }

    public function getUserId() {
        return $this->getAttr("user_id");
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

    public function setType($type) {
        return $this->setAttr("type",$type);
    }

    public function getType() {
        return $this->getAttr("type");
    }
    public function setStatus($status) {
        return $this->setAttr("status",$status);
    }

    public function getStatus() {
        return $this->getAttr("status");
    }
    public function setCreateTime($create_time) {
        return $this->setAttr("create_time",$create_time);
    }

    public function getCreateTime() {
        return $this->getAttr("create_time");
    }

}