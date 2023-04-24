-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Июл 24 2008 г., 15:32
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.6
-- 
-- БД: `7za`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `za_comments`
-- 

CREATE TABLE `za_comments` (
  `comment_id` bigint(20) unsigned NOT NULL auto_increment,
  `item_id` bigint(20) unsigned NOT NULL,
  `author` varchar(128) NOT NULL,
  `author_ip` varchar(32) NOT NULL,
  `added_time` datetime NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  PRIMARY KEY  (`comment_id`),
  KEY `item_id` (`item_id`),
  KEY `added_time` (`added_time`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='Comments for products' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_comments`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_mm_files`
-- 

CREATE TABLE `za_mm_files` (
  `file_id` bigint(20) unsigned NOT NULL auto_increment,
  `file_name` varchar(128) NOT NULL default '',
  `file_type` varchar(32) NOT NULL default '',
  `file_url` varchar(32) NOT NULL default '',
  `file_path` varchar(32) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `attributes` varchar(255) NOT NULL default '',
  `added_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `type` varchar(16) NOT NULL default '',
  `mtt_id` bigint(20) unsigned NOT NULL default '0',
  `user_id` bigint(20) unsigned NOT NULL default '0',
  `group` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='MediaManager files info' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_mm_files`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_news`
-- 

CREATE TABLE `za_news` (
  `news_id` bigint(20) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `news_date` date NOT NULL default '0000-00-00',
  `news_text` text NOT NULL,
  `shown` enum('0','1') NOT NULL default '0',
  `image_file_id` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='News' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_news`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_order_products`
-- 

CREATE TABLE `za_order_products` (
  `order_id` bigint(20) unsigned NOT NULL default '0',
  `product_id` bigint(20) NOT NULL default '0',
  `product_qnt` int(10) unsigned default NULL,
  `product_price` decimal(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`order_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `za_order_products`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_order_status`
-- 

CREATE TABLE `za_order_status` (
  `status_id` tinyint(1) unsigned NOT NULL auto_increment,
  `status_name` varchar(255) default '0',
  PRIMARY KEY  (`status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_order_status`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_orders`
-- 

CREATE TABLE `za_orders` (
  `order_id` bigint(20) unsigned NOT NULL auto_increment,
  `surname` varchar(255) NOT NULL default '0',
  `firstname` varchar(255) NOT NULL default '0',
  `lastname` varchar(255) NOT NULL default '0',
  `added_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `email` varchar(255) NOT NULL default '0',
  `password` varchar(255) NOT NULL default '0',
  `status_id` int(10) unsigned NOT NULL default '1',
  `phone` varchar(255) NOT NULL default '0',
  `fax` varchar(255) default '0',
  `ind` varchar(255) NOT NULL default '0',
  `region` varchar(255) default '0',
  `district` varchar(255) default '0',
  `city` varchar(128) NOT NULL,
  `street` varchar(255) NOT NULL default '0',
  `number` varchar(255) NOT NULL default '0',
  `building` varchar(255) default '0',
  `office` varchar(255) default '0',
  `entrance` varchar(255) default '0',
  `code` varchar(255) default '0',
  `floor` varchar(255) default '0',
  `comment` text,
  `company` varchar(255) NOT NULL default '',
  `legal_address` varchar(255) NOT NULL default '',
  `postal_address` varchar(255) NOT NULL default '',
  `inn` varchar(255) NOT NULL default '',
  `kpp` varchar(255) NOT NULL default '',
  `okpo` varchar(255) NOT NULL default '',
  `bank_name` varchar(255) NOT NULL default '',
  `settl_account` varchar(255) NOT NULL default '',
  `corr_account` varchar(255) NOT NULL default '',
  `bik` varchar(255) NOT NULL default '',
  `ssnumber` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_orders`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_pages`
-- 

CREATE TABLE `za_pages` (
  `page_id` int(10) unsigned NOT NULL auto_increment,
  `page_parent_id` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `include_module` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `position` int(10) unsigned NOT NULL default '0',
  `visible` tinyint(1) unsigned NOT NULL default '0',
  `forbid_remove` tinyint(1) unsigned NOT NULL default '0',
  `in_menu` tinyint(1) unsigned NOT NULL default '1',
  `has_print_link` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

-- 
-- Дамп данных таблицы `za_pages`
-- 

INSERT INTO `za_pages` VALUES (1, 0, 'Главная', '', '', '', 1, 1, 1, 1, 0);

-- --------------------------------------------------------

-- 
-- Структура таблицы `za_parameters`
-- 

CREATE TABLE `za_parameters` (
  `parameter_id` bigint(20) unsigned NOT NULL auto_increment,
  `group_id` int(10) unsigned NOT NULL default '0',
  `parameter_name` varchar(255) default NULL,
  `unit` varchar(255) default NULL,
  `is_header` tinyint(1) unsigned NOT NULL default '0',
  `use_in_search` tinyint(1) unsigned default '0',
  `position` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`parameter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_parameters`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_parameters_groups`
-- 

CREATE TABLE `za_parameters_groups` (
  `group_id` int(10) unsigned NOT NULL auto_increment,
  `group_name` varchar(255) default NULL,
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_parameters_groups`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_parameters_values`
-- 

CREATE TABLE `za_parameters_values` (
  `parameter_id` bigint(20) unsigned NOT NULL default '0',
  `product_id` bigint(20) unsigned NOT NULL default '0',
  `value` varchar(255) default NULL,
  PRIMARY KEY  (`parameter_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

-- 
-- Дамп данных таблицы `za_parameters_values`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_product`
-- 

CREATE TABLE `za_product` (
  `product_id` bigint(20) unsigned NOT NULL auto_increment,
  `linked_to_product` bigint(20) unsigned NOT NULL,
  `subcategory_id` int(10) unsigned NOT NULL default '0',
  `product_name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `image_file_id` bigint(20) unsigned NOT NULL default '0',
  `add_photos` varchar(255) NOT NULL,
  `added_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `price` decimal(10,2) NOT NULL default '0.00',
  `shown` tinyint(1) unsigned NOT NULL default '0',
  `position` bigint(20) unsigned NOT NULL default '0',
  `view` bigint(20) unsigned default '0',
  `conn_goods` varchar(255) default NULL,
  `discount` int(11) NOT NULL default '0',
  `discount_start` date NOT NULL default '0000-00-00',
  `discount_finish` date NOT NULL default '0000-00-00',
  `absent` tinyint(1) unsigned NOT NULL default '0',
  `special_offer` tinyint(1) unsigned NOT NULL default '0',
  `recommended` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_product`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_product_categories`
-- 

CREATE TABLE `za_product_categories` (
  `category_id` int(10) unsigned NOT NULL auto_increment,
  `category_name` varchar(255) NOT NULL default '',
  `position` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='Product categories' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_product_categories`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_product_subcategories`
-- 

CREATE TABLE `za_product_subcategories` (
  `subcategory_id` int(10) unsigned NOT NULL auto_increment,
  `category_id` int(10) unsigned NOT NULL default '0',
  `subcategory_name` varchar(255) NOT NULL default '',
  `image_file_id` bigint(20) unsigned NOT NULL default '0',
  `position` int(10) unsigned NOT NULL default '0',
  `hidden` tinyint(1) unsigned NOT NULL default '0',
  `marked` tinyint(1) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`subcategory_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='Product subcategories' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_product_subcategories`
-- 


-- --------------------------------------------------------

-- 
-- Структура таблицы `za_registry`
-- 

CREATE TABLE `za_registry` (
  `option_id` bigint(20) unsigned NOT NULL auto_increment,
  `application` varchar(64) NOT NULL default '',
  `module` varchar(64) NOT NULL default '',
  `name` varchar(64) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`option_id`),
  UNIQUE KEY `application` (`application`,`module`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 COMMENT='Registry module table' AUTO_INCREMENT=1 ;

-- 
-- Дамп данных таблицы `za_registry`
-- 

        