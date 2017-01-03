<?php

/* 
** Plugin Name: dotstudioPRO Premium Owl Carousel
** Version: 1.07
** Author: dotstudioPRO
** Author URI: #
*/
 
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require_once("functions.php");

/*
require 'updater/plugin-update-checker.php';
$myUpdateChecker = PucFactory::buildUpdateChecker(
    'http://wordpress.dotstudiopro.com/pluginupdates/dsowlcarousel/api/update.php',
    __FILE__
);
*/

add_action( 'wp_enqueue_scripts', 'ds_owl_carousel' );

function owl_carousel_main_check() {

    $plugins = get_option('active_plugins');
 
    $ds_premium_video = false;

    foreach($plugins as $k => $v){

    	if(strpos($v, "ds-premium-video")){

    		$video_plugin = get_plugins( '/' . plugin_basename( dirname( $v ) ) ); //get_plugin_data( plugin_dir_url( $v )."ds-premium-video.php" );

    		$ds_premium_video = true;

    		break;

    	}

    }

    if (!$ds_premium_video || isset($video_plugin) && $video_plugin["ds-premium-video.php"]['Version'] < 1.31 ) {

    	foreach($plugins as $k => $v){

	    	if(strpos($v, "ds-premium-carousel")){

	    		unset($plugins[$k]);

	    		update_option('active_plugins', $plugins);

    			add_action( 'admin_notices', 'ds_owl_carousel_check_main_plugin' );

	    		break;

	    	}

	    }

    }

}
register_activation_hook( __FILE__, 'owl_carousel_main_check' );

add_action("init", "owl_carousel_main_check");
