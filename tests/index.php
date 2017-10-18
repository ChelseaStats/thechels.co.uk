<?php
// silence is golden

	/**
	 * Mocking WP method.
	 * @return bool
	 */
	 function add_action() { return true; }

	/**
	 * Mocking WP method.
	 * @return bool
	 */
	 function add_filter() { return true; }

	/**
	 * Mocking WP Method
	 * @return bool
	 */
	function add_shortcode() { return true; }

	/**
	 * Mocking WP Method
	 * @return bool
	 */
	function shortcode_atts() { return array("href" => 'https://'); }

	/**
	 * Mocking WP Method
	 * @return bool
	 */
	function antispambot()  { return true; }

	/**
	 * Mocking WP Method
	 * @return array
	 */
	function get_pages() {

		$array = [ "1" => "2", "ID" => '2', '5' => '3'];
		return $array;
	}

	/**
	 * Mocking WP Method
	 * @return string
	 */
	function get_page_link() {
		
		$array = [ "1" => "2", "ID" => '2', '5' => '3'];
		return $array;
	}

	/**
	 * Mocking WP Method
	 * @return bool
	 */
	function is_admin() { return true; }

	/**
	 * Mocking WP Method
	 * @return bool
	 */
	function plugin_basename() { return true; }

	/**
	 * Mocking WP Method
	 * @return bool
	 */
	function get_option() { return true; }

	/**
	 * @return string
	 */
	function home_url() { return '/';}