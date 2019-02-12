<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre ()
 */


class Cmac_Blog_Model_Mysql4_Tag extends Mage_Core_Model_Mysql4_Abstract {

    protected function _construct() {
        $this->_init('blog/tag', 'id');
    }

}
