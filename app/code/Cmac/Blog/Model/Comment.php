<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Indez_Blog
 * @copyright   Copyright (c) 2012 Indez Ltd. (http://www.indez.com)
 * @author Steven Richardson (steven.richardson@indez.com)
 */


class Indez_Blog_Model_Comment extends Mage_Core_Model_Abstract {

    public function _construct() {
        $this->_init('blog/comment');
    }

    public function load($id, $field=null) {
        return parent::load($id, $field);
    }

}
