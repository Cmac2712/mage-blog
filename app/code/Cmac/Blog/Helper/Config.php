<?php
/**
 * INDEZ BLOG MODULE
 *
 * @category    Module
 * @package     Cmac_Blog
 * @copyright   Copyright (c) 2012 Craig MacIntyre (http://www.indez.com)
 * @author Craig MacIntyre (steven.richardson@indez.com)
 */


class Cmac_Blog_Helper_Config extends Mage_Core_Helper_Abstract {
    const XML_TAGCLOUD_SIZE = 'blogconfig/menu/tagcloud_size';
    const XML_RECENT_SIZE = 'blogconfig/menu/recent';

    const XML_BLOG_PERPAGE = 'blogconfig/blog/perpage';
    const XML_BLOG_READMORE = 'blogconfig/blog/readmore';
    const XML_BLOG_PARSE_CMS = 'blogconfig/blog/parse_cms';

    const XML_BLOG_USESHORTCONTENT = 'blogconfig/blog/useshortcontent';

    const XML_COMMENTS_PER_PAGE = 'blogconfig/comments/page_count';

    public function getCommentsPerPage($store = null) {
        $perPageCount = intval(Mage::getStoreConfig(self::XML_COMMENTS_PER_PAGE, $store));
        if ($perPageCount < 1)
            $perPageCount = 10;
        return $perPageCount;
    }

}
