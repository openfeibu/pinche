<?php
/**
 * 南京灵衍信息科技有限公司
 * User: jinghao@duohuo.net
 * Date: 16/9/30
 * Time: 上午11:32
 */

namespace app\core;


use app\carpool\service\OrderService;
use app\core\forum\ForumColumnLogic;
use app\core\forum\ThreadLogic;
use app\mag\dz\forum\DzForumCloumnLogic;
use app\mag\dz\forum\DzThreadLogic;
use app\mag\wave\LoginWave;
use app\mag\user\logic\LocalUserLogic;
use app\core\user\UserLogic;
use rap\Aop\CtrWave;
use rap\Aop\EventHook;
use rap\Ioc;
class AppInit {
    public static function run() {
        CtrWave::instance()->add("checkLogin", LoginWave::class, "checkLogin");
        Ioc::bind(UserLogic::class, LocalUserLogic::class);
        Ioc::bind(ForumColumnLogic::class, DzForumCloumnLogic::class);
        Ioc::bind(ThreadLogic::class, DzThreadLogic::class);

        //监听支付完成回调钩子
        EventHook::add('orderPaySuccess', OrderService::class, 'paySuccess');
    }


}