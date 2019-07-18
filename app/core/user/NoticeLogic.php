<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/19
 * Time: 下午4:29
 */

namespace app\core\user;

/**
 * 通知接口
 * Interface NoticeLogic
 * @package app\core\user
 */
interface NoticeLogic {

    /**
     * 发生系统通知
     * @param $uid int 用户id
     * @param $token string 用户token
     * @param $msg   string
     * @param $link
     * @return mixed
     */
    public function sendNotice($uid, $msg, $link);

    /**
     * 加载论坛的通知
     * @param $page
     * @return mixed
     */
    public function listNotice($page);


}