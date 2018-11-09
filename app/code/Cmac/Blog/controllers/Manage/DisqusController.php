<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Indez_Blog
 * @copyright   Copyright (c) 2012 Indez Ltd. (http://www.indez.com)
 * @author Steven Richardson (steven.richardson@indez.com)
 */

class Indez_Blog_Manage_DisqusController extends Mage_Adminhtml_Controller_Action {

    /**
    * Redirect to external disqus admin panel
    */
    public function indexAction()
    {
    $url = 'http://disqus.com/admin/';
        $this->getResponse()->setRedirect($url);
    }

}
