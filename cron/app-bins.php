<?php
	// Run cron @ Wed at 16:30 and Thurs 7:15
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	$date = new DateTime("now");
	$week = $date->format("W");
	$string  = "Week: {$week} type:". (($week % 2 == 0) ? "Bin, Garden + Food" : "Boxes + Food" ).PHP_EOL;
	$melinda->goSlack($string, 'RecycleBot','truck', 'bots');
	exit();