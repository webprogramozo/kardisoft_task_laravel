/*
Navicat MySQL Data Transfer

Source Server         : [DEV] LOCALHOST
Source Server Version : 80031
Source Host           : 127.0.0.1:3306
Source Database       : kardisoft_task

Target Server Type    : MYSQL
Target Server Version : 80031
File Encoding         : 65001

Date: 2024-03-06 14:14:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for medicines
-- ----------------------------
DROP TABLE IF EXISTS `medicines`;
CREATE TABLE `medicines` (
  `med_id` int NOT NULL,
  `med_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `med_reg_number` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `med_active_ingredient` varchar(550) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `med_atc_code` varchar(7) COLLATE utf8mb4_general_ci NOT NULL,
  `med_auth_date` date NOT NULL,
  PRIMARY KEY (`med_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SET FOREIGN_KEY_CHECKS=1;
