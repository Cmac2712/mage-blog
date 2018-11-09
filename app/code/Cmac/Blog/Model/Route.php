<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre (steven.richardson@indez.com)
 */


class Cmac_Blog_Model_Route extends Mage_Core_Model_Config_Data {

    public function toOptionArray() {
        $options = array();
        return $options;
    }

    protected function _beforeSave() {
        $value = $this->getValue();
        if (trim($value) == "") {
            $value = "blog";
        }
        $this->setValue($value);
        return $this;
    }

}
