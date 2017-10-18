<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/modifier.php";
	
	class modifierTests extends PHPUnit_Framework_TestCase {
		
		public function textcfc_wp_change_admin_color() {
			
			$modifier = new modifier();
			$this->assertTrue('blue' === $modifier->cfc_wp_change_admin_color());
		}

		public function testcfc_wp_mailFrom() {

			$modifier = new modifier();
			$this->assertTrue('website@thechels.uk' === $modifier->cfc_wp_mailFrom());
		}

		public function testcfc_wp_mailFromName() {

			$modifier = new modifier();
			$this->assertTrue('website@thechels.uk' === $modifier->cfc_wp_mailFromName());
		}

		public function testcfc_wp_twitterUsername() {

			$modifier = new modifier();
			$first = "<a href='https://twitter.com/chelseastats'>@chelseastats</a>";
			$second = $modifier->cfc_wp_twitterUsername("@chelseastats");
			$this->assertTrue( $first == $second);
		}

		public function testcfc_wp_twitterHash() {

			$modifier = new modifier();
			$this->assertTrue('#hash' === $modifier->cfc_wp_twitterHash('#hash'));
		}

		public function testcfc_wp_lowertitle() {

			$modifier = new modifier();

			$this->assertTrue(strtolower('STRING') == $modifier->cfc_wp_lowertitle('STRING'));
		}

		public function testcfc_wp_removeunderscores() {

			$modifier = new modifier();
			$this->assertTrue('he llo' == $modifier->cfc_wp_removeunderscores('he llo'));
		}

		public function testcfc_wp_cfc_wp_fixtitle() {

			$modifier = new modifier();
			$this->assertTrue('Hello Title' == $modifier->cfc_wp_fixtitle('hello title'));
		}

		public function testcfc_wp_change_admin_color() {

			$m = new modifier();
			$output = $m->cfc_wp_change_admin_color();
			$expected = "blue";

			$this->assertTrue($output == $expected);
		}

		public function testcfc_wp_login_header_url() {

			$m = new modifier();
			$output = $m->cfc_wp_login_header_url();
			$expected = "/";
			$this->assertTrue($output == $expected);
		}

		public function testcfc_wp_replace_footer_version() {

			$m = new modifier();
			$output = $m->cfc_wp_replace_footer_version();
			$expected = " ";
			$this->assertTrue($output == $expected);
		}

		public function testcfc_wp_replace_footer_admin() {

			$m = new modifier();
			$m->cfc_wp_replace_footer_admin();
			$expected = '<span id="footer-thankyou"></span>';
			$this->expectOutputString($expected);
		}


	}
