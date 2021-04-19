-- -------------------------------------------------------------
-- TablePlus 3.12.5(364)
--
-- https://tableplus.com/
--
-- Database: mysteryboxes_com
-- Generation Time: 2021-04-19 00:05:58.7560
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `check_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `date_of_check` varchar(16) NOT NULL DEFAULT '' COMMENT '签到日期 yyyy-MM-dd',
  `gmt_created` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='每日签到表';

CREATE TABLE `gold_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `before_number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '变更前数量',
  `number` int(10) NOT NULL DEFAULT '0' COMMENT '变更数量',
  `after_number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '变更后数量',
  `version` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '乐观锁',
  `description` varchar(63) NOT NULL DEFAULT '' COMMENT '变更说明',
  `gmt_created` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='金币变更日志表';

CREATE TABLE `medal` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(32) NOT NULL DEFAULT '' COMMENT '编码',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `image_url` varchar(255) NOT NULL DEFAULT '' COMMENT '徽章图片',
  `odds` int(11) NOT NULL DEFAULT '0' COMMENT '出现几率',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='勋章信息表';

CREATE TABLE `prize` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '奖品类型 0 - 优惠券，1 - 实物',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `image_url` varchar(255) NOT NULL DEFAULT '' COMMENT '奖品图片',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存数量',
  `exchange_rule` varchar(255) NOT NULL DEFAULT '' COMMENT '兑换规则，指定勋章编码逗号拼接，如未指定使用权重最低的一个勋章',
  `exchange_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '兑换说明',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `version` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '乐观锁',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='奖品表';

CREATE TABLE `share_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `date_of_share` varchar(16) NOT NULL DEFAULT '' COMMENT '分享日期 yyyy-MM-dd',
  `gmt_created` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='每日分享表';

CREATE TABLE `stock_medal` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `medal_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '勋章id',
  `medal_code` varchar(32) NOT NULL DEFAULT '' COMMENT '勋章编码',
  `number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '拥有数量',
  `version` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '乐观锁',
  `gmt_created` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='用户勋章库存表';

CREATE TABLE `stock_medal_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `medal_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '勋章id',
  `medal_code` varchar(32) NOT NULL DEFAULT '' COMMENT '勋章编码',
  `before_number` int(10) NOT NULL DEFAULT '0' COMMENT '变更前数量',
  `number` int(10) NOT NULL DEFAULT '0' COMMENT '变更数量',
  `after_number` int(10) NOT NULL DEFAULT '0' COMMENT '变更后数量',
  `version` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '乐观锁',
  `description` varchar(63) NOT NULL DEFAULT '' COMMENT '变更说明',
  `gmt_created` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户勋章库存日志表';

CREATE TABLE `stock_prize` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `prize_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '勋章id',
  `notify_shipping` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '请求发货状态：0 - 未请求发货，1 - 已请求发货',
  `real_name` varchar(255) NOT NULL DEFAULT '' COMMENT '收货联系人',
  `phone_number` varchar(255) NOT NULL DEFAULT '' COMMENT '联系电话',
  `address` text COMMENT '详细地址',
  `gmt_created` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='用户勋章库存表';

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `out_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '外部系统用户id',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `gender` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '性别：0 - 未知，1 - 男，2 - 女',
  `avatar_url` varchar(255) NOT NULL DEFAULT '' COMMENT '头像地址',
  `register_time` datetime DEFAULT NULL COMMENT '注册时间',
  `mobile_phone` varchar(32) NOT NULL DEFAULT '' COMMENT '手机 号码',
  `freeze` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '冻结用户：0 - 未冻结，1 - 已冻结',
  `referrer` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '推荐用户id',
  `checkin` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '签到次数',
  `gold` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户金币数量',
  `medal` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户累计获得勋章数量',
  `poster` text COMMENT '海报',
  `version` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '乐观锁',
  `gmt_created` datetime NOT NULL COMMENT '创建时间',
  `gmt_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户信息表';

CREATE TABLE `wechat_account` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户表id',
  `app_type` varchar(32) NOT NULL DEFAULT '' COMMENT '微信应用类型：official_account - 公众号，mini_program - 小程序',
  `open_id` varchar(64) NOT NULL DEFAULT '' COMMENT '用户在微信应用下的唯一标识',
  `app_id` varchar(64) NOT NULL DEFAULT '' COMMENT '微信应用id',
  `union_id` varchar(64) NOT NULL DEFAULT '' COMMENT '用户在同一个微信主体下多个应用之间的唯一标识',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar_url` varchar(255) NOT NULL DEFAULT '' COMMENT '头像地址',
  `gender` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '性别：0 - 未知，1 - 男，2 - 女',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '所在城市',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '所在省份',
  `country` varchar(32) NOT NULL DEFAULT '' COMMENT '所在国家',
  `subscribe_time` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '公众号关注的时间，多次关注获取最后一次时间',
  `subscribe_scene` varchar(32) NOT NULL DEFAULT '' COMMENT '公众号关注渠道来源，详情见微信官方公众号开发文档',
  `created_by` varchar(128) NOT NULL DEFAULT '' COMMENT '创建人',
  `gmt_created` datetime NOT NULL COMMENT '创建时间',
  `modified_by` varchar(255) NOT NULL DEFAULT '' COMMENT '修改人',
  `gmt_modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户第三方平台账号表 - 微信平台';

INSERT INTO `check_history` (`id`, `user_id`, `date_of_check`, `gmt_created`) VALUES
(1, 1, '2021-04-18', '2021-04-18 23:48:07');

INSERT INTO `gold_history` (`id`, `user_id`, `before_number`, `number`, `after_number`, `version`, `description`, `gmt_created`) VALUES
(1, 1, 0, 2, 2, 1, '每日签到获得金币', '2021-04-18 23:48:07'),
(2, 1, 2, 2, 4, 2, '每日分享获得金币', '2021-04-18 23:49:26'),
(4, 1, 4, -3, 1, 3, '游戏消费', '2021-04-18 23:53:05'),
(5, 1, 1000, -3, 997, 4, '游戏消费', '2021-04-18 23:58:38'),
(6, 1, 997, -3, 994, 5, '游戏消费', '2021-04-18 23:59:23'),
(7, 1, 994, -3, 991, 6, '游戏消费', '2021-04-18 23:59:25'),
(8, 1, 991, -3, 988, 7, '游戏消费', '2021-04-18 23:59:25'),
(9, 1, 988, -3, 985, 8, '游戏消费', '2021-04-18 23:59:26'),
(10, 1, 985, -3, 982, 9, '游戏消费', '2021-04-18 23:59:27'),
(11, 1, 982, -3, 979, 10, '游戏消费', '2021-04-18 23:59:28'),
(12, 1, 979, -3, 976, 11, '游戏消费', '2021-04-18 23:59:29'),
(13, 1, 976, -3, 973, 12, '游戏消费', '2021-04-18 23:59:29'),
(14, 1, 973, -3, 970, 13, '游戏消费', '2021-04-18 23:59:30'),
(15, 1, 970, -3, 967, 14, '游戏消费', '2021-04-18 23:59:31'),
(16, 1, 967, -3, 964, 15, '游戏消费', '2021-04-18 23:59:31'),
(17, 1, 964, -3, 961, 16, '游戏消费', '2021-04-18 23:59:32'),
(18, 1, 961, -3, 958, 17, '游戏消费', '2021-04-18 23:59:33'),
(19, 1, 958, -3, 955, 18, '游戏消费', '2021-04-18 23:59:34'),
(20, 1, 955, -3, 952, 19, '游戏消费', '2021-04-18 23:59:34'),
(21, 1, 952, -3, 949, 20, '游戏消费', '2021-04-18 23:59:35'),
(22, 1, 949, -3, 946, 21, '游戏消费', '2021-04-18 23:59:36'),
(23, 1, 946, -3, 943, 22, '游戏消费', '2021-04-18 23:59:37'),
(24, 1, 943, -3, 940, 23, '游戏消费', '2021-04-18 23:59:37'),
(25, 1, 940, -3, 937, 24, '游戏消费', '2021-04-18 23:59:38'),
(26, 1, 937, -3, 934, 25, '游戏消费', '2021-04-18 23:59:39'),
(27, 1, 934, -3, 931, 26, '游戏消费', '2021-04-18 23:59:39'),
(28, 1, 931, -3, 928, 27, '游戏消费', '2021-04-18 23:59:40'),
(29, 1, 928, -3, 925, 28, '游戏消费', '2021-04-18 23:59:41'),
(30, 1, 925, -3, 922, 29, '游戏消费', '2021-04-18 23:59:41'),
(31, 1, 922, -3, 919, 30, '游戏消费', '2021-04-18 23:59:42'),
(32, 1, 919, -3, 916, 31, '游戏消费', '2021-04-18 23:59:43'),
(33, 1, 916, -3, 913, 32, '游戏消费', '2021-04-18 23:59:44'),
(34, 1, 913, -3, 910, 33, '游戏消费', '2021-04-18 23:59:44'),
(35, 1, 910, -3, 907, 34, '游戏消费', '2021-04-18 23:59:45'),
(36, 1, 907, -3, 904, 35, '游戏消费', '2021-04-18 23:59:46'),
(37, 1, 904, -3, 901, 36, '游戏消费', '2021-04-18 23:59:46'),
(38, 1, 901, -3, 898, 37, '游戏消费', '2021-04-18 23:59:47'),
(39, 1, 898, -3, 895, 38, '游戏消费', '2021-04-18 23:59:48');

INSERT INTO `medal` (`id`, `code`, `name`, `image_url`, `odds`) VALUES
(1, 'astronaut', '航天员', 'http://119.23.43.225:88/storage/badge/astronaut.png', 5),
(2, 'director', '大导演', 'http://119.23.43.225:88/storage/badge/director.png', 95),
(3, 'performer', '演奏家', 'http://119.23.43.225:88/storage/badge/performer.png', 200),
(4, 'explorer', '探险家', 'http://119.23.43.225:88/storage/badge/explorer.png', 600),
(5, 'photographer', '摄影家', 'http://119.23.43.225:88/storage/badge/photographer.png', 800),
(6, 'police', '警官', 'http://119.23.43.225:88/storage/badge/police.png', 1500),
(7, 'doctor', '医生', 'http://119.23.43.225:88/storage/badge/doctor.png', 2800),
(8, 'cook', '厨师', 'http://119.23.43.225:88/storage/badge/cook.png', 4000);

INSERT INTO `prize` (`id`, `name`, `type`, `description`, `image_url`, `quantity`, `exchange_rule`, `exchange_desc`, `remark`, `version`) VALUES
(1, '蜡笔小新地毯', 1, '集齐5款徽章可兑换', 'http://119.23.43.225:88/storage/prize/carpet.png', 300, 'astronaut,director,performer,explorer,doctor,cook', '体操小新+游泳小新+冲浪小新+足球小新+马术小新+篮球小新+举重小新', '注：每位用户每种现金券仅限兑换1张，实物奖品可兑换多个。', 1),
(2, '120元现金券', 0, '集齐7款徽章可兑换', 'http://119.23.43.225:88/storage/prize/coupon_120.png', 3000, 'astronaut,director,performer,explorer,doctor,cook', '体操小新+游泳小新+冲浪小新+足球小新+马术小新+篮球小新+举重小新', '注：每位用户每种现金券仅限兑换1张，实物奖品可兑换多个。', 1),
(3, '蜡笔小新胸针', 1, '集齐3款徽章可兑换', 'http://119.23.43.225:88/storage/prize/badge.png', 1000, 'astronaut,director,performer,explorer,doctor,cook', '足球小新+马术小新+篮球小新', '注：每位用户每种现金券仅限兑换1张，实物奖品可兑换多个。', 1),
(4, '200元现金券', 0, '集齐7款徽章可兑换', 'http://119.23.43.225:88/storage/prize/coupon_200.png', 3000, 'astronaut,director,performer,explorer,doctor,cook', '芭蕾舞小新+体操小新+游泳小新+冲浪小新+足球小新+马术小新+举重小新', '注：每位用户每种现金券仅限兑换1张，实物奖品可兑换多个。', 1),
(5, '60元现金券', 0, '集齐3款徽章可兑换', 'http://119.23.43.225:88/storage/prize/coupon_200.png', 3000, 'astronaut,director,performer,explorer,doctor,cook', '足球小新+马术小新+篮球小新', '注：每位用户每种现金券仅限兑换1张，实物奖品可兑换多个。', 1);

INSERT INTO `share_history` (`id`, `user_id`, `date_of_share`, `gmt_created`) VALUES
(1, 1, '2021-04-18', '2021-04-18 23:49:26');

INSERT INTO `stock_medal` (`id`, `user_id`, `medal_id`, `medal_code`, `number`, `version`, `gmt_created`) VALUES
(1, 1, 1, 'astronaut', 994, 7, '2021-04-18 23:03:13'),
(2, 1, 2, 'director', 994, 7, '2021-04-18 23:05:11'),
(3, 1, 3, 'performer', 994, 7, '2021-04-18 23:05:11'),
(4, 1, 4, 'explorer', 994, 7, '2021-04-18 23:05:11'),
(5, 1, 5, 'photographer', 1000, 1, '2021-04-18 23:05:11'),
(6, 1, 6, 'police', 1000, 1, '2021-04-18 23:05:11'),
(7, 1, 7, 'doctor', 994, 7, '2021-04-18 23:05:11'),
(8, 1, 8, 'cook', 994, 7, '2021-04-18 23:05:11'),
(10, 1, 7, 'doctor', 0, 1, '2021-04-18 23:53:05'),
(11, 1, 5, 'photographer', 0, 1, '2021-04-18 23:58:38'),
(12, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:23'),
(13, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:25'),
(14, 1, 7, 'doctor', 0, 1, '2021-04-18 23:59:25'),
(15, 1, 4, 'explorer', 0, 1, '2021-04-18 23:59:26'),
(16, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:27'),
(17, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:28'),
(18, 1, 4, 'explorer', 0, 1, '2021-04-18 23:59:29'),
(19, 1, 7, 'doctor', 0, 1, '2021-04-18 23:59:29'),
(20, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:30'),
(21, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:31'),
(22, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:31'),
(23, 1, 7, 'doctor', 0, 1, '2021-04-18 23:59:32'),
(24, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:33'),
(25, 1, 6, 'police', 0, 1, '2021-04-18 23:59:34'),
(26, 1, 3, 'performer', 0, 1, '2021-04-18 23:59:34'),
(27, 1, 6, 'police', 0, 1, '2021-04-18 23:59:35'),
(28, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:36'),
(29, 1, 7, 'doctor', 0, 1, '2021-04-18 23:59:37'),
(30, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:37'),
(31, 1, 7, 'doctor', 0, 1, '2021-04-18 23:59:38'),
(32, 1, 5, 'photographer', 0, 1, '2021-04-18 23:59:39'),
(33, 1, 4, 'explorer', 0, 1, '2021-04-18 23:59:39'),
(34, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:40'),
(35, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:41'),
(36, 1, 7, 'doctor', 0, 1, '2021-04-18 23:59:41'),
(37, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:42'),
(38, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:43'),
(39, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:44'),
(40, 1, 7, 'doctor', 0, 1, '2021-04-18 23:59:44'),
(41, 1, 7, 'doctor', 0, 1, '2021-04-18 23:59:45'),
(42, 1, 5, 'photographer', 0, 1, '2021-04-18 23:59:46'),
(43, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:46'),
(44, 1, 6, 'police', 0, 1, '2021-04-18 23:59:47'),
(45, 1, 8, 'cook', 0, 1, '2021-04-18 23:59:48');

INSERT INTO `stock_medal_history` (`id`, `user_id`, `medal_id`, `medal_code`, `before_number`, `number`, `after_number`, `version`, `description`, `gmt_created`) VALUES
(1, 1, 8, 'cook', 1000, -1, 999, 1, '兑换奖励蜡笔小新地毯', '2021-04-18 23:33:31'),
(2, 1, 8, 'cook', 999, -1, 998, 2, '兑换奖励蜡笔小新地毯', '2021-04-18 23:33:36'),
(3, 1, 8, 'cook', 998, -1, 997, 3, '兑换奖励蜡笔小新地毯', '2021-04-18 23:33:38'),
(4, 1, 8, 'cook', 997, -1, 996, 4, '兑换奖励蜡笔小新地毯', '2021-04-18 23:34:56'),
(5, 1, 8, 'cook', 996, -1, 995, 5, '兑换奖励蜡笔小新地毯', '2021-04-18 23:35:59'),
(6, 1, 8, 'cook', 995, -1, 994, 6, '兑换奖励蜡笔小新胸针', '2021-04-18 23:47:32');

INSERT INTO `stock_prize` (`id`, `user_id`, `prize_id`, `notify_shipping`, `real_name`, `phone_number`, `address`, `gmt_created`) VALUES
(1, 1, 1, 0, '', '', NULL, '2021-04-18 21:14:18'),
(2, 1, 2, 0, '', '', NULL, '2021-04-18 21:14:27'),
(3, 1, 1, 0, '', '', NULL, '2021-04-18 23:33:31'),
(4, 1, 1, 0, '', '', NULL, '2021-04-18 23:33:36'),
(5, 1, 1, 0, '', '', NULL, '2021-04-18 23:33:38'),
(6, 1, 1, 0, '', '', NULL, '2021-04-18 23:34:56'),
(7, 1, 1, 0, '', '', NULL, '2021-04-18 23:35:59'),
(8, 1, 3, 0, '', '', NULL, '2021-04-18 23:47:32');

INSERT INTO `user` (`id`, `out_id`, `nickname`, `gender`, `avatar_url`, `register_time`, `mobile_phone`, `freeze`, `referrer`, `checkin`, `gold`, `medal`, `poster`, `version`, `gmt_created`, `gmt_modified`) VALUES
(1, 1, '马马马', 1, 'https://avatars.githubusercontent.com/u/27860532?s=400&v=4', '2021-04-08 08:50:27', '15107691336', 0, 0, 1, 1, 36, NULL, 39, '2021-04-07 16:48:04', '2021-04-19 00:03:25');

INSERT INTO `wechat_account` (`id`, `user_id`, `app_type`, `open_id`, `app_id`, `union_id`, `nickname`, `avatar_url`, `gender`, `city`, `province`, `country`, `subscribe_time`, `subscribe_scene`, `created_by`, `gmt_created`, `modified_by`, `gmt_modified`) VALUES
(1, 1, 'officialAccount', 'tester-openid', 'test-appid', 'tester-unionid', '马马马', 'https://avatars.githubusercontent.com/u/27860532?s=400&v=4', 1, '', '', '', 0, '', 'test', '2021-04-02 09:00:07', 'test', '2021-04-08 08:49:21');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;