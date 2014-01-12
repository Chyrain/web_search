CREATE DATABASE IF NOT EXISTS `blogdata`;
USE `blogdata`;

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL,
  `updatetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `sina_documents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `link_id` int(11) unsigned NOT NULL,
  `url` varchar(250) NOT NULL,
  `hits` mediumint(8) unsigned DEFAULT '0',
  `title` varchar(300) NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `fullcontent` mediumtext NOT NULL,
  `updatetime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;