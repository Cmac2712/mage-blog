<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre ()
 */


class Cmac_Blog_Block_Manage_Blog extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct() {
        $this->_controller = 'manage_blog';
        $this->_blockGroup = 'blog';
        $this->_headerText = Mage::helper('blog')->__('Blog Post Manager');
        parent::__construct();
        $this->setTemplate('aw_blog/posts.phtml');
    }

    protected function _prepareLayout() {
        $this->setChild('add_new_button', $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label' => Mage::helper('blog')->__('Add Post'),
                            'onclick' => "setLocation('" . $this->getUrl('*/*/new') . "')",
                            'class' => 'add'
                        ))
        );
        /**
         * Display store switcher if system has more one store
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->setChild('store_switcher', $this->getLayout()->createBlock('adminhtml/store_switcher')
                            ->setUseConfirm(false)
                            ->setSwitchUrl($this->getUrl('*/*/*', array('store' => null)))
            );
        }
        $this->setChild('grid', $this->getLayout()->createBlock('blog/manage_blog_grid', 'blog.grid'));
        return parent::_prepareLayout();
    }

    public function getAddNewButtonHtml() {
        return $this->getChildHtml('add_new_button');
    }

    public function getGridHtml() {
        return $this->getChildHtml('grid');
    }

    public function getStoreSwitcherHtml() {
        return $this->getChildHtml('store_switcher');
    }

}
