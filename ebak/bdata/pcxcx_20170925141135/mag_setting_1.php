<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `mag_setting`;");
E_C("CREATE TABLE `mag_setting` (
  `key` varchar(255) NOT NULL,
  `value` longtext,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
E_D("replace into `mag_setting` values('carpool_admin_account','admin','管理员账号');");
E_D("replace into `mag_setting` values('carpool_admin_password','2d1395b483aa8a186903d3e59444656e','管理员密码');");
E_D("replace into `mag_setting` values('carpool_post_cost','0.01','发布时的金额');");
E_D("replace into `mag_setting` values('carpool_top_time_cost','0.02','置顶每小时金额');");
E_D("replace into `mag_setting` values('config_ad_banner','/public/uploads/img/default_banner.png','首页广告位');");
E_D("replace into `mag_setting` values('config_notice_content','<p style=\"margin-top:16px\">本平台仅提供信息交流，请大家自行辨别真伪，如要求付订金很可能是骗子，上车前请您核对车主身份信息！</p><p>&nbsp;</p><p>要确认好拼车人信息。详细记录拼车者姓名、年龄、身份证、个人及家庭联系方式等，最好有认识的人一起拼车。</p><p>与乘客约好出发时间，出发前1天最好给乘客通一次电话提醒对方。</p><p>要明确拼车所需的费用。尤其是一旦发生交通违章造成罚款的分担，以及车辆发生问题所带来的维修费用的承担。</p><p>要和乘客明确是上车前支付还是上车后支付，还应明确额外费用的支付方式。</p><p>合理规划时间，总路程不宜超过十小时，不走夜路。 不要疲劳驾驶，同时保管好个人财物。</p><p>车主和同车人应分别将了解到的对方信息发送给至少一名亲友，以备出现问题后联系使用，并有意让对方知道这个情况。</p><p>事先确定好关于吸烟等细节的规则,特别是有女性和小孩在场的时候。</p><p>签协议和买保险是非常有必要的。</p><p>&nbsp;</p><p>拼车者最好是熟悉的。与陌生人拼车时，要注意预防骗子或劫车者，车主和乘车人有必要互相了解对方的真实身份及联系方式。</p><p>车主和同车人应分别将了解到的对方信息发送给至少一名亲友，以备出现问题后联系使用，并有意让对方知道这个情况。</p><p>搭车人应事先了解驾驶员的技术水平、所用车型。关键是有无跑长途的经历。</p><p>要和乘客明确是上车前支付还是上车后支付，还应明确额外费用的支付方式。</p><p>总路程不宜超过10小时，不走夜路。避免心急赶路和疲劳驾驶，合理安排休息。</p><p>车主对于没有驾驶过所乘车型的同车人，尽量不要让其参与驾驶。</p><p>不要在途中向同车不熟悉的人炫耀自己的或者所携带财物 情况。</p><p>女性车主或乘车人应有熟悉的男性成年亲友相伴。</p><p>事先确定好关于吸烟等细节的规则,特别是有女性和小孩在场的时候 。</p><p>签协议和买保险是非常有必要的。</p><p>&nbsp;</p><p><br/></p>','公告内容');");
E_D("replace into `mag_setting` values('config_notice_title','《拼车免责声明》','公告标题');");
E_D("replace into `mag_setting` values('config_pay_ali_pid','','支付宝身份ID');");
E_D("replace into `mag_setting` values('config_pay_wx_appid','','APP APPID');");
E_D("replace into `mag_setting` values('config_pay_wx_js_appid','','JS APPID');");
E_D("replace into `mag_setting` values('config_pay_wx_js_key','','JS KEY');");
E_D("replace into `mag_setting` values('config_pay_wx_js_mch_id','','JS MCHID');");
E_D("replace into `mag_setting` values('config_pay_wx_js_secret','','APP SECRET');");
E_D("replace into `mag_setting` values('config_pay_wx_key','','APP KEY');");
E_D("replace into `mag_setting` values('config_pay_wx_mch_id','','APP MCHID');");
E_D("replace into `mag_setting` values('config_pay_wx_small_appid','','小程序APPID');");
E_D("replace into `mag_setting` values('config_pay_wx_small_key','','小程序KEY');");
E_D("replace into `mag_setting` values('config_pay_wx_small_mch_id','','小程序MCHID');");
E_D("replace into `mag_setting` values('config_pay_wx_small_secret','','小程序SECRET');");
E_D("replace into `mag_setting` values('config_share_des',NULL,'第三方分享描述');");
E_D("replace into `mag_setting` values('config_share_pic','/public/uploads/img/default_share_pic.png','第三方分享图片');");
E_D("replace into `mag_setting` values('config_share_title','丰宁拼车里','拼车出行，绿色环保');");

require("../../inc/footer.php");
?>