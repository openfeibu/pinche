-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-05-15 17:28:09
-- 服务器版本： 5.5.54-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beijing`
--

-- --------------------------------------------------------

--
-- 表的结构 `carpool_content`
--

CREATE TABLE `carpool_content` (
  `id` int(11) NOT NULL,
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
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `carpool_order`
--

CREATE TABLE `carpool_order` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `money` decimal(11,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0 未支付 1已支付',
  `user_id` int(11) DEFAULT NULL,
  `extra` varchar(255) DEFAULT NULL,
  `create_time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `carpool_user`
--

CREATE TABLE `carpool_user` (
  `id` int(11) NOT NULL,
  `wx_open_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `head` varchar(255) DEFAULT NULL,
  `mag_open_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mag_api_column`
--

CREATE TABLE `mag_api_column` (
  `id` int(11) NOT NULL,
  `controller` varchar(111) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `des` varchar(255) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `rank` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mag_api_method`
--

CREATE TABLE `mag_api_method` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `method` varchar(255) DEFAULT NULL,
  `result_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `mag_setting`
--

CREATE TABLE `mag_setting` (
  `key` varchar(255) NOT NULL,
  `value` longtext,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `mag_setting`
--

INSERT INTO `mag_setting` (`key`, `value`, `name`) VALUES
('carpool_admin_account', 'admin', '管理员账号'),
('carpool_admin_password', '2d1395b483aa8a186903d3e59444656e', '管理员密码'),
('carpool_post_cost', '0.01', '发布时的金额'),
('carpool_top_time_cost', '0.02', '置顶每小时金额'),
('config_ad_banner', '/public/uploads/img/default_banner.png', '首页广告位'),
('config_notice_content', '<p style=\"margin-top:16px\">本平台仅提供信息交流，请大家自行辨别真伪，如要求付订金很可能是骗子，上车前请您核对车主身份信息！</p><p>&nbsp;</p><p>要确认好拼车人信息。详细记录拼车者姓名、年龄、身份证、个人及家庭联系方式等，最好有认识的人一起拼车。</p><p>与乘客约好出发时间，出发前1天最好给乘客通一次电话提醒对方。</p><p>要明确拼车所需的费用。尤其是一旦发生交通违章造成罚款的分担，以及车辆发生问题所带来的维修费用的承担。</p><p>要和乘客明确是上车前支付还是上车后支付，还应明确额外费用的支付方式。</p><p>合理规划时间，总路程不宜超过十小时，不走夜路。 不要疲劳驾驶，同时保管好个人财物。</p><p>车主和同车人应分别将了解到的对方信息发送给至少一名亲友，以备出现问题后联系使用，并有意让对方知道这个情况。</p><p>事先确定好关于吸烟等细节的规则,特别是有女性和小孩在场的时候。</p><p>签协议和买保险是非常有必要的。</p><p>&nbsp;</p><p>拼车者最好是熟悉的。与陌生人拼车时，要注意预防骗子或劫车者，车主和乘车人有必要互相了解对方的真实身份及联系方式。</p><p>车主和同车人应分别将了解到的对方信息发送给至少一名亲友，以备出现问题后联系使用，并有意让对方知道这个情况。</p><p>搭车人应事先了解驾驶员的技术水平、所用车型。关键是有无跑长途的经历。</p><p>要和乘客明确是上车前支付还是上车后支付，还应明确额外费用的支付方式。</p><p>总路程不宜超过10小时，不走夜路。避免心急赶路和疲劳驾驶，合理安排休息。</p><p>车主对于没有驾驶过所乘车型的同车人，尽量不要让其参与驾驶。</p><p>不要在途中向同车不熟悉的人炫耀自己的或者所携带财物 情况。</p><p>女性车主或乘车人应有熟悉的男性成年亲友相伴。</p><p>事先确定好关于吸烟等细节的规则,特别是有女性和小孩在场的时候 。</p><p>签协议和买保险是非常有必要的。</p><p>&nbsp;</p><p><br/></p>', '公告内容'),
('config_notice_title', '《拼车免责声明》', '公告标题'),
('config_pay_ali_pid', '', '支付宝身份ID'),
('config_pay_wx_appid', '', 'APP APPID'),
('config_pay_wx_js_appid', '', 'JS APPID'),
('config_pay_wx_js_key', '', 'JS KEY'),
('config_pay_wx_js_mch_id', '', 'JS MCHID'),
('config_pay_wx_js_secret', '', 'APP SECRET'),
('config_pay_wx_key', '', 'APP KEY'),
('config_pay_wx_mch_id', '', 'APP MCHID'),
('config_pay_wx_small_appid', '', '小程序APPID'),
('config_pay_wx_small_key', '', '小程序KEY'),
('config_pay_wx_small_mch_id', '', '小程序MCHID'),
('config_pay_wx_small_secret', '', '小程序SECRET'),
('config_share_des', NULL, '第三方分享描述'),
('config_share_pic', '/public/uploads/img/default_share_pic.png', '第三方分享图片'),
('config_share_title', '丰宁拼车里', '拼车出行，绿色环保');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carpool_content`
--
ALTER TABLE `carpool_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carpool_order`
--
ALTER TABLE `carpool_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carpool_user`
--
ALTER TABLE `carpool_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_api_column`
--
ALTER TABLE `mag_api_column`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_api_method`
--
ALTER TABLE `mag_api_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mag_setting`
--
ALTER TABLE `mag_setting`
  ADD PRIMARY KEY (`key`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `carpool_content`
--
ALTER TABLE `carpool_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `carpool_order`
--
ALTER TABLE `carpool_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `carpool_user`
--
ALTER TABLE `carpool_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `mag_api_column`
--
ALTER TABLE `mag_api_column`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
