<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/11/10
 * Time: 下午2:36
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

}