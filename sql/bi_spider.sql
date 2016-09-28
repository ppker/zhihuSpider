CREATE TABLE `details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `platform_id` smallint(6) unsigned NOT NULL COMMENT '平台ID',
  `produce_id` int(12) unsigned NOT NULL COMMENT '产品ID',
  `produce_mayer` varchar(20) NOT NULL DEFAULT '' COMMENT '购买人',
  `produce_may_money` bigint(16) NOT NULL DEFAULT '0' COMMENT '购买金额',
  `produce_may_time` int(12) NOT NULL DEFAULT '0' COMMENT '购买时间',
  `create_time` int(12) NOT NULL DEFAULT '0' COMMENT '记录创建时间',
  `update_time` int(12) NOT NULL DEFAULT '0' COMMENT '记录更新时间',
  PRIMARY KEY (`id`),
  KEY `platform_id` (`platform_id`),
  KEY `produce_id` (`produce_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品购买记录表';

CREATE TABLE `platform` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `platform_name` varchar(50) NOT NULL COMMENT '平台名字',
  `platform_url` varchar(100) NOT NULL COMMENT '平台网址',
  `platform_rank` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '平台排名',
  `platform_desc` varchar(256) DEFAULT NULL COMMENT '平台简介',
  `platform_total_money` bigint(20) NOT NULL DEFAULT '0' COMMENT '平台累计投资',
  `platform_total_times` bigint(14) NOT NULL DEFAULT '0' COMMENT '平台累计购买人次',
  `platform_total_profit` bigint(16) NOT NULL DEFAULT '0' COMMENT '平台累计为用户获利',
  `platform_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '平台状态',
  `create_time` int(12) NOT NULL DEFAULT '0' COMMENT '记录创建时间',
  `update_time` int(12) NOT NULL DEFAULT '0' COMMENT '记录更新时间',
  PRIMARY KEY (`id`),
  KEY `platform_status` (`platform_status`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='金融平台信息表';

CREATE TABLE `produce` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `produce_name` varchar(50) NOT NULL COMMENT '产品名字',
  `produce_rate` varchar(25) NOT NULL COMMENT '产品利率',
  `produce_total_money` bigint(20) NOT NULL DEFAULT '0' COMMENT '产品累计投资',
  `produce_total_profit` bigint(16) NOT NULL DEFAULT '0' COMMENT '产品累计赚取',
  `produce_total_times` bigint(14) NOT NULL DEFAULT '0' COMMENT '产品累计入团',
  `produce_deadline` int(10) NOT NULL DEFAULT '0' COMMENT '产品期限',
  `create_time` int(12) NOT NULL DEFAULT '0' COMMENT '记录创建时间',
  `update_time` int(12) NOT NULL DEFAULT '0' COMMENT '记录更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='理财产品信息表';

