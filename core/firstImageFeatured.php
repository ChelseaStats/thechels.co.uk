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

	if (!class_exists('firstImageFeatured')) {

		class firstImageFeatured {

			/**
			 * firstImageFeatured constructor.
			 */
			function __construct() {
				add_action( 'save_post', array ( $this, 'cfc_wp_firstImageFeatured' ) );
			}

			/**
			 * @return null
			 */
			function cfc_wp_firstImageFeatured() {

				if ( ! isset( $GLOBALS['post']->ID ) )
					return NULL;

				if ( has_post_thumbnail( get_the_ID() ) )
					return NULL;

				$args = array(
					'numberposts' => 1,
					'order' => 'ASC', // DESC for the last image
					'post_mime_type' => 'image',
					'post_parent' => get_the_ID(),
					'post_status' => NULL,
					'post_type' => 'attachment'
				);

				$attached_image = get_children( $args );
				if ( $attached_image ) {
					foreach ( $attached_image as $attachment_id => $attachment )
						set_post_thumbnail( get_the_ID(), $attachment_id );
				}

			}
			
		}

		new firstImageFeatured;

	}