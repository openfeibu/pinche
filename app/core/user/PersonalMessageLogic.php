<?php
/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/19
 * Time: 下午4:28
 */

namespace app\core\user;


/**
 * 私信接口
 * Interface PersonalMessageLogic
 * @package app\core\user
 */
interface PersonalMessageLogic {

    /**
     * 加载用户站内信分组列表
     *    [
     *       {
     *         uid:'(int)聊天用户id'
     *         head:'用户头像',
     *         name:'用户昵称',
     *         last_msg_content:'最后一条消息内容',
     *         last_msg_time:'格式化时间字符串',
     *         unread_msg_count:'(int)未读消息数量'
     *        }
     *    ]
     * @return mixed
     */
    public function listMessageGroup();

    /**
     * 加载聊天列表
     *  [
     *       {
     *         uid:'(int)聊天用户id'
     *         head:'用户头像',
     *         name:'用户昵称',
     *         content:'最后一条消息内容',
     *         time:'格式化时间字符串'
     *        }
     *    ]
     * @param $uid  int 聊天对象用户id
     * @param $page int 页码
     * @return mixed
     */
    public function listMessage($uid, $page);

    /**
     * 发送站内信
     * @param $uid   int 聊天对象用户id
     * @param $content string 站内信内容
     * @return mixed
     */
    public function sendMsg($uid, $content);



}