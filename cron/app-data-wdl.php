<?php
	error_reporting('E_ALL');
	ini_set('display_errors', 1);
	require_once( dirname(__DIR__).'/autoload.php');
	$updater    = new updater();
	$melinda    = new melinda();
	$wslyear    = date("Y");
	$messages   = "Updating WDL...".PHP_EOL;
	$messages  .= $updater->updateWDL('WDL South' , 'all_results_wdl_south'   , '627893283' );
	$messages  .= $updater->updateWDL('WDL North' , 'all_results_wdl_north'   , '307682937' );
	$melinda->goSlack( $messages , 'UpdaterBot', 'soccer', 'bots' );
