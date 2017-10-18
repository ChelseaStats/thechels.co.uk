<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda    = new melinda();
	$pdo        = new pdodb();
	$go         = new utility();

	$pdo->query("SELECT Team, SUM(PLD) PLD, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
              FROM 0V_base_WSL1_this GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC");
	$rows = $pdo->rows();
	$i = 1;
    foreach($rows as $row) {
             $OPP = $go->_V($row['Team']);
             $PLD = $row['PLD'];
             $GD  = $row['GD'];
             $PPG = $row['PPG'];
             $PTS = $row['PTS'];
             $melinda->goTweet("#FAWSL Table: ({$i}) {$OPP} PLD: {$PLD} with GD: {$GD}, {$PPG} PPG and {$PTS} PTS.",'wsl');
	         $i++;
     }

	sleep(600);

	$pdo->query("SELECT Team, SUM(PLD) PLD, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
              FROM 0V_base_WSL1 GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC");
	$rows = $pdo->rows();
	$i = 1;
	foreach($rows as $row) {
			$OPP = $go->_V($row['Team']);
			$PLD = $row['PLD'];
			$GD  = $row['GD'];
			$PPG = $row['PPG'];
			$PTS = $row['PTS'];
			$melinda->goTweet("All-time #FAWSL Table: ({$i}) {$OPP} PLD: {$PLD} with GD: {$GD}, {$PPG} PPG and {$PTS} PTS.",'wsl');
			$i++;
	}

	sleep(600);

	$pdo->query("SELECT Team, SUM(PLD) PLD, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
              FROM 0V_base_WSL2_this GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC");
	$rows = $pdo->rows();
	$i = 1;
	foreach($rows as $row) {
			$OPP = $go->_V($row['Team']);
			$PLD = $row['PLD'];
			$GD  = $row['GD'];
			$PPG = $row['PPG'];
			$PTS = $row['PTS'];
			$melinda->goTweet("#FAWSL2 Table: ({$i}) {$OPP} PLD: {$PLD} with GD: {$GD}, {$PPG} PPG and {$PTS} PTS.",'wsl');
			$i++;
	}

	sleep(600);

	$pdo->query("SELECT Team, SUM(PLD) PLD, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
              FROM 0V_base_WSL2 GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC");
	$rows = $pdo->rows();
	$i = 1;
	foreach($rows as $row) {
			$OPP = $go->_V($row['Team']);
			$PLD = $row['PLD'];
			$GD  = $row['GD'];
			$PPG = $row['PPG'];
			$PTS = $row['PTS'];
			$melinda->goTweet("All-time #FAWSL2 Table: ({$i}) {$OPP} PLD: {$PLD} with GD: {$GD}, {$PPG} PPG and {$PTS} PTS.",'wsl');
			$i++;
	}

