<?php
	/*
	Plugin Name: CFC Checklist Class
	Description: Allows the auto-creation of checklists (markdown).
	License: GPL
	Version: 3.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	/**
	 * Class checklister
	 */
	class checklister {

		/**
		 * @param $x
		 * @param $body
		 * @return string
		 */
		function generateIssue( $x, $body ) {
			$clientId     = '*****';
			$clientSecret = '*****';
			$token        = '*****';
			$token        = new Milo\Github\OAuth\Token( $token );
			$api          = new Milo\Github\Api;
			$api->setToken( $token );
			
			$urlPath       = 'https://api.github.com/repos/*****';
			$content       = array ( 'title' => $x, 'body' => $body, 'token' => $token );
			$parameters    = array ( '' );
			$headers_array = array ( '' );

			$response = $api->post( $urlPath, $content, $parameters, $headers_array );
			//$response = $api->createRequest('POST', $urlPath, $parameters, $headers_array, $content);
    		

			$client = new Milo\Github\Http\CurlClient;

			$client->onRequest(function(Milo\Github\Http\Request $request) {
				var_dump($request);
			});

			$client->onResponse(function(Milo\Github\Http\Response $response) {
				var_dump($response);
			});


			if ( $response && $response != '' && isset($token) && $token !='') {

				return "<div class='alert alert-warning'>Issue created...</div>";
			}
			
			return "<div class='alert alert-danger'>Issue creation failed</div>";
		}

		/**
		 * @return string
		 */
		function checklist_cfc_results() {

			$string = "".PHP_EOL;
			$string .= "> CFC Results".PHP_EOL;
			$string .= "".PHP_EOL;
			$string .= "- [ ] Add CFC result to `cfc_fixtures`.".PHP_EOL;
			$string .= "- [ ] Run Process Events and Player Stats".PHP_EOL;
			$string .= "- [ ] Run Minutes".PHP_EOL;
			$string .= "- [ ] Check goalkeeper clean sheets.".PHP_EOL;
			$string .= "- [ ] Add milestones and key events to `cfc_dates`.".PHP_EOL;
			$string .= "- [ ] Add info/key stats to `AppStats`".PHP_EOL;
			$string .= "- [ ] Process Shots flow".PHP_EOL;
			$string .= "- [ ] Run cfc-flot-imager".PHP_EOL;
			$string .= "- [ ] Run get stat shots".PHP_EOL;
			$string .= "- [ ] run Workflows for images".PHP_EOL;
			$string .= "- [ ] Do Statszone, workflow  + upload".PHP_EOL;
			$string .= "- [ ] If no more league games then process Drafter TBL".PHP_EOL;
			$string .= "- [ ] If no more league games then process Drafter CFC".PHP_EOL;
			$string .= "- [ ] Review and re-save each article and set to pending.".PHP_EOL;
			$string .= "- [ ] Check Audit for errors".PHP_EOL;
			$string .= "- [ ] Copy Data day from CFC to `TOCFCWS` github".PHP_EOL;
			$string .= "- [ ] Copy Caley_Graphics to Instagram".PHP_EOL;
			$string .= "- [ ] Copy 11gen11 graphics to Instagram".PHP_EOL;
			$string .= "- [ ] Update uefa coefficients if game warrants (European)".PHP_EOL;
			return $string;
		}

		/**
		 * @return string
		 */
		function checklist_cfc_results_nonPL() {

			$string = "".PHP_EOL;
			$string .= "> CFC Results".PHP_EOL;
			$string .= "".PHP_EOL;
			$string .= "- [ ] Add CFC result to `cfc_fixtures`.".PHP_EOL;
			$string .= "- [ ] Run Process Events and Player Stats".PHP_EOL;
			$string .= "- [ ] Run Minutes".PHP_EOL;
			$string .= "- [ ] Check goalkeeper clean sheets.".PHP_EOL;
			$string .= "- [ ] Add milestones and key events to `cfc_dates`.".PHP_EOL;
			$string .= "- [ ] Add info/key stats to `AppStats`".PHP_EOL;
			$string .= "".PHP_EOL;
			$string .= "> Images".PHP_EOL;
			$string .= "".PHP_EOL;
			$string .= "- [ ] Process Shots flow + Chances by minutes".PHP_EOL;
			$string .= "- [ ] Save as images".PHP_EOL;
			$string .= "- [ ] Run cfc-flot-imager".PHP_EOL;
			$string .= "- [ ] Run get stat shots".PHP_EOL;
			$string .= "- [ ] Screenshot Shot Locations".PHP_EOL;
			$string .= "- [ ] Run cfc-shots-imager".PHP_EOL;
			$string .= "- [ ] Pick and save Statszone".PHP_EOL;
			$string .= "- [ ] Run cfc-statszone-imager".PHP_EOL;
			$string .= " ".PHP_EOL;
			$string .= "- [ ] Update uefa coefficients if game warrants (European)".PHP_EOL;
			$string .= "- [ ] Copy Data day from CFC to `TOCFCWS` github".PHP_EOL;
			$string .= "- [ ] Copy MC_of_A to Dropbox".PHP_EOL;
			$string .= "- [ ] Check Audit for errors".PHP_EOL;

			return $string;

		}

		/**
		 * @return string
		 */
		function checklist_finance() {

			$string  = "".PHP_EOL;
			$string .= "> Chelsea FC PLC (02536231) or CHELSEA FOOTBALL CLUB LIMITED  (01965149)" . PHP_EOL;
			$string .= "".PHP_EOL;
			$string .= "- [ ] Year".PHP_EOL;
			$string .= "- [ ] Turnover".PHP_EOL;
			$string .= "- [ ] Profit/Loss".PHP_EOL;
			$string .= "- [ ] Wage".PHP_EOL;
			$string .= "- [ ] STRGL".PHP_EOL;
			$string .= "- [ ] Transfer".PHP_EOL;
			$string .= "- [ ] Squad".PHP_EOL;
			$string .= "- [ ] Ratio (wage / turnover)*10".PHP_EOL;
			$string .= "- [ ] player staff".PHP_EOL;
			$string .= "- [ ] non-playing staff".PHP_EOL;
			$string .= "- [ ] total staff".PHP_EOL;
			$string .= "- [ ] average salary (wage/total staff)".PHP_EOL;
			$string .= "- [ ] Check Flots".PHP_EOL;
			$string .= "".PHP_EOL;



			return $string;
		}

		/**
		 * @return string
		 */
		function checklist_wsl_results() {

				$string  = "".PHP_EOL;
				$string .= "> WSL + WDL Results" . PHP_EOL;
				$string .= "".PHP_EOL;
				$string .= "- [ ] Run Process `WSL` & `WDL`" . PHP_EOL;
				$string .= "- [ ] Add result to `wsl_fixtures`." . PHP_EOL;
				$string .= "- [ ] Add match events" . PHP_EOL;
				$string .= "- [ ] Add player stats" . PHP_EOL;
				$string .= "- [ ] Add milestones and key events to `cfc_dates`." . PHP_EOL;
				$string .= "- [ ] Add info/key stats to `AppStats`" . PHP_EOL;
				$string .= "- [ ] Download youtube highlights" . PHP_EOL;
				$string .= "- [ ] If no more league games then process Drafter WSL".PHP_EOL;
				$string .= "- [ ] Review and re-save each item as pending.".PHP_EOL;
				$string .= "- [ ] Check Audit for errors".PHP_EOL;

				return $string;
			}

		/**
		 * @return string
		 */
		function checklist_new_manager() {

				$string  = "".PHP_EOL;
				$string .= "> New Manager".PHP_EOL;
				$string .= "".PHP_EOL;
				$string .= "- [ ] Add name to `cfc_dob`".PHP_EOL;
				$string .= "- [ ] Add name to `cfc_fun`".PHP_EOL;
				$string .= "- [ ] Add record to `cfc_managers` or `wsl_managers`".PHP_EOL;
				$string .= "- [ ] Add record to `cfc_dates`".PHP_EOL;
				$string .= "- [ ] Add extra data to graph on managers page".PHP_EOL;
				$string .= "- [ ] Write custom tables if returning manager".PHP_EOL;

				return $string;
			}

		/**
		 * @return string
		 */
		function checklist_old_manager() {

				$string  = "".PHP_EOL;
				$string .= ">  Old Manager".PHP_EOL;
				$string .= "".PHP_EOL;
				$string .= "- [ ] Add end date to `cfc_managers` or  `wsl_managers` for previous incumbent".PHP_EOL;
				$string .= "- [ ] Add record to `cfc_dates` for previous incumbent".PHP_EOL;
				$string .= "- [ ] Rewrite custom tables if exists".PHP_EOL;


			return $string;
			}

		/**
		 * @return string
		 */
		function checklist_new_player() {

				$string  = "".PHP_EOL;
				$string .= "> New Player".PHP_EOL;
				$string .= "".PHP_EOL;
				$string .= "- [ ] Add dob `cfc_dobs`".PHP_EOL;
				$string .= "- [ ] Add name `cfc_fun`".PHP_EOL;
				$string .= "- [ ] Add player to `meta_wsl_squadno` or to `meta_squadno` - end date is null".PHP_EOL;
				$string .= "- [ ] Add player to `cfc_players` or `wsl_players` including position and DOB".PHP_EOL;
				$string .= "- [ ] Add player (if keeper) to `cfc_cleansheets`".PHP_EOL;
				$string .= "- [ ] Add player to Glossary page (nicknames) if one exists".PHP_EOL;
				
				return $string;
			}

		/**
		 * @return string
		 */
		function checklist_old_player() {

				$string  = "".PHP_EOL;
				$string .= "> Old Player".PHP_EOL;
				$string .= "".PHP_EOL;
				$string .= "- [ ] Add record to `cfc_dates`".PHP_EOL;
				$string .= "- [ ] Update `squadno` table with end date".PHP_EOL;
				$string .= "- [ ] Update `cfc_explayers` with end stats".PHP_EOL;
				$string .= "- [ ] Update players(passing) excel file".PHP_EOL;

				return $string;
			}

		/**
		 * @return string
		 */
		function checklist_end_of_season() {

				$string  = "".PHP_EOL;
				$string .= "> End of Season".PHP_EOL;
				$string .= "".PHP_EOL;
				$string .= "- [ ] Update `cfc_positions` with new end of year data".PHP_EOL;
				$string .= "- [ ] Update positions page graphs with new end of year data".PHP_EOL;
				$string .= "- [ ] Recalculate average attendances and update `cfc_positions`".PHP_EOL;
				$string .= "- [ ] Do stats analysis (ebooks) and publish".PHP_EOL;
				$string .= "- [ ] Check final clean sheets table".PHP_EOL;
				$string .= "- [ ] Update OnThisDay records".PHP_EOL;

				return $string;
			}

	 	/**
		 * @return string
		 */
		function checklist_new_wsl_season() {

		   	$string  = "".PHP_EOL;
		   	$string .= "> New Season".PHP_EOL;
			$string .= "".PHP_EOL;
			$string .= "- [ ] Update label values in ISG script".PHP_EOL;
			$string .= "- [ ] Update teams in 000_configs".PHP_EOL;
			$string .= "```".PHP_EOL;
			$string .= "UPDATE 000_configs SET F_VALUE = '1st' where F_FIELD ='WSL_PROMOTED1'; ".PHP_EOL;
			$string .= "UPDATE 000_configs SET F_VALUE = '9th' where F_FIELD ='WSL_RELEGATED1';".PHP_EOL;
			$string .="```".PHP_EOL;
			$string .= "- [ ] Update date stamps in meta_seasons".PHP_EOL;
			$string .= "- [ ] Update date stamps in 000_config".PHP_EOL;
			$string .= "```".PHP_EOL;
			$string .= "UPDATE 000_config SET F_DATE ='2016-01-01' WHERE F_LEAGUE = 'WSL';  ".PHP_EOL;
			$string .= "UPDATE 000_config SET F_DATE ='2015-01-01' WHERE F_LEAGUE = 'WSLm1';".PHP_EOL;
			$string .= "```".PHP_EOL;

			return $string;
		}

	 	/**
		 * @return string
		 */
		function checklist_new_pl_season() {

			$u = new utility();
			$d = $u->getYearMarkerFromDate( date('Y-m-d'));

		   	$string  = "".PHP_EOL;
		   	$string .= "> New Season".PHP_EOL;
			$string .= "".PHP_EOL;
			$string .= "- [ ] Update label values in ISG script".PHP_EOL;
			$string .= "- [ ] Update teams (3 up 3 down) in 000_configs".PHP_EOL;
			$string .= "```".PHP_EOL;
			$string .= "UPDATE 000_configs SET F_VALUE = '1st' where F_FIELD ='PROMOTED1';".PHP_EOL;
			$string .= "UPDATE 000_configs SET F_VALUE = '2nd' where F_FIELD ='PROMOTED2';".PHP_EOL;
			$string .= "UPDATE 000_configs SET F_VALUE = '3rd' where F_FIELD ='PROMOTED3';".PHP_EOL;
			$string .= "UPDATE 000_configs SET F_VALUE = '18th' where F_FIELD ='RELEGATED1';".PHP_EOL;
			$string .= "UPDATE 000_configs SET F_VALUE = '19th' where F_FIELD ='RELEGATED2';".PHP_EOL;
			$string .= "UPDATE 000_configs SET F_VALUE = '20th' where F_FIELD ='RELEGATED3';".PHP_EOL;
			$string .= "```".PHP_EOL;
			$string .= "- [ ] Update date stamps in meta_seasons".PHP_EOL;
			$string .= "- [ ] Update date stamps in 000_config (month should be 07 to match meta_seasons)".PHP_EOL;
			$string .= "```".PHP_EOL;
			$string .= "UPDATE 000_config SET F_DATE ='2017-07-01' WHERE F_DATE = '2016-07-01';".PHP_EOL;
			$string .= "UPDATE 000_config SET F_DATE ='2016-07-01' WHERE F_LEAGUE = 'PLm1';".PHP_EOL;
			$string .= "UPDATE 000_config SET F_DATE ='2015-07-01' WHERE F_LEAGUE = 'PLm2';".PHP_EOL;
			$string .= "UPDATE 000_config SET F_DATE ='2014-07-01' WHERE F_LEAGUE = 'PLm3';".PHP_EOL;
			$string .= "UPDATE 000_config SET F_DATE ='2017-12-31' WHERE F_LEAGUE = 'cutoff';".PHP_EOL;
			$string .= "```".PHP_EOL;
			$string .= "- [ ] Create base football data table with following code:".PHP_EOL;
			$string .= "```".PHP_EOL;
			$string .= "CREATE TABLE o_tempFootballData{$d} as ".PHP_EOL;
			$string .= "select * from o_tempFootballData201617 where 1=2;".PHP_EOL;
			$string .= "```".PHP_EOL;


			return $string;
		}

	}
