<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/11/10
 * Time: 下午2:31
 */

namespace app\carpool\model;


use app\core\base\BaseModel;

class CarpoolContent extends BaseModel {

    protected $table = 'carpool_content';

    public function setId($id) {
        return $this->setAttr("id",$id);
    }

    public function getId() {
        return $this->getAttr("id");
    }
    public function setFromPlace($from_place) {
        return $this->setAttr("from_place",$from_place);
    }

    public function getFromPlace() {
        return $this->getAttr("from_place");
    }
    public function setToPlace($to_place) {
        return $this->setAttr("to_place",$to_place);
    }

    public function getToPlace() {
        return $this->getAttr("to_place");
    }
    public function setUserId($user_id) {
        return $this->setAttr("user_id",$user_id);
    }

    public function getUserId() {
        return $this->getAttr("user_id");
    }
    public function setType($type) {
        return $this->setAttr("type",$type);
    }

    public function getType() {
        return $this->getAttr("type");
    }
    public function setStartTime($start_time) {
        return $this->setAttr("start_time",$start_time);
    }

    public function getStartTime() {
        return $this->getAttr("start_time");
    }
    public function setMidPlace($mid_place) {
        return $this->setAttr("mid_place",$mid_place);
    }

    public function getMidPlace() {
        return $this->getAttr("mid_place");
    }
    public function setCar($car) {
        return $this->setAttr("car",$car);
    }

    public function getCar() {
        return $this->getAttr("car");
    }
    public function setUserCount($user_count) {
        return $this->setAttr("user_count",$user_count);
    }

    public function getUserCount() {
        return $this->getAttr("user_count");
    }
    public function setNote($note) {
        return $this->setAttr("note",$note);
    }

    public function getNote() {
        return $this->getAttr("note");
    }
    public function setTopTime($top_time) {
        return $this->setAttr("top_time",$top_time);
    }

    public function getTopTime() {
        return $this->getAttr("top_time");
    }
    public function setPostdate($postdate) {
        return $this->setAttr("postdate",$postdate);
    }

    public function getPostdate() {
        return $this->getAttr("postdate");
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
    public function setStatus($status) {
        return $this->setAttr("status",$status);
    }

    public function getStatus() {
        return $this->getAttr("status");
    }

    public function setOrderId($order_id) {
        return $this->setAttr("order_id",$order_id);
    }

    public function getOrderId() {
        return $this->getAttr("order_id");
    }
}