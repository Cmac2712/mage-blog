<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre (steven.richardson@indez.com)
 */


class Cmac_Blog_Block_Cat extends Cmac_Blog_Block_Abstract {

    public function getPosts() {

        $cats = Mage::getSingleton('blog/cat');

        if ($cats->getCatId() === NULL) {
            return false;
        }

        $collection = parent::_prepareCollection(array('addCatFilter' => $cats->getCatId()));
        parent::_processCollection($collection, $categoryMode = true);

        return $collection;
    }

    public function getCat() {
        $cats = Mage::getSingleton('blog/cat');
        return $cats;
    }

    public function getPages() {

        echo parent::getPagesCollection('category', array('setCatId' => $this->getCat()->getId()));
    }

    protected function _prepareLayout() {

        $post = $this->getCat();

        $route = Mage::helper('blog')->getRoute();

        // show breadcrumbs
        if (Mage::getStoreConfig('blogconfig/blog/blogcrumbs') && ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs'))) {
            $breadcrumbs->addCrumb('home', array('label' => Mage::helper('blog')->__('Home'), 'title' => Mage::helper('blog')->__('Go to Home Page'), 'link' => Mage::getBaseUrl()));
            ;
            $breadcrumbs->addCrumb('blog', array('label' => Mage::getStoreConfig('blogconfig/blog/title'), 'title' => Mage::helper('blog')->__('Return to ' . Mage::getStoreConfig('blogconfig/blog/title')), 'link' => Mage::getUrl($route)));
            $breadcrumbs->addCrumb('blog_page', array('label' => $post->getTitle(), 'title' => $post->getTitle()));
        }

        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setTitle($post->getTitle());
            $head->setKeywords($post->getMetaKeywords());
            $head->setDescription($post->getMetaDescription());
        }
    }

    protected function _toHtml() {
        return Mage::helper('blog')->filterWYS(parent::_toHtml());
    }

}
