<?php

/**
 * @Description:拼车管理
 * @Author: Danny
 * @Date:   2017-12-20 19:14:13
 * @Last Modified by:   Danny
 * @Last Modified time: 2018-01-29 16:24:40
 */

namespace app\carpool\controller;
use app\carpool\model\CarpoolContent;
use app\carpool\model\CarpoolUser;
use app\carpool\model\UserPay;
use app\carpool\service\CarpoolService;
use app\carpool\service\OrderService;
use app\carpool\service\WeixinService;
use app\carpool\service\SiteConfigService;
use app\carpool\service\UserService;
use app\core\base\BaseController;
use app\core\comp\Result;
use app\core\comp\UserHolder;
use app\core\XConfig;
use rap\Aop\EventHook;
use rap\Ioc;
use think\Exception;
use think\Paginator;

class CarpoolController extends BaseController {

    /**
     * @var $carpoolService CarpoolService
     */
    private $carpoolService;
    /**
     * @var $orderService OrderService
     */
    private $orderService;
    /**
     * @var $wxService WeixinService
     */
    private $wxService;
    /**
     * @var $siteConfigService SiteConfigService
     */
    private $siteConfigService;
    /**
     * @var $userService UserService
     */
    private $userService;

    protected function _initialize() {
        parent::_initialize();
        $this->carpoolService=Ioc::get(CarpoolService::class);
        $this->wxService=Ioc::get(WeixinService::class);
        $this->orderService=Ioc::get(OrderService::class);
        $this->siteConfigService=Ioc::get(SiteConfigService::class);
        $this->userService=Ioc::get(UserService::class);
    }
    public function getUserByCode($code)
    {
        $openid = $this->wxService->wxLogin($code);
        $user= CarpoolUser::get(['wx_open_id'=>$openid]);
        if($user)
        {
            $token = md5str(time() .$openid.$user['name'].$user['head'].$code);
            return Result::data(["token"=>$token,'user' => $user])-> put('open_id', $openid);
        }else{
            return Result::data(["token" => NULL,'user' => NULL]);
        }
    }
    /**
     * 微信用户登录
     * POST
     * @param $code   string 微信返回的code
     * @param $nickname  string 用户昵称
     * @param $head     string  用户头像
     * @param $sex      int  性别 1:男 2:女 0:未知
     * @return Result
     */
    public function wxLogin($code,$nickname,$head,$sex){
        $openid = $this->wxService->wxLogin($code);
        $token = md5str(time() .$openid.$nickname.$head.$code);
        $user= CarpoolUser::get(['wx_open_id'=>$openid]);
        $isFirstLogin=false;
        if(!$user){
            $user=new CarpoolUser();
            //初始化用户余额
            $user -> setAmount(XConfig::get('carpool_init_user_amount'));
            $isFirstLogin=true;
        }
        $user->setWxOpenId($openid);
        $user->setHead($head);
        $user->setSex($sex);
        $user->setName($nickname);
        $user->save();
        if($isFirstLogin)
        {
            //添加充值记录
            $userPay = new UserPay();
            $userPay->setUserId($user -> getId());
            $userPay->setAmount($user -> getAmount());
            $userPay->setGiveAmount(0);
            //充值类型：1-现金；2-推广；3-赠送(初始化);
            $userPay->setType(3);
            //支付状态:0-待支付；1-支付成功；2-支付失败；
            $userPay->setStatus(1);
            $userPay->setCreateTime(time());
            $userPay->save();
        }
        cache("token_".$token,$user->getId());
        cookie(md5str("usertoken"),$user->getId());
        session("userid",$user->getId());
        return Result::data(["token"=>$token])-> put('open_id', $openid);
    }

    /**
     * 加载用户拼车联系人
     * GET
     * @return Result
     */
    public function getUserInfo() {
        $last = CarpoolContent::where(["user_id" => UserHolder::getUserId()]) -> order("postdate", "desc") -> find();
        $data = [];
        if($last) {
            $data = array_pick($last, ["name", "phone", "sex", "car"]);
        } else {
            $user = CarpoolUser::get(['id' => UserHolder::getUserId()]);
            if($user) {
                $data = array_pick($user,["name", "phone", "sex", "car"]);
            }
        }
        // $post_cost = XConfig::get('carpool_post_cost');
        // if(!$post_cost) {
        //     $post_cost = 0;
        // }
        $post_cost = 0;
        return Result::data($data) -> put('post_cost', $post_cost);
    }

    /**
     * 发布拼车信息
     * POST
     * 包括  人找车,车找人 发布前需要使用接口 createPostOrder 检查是否需要进行支付
     * @param $name     string  联系人姓名
     * @param $phone    string  手机号
     * @param $sex       int  性别 1:男 2:女 0:未知
     * @param $from_place  string   出发地
     * @param $to_place    string   目的地
     * @param $start_time  string   出发时间(格式:2012-11-08 11:32)
     * @param $mid_place   string   途径
     * @param $car         string   车型
     * @param $weight      string   货物重量
     * @param $user_count  string   空位数/乘客数
     * @param $note        string   备注
     * @param $type    int   类型 1:人找车 2:车找人 3:货找车 4:车找货
     * @param $paySource int 支付类型 1:小程序、2：微信APP、3：微信JS支付、4、支付宝APP、5、支付宝手机网站
     * @return Result
     * @throws Exception
     */
    public function createCarpoolNew($name, $phone, $sex, $from_place, $to_place, $start_time, $mid_place,
                                  $car,$weight, $user_count, $note,$top,$top_len,$type,
                                  $from_place_latitude,$from_place_longitude,$to_place_latitude,$to_place_longitude,
                                    $polyline,$distance,$price,$count,
                                     $paySource = 1) {
        $user_id = UserHolder::getUserId();
        if($user_id == 0) {
            Result::error('请先登录');
        }
        $data = $this -> getArgs(__FUNCTION__, func_get_args());
        emptysThrow($name, "联系人姓名不可为空", $phone, "联系方式不可为空", $from_place, "出发地不可为空",
            $to_place,"目的地不可为空","start_time","出发时间不可为空",$user_count,($type==1?"乘车人数":"空位数")."不可空");
        $info = new CarpoolContent();
        if($type==3 || $type==4)
        {
            emptysThrow($weight, "货物重量不可为空");
            $info -> setWeight($weight);
        }
        $info -> setUserId($user_id);
        $info -> fromArray($data);
        $info -> setStartTime(strtotime($start_time));
        //新加定位信息
        $info -> setFromPlaceLatitude($from_place_latitude);
        $info -> setFromPlaceLongitude($from_place_longitude);
        $info -> setToPlaceLatitude($to_place_latitude);
        $info -> setToPlaceLongitude($to_place_longitude);
        $info -> setPolyline($polyline);
        $info -> setDistance($distance);
        $info -> setPrice($price);
        $info -> setCount($count);

        $time = time();
        $info -> setPostdate($time);
        $info -> setStatus(1);
       $top_time = $time;
        if($top==1)
        {    $top_time =$time;
            $top_time += 3600*$top_len;
        }

        $info -> setTop($top);
        $info -> setTopTime($top_time);
      
     
        $post_cost = $this -> siteConfigService->getCarpoolPostCost($type);
        $top_cost = XConfig::get("carpool_top_time_cost");
        $cost= 0;
        if($post_cost && $post_cost > 0)
        {
            $cost+=$post_cost;
        }
        if($top==1)
        {
            if($top_cost && $top_cost > 0)
            {
                $cost+=$top_cost*$top_len;
            }
        }
        $needPay = false;
        if($cost > 0) {
            $needPay = true;
        }
        $pay_params = [];
        $user_amount = 0;
        if($needPay) {
            //检查用户账户余额是否够支付
            $amount =$this -> userService -> getUserAmount($user_id);
            $user_amount = $amount - $cost;
            if($user_amount <0)
            {
                return Result::error("您的账户余额不足，请您立即充值");
            }
            // 创建订单
            $order_id = $this -> orderService -> addOrder('发布拼车信息', $cost, null);
            $info -> setOrderId($order_id);
        }
        
        $this -> carpoolService -> saveCarpool($info);
        //更新账户余额
        $this->userService->updateUserAmount($user_id,$user_amount);
        return Result::success("发布拼车信息成功");
    }
  
  

  
    /**
     * 创建置顶订单
     *
     * @param $id  int 拼车信息id
     * @param $hour int 置顶小时
     * @return Result
     */
    public function createTopOrder($id, $hour) {
        $user_id = UserHolder::getUserId();
        if($user_id == 0) {
            Result::error('请先登录');
        }
        $carpoolContent = CarpoolContent::get(['id' => $id]);
                 $top_time = $carpoolContent -> getTopTime();
            if($top_time < time()) {
                $top_time = time();
            }
            $top_time += 3600 * $hour;
            $carpoolContent -> setTopTime($top_time);
            $carpoolContent -> save();
        if($carpoolContent) {
            $topCost = XConfig::get("carpool_top_time_cost");
            $cost= $topCost * $hour;
             //检查用户账户余额是否够支付
            $amount =$this -> userService -> getUserAmount($user_id);
            $user_amount = $amount - $cost;
            if($user_amount <0)
            {
                return Result::error("您的账户余额不足，请您立即充值");
            }
            // 创建订单
            $order_id = $this -> orderService -> addOrder('信息置顶', $cost, null);
            //更新账户余额
            $this->userService->updateUserAmount($user_id,$user_amount);

            return Result::success("信息置顶成功");
        }
    }

    /**
     * 编辑拼车信息
     * POST
     * 包括  人找车,车找人 编辑拼车信息不需要支付
     * @param $id     int  内容id
     * @param $name     string  联系人姓名
     * @param $phone    string  手机号
     * @param $sex       int  性别 1:男 2:女 0:未知
     * @param $from_place  string   出发地
     * @param $to_place    string   目的地
     * @param $start_time  string   出发时间(格式:2012-11-08 11:32)
     * @param $mid_place   string   途径
     * @param $car         string   车型
     * @param $weight      string   货物重量
     * @param $user_count  string   空位数/乘客数
     * @param $note        string   备注
     * @return Result
     * @throws Exception
     */
    public function editCarpool($id, $name, $phone, $sex, $from_place, $to_place, $start_time, $mid_place,
                                $car,$weight, $user_count, $note) {
        $data = $this -> getArgs(__FUNCTION__, func_get_args());
        emptysThrow($id, "编辑的数据不存在", $name, "联系人姓名不可为空", $phone, "联系方式不可为空", $from_place, "出发地不可为空",
            $to_place, "目的地不可为空", "start_time", "出发时间不可为空");
        $carpoolContent = CarpoolContent::get(['id' => $id]);
        if($carpoolContent) {
            $info = new CarpoolContent();
            $info -> fromArray($data);
            $info -> setStartTime(strtotime($start_time));
            $info -> setStatus($carpoolContent -> getStatus());
            $info -> setPostdate($carpoolContent -> getPostdate());
            $type = $carpoolContent -> getType();
            if($type==3 || $type==4)
            {
                emptysThrow($weight, "货物重量不可为空");
            }
            $info -> setWeight($weight);
            $this -> carpoolService -> saveCarpool($info);
            return Result::success("保存拼车信息成功");
        } else {
            return Result::error('参数错误');
        }
    }


    /**
     * 拼车信息列表
     * @param $type    int   类型 1:人找车 2:车找人 3:货找车 4:车找货
     * @param $from_place  string   出发地
     * @param $to_place    string   目的地
     * @param $mid_place   string    途径
     * @param $start_time   string   出发时间(格式:2012-11-08 11:32)
     * @param $user_count    string   空位数/乘客数
     * @param $page  int  页数
     * @return Result
     */
    public function listCarpool($type, $from_place, $to_place, $mid_place, $start_time, $user_count,$car, $page=1){
        $where = [];
        if($type) {
            $where["type"] = $type;
        }
        if($from_place) {
            $where["from_place"] = ["like", "%" . $from_place . "%"];
        }
        if($to_place) {
            $where["to_place"] = ["like", "%" . $to_place . "%"];
        }
        if($mid_place) {
            $where["mid_place"] = ["like", "%" . $mid_place . "%"];
        }
        if($start_time) {
            $where["start_time"] = [">=", strtotime($start_time)];
        }
        if($user_count) {
            $where["user_count"] = [">=", $user_count];
        }
        if($car) {
            $where["car"] = $car;
        }
        $where['status'] = 1;
        $where['start_time'] = ['gt', time()];
        $tops = [];
        if($page == 1) {
            $where['top_time'] = ['gt', time()];
            $order = 'top_time desc';
            $tops = $this -> carpoolService -> listCarpool($where, $page, 100, $order);
        }
        unset($where['top_time']);
        $where['top_time'] = ['lt', time()];
        $order = 'start_time asc';
        $datas = $this -> carpoolService -> listCarpool($where, $page, 10, $order);
        foreach ($datas as $item) {
            $tops[] = $item;
        }
        return Result::data($tops);
    }

    /**
     * 我的拼车
     * @param $page int 页数
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function myCarpool($page=1) {
        $where=[];
        $where["user_id"] = UserHolder::getUserId();
        $where['status'] = 1;
        $order = 'start_time asc';
        $datas = $this -> carpoolService -> listCarpool($where, $page, 10, $order);
        return Result::data($datas);
    }
    /**
     * 设置满座
     * @param $id int 信息ID
     * @return false|true
    */
    public function setFullSeat($id) 
    {
        $carpoolContent = CarpoolContent::get(['id' => $id]);
         if($carpoolContent) {
            $carpoolContent -> setStartTime(0);
            $this -> carpoolService -> saveCarpool($carpoolContent);
            return Result::success("设置满座成功");
        } else {
            return Result::error('参数错误');
        }
    }
     /**
     * 我的拼车 发布信息数量
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function myCarpoolCount() {
        $where=[];
        $where["user_id"] = UserHolder::getUserId();
        $where['status'] = 1;
        $datas = $this -> carpoolService -> listCarpoolCount($where);
        return Result::data($datas);
    }


    /***
     * 获取每小时置顶金额
     * @return Result
     */
    public function getTopDayCost() {
        $cost = XConfig::get('carpool_top_time_cost');
        return Result::data($cost);
    }
   /***
     * 获取车主发布金额
     * @return Result
     */
    public function getownersPostCost() {
        $cost1 = XConfig::get('carpool_owners_post_cost');
        return Result::data($cost1);
    }
   /***
     * 获取乘客发布金额
     * @return Result
     */
    public function getcustomerPostCost() {
        $cost2 = XConfig::get('carpool_customer_post_cost');
        return Result::data($cost2);
    }
     
   /***
     * 获取货物发布金额
     * @return Result
     */
    public function getgoodsPostCost() {
        $cost3 = XConfig::get('carpool_goods_post_cost');
        return Result::data($cost3);
    }
    /***
     * 获取当时单价
     * @return Result
     */
    public function getPrice() {
        $price=XConfig::get('config_price');
        return Result::data($price);
    }

    /***
     * 获取发布内容
     * @param int $id 发布内容ID
     * @return Result
     */
    public function getCarpool($id) {
        if(!empty($id)) {
            $carpoolContent = CarpoolContent::get(['id' => $id]);
            if($carpoolContent) {
                $carpoolContent -> putExtra('startTimeDateStr', date('Y-m-d', $carpoolContent -> getStartTime()));
                $carpoolContent -> putExtra('startTimeTimeStr', date('H:i:s', $carpoolContent -> getStartTime()));

            }
            return Result::data($carpoolContent);
        } else {
            return Result::error('10001', '参数错误');
        }
    }

    /**
     * 删除发布内容
     * @param int $id 发布内容ID
     * @return Result
     */
    public function delCarpool($id) {
        $userid = UserHolder::getUserId();
        $carpool = CarpoolContent::get(['user_id' => $userid, 'id' => $id]);
        if($carpool) {
            $carpool -> setStatus(-1);
            $carpool -> save();
        }
        return Result::success('删除成功');
    }

    /**
     * 获取广告图片路径
     * @return Result
     */
    public function getBannerPathAndNotice() {
        $path = XConfig::get('config_ad_banner', '/public/uploads/img/default_banner.png');
        $notice_title = XConfig::get('config_notice_title');
        $rs['path'] = $path;
        $rs['notice_title'] = $notice_title;
        return Result::data($rs);
    }

    /**
     * 通知内容
     * @return Result
     */
    public function getNoticeContent() {
        $content = XConfig::get('config_notice_content');
        return Result::data($content);
    }

    /**
     * 获取分销标题和图片
     * @return Result
     */
    public function getShareInfo() {
        $share_title = XConfig::get('config_share_title', '马甲拼车，既省钱又划算!');
        $share_desc = XConfig::get('config_share_des', '马甲拼车，方便生活交通');
        $share_pic = XConfig::get('config_share_pic', '/public/uploads/img/default_share_pic.png');
        $share_pic = 'http://' . $_SERVER['HTTP_HOST'] . $share_pic;
        $rs['share_title'] = $share_title;
        $rs['share_desc'] = $share_desc;
        $rs['share_pic'] = $share_pic;
        return Result::data($rs);
    }
    /**
     * 获取发布信息金额
     * @param int $type 类型 1:人找车 2:车找人 3:货找车 4:车找货
     * @return Result
     */
    public function getPostCost($type) {
       $post_cost = $this -> siteConfigService -> getCarpoolPostCost($type);
       return Result::data($post_cost);
    }
    
}