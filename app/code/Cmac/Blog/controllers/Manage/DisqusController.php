<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre ()
 */

class Cmac_Blog_Manage_DisqusController extends Mage_Adminhtml_Controller_Action {

    /**
    * Redirect to external disqus admin panel
    */
    public function indexAction()
    {
    $url = 'http://disqus.com/admin/';
        $this->getResponse()->setRedirect($url);
    }

}
