<?php

/**
 * @Description:后台管理
 * @Author: Danny
 * @Date:   2017-12-20 19:14:13
 * @Last Modified by:   Danny
 * @Last Modified time: 2018-01-10 10:40:37
 */

namespace app\carpool\controller;


use app\carpool\model\CarpoolContent;
use app\carpool\model\CarpoolUser;
use app\carpool\service\SiteConfigService;
use app\core\base\BaseController;
use app\core\comp\Result;
use app\core\XConfig;
use rap\Aop\EventHook;
use rap\Ioc;
use think\Db;
use think\Exception;
use think\Request;

class AdminController extends BaseController {

     /**
     * @var $SiteConfigService SiteConfigService
     */
    private $SiteConfigService;
    protected function _initialize() {
        parent::_initialize();
        $this->SiteConfigService=Ioc::get(SiteConfigService::class);
        $action=Request::instance()->action();
        if($action!="login"){
            if(!session("is_admin")){
                throw  new Exception("请先登录");
            }
        }
    }
    /**
     * 登录
     * POST
     * @param $account string 账号
     * @param $password string 密码
     * @return Result
     */
    public function login($account,$password) {
        $p_account= XConfig::get("carpool_admin_account");
        $p_password = XConfig::get("carpool_admin_password");
        if($account == $p_account && md5str($password) == $p_password) {
            session("is_admin", 1);
            return Result::success("登录成功");
        }
        return Result::error("账号或密码错误");
    }

    /**
     * 修改密码
     * POST
     * @param $old_password  string 原密码
     * @param $password  string 新密码
     * @return Result
     */
    public function changePassword($old_password,$password){
        if(XConfig::get("carpool_admin_password")!=md5str($old_password)){
            return Result::error("原密码错误");
        }
        XConfig::set("carpool_admin_password",md5str($password));
        XConfig::clearCache();
        return Result::success("更换密码成功");
    }

    /**
     * 设置单价
     * POST
     * @param $price  string 新单价
     * @return Result
     */
    public function changePrice($price){
        XConfig::set("config_price",$price);
        XConfig::clearCache();
        return Result::success("修改单价成功");
    }
    /**
     * 获取单价
     * POST
     * @param $price  string 单价
     * @return Result
     */
    public function selectPrice(){
        $a=XConfig::get("config_price");
        return Result::data($a);
    }

    /**
     * 配置项
     * POST
     * 格式[{key:value}]
     * 支持的key
     * carpool_post_cost 发布时需要支付金额
     * carpool_top_time_cost 置顶一小时需要支付金额
     * config_pay_wx_appid 微信appid
     * config_pay_wx_key 微信key
     * config_pay_wx_mch_id 商户id
     * @param $configs string  配置项 json字符串
     * @return Result
     */
    public function setConfig($configs) {
        $configs = json_decode($configs);
        $allow = $this -> getCanConfigKeys();
        foreach ($configs as $key => $value) {
            if(in_array($key, $allow)){
                XConfig::set($key, $value);
            }
        }
        XConfig::clearCache();
        return Result::success("配置成功");
    }

    /***
     * 获取配置项
     * carpool_post_cost 发布时需要支付金额
     * carpool_top_time_cost 置顶一小时需要支付金额
     * config_pay_wx_appid 微信appid
     * config_pay_wx_key 微信key
     * config_pay_wx_mch_id 商户id
     * @return Result
     */
    public function getConfig() {
        $allow = $this -> getCanConfigKeys();
        $rs = [];
        foreach ($allow as $k) {
            $rs[$k] = XConfig::get($k);
        }
        if(!$rs['config_ad_banner']) {
            $rs['config_ad_banner'] = '/public/uploads/img/default_banner.png';
        }
        if(!$rs['config_share_pic']) {
            $rs['config_share_pic'] = '/public/uploads/img/default_share_pic.png';
        }
        return Result::data($rs);
    }

    /**
     * 获取可配置项
     * @return array
     */
    public function getCanConfigKeys() {
        $allow = ["carpool_customer_post_cost","carpool_owners_post_cost","carpool_goods_post_cost",
            "carpool_top_time_cost","carpool_init_user_amount","carpool_expand_cost",
            "config_pay_wx_small_appid", "config_pay_wx_small_secret", "config_pay_wx_small_key",
            "config_pay_wx_small_mch_id",
            "config_pay_wx_js_appid", "config_pay_wx_js_secret", "config_pay_wx_js_key", "config_pay_wx_js_mch_id",
            "config_pay_wx_appid", "config_pay_wx_key", "config_pay_wx_mch_id",
            "config_pay_ali_pid",
            "config_notice_title", "config_notice_content", "config_ad_banner",
            "config_share_title", "config_share_des", "config_share_pic"
        ];
        return $allow;
    }

    /**
     * 加载用户列表
     * @param $p int 第几页
     * @param $step int 每页加载几个
     * @return Result
     */
    public function listUser($page = 1, $step = 10) {
        $pages = CarpoolUser::paginate($step, false, ['page' => $page]);
        return Result::data($pages);
    }

    /**
     * 加载拼车列表
     * @param int $page 第几页
     * @param int $step 每页加载几个
     * @return Result
     */
    public function listContent($page = 1, $step = 10, $type = 0, $phone) {
        $where['status'] = 1;
        if($type > 0) {
            $where['type'] = $type;
        }
        if($phone) {
            $where['phone'] = $phone;
        }
        $pages = CarpoolContent::where($where) -> order('top_time desc')
            -> paginate($step, false, ['page' => $page]);
        return Result::data($pages);
    }

     /**
      * 按天统计每天收入
     * @return Result
     */
    public function orderInfos($page = 1, $step = 10) {
        $pages = Db::table("carpool_order")
         -> field("sum(money) as money, FROM_UNIXTIME(create_time, '%Y-%m-%d') as time") -> where("status", 1)
         -> group("FROM_UNIXTIME(create_time, '%Y-%m-%d')")
         -> order('create_time desc')
         -> paginate($step, false, ['page' => $page]);
        return Result::data($pages);
    }

    /**
     * 获取订单总金额
     * @return Result
     */
    public function totalOrderMoney() {
        $rs = Db::table("carpool_order")
            -> field('ifnull(sum(money), 0) as money') -> where('status', 1) -> select();
        return Result::data($rs);
    }

    /**
     * 拼车信息删除
     * @param int $id 拼车信息ID
     * @return Result
     */
    public function delContent($id) {
        $is_admin = session('is_admin');
        if($is_admin == "1") {
            $carpoolContent = CarpoolContent::get(['id' => $id]);
            $carpoolContent -> setStatus(-1);
            $carpoolContent -> save();
            return Result::success();
        } else {
            return Result::error('非法操作');
        }
    }

    /**
     * 拼车信息置顶
     * @param int $id 拼车信息ID
     * @return Result
     */
    public function topContent($id) {
        $is_admin = session('is_admin');
        if($is_admin == "1") {
            $carpoolContent = CarpoolContent::get(['id' => $id]);
            $top_time = $carpoolContent -> getTopTime();
            if($top_time < time()) {
                $top_time = time();
            }
            $top_time += 3600;
            $carpoolContent -> setTopTime($top_time);
            $carpoolContent -> save();
            return Result::success(date('Y-m-d H:i:s', $top_time));
        } else {
            return Result::error('非法操作');
        }
    }

}
