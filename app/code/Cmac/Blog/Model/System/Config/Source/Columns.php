<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre (steven.richardson@indez.com)
 */


class Cmac_Blog_Model_System_Config_Source_Columns {

    public function toOptionArray() {
        return array(
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Yes, all pages')),
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Yes, only blog page')),
            array('value' => 0, 'label' => Mage::helper('adminhtml')->__('No')),
        );
    }

}
