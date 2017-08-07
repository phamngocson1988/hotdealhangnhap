<?php
namespace app\components\utils;

class KConstants {
    /** Define constants for limit **/
    const COMPANY_GROUP_PAGE_LIMIT = 10;
    const GROUP_LIST_LIMIT = 10;
    const GROUP_WIDGET_LIMIT = 4;
    const GROUP_SUGGESTED_LIST_LIMIT = 6;
    const GROUP_INSIDER_LIST_LIMIT = 10;
    
    const GROUP_MEMBER_LIST_LIMIT = 8;
    const GROUP_PAGE_MEMBER_LIST_LIMIT = 20;
    
    const GROUP_REQUEST_MEMBER_LIST_LIMIT = 8;
    const GROUP_PAGE_REQUEST_MEMBER_LIST_LIMIT = 20;
    const GROUP_PAGE_SUGGEST_MEMBER_LIST_LIMIT = 20;
    
    const GROUP_ADMIN_LIST_LIMIT = 4;
    const GROUP_PAGE_ADMIN_LIST_LIMIT = 10;
    
    const MIN_LENGHT_DOMAIN_ID = 2;
    const MAX_LENGHT_DOMAIN_ID = 30;

    const MIN_PHOTO_SIZE = 50;
    const MIN_THUMB_PHOTO_SIZE = 402;

    const AFFILIATE_LIMIT = 10;
    const COMMENT_LIMIT = 10;

    /**
     * @var int
     * Time to check user read the thread and increase thread view, this value is 1 day (24 * 60 * 60)
     */
    const THREAD_COOKIE_TIME = 86400;

    const BOARD_ITEMS_LIMIT = 2;
    const BOARD_ITEMS_INTROTEXT_LENGTH = 80;
    const SERVICE_ITEMS_LIMIT = 3;
    const SERVICE_ITEMS_WIDGET_LIMIT = 3;
    const PRODUCT_ITEMS_WIDGET_LIMIT = 4;
    const PRODUCT_ITEMS_LIMIT = 6;
    const PRODUCT_ITEMS_POST_LIMIT = 3;
}