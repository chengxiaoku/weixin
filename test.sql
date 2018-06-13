/*
Navicat MySQL Data Transfer

Source Server         : 服务器
Source Server Version : 50639
Source Host           : 123.207.218.195:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50639
File Encoding         : 65001

Date: 2018-06-13 11:21:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for access_token
-- ----------------------------
DROP TABLE IF EXISTS `access_token`;
CREATE TABLE `access_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of access_token
-- ----------------------------
INSERT INTO `access_token` VALUES ('4', 'wechat_access_tokenwx3685282b3057c7d3', '10_eM586zr_2WDR0A0cI1RGYswolnMJDhI2eRpQQBnThgMw5lBAZcwe8rO2MR3y2QRHbinh_ajC1j8-wESWyPHr14Yz0LiLyGXcQDmgtAb5s25HQcgic0KZ4tMV7t38J0n-JnhWPI1BUjgHYvFLPVXjADAAGI', '1527327026');
INSERT INTO `access_token` VALUES ('5', 'wechat_access_tokenwxe459fc6738158329', '10_hJYkVo0HP7wfTTtOPHDDu8RwcEhE7g3rIOtNOgZ4DW051rGhApKMUCdZrYejEeN0ObwVF-5w1ubi2FmHh68lByi5XWCXn_L4oSW12TO_y1KwjL36t0KjTPzeRKejixtuY3AHdoHlmYYKwnaGJXNeAHAWKA', '1528856225');

-- ----------------------------
-- Table structure for list
-- ----------------------------
DROP TABLE IF EXISTS `list`;
CREATE TABLE `list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user1_openid` varchar(200) NOT NULL,
  `user2_openid` varchar(200) DEFAULT NULL,
  `user1_sex` int(10) DEFAULT NULL COMMENT '1 男 2女 0未知',
  `create_time` varchar(200) DEFAULT NULL COMMENT '开始等待时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of list
-- ----------------------------

-- ----------------------------
-- Table structure for test
-- ----------------------------
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `sex` varchar(100) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `headimgurl` varchar(100) DEFAULT NULL,
  `subscribe` int(100) DEFAULT NULL,
  `subscribe_time` varchar(20) DEFAULT NULL,
  `createtime` varchar(90) DEFAULT NULL,
  `token` varchar(80) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test
-- ----------------------------
INSERT INTO `test` VALUES ('9', 'oZSJ1wZJRES3nXO9Q-uxZoyZYxsU', '℃', '1', null, null, '河南', '洛阳', null, null, '1526862484', '1526862484', 'clf', null);
INSERT INTO `test` VALUES ('14', 'oZSJ1weVi0gB3FACz7MPLvbyNL0c', '国峰', '0', null, null, '', '', null, null, '1526876168', '1526876169', 'clf', null);
INSERT INTO `test` VALUES ('15', 'oZSJ1wXv355mAbP7pvkBHXU3iud8', '风珍', '2', null, null, '河南', '平顶山', null, null, '1526895155', '1526895155', 'clf', null);
INSERT INTO `test` VALUES ('16', 'oGPSv1XdGgpVru7Zsn-1n1mmdAVU', '℃', '1', null, null, '河南', '洛阳', null, null, '1526906617', '1526906617', 'clf', null);
INSERT INTO `test` VALUES ('17', 'oGPSv1ahJvLjBe2jdF_y8h5__sT4', '国峰', '2', null, null, '', '', null, null, '1526908210', '1526908210', 'clf', null);
INSERT INTO `test` VALUES ('18', 'oGPSv1ZI3vm5InShjT7bkPAT7AWQ', '拓力威技术', '0', null, null, '', '', null, null, '1526909361', '1526909361', 'clf', null);
INSERT INTO `test` VALUES ('19', 'oGPSv1Sdc4WgiGz8thjrYSm8Zi8s', '蓝研墨雪', '2', null, null, '', '', null, null, '1526910234', '1526910234', 'clf', null);
INSERT INTO `test` VALUES ('20', 'oGPSv1eSyAhTk3aTUvg4GJFaoXeY', '毛头', '1', null, null, '', '', null, null, '1526911456', '1526911456', 'clf', null);
INSERT INTO `test` VALUES ('21', 'oGPSv1aned4FChn94tplhapHT99k', '王磊说你很赞', '1', null, null, '', '', null, null, '1526913436', '1526913436', 'clf', null);
INSERT INTO `test` VALUES ('22', 'oGPSv1SKHh7Hdy9i2LMdkqUkXZS0', '风珍', '2', null, null, '河南', '平顶山', null, null, '1526914768', '1526914768', 'clf', null);
INSERT INTO `test` VALUES ('23', 'oGPSv1cvhCyljopa-GuBfbyw6tb4', '请叫我点赞狂魔', '2', null, null, '内蒙古', '包头', null, null, '1526981905', '1526981906', 'clf', null);
INSERT INTO `test` VALUES ('24', 'oGPSv1Qd3MghL_1OnhF5h8aUFE84', '燕子', '2', null, null, '', '', null, null, '1527052733', '1527052733', 'clf', null);
INSERT INTO `test` VALUES ('25', 'oGPSv1XaI5dIpqkuyScLrugwVvNw', '哼唱幸福', '1', null, null, '天津', '河西', null, null, '1527052792', '1527052792', 'clf', null);
INSERT INTO `test` VALUES ('26', 'oGPSv1dl_NlrQt-5roeQ0v5CM1Uc', '张宏亮', '1', null, null, '内蒙古', '包头', null, null, '1527056933', '1527056933', 'clf', null);
INSERT INTO `test` VALUES ('27', 'oGPSv1ebZBURtiaEHyLlMz-r4IFY', 'A 吴雪飞', '2', null, null, '维多利亚', '墨尔本', null, null, '1527057412', '1527057412', 'clf', null);
INSERT INTO `test` VALUES ('28', 'oGPSv1RJSIa-YtywsYl5LHou2Q04', '「小程序·微信新媒体」人脉哥', '1', null, null, '内蒙古', '包头', null, null, '1527129721', '1527129722', 'clf', null);
INSERT INTO `test` VALUES ('29', 'oGPSv1YFOGmYjlmB-bF1_V-mBRP0', '杨福军(包头大管家负责人)', '1', null, null, '内蒙古', '包头', null, null, '1527130366', '1527130366', 'clf', null);
INSERT INTO `test` VALUES ('30', 'oGPSv1encNNq763x9s7L_m49ESnY', 'Beauty', '2', null, null, '河南', '郑州', null, null, '1527216553', '1527216553', 'clf', null);
