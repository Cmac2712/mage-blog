<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre ()
 */


class Cmac_Blog_Model_Comment extends Mage_Core_Model_Abstract {

    public function _construct() {
        $this->_init('blog/comment');
    }

    public function load($id, $field=null) {
        return parent::load($id, $field);
    }

}
