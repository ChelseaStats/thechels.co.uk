<?php
	/**
	 *  Author 	: ChelseaStats
	 *  Date 	: 2015-05-22
	 *  Url		: https://twitter.com/19thMayBot
	 *  Description : A twitter bot for 'live' tweeting that night in Munich (19th May 2012)
	 *  Match 	: 60 seconds * 165 minutes ( 45 [1H] + 15 + 45 [2H] + 5 + 15 [1H ET] + 5 + 15 [2H ET] + 5 + 15 [pens])
	 *          	- the rest of the time slots are HT, FT, HT ET and pre-pens. comfort breaks.
	 */
	$match = 60*165;
	ini_set('max_execution_time', $match);
	require_once( dirname(__DIR__).'/autoload.php');

	$go = new utility();
	$go->process('/home/thechels/public_html/media/cron/commentary-log.csv');

