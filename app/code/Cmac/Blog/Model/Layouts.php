<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre ()
 */


class Cmac_Blog_Model_Layouts {

    protected $_options = null;

    public function toOptionArray() {
        if ($this->_options === null) {
            $this->_options = array();
            foreach (Mage::getSingleton('page/config')->getPageLayouts() as $layout) {
                $this->_options[] = array(
                    'value' => $layout->getTemplate(),
                    'label' => $layout->getLabel(),
                );
            }
        }
        return $this->_options;
    }

}
