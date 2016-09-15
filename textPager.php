<?php
/**
 *  Text Pager
 *
 *  ページ内ページャーの文言指定
 *  @version 1.0
 *  @author R-Harada
 */
/*
Plugin Name: Text Pager
Description: ページ内ページャーの文言指定
Author: R-Harada
Version: 1
 */

require_once 'class/nextPager.php';

add_filter('content_pagination', array('nextPager', 'run'));

