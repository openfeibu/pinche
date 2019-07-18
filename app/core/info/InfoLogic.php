<?php
/**
 * 承德博智网络科技有限公司
 * User: wangxiao
 * Date: 2016/11/9
 * Time: 13:01
 */

namespace app\core\info;

interface InfoLogic {


    /**
     * 所有栏目树形
     *[{
     * catid:'栏目id',
     * catname:'名称',
     * articles:'文章数量',
     * description:'版块描述',
     * children:[
     *      {}
     *    ]
     * }]
     *
     * @return mixed
     */
    public function catTree();


    /**
     * 返回子版块
     *[{
     * catid:'栏目id',
     * catname:'名称',
     * articles:'文章数量',
     * description:'版块描述',
     * }]
     * @param $catid int 版块id
     * @return mixed
     */
    public function catChild($fid);


    /**
     * 版块的基本信息
     * 包含 名称 今日数 主题数 子版块数量
     * 版块详情 包含子版块 版主 描述
     *{
     * catid:'栏目id',
     * catname:'名称',
     * articles:'文章数量',
     * description:'版块描述',
     * children:"(数组)子版块数组"
     * }
     * @param $catid string 版块id
     * @return mixed
     */
    public function catInfo($id);


    /**
     * 文章列表
     * [{
     *   aid:文章id,
     *   title:'文章标题',
     *   author:'作者',
     *   summary:'描述',
     *   pic:'封面',
     *   dateline:'发布时间',
     *   tags:["标签图片地址"],
     *   pics:["图片地址"],
     * }]
     * @param $catid int 版块id
     * @param $page  int 页码
     * @return mixed
     */
    public function articleList($catid,$page);


    /**
     * 查看文章详情
     *{
     * aid:"文章id",
     * title:"标题"
     * username:'作者',
     * summary:'描述',
     * pic:'封面',
     * dateline:'发布时间',
     * timestamp:'发布时间',
     * content:'内容html',
     * content_base_url:'内容的base_url'
     * }
     * @return mixed
     */
    public function articleView($aid);


}