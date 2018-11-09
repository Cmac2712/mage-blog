<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Indez_Blog
 * @copyright   Copyright (c) 2012 Indez Ltd. (http://www.indez.com)
 * @author Steven Richardson (steven.richardson@indez.com)
 */


class Indez_Blog_Model_Mysql4_Tag extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct() {
        $this->_init('blog/tag', 'id');
    }

}
