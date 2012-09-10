CREATE TABLE IF NOT EXISTS `#__linkcomp_competition` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `description` text,
  `published` tinyint(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `linktext` varchar(255) DEFAULT NULL,
  `linkurl` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `#__linkcomp_contestant` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `competition_id` int(11) unsigned NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `site_url` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `#__linkcomp_winner` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contestant_id` int(11) unsigned NOT NULL,
  `competition_id` int(11) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  `contacted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

