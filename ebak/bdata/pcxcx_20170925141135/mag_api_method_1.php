<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `mag_api_method`;");
E_C("CREATE TABLE `mag_api_method` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `method` varchar(255) DEFAULT NULL,
  `result_info` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>