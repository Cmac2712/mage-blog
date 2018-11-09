<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Indez_Blog
 * @copyright   Copyright (c) 2012 Indez Ltd. (http://www.indez.com)
 * @author Steven Richardson (steven.richardson@indez.com)
 */


class Indez_Blog_Model_Route extends Mage_Core_Model_Config_Data {

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
