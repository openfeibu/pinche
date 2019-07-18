<?php

namespace app\core\forum;

/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/19
 * Time: 下午6:05
 */
interface ThreadLogic {

    /**
     * 查看帖子
     *{
     * fid:"版块id",
     * column_name:"版块名称"
     * user_head:'用户头像',
     * tid:'帖子id',
     * user_name:'用户昵称',
     * user_sex:'(int)用户性别 1:男 2:女 3:未知',
     * publish_time:'(int)发布时间',
     * from:'来自 手机/网站',
     * can_manager:'是否可以管理',
     * manager_link:'管理链接',
     * content:'内容html',
     * content_base_url:'内容的base_url'
     * }
     * @return mixed
     */
    public function threadView($tid);

    /**
     * 评论列表
     *[
     *  {
     *  id:'评论id'
     *  user_head:'用户头像',
     *  user_name:'用户昵称',
     *  user_sex:'(int)用户性别 1:男 2:女 3:未知',
     *  content:'内容',
     *  is_publisher:'boolean 是否发布者',
     *  time:'(int)发布时间',
     *  floor:'(int)楼层',
     *  pics:['图片地址'],
     *  can_manager:'是否可以管理',
     *  manager_link:'管理链接',
     *  to_comment:{
     *         __:'被回复的评论',
     *         id:'评论id'
     *         user_head:'用户头像',
     *         user_name:'用户昵称',
     *         user_sex:'(int)用户性别 1:男 2:女 3:未知',
     *         content:'内容',
     *         is_publisher:'boolean 是否发布者',
     *         time:'(int)发布时间',
     *         floor:'(int)楼层',
     *         pics:['图片地址']
     *    }
     *  }
     * ]
     * @param $tid
     * @param $order
     * @param bool $only_publisher
     * @return mixed
     */
    public function commentList($tid,$order,$only_publisher=false);

    /**
     * 上传附件
     * 具体规则讨论
     * @param $file
     * @return mixed
     */
    public function attachmentUpload($file);

    /**
     * 发布帖子
     * @param $title   string 标题
     * @param $content string 内容
     * @param $pics   string  图片信息json字符串
     * @param $fid string 版块id
     * @param $type_id string 分类id
     * @param $classified_id string 分类信息id
     * @param $classified_info string 分类信息json字符串
     */
    public function threadAdd($title, $content, $pics ,$fid , $type_id, $classified_id, $classified_info);

    /**
     * 添加时版块的基本信息
     * 包含 名称 今日数 主题数 子版块数量
     * 版块详情 包含子版块 版主 描述
     *{
     * fid:'版块id',
     * name:'版块名称',
     * type_require:'(boolean) 分类必须',
     * types:[{
     *       __:'分类列表',
     *      name:'名称',
     *      id:'id'
     * }],
     * classified_require:'(boolean) 分类必须',
     * classifieds:[{
     *        __:'分类信息列表',
     *        name:"名称",
     *        id:'分类信息id'
     *   }
     * ]
     *}
     * @param $fid string 版块id
     * @param $sortid int 分类id
     * @return mixed
     */
    public function threadAddColumnInfo($fid,$sotid);

    /**
     * 发布回复
     * @param $tid   int 帖子id
     * @param $reply_id   int 被回复的回复id
     * @param $content string 回复内容
     * @param $pics   string  回复图片信息json字符串
     * @return mixed
     */
    public function replyAdd($tid, $reply_id, $content, $pics);


}