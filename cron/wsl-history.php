<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	$pdo = new pdodb();
	$go = new utility();
	
	$pdo->query("SELECT F_HOME, F_HGOALS, F_AGOALS, F_AWAY, F_DATE FROM all_results_wsl_one WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now())) AND YEAR(F_DATE)!=(SELECT YEAR(now()))");
	$rows = $pdo->rows();
	foreach($rows as $row) {
		$R  = ''; //default
		$H  = $go->_V($row['F_HOME']);
		$A  = $go->_V($row['F_AWAY']);
        $HG = $row['F_HGOALS'];
        $AG = $row['F_AGOALS'];
        $D  = $go->_Y($row['F_DATE']);
	         if ($HG > $AG)  { $R =  'won'; };
	         if ($HG < $AG)  { $R = 'lost'; };
	         if ($HG == $AG) { $R = 'drew'; };
         $melinda->goTweet("On This Day ($D) $H $R at home to $A  $HG-$AG in the #FAWSL",'wsl');

    }

	$pdo->query("SELECT F_HOME, F_HGOALS, F_AGOALS, F_AWAY, F_DATE FROM all_results_wsl_two WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now())) AND YEAR(F_DATE)!=(SELECT YEAR(now()))");
	$rows = $pdo->rows();
	foreach($rows as $row) {
		$R  = ''; //default
		$H  = $go->_V($row['F_HOME']);
		$A  = $go->_V($row['F_AWAY']);
		$HG = $row['F_HGOALS'];
		$AG = $row['F_AGOALS'];
		$D  = $go->_Y($row['F_DATE']);
			if ($HG > $AG)  { $R =  'won'; };
			if ($HG < $AG)  { $R = 'lost'; };
			if ($HG == $AG) { $R = 'drew'; };
		$melinda->goTweet("On This Day ($D) $H $R at home to $A  $HG-$AG in the #FAWSL2",'wsl');
	}

