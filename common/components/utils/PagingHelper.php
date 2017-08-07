<?php
/**
 * Project: quark.
 * Date: 9/26/2016
 * Name: TDT
 */

namespace app\components\utils;


class PagingHelper
{
    /**
     * @param int $total
     * @param int $offset
     * @param int $limit
     * @param string $link
     * @return array
     */
    public static function makePaging($total, $offset, $limit, $link)
    {
        $currentPage = floor($offset / $limit) + 1;
        $pageCount = ceil($total / $limit);
        $pages = [];
        for($i = 1; $i <= $pageCount; $i++){
            $offset = ($i - 1) * $limit;
            if($offset < 0){
                $offset = 0;
            }
            elseif($offset > $total){
                $offset = $total;
            }

            $pages[$i] = str_replace('{offset}', $offset, urldecode($link));
        }

        $render = [
            'paging'        => $pages,
            'current_page'  => $currentPage,
        ];
        return $render;
    }
}