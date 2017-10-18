<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/melinda.php";
	
	class MelindaTests extends PHPUnit_Framework_TestCase {

		public function testGoMessageReturnsString() {

			$m = new melinda();

			$this->assertTrue('<div class="alert alert-alert">message</div>' == $m->goMessage('message','alert'));

		}

		public function testGoDebugOutput() {

			$m = new melinda();
			$var = 'bob';
			$this->expectOutputString('<hr/>type: string<pre>bob</pre><hr/>');
			$m->goDebug($var);
		}

		public function testGoSlack() {

			$m = new melinda();
			$this->assertTrue( true == $m->goSlack('This is just a test','TestBot','robot_face','bots'));
		}
		
	}
	