<?php
	/*
	Plugin Name: CFC Feeds & Custom Post Types
	Description: WordPress feeds & Custom Post Types
	License: GPL
	Version: 13.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	class feeder {

		/**
		 * feeder constructor.
		 */
		function __construct() {

				// add_action('init'                   , array($this, 'wp_cfc_custom_post_type_feeder'), 0);
				add_action('init'                   , array($this, 'wp_cfc_add_my_feeds'));
				add_action('add_meta_boxes'         , array($this, 'wp_cfc_add_bool_tweet_metabox'));
				add_action('save_post'              , array($this, 'wp_cfc_save_tweet_meta'), 1, 2);
				add_action( 'rss2_ns'	            , array($this, 'wp_cfc_add_namespace'));
				add_action( 'atom_ns'	            , array($this, 'wp_cfc_add_namespace'));
				add_action( 'rdf_ns'	            , array($this, 'wp_cfc_add_namespace'));
				add_action( 'rss_ns'	            , array($this, 'wp_cfc_add_namespace'));
				add_action( 'rss2_head'	            , array($this, 'wp_cfc_add_header_information'));
				add_action( 'atom_head'	            , array($this, 'wp_cfc_add_header_information'));
				add_action( 'rdf_head'	            , array($this, 'wp_cfc_add_header_information'));
				add_action( 'rss_head'	            , array($this, 'wp_cfc_add_header_information'));
				add_action('wp_head'                , array($this, 'wp_cfc_addBackPostFeed'));
				add_filter('request'                , array($this, 'wp_cfc_add_post_types_to_rss_feed'));
				add_filter('the_excerpt_rss'        , array($this, 'wp_cfc_add_feed_content'));
				add_filter('the_content'            , array($this, 'wp_cfc_add_feed_content'));

				add_action('do_feed_rdf'            , 'do_feed_rss2', 10);
				add_action('do_feed_rss'            , 'do_feed_rss2', 10);

				add_filter('rss_update_period'      , create_function('', 'return "hourly";'));
				add_filter('rss_update_frequency'   , create_function('', 'return 2;'));
				add_filter('default_feed'           , array($this, 'wp_cfc_default_feed'));

				remove_action('do_feed_rdf'         , 'do_feed_rdf', 10);
				remove_action('do_feed_rss'         , 'do_feed_rss', 10);
				remove_action('wp_head'             , 'feed_links', 10);

				//add_action( 'save_post_feeders'   , 'wp_cfc_save_tweet_meta', 1, 2);
				//add_action( 'save_post_sponsors'  , 'wp_cfc_save_tweet_meta', 1, 2);

		}

		/**
		 *
		 */
		function wp_cfc_add_my_feeds() {

			add_feed('wslone'   	, array($this, 'feed_wslone'));
			add_feed('wsltwo'   	, array($this, 'feed_wsltwo'));
			add_feed('wdlnorth' 	, array($this, 'feed_wdlnorth'));
			add_feed('wdlsouth' 	, array($this, 'feed_wdlsouth'));
			add_feed('wslprogress' 	, array($this, 'feed_wslprog'));
			add_feed('wslcann'      , array($this, 'feed_wslcann'));
			add_feed('wslgdl'    	, array($this, 'feed_wslgdl'));
			add_feed('big7' 	    , array($this, 'feed_big7'));
			add_feed('t13' 		    , array($this, 'feed_t13'));
			add_feed('ever6' 	    , array($this, 'feed_ever6'));
			add_feed('london' 	    , array($this, 'feed_london'));
			add_feed('last38' 	    , array($this, 'feed_last38'));
			add_feed('epl' 	        , array($this, 'feed_epl'));
			add_feed('shots' 	    , array($this, 'feed_shots'));
			add_feed('sot' 	        , array($this, 'feed_sot'));
			add_feed('close'  	    , array($this, 'feed_close'));
			add_feed('progress' 	, array($this, 'feed_prog'));
			add_feed('history'      , array($this, 'feed_history'));
			add_feed('cann'       	, array($this, 'feed_cann'));
			add_feed('goaldiff'    	, array($this, 'feed_goaldiff'));
		}

		/** Set Post types in RSS
		 * @param $args
		 * @return mixed
		 */
		function wp_cfc_add_post_types_to_rss_feed( $args ) {
			if ( isset( $args['feed'] ) && !isset( $args['post_type'] ) )
				$args['post_type'] = array('post');
			return $args;
		}

		/** Add Custom Post Type (Feeder)
		 *
		 */
		function wp_cfc_custom_post_type_feeder() {

			$labels = array(
				'name'                => _x( 'Feeders', 'Post Type General Name', 'text_domain' ),
				'singular_name'       => _x( 'Feeder', 'Post Type Singular Name', 'text_domain' ),
				'menu_name'           => __( 'Feeders', 'text_domain' ),
				'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
				'all_items'           => __( 'All Items', 'text_domain' ),
				'view_item'           => __( 'View Item', 'text_domain' ),
				'add_new_item'        => __( 'Add New Item', 'text_domain' ),
				'add_new'             => __( 'Add New', 'text_domain' ),
				'edit_item'           => __( 'Edit Item', 'text_domain' ),
				'update_item'         => __( 'Update Item', 'text_domain' ),
				'search_items'        => __( 'Search Item', 'text_domain' ),
				'not_found'           => __( 'Not found', 'text_domain' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
			);
			$args = array(
				'label'               => __( 'feeders', 'text_domain' ),
				'description'         => __( 'RSS only content', 'text_domain' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor','post-formats' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => false,
				'menu_position'       => 5,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'register_meta_box_cb' => array ($this, 'wp_cfc_add_bool_tweet_metabox')
			);
		//	register_post_type( 'feeders', $args );

		}

		/** Add the TweetsMeta Meta Boxes
		 *
		 */
		function wp_cfc_add_bool_tweet_metabox() {

			add_meta_box('wp_cfc_bool_tweet', 'Tweeter', array($this, 'wp_cfc_tweet_html'), 'post'        , 'side', 'default');
		}

		/**  The TweetsMeta Metabox
		 *
		 */
		function wp_cfc_tweet_html() {
			global $post;

			// Noncename needed to verify where the data originated
			echo '<input type="hidden" name="tweetmeta_noncename" id="tweetmeta_noncename" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

			// Get the tweet data if its already been entered
			$tweetMeta = get_post_meta($post->ID, '_tweetMeta', true);

			print "<!-- {$tweetMeta} - {$post->ID} -->";

			// Echo out the field
			if( $tweetMeta == 'Y') {
				echo "<input type='radio' name='_tweetMeta' value='{$tweetMeta}' 	class='widefat' checked /> Yes ";
				echo "<input type='radio' name='_tweetMeta' value='N' 				class='widefat' 		/> No ";
			} else {
				echo "<input type='radio' name='_tweetMeta' value='Y' 				class='widefat'  		/> Yes ";
				echo "<input type='radio' name='_tweetMeta' value='{$tweetMeta}' 	class='widefat' checked	/> No ";
			}
		}

		/** Save the TweetsMeta Metabox Data
		 * @param $post_id
		 * @param $post
		 * @return int
		 */
		function wp_cfc_save_tweet_meta($post_id, $post) {

			// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times
			if ( !wp_verify_nonce( $_POST['tweetmeta_noncename'], plugin_basename(__FILE__) )) {
				return $post->ID;
			}

			print '<!--'. $post_id . '-->';

			// Is the user allowed to edit the post or page?
			if ( !current_user_can( 'edit_post', $post->ID ))
				return $post->ID;

			// OK, we're authenticated: we need to find and save the data
			// We'll put it into an array to make it easier to loop though.

			$tweets_meta['_tweetMeta'] = $_POST['_tweetMeta'];

			// Add values of $events_meta as custom fields

			foreach ($tweets_meta as $key => $value) { // Cycle through the $tweets_meta array!
				//if( $post->post_type == 'revision' ) return; // Don't store custom data twice
				//$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
				if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
					update_post_meta($post->ID, $key, $value);
				} else { // If the custom field doesn't have a value
					add_post_meta($post->ID, $key, $value);
				}
				if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
			}

			return true;

		}

		/** Add custom feed content footer
		 * @param $content
		 * @return string
		 */
		function wp_cfc_add_feed_content($content) {
				//global $wp_query;

			if(is_feed()) {
				/** @var $post_type
				 * needed to get post ID, but never used?
				 */
				//$post_type = get_post_type( get_the_ID() );

				$content .= '<footer>'.PHP_EOL;
				$content .= '<hr/>'.PHP_EOL;
				$content .= '<p><small>Data provided by <a href="http://twitter.com/ChelseaStats">@ChelseaStats</a>, <a href="http://twitter.com/FawslStats">@FawslStats</a>  &amp; ';
				$content .= '<a href="https://thechels.co.uk">TheChels.co.uk</a> &copy; '.date( 'Y' ).' All rights reserved.</small></p>'.PHP_EOL;
				$content .= '<p><small><a href="https://thechels.co.uk/rss-feeds/" target="_blank">Get more feeds</a>
							| <a href="https://m.TheChels.uk/" target="_blank">App</a>
							| <a href="https://github.com/ChelseaStats/Issues/issues/new/">Report Issues</a>
							| <a href="https://TheChels.co.uk/sponsorship" target="_blank">Sponsor Us</a></small></p>'.PHP_EOL;
				$content .= '<p><small><a href="https://thechels.co.uk/support/">ChelseaStats is supported by readers like you click here to help out</a>.</small></p>'.PHP_EOL;
				$content .= '</footer>'.PHP_EOL;
			}
			return $content;
		}

		/** Add namespace for FEEDLY
		 *
		 */
		function wp_cfc_add_namespace() {
		    echo 'xmlns:webfeeds="http://webfeeds.org/rss/1.0"'.PHP_EOL;
		}

		/** Add color scheme and logo for feedly
		 *
		 */
		function wp_cfc_add_header_information() {
			echo 	'<webfeeds:cover image="https://thechels.co.uk/media/themes/ChelseaStats/img/logo.png"/>'.PHP_EOL;
		    echo 	'<webfeeds:accentColor>#326ea1</webfeeds:accentColor>'.PHP_EOL;
		    echo 	'<webfeeds:related layout="card" target="browser"/>'.PHP_EOL;
		}

		/** Remove Generator, add our own
		 * @return string
		 */
		function wp_cfc_remove_wp_version_rss() {
		    return '<generator>ChelseaStats</generator>';
		}

		/**
		 * @return string
		 */
		function wp_cfc_default_feed() { return 'rss2'; }

		/** Add feeds back into head
		 *  Void
		 */
		function wp_cfc_addBackPostFeed() {
			echo "<!-- RSS feeds galore -->".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Main Site Default Feed' 	href='http://thechels.co.uk/feed/' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Main Site RSS 2.0 Feed' 	href='http://thechels.co.uk/feed/rss2/' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Main Site Atom Feed' 		href='http://thechels.co.uk/feed/atom/' />".PHP_EOL;
			echo " ".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='WSL and WDL Combined Master RSS 2.0 Feed' href='http://fawslstats.tumblr.com/rss/' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='WSL 1 RSS 2.0 Feed' 						href='http://thechels.co.uk/feed/wslone' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='WSL 2 RSS 2.0 Feed' 			            href='http://thechels.co.uk/feed/wsltwo' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='WDL North RSS 2.0 Feed' 		            href='http://thechels.co.uk/feed/wdlnorth' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='WDL South RSS 2.0 Feed' 		            href='http://thechels.co.uk/feed/wdlsouth' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='WSL Progress League RSS 2.0 Feed' 		href='http://thechels.co.uk/feed/wslprogress' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='WSL Cann Table RSS 2.0 Feed' 				href='http://thechels.co.uk/feed/wslcann' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='WSL Goal Difference League RSS 2.0 Feed' 	href='http://thechels.co.uk/feed/wslgdl' />".PHP_EOL;
			echo " ".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Premier League RSS 2.0 Feed' 
			href='http://thechels.co.uk/feed/epl' />".PHP_EOL;
			
			echo "<link rel='alternate' type='application/rss+xml' title='Shots League RSS 2.0 Feed' 			href='http://thechels.co.uk/feed/shots' />".PHP_EOL;
			
			echo "<link rel='alternate' type='application/rss+xml' title='Shots on Target League RSS 2.0 Feed' 			href='http://thechels.co.uk/feed/sot' />".PHP_EOL;
			
			echo "<link rel='alternate' type='application/rss+xml' title='London League RSS 2.0 Feed' 			href='http://thechels.co.uk/feed/london' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Big 7 League RSS 2.0 Feed' 			href='http://thechels.co.uk/feed/big7' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Threatened 13 League RSS 2.0 Feed' 	href='http://thechels.co.uk/feed/t13' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Ever Present 6 League RSS 2.0 Feed' 	href='http://thechels.co.uk/feed/ever6' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Last 38 League RSS 2.0 Feed' 			href='http://thechels.co.uk/feed/last38' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Progress League RSS 2.0 Feed' 		href='http://thechels.co.uk/feed/progress' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Cann Table RSS 2.0 Feed' 				href='http://thechels.co.uk/feed/cann' />".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='Goal Difference League RSS 2.0 Feed' 	href='http://thechels.co.uk/feed/goaldiff' />".PHP_EOL;
			echo " ".PHP_EOL;
			echo "<link rel='alternate' type='application/rss+xml' title='History Checker RSS 2.0 Feed' href='http://thechels.co.uk/feed/history' />".PHP_EOL;
		}

		/**
		 *
		 */
		function feed_wslone( ) {
			get_template_part('feed', 'wslone');
			assert( "locate_template( array('feeds/feed-wslone.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_wsltwo( ) {
			get_template_part('feed', 'wsltwo');
			assert( "locate_template( array('feeds/feed-wsltwo.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_wdlnorth( ) {
			get_template_part('feed', 'wdlnorth');
			assert( "locate_template( array('feeds/feed-wdlnorth.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_wdlsouth( ) {
			get_template_part('feed', 'wdlsouth');
			assert( "locate_template( array('feeds/feed-wdlsouth.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_wslprog( ) {
			get_template_part('feed', 'wslprogress');
			assert( "locate_template( array('feeds/feed-wsl-progress.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_wslcann( ) {
			get_template_part('feed', 'wslcann');
			assert( "locate_template( array('feeds/feed-wsl-cann.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_wslgdl( ) {
			get_template_part('feed', 'wslgdl');
			assert( "locate_template( array('feeds/feed-wsl-gdl.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_big7( ) {
			get_template_part('feed', 'big7');
			assert( "locate_template( array('feeds/feed-big7.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_t13( ) {
			get_template_part('feed', 't13');
			assert( "locate_template( array('feeds/feed-t13.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_ever6( ) {
			get_template_part('feed', 'ever6');
			assert( "locate_template( array('feeds/feed-ever.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_london( ) {
			get_template_part('feed', 'london');
			assert( "locate_template( array('feeds/feed-london.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_last38( ) {
			get_template_part('feed', 'last38');
			assert( "locate_template( array('feeds/feed-last38.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_epl( ) {
			get_template_part('feed', 'epl');
			assert( "locate_template( array('feeds/feed-epl.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_shots( ) {
			get_template_part('feed', 'shots');
			assert( "locate_template( array('feeds/feed-shots.php'), true, false )" );
		}
		
		/**
		 *
		 */
		function feed_sot( ) {
			get_template_part('feed', 'sot');
			assert( "locate_template( array('feeds/feed-sot.php'), true, false )" );
		}
		
		/**
		 *
		 */
		function feed_close( ) {
			get_template_part('feed', 'close');
			assert( "locate_template( array('feeds/feed-close.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_prog( ) {
			get_template_part('feed', 'progress');
			assert( "locate_template( array('feeds/feed-progress.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_history( ) {
			get_template_part('feed', 'history');
			assert( "locate_template( array('feeds/feed-history.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_cann( ) {
			get_template_part('feed', 'cann');
			assert( "locate_template( array('feeds/feed-cann.php'), true, false )" );
		}

		/**
		 *
		 */
		function feed_goaldiff( ) {
			get_template_part('feed', 'goaldiff');
			assert( "locate_template( array('feeds/feed-goaldiff.php'), true, false )" );
		}

	}

	new feeder();