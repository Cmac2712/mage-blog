<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Indez_Blog
 * @copyright   Copyright (c) 2012 Indez Ltd. (http://www.indez.com)
 * @author Steven Richardson (steven.richardson@indez.com)
 */


class Indez_Blog_Block_Pager extends Mage_Core_Block_Template {

    public function getCollection() {

        if ($this->getData('collection')) {
            return $this->getData('collection');
        }

        $collection = Mage::getModel('blog/blog')->getCollection()
                ->addPresentFilter()
                ->addStoreFilter()
                ->setOrder('created_time ', 'desc');

        $tagFilter = '';
        if ($tag = $this->getRequest()->getParam('tag')) {
            $collection->addTagFilter(urldecode($tag));
            $tagFilter = "/tag/{$tag}/";
        }

        $this->setTagFilter($tagFilter);

        Mage::getSingleton('blog/status')->addEnabledFilterToCollection($collection);

        if ($this->getCategoryMode()) {

            Mage::getSingleton('blog/status')->addCatFilterToCollection($collection, $this->getCatId());
        }

        $this->setData('collection', $collection);

        return $this->getData('collection');
    }

    public function getCurrentPage() {

        $currentPage = (int) $this->getRequest()->getParam('page');
        if (!$currentPage) {
            $currentPage = 1;
        }

        return $currentPage;
    }

    public function getPagesCount() {

        return ceil($this->getCollection()->count() / (int) Mage::getStoreConfig('blogconfig/blog/perpage'));
    }

}
