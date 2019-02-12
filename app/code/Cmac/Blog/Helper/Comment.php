<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre ()
 */


class Cmac_Blog_Helper_Comment extends Mage_Core_Helper_Abstract {

    public function renderPage(Mage_Core_Controller_Front_Action $action, $identifier=null, $data) {
        $page = Mage::getSingleton('blog/blog');
        if (!is_null($identifier) && $identifier !== $page->getId()) {
            $page->setStoreId(Mage::app()->getStore()->getId());
            if (!$page->load($identifier)) {
                return false;
            }
        }

        if (!$page->getId()) {
            return false;
        }
        if ($page->getStatus() == 2) {
            return false;
        }
        $page_title = Mage::getSingleton('blog/blog')->load($identifier)->getTitle();
        $blog_title = Mage::getStoreConfig('blogconfig/blog/title') . " - ";

        $action->loadLayout();
        if ($storage = Mage::getSingleton('customer/session')) {
            $action->getLayout()->getMessagesBlock()->addMessages($storage->getMessages(true));
        }
        /*
          if (Mage::getStoreConfig('blog/rss/enable'))
          {
          Mage::helper('blog')->addRss($action->getLayout()->getBlock('head'), Mage::getUrl(Mage::getStoreConfig('blogconfig/blog/route')) . "rss");
          }
         */
        $action->getLayout()->getBlock('head')->setTitle($blog_title . $page_title);
        $action->getLayout()->getBlock('root')->setTemplate(Mage::getStoreConfig('blogconfig/blog/layout'));
        $action->getLayout()->getBlock('post')->setCommentDetails($data['user'], $data['email'], $data['comment']);
        $action->renderLayout();

        return true;
    }

}
