<?php
	/*
	Plugin Name: CFC Show IDs in Admin
	Description: Shows the ID of Posts, Pages, Media, Links, Categories, Tags and Users in the admin tables for easy access. Very lightweight.
	Version: 4.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	if ( !class_exists( 'identifier' ) ) :
		class identifier {

			/**
			 * tcr_simply_ids constructor.
			 */
			function __construct() {
				add_action('admin_init', array($this, 'cfc_wp_sid_add') );
			}

			/**
			 * @param $cols
			 * @return mixed
			 */
			function  cfc_wp_sid_column( $cols ) {
				$cols['cfc_wp_sid'] = 'ID';
				return $cols;
			}

			/**
			 * @param $column_name
			 * @param $id
			 */
			function cfc_wp_sid_value( $column_name, $id ) {
				if ( $column_name == 'cfc_wp_sid' ) {
					echo $id;
				}
			}

			/**
			 * @param $value
			 * @param $column_name
			 * @param $id
			 * @return mixed
			 */
			function cfc_wp_sid_return_value( $value, $column_name, $id ) {
				if ( $column_name == 'cfc_wp_sid' ) {
					$value = $id;
				}
				return $value;
			}

			/**
			 * Adds CSS to the admin to handle ID column
			 *
			 */
			function cfc_wp_sid_css() {
			
				print '<style type = "text/css">#cfc_wp_sid { width: 40px; }</style>';
			
			}

			/**
			 * adds actions and filters
			 */
			function cfc_wp_sid_add() {
				add_action('admin_head'                            , array($this, 'cfc_wp_sid_css' ));
				add_filter('manage_posts_columns'                  , array($this, 'cfc_wp_sid_column' ));
				add_action('manage_posts_custom_column'            , array($this, 'cfc_wp_sid_value'), 10, 2 );
				add_filter('manage_pages_columns'                  , array($this, 'cfc_wp_sid_column') );
				add_action('manage_pages_custom_column'            , array($this, 'cfc_wp_sid_value'), 10, 2 );
				add_filter('manage_media_columns'                  , array($this, 'cfc_wp_sid_column') );
				add_action('manage_media_custom_column'            , array($this, 'cfc_wp_sid_value'), 10, 2 );
				add_filter('manage_link-manager_columns'           , array($this, 'cfc_wp_sid_column') );
				add_action('manage_link_custom_column'             , array($this, 'cfc_wp_sid_value'), 10, 2 );
				add_action('manage_edit-link-categories_columns'   , array($this, 'cfc_wp_sid_column') );
				add_filter('manage_link_categories_custom_column'  , array($this, 'cfc_wp_sid_return_value'), 10, 3 );
				add_action('manage_users_columns'                  , array($this, 'cfc_wp_sid_column') );
				add_filter('manage_users_custom_column'            , array($this, 'cfc_wp_sid_return_value'), 10, 3 );
				add_action('manage_edit-comments_columns'          , array($this, 'cfc_wp_sid_column') );
				add_action('manage_comments_custom_column'         , array($this, 'cfc_wp_sid_value'), 10, 2 );
				foreach(get_taxonomies() as $taxonomy ) {
					add_action("manage_edit-${taxonomy}_columns"   , array($this, 'cfc_wp_sid_column') );
					add_filter("manage_${taxonomy}_custom_column"  , array($this, 'cfc_wp_sid_return_value'), 10, 3 );
				}
			}
		}
		new identifier;
	endif;
