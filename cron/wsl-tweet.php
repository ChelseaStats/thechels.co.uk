<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	$pdo = new pdodb();
	$go = new utility();
	/**
	 *
	 * 01 : home goals this WSL 1
	 * 02 : away goals this WSL 1
	 * 03 : home goals this WSL 2
	 * 04 : away goals this WSL 2
	 * 05 : home goals this WDL N
	 * 06 : away goals this WDL N
	 * 07 : home goals this WDL S
	 * 08 : away goals this WDL S
	 *
	 * 9  : CS total all  WSL 1
	 * 10 : CS total this WSL 1
	 * 11 : CS total all  WSL 2
	 * 12 : CS total this WSL 2
	 * 13 : CS total all  WDL N
	 * 14 : CS total this WDL N
	 * 15 : CS total all  WDL S
	 * 16 : CS total this WDL S
	 *
	 * 17 : FS total all  WSL 1
	 * 18 : FS total this WSL 1
	 * 19 : FS total all  WSL 2
	 * 20 : FS total this WSL 2
	 * 21 : FS total all  WDL N
	 * 22 : FS total this WDL N
	 * 23 : FS total all  WDL S
	 * 24 : FS total this WDL S
	 *
	 * 25 : home records this WSL 1
	 * 26 : away records this WSL 1
	 * 27 : home records this WSL 2
	 * 28 : away records this WSL 2
	 * 29 : home records this  WDL N
	 * 30 : away records this  WDL N
	 * 31 : home records this  WDL S
	 * 32 : away records this  WDL S
	 * 33 : home records all  WSL 1
	 * 34 : away records all  WSL 1
	 * 35 : home records all  WSL 2
	 * 36 : away records all  WSL 2
	 * 37 : home records all  WDL N
	 * 38 : away records all  WDL N
	 * 39 : home records all  WDL S
	 * 40 : away records all  WDL S
	 *
     *** Top 3s
	 * 41 : FS home records this WSL 1
	 * 42 : FS away records this WSL 1
	 * 43 : FS home records all  WSL 1
	 * 44 : FS away records all  WSL 1
	 *
	 * 45 : CS home records this WSL 1
	 * 46 : CS away records this WSL 1
	 * 47 : CS home records all WSL 1
	 * 48 : CS away records all WSL 1
	 *
	 * 49 : BTS home records this WSL 1
	 * 50 : BTS away records this WSL 1
	 * 51 : BTS home records all WSL 1
	 * 52 : BTS away records all WSL 1
	 *
	 * 53 : GD home records this WSL 1
	 * 54 : GD away records this WSL 1
	 * 55 : GD home records all WSL 1
	 * 56 : GD away records all WSL 1
	 *
	 * 57 : FS home records this WSL 2
	 * 58 : FS away records this WSL 2
	 * 59 : FS home records all  WSL 2
	 * 60 : FS away records all  WSL 2
	 *
	 * 61 : CS home records this WDL 2
	 * 62 : CS away records this WDL 2
	 * 63 : CS home records this WDL 2
	 * 64 : CS away records this WDL 2
	 *
	 * 65 : BTS home records this WSL 2
	 * 66 : BTS away records this WSL 2
	 * 67 : BTS home records this WSL 2
	 * 68 : BTS away records this WSL 2
	 *
	 * 69 : GD home records this WSL 2
	 * 70 : GD away records this WSL 2
	 * 71 : GD home records this WSL 2
	 * 72 : GD away records this WSL 2
	 *
	 *
	 * 73 : FS home records this WDL N
	 * 74 : FS away records this WDL N
	 * 75 : FS home records all  WDL N
	 * 76 : FS away records all  WDL N
	 *
	 * 77 : CS home records this WDL N
	 * 78 : CS away records this WDL N
	 * 79 : CS home records all WDL N
	 * 80 : CS away records all WDL N
	 *
	 * 81 : BTS home records this WDL N
	 * 82 : BTS away records this WDL N
	 * 83 : BTS home records all WDL N
	 * 84 : BTS away records all WDL N
	 *
	 * 85 : GD home records this WDL N
	 * 86 : GD away records this WDL N
	 * 87 : GD home records all WDL N
	 * 88 : GD away records all WDL N
	 *
	 * 89 : FS home records this WDL S
	 * 90 : FS away records this WDL S
	 * 91 : FS home records all  WDL S
	 * 92 : FS away records all  WDL S
	 *
	 * 93 : CS home records this WDL S
	 * 94 : CS away records this WDL S
	 * 95 : CS home records all WDL S
	 * 96 : CS away records all WDL S
	 *
	 * 97 : BTS home records this WDL S
	 * 98 : BTS away records this WDL S
	 * 99 : BTS home records all WDL S
	 * 100 : BTS away records all WDL S
	 *
	 * 101: GD home records this WDL S
	 * 102 : GD away records this WDL S
	 * 103 : GD home records all WDL S
	 * 104 : GD away records all WDL S
	 *
	 * 105 : league wide avg goals this WSL 1
	 * 106 : league wide avg goals this WSL 2
	 * 107 : league wide avg goals this WDL N
	 * 108 : league wide avg goals this WDL S
	 * 
	 * 109 : league wide avg goals all WSL 1
	 * 110 : league wide avg goals all WSL 2
	 * 111 : league wide avg goals all WDL N
	 * 112 : league wide avg goals all WDL S
	 *
	 * 113 : Top home unbeaten streaks WSL 1
	 * 114 : Top away unbeaten streaks WSL 1
	 * 115 : Top home winning  streaks WSL 1
	 * 116 : Top away winning  streaks WSL 1
	 *
	 * 117 : Top home unbeaten streaks WSL 2
	 * 118 : Top away unbeaten streaks WSL 2
	 * 119 : Top home winning  streaks WSL 2
	 * 120 : Top away winning  streaks WSL 2
	 *
	 * 121 : Top home unbeaten streaks WDL N
	 * 122 : Top away unbeaten streaks WDL N
	 * 123 : Top home winning  streaks WDL N
	 * 124 : Top away winning  streaks WDL N
	 *
	 * 125 : Top home unbeaten streaks WDL S
	 * 126 : Top away unbeaten streaks WDL S
	 * 127 : Top home winning  streaks WDL S
	 * 128 : Top away winning  streaks WDL S
	 *
	 * 129 : Top Progress Report WSL
	 * 130 : Bot Progress Report WSL
	 * 131 : Top Progress Report WSL2
	 * 132 : Bot Progress Report WSL2
	 * 133 : Top Progress Report WDLNorth
	 * 134 : Bot Progress Report WDLNorth
	 * 134 : Top Progress Report WDLSouth
	 * 135 : Bot Progress Report WDLSouth
	 */
	$message = '';
	$tweet = rand( 1, 130 ); // pick a random number and then tweet it
	switch ( $tweet ) {
		/******************************************************************************/
		case '1':

			$sql = "select F_HOME as N, sum(F_HGOALS) as V from all_results_wsl_one where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top scoring #WSL home teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '2':
			
			$sql = "select F_AWAY as N, sum(F_AGOALS) as V from all_results_wsl_one where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top scoring #WSL away teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '3':
			
			$sql = "select F_HOME as N, sum(F_HGOALS) as V from all_results_wsl_two where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top scoring #WSL2 home teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '4':
			
			$sql = "select F_AWAY as N, sum(F_AGOALS) as V from all_results_wsl_two where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top scoring #WSL2 away teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		case '5':
			
			$sql = "select F_HOME as N, sum(F_HGOALS) as V from all_results_wdl_north where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WDL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top scoring #WDLNorth home teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '6':
			
			$sql = "select F_AWAY as N, sum(F_AGOALS) as V from all_results_wdl_north where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WDL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top scoring #WDLNorth away teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '7':
			
			$sql = "select F_HOME as N, sum(F_HGOALS) as V from all_results_wdl_south where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WDL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top scoring #WDLSouth home teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '8':
			
			$sql = "select F_AWAY as N, sum(F_AGOALS) as V from all_results_wdl_south where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WDL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top scoring #WDLSouth away teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '9':
			
			$sql="SELECT Team as N, SUM(CS) as V FROM 0V_base_WSL1 GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have kept ".$V." clean sheets in the history of the #FAWSL","wsl");
			}
			break;
		/******************************************************************************/
		case '10':
			
			$sql="SELECT Team as N, SUM(CS) as V FROM 0V_base_WSL1_this GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have kept ".$V." clean sheets in the #FAWSL this season","wsl");
			}
			break;
		/******************************************************************************/
		case '11':
			
			$sql="SELECT Team as N, SUM(CS) as V FROM 0V_base_WSL2 GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have kept ".$V." clean sheets in the history of the #FAWSL2","wsl");
			}
			break;
		/******************************************************************************/
		case '12':
			
			$sql="SELECT Team as N, SUM(CS) as V FROM 0V_base_WSL2_this GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have kept ".$V." clean sheets in the #FAWSL2 this season","wsl");
			}
			break;
		/******************************************************************************/
		case '13':
			
			$sql="SELECT Team as N, SUM(CS) as V FROM 0V_base_WDL_north GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have kept ".$V." clean sheets in the history of the #WDLNorth","wsl");
			}
			break;
		/******************************************************************************/
		case '14':
			
			$sql="SELECT Team as N, SUM(CS) as V FROM 0V_base_WDL_north_this GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have kept ".$V." clean sheets in the #WDLNorth this season","wsl");
			}
			break;
		/******************************************************************************/
		case '15':
			
			$sql="SELECT Team as N, SUM(CS) as V FROM 0V_base_WDL_south GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have kept ".$V." clean sheets in the history of the #WDLSouth","wsl");
			}
			break;
		/******************************************************************************/
		case '16':
			
			$sql="SELECT Team as N, SUM(CS) as V FROM 0V_base_WDL_south_this GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have kept ".$V." clean sheets in the #WDLSouth this season","wsl");
			}
			break;
		/******************************************************************************/

		case '17':
			
			$sql="SELECT Team as N, SUM(FS) as V FROM 0V_base_WSL1 GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have failed to score in ".$V." games in the history of the #FAWSL","wsl");
			}
			break;
		/******************************************************************************/
		case '18':
			
			$sql="SELECT Team as N, SUM(FS) as V FROM 0V_base_WSL1_this GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have failed to score in ".$V." games in the #FAWSL this season","wsl");
			}
			break;
		/******************************************************************************/
		case '19':
			
			$sql="SELECT Team as N, SUM(FS) as V FROM 0V_base_WSL2 GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have failed to score in ".$V." games in the history of the #FAWSL2","wsl");
			}
			break;

		/******************************************************************************/
		case '20':
			
			$sql="SELECT Team as N, SUM(FS) as V FROM 0V_base_WSL2_this GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have failed to score in ".$V." games in the #FAWSL2 this season","wsl");
			}
			break;

		/******************************************************************************/
		case '21':
			
			$sql="SELECT Team as N, SUM(FS) as V FROM 0V_base_WDL_north GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have failed to score in ".$V." games in the history of the #WDLNorth","wsl");
			}
			break;

		/******************************************************************************/
		case '22':
			
			$sql="SELECT Team as N, SUM(FS) as V FROM 0V_base_WDL_north_this GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have failed to score in ".$V." games in the #WDLNorth this season","wsl");
			}
			break;
		/******************************************************************************/
		case '23':
			
			$sql="SELECT Team as N, SUM(FS) as V FROM 0V_base_WDL_south GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have failed to score in ".$V." games in the history of the #WDLSouth","wsl");
			}
			break;

		/******************************************************************************/
		case '24':
			
			$sql="SELECT Team as N, SUM(FS) as V FROM 0V_base_WDL_south_this GROUP BY Team ORDER BY CS DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$T = $go->_V($row['N']);
				$V = $row['V'];
				$melinda->goTweet($T." have failed to score in ".$V." games in the #WDLSouth this season","wsl");
			}
			break;

		/******************************************************************************/
		case '25':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WSL1_this WHERE LOC='H' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H 	= $go->_V($row['Team']);
				$W 	= $row['W'];
				$D 	= $row['D'];
				$L 	= $row['L'];
				$PPG 	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) at home in the #FAWSL this season.","wsl");
			}
			break;
		/******************************************************************************/
		case '26':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WSL1_this WHERE LOC='A' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) away in the #FAWSL this season.","wsl");
			}
			break;
		/******************************************************************************/
		case '27':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WSL2_this WHERE LOC='H' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) at home in the #FAWSL2 this season.","wsl");
			}
			break;
		/******************************************************************************/
		case '28':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WSL2_this WHERE LOC='A' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) away in the #FAWSL2 this season.","wsl");
			}
			break;
		/******************************************************************************/
		case '29':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WDL_north_this WHERE LOC='H' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) at home in the #WDLNorth this season.","wsl");
			}
			break;
		/******************************************************************************/
		case '30':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WDL_north_this WHERE LOC='A' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) away in the #WDLNorth this season.","wsl");
			}
			break;
		/******************************************************************************/
		case '31':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WDL_south_this WHERE LOC='H' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) at home in the #WDLSouth this season.","wsl");
			}
			break;
		/******************************************************************************/
		case '32':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WDL_south_this WHERE LOC='A' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) away in the #WDLSouth this season.","wsl");
			}
			break;
		/******************************************************************************/
		case '33':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WSL1 WHERE LOC='H' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) at home in the history of the #FAWSL","wsl");
			}
			break;
		/******************************************************************************/
		case '34':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WSL1 WHERE LOC='A' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) away in the history of the #FAWSL","wsl");
			}
			break;
		/******************************************************************************/
		case '35':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WSL2 WHERE LOC='H' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) at home in the history of the #FAWSL2","wsl");
			}
			break;
		/******************************************************************************/
		case '36':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WSL2 WHERE LOC='A' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) away in the history of the #FAWSL2","wsl");
			}
			break;
		/******************************************************************************/
		case '37':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WDL_north WHERE LOC='H' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) at home in the history of the #WDLNorth","wsl");
			}
			break;
		/******************************************************************************/
		case '38':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WDL_north WHERE LOC='A' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) away in the history of the #WDLNorth","wsl");
			}
			break;
		/******************************************************************************/
		case '39':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WDL_south WHERE LOC='H' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) at home in the history of the #WDLSouth","wsl");
			}
			break;
		/******************************************************************************/
		case '40':
			
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WDL_south WHERE LOC='A' GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
			$pdo->query($sql);
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$H	= $go->_V($row['Team']);
				$W	= $row['W'];
				$D	= $row['D'];
				$L	= $row['L'];
				$PPG	= $row['PPG'];

				$melinda->goTweet($H." are W".$W." D".$D." L".$L." (with ".$PPG." PPG) away in the history of the #WDLSouth","wsl");
			}
			break;

		/***************************************************************/
		case '41':
			
			$sql = "select F_HOME as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wsl_one
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top failing to score at home #WSL teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '42':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wsl_one
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top failing to score away #WSL teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '43':
			
			$sql = "select F_HOME as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wsl_one
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top failing to score at home #WSL teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '44':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wsl_one
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top failing to score away #WSL teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;	
		/***************************************************************/
		case '45':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wsl_one
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top clean sheets at home #WSL teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '46':
			
			$sql = "select F_AWAY as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wsl_one
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top clean sheets away #WSL teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '47':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wsl_one
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top clean sheets at home #WSL teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '48':
			
			$sql = "select F_AWAY as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wsl_one
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top clean sheets away #WSL teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/	
		case '49':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wsl_one
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top teams having BTTS games at home #WSL teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '50':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wsl_one
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top teams having BTTS games away #WSL teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '51':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wsl_one
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams having BTTS games at home #WSL teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '52':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wsl_one
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams having BTTS games away #WSL teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '53':
			
			$sql = "select F_HOME as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wsl_one
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top teams for Goal Diff at home #WSL teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '54':
			
			$sql = "select F_AWAY as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wsl_one
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top teams for Goal Diff away #WSL teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '55':
			
			$sql = "select F_HOME as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wsl_one
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams for Goal Diff at home #WSL teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '56':
			
			$sql = "select F_AWAY as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wsl_one
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams for Goal Diff away #WSL teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '57':
			
			$sql = "select F_HOME as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wsl_two
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top failing to score at home #WSL2 teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '58':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wsl_two
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top failing to score away #WSL2 teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '59':
			
			$sql = "select F_HOME as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wsl_two
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top failing to score at home #WSL2 teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '60':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wsl_two
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top failing to score away #WSL2 teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '61':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wsl_two
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top clean sheets at home #WSL2 teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '62':
			
			$sql = "select F_AWAY as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wsl_two
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top clean sheets away #WSL2 teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '63':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wsl_two
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top clean sheets at home #WSL2 teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '64':
			
			$sql = "select F_AWAY as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wsl_two
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top clean sheets away #WSL2 teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '65':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wsl_two
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top teams having BTTS games at home #WSL2 teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '66':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wsl_two
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top teams having BTTS games away #WSL2 teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '67':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wsl_two
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams having BTTS games at home #WSL2 teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '68':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wsl_two
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams having BTTS games away #WSL2 teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '69':
			
			$sql = "select F_HOME as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wsl_two
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top teams for Goal Diff at home #WSL2 teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '70':
			
			$sql = "select F_AWAY as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wsl_two
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top teams for Goal Diff away #WSL2 teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '71':
			
			$sql = "select F_HOME as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wsl_two
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams for Goal Diff at home #WSL2 teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '72':
			
			$sql = "select F_AWAY as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wsl_two
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams for Goal Diff away #WSL2 teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '73':
			
			$sql = "select F_HOME as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wdl_north
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top failing to score at home #WDLNorth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '74':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wdl_north
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top failing to score away #WDLNorth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '75':
			
			$sql = "select F_HOME as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wdl_north
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top failing to score at home #WDLNorth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '76':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wdl_north
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top failing to score away #WDLNorth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '77':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wdl_north
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top clean sheets at home #WDLNorth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '78':
			
			$sql = "select F_AWAY as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wdl_north
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top clean sheets away #WDLNorth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '79':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wdl_north
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top clean sheets at home #WDLNorth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '80':
			
			$sql = "select F_AWAY as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wdl_north
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top clean sheets away #WDLNorth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '81':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wdl_north
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top teams having BTTS games at home #WDLNorth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '82':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wdl_north
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top teams having BTTS games away #WDLNorth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '83':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wdl_north
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams having BTTS games at home #WDLNorth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '84':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wdl_north
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams having BTTS games away #WDLNorth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '85':
			
			$sql = "select F_HOME as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wdl_north
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top teams for Goal Diff at home #WDLNorth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '86':
			
			$sql = "select F_AWAY as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wdl_north
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top teams for Goal Diff away #WDLNorth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '87':
			
			$sql = "select F_HOME as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wdl_north
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams for Goal Diff at home #WDLNorth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '88':
			
			$sql = "select F_AWAY as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wdl_north
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams for Goal Diff away #WDLNorth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		/***************************************************************/
		case '89':
			
			$sql = "select F_HOME as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wdl_south
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top failing to score at home #WDLSouth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '90':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wdl_south
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top failing to score away #WDLSouth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '91':
			
			$sql = "select F_HOME as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wdl_south
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top failing to score at home #WDLSouth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '92':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wdl_south
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top failing to score away #WDLSouth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '93':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wdl_south
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top clean sheets at home #WDLSouth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '94':
			
			$sql = "select F_AWAY as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wdl_south
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top clean sheets away #WDLSouth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '95':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS = 0),1,0) = 1)) AS V from all_results_wdl_south
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top clean sheets at home #WDLSouth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '96':
			
			$sql = "select F_AWAY as N, sum((if((F_HGOALS = 0),1,0) = 1)) AS V from all_results_wdl_south
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top clean sheets away #WDLSouth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '97':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wdl_south
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top teams having BTTS games at home #WDLSouth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '98':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wdl_south
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top teams having BTTS games away #WDLSouth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '99':
			
			$sql = "select F_HOME as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wdl_south
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams having BTTS games at home #WDLSouth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '100':
			
			$sql = "select F_AWAY as N, sum((if((F_AGOALS > 0 AND F_HGOALS > 0),1,0) = 1)) AS V from all_results_wdl_south
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams having BTTS games away #WDLSouth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '101':
			
			$sql = "select F_HOME as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wdl_south
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat Top teams for Goal Diff at home #WDLSouth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '102':
			
			$sql = "select F_AWAY as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wdl_south
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat Top teams for Goal Diff away #WDLSouth teams (this season): ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/****************************************************************/
		case '103':
			
			$sql = "select F_HOME as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wdl_south
					group by F_HOME having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams for Goal Diff at home #WDLSouth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/***************************************************************/
		case '104':
			
			$sql = "select F_AWAY as N, sum((F_HGOALS - F_AGOALS)) AS V from all_results_wdl_south
					group by F_AWAY having V > 0 order by V desc limit 3";
			$message="#stat All time - Top teams for Goal Diff away #WDLSouth teams: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '105':
			
			$sql = "SELECT sum(F_HGOALS+F_AGOALS)/Count(*) as V FROM all_results_wsl_one
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')";
			$message="#stat Average goals per game in the #WSL (this season): ";
			$type ='1';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '106':
			
			$sql = "SELECT sum(F_HGOALS+F_AGOALS)/Count(*) as V FROM all_results_wsl_two
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')";
			$message="#stat Average goals per game in the #WSL2 (this season): ";
			$type ='1';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '107':
			
			$sql = "SELECT sum(F_HGOALS+F_AGOALS)/Count(*) as V FROM all_results_wdl_north
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')";
			$message="#stat Average goals per game in the #WDLNorth (this season): ";
			$type ='1';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '108':
			
			$sql = "SELECT sum(F_HGOALS+F_AGOALS)/Count(*) as V FROM all_results_wdl_south
					where F_DATE > (select f_date from 000_config where F_LEAGUE = 'WSL')";
			$message="#stat Average goals per game in the #WDLSouth (this season): ";
			$type ='1';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '109':
			
			$sql = "SELECT sum(F_HGOALS+F_AGOALS)/Count(*) as V FROM all_results_wsl_one";
			$message="#stat Average goals per game in the #WSL (all time): ";
			$type ='1';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '110':
			
			$sql = "SELECT sum(F_HGOALS+F_AGOALS)/Count(*) as V FROM all_results_wsl_two";
			$message="#stat Average goals per game in the #WSL2 (all time): ";
			$type ='1';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '111':
			
			$sql = "SELECT sum(F_HGOALS+F_AGOALS)/Count(*) as V FROM all_results_wdl_north";
			$message="#stat Average goals per game in the #WDLNorth (all time): ";
			$type ='1';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '112':
			
			$sql = "SELECT sum(F_HGOALS+F_AGOALS)/Count(*) as V FROM all_results_wdl_south";
			$message="#stat Average goals per game in the #WDLSouth (all time): ";
			$type ='1';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '113':
			
			$sql = "SELECT a.F_HOME as N, count(*) as V from all_results_wsl_one a where F_hgoals >= f_agoals and f_Date > (select max(f_date)
           			FROM all_results_wsl_one b where a.f_home = b.f_home and f_hgoals < f_agoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 unbeaten home #WSL streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '114':
			
			$sql = "SELECT a.F_AWAY as N, count(*) as V from all_results_wsl_one a where F_agoals >= f_hgoals and f_Date > (select max(f_date)
           			FROM all_results_wsl_one b where a.F_AWAY = b.F_AWAY and f_agoals < f_hgoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 unbeaten away #WSL streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '115':
			
			$sql = "SELECT a.F_HOME as N, count(*) as V from all_results_wsl_one a where F_hgoals > f_agoals and f_Date > (select max(f_date)
           			FROM all_results_wsl_one b where a.f_home = b.f_home and f_hgoals <= f_agoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 winning home #WSL streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '116':
			
			$sql = "SELECT a.F_AWAY as N, count(*) as V from all_results_wsl_one a where F_agoals > f_hgoals and f_Date > (select max(f_date)
           			FROM all_results_wsl_one b where a.F_AWAY = b.F_AWAY and f_agoals <= f_hgoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 winning away #WSL streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '117':
			
			$sql = "SELECT a.F_HOME as N, count(*) as V from all_results_wsl_one a where F_hgoals >= f_agoals and f_Date > (select max(f_date)
           			FROM all_results_wsl_two b where a.f_home = b.f_home and f_hgoals < f_agoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 unbeaten home #WSL2 streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '118':
			
			$sql = "SELECT a.F_AWAY as N, count(*) as V from all_results_wsl_one a where F_agoals >= f_hgoals and f_Date > (select max(f_date)
           			FROM all_results_wsl_two b where a.F_AWAY = b.F_AWAY and f_agoals < f_hgoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 unbeaten away #WSL2 streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '119':
			
			$sql = "SELECT a.F_HOME as N, count(*) as V from all_results_wsl_one a where F_hgoals > f_agoals and f_Date > (select max(f_date)
           			FROM all_results_wsl_two b where a.f_home = b.f_home and f_hgoals <= f_agoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 winning home #WSL2 streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '120':
			
			$sql = "SELECT a.F_AWAY as N, count(*) as V from all_results_wsl_one a where F_agoals > f_hgoals and f_Date > (select max(f_date)
           			FROM all_results_wsl_two b where a.F_AWAY = b.F_AWAY and f_agoals <= f_hgoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 winning away #WSL2 streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '121':
			
			$sql = "SELECT a.F_HOME as N, count(*) as V from all_results_wsl_one a where F_hgoals >= f_agoals and f_Date > (select max(f_date)
           			FROM all_results_wdl_north b where a.f_home = b.f_home and f_hgoals < f_agoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 unbeaten home #WDLNorth streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '122':
			
			$sql = "SELECT a.F_AWAY as N, count(*) as V from all_results_wsl_one a where F_agoals >= f_hgoals and f_Date > (select max(f_date)
           			FROM all_results_wdl_north b where a.F_AWAY = b.F_AWAY and f_agoals < f_hgoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 unbeaten away #WDLNorth streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '123':
			
			$sql = "SELECT a.F_HOME as N, count(*) as V from all_results_wsl_one a where F_hgoals > f_agoals and f_Date > (select max(f_date)
           			FROM all_results_wdl_north b where a.f_home = b.f_home and f_hgoals <= f_agoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 winning home #WDLNorth streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '124':
			
			$sql = "SELECT a.F_AWAY as N, count(*) as V from all_results_wsl_one a where F_agoals > f_hgoals and f_Date > (select max(f_date)
           			FROM all_results_wdl_north b where a.F_AWAY = b.F_AWAY and f_agoals <= f_hgoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 winning away #WDLNorth streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '125':
			
			$sql = "SELECT a.F_HOME as N, count(*) as V from all_results_wsl_one a where F_hgoals >= f_agoals and f_Date > (select max(f_date)
           			FROM all_results_wdl_south b where a.f_home = b.f_home and f_hgoals < f_agoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 unbeaten home #WDLSouth streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '126':
			
			$sql = "SELECT a.F_AWAY as N, count(*) as V from all_results_wsl_one a where F_agoals >= f_hgoals and f_Date > (select max(f_date)
           			FROM all_results_wdl_south b where a.F_AWAY = b.F_AWAY and f_agoals < f_hgoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 unbeaten away #WDLSouth streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '127':
			
			$sql = "SELECT a.F_HOME as N, count(*) as V from all_results_wsl_one a where F_hgoals > f_agoals and f_Date > (select max(f_date)
           			FROM all_results_wdl_south b where a.f_home = b.f_home and f_hgoals <= f_agoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 winning home #WDLSouth streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '128':
			
			$sql = "SELECT a.F_AWAY as N, count(*) as V from all_results_wsl_one a where F_agoals > f_hgoals and f_Date > (select max(f_date)
           			FROM all_results_wdl_south b where a.F_AWAY = b.F_AWAY and f_agoals <= f_hgoals) group by a.F_HOME order by V desc limit 3";
			$message="#stat Top 3 winning away #WDLSouth streaks: ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') { $melinda->goTweet( $message , 'wsl' ); }
			break;
		/******************************************************************************/
		case '129':
			
			$sql = "select a.Team as N_NAME, a.PTS-b.PTS as PTS from 0V_base_WSL_ISG_totals a, 0V_base_WSL_ISG_totals b
					where a.Team = b.Team
					and a.Label = (select year(F_DATE) from 000_config where F_LEAGUE = 'WSl')
					and b.Label = (select year(F_DATE) from 000_config where F_LEAGUE = 'WSlm1')
					group by a.Team order by PTS desc limit 3";
			$message="/2 ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') {
				$melinda->goTweet( '/1 #stat Top 3 #WSL teams by PTS improvement to comparable results from last season: '  , 'wsl' );
				$melinda->goTweet( $message , 'wsl' );
			}
			break;
		/******************************************************************************/
		case '130':
			
			$sql = "select a.Team as N_NAME, a.PTS-b.PTS as PTS from 0V_base_WSL_ISG_totals a, 0V_base_WSL_ISG_totals b
					where a.Team = b.Team
					and a.Label = (select year(F_DATE) from 000_config where F_LEAGUE = 'WSl')
					and b.Label = (select year(F_DATE) from 000_config where F_LEAGUE = 'WSlm1')
					group by a.Team order by PTS asc limit 3";
			$message="/2 ";
			$type ='3';
			$nv = $go->processType($type,$sql);
			$message = $message .' '.$nv;
			if($nv !='') {
				$melinda->goTweet( '/1 #stat Worst 3 #WSL teams by PTS improvement to comparable results from last season: '  , 'wsl' );
				$melinda->goTweet( $message , 'wsl' );
			}
			break;
		/******************************************************************************/
	}
