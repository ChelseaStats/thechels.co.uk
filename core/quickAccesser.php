<?php
	/*
	Plugin Name: CFC Quick Access to Posts
	Description: Adds a link to 'Drafts' under the Posts, Pages, and other custom post type sections in the admin menu.
	Version: 12.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	if (!class_exists('quickAccessor')) {

		class quickAccessor {

			/**
			 * quickAccessor constructor.
			 */
			function __construct() {
				add_action( 'admin_menu', array ( $this, 'cfc_wp_quickDraftsAccess' ) );
				// add_action( 'admin_menu', array ( $this, 'cfc_wp_quickPendingAccess' ) );
				// add_action( 'admin_menu', array ( $this, 'cfc_wp_quickScheduledAccess' ) );
			}

			/**
			 * Creates shortcut to drafts.
			 *
			 */
			function cfc_wp_quickDraftsAccess() {
				$post_types = (array) get_post_types( array ( 'show_ui' => TRUE ), 'object' );
				$post_types = apply_filters( 'cfc_wp_quickDraftsAccessPostTypes', $post_types );
				foreach ( $post_types as $post_type ) {
					$name      = $post_type->name;
					$num_posts = wp_count_posts( $name, 'readable' );
					$path      = 'edit.php';
					if ( 'post' != $name ) // edit.php?post_type=post doesn't work
					{
						$path .= '?post_type=' . $name;
					}
					if ( ( $num_posts->draft > 0 ) || apply_filters( 'cfc_wp_quickDraftsAccessShowIfEmpty', FALSE, $name, $post_type ) ) {
						add_submenu_page( $path, __( 'Drafts' ), sprintf( __( 'Drafts <span class="update-plugins" title="Drafts"><span class="update-count">%d</span></span>' ),
							$num_posts->draft ), $post_type->cap->edit_posts, "edit.php?post_type=$name&post_status=draft" );
					}
				}
			}

			/**
			 * Creates shortcut to Pending.
			 *
			 */
/*
			function cfc_wp_quickPendingAccess() {
				$post_types = (array) get_post_types( array ( 'show_ui' => TRUE ), 'object' );
				$post_types = apply_filters( 'cfc_wp_quickPendingAccessPostTypes', $post_types );
				foreach ( $post_types as $post_type ) {
					$name      = $post_type->name;
					$num_posts = wp_count_posts( $name, 'readable' );
					$path      = 'edit.php';
					if ( 'post' != $name ) // edit.php?post_type=post doesn't work
					{
						$path .= '?post_type=' . $name;
					}
					if ( ( $num_posts->draft > 0 ) || apply_filters( 'cfc_wp_quickPendingAccessShowIfEmpty', FALSE, $name, $post_type ) ) {
						add_submenu_page( $path, __( 'Pending' ), sprintf( __( 'Pending <span class="update-plugins" title="Pending"><span class="update-count">%d</span></span>' ),
							$num_posts->draft ), $post_type->cap->edit_posts, "edit.php?post_type=$name&post_status=pending" );
					}
				}
			}
*/

			/**
			 * Creates shortcut to Scheduled.
			 *
			 */
/*
 			function cfc_wp_quickScheduledAccess() {
				$post_types = (array) get_post_types( array ( 'show_ui' => TRUE ), 'object' );
				$post_types = apply_filters( 'cfc_wp_quickScheduledAccessPostTypes', $post_types );
				foreach ( $post_types as $post_type ) {
					$name      = $post_type->name;
					$num_posts = wp_count_posts( $name, 'readable' );
					$path      = 'edit.php';
					if ( 'post' != $name ) // edit.php?post_type=post doesn't work
					{
						$path .= '?post_type=' . $name;
					}
					if ( ( $num_posts->draft > 0 ) || apply_filters( 'cfc_wp_quickScheduledAccessShowIfEmpty', FALSE, $name, $post_type ) ) {
						add_submenu_page( $path, __( 'Scheduled' ), sprintf( __( 'Scheduled <span class="update-plugins" title="Scheduled"><span class="update-count">%d</span></span>' ),
							$num_posts->draft ), $post_type->cap->edit_posts, "edit.php?post_type=$name&post_status=scheduled" );
					}
				}
			}
*/

		}

		new quickAccessor;

	}