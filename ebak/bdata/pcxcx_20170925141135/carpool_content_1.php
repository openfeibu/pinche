<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `carpool_content`;");
E_C("CREATE TABLE `carpool_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_place` varchar(255) DEFAULT NULL,
  `to_place` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT '类型 1:人找车 2:车找人',
  `start_time` int(11) DEFAULT NULL,
  `mid_place` varchar(255) DEFAULT NULL,
  `car` varchar(255) DEFAULT NULL,
  `user_count` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `top_time` int(11) DEFAULT NULL,
  `postdate` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>