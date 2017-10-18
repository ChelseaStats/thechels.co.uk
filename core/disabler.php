<?php
	/*
	Plugin Name: CFC WordPress settings
	Description: Wordpress settings and filters -no options
	Version: 12.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.uk
	Author URI: https://thechels.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();
	
	show_admin_bar(false);

	remove_action('init'	        , 'wp_admin_bar_init');
	remove_action('wp_head'	        , 'rsd_link');
	remove_action('wp_head'	        , 'wlwmanifest_link');
	remove_action('wp_head'	        , 'index_rel_link');
	remove_action('wp_head'	        , 'parent_post_rel_link',10);
	remove_action('wp_head'	        , 'start_post_rel_link',10);
	remove_action('wp_head'	        , 'adjacent_posts_rel_link_wp_head',10);
	remove_action('wp_head'	        , 'wp_generator');
	remove_action('wp_head'         , 'print_emoji_detection_script', 7 );
	remove_action('wp_print_styles' , 'print_emoji_styles' );
	
	add_filter('xmlrpc_enabled'        , '__return_true' );
