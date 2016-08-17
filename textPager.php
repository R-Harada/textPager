<?php
/**
 *  Text Pager
 *
 *  ページ内ページャーの文言指定
 *  @author R-Harada
 */
/*
Plugin Name: Text Pager
Description: ページ内ページャーの文言指定
Author: R-Harada
Version: 1.0
 */


/**
 * 開発用
 */
//
//function nextPages() {
//    global $page, $pages, $post, $numpages, $multipage, $more;
//
//    /**
//     * 初期設定
//     */
//    $numpages = 1;
//    $multipage = 0;
//    $page = ( 0 === get_query_var('page'))? 1 : get_query_var('page');
//
//    /**
//     *  ページ分割
//     */
//    global $nextMessage;
//    $nextMessage = [];
//    $content = preg_replace_callback('/\[\s?next\s?(text\s?=["|\']?(.*?)["|\']?)?\]/', function($match) {
//        global $nextMessage;
//        $nextMessage[] = $match[2];
//        return '[next]';
//    }, $pages);
//    $pages = explode('[next]', $content[0]);
//
//    /**
//     *  タイトル付け
//     */
//    foreach($nextMessage as $key => $val) {
//        $anker = _wp_link_page(($page == 0 )? 2 : $page + 1);
//        if(empty($val)) {
//            $anker .= mb_substr($pages[$key + 1], 0, 19) . '...' . '</a>' . PHP_EOL;
//        } else {
//            $anker .= $val . '</a>' . PHP_EOL;
//        }
//        $pages[$key] .= $anker;
//    }
//
//    /**
//     *  ページャー設定
//     */
//    $numpages = count( $pages );
//    if ( $numpages > 1 ) {
//        if ( $page > 1 ) {
//            $more = 1;
//        }
//        $multipage = 1;
//    } else {
//        $multipage = 0;
//    }
//
//    if($page == 0) {
//        return $pages[0];
//    } else {
//        return $pages[$page - 1];
//    }
//
//}
//add_filter('the_content', 'nextPages', 0);
//

add_filter('content_pagination', function($pages){

    global $page;
    $pages = implode('', $pages);

    /**
     *  ページ分割
     */
    global $nextMessage;
    $nextMessage = [];
    $content = preg_replace_callback('/\[\s?next\s?(text\s?=["|\']?(.*?)["|\']?)?\]/', function($match) {
        global $nextMessage;
        $nextMessage[] = $match[2];
        return '[next]';
    }, $pages);

    $pages = explode('[next]', $content);

    /**
     *  タイトル付け
     */
    foreach($nextMessage as $key => $val) {
        $anker = _wp_link_page(($page == 0 )? 2 : $page + 1);
        if(empty($val)) {
            $anker .= mb_substr($pages[$key + 1], 0, 19) . '...' . '</a>' . PHP_EOL;
        } else {
            $anker .= $val . '</a>' . PHP_EOL;
        }
        $pages[$key] .= $anker;
    }

    return $pages;

});

//require_once __dir__ . '/hook.php';
