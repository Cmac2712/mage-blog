<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre (steven.richardson@indez.com)
 */


class Cmac_Blog_Helper_Home extends Mage_Core_Helper_Abstract {


    public function __construct() {


    }

    public function getLatestPost($category) {
        
        $data = array();

        $collection = Mage::getModel('blog/blog')->getCollection()
            ->addPresentFilter()
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->addCatsFilter($category)
            ->setOrder('created_time ', 'desc');

        $i = 0;
        foreach ($collection as $post) {

            if ($i == 1)
                break;

            $html .= '<a href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'blog/'.$post->getIdentifier().'"><span>'.$post->getTitle().'</span></a>';

            ++$i;
        }

        return $html;

    }

    public function getCompPosts($limit = 2) {

        $collection = Mage::getModel('blog/blog')->getCollection()
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->addCatsFilter(6)
            ->addFieldToFilter('status', '1')
            ->setOrder('created_time ', 'desc');

		$collection->getSelect()->limit($limit);
        
        return $collection;
    }
	
	public function showCompPosts($collection){
        $i = 1;
        $html = '';
        foreach ($collection as $post) {
			$img = null;
            $content = $post->getPostContent();

            $subject = $content;
            $pattern = '/({{media url="([A-Za-z0-9\/\.]+))/';
			$pattern2 = '/<img[^>]*\/?>/';
            if (preg_match($pattern, $subject, $matches)){
				$img = '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$matches[2].'" alt="Compition" />';
				
			} else if(preg_match($pattern2, $subject, $matches))
			{
				$img = $matches[0];
			}
			
			// Description 
			$slug = '';
			if(preg_match('@<p[^>]*>(.*?)</p>@', $content, $matches))
			{
				$slug = strip_tags($matches[1]);
			}


			$html .= '<div class="img">';
			$html .= '<div class="relative">';
			$html .= $img;
			$html .= '<a href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'blog/'.$post->getIdentifier().'"><span>'.$post->getTitle().'</span></a>';
			$html .= '</div>';
			$html .= '</div>';
			if($slug){
				$html .= '<p class="crash">'.$slug.'</p>';
			}


            ++$i;
        }
        return $html;
    }


    public function getEvents() {

        $data = array();

        $collection = Mage::getModel('blog/blog')->getCollection()
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->addCatsFilter(7)
            ->addFieldToFilter('status', '1')
            ->setOrder('created_time ', 'desc');

        $i = 0;
        $html = '';
        
        foreach ($collection as $post) {


            //print_r($post);


            $content = $post->getPostContent();
            $img = null;

            $subject = $content;
            $img_pattern = '/({{media url="([A-Za-z0-9\/\.]+))/';
            $img_pattern2 = '/<img[^>]*\/?>/';
            if (preg_match($img_pattern, $subject, $matches)){
                $img = '<img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$matches[2].'" alt="Compition" />';
            } else if(preg_match($img_pattern2, $subject, $matches)){
                $img = $matches[0];
            }

            $subject = $content;
            $ul_pattern = '/(<ul>)?(<li>(?<value>.+?)<\/li>)+?(<\/ul>)?/s';
            preg_match_all($ul_pattern, $subject, $uls);

            $lis = $uls[0];
            $lists = '';
            for ($i = 0; $i < 3; ++$i) {
                $lists .= $lis[$i];
            }

            $liDate = $lis[0];
            $date_pattern = '/(\d{1,2}\/\d{1,2}\/\d{2})/';
            preg_match($date_pattern, $liDate, $date);
            $date = $date[0];

            $class = ($i==0) ? 'open' : ' ';

            $html .= '<li><h4 onclick="jQuery(this).parent().siblings(\'li\').children(\'.concertina\').removeClass(\'open\'); jQuery(this).siblings(\'.concertina\').addClass(\'open\');">'.$post->getTitle().'</h4><aside>'.$date.'</aside>';
            $html .= '<div class="concertina '.$class.'">';
            $html .= $img;
            $html .= '<ul>';
            $html .= $lists;
            $html .= '<li><a href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'blog/'.$post->getIdentifier().'" class="bullet type2">More Info</a></li>';
            $html .= '</ul>';
            $html .= '<div class="clearfix"></div>';
            $html .= '</div>';
            $html .= '</li>';

            ++$i;
        }

        return $html;
    }


    public function getLatestPostList($limit = 3) {
        
        $data = array();

        $collection = Mage::getModel('blog/blog')->getCollection()
            ->addPresentFilter()
            ->addStoreFilter(Mage::app()->getStore()->getId())
            ->setOrder('created_time ', 'desc');

        $i = 0;
        foreach ($collection as $post) {

            if ($i == $limit)
                break;

            $html .= '<a href="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'blog/'.$post->getIdentifier().'"><span>'.$post->getTitle().'</span></a>';

            ++$i;
        }

        return $html;

    }


}
