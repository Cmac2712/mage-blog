<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre (steven.richardson@indez.com)
 */


class Cmac_Blog_Helper_Data extends Mage_Core_Helper_Abstract {
    const XML_PATH_ENABLED = 'blogconfig/blog/enabled';
    const XML_PATH_TITLE = 'blogconfig/blog/title';
    const XML_PATH_MENU_LEFT = 'blogconfig/blog/menuLeft';
    const XML_PATH_MENU_RIGHT = 'blogconfig/blog/menuRoght';
    const XML_PATH_FOOTER_ENABLED = 'blogconfig/blog/footerEnabled';
    const XML_PATH_LAYOUT = 'blogconfig/blog/layout';
    
    const XML_DISQUS_ENABLED = 'blogconfig/disqus/enabled';
    const XML_DISQUS_SHORTNAME = 'blogconfig/disqus/disqus_shortname';

    
    public function getDisqusEnabled() {
        return Mage::getStoreConfig(self::XML_DISQUS_ENABLED);
    }

    public function getDisqusShortname() {
        return Mage::getStoreConfig(self::XML_DISQUS_SHORTNAME);
    }
       
    public function isEnabled() {
        return Mage::getStoreConfig(self::XML_PATH_ENABLED);
    }

    public function isTitle() {
        return Mage::getStoreConfig(self::XML_PATH_TITLE);
    }

    public function isMenuLeft() {
        return Mage::getStoreConfig(self::XML_PATH_MENU_LEFT);
    }

    public function isMenuRight() {
        return Mage::getStoreConfig(self::XML_PATH_MENU_RIGHT);
    }

    public function isFooterEnabled() {
        return Mage::getStoreConfig(self::XML_PATH_FOOTER_ENABLED);
    }

    public function isLayout() {
        return Mage::getStoreConfig(self::XML_PATH_LAYOUT);
    }

    public function getUserName() {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        return trim("{$customer->getFirstname()} {$customer->getLastname()}");
    }

    public function getRoute($store = null) {

        $route = Mage::getStoreConfig('blogconfig/blog/route', $store);
        if (!$route) {
            $route = "blog";
        }
        return $route;
    }

    public function getStoreIdByCode($storeCode) {
        foreach (Mage::app()->getStore()->getCollection() as $store) {
            if ($storeCode == $store->getCode()) {
                return $store->getId();
            }
        }
        return false;
    }

    public function getEnabled() {
        return Mage::getStoreConfig('blogconfig/blog/enabled') && $this->extensionEnabled('Cmac_Blog');
    }

    public function getUserEmail() {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        return $customer->getEmail();
    }

    /*
     * Recursively searches and replaces all occurrences of search in subject values replaced with the given replace value
     * @param string $search The value being searched for
     * @param string $replace The replacement value
     * @param array $subject Subject for being searched and replaced on
     * @return array Array with processed values
     */

    public function recursiveReplace($search, $replace, $subject) {
        if (!is_array($subject))
            return $subject;

        foreach ($subject as $key => $value)
            if (is_string($value))
                $subject[$key] = str_replace($search, $replace, $value);
            elseif (is_array($value))
                $subject[$key] = self::recursiveReplace($search, $replace, $value);

        return $subject;
    }

    public function extensionEnabled($extension_name) {
        $modules = (array) Mage::getConfig()->getNode('modules')->children();
        if (!isset($modules[$extension_name])
                || $modules[$extension_name]->descend('active')->asArray() == 'false'
                || Mage::getStoreConfig('advanced/modules_disable_output/' . $extension_name)
        )
            return false;
        return true;
    }

    public function addRss($head, $path) {
        if ($head instanceof Mage_Page_Block_Html_Head)
            $head->addItem("rss", $path, 'title="' . Mage::getStoreConfig(self::XML_PATH_TITLE) . '"');
    }

    public function getRssEnabled() {
        return (Mage::getStoreConfigFlag('blogconfig/rss/enable') && Mage::getStoreConfigFlag('rss/config/active'));
    }

    public function convertSlashes($tag, $direction = 'back') {

        if ($direction == 'forward') {
            $tag = preg_replace("#/#is", "&#47;", $tag);
            $tag = preg_replace("#\\\#is", "&#92;", $tag);
            return $tag;
        }

        $tag = str_replace("&#47;", "/", $tag);
        $tag = str_replace("&#92;", "\\", $tag);

        return $tag;
    }

    public function filterWYS($text) {
        $processorModelName = version_compare(Mage::getVersion(), '1.3.3.0', '>') ? 'widget/template_filter' : 'core/email_template_filter';
        $processor = Mage::getModel($processorModelName);
        if ($processor instanceof Mage_Core_Model_Email_Template_Filter) {
            return $processor->filter($text);
        }
        return $text;
    }

    public function magentoLess14() {

        return version_compare(Mage::getVersion(), '1.4', '<');
    }

    public static function escapeSpecialChars($post) {

        $post->setTitle(htmlspecialchars($post->getTitle()));
    }

    public function ifStoreChangedRedirect() {
        
        $path = Mage::app()->getRequest()->getPathInfo();
        
        $helper = Mage::helper('blog');
        $currentRoute = $helper->getRoute();
        
        $fromStore = Mage::app()->getRequest()->getParam('___from_store');
        if ($fromStore) {

            $fromStoreId = $helper->getStoreIdByCode($fromStore);
            $fromRoute = $helper->getRoute($fromStoreId);

            $url = preg_replace("#$fromRoute#si", $currentRoute, $path, 1);
            $url = Mage::getBaseUrl() . ltrim($url, '/');

            Mage::app()->getFrontController()->getResponse()
                    ->setRedirect($url)
                    ->sendResponse();
            exit;
        }
    }

}
