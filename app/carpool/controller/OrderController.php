<?php
/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/11/10
 * Time: 下午7:44
 */

namespace app\carpool\controller;

use app\carpool\model\CarpoolOrder;
use app\carpool\service\OrderService;
use app\carpool\service\WeixinService;
use app\core\base\BaseController;
use rap\Ioc;

class OrderController extends BaseController {

    /**
     * @var $weixinService WeixinService
     */
    private $weixinService;
    protected function _initialize() {
        parent::_initialize();
        $this->weixinService=Ioc::get(WeixinService::class);
    }

    public function wxPaySuccess() {
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $xml = $this -> weixinService -> orderPaySuccess($xml);
        echo  $xml;
        die;
    }

    public function aa() {
        $order = CarpoolOrder::get(['id' => 1]);
        $extra = $order -> getExtraa();
        if(isset($extra['id'])) {
            return 1;
        }

    }

}