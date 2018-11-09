<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre (steven.richardson@indez.com)
 */
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('blog/lblog')}
	ADD `cat_id` TINYINT( 11 ) NOT NULL AFTER `post_id` ;
");

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('blog/lcat')};
CREATE TABLE {$this->getTable('blog_cat')} (
`cat_id` int( 11 ) unsigned NOT NULL AUTO_INCREMENT ,
`title` varchar( 255 ) NOT NULL default '',
`identifier` varchar( 255 ) NOT NULL default '',
`sort_order` tinyint ( 6 ) NOT NULL ,
`meta_keywords` text NOT NULL ,
`meta_description` text NOT NULL ,
PRIMARY KEY ( `cat_id` )
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO {$this->getTable('blog/lcat')} (
`cat_id` ,
`title`,
`identifier`
)
VALUES (
NULL , 'News', 'news'
);
");

$installer->endSetup();
