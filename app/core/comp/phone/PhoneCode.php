<?php
namespace app\core\comp\phone;
use app\core\base\BaseModel;

/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/10/27
 * Time: 下午12:57
 */
class PhoneCode extends BaseModel {

    protected $table = 'mag_phone_code';

    const type_bind_phone=1;
    const type_change_password=2;
    const type_register=3;
    const type_phone_login=4;


    public function setId($id) {
        return $this->setAttr("id",$id);
    }

    public function getId() {
        return $this->getAttr("id");
    }
    public function setPhone($phone) {
        return $this->setAttr("phone",$phone);
    }

    public function getPhone() {
        return $this->getAttr("phone");
    }
    public function setUserId($user_id) {
        return $this->setAttr("user_id",$user_id);
    }

    public function getUserId() {
        return $this->getAttr("user_id");
    }
    public function setCode($code) {
        return $this->setAttr("code",$code);
    }

    public function getCode() {
        return $this->getAttr("code");
    }
    public function setCreateTime($create_time) {
        return $this->setAttr("create_time",$create_time);
    }

    public function getCreateTime() {
        return $this->getAttr("create_time");
    }
    public function setStatus($status) {
        return $this->setAttr("status",$status);
    }

    public function getStatus() {
        return $this->getAttr("status");
    }

    public function setType($type) {
        return $this->setAttr("type",$type);
    }

    public function getType() {
        return $this->getAttr("type");
    }

}