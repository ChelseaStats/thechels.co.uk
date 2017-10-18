<?php
	error_reporting('E_ALL');
	ini_set('display_errors', 1);
	require_once( dirname(__DIR__).'/autoload.php');
	$updater    = new updater();
	$melinda    = new melinda();
	$wslyear    = date("Y");
	$messages   = "Updating WSL for {$wslyear}...".PHP_EOL;
	// $messages  .= $updater->UpdateWSL('WSL 1'     , 'all_results_wsl_one'     , 1, $wslyear );
	// $messages  .= $updater->UpdateWSL('WSL 2'     , 'all_results_wsl_two'     , 2, $wslyear );
	$melinda->goSlack( $messages , 'UpdaterBot', 'soccer', 'bots' );
