<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Indez_Blog
 * @copyright   Copyright (c) 2012 Indez Ltd. (http://www.indez.com)
 * @author Steven Richardson (steven.richardson@indez.com)
 */
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('blog/lblog')} CHANGE `content` `post_content` TEXT NOT NULL;
");
$installer->endSetup();
