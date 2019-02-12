<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre ()
 */


class Cmac_Blog_Block_Rss_List extends Mage_Rss_Block_List {

    public function getRssMiscFeeds() {
        parent::getRssMiscFeeds();
        $this->AWBlogFeed();
        return $this->getRssFeeds();
    }

    public function AWBlogFeed() {
        $route = Mage::helper('blog')->getRoute() . '/rss';
        $title = Mage::getStoreConfig('blogconfig/blog/title');
        $this->addRssFeed($route, $title);
        return $this;
    }

}
