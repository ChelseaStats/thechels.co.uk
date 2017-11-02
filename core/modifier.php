<?php
	/*
	Plugin Name: CFC Admin modifier
	Description: Modify the admin adding user guide, menu changes, dashboard widgets and simplifying display
	Version: 13.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	if (! class_exists( 'modifier')) :

		class modifier {

			/**
			 * modifier constructor.
			 */
			function __construct() {

				add_action('wp_before_admin_bar_render'    , array ($this, 'cfc_wp_remove_wp_logo' ) );
				add_action('wp_before_admin_bar_render'    , array ($this, 'cfc_wp_remove_my_account')  );
				add_action('wp_before_admin_bar_render'    , array ($this, 'cfc_wp_remove_comment_bubble')  );
				add_action('wp_before_admin_bar_render'    , array ($this, 'cfc_wp_remove_my_menu' ) );
				add_filter('user_contactmethods'           , array ($this, 'cfc_wp_extra_contact_info') );
				add_filter('get_user_option_admin_color'   , array ($this, 'cfc_wp_change_admin_color') );
				add_action('restrict_manage_posts'         , array ($this, 'cfc_wp_author_filter') );
				add_action('dashboard_glance_items'        , array ($this, 'cfc_wp_at_glance_content_table_end') );
				add_action('wp_scheduled_delete'           , array ($this, 'cfc_wp_delete_expired_db_transients') );
				add_filter('admin_footer_text'             , array ($this, 'cfc_wp_replace_footer_admin') );
				add_filter('update_footer'                 , array ($this, 'cfc_wp_replace_footer_version') , '1234');
				add_action('login_head'                    , array ($this, 'cfc_wp_custom_login_logo') );
				add_filter('login_header_url'              , array ($this, 'cfc_wp_login_header_url') );
				add_filter('login_header_title'            , array ($this, 'cfc_wp_login_header_title') );
				add_action('admin_menu'                    , array ($this, 'cfc_wp_all_settings_link') );
				add_action('admin_menu'                    , array ($this, 'cfc_wp_plugin_admin_add_page') );
				add_action('admin_menu'                    , array ($this, 'cfc_wp_remove_editor_menu'), 1);
				add_action('admin_init'                    , array ($this, 'cfc_wp_remove_dashboard_meta' ) );
				add_action('admin_head'                    , array ($this, 'cfc_wp_remove_contextual_help') );
				add_action('admin_head'                    , array ($this, 'cfc_wp_admin_register_head') );
				add_action('admin_head'                    , array ($this, 'cfc_wp_admin_favicon') );
				add_filter('post_date_column_time'         , array ($this, 'cfc_wp_post_date_column_time' ) , 10 , 2 );
				add_filter('wp_mail_from'                  , array ($this, 'cfc_wp_mailFrom' ));
				add_filter('wp_mail_from_name'             , array ($this, 'cfc_wp_mailFromName' ));
				add_filter('the_content'                   , array ($this, 'cfc_wp_twitterHash'));
				add_filter('the_content'                   , array ($this, 'cfc_wp_twitterUsername'));
				add_filter('title_save_pre'                , array ($this, 'cfc_wp_lowertitle'));
				add_filter('the_title'                     , array ($this, 'cfc_wp_lowertitle'));
				add_filter('title_save_pre'                , array ($this, 'cfc_wp_removeunderscores'));
				add_filter('the_title'                     , array ($this, 'cfc_wp_removeunderscores'));
				add_filter('title_save_pre'                , array ($this, 'cfc_wp_fixtitle'));
				add_filter('the_title'                     , array ($this, 'cfc_wp_fixtitle'));
				add_action('wp_print_styles'               , array ($this, 'cfc_wp_deregister_styles'), 100 );
				add_filter('wp_headers'                    , array ($this, 'cfc_wp_setHeaders') );
			}

			/**
			 * Custom function to add time to the date / time column for future posts.
			 *
			 * @param $h_time
			 * @param $post
			 * @return string
			 */
			function cfc_wp_post_date_column_time( $h_time, $post ) {
				// If post is scheduled then add the time to the column output
				if ($post->post_status == 'future') {
					$h_time .= '<br>' . get_post_time( 'g:i a', false, $post );
				}
				// Return the column output
				return $h_time;
			}

			/**
			 * Remove WP logo from admin.
			 *
			 */
			function cfc_wp_remove_wp_logo() {
				global $wp_admin_bar;
				$wp_admin_bar->remove_menu('wp-logo');
			}

			/**
			 * Remove my account link
			 *
			 */
			function cfc_wp_remove_my_account() {
				global $wp_admin_bar;
				$wp_admin_bar->remove_menu('my-account');
			}

			/**
			 * Remove comment bubble.
			 *
			 */
			function cfc_wp_remove_comment_bubble() {

				global $wp_admin_bar;
				$wp_admin_bar->remove_menu('comments');

			}

			/**
			 * Remove my menu
			 *
			 */
			function cfc_wp_remove_my_menu() {

				global $wp_admin_bar;
				$wp_admin_bar->remove_menu('my-sites');
				$wp_admin_bar->remove_menu('site-name');
				$wp_admin_bar->remove_menu('new-content');
				$wp_admin_bar->remove_menu('search');
				$wp_admin_bar->remove_menu('updates');
			}

			/**
			 * Remove dashboard meta.
			 *
			 */
			function cfc_wp_remove_dashboard_meta() {
				remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
				remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
				remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
				remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
				remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
				remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
				remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
			}

			/**
			 * Remove footer in admin.
			 */
			function cfc_wp_replace_footer_admin () {
				echo '<span id="footer-thankyou"></span>';
			}

			/**
			 * Remove footer version.
			 *
			 * @return string
			 */
			function cfc_wp_replace_footer_version() {
				return ' ';
			}

			/**
			 * Removes contextual help from admin.
			 *
			 */
			function cfc_wp_remove_contextual_help() {
				$screen = get_current_screen();
				$screen->remove_help_tabs();
			}

			/**
			 * Registers head for admin.
			 *
			 */
			function cfc_wp_admin_register_head() {
				echo "<style>#header-logo, #icon-plugins, #wphead h1 a span, #wphead #site-visit-button, #privacy-on-link, #favorite-actions, #contextual-help-link-wrap, #icon-index, .icon32, #user_info p > a[href=\'profile.php\'], #wpfooter {display:none;}</style>";
			}

			/**
			 * Removes editor menu.
			 *
			 */
			function cfc_wp_remove_editor_menu() {
				remove_action('admin_menu', '_add_themes_utility_last', 101);
			}

			/**
			 * Adds admin page.
			 *
			 */
			function cfc_wp_plugin_admin_add_page() {
				// add_meta_box('User Guide', 'User Guide', 'cfc_wp_plugin_options_page', 'post', 'side', 'default', null );
			}

			/**
			 * Adds passing stats.
			 *
			 */
			function cfc_wp_plugin_options_page() {
				$dollar  = '<div class="wrap">';
				$dollar .= '<p>Passing Stats excel table header replacer</p>'.PHP_EOL;
				$dollar .= '<pre>[passstats]'.PHP_EOL;
				$dollar .= '&lt;table class="tablesorter"&gt;'.PHP_EOL;
				$dollar .= '&lt;thead&gt;&lt;tr&gt;'.PHP_EOL;
				$dollar .= '&lt;th&gt;Name&lt;/th&gt;'.PHP_EOL;
				$dollar .= '&lt;th&gt;Completed&lt;/th&gt;'.PHP_EOL;
				$dollar .= '&lt;th&gt;Misplaced&lt;/th&gt;'.PHP_EOL;
				$dollar .= '&lt;th&gt;Total&lt;/th&gt;'.PHP_EOL;
				$dollar .= '&lt;th&gt;Comp %&lt;/th&gt;'.PHP_EOL;
				$dollar .= '&lt;th&gt;% of team’s'.PHP_EOL;
				$dollar .= '&lt;br/&gt;completed&lt;/th&gt;'.PHP_EOL;
				$dollar .= '&lt;th&gt;% of team’s'.PHP_EOL;
				$dollar .= '&lt;br/&gt;misplaced&lt;/th&gt;'.PHP_EOL;
				$dollar .= '&lt;th&gt;% of team’s'.PHP_EOL;
				$dollar .= '&lt;br/&gt;attempted&lt;/th&gt;'.PHP_EOL;
				$dollar .= '&lt;/tr&gt;&lt;/thead&gt;&lt;tbody&gt;'.PHP_EOL;
				$dollar .= '</pre>'.PHP_EOL;
				$dollar .= '</div>';

				print $dollar;
			}

			/**
			 * Removes crap from user profile.
			 *
			 * @param $contactmethods
			 * @return mixed
			 */
			function cfc_wp_extra_contact_info($contactmethods) {
				unset($contactmethods['aim']);
				unset($contactmethods['yim']);
				unset($contactmethods['jabber']);
				unset($contactmethods['description']);

				return $contactmethods;
			}

			/**
			 * Adds all settings page.
			 *
			 */
			function cfc_wp_all_settings_link() {
				add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
			}

			/**
			 * Adds logo to login.
			 *
			 */
			function cfc_wp_custom_login_logo() {
				echo '<style type="text/css">
				body.login #login{padding-top:50px;}
				body.login h1 a{
				  display:none;
				}

				body.login{
				  background-image: url("https://thechels.co.uk/media/uploads/abg.png");
				  background-size:cover;
				}

				body.login #nav{
				  display:none;
				 /* hides forgotten password links*/
				}

				body.login #backtoblog{
				 display:none;
				}
			  </style>';
			}

			/**
			 * Adds url to login header.
			 *
			 * @return string|void
			 */
			function cfc_wp_login_header_url() {
				return home_url('/');
			}

			/**
			 * Adds title to login.
			 *
			 * @return string|void
			 */
			function cfc_wp_login_header_title() {
				return get_bloginfo('title', 'ChelseaStats' );
			}

			/**
			 * Deletes expired transients.
			 *
			 */
			function cfc_wp_delete_expired_db_transients() {
				global $wpdb, $_wp_using_ext_object_cache;
				if( $_wp_using_ext_object_cache )
					return;
				$time = isset ( $_SERVER['REQUEST_TIME'] ) ? (int)$_SERVER['REQUEST_TIME'] : time() ;
				$expired = $wpdb->get_col( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE '_transient_timeout%' AND option_value < {$time};" );
				foreach( $expired as $transient ) {
					$key = str_replace('_transient_timeout_', '', $transient);
					delete_transient($key);
				}
			}

			/**
			 * Adds extra info to glance table.
			 *
			 */
			function cfc_wp_at_glance_content_table_end() {
				$args = array(
					'public' => true,
					'_builtin' => false
				);
				$output = 'object';
				$operator = 'and';

				$post_types = get_post_types( $args, $output, $operator );
				foreach ( $post_types as $post_type ) {
					$num_posts = wp_count_posts( $post_type->name );
					$num = number_format_i18n( $num_posts->publish );
					$text = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );
					if ( current_user_can( 'edit_posts' ) ) {
						$output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
						echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
					} else {
						$output = '<span>' . $num . ' ' . $text . '</span>';
						echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
					}
				}
			}

			/**
			 * Adds author filter to admin.
			 *
			 */
			function cfc_wp_author_filter() {
				// add author filter to WordPress posts admin
				$args = array('name' => 'author', 'show_option_all' => 'View all authors');
				if (isset($_GET['user'])) {
					$args['selected'] = $_GET['user'];
				}
				wp_dropdown_users($args);
			}

			/**
			 * Change admin colour.
			 *
			 * @return string
			 */
			function cfc_wp_change_admin_color() {

				return 'blue';
			}

			/**
			 * Adds favicon to admin.
			 *
			 */
			function cfc_wp_admin_favicon() {

				echo '
		<!-- iPad, retina, portrait -->
		<link href="//m.thechels.uk/img/apple-touch-startup-image-1536x2008.png"
		      media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)"
		      rel="apple-touch-startup-image">
		<!-- iPad, retina, landscape -->
		<link href="//m.thechels.uk/img/apple-touch-startup-image-1496x2048.png"
		      media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)"
		      rel="apple-touch-startup-image">
		<!-- iPad, portrait -->
		<link href="//m.thechels.uk/img/apple-touch-startup-image-768x1004.png"
		      media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)"
		      rel="apple-touch-startup-image">
		<!-- iPad, landscape -->
		<link href="//m.thechels.uk/img/apple-touch-startup-image-748x1024.png"
		      media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)"
		      rel="apple-touch-startup-image">
		<!-- iPhone 5 -->
		<link href="//m.thechels.uk/img/apple-touch-startup-image-640x1096.png"
		      media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"
		      rel="apple-touch-startup-image">
		<!-- iPhone, retina -->
		<link href="//m.thechels.uk/img/apple-touch-startup-image-640x920.png"
		      media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)"
		      rel="apple-touch-startup-image">
		<!-- iPhone -->
		<link href="//m.thechels.uk/img/apple-touch-startup-image-320x460.png"
		      media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)"
		      rel="apple-touch-startup-image">
		<link rel="apple-touch-icon-precomposed" sizes="57x57"      href="//m.thechels.uk/img/apple-touch-icon-iphone.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72"      href="//m.thechels.uk/img/apple-touch-icon-ipad.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114"    href="//m.thechels.uk/img/apple-touch-icon-iphone4.png">
		<link rel="apple-touch-icon-precomposed" sizes="144x144"    href="//m.thechels.uk/img/apple-touch-icon-ipad3.png">
		<link rel="Shortcut Icon" href="//m.thechels.uk/img/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="//m.thechels.uk/img/favicon.png" type="image/png">';

			}

			/**
			 * Sets From system email address.
			 *
			 * @return string
			 */
			function cfc_wp_mailFrom() {
				return 'website@thechels.uk';
			}

			/**
			 * Sets From Name in system email
			 * @return string
			 */
			function cfc_wp_mailFromName() {
				return 'website@thechels.uk';
			}

			/**
			 * Make twitter username stuff happy.
			 *
			 * @param $content
			 * @return mixed
			 */
			function cfc_wp_twitterUsername($content) {

				return preg_replace('/\B\@([a-zA-Z0-9_]{1,20})/', "<a href='https://twitter.com/$1'>$0</a>", $content);

			}

			/**
			 * Make twitter hash stuff happy.
			 *
			 * @param $content
			 * @return mixed
			 */
			function cfc_wp_twitterHash($content) {

				return preg_replace('/([^a-zA-Z0-9-_&])##([0-9a-zA-Z_]+)/',"$1<a href=\"https://twitter.com/search?q=%23$2\" target=\"_blank\">#$2</a>",$content);

			}

			/**
			 * Lowercases title.
			 * @param $title
			 * @return string
			 */
			function cfc_wp_lowertitle($title)  {

				$title = strtolower($title);
				return $title;
			}

			/**
			 * Remove underscores.
			 *
			 * @param $title
			 * @return mixed
			 */
			function cfc_wp_removeunderscores($title) {

				$title = str_replace('_',' ',$title);
				return $title;
			}

			/**
			 * Fix title case.
			 *
			 * @param $title
			 * @return string
			 */
			function cfc_wp_fixtitle($title) {

				$small_words_array = array( 'of','a','the','and','an','or','nor','but','is','if','then','else','when', 'at','from','by','on','off','for','in','out','over','to','into','with' );
				$words = explode(' ', $title);
				foreach ($words as $key => $word) {

					if ($key == 0 or !in_array($word, $small_words_array)) $words[$key] = ucwords($word);
				}

				$new_title = implode(' ', $words);
				return $new_title;

			}

			/**
			 * Removes Pagenavi styles.
			 *
			 */
			function cfc_wp_deregister_styles() {

				wp_deregister_style( 'wp-pagenavi' );
				wp_deregister_style( 'page-list-style' );

			}

			/**
			 * @param $headers
			 * @return mixed
			 */
			function cfc_wp_setHeaders($headers) {

				$headers['Hello-Scraper'] = "Scraping is welcome, data on pages are in well-formed tables. Please cache results and consider server costs & load.";
				$headers['Hello-Donater'] = "Donations welcome see https://thechels.co.uk/support for details.";
				$headers['X-Hello-Human'] = "Say hello to @ChelseaStats on twitter.";

				return $headers;
			}
		}

		new modifier;

	endif;
