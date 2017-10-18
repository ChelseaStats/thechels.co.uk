<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/checklister.php";
	require __DIR__ . "/../core/Github/Sanity.php";
	require __DIR__ . "/../core/Github/Http/Message.php";
	require __DIR__ . "/../core/Github/Http/Request.php";
	require __DIR__ . "/../core/Github/Http/Response.php";
	require __DIR__ . "/../core/Github/Http/IClient.php";
	require __DIR__ . "/../core/Github/Http/AbstractClient.php";
	require __DIR__ . "/../core/Github/Http/CurlClient.php";
	require __DIR__ . "/../core/Github/Helpers.php";
	require __DIR__ . "/../core/Github/OAuth/Token.php";
	require __DIR__ . "/../core/Github/Api.php";

	
	class ChecklisterTests extends PHPUnit_Framework_TestCase {

		public function testGenerateIssue() {

			$ck = new checklister();

			$this->assertTrue( "<div class='alert alert-warning'>Issue created...</div>" == $ck->generateIssue( '(test) Title', '(test) Body'  ) );


		}

		/**
		 * Test views are create or replace
		 * Test tables are create
		 * Test statements are Select
		 */
		public function testChecklistsForStrings() {

			$check = new checklister();

			$this->assertContains( "- [ ]", $check->checklist_cfc_results());
			$this->assertContains( "- [ ]", $check->checklist_cfc_results_nonPL());
			$this->assertContains( "- [ ]", $check->checklist_finance());
			$this->assertContains( "- [ ]", $check->checklist_wsl_results());
			$this->assertContains( "- [ ]", $check->checklist_new_manager());
			$this->assertContains( "- [ ]", $check->checklist_old_manager());
			$this->assertContains( "- [ ]", $check->checklist_new_player());
			$this->assertContains( "- [ ]", $check->checklist_old_player());
			$this->assertContains( "- [ ]", $check->checklist_end_of_season());
			$this->assertContains( "- [ ]", $check->checklist_new_wsl_season());
			$this->assertContains( "- [ ]", $check->checklist_new_pl_season());
			
		}
	}
	