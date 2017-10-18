<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/identifier.php";
	
	class IdentifierTests extends PHPUnit_Framework_TestCase {

		public function testSidColumnReturnValue() {

			$id = new identifier();

			$this->assertTrue( 'idfield' == $id->cfc_wp_sid_return_value( 'value', 'cfc_wp_sid', 'idfield' ) );
			$this->assertTrue( 'value' == $id->cfc_wp_sid_return_value( 'value', 'junk', 'idfield' ) );

		}
		
		public function testSidColumnValueOutput() {

			$id = new identifier();

			$this->expectOutputString('idfield');
			$id->cfc_wp_sid_value('cfc_wp_sid', 'idfield');

		}

		public function testSidColumnhasArrayKey() {

			$id = new identifier();
			$cols = array();
			$this->assertArrayHasKey('cfc_wp_sid', $id->cfc_wp_sid_column($cols));
		}

		public function testSidColumnStylePrint() {

			$id =  new identifier();
			$this->expectOutputString('<style type = "text/css">#cfc_wp_sid { width: 40px; }</style>');
			$id->cfc_wp_sid_css();
		}

	}
	