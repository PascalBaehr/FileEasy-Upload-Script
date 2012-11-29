CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}dlsession` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(40) NOT NULL,
  `access_id` varchar(13) NOT NULL,
  `ip_address` varchar(15) NOT NULL DEFAULT 'UNKNOWN',
  `expiry` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}files` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `access_id` varchar(13) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `expiry` int(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `ip_address` varchar(15) NOT NULL DEFAULT 'UNKNOWN',
  `timestamp` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `{TABLE_PREFIX}settings` (
  `setting` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`setting`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

