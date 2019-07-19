<?php

/**
 * @Description:Banner图实体类
 * @Author: Danny
 * @Date:   2017-12-18 09:59:44
 * @Last Modified by:   zhangyh
 * @Last Modified time: 2018-01-20 12:47:43
 */
namespace app\carpool\model;


use app\core\base\BaseModel;

class CarpoolBanner extends BaseModel {

    protected $table = 'carpool_banner';

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
    public function setUrl($url) {
        return $this->setAttr("url",$url);
    }

    public function getUrl() {
        return $this->getAttr("url");
    }
    public function setLink($link) {
        return $this->setAttr("link",$link);
    }

    public function getLink() {
        return $this->getAttr("link");
    }
    public function setSort($sort) {
        return $this->setAttr("sort",$sort);
    }

    public function getSort() {
        return $this->getAttr("sort");
    }
    public function setStatus($status) {
        return $this->setAttr("status",$status);
    }

    public function getStatus() {
        return $this->getAttr("status");
    }
    public function setLocation($location) {
        return $this->setAttr("location",$location);
    }

    public function getLocation() {
        return $this->getAttr("location");
    }
}