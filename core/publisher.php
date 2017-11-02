<?php
	/*
	Plugin Name: CFC Publisher
	Description: Automatically tweets, slacks and hooks new post titles and links to new/scheduled posts
	License: GPL
	Version: 12.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	class publisher {

		/**
		 * publisher constructor.
		 */
		function __construct() {

			/* Register Actions this is what triggers the post */
			add_action('new_to_publish',        array ($this, 'cfc_wp_tweeter'), 10, 1);
			add_action('draft_to_publish',      array ($this, 'cfc_wp_tweeter'), 10, 1);
			add_action('auto-draft_to_publish', array ($this, 'cfc_wp_tweeter'), 10, 1);
			add_action('pending_to_publish',    array ($this, 'cfc_wp_tweeter'), 10, 1);
			add_action('publish_future_post',   array ($this, 'cfc_wp_future' ), 10, 1);

		}

		/**
		 * Determines if current/draft/pending post then calls publishing
		 * @param $post_id
		 */
		function cfc_wp_tweeter( $post_id ) {
			$post = get_post( $post_id );
			if ( ( $post->post_type == 'post' || $post->post_type == 'feeders' ) && $post->post_status == 'publish' ) {
				$this->cfc_wp_publishing( $post, $post_id );
			}
		}

		/**
		 * Determines if future post then calls publishing
		 * @param $post_id
		 */
		function cfc_wp_future( $post_id ) {

			$post = get_post( $post_id );
			if ( $post->post_type == 'post' || $post->post_type == 'feeders' ) {
				$this->cfc_wp_publishing( $post, $post_id );
			}
		}

		/**
		 * Does the post to Social Media
		 * @param $post
		 * @param $post_id
		 */
		function cfc_wp_publishing( $post, $post_id ) {

			$go      = new utility();
			$melinda = new melinda();
			/* get the post that's being published */
			$post_title = $post->post_title;
			/* author needs a twitterid in their meta data*/
			// $author = get_the_author_meta('twitterid',$post->post_author);
			/* get the permalink */
			$url = get_permalink( $post_id );
			/* and shorten it */
			$short_url = $go->goBitly( $url );
			//check to make sure the tweet is within the 140 char limit
			//if not, shorten and place ellipsis and leave room for link.
			if ( strlen( $post_title ) + strlen( $short_url ) > 100 ) {
				$total_len       = strlen( $post_title ) + strlen( $short_url );
				$over_flow_count = $total_len - 100;
				$post_title      = substr( $post_title, 0, strlen( $post_title ) - $over_flow_count - 3 );
				$post_title .= '...';
			}
			//add in the shortened bit.ly link
			$message   = "New post: {$post_title} :- {$short_url}" . PHP_EOL;
			$message  .= "#Chelsea #ChelseaFC #CFC" . PHP_EOL;
			$tweetMeta = get_post_meta( $post->ID, "_tweetMeta", TRUE );
			if ( $tweetMeta == 'Y' ):
				$melinda->goTweet( $message, 'www' );
			endif;
			$melinda->goSlack( "New post: {$post_title}", 'TheChels Bot', 'cfc', 'bots' );
			$melinda->goTelegram( "<b>New post:</b> {$post_title} - {$hooks_url} <br/>by <i>@ChelseaStats</i>" );
			// $melinda->goEmail($message,$post_title,'website@thechels.uk');
		}
	}

new publisher();