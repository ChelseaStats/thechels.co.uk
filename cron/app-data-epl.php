<?php
	
	error_reporting('E_ALL');
	ini_set('display_errors', 1);

	require_once( dirname(__DIR__).'/autoload.php');

	$pdo             = new pdodb();
	$melinda         = new melinda();
	$updater         = new updater();
	$plResultsTable  = "all_results";
	$SubsUsage_this  = "0V_SubsUsage_this";
	$footballData    = "http://www.football-data.co.uk/mmz4281/1617/E0.csv";
	$urlEPL1         = "http://www.futbol24.com/national/England/Premier-League/2016-2017/results/";
	$messages        = "Updating...".PHP_EOL;

	/** EPL 1 */
	$pdo->query("select count(*) as F_COUNT from {$plResultsTable} where F_DATE > (Select F_DATE from 000_config where F_LEAGUE = 'PL')");
	$row = $pdo->row();
	$original = $row['F_COUNT'];
	$messages .= "Current {$plResultsTable} row count: {$original}.".PHP_EOL;
	$sql = $updater->_processMatchResults( $urlEPL1, '<div class="table loadingContainer">', $plResultsTable );
	$counter    = substr_count($sql, 'INSERT');
	$messages .= "New {$plResultsTable} rows analysed : {$counter}.".PHP_EOL;
	$pdo->query( $sql );
	$pdo->execute();
	$lastRowAndCount = $pdo->lastInsertId() . ' ' . $pdo->rowCount();
	$messages .= "PL Results added: {$lastRowAndCount}.".PHP_EOL;

	/** Subs */
	$pdo->query("select count(*) as F_COUNT from {$SubsUsage_this}");
	$row = $pdo->row();
	$original = $row['F_COUNT'];
	$messages .= "Current {$SubsUsage_this} row count: {$original}.".PHP_EOL;
	$sql = $updater->updater_subsUsage($SubsUsage_this);
	$pdo->query($sql);
	$result = $pdo->execute();
	$pdo->query("select count(*) as F_COUNT from {$SubsUsage_this}");
	$row = $pdo->row();
	$counter = $row['F_COUNT'];
	$messages .= "New {$SubsUsage_this} row count : {$counter}.".PHP_EOL;
	$pdo->query( $sql );
	$pdo->execute();

	/** Miles */
	$pdo->query("SELECT COUNT(*) as CNT FROM 0t_miles");
	$row = $pdo->row();
	$count = $row['CNT'];
	$messages .= "Current milestones row count : {$count}.".PHP_EOL;
	$messages .= "New milestones row count : {$updater->updater_milestones()}.".PHP_EOL;

	/** Last 38 */
	$pdo->query("SELECT COUNT(*) as CNT FROM  0t_last38");
	$row = $pdo->row();
	$count = $row['CNT'];
	$messages .= "Current Last38 row count: {$count}.".PHP_EOL;
	$messages .= "New Last38 row count : {$updater->updater_last38()}.".PHP_EOL;

	$melinda->goSlack( $messages , 'UpdaterBot', 'soccer', 'bots' );
