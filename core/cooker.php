<?php
	/*
	Plugin Name: CFC Cooker
	Description: Set the expire time for cookies
	Version: 12.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();
	
	if ( is_admin() ) :

		class cooker {

			function __construct() {

				add_filter('login_footer'              , array($this, 'wp_cfc_remember_js') );
				add_filter('auth_cookie_expiration'    , array($this, 'wp_cfc_remember_cookie') );
				add_filter('auth_cookie_expiration'    , array($this, 'wp_cfc_set_cookie_expire_filter') );
				add_action('admin_init'                , array($this, 'wp_cfc_set_cookie_expire_admin') );

				$plugin = plugin_basename(__FILE__);
				add_filter("plugin_action_links_$plugin", array($this, 'wp_cfc_registerPluginLinks') );
			}

			/**
			 * Register plugin links.
			 *
			 * @param $links
			 * @return mixed
			 */
			function wp_cfc_registerPluginLinks($links) {

					$settings_link = '<a href="options-general.php">Settings</a>';
					array_unshift($links, $settings_link);

				return $links;
			}

			/**
			 * Remember JS.
			 *
			 */
			function wp_cfc_remember_js() {

				echo "<script>document.getElementById('rememberme').checked = true; document.getElementById('user_login').focus();</script>";

			}

			/**
			 * set cookie.
			 *
			 * @return int
			 */
			function wp_cfc_remember_cookie() {

				return 31536000; // one year: 60 * 60 * 24 * 365
			}

			/**
			 * set cookie expiration.
			 *
			 */
			function wp_cfc_set_cookie_expire_admin() {
				foreach ( array ( 'normal' => 'Normal', 'remember' => 'Remember' ) as $type => $label ) {
					register_setting( 'general', "{$type}_cookie_expire", 'absint' );
					add_settings_field( "{$type}_cookie_expire", $label . ' cookie expire', array ($this, 'wp_cfc_set_cookie_expire_option'), 'general', 'default', $type );
				}
			}

			/**
			 * @param $type
			 */
			function wp_cfc_set_cookie_expire_option( $type ) {
				if ( ! $expires = get_option( "{$type}_cookie_expire" ) ) {
					$expires = $type === 'normal' ? 2 : 14;
				}
				echo '<input type="text" name="' . $type . '_cookie_expire" value="' . intval( $expires ) . '" class="small-text" /> days';
			}

			/**
			 * @param $default
			 * @param $remember
			 * @return int
			 */
			function wp_cfc_set_cookie_expire_filter( $default, $remember ) {
				if ( ! $expires = get_option( $remember ? 'remember_cookie_expire' : 'normal_cookie_expire' ) ) {
					$expires = 1;
				}

				if ( $expires = ( intval( $expires ) * 604800 ) ) // one week 60*60*24*7
				{
					$default = $expires;
				}

				return $default;
			}

		}

		$cooker = new cooker();

	endif;