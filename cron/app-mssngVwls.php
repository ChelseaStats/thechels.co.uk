<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$go = new utility();
	$pdo = new pdodb();
	$pdo->query("SELECT count(*) as F_VWLS FROM cfc_games WHERE F_VWLS = 0");
	$row = $pdo->row();
	if(isset($row['F_VWLS']) && $row['F_VWLS'] > 1) {
		$go->mssngVwls();
	} else {
		$pdo->query("UPDATE cfc_games SET F_VWLS='0' WHERE F_ID > 0");
		$pdo->execute();
		$go->mssngVwls();
	}