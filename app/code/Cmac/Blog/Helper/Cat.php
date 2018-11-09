<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Indez_Blog
 * @copyright   Copyright (c) 2012 Indez Ltd. (http://www.indez.com)
 * @author Steven Richardson (steven.richardson@indez.com)
 */


class Indez_Blog_Helper_Cat extends Mage_Core_Helper_Abstract {

    /**
     * Renders CMS page
     *
     * Call from controller action
     *
     * @param Mage_Core_Controller_Front_Action $action
     * @param integer $pageId
     * @return boolean
     */
    public function renderPage(Mage_Core_Controller_Front_Action $action, $identifier=null) {
        if (!$cat_id = Mage::getSingleton('blog/cat')->load($identifier)->getcatId()) {
            return false;
        }

        $page_title = Mage::getSingleton('blog/cat')->load($identifier)->getTitle();
        $blog_title = Mage::getStoreConfig('blogconfig/blog/title') . " - ";

        $action->loadLayout();
        if ($storage = Mage::getSingleton('customer/session')) {
            $action->getLayout()->getMessagesBlock()->addMessages($storage->getMessages(true));
        }
        $action->getLayout()->getBlock('head')->setTitle($blog_title . $page_title);
        /*
          if (Mage::getStoreConfig('blog/rss/enable'))
          {
          Mage::helper('blog')->addRss($action->getLayout()->getBlock('head'), Mage::getUrl(Mage::getStoreConfig('blogconfig/blog/route') . "/cat/" .$identifier) . "rss");
          }
         */
        $action->getLayout()->getBlock('root')->setTemplate(Mage::getStoreConfig('blogconfig/blog/layout'));
        $action->renderLayout();

        return true;
    }

}
