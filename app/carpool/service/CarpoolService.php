<?php

/**
 * @Description:拼车服务类
 * @Author: Danny
 * @Date:   2017-12-18 09:59:44
 * @Last Modified by:   Danny
 * @Last Modified time: 2018-01-14 12:05:40
 */
namespace app\carpool\service;

use app\carpool\model\CarpoolContent;

class CarpoolService {

    /**
     * 保存拼车信息
     * @param CarpoolContent $info
     * @return mixed
     */
    public function saveCarpool(CarpoolContent $info){
        $info->save();
        return $info->getId();
    }


    /**
     * 加载拼车信息列表
     * @param $where
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function listCarpool($where, $page, $listRows, $order){
        $datas = CarpoolContent::where($where)->order($order)->page($page,$listRows)->select();
        return $datas;
    }
    public function listCarpoolCount($where){
        $datas = CarpoolContent::where($where)->count();
        return $datas;
    }

}