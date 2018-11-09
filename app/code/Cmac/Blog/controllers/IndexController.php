<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Indez_Blog
 * @copyright   Copyright (c) 2012 Indez Ltd. (http://www.indez.com)
 * @author Steven Richardson (steven.richardson@indez.com)
 */

class Indez_Blog_IndexController extends Mage_Core_Controller_Front_Action {

    public function preDispatch() {
        parent::preDispatch();
        if (!Mage::helper('blog')->getEnabled()) {
            $this->_redirectUrl(Mage::helper('core/url')->getHomeUrl());
        }

        Mage::helper('blog')->ifStoreChangedRedirect();
    }

    public function indexAction() {

        $this->loadLayout();

        $this->getLayout()->getBlock('root')->setTemplate(Mage::getStoreConfig('blogconfig/blog/layout'));

        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setTitle(Mage::getStoreConfig('blogconfig/blog/title'));
            $head->setKeywords(Mage::getStoreConfig('blogconfig/blog/keywords'));
            $head->setDescription(Mage::getStoreConfig('blogconfig/blog/description'));
            /*
              if (Mage::getStoreConfig('blogconfig/rss/enable')) {
              $route = Mage::helper('blog')->getRoute();
              Mage::helper('blog')->addRss($head, Mage::getUrl($route) . "rss");
              }
             */
        }
        $this->renderLayout();
    }

    public function listAction() {

        $this->loadLayout();

        $this->getLayout()->getBlock('root')->setTemplate(Mage::getStoreConfig('blogconfig/blog/layout'));

        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setTitle(Mage::getStoreConfig('blogconfig/blog/title'));
            $head->setKeywords(Mage::getStoreConfig('blogconfig/blog/keywords'));
            $head->setDescription(Mage::getStoreConfig('blogconfig/blog/description'));
            /*
              if (Mage::getStoreConfig('blog/rss/enable')) {
              $route = Mage::helper('blog')->getRoute();
              if($tag = $this->getRequest()->getParam('tag')) {
              Mage::helper('blog')->addRss($head, Mage::getUrl($route) . "tag/$tag/" . "rss");
              }else {
              Mage::helper('blog')->addRss($head, Mage::getUrl($route) . "rss");
              }
              }
             */
        }
        $this->renderLayout();
    }

}
