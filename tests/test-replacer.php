<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/replacer.php";
	
	class replacerTests extends PHPUnit_Framework_TestCase {

		public function testReplaceContent(){

			$replacer = new replacer();

			$a = 'content';
			$b = $replacer->replace_content('content');
			$this->assertTrue ( $a == $b);

			$a = '<div class="table-container"><table class="tablesorter">';
			$b = $replacer->replace_content('<table class="tablesorter">');
			$this->assertTrue ( $a == $b);

			$a = '<div class="table-container-small"><table class="tablesorter">';
			$b = $replacer->replace_content('<table class="tablesorter small">');
			$this->assertTrue ( $a == $b);

			$a = '</table></div>';
			$b = $replacer->replace_content('</table>');
			$this->assertTrue ( $a == $b);
		}

		public function testCFCReplaceContentPre(){

			$replacer = new replacer();

			$a = 'content';
			$b = $replacer->cfc_replace_content_pre('content');
			$this->assertTrue ( $a == $b);

			$a = '<a href="https://thechels.co.uk/analysis-ladies/competition-analysis/?comp=WSL">FAWSL</a>';
			$b = $replacer->cfc_replace_content_pre('FAWSL');
			$this->assertTrue ( $a == $b);


			$a = '<a href="https://thechels.co.uk/analysis/referees/?ref=DOWD,PHIL">Phil Dowd</a>';
			$b = $replacer->cfc_replace_content_pre('^_PhilDowd');
			$this->assertTrue( $a == $b);

		}
	}