<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/cooker.php";
	
	class CookerTests extends PHPUnit_Framework_TestCase {
		
		public function testRememberJs() {

			$cooker = new cooker();

			$this->expectOutputString( '<script>document.getElementById(\'rememberme\').checked = true; document.getElementById(\'user_login\').focus();</script>' );
			$cooker->wp_cfc_remember_js();
		}

		public function testRememberCookieExpiration() {

			$cooker = new cooker();
			$this->assertTrue( 31536000 === $cooker->wp_cfc_remember_cookie());
		}
		
		public function testwSetCookieExpireFilter() {

			$cooker = new cooker();
			$output = $cooker->wp_cfc_set_cookie_expire_filter( 1, 1);

			$this->assertTrue( 604800 == $output );
		}
		
	}
	