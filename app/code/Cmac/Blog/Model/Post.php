<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Indez_Blog
 * @copyright   Copyright (c) 2012 Indez Ltd. (http://www.indez.com)
 * @author Steven Richardson (steven.richardson@indez.com)
 */


class Indez_Blog_Model_Post extends Mage_Core_Model_Abstract {
    const NOROUTE_PAGE_ID = 'no-route';

    protected function _construct() {
        $this->_init('blog/post');
    }

    public function load($id, $field=null) {
        return $post = parent::load($id, $field);
    }

    public function noRoutePage() {
        $this->setData($this->load(self::NOROUTE_PAGE_ID, $this->getIdFieldName()));
        return $this;
    }

    public function getShortContent() {
        $content = $this->getData('short_content');
        if (Mage::getStoreConfig(Indez_Blog_Helper_Config::XML_BLOG_PARSE_CMS)) {
            $processor = Mage::getModel('core/email_template_filter');
            $content = $processor->filter($content);
        }
        return $content;
    }

    public function getPostContent() {
        $content = $this->getData('post_content');
        if (Mage::getStoreConfig(Indez_Blog_Helper_Config::XML_BLOG_PARSE_CMS)) {
            $processor = Mage::getModel('core/email_template_filter');
            $content = $processor->filter($content);
        }
        return $content;
    }

    public function loadByIdentifier($v) {
        return $this->load($v, 'identifier');
    }

    public function getCats() {

        $route = Mage::getStoreConfig('blogconfig/blog/route');
        if ($route == "") {
            $route = "blog";
        }
        $route = Mage::getUrl($route);

        $cats = Mage::getModel('blog/cat')->getCollection()
                ->addPostFilter($this->getId())
                ->addStoreFilter(Mage::app()->getStore()->getId());

        $catUrls = array();
        foreach ($cats as $cat) {
            $catUrls[$cat->getTitle()] = $route . "cat/" . $cat->getIdentifier();
        }
        return $catUrls;
    }

}