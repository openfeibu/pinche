<?php

/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/11/10
 * Time: 下午5:36
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
        foreach ($datas as $data) {
            $data['istop'] = false;
            if($data['top_time'] > $data['postdate'] && $data['top_time'] > time()) {
                $data['istop'] = true;
            }
        }
        return $datas;
    }

}