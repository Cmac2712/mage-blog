<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre (steven.richardson@indez.com)
 */


class Cmac_Blog_Model_Blog extends Mage_Core_Model_Abstract {

    public function _construct() {
        parent::_construct();
        $this->_init('blog/blog');
    }

    public function getShortContent() {
        $content = $this->getData('short_content');
        if (Mage::getStoreConfig(Cmac_Blog_Helper_Config::XML_BLOG_PARSE_CMS)) {
            $processor = Mage::getModel('core/email_template_filter');
            $content = $processor->filter($content);
        }
        return $content;
    }

    public function getPostContent() {
        $content = $this->getData('post_content');
        if (Mage::getStoreConfig(Cmac_Blog_Helper_Config::XML_BLOG_PARSE_CMS)) {
            $processor = Mage::getModel('core/email_template_filter');
            $content = $processor->filter($content);
        }
        return $content;
    }

    public function _beforeSave() {
        if (is_array($this->getData('tags'))) {
            $this->setData('tags', implode(",", $this->getData('tags')));
        }
        return parent::_beforeSave();
    }

    public function getPostImages($desc)
    {
        //find the instances of img
        preg_match_all('/<img[^>]+>/i',$desc, $result);
        $img = array();
        //lets just send the first one back
        $returnedImage = $result[0][0];
        if(strpos($returnedImage, 'media url') > 0){
            //replace media url with the actual media url
            $returnedImage = Mage::helper('cms')->getBlockTemplateProcessor()->filter($returnedImage);
        }
        return $returnedImage;
    }

    public function timeElapsedString($ptime){
        $diff = time() - strtotime($ptime);
        $calc_times = array();
        $timeleft   = array();

        // Prepare array, depending on the output we want to get.
        $calc_times[] = array('Month',  'Months',  2592000);
        $calc_times[] = array('Day',    'Days',    86400);
        $calc_times[] = array('Hour',   'Hours',   3600);

        foreach ($calc_times AS $timedata){
            list($time_sing, $time_plur, $offset) = $timedata;

            if ($diff >= $offset){
                $left = floor($diff / $offset);
                $diff -= ($left * $offset);
                $timeleft[] = "{$left} " . ($left == 1 ? $time_sing : $time_plur);
            }
        }

        return $timeleft ? (time() > $ptime ? null : '-') . implode(' ', $timeleft) : 0;
    }

}
