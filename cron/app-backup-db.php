<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	$up = new updater();
	$up->getCurlResponse( 'https://thechels.co.uk/wp-cron.php?_nonce=04f9d384&backwpup_run=runext&jobid=2' ); //db
	$melinda->goSlack('Backup for DB is complete', 'BackUpBot','robot_face','bots');