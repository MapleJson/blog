/*
 Navicat Premium Data Transfer

 Source Server         : Docker
 Source Server Type    : MySQL
 Source Server Version : 50721
 Source Host           : 127.0.0.1:3306
 Source Schema         : blog

 Target Server Type    : MySQL
 Target Server Version : 50721
 File Encoding         : 65001

 Date: 25/06/2018 23:40:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for about
-- ----------------------------
DROP TABLE IF EXISTS `about`;
CREATE TABLE `about` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `siteName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '站点名称',
  `authorName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '作者名称',
  `profession` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '职业',
  `keywords` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '关键字',
  `description` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '站点说明',
  `mood` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '一句话描述自己',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '一篇关于我的文章',
  `weChat` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '微信号',
  `weChatQR` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '微信二维码图片',
  `qq` bigint(15) unsigned DEFAULT NULL COMMENT 'QQ号',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `state` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否展示 1 展示 2 不展示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `about_state_index` (`state`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of about
-- ----------------------------
BEGIN;
INSERT INTO `about` VALUES (1, '秋枫阁', 'Maple | Zoe', 'PHP工程师、web开发', '秋枫阁,Blog,博客,个人博客', '秋枫阁，是一个PHPer记录生活点滴，学习之路的个人网站。', '一个90后草根程序猿！2015年入行。一直潜心研究web后端技术，一边工作一边积累经验，分享一些个人笔记，以及开发经验等心得。', '<p>这是一篇关于我的文章。其中包含我的简介，联系方式等等。</p>', 'kfbbyz', 'images/20180621/20180621130310156.png', 888888888, '888888888@qq.com', 1, '2018-05-30 14:30:30', '2018-06-21 13:03:10');
COMMIT;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_menu` VALUES (1, 0, 1, '主页', 'fa-home', '/', NULL, '2018-06-24 22:35:18');
INSERT INTO `admin_menu` VALUES (2, 0, 12, '管理员', 'fa-tasks', NULL, NULL, '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (3, 2, 13, '用户', 'fa-users', 'auth/users', NULL, '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (4, 2, 14, '角色', 'fa-user', 'auth/roles', NULL, '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (5, 2, 15, '权限', 'fa-ban', 'auth/permissions', NULL, '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (6, 2, 16, '菜单', 'fa-bars', 'auth/menu', NULL, '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (7, 2, 17, '日志', 'fa-history', 'auth/logs', NULL, '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (8, 9, 4, '文章', 'fa-book', 'blog', '2018-06-20 01:02:50', '2018-06-21 15:11:48');
INSERT INTO `admin_menu` VALUES (9, 0, 3, '博客管理', 'fa-book', NULL, '2018-06-20 16:00:25', '2018-06-21 15:11:48');
INSERT INTO `admin_menu` VALUES (10, 9, 5, '标签', 'fa-tags', 'tags', '2018-06-20 21:48:55', '2018-06-21 15:11:48');
INSERT INTO `admin_menu` VALUES (11, 0, 9, '友情链接', 'fa-link', 'links', '2018-06-20 23:25:14', '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (12, 0, 11, '网站设置', 'fa-cogs', 'about', '2018-06-21 10:20:40', '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (13, 0, 2, '首页图片', 'fa-image', 'carousels', '2018-06-21 15:11:26', '2018-06-21 15:11:48');
INSERT INTO `admin_menu` VALUES (14, 0, 8, '留言管理', 'fa-comments', 'comment', '2018-06-21 15:59:27', '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (15, 0, 6, '相册管理', 'fa-camera-retro', 'travels', '2018-06-21 16:01:21', '2018-06-25 00:59:41');
INSERT INTO `admin_menu` VALUES (16, 0, 10, '用户管理', 'fa-users', 'users', '2018-06-27 01:02:15', '2018-06-29 02:17:12');
INSERT INTO `admin_menu` VALUES (17, 0, 7, '心情管理', 'fa-whatsapp', 'whispers', '2018-06-29 02:16:56', '2018-06-29 02:17:12');
COMMIT;

-- ----------------------------
-- Table structure for admin_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE `admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
BEGIN;
INSERT INTO `admin_permissions` VALUES (1, '所有权限', '*', '', '*', NULL, '2018-05-29 22:32:40');
INSERT INTO `admin_permissions` VALUES (2, '主页', 'index', 'GET', '/', NULL, '2018-06-25 23:36:33');
INSERT INTO `admin_permissions` VALUES (3, '登录', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, '2018-05-29 22:33:02');
INSERT INTO `admin_permissions` VALUES (4, '用户设置', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, '2018-05-29 22:32:54');
INSERT INTO `admin_permissions` VALUES (5, '身份验证', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, '2018-05-29 22:33:56');
COMMIT;

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
BEGIN;
INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
BEGIN;
INSERT INTO `admin_roles` VALUES (1, '炒鸡管理员', 'administrator', '2018-05-29 19:46:36', '2018-05-29 22:32:22');
COMMIT;

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
BEGIN;
INSERT INTO `admin_users` VALUES (1, 'admin', '$2y$10$zpXmKiFJrI4QY4w/hi4SoevcNwi.RzBWIwIpgpGW2Mc9XVkO9ot2e', '管理员', 'admin@gmail.com', NULL, 'X73Jjx5NqZZDYABbPGygA2y1FUHlO7yiqaDaNC1BiTyll8DqZm3oEApXGFtq', '2018-05-29 19:46:36', '2018-06-24 22:28:50');
COMMIT;

-- ----------------------------
-- Table structure for blog
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '封面图',
  `summary` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章简介',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章内容',
  `authorName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '作者',
  `authorEmail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '作者邮箱',
  `read` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `comments` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `isTop` tinyint(4) unsigned NOT NULL DEFAULT '2' COMMENT '是否置顶 1 置顶 2 不置顶',
  `recommend` tinyint(4) unsigned NOT NULL DEFAULT '2' COMMENT '是否推荐 1 推荐 2 不推荐',
  `original` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '是否原创 1 是(原创) 2 否(转载)',
  `state` tinyint(4) unsigned NOT NULL DEFAULT '2' COMMENT '是否展示 1 展示 2 不展示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `blog_title_index` (`title`),
  KEY `blog_istop_index` (`isTop`),
  KEY `blog_recommend_index` (`recommend`),
  KEY `blog_state_index` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for blog_tag
-- ----------------------------
DROP TABLE IF EXISTS `blog_tag`;
CREATE TABLE `blog_tag` (
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `blog_tag_blog_id_tag_id_index` (`blog_id`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for carousels
-- ----------------------------
DROP TABLE IF EXISTS `carousels`;
CREATE TABLE `carousels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片地址',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型 1 顶部 2 轮播',
  `state` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否展示 1 展示 2 不展示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carousels_title_index` (`title`),
  KEY `carousels_type_index` (`type`),
  KEY `carousels_state_index` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for links
-- ----------------------------
DROP TABLE IF EXISTS `links`;
CREATE TABLE `links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '链接',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'logo链接',
  `title` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '站点名称',
  `summary` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '站点说明',
  `state` tinyint(4) NOT NULL DEFAULT '2' COMMENT '审核状态 1 通过 2 待审核 3 不通过',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `link_state_index` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `articleId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `parentId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '主评论ID',
  `targetId` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被回复人ID',
  `targetUser` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '作者' COMMENT '被回复人名称',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '回复人头像',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '回复人名称',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '回复内容',
  `state` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否展示 1 展示 2 不展示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `message_articleid_index` (`articleId`),
  KEY `message_parentid_index` (`parentId`),
  KEY `message_targetid_index` (`targetId`),
  KEY `message_state_index` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES (1, '2016_01_04_173148_create_admin_tables', 1);
INSERT INTO `migrations` VALUES (2, '2018_05_29_143810_create_blog_table', 1);
INSERT INTO `migrations` VALUES (3, '2018_05_29_143846_create_about_table', 1);
INSERT INTO `migrations` VALUES (4, '2018_05_29_143857_create_messages_table', 1);
INSERT INTO `migrations` VALUES (5, '2018_05_29_143911_create_links_table', 1);
INSERT INTO `migrations` VALUES (6, '2018_05_29_143930_create_travels_table', 1);
INSERT INTO `migrations` VALUES (7, '2018_05_29_144028_create_users_table', 1);
INSERT INTO `migrations` VALUES (8, '2018_05_29_161344_create_tags_table', 1);
INSERT INTO `migrations` VALUES (9, '2018_05_29_165611_create_thumbs_table', 1);
INSERT INTO `migrations` VALUES (10, '2018_05_29_165625_create_intermediate_table', 1);
INSERT INTO `migrations` VALUES (11, '2018_05_29_170027_create_photos_table', 1);
INSERT INTO `migrations` VALUES (12, '2018_05_30_094446_create_carousels_table', 2);
COMMIT;

-- ----------------------------
-- Table structure for photos
-- ----------------------------
DROP TABLE IF EXISTS `photos`;
CREATE TABLE `photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `travelId` int(10) unsigned NOT NULL COMMENT '图片所属相册',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '图片地址',
  `summary` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '图片简介',
  `state` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否展示 1 展示 2 不展示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_travelid_index` (`travelId`),
  KEY `photos_state_index` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for tags
-- ----------------------------
DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标签名称',
  `state` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否展示 1 展示 2 不展示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tags_state_index` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for travels
-- ----------------------------
DROP TABLE IF EXISTS `travels`;
CREATE TABLE `travels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '封面',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '相册标题',
  `summary` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '相册简介',
  `state` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否展示 1 展示 2 不展示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `travel_state_index` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户头像',
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户名称',
  `nickname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户昵称',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户邮箱',
  `password` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '用户密码',
  `confirmationToken` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'token',
  `githubId` bigint(15) unsigned DEFAULT NULL COMMENT 'github登录ID',
  `githubName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'github账户名称',
  `githubUrl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'github地址',
  `qqOpenid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'QQ登录ID',
  `wbOpenId` bigint(15) unsigned DEFAULT NULL COMMENT '微博ID',
  `state` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否展示 1 展示 2 不展示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_state_index` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table structure for whispers
-- ----------------------------
DROP TABLE IF EXISTS `whispers`;
CREATE TABLE `whispers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '作者',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '2' COMMENT '是否展示 1 展示 2 不展示',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `whispers_state_index` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
