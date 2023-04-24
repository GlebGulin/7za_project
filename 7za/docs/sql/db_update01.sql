DROP TABLE `za_news`;
CREATE TABLE `za_articles` (
  `article_id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `image_file_id` bigint(20) unsigned NOT NULL default '0',
  `added_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `visible` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;


CREATE TABLE `za_news` (
  `news_id` int(10) unsigned NOT NULL auto_increment,
  `title_rus` varchar(255) NOT NULL,
  `title_ukr` varchar(255) NOT NULL,
  `text_rus` text NOT NULL,
  `text_ukr` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `visible` tinyint(1) unsigned NOT NULL default '0',
  `image_file_id` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251;
