<?php

	/*
	Plugin Name: CFC Summary Stats Generator
	Description: returns arrays of messages.
	Version: 2.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	class summaries {

		/**
		 * @return array
		 */
		function wslHistory() {

			$pdo = new pdodb();
			$pdo->query( "SELECT count(*) as PLD,
					SUM(IF(F_HGOALS=0 OR F_AGOALS=0 OR (F_HGOALS=0 AND F_AGOALS=0)=1,1,0)) CS,
					SUM(IF((F_HGOALS > F_AGOALS)=1,1,0)) HW,
					SUM(IF((F_HGOALS < F_AGOALS)=1,1,0)) AW,
					SUM(IF((F_HGOALS = F_AGOALS)=1,1,0)) DD
					FROM all_results_wsl_one" );
			$row = $pdo->row();

			$P  = $row['PLD'];
			$CS = $row['CS'];
			$HW = $row['HW'];
			$AW = $row['AW'];
			$DD = $row['DD'];

			$P1 = $CS > 0 ? round( ( $CS / $P ) * 100, 2 ) : 0;
			$P2 = $HW > 0 ? round( ( $HW / $P ) * 100, 2 ) : 0;
			$P3 = $AW > 0 ? round( ( $AW / $P ) * 100, 2 ) : 0;
			$P4 = $DD > 0 ? round( ( $DD / $P ) * 100, 2 ) : 0;

			$messages[] = "Up to date summary statistics from the #FAWSL";
			$messages[] = $P1 . "% of matches have ended with a clean sheets in the history of the #FAWSL. ({$CS}/{$P})";
			$messages[] = $P2 . "% of matches have been won by the home team in the history of the #FAWSL. ({$HW}/{$P})";
			$messages[] = $P3 . "% of matches have been won by the away team in the history of the #FAWSL. ({$AW}/{$P})";
			$messages[] = $P4 . "% of matches have been drawn in the history of the #FAWSL. ({$DD}/{$P})";

			return $messages;
		}

		/**
		 * @return array
		 */
		function wslThisSeason() {

			$pdo = new pdodb();
			$pdo->query("SELECT count(*) as PLD,
					SUM(IF(F_HGOALS=0 OR F_AGOALS=0 OR (F_HGOALS=0 AND F_AGOALS=0)=1,1,0)) CS,
					SUM(IF((F_HGOALS > F_AGOALS)=1,1,0)) HW,
					SUM(IF((F_HGOALS < F_AGOALS)=1,1,0)) AW,
					SUM(IF((F_HGOALS = F_AGOALS)=1,1,0)) DD
					FROM all_results_wsl_one
					WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL') ");
			$row = $pdo->row();

			$P  = $row['PLD'];
			$CS = $row['CS'];
			$HW = $row['HW'];
			$AW = $row['AW'];
			$DD = $row['DD'];

			$P1 = $CS > 0 ? round( ($CS / $P ) *100 , 2) : 0 ;
			$P2 = $HW > 0 ? round( ($HW / $P ) *100 , 2) : 0 ;
			$P3 = $AW > 0 ? round( ($AW / $P ) *100 , 2) : 0 ;
			$P4 = $DD > 0 ? round( ($DD / $P ) *100 , 2) : 0 ;

			$messages[] = $P1 . "% of matches have ended with a clean sheets in the #FAWSL this season. ({$CS}/{$P})";
			$messages[] = $P2 . "% of matches have been won by the home team in the #FAWSL this season. ({$HW}/{$P})";
			$messages[] = $P3 . "% of matches have been won by the away team in the #FAWSL this season. ({$AW}/{$P})";
			$messages[] = $P4 . "% of matches have been drawn in the #FAWSL this season. ({$DD}/{$P})";

			return $messages;
		}

		/**
		 * @return array
		 */
		function wslScoringFirst() {

			$pdo = new pdodb();
			$pdo->query("SELECT sum(PLD) PLD, sum(W) W, sum(D) D, sum(L) L, sum(W + D) as U FROM 0V_base_WSL_this_1S");
			$row = $pdo->row();

			$P  =   $row['PLD'];
			$W  =   $row['W'];
			$D  =   $row['D'];
			$L  =   $row['L'];
			$U  =   $row['U'];

			$P1 = $W > 0 ? round( ( $W / $P ) *100 , 2) : 0 ;
			$P2 = $D > 0 ? round( ( $D / $P ) *100 , 2) : 0 ;
			$P3 = $L > 0 ? round( ( $L / $P ) *100 , 2) : 0 ;
			$P4 = $U > 0 ? round( ( $U / $P ) *100 , 2) : 0 ;

			$messages[] = "{$P1}% of matches have won by the team scoring first in the #FAWSL1 this season. ({$W}/{$P})";
			$messages[] = "{$P2}% of matches have been drawn by the team scoring first in the #FAWSL1 this season. ({$D}/{$P})";
			$messages[] = "{$P3}% of matches have been lost by the team scoring first in the #FAWSL1 this season. ({$L}/{$P})";
			$messages[] = "{$P4}% of matches have seen team take at least a point when scoring first in games in the #FAWSL1 this season. ({$U}/{$P})";

			return $messages;
		}

		/**
		 * @return array
		 */
		function wslWinningHalfTime() {

			$pdo = new pdodb();
			$pdo->query("SELECT sum(PLD) PLD, sum(W) W, sum(D) D, sum(L) L, sum(W + D) as U FROM 0V_base_WSL_this_W_HT");
			$row = $pdo->row();

			$P  =   $row['PLD'];
			$W  =   $row['W'];
			$D  =   $row['D'];
			$L  =   $row['L'];
			$U  =   $row['U'];

			$P1 = $W > 0 ? round( ( $W / $P ) *100 , 2) : 0 ;
			$P2 = $D > 0 ? round( ( $D / $P ) *100 , 2) : 0 ;
			$P3 = $L > 0 ? round( ( $L / $P ) *100 , 2) : 0 ;
			$P4 = $U > 0 ? round( ( $U / $P ) *100 , 2) : 0 ;

			$messages[] = "{$P1}% of matches have won by the team after they were winning at HT in the #FAWSL1 this season. ({$W}/{$P})";
			$messages[] = "{$P2}% of matches have been drawn by the team after they were winning at HT in the #FAWSL1 this season. ({$D}/{$P})";
			$messages[] = "{$P3}% of matches have been lost by the team after they were winning at HT in the #FAWSL1 this season. ({$L}/{$P})";
			$messages[] = "{$P4}% of matches have seen team take at least a point in games after they were winning at HT in the #FAWSL1 this season. ({$U}/{$P})";

			return $messages;
		}

		/**
		 * @return array
		 */
		function wslLosingHalfTime() {
			$pdo = new pdodb();
			$pdo->query("SELECT sum(PLD) PLD, sum(W) W, sum(D) D, sum(L) L, sum(W + D) as U FROM 0V_base_WSL_this_L_HT");
			$row = $pdo->row();

			$P  =   $row['PLD'];
			$W  =   $row['W'];
			$D  =   $row['D'];
			$L  =   $row['L'];
			$U  =   $row['U'];

			$P1 = $W > 0 ? round( ( $W / $P ) *100 , 2) : 0 ;
			$P2 = $D > 0 ? round( ( $D / $P ) *100 , 2) : 0 ;
			$P3 = $L > 0 ? round( ( $L / $P ) *100 , 2) : 0 ;
			$P4 = $U > 0 ? round( ( $U / $P ) *100 , 2) : 0 ;

			$messages[] = "{$P1}% of matches have won by the team after they were losing at HT in the #FAWSL1 this season. ({$W}/{$P})";
			$messages[] = "{$P2}% of matches have been drawn by the team after they were losing at HT in the #FAWSL1 this season. ({$D}/{$P})";
			$messages[] = "{$P3}% of matches have been lost by the team after they were losing at HT in the #FAWSL1 this season. ({$L}/{$P})";
			$messages[] = "{$P4}% of matches have seen team take at least a point in games after they were losing at HT in the #FAWSL1 this season. ({$U}/{$P})";


			return $messages;
		}

		/**
		 * @return array
		 */
		function wsl2History() {
			$pdo = new pdodb();
			$pdo->query( "SELECT count(*) as PLD,
					SUM(IF(F_HGOALS=0 OR F_AGOALS=0 OR (F_HGOALS=0 AND F_AGOALS=0)=1,1,0)) CS,
					SUM(IF((F_HGOALS > F_AGOALS)=1,1,0)) HW,
					SUM(IF((F_HGOALS < F_AGOALS)=1,1,0)) AW,
					SUM(IF((F_HGOALS = F_AGOALS)=1,1,0)) DD
					FROM all_results_wsl_two" );
			$row = $pdo->row();

			$P  = $row['PLD'];
			$CS = $row['CS'];
			$HW = $row['HW'];
			$AW = $row['AW'];
			$DD = $row['DD'];

			$P1 = $CS > 0 ? round( ( $CS / $P ) * 100, 2 ) : 0;
			$P2 = $HW > 0 ? round( ( $HW / $P ) * 100, 2 ) : 0;
			$P3 = $AW > 0 ? round( ( $AW / $P ) * 100, 2 ) : 0;
			$P4 = $DD > 0 ? round( ( $DD / $P ) * 100, 2 ) : 0;

			$messages[] = "Up to date summary statistics from the #FAWSL2";
			$messages[] = $P1 . "% of matches have ended with a clean sheets in the history of the #FAWSL2. ({$CS}/{$P})";
			$messages[] = $P2 . "% of matches have been won by the home team in the history of the #FAWSL2. ({$HW}/{$P})";
			$messages[] = $P3 . "% of matches have been won by the away team in the history of the #FAWSL2. ({$AW}/{$P})";
			$messages[] = $P4 . "% of matches have been drawn in the history of the #FAWSL2. ({$DD}/{$P})";

			return $messages;
		}

		/**
		 * @return array
		 */
		function wsl2ThisSeason() {

			$pdo = new pdodb();
			$pdo->query( "SELECT count(*) as PLD,
					SUM(IF(F_HGOALS=0 OR F_AGOALS=0 OR (F_HGOALS=0 AND F_AGOALS=0)=1,1,0)) CS,
					SUM(IF((F_HGOALS > F_AGOALS)=1,1,0)) HW,
					SUM(IF((F_HGOALS < F_AGOALS)=1,1,0)) AW,
					SUM(IF((F_HGOALS = F_AGOALS)=1,1,0)) DD
					FROM all_results_wsl_two
					WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL') " );
			$row = $pdo->row();

			$P  = $row['PLD'];
			$CS = $row['CS'];
			$HW = $row['HW'];
			$AW = $row['AW'];
			$DD = $row['DD'];

			$P1 = $CS > 0 ? round( ( $CS / $P ) * 100, 2 ) : 0;
			$P2 = $HW > 0 ? round( ( $HW / $P ) * 100, 2 ) : 0;
			$P3 = $AW > 0 ? round( ( $AW / $P ) * 100, 2 ) : 0;
			$P4 = $DD > 0 ? round( ( $DD / $P ) * 100, 2 ) : 0;

			$messages[] = $P1 . "% of matches have ended with a clean sheets in the #FAWSL2 this season. ({$CS}/{$P})";
			$messages[] = $P2 . "% of matches have been won by the home team in the #FAWSL2 this season. ({$HW}/{$P})";
			$messages[] = $P3 . "% of matches have been won by the away team in the #FAWSL2 this season. ({$AW}/{$P})";
			$messages[] = $P4 . "% of matches have been drawn in the #FAWSL2 this season. ({$DD}/{$P})";

			return $messages;
		}

		/**
		 * @return array
		 */
		function plThisSeason() {

			$pdo = new pdodb();
			$pdo->query("SELECT count(*) as PLD,
					SUM(IF(F_HGOALS=0 OR F_AGOALS=0 OR (F_HGOALS=0 AND F_AGOALS=0)=1,1,0)) CS,
					SUM(IF((F_HGOALS > F_AGOALS)=1,1,0)) HW,
					SUM(IF((F_HGOALS < F_AGOALS)=1,1,0)) AW,
					SUM(IF((F_HGOALS = F_AGOALS)=1,1,0)) DD
					FROM all_results
					WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') ");
			$row = $pdo->row();

			$P  = $row['PLD'];
			$CS = $row['CS'];
			$HW = $row['HW'];
			$AW = $row['AW'];
			$DD = $row['DD'];

			$P1 = $CS > 0 ? round( ($CS / $P ) *100 , 2) : 0 ;
			$P2 = $HW > 0 ? round( ($HW / $P ) *100 , 2) : 0 ;
			$P3 = $AW > 0 ? round( ($AW / $P ) *100 , 2) : 0 ;
			$P4 = $DD > 0 ? round( ($DD / $P ) *100 , 2) : 0 ;

			$messages[] = $P1 . "% of matches have ended with a clean sheets in the Premier League this season. ({$CS}/{$P})";
			$messages[] = $P2 . "% of matches have been won by the home team in the Premier League this season. ({$HW}/{$P})";
			$messages[] = $P3 . "% of matches have been won by the away team in the Premier League this season. ({$AW}/{$P})";
			$messages[] = $P4 . "% of matches have been drawn in the Premier League this season. ({$DD}/{$P})";

			return $messages;
		}

		/**
		 * @return array
		 */
		function plScoringFirst() {

			$pdo = new pdodb();
			$pdo->query("SELECT sum(PLD) PLD, sum(W) W, sum(D) D, sum(L) L, sum(W + D) as U FROM 0V_base_PL_this_1S");
			$row = $pdo->row();

			$P  =   $row['PLD'];
			$W  =   $row['W'];
			$D  =   $row['D'];
			$L  =   $row['L'];
			$U  =   $row['U'];

			$P1 = $W > 0 ? round( ( $W / $P ) *100 , 2) : 0 ;
			$P2 = $D > 0 ? round( ( $D / $P ) *100 , 2) : 0 ;
			$P3 = $L > 0 ? round( ( $L / $P ) *100 , 2) : 0 ;
			$P4 = $U > 0 ? round( ( $U / $P ) *100 , 2) : 0 ;

			$messages[] = "{$P1}% of matches have won by the team scoring first in the Premier League this season. ({$W}/{$P})";
			$messages[] = "{$P2}% of matches have been drawn by the team scoring first in the Premier League  this season. ({$D}/{$P})";
			$messages[] = "{$P3}% of matches have been lost by the team scoring first in the Premier League  this season. ({$L}/{$P})";
			$messages[] = "{$P4}% of matches have seen team take at least a point when scoring first in games in the Premier League this season. ({$U}/{$P})";

			return $messages;
		}

		/**
		 * @return array
		 */
		function plWinningHalfTime() {

			$pdo = new pdodb();
			$pdo->query("SELECT sum(PLD) PLD, sum(W) W, sum(D) D, sum(L) L, sum(W + D) as U FROM 0V_base_PL_this_W_HT");
			$row = $pdo->row();

			$P  =   $row['PLD'];
			$W  =   $row['W'];
			$D  =   $row['D'];
			$L  =   $row['L'];
			$U  =   $row['U'];

			$P1 = $W > 0 ? round( ( $W / $P ) *100 , 2) : 0 ;
			$P2 = $D > 0 ? round( ( $D / $P ) *100 , 2) : 0 ;
			$P3 = $L > 0 ? round( ( $L / $P ) *100 , 2) : 0 ;
			$P4 = $U > 0 ? round( ( $U / $P ) *100 , 2) : 0 ;

			$messages[] = "{$P1}% of matches have won by the team after they were winning at HT in the Premier League this season. ({$W}/{$P})";
			$messages[] = "{$P2}% of matches have been drawn by the team after they were winning at HT in the Premier League this season. ({$D}/{$P})";
			$messages[] = "{$P3}% of matches have been lost by the team after they were winning at HT in the Premier League this season. ({$L}/{$P})";
			$messages[] = "{$P4}% of matches have seen team take at least a point in games after they were winning at HT in the Premier League this season. ({$U}/{$P})";

			return $messages;
		}

		/**
		 * @param $messages
		 * @param $account
		 */
		function arrayToTweets($messages, $account) {
			$melinda = new melinda();

			foreach($messages as $tweet){
				$melinda->goTweet( $tweet, $account);
				sleep(90);
			}

			sleep(600);
		}

	}

	/* 					FROM all_results
					WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') ");
	*/