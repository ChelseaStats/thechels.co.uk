<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$updater                = new updater();
	$melinda                = new melinda();
	$go                     = new utility();
	$startingValue          = $go->getSeasonalDate( date('Y-m-d') );
	$yearMarker             = $go->getYearMarkerFromDate( $startingValue );
	$shortId                = $go->getShortDateID( $yearMarker );
	$baseFootballDataTable  = "o_tempFootballData{$yearMarker}";	$footballData           = "http://www.football-data.co.uk/mmz4281/{$shortId}/E0.csv";
	$return = $updater->createFootballDataBase( $baseFootballDataTable, $footballData );
	
	if(isset($return) && $return > 0) {
	 	$one =	$updater->updater_shots( $baseFootballDataTable);
		$two =	$updater->updater_shotsOnTarget( $baseFootballDataTable);
		$thr =	$updater->updater_fouls( $baseFootballDataTable);
		$melinda->goSlack( "Football-Data updated, {$one}, {$two}, {$thr}", "UpdaterBot", "package", "bots" );
	}