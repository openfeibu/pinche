<?php

/**
 * @Description:拼车用户实体类
 * @Author: Danny
 * @Date:   2017-12-18 09:59:44
 * @Last Modified by:   zhangyh
 * @Last Modified time: 2018-01-20 21:30:27
 */

namespace app\carpool\model;


use app\core\base\BaseModel;

class CarpoolUser extends BaseModel {

    protected $table = 'carpool_user';

    public function setId($id) {
        return $this->setAttr("id",$id);
    }

    public function getId() {
        return $this->getAttr("id");
    }
    public function setWxOpenId($wx_open_id) {
        return $this->setAttr("wx_open_id",$wx_open_id);
    }

    public function getWxOpenId() {
        return $this->getAttr("wx_open_id");
    }
    public function setName($name) {
        return $this->setAttr("name",$name);
    }

    public function getName() {
        return $this->getAttr("name");
    }

    public function setSessionKey($session_key) {
        return $this->setAttr("session_key",$session_key);
    }

    public function getSessionKey() {
        return $this->getAttr("session_key");
    }

    public function setPhone($phone) {
        return $this->setAttr("phone",$phone);
    }

    public function getPhone() {
        return $this->getAttr("phone");
    }
    public function setSex($sex) {
        return $this->setAttr("sex",$sex);
    }

    public function getSex() {
        return $this->getAttr("sex");
    }
    public function setHead($head) {
        return $this->setAttr("head",$head);
    }

    public function getHead() {
        return $this->getAttr("head");
    }

    public function setMagOpenId($mag_open_id) {
        return $this -> setAttr('mag_open_id', $mag_open_id);
    }

    public function getMagOpenId() {
        return $this -> getAttr('mag_open_id');
    }
    public function setTjzOpenId($tjz_open_id) {
        return $this -> setAttr('tjz_open_id', $tjz_open_id);
    }

    public function getTjzOpenId() {
        return $this -> getAttr('tjz_open_id');
    }
    public function setAmount($amount) {
        return $this->setAttr("amount",$amount);
    }

    public function getAmount() {
        return $this->getAttr("amount");
    }
     public function setWxacode($wxacode) {
        return $this->setAttr("wxacode",$wxacode);
    }

    public function getWxacode() {
        return $this->getAttr("wxacode");
    }

}