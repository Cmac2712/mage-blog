<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre (steven.richardson@indez.com)
 */


class Cmac_Blog_Model_Mysql4_Tag_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {

    protected $_previewFlag;

    protected function _construct() {
        $this->_init('blog/tag');
    }

    public function toOptionArray() {
        return $this->_toOptionArray('identifier', 'title');
    }

    public function addStoreFilter($store) {
        if (!Mage::app()->isSingleStoreMode()) {
            $id = $store->getId();
            $this->getSelect()->where('store_id=' . $id . ' OR store_id=0');
            return $this;
        }
        return $this;
    }

    public function addTagFilter($tag) {
        $this->getSelect()->where('tag=?', $tag);
        return $this;
    }

}
