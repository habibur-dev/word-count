<?php

/**
 * Plugin Name:       Word Count
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * Text Domain:       word-count
 * Domain Path:       /languages
 */


 /* function wordcount_activation_hook(){}
 register_activation_hook( __FILE__, 'wordcount_activation_hook' );

 function wordcount_deactivation_hook(){}
 register_activation_hook( __FILE__, 'wordcount_deactivation_hook' ); */

 function word_count_load_textdomain(){
    load_plugin_textdomain( 'word-count', false, dirname(__FILE__)."/languages" );
 }
 add_action( 'plugins_loaded', 'word_count_load_textdomain' );


 function wordcount_count_words( $content ){
    $stripped_content   = strip_tags( $content );
    $wordn              = str_word_count( $stripped_content );
    $label              = __('Total Number of Words', 'word-count');
    $label              = apply_filters( 'wordcount_title', $label );
    $tag                = apply_filters( 'wordcount_tag', 'h3' );

    $content .= sprintf( '<%s><strong>%s:</strong> %s</%s>', $tag, $label, $wordn, $tag );
    return $content;
 }
 add_filter( 'the_content', 'wordcount_count_words' );
 
 function wordcount_reading_time( $content ){
    $stripped_content   = strip_tags( $content );
    $wordn              = str_word_count( $stripped_content );
    $reading_minute     = floor( $wordn / 200 );
    $reading_seconds    = floor( $wordn % 200 / ( 200 / 60 ) );
    $is_visible         = apply_filters( 'wordcount_display_readingtime', 1 );
    if($is_visible){
        $label          = __( 'Reading Time', 'word-count' );
        $label          = apply_filters( 'wordcount_readingtime_title', $label );
        $tag            = apply_filters( 'wordcount_readingtime_tag', 'h3' );

        $content .= sprintf( '<%s><strong>%s:</strong> %s Minutes, %s Seconds.</%s>', $tag, $label, $reading_minute, $reading_seconds, $tag );
    }
    
    return $content;
 }
 
 add_filter( 'the_content', 'wordcount_reading_time' );
