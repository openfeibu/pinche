<?php

/**
 * @Description:Banner图管理
 * @Author: Danny
 * @Date:   2017-12-18 09:59:44
 * @Last Modified by:   zhangyh
 * @Last Modified time: 2018-01-20 14:45:40
 */

namespace app\carpool\controller;

use app\carpool\model\CarpoolBanner;
use app\core\base\BaseController;
use app\core\comp\Result;

class BannerController extends BaseController {

    /***
     * 创建
     * @return Result
     */
    public function create($title,$url,$link,$sort,$status,$location) {
        emptysThrow($title, "标题不可为空", $url, "图片地址不可为空", $sort, "顺序号不可为空");
        $data = $this -> getArgs(__FUNCTION__, func_get_args());
        $info = new CarpoolBanner();
        $info -> fromArray($data);
        $info -> save();
        $id = $info->getId();
        if($id)
        {
            return Result::success("添加成功");
        }
        else
        {
            return Result::error("添加失败");
        }
    }
      /***
     * 修改
     * @return Result
     */
    public function update($id,$title,$url,$link,$sort,$status,$location) {

        emptysThrow($id, "编辑的数据不存在",$title, "标题不可为空", $url, "图片地址不可为空", $sort, "顺序号不可为空");
        $data = $this -> getArgs(__FUNCTION__, func_get_args());
        $info = new CarpoolBanner();
        $info -> fromArray($data);
        $info -> save();
        $id = $info->getId();
        if($id)
        {
            return Result::success("修改成功");
        }
        else
        {
            return Result::error("修改失败");
        }
    }
      /***
     * 获取单条数据
     * @return Result
     */
    public function read($id) {
        $carpoolBanner = CarpoolBanner::get(['id' => $id]);
        if($carpoolBanner)
        {
            return Result::data($carpoolBanner);
        }
        else
        {
            return Result::error("获取数据失败");
        }
    }
      /***
     * 删除
     * @return Result
     */
    public function delete($id) {
        $result = CarpoolBanner::destroy(['id' => $id]);
        if($result)
        {
            return Result::success("删除成功");
        }
        else
        {
            return Result::error("删除失败");
        }
    }
     /***
     * 获取所有列表
     * @return Result
     */
    public function listBanner($page = 1, $step = 10) {
        $pages = CarpoolBanner::find() -> order('sort asc')
            -> paginate($step, false, ['page' => $page]);
        return Result::data($pages);
    }
      /***
     * 获取有效的列表
     * @return Result
     */
    public function getBannerByLocation($location,$page = 1, $step = 10) {
        $where=[];
        $where["status"]=["=",1];
        $where["location"]=["=",$location];
        $pages = CarpoolBanner::where($where) -> order('sort asc')
            -> paginate($step, false, ['page' => $page]);
        return Result::data($pages);
    }
}