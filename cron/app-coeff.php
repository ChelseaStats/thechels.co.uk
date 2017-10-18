<?php
	// Run cron Thurs 22:00
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	$pdo = new pdodb();
	$pdo->query("SELECT X_COMPS AS x_comp FROM cfc_fixtures ORDER BY F_DATE desc limit 1");
	$row = $pdo->row();
	if(isset($row) && $row['x_comp'] == 0) :
		$melinda->goSlack("Please update your UEFA Coefficients", 'Coefficent Bot','robot_face', 'bots');
	endif;
	exit();
