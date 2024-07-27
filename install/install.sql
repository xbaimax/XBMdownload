CREATE TABLE IF NOT EXISTS `app_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_title` varchar(255) NOT NULL,
  `app_icon` varchar(255) NOT NULL,
  `app_version` varchar(50) NOT NULL,
  `app_platform` varchar(50) NOT NULL,
  `app_source_url` varchar(255) NOT NULL,
  `app_description` text NOT NULL,
  `app_download_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(255) NOT NULL COMMENT '账号',
  `xkey` varchar(255) NOT NULL COMMENT '密码',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admin` (`username`, `xkey`) VALUES ('admin','123456');

INSERT INTO `app_cards` (`app_title`, `app_icon`, `app_version`, `app_platform`, `app_source_url`, `app_description`, `app_download_url`) VALUES
('启原GS', 'https://ak-d.tripcdn.com/images/0Z04s4234d68mqaj408FB.jpg', '1.0', 'Windows', 'https://gitee.com/ibaizhan/kaiyuan-gs', '开发中，现处于高度保密中。。。', ''),
('润雨 MD5提取器', 'https://ak-d.tripcdn.com/images/0Z04x424x8u3rm1b52833.jpg', '1.1（完结版）', 'Windows', '', '用于获取文本或文件的MD5值的软件。（软件基本更新完毕，无BUG不更新）', 'https://gitee.com/ibaizhan/ziyuankuXbai/releases/download/Othersoftware/MD5%E8%8E%B7%E5%8F%96%E5%99%A8.exe'),
('希沃启动安装器', 'https://ak-d.tripcdn.com/images/0Z06q424x8u3s3317B51B.jpg', '1.1', 'Windows', 'https://gitee.com/ibaizhan/xiwo-startup-installer', '本软件用于替换希沃白板启动程序为第三方启动器，第三方启动器给用户提供了更高的diy性，大家可以自己制作启动主题。', 'https://gitee.com/ibaizhan/xiwo-startup-installer/releases/download/Data/%E5%B8%8C%E6%B2%83%E5%90%AF%E5%8A%A8%E5%AE%89%E8%A3%85%E5%99%A8.exe'),
('小草神表白墙', 'https://ak-d.tripcdn.com/images/0Z05d424x8u23hvtxFD62.jpg', '1.1', 'PHP+Html+JavaScript', 'https://gitee.com/ibaizhan/nahidalove', '基于樱振宇的樱花表白墙进行修改并二次开源的表白墙，可以理解为是樱花表白墙的一个UI+部分页面的性能和安全方面的优化的一个皮肤,本表白墙以纳西妲为主题中心进行开发，本源码非特殊情况不会再跟随原作者的更新，而是作为独立的源码存在。', 'https://gitee.com/ibaizhan/nahidalove');