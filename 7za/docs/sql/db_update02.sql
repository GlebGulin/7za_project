ALTER TABLE `za_articles` ADD `category_id` INT UNSIGNED DEFAULT '0' NOT NULL ;

CREATE TABLE `za_articles_categories` (
  `category_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `position` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='Article categories';