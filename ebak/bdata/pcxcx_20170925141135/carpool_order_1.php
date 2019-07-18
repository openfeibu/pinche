<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `carpool_order`;");
E_C("CREATE TABLE `carpool_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `money` decimal(11,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 未支付 1已支付',
  `user_id` int(11) DEFAULT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `create_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>