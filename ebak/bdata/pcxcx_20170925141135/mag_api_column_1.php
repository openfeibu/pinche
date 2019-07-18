<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `mag_api_column`;");
E_C("CREATE TABLE `mag_api_column` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(111) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `rank` int(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>