<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	$wsl = new summaries();

	$messages = $wsl->wslHistory();
	$wsl->arrayToTweets($messages, 'wsl');

	$messages = $wsl->wslThisSeason();
	$wsl->arrayToTweets($messages, 'wsl');

	$messages = $wsl->wslScoringFirst();
	$wsl->arrayToTweets($messages, 'wsl');

	$messages = $wsl->wslWinningHalfTime();
	$wsl->arrayToTweets($messages, 'wsl');

	$messages = $wsl->wslLosingHalfTime();
	$wsl->arrayToTweets($messages, 'wsl');

	$messages = $wsl->wsl2ThisSeason();
	$wsl->arrayToTweets($messages, 'wsl');

	$messages = $wsl->wsl2History();
	$wsl->arrayToTweets($messages, 'wsl');