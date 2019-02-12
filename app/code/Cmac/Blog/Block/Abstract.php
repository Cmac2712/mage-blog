<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre ()
 */


class Cmac_Blog_Block_Abstract extends Mage_Core_Block_Template {

    protected function _processCollection($collection, $category = false) {

        $route = Mage::helper('blog')->getRoute();

        foreach ($collection as $item) {

            /* Escape tags */
           Cmac_Blog_Helper_Data::escapeSpecialChars($item);


            if ($category) {
                if (Mage::getStoreConfig('blogconfig/blog/categories_urls')) {
                    $item->setAddress($this->getUrl($route . '/cat/' . $this->getCat()->getIdentifier() . '/post/' . $item->getIdentifier()));
                } else {
                    $item->setAddress($this->getUrl($route . "/" . $item->getIdentifier()));
                }
            } else {
                $item->setAddress($this->getUrl($route . "/" . $item->getIdentifier()));
            }

            $item->setCreatedTime($this->formatTime($item->getCreatedTime(), Mage::getStoreConfig('blogconfig/blog/dateformat'), true));
            $item->setUpdateTime($this->formatTime($item->getUpdateTime(), Mage::getStoreConfig('blogconfig/blog/dateformat'), true));

            if (Mage::getStoreConfig(Cmac_Blog_Helper_Config::XML_BLOG_USESHORTCONTENT) && trim($item->getShortContent())) {
                $content = trim($item->getShortContent());
                $content = $this->closetags($content);
                $content .= ' <a href="' . $this->getUrl($route . "/" . $item->getIdentifier()) . '" >' . $this->__('Read More') . '</a>';
                $item->setPostContent($content);
            } elseif ((int) Mage::getStoreConfig(Cmac_Blog_Helper_Config::XML_BLOG_READMORE) != 0) {

                $content = $item->getPostContent();
                $strManager = new Cmac_Blog_Helper_Substring(array('input' => Mage::helper('blog')->filterWYS($content)));
                $content = $strManager->getHtmlSubstr((int) Mage::getStoreConfig(Cmac_Blog_Helper_Config::XML_BLOG_READMORE));

                if ($strManager->getSymbolsCount() == Mage::getStoreConfig(Cmac_Blog_Helper_Config::XML_BLOG_READMORE)) {
                    $content .= ' <a href="' . $this->getUrl($route . "/" . $item->getIdentifier()) . '" >' . $this->__('Read More') . '</a>';
                }
                $item->setPostContent($content);
            }


            $comments = Mage::getModel('blog/comment')->getCollection()
                    ->addPostFilter($item->getPostId())
                    ->addApproveFilter(2);
            $item->setCommentCount(count($comments));

            $post = Mage::getModel('blog/post')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($item->getPostId(), 'post_id');

            $item->setCats($post->getCats());
        }


        if ($category) {

            $this->setData('cat', $collection);
            return $this->getData('cat');
        }


        return $collection;
    }

    public function getBookmarkHtml($post) {
        if (Mage::getStoreConfig('blogconfig/blog/bookmarkslist')) {
            $this->setTemplate('aw_blog/bookmark.phtml');
            $this->setPost($post);
            return $this->toHtml();
        }
        return;
    }

    public function getTagsHtml($post) {

        if (trim($post->getTags())) {
            $this->setTemplate('aw_blog/line_tags.phtml');
            $this->setPost($post);
            return $this->toHtml();
        }
        return;
    }

    public function getCommentsEnabled() {
        return Mage::getStoreConfig('blogconfig/comments/enabled');
    }

    public function getPagesCollection($mode, $params = array()) {

        if ((int) Mage::getStoreConfig('blogconfig/blog/perpage') != 0) {

            if ($mode == 'list') {
                $bool = false;
            } else {
                $bool = true;
            }

            $pager = Mage::getConfig()->getBlockClassName('blog/pager');
            $pager = new $pager();
            $pager->setTemplate('aw_blog/pager/list.phtml');
            $pager->setCategoryMode($bool);


            foreach ($params as $key => $param) {
                $pager->{$key}($param);
            }

            return $pager->renderView();
        }
    }

    public function addTopLink() {
        if (Mage::helper('blog')->getEnabled()) {
            $route = Mage::helper('blog')->getRoute();
            $title = Mage::getStoreConfig('blogconfig/blog/title');
            $this->getParentBlock()->addLink($title, $route, $title, true, array(), 15, null, 'class="top-link-blog"');
        }
    }

    public function addFooterLink() {
        if (Mage::helper('blog')->getEnabled()) {
            $route = Mage::helper('blog')->getRoute();
            $title = Mage::getStoreConfig('blogconfig/blog/title');
            $this->getParentBlock()->addLink($title, $route, $title, true);
        }
    }

    public function closetags($html) {
        return Mage::helper('blog/post')->closetags($html);
    }

    protected function _prepareCollection($customFilters = array()) {

        if (!$this->getCachedCollection()) {

            $collection = Mage::getModel('blog/blog')->getCollection()
                    ->addPresentFilter()
                    ->addStoreFilter(Mage::app()->getStore()->getId())
                    ->setOrder('created_time ', 'desc');

            if (!empty($customFilters)) {
                foreach ($customFilters as $filter => $value) {
                    $collection->{$filter}($value);
                }
            }

            $page = $this->getRequest()->getParam('page');
            Mage::getSingleton('blog/status')->addEnabledFilterToCollection($collection);
            $collection->setPageSize((int) Mage::getStoreConfig(Cmac_Blog_Helper_Config::XML_BLOG_PERPAGE));
            $collection->setCurPage($page);

            $this->setCachedCollection($collection);
        }

        return $this->getCachedCollection();
    }

}
