<?php
/**
 *  Next Pager
 *
 *  @class nextPager
 *  @author R-Harada
 */
class nextPager
{

    private static $nextMessage;

    public static function run($pages)
    {

        global $page;
        $pages = implode('', $pages);

        self::$nextMessage = [];
        $content = preg_replace_callback('/\[\s?next\s?(text\s?=["|\']?(.*?)["|\']?)?\]/', function($match) {
            self::$nextMessage[] = $match[2];
            return '[next]';
        }, $pages);


        $pages = explode('[next]', $content);

        $pages = self::nextMessageLink($pages, $page);

        return $pages;

    }

    private static function nextMessageLink($pages, $page)
    {

        foreach (self::$nextMessage as $key => $val) {
            $link = self::getPageLink(($page == 0 )? 2 : $page + 1);
            if (empty($val)) {
                $anker = "<a href='{$link}' rel='next'>" . mb_substr($pages[$key + 1], 0, 19) . '...' . '</a>' . PHP_EOL;
            } else {
                $anker = "<a href='{$link}' rel='next'>" . $val . '</a>' . PHP_EOL;
            }
            $pages[$key] .= $anker;
        }

        return $pages;

    }

    private static function getPageLink($i)
    {

        global $wp_rewrite;
        $post = get_post();
        $queryArgs= [];

        if (1 == $i) {
            $url = get_permalink();
        } else {
            if ('' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending'))) {
                $url = add_query_arg( 'page', $i, get_permalink() );
            } elseif ('page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID) {
                $url = trailingslashit(get_permalink()) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
            } else {
                $url = trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
            }
        }

        if (is_preview()) {

            if (('draft' !== $post->post_status) && isset($_GET['preview_id'], $_GET['preview_nonce'])) {
                $queryArgs['preview_id'] = wp_unslash( $_GET['preview_id'] );
                $queryArgs['preview_nonce'] = wp_unslash( $_GET['preview_nonce'] );
            }

            $url = get_preview_post_link( $post, $queryArgs, $url );
        }

        return $url;

    }

}

