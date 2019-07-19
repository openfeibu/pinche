<?php

/**
 * @Description:用户充值
 * @Author: Danny
 * @Date:   2017-12-22 15:37:33
 * @Last Modified by:   zhangyh
 * @Last Modified time: 2018-01-20 15:53:42
 */

namespace app\carpool\controller;

use app\carpool\model\PaySetting;
use app\carpool\model\UserPay;
use app\core\base\BaseController;
use app\core\comp\UserHolder;
use app\core\comp\Result;
use rap\Aop\EventHook;
use rap\Ioc;
use think\Db;
use app\carpool\service\UserService;
use app\carpool\service\UserPayService;

class PayController extends BaseController {

    private $userPayService;

    private $userService;

    protected function _initialize() {
        parent::_initialize();
        $this->userPayService=Ioc::get(UserPayService::class);
        $this->userService=Ioc::get(UserService::class);
    }

    /***
     * 创建充值记录
     * @param $paySource int 支付来源 //1:小程序、2：微信APP、3：微信JS支付、4、支付宝APP、5、支付宝手机网站
     * @param $amount  充值
     * @return Result
     */
    public function create($paySource,$amount) {
        $user_id = UserHolder::getUserId();
        if(empty($user_id)) {
            Result::error('请先登录');
        }
        // 创建充值记录
        $pay_params = $this -> userPayService -> createUserPay($paySource,$user_id,$amount);
        if($pay_params['pay_id']>0)
        {
            return Result::success("充值成功") -> put('pay_params', $pay_params);;
        }
        else
        {
            return Result::error('10001', '参数错误');
        }
    }
     /***
     * 按时间段查询充值列表
     * @param $stime  开始时间
     * @param $etime  结束时间
     * @param $page  页码
     * @param $step  页大小
     * @return Result
     */
    public function listPay($stime,$etime,$page = 1, $step = 10) {
        $where=[];
        if($stime)
        {
            $where["create_time"]=[">=",strtotime($stime)];
        }
        if($etime)
        {
            $where["create_time"]=["<=",strtotime($etime)];
        }
        $pages = UserPay::where($where) -> order('create_time desc')
            -> paginate($step, false, ['page' => $page]);
        return Result::data($pages);
    }
    /***
     * 我的充值列表
     * @param $page  页码
     * @param $step  页大小
     * @return Result
     */
    public function myPayList($page = 1, $step = 10)
    {
        $user_id = UserHolder::getUserId();
        if(empty($user_id)) {
            Result::error('请先登录');
        }
        $where["user_id"]=$user_id;
        $pages = UserPay::where($where) 
            -> field("amount,give_amount,type,status, FROM_UNIXTIME(create_time, '%Y-%m-%d') as create_time") 
            -> order('create_time desc')
            -> paginate($step, false, ['page' => $page]);
        return Result::data($pages);
    }
    /**
     * 获取充值配置列表
     * @return Result
     */
    public function getPaySetting() {
        $datas = PaySetting::field("floor(amount) as amount,floor(give_amount) as give_amount") -> order('sort asc')
    
         -> select();
        return Result::data($datas);
    }
    /**
     * 按天统计用户充值收入
     * @return Result
     */
    public function getAllCashPay($page = 1, $step = 10) {
        $where["status"]=1;
        $where["type"]=1;
        $pages = Db::table("user_pay")
         -> field("sum(amount) as money, FROM_UNIXTIME(create_time, '%Y-%m-%d') as time") 
         -> where($where)
         -> group("FROM_UNIXTIME(create_time, '%Y-%m-%d')")
         -> order('create_time desc')
         -> paginate($step, false, ['page' => $page]);
        return Result::data($pages);
    }
     /**
     * 获取用户充值总金额
     * @return Result
     */
    public function totalCashMoney() {
        $rs = Db::table("user_pay")
            -> field('ifnull(sum(amount), 0) as money') 
            -> where("status=1 and type=1")
            -> select();
        return Result::data($rs);
    }

}