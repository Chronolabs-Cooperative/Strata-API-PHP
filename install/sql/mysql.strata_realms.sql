
# Table structure for table `strata_realms`
#

CREATE TABLE `strata_realms` (
  `id` mediumint(64) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL default 0,
  `active` enum('Yes','Suspended','Offline','unknown') NOT NULL default 'unknown',
  `typal` enum('Realm','TLD','gTLD','unknown') NOT NULL default 'unknown',
  `realm` varchar(196) NOT NULL default '',
  `md5` varchar(32) NOT NULL default '',
  `email` mediumtext,
  `email-md5` varchar(32) NOT NULL default '',
  `history` longtext,
  `stored` int(13) NOT NULL default 0,
  `updated` int(13) NOT NULL default 0,
  PRIMARY KEY  (`id`),
  KEY typalstored (`typal`,`stored`),
  KEY md5emailmd5stored (`md5`,`email-md5`,`stored`)
) ENGINE=INNODB;
