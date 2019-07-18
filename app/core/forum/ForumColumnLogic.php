<?php

/**
 * 承德博智网络科技有限公司
 * User: service@cdbozhi.com
 * Date: 16/10/19
 * Time: 下午4:40
 */
namespace app\core\forum;

interface ForumColumnLogic {


    /**
     * 所有版块树形
     *[{
     * fid:'版块id',
     * type:'1:版块 2:容器'
     * name:'版块名称',
     * icon:'版块图标',
     * des:'版块描述',
     * children:[
     *      {}
     *    ]
     * }]
     *
     * @return mixed
     */
    public function forumTree();

    /**
     * 返回子版块
     *[{
     * fid:'版块id',
     * type:'1:版块 2:容器'
     * name:'版块名称',
     * icon:'版块图标',
     * des:'版块描述'
     * }]
     * @param $fid string 版块id
     * @return mixed
     */
    public function forumChild($fid);

    /**
     * 版块的基本信息
     * 包含 名称 今日数 主题数 子版块数量
     * 版块详情 包含子版块 版主 描述
     *{
     * fid:'版块id',
     * type:'1:版块'
     * name:'版块名称',
     * icon:'版块图标',
     * des:'版块描述',
     * post_today:'(int)今日帖子数',
     * thread:'(int)主题数',
     * post:'(int)帖子数',
     * last_reply:'最后回复',
     * types:[{
     *     __:'分类列表',
     *     name:'名称',
     *     value:'分类值'
     * }],
     * orders:[
     *      {
     *       __:'排序列表',
     *      name:'名称',
     *      value:'排序值'
     * }
     * ],
     * moderators:[{
     *           __:'版主列表',
     *           name:'版主名称',
     *           uid:'版主id'
     * }],
     * children:"(数组)子版块数组"
     * }
     * @param $fid string 版块id
     * @return mixed
     */
    public function forumInfo($fid);


    /**
     * 返回分类信息的筛选条件
     * 具体规则待确定
     * @param $fid string 版块id
     * @param $sortid 分类id
     * @return mixed
     */
    public function forumClassified($fid, $picked);

    /**
     * 帖子列表
     * [{
     *   uid:用户id,
     *   name:'用户昵称',
     *   head:'用户头像',
     *   title:'标题',
     *   des:'描述',
     *   view_count: '(int)查看数',
     *   reply_count: '(int)回复数',
     *   publish_time:'(int) 发布时间',
     *   last_reply_time:'(int) 最后回复时间',
     *   tags:["标签图片地址"],
     *   pics:["图片地址"],
     *   is_top:'(boolean)是否置顶'
     * }]
     * @param $fid string 版块id
     * @param $order  string 排序
     * @param $digest  boolean 是否只显示精华
     * @param $type string 分类
     * @param $page  int 页码
     * @param $classified_infos string  分类信息选中值
     * @return mixed
     */
    public function threadList($fid, $order, $digest = false, $type = '',$sortid  , $page, $classified_infos);


}