<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/11/10
 * Time: 下午5:35
 */

namespace app\carpool\model;


use app\core\base\BaseModel;

class CarpoolOrder extends BaseModel {

    protected $table = 'carpool_order';

    protected $type = [
        'extra'      =>  'array',
    ];

    public function setId($id) {
        return $this->setAttr("id",$id);
    }

    public function getId() {
        return $this->getAttr("id");
    }
    public function setTitle($title) {
        return $this->setAttr("title",$title);
    }

    public function getTitle() {
        return $this->getAttr("title");
    }
    public function setMoney($money) {
        return $this->setAttr("money",$money);
    }

    public function getMoney() {
        return $this->getAttr("money");
    }
    public function setStatus($status) {
        return $this->setAttr("status",$status);
    }

    public function getStatus() {
        return $this->getAttr("status");
    }
    public function setUserId($user_id) {
        return $this->setAttr("user_id",$user_id);
    }

    public function getUserId() {
        return $this->getAttr("user_id");
    }
    public function setExtraa($extra) {
        return $this->setAttr("extra",$extra);
    }

    public function getExtraa() {
        return $this->getAttr("extra");
    }

    public function setCreateTime($create_time) {
        return $this->setAttr("create_time",$create_time);
    }

    public function getCreateTime() {
        return $this->getAttr("create_time");
    }


}