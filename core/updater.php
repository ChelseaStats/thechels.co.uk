<?php
	/*
	Plugin Name: CFC Updater Class
	Description: Adds a class to update stuff
	Version: 5.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	class updater {

		/**
		 * updater constructor.
		 */
		function __construct() {
		}

		/**
		 * Returns my shortened team names for consistency
		 * @param $needle
		 * @return int|string
		 */
		public function swapOutTeamNames($needle) {

			$needle = strtoupper(trim($needle));

			$haystack = array (

				/* EPL */
				'ARSENAL FC'                => 'ARSENAL'        ,
				'CHELSEA FC'                => 'CHELSEA'        ,
				'WATFORD FC'                => 'WATFORD'        ,
				'EVERTON FC'                => 'EVERTON'        ,
				'LIVERPOOL FC'              => 'LIVERPOOL'        ,
				'ASTON VILLA'               => 'ASTON_VILLA'        ,
				'BIRMINGHAM CITY'           => 'BIRMINGHAM'         ,
				'CRYSTAL PALACE'            => 'C_PALACE'           ,
				'DERBY COUNTY'              => 'DERBY'              ,
				'LEICESTER CITY'            => 'LEICESTER'          ,
				'MAN CITY'                  => 'MAN_CITY'           ,
				'MANCHESTER CITY'           => 'MAN_CITY'           ,
				'MAN UNITED'                => 'MAN_UTD'            ,
				'MANCHESTER UNITED'         => 'MAN_UTD'            ,
				'MIDDLESBROUGH'             => 'BORO'               ,
				'NEWCASTLE UTD'             => 'NEWCASTLE'          ,
				'NORWICH CITY'              => 'NORWICH'            ,
				'STOKE CITY'                => 'STOKE'              ,
				'SWANSEA CITY'              => 'SWANSEA'            ,
				'TOTTENHAM'                 => 'SPURS'              ,
				'WEST BROM'                 => 'WEST_BROM'          ,
				'WEST BROMWICH'             => 'WEST_BROM'          ,
				'WEST HAM'                  => 'WEST_HAM'           ,
				'BURNLEY FC'                => 'BURNLEY'            ,
				'SHEFFIELD WED'             => 'SHEFF_WED'          ,
				'HULL CITY'                 => 'HULL'               ,

				/* WDL N / S */
				'SUNDERLAND AFC LADIES RESERVES'        => 'SUNDERLAND'         ,
				'SHEFFIELD FC LADIES RESERVES'          => 'SHEFFIELD'          ,
				'MANCHESTER CITY WFC RESERVES'          => 'MAN_CITY'           ,
				'LIVERPOOL LFC RESERVES'                => 'LIVERPOOL'          ,
				'ASTON VILLA LFC RESERVES'              => 'ASTON_VILLA'        ,
				'BIRMINGHAM CITY LFC RESERVES'          => 'BIRMINGHAM'         ,
				'DURHAM WFC RESERVES'                   => 'DURHAM'             ,
				'DONCASTER ROVERS BELLES LFC RESERVES'  => 'DONCASTER'          ,
				'DONCASTER ROVERS BELLES'               => 'DONCASTER'          ,
				'EVERTON LFC RESERVES'                  => 'EVERTON'            ,
				'NOTTS COUNTY LFC RESERVES'             => 'NOTTS_COUNTY'       ,
				'ARSENAL LFC RESERVES'                  => 'ARSENAL'            ,
				'READING WFC RESERVES'                  => 'READING'            ,
				'CHELSEA LFC RESERVES'                  => 'CHELSEA'            ,
				'MILLWALL LIONESSES LFC RESERVES'       => 'MILLWALL'           ,
				'MILLWALL LIONESSES'                    => 'MILLWALL'           ,
				'BRISTOL ACADEMY WFC RESERVES'          => 'BRISTOL'            ,
				'BRISTOL ACADEMY'                       => 'BRISTOL'            ,
				'BRISTOL CITY'                          => 'BRISTOL'            ,
				'BRISTOL CITY WFC RESERVES'             => 'BRISTOL'            ,
				'LONDON BEES LFC RESERVES'              => 'LONDON_BEES'        ,
				'YEOVIL TOWN LFC RESERVES'              => 'YEOVIL'             ,
				'YEOVIL TOWN'                           => 'YEOVIL'             ,
				'WATFORD LFC RESERVES'                  => 'WATFORD'            ,
				'OXFORD UNITED WFC RESERVES'            => 'OXFORD'             ,
				'OXFORD UNITED'                         => 'OXFORD'             ,
                		'BRIGHTON & HOVE ALBION WFC RESERVES'   => 'BRIGHTON'           ,
				'BRIGHTON & HOVE ALBION'                => 'BRIGHTON'           ,

				/* WSL 1 / 2 */
				'MAN CITY (W)'              => 'MAN_CITY'           ,
				'CHELSEA (W)'               => 'CHELSEA'            ,
				'BIRMINGHAM (W)'            => 'BIRMINGHAM'         ,
				'BIRMINGHAM CITY (W)'       => 'BIRMINGHAM'         ,
				'LIVERPOOL (W)'             => 'LIVERPOOL'          ,
				'ARSENAL LFC (W)'           => 'ARSENAL'            ,
				'NOTTS COUNTY (W)'          => 'NOTTS_COUNTY'       ,
				'READING (W)'               => 'READING'            ,
				'SUNDERLAND (W)'            => 'SUNDERLAND'         ,
				'DONCASTER (W)'             => 'DONCASTER'          ,
				'YEOVIL TOWN (W)'           => 'YEOVIL'             ,
				'EVERTON LFC (W)'           => 'EVERTON'            ,
				'DURHAM (W)'                => 'DURHAM'             ,
				'BRISTOL CITY (W)'          => 'BRISTOL'            ,
				'BRISTOL ACADEMY (W)'       => 'BRISTOL'            ,
				'ASTON VILLA (W)'           => 'ASTON_VILLA'        ,
				'LONDON BEES (W)'           => 'LONDON_BEES'        ,
				'MILLWALL LIONESSES (W)'    => 'MILLWALL'           ,
				'OXFORD UNITED (W)'         => 'OXFORD'             ,
				'SHEFFIELD FC (W)'          => 'SHEFFIELD'          ,
				'WATFORD (W)'               => 'WATFORD'            ,



			);

			foreach($haystack as $key => $output) {
				if(strcasecmp($key, $needle) === 0) {
					return $output;
				}
			}
			// if not much prepare it for the DB anyway.
			return strtoupper(str_replace( ' ', '_', trim($needle,'_') ) );
		}

		/**
		 * @param $table
		 * @param $file
		 * @return mixed
		 */
		public function createFootballDataBase($table, $file) {
			$pdo = new pdodb();
			$data = $this->getCSVdata($file);
			$pdo->query("TRUNCATE TABLE $table");
			$pdo->execute();
			$results_data ='';
			foreach($data as $row) :
				$date       = explode('/',$row['1']);
				$d          = $date[0];
				$m          = $date[1];
				$y          = $date[2];
				$date 	    = $y.'-'.$m.'-'.$d;
				$home       = $this->swapOutTeamNames($row['2']);
				$away       = $this->swapOutTeamNames($row['3']);
				$h_shots    = $row['11'];
				$a_shots    = $row['12'];
				$h_shotsOn  = $row['13'];
				$a_shotsOn  = $row['14'];
				$h_fouls    = $row['15'];
				$a_fouls    = $row['16'];
				$h_cards    = $row['19'] + $row['21'];
				$a_cards    = $row['20'] + $row['22'];
				$results_data  .= "INSERT INTO $table (F_DATE, F_HOME, F_AWAY, H_FOULS, A_FOULS, H_CARDS, A_CARDS, H_SHOTS, A_SHOTS, H_SOT, A_SOT) 
 		                   VALUES ('$date', '$home', '$away' , '$h_fouls', '$a_fouls', '$h_cards', '$a_cards', '$h_shots', '$a_shots', '$h_shotsOn', '$a_shotsOn');";
			endforeach;
			$pdo->query($results_data);
			$pdo->execute();
			return $pdo->returnCountAll($table);

		}

		/**
		 * @param $table
		 * @return mixed
		 */
		public function updater_shots($table) {

			$pdo = new pdodb();
			$pdo->query("CREATE OR REPLACE VIEW 0V_base_Shots_this AS
				SELECT a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
				sum((if((a.H_SHOTS > a.A_SHOTS),1,0) = 1)) AS W,
				sum((if((a.H_SHOTS = a.A_SHOTS),1,0) = 1)) AS D,
				sum((if((a.H_SHOTS < a.A_SHOTS),1,0) = 1)) AS L,
				sum((if((a.H_SHOTS = 0),1,0) = 1)) AS FS, sum((if((a.A_SHOTS = 0),1,0) = 1)) AS CS,
				sum((if((a.A_SHOTS > 0 AND a.H_SHOTS > 0),1,0) = 1)) AS BTTS,
				sum(a.H_SHOTS) AS F,sum(a.A_SHOTS) AS A, sum((a.H_SHOTS - a.A_SHOTS)) AS GD,
				round((sum((((if((a.H_SHOTS > a.A_SHOTS),1,0) = 1) * 3) + (if((a.H_SHOTS = a.A_SHOTS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
				sum((((if((a.H_SHOTS > a.A_SHOTS),1,0) = 1) * 3) + (if((a.H_SHOTS = a.A_SHOTS),1,0) = 1))) AS PTS
				from $table a where a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
				group by a.F_HOME
				union all
				SELECT b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
				sum((if((b.A_SHOTS > b.H_SHOTS),1,0) = 1)) AS W,
				sum((if((b.A_SHOTS = b.H_SHOTS),1,0) = 1)) AS D,
				sum((if((b.A_SHOTS < b.H_SHOTS),1,0) = 1)) AS L,
				sum((if((b.A_SHOTS = 0),1,0) = 1)) AS FS, sum((if((b.H_SHOTS = 0),1,0) = 1)) AS CS,
				sum((if((b.A_SHOTS > 0 AND b.H_SHOTS > 0),1,0) = 1)) AS BTTS,
				sum(b.A_SHOTS) AS F, sum(b.H_SHOTS) AS A, sum((b.A_SHOTS - b.H_SHOTS)) AS GD,
				round((sum((((if((b.A_SHOTS > b.H_SHOTS),1,0) = 1) * 3) + (if((b.A_SHOTS = b.H_SHOTS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
				sum((((if((b.A_SHOTS > b.H_SHOTS),1,0) = 1) * 3) + (if((b.A_SHOTS = b.H_SHOTS),1,0) = 1))) AS PTS
				from $table b where b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
				group by b.F_AWAY");
			$pdo->execute();
			return $pdo->returnCountAll('0V_base_Shots_this');
		}

		/**
		 * @param $table
		 * @return mixed
		 */
		public function updater_shotsOnTarget($table) {

			$pdo = new pdodb();
			$pdo->query("CREATE OR REPLACE VIEW 0V_base_Shots_on_this AS
				SELECT a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
				sum((if((a.H_SOT > a.A_SOT),1,0) = 1)) AS W,
				sum((if((a.H_SOT = a.A_SOT),1,0) = 1)) AS D,
				sum((if((a.H_SOT < a.A_SOT),1,0) = 1)) AS L,
				sum((if((a.H_SOT = 0),1,0) = 1)) AS FS, sum((if((a.A_SOT = 0),1,0) = 1)) AS CS,
				sum((if((a.A_SOT > 0 AND a.H_SOT > 0),1,0) = 1)) AS BTTS,
				sum(a.H_SOT) AS F,sum(a.A_SOT) AS A, sum((a.H_SOT - a.A_SOT)) AS GD,
				round((sum((((if((a.H_SOT > a.A_SOT),1,0) = 1) * 3) + (if((a.H_SOT = a.A_SOT),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
				sum((((if((a.H_SOT > a.A_SOT),1,0) = 1) * 3) + (if((a.H_SOT = a.A_SOT),1,0) = 1))) AS PTS
				from $table a where a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
				group by a.F_HOME
				union all
				SELECT b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
				sum((if((b.A_SOT > b.H_SOT),1,0) = 1)) AS W,
				sum((if((b.A_SOT = b.H_SOT),1,0) = 1)) AS D,
				sum((if((b.A_SOT < b.H_SOT),1,0) = 1)) AS L,
				sum((if((b.A_SOT = 0),1,0) = 1)) AS FS, sum((if((b.H_SOT = 0),1,0) = 1)) AS CS,
				sum((if((b.A_SOT > 0 AND b.H_SOT > 0),1,0) = 1)) AS BTTS,
				sum(b.A_SOT) AS F, sum(b.H_SOT) AS A, sum((b.A_SOT - b.H_SOT)) AS GD,
				round((sum((((if((b.A_SOT > b.H_SOT),1,0) = 1) * 3) + (if((b.A_SOT = b.H_SOT),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
				sum((((if((b.A_SOT > b.H_SOT),1,0) = 1) * 3) + (if((b.A_SOT = b.H_SOT),1,0) = 1))) AS PTS
				from $table b where b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
				group by b.F_AWAY");
			$pdo->execute();
			return $pdo->returnCountAll('0V_base_Shots_on_this');
		}

		/**
		 * @param $table
		 * @return mixed
		 */
		public function updater_fouls($table) {
			$pdo = new pdodb();
			$pdo->query("CREATE OR REPLACE VIEW 0V_base_Fouls_this AS
				SELECT a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
				sum(H_FOULS) as F_FOULS,
				sum(A_FOULS) as A_FOULS,
				sum(H_CARDS) as F_CARDS,
				sum(A_CARDS) as A_CARDS
				from $table a where a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
				group by a.F_HOME
				union all
				SELECT b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
				sum(A_FOULS) as F_FOULS,
				sum(H_FOULS) as A_FOULS,
				sum(A_CARDS) as F_CARDS,
				sum(H_CARDS) as A_CARDS
				from $table b where b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
				group by b.F_AWAY");
			$pdo->execute();
			return $pdo->returnCountAll('0V_base_Fouls_this');
		}

		/**
		 * @return mixed
		 */
		public function updater_milestones() {

			$pdo = new pdodb();
			$pdo->query("TRUNCATE TABLE 0t_miles");
			$pdo->execute();
			$pdo->query("INSERT INTO 0t_miles (N, C, L , D, V)
                SELECT N, C, L, D, V FROM ( 
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Wins'  AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS > F_AGOALS GROUP BY F_HOME UNION ALL 
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Wins with clean sheet'   AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS > F_AGOALS AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Draws' 					AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Losses' 					AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS < F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Losses without scoring' 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS < F_AGOALS AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Failed to score' 			AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Clean sheets'				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Both teams to score'		AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS > 0 AND F_AGOALS > 0 GROUP BY F_HOME UNION ALL

                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Wins' 					AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > F_HGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Wins with clean sheet' 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > F_HGOALS AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Draws' 					AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = F_HGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Losses' 					AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS < F_HGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Losses without scoring' 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS > F_AGOALS AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Failed to score' 	 		AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Clean sheets'				AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Both teams to score'		AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > 0 AND F_HGOALS > 0 GROUP BY F_AWAY UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Scored once' 				AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 1 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Scored twice' 			AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 2 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Scored three' 			AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 3 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Scored four' 			 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 4 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Scored five' 			 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 5 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Scored more than five' 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS > 5 GROUP BY F_HOME UNION ALL

                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Conceded once' 			AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 1 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Conceded twice' 		 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 2 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Conceded three' 			AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 3 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Conceded four' 			AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 4 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Conceded five' 			AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 5 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Conceded more than five' 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > 5 GROUP BY F_HOME UNION ALL

                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Scored once' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 1 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Scored twice' 			AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 2 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Scored three' 			AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 3 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Scored four' 			 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 4 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Scored five' 			 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 5 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Scored more than five' 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > 5 GROUP BY F_AWAY UNION ALL

                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Conceded once' 			AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 1 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Conceded twice' 		 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 2 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Conceded three' 			AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 3 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Conceded four' 			AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 4 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Conceded five' 			AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 5 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Conceded more than five' 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS > 5 GROUP BY F_AWAY UNION ALL

                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Won 1-0' 				 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 1 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Won 2-0' 			 		AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 2 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Won 3-0' 			 		AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 3 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Won 4-0' 			 	 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 4 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Won 5-0' 			 	 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 5 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Won by more than 5-0' 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS > 5 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL

                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Lost 1-0' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 1 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Lost 2-0'	 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 2 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Lost 3-0' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 3 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Lost 4-0' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 4 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Lost 5-0' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 5 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Lost by more than 5-0' 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > 5 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL

                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 1-1' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 1 AND F_HGOALS = 1 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 2-2'	 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 2 AND F_HGOALS = 2 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 3-3' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 3 AND F_HGOALS = 3 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 4-4' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 4 AND F_HGOALS = 4 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 5-5' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 5 AND F_HGOALS = 5 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew by more than 5-5' 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > 5 AND F_HGOALS > 5 AND F_AGOALS=F_HGOALS GROUP BY F_HOME UNION ALL

                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 1-1' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 1 AND F_HGOALS = 1 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 2-2'	 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 2 AND F_HGOALS = 2 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 3-3' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 3 AND F_HGOALS = 3 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 4-4' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 4 AND F_HGOALS = 4 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 5-5' 				AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 5 AND F_HGOALS = 5 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew by more than 5-5' 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > 5 AND F_HGOALS > 5 AND F_AGOALS=F_HGOALS GROUP BY F_AWAY UNION ALL

                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Won 1-0' 				 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 1 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Won 2-0' 			 		AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 2 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Won 3-0' 			 		AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 3 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Won 4-0' 			 	 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 4 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Won 5-0' 			 	 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 5 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Won by more than 5-0' 	AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > 5 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL

                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Lost 1-0' 				AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 1 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Lost 2-0'	 				AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 2 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Lost 3-0' 				AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 3 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Lost 4-0' 				AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 4 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Lost 5-0' 				AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 5 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Lost by more than 5-0' 	AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS > 5 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL

                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 0-0'	 AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 1 AND F_HGOALS = F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 1-1'	 AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 2 AND F_HGOALS = F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 2-2'	 AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 3 AND F_HGOALS = F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 3-3'	 AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 4 AND F_HGOALS = F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 4-4'	 AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 5 AND F_HGOALS = F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Drew 5-5'  AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS > 5 AND F_HGOALS = F_AGOALS GROUP BY F_HOME UNION ALL

                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 0-0'	 AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 1 AND F_HGOALS = F_AGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 1-1'	 AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 2 AND F_HGOALS = F_AGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 2-2'	 AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 3 AND F_HGOALS = F_AGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 3-3'	 AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 4 AND F_HGOALS = F_AGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 4-4'	 AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS = 5 AND F_HGOALS = F_AGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Drew 5-5'  AS D, COUNT(*) AS V FROM all_results WHERE F_AGOALS > 5 AND F_HGOALS = F_AGOALS GROUP BY F_AWAY UNION ALL
                
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total home goals scored' AS D, 		SUM(F_HGOALS) AS V FROM all_results UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total away goals scored' AS D, 		SUM(F_AGOALS) AS V FROM all_results UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total goals scored' AS D, 			SUM(F_HGOALS)+SUM(F_AGOALS) AS V FROM all_results UNION ALL
                
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Total goals scored' AS D, SUM(F_HGOALS) AS V FROM all_results GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Total goals conceded' AS D, SUM(F_AGOALS) AS V FROM all_results GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Total goals (for and against)' AS D, SUM(F_HGOALS)+SUM(F_AGOALS) AS V FROM all_results GROUP BY F_HOME UNION ALL
                
				SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Total goals scored' AS D, SUM(F_AGOALS) AS V FROM all_results GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Total goals conceded' AS D, 	SUM(F_HGOALS) AS V FROM all_results GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Total goals (for and against)' AS D, SUM(F_HGOALS)+SUM(F_AGOALS) AS V FROM all_results GROUP BY F_AWAY UNION ALL
                
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total home goals scored this season' AS D, SUM(F_HGOALS) AS V FROM all_results 
                 WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL') UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total away goals scored this season' AS D, SUM(F_AGOALS) AS V FROM all_results 
                 WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL') UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total goals scored this season' AS D, SUM(F_HGOALS)+SUM(F_AGOALS) AS V FROM all_results 
                 WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL') UNION ALL
                
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Total goals scored this season' AS D, 		SUM(F_HGOALS) AS V FROM all_results 
                WHERE F_DATE >  (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL') GROUP BY F_HOME  UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Total goals conceded this season' AS D, 		SUM(F_AGOALS) AS V FROM all_results 
                 WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL') GROUP BY F_HOME  UNION ALL
                SELECT F_HOME AS N, 'EPL' AS C, 'H' as L, 'Total goals (for and against) this season' AS D,  SUM(F_HGOALS)+SUM(F_AGOALS) AS V FROM all_results 
                 WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL') GROUP BY F_HOME  UNION ALL
                
				SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Total goals scored this season' AS D, SUM(F_AGOALS) AS V FROM all_results 
				 WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL') GROUP BY F_AWAY  UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Total goals conceded this season' AS D, SUM(F_HGOALS) AS V FROM all_results 
                 WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL') GROUP BY F_AWAY  UNION ALL
                SELECT F_AWAY AS N, 'EPL' AS C, 'A' as L, 'Total goals (for and against) this season' AS D, SUM(F_HGOALS)+SUM(F_AGOALS) AS V FROM all_results 
                 WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL') GROUP BY F_AWAY  UNION ALL
                             
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total 1-1 draws' AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 1 AND F_AGOALS = 1 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total 2-2 draws' AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 2 AND F_AGOALS = 2 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total 3-3 draws' AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 3 AND F_AGOALS = 3 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total 4-4 draws' AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 4 AND F_AGOALS = 4 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total 5-5 draws' AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 5 AND F_AGOALS = 5 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total 6-6 draws' AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 6 AND F_AGOALS = 6 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total 7-7 draws' AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 7 AND F_AGOALS = 7 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total 8-8 draws' AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 8 AND F_AGOALS = 8 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'n/a' as L, 'Total 9-9 draws' AS D, COUNT(*) AS V FROM all_results WHERE F_HGOALS = 9 AND F_AGOALS = 9 UNION ALL

                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'H' as L, 'Total wins by a 1-0 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 1 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'H' as L, 'Total wins by a 2-0 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 2 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'H' as L, 'Total wins by a 3-0 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 3 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'H' as L, 'Total wins by a 4-0 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 4 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'H' as L, 'Total wins by a 5-0 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 5 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'H' as L, 'Total wins by a 6-0 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 6 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'H' as L, 'Total wins by a 7-0 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 7 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'H' as L, 'Total wins by a 8-0 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 8 AND F_AGOALS = 0 UNION ALL

                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'A' as L, 'Total wins by a 0-1 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 AND F_AGOALS = 1 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'A' as L, 'Total wins by a 0-2 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 AND F_AGOALS = 2 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'A' as L, 'Total wins by a 0-3 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 AND F_AGOALS = 3 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'A' as L, 'Total wins by a 0-4 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 AND F_AGOALS = 4 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'A' as L, 'Total wins by a 0-5 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 AND F_AGOALS = 5 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'A' as L, 'Total wins by a 0-6 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 AND F_AGOALS = 6 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'A' as L, 'Total wins by a 0-7 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 AND F_AGOALS = 7 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'EPL' AS C, 'A' as L, 'Total wins by a 0-8 score' AS D,COUNT(*) AS V FROM all_results WHERE F_HGOALS = 0 AND F_AGOALS = 8
                ) a
                WHERE( MOD(V+1,100)=0 OR MOD(V+1,50)=0 OR MOD(V+1,25)=0 )
                GROUP BY N, C, L, D, V
                ORDER BY V DESC");
			$pdo->execute();
			return $pdo->returnCountAll('0t_miles');
		}

		/**
		 * @return mixed
		 */
		public function updater_wsl_milestones() {

			$pdo = new pdodb();
			$pdo->query("TRUNCATE TABLE 0t_wsl_miles");
			$pdo->execute();
			$pdo->query("INSERT INTO 0t_wsl_miles (N, C, L, D, V) SELECT N, C, L, D, V FROM (
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Scored once' 				 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 1 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Scored twice' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 2 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Scored three' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 3 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Scored four' 			 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 4 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Scored five' 			 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 5 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Scored more than five' 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS > 5 GROUP BY F_HOME UNION ALL

                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Conceded once' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 1 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Conceded twice' 		 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 2 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Conceded three' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 3 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Conceded four' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 4 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Conceded five' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 5 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Conceded more than five' 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS > 5 GROUP BY F_HOME UNION ALL

                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Scored once' 				 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 1 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Scored twice' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 2 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Scored three' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 3 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Scored four' 			 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 4 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Scored five' 			 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 5 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Scored more than five' 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS > 5 GROUP BY F_AWAY UNION ALL

                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Conceded once' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 1 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Conceded twice' 		 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 2 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Conceded three' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 3 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Conceded four' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 4 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Conceded five' 			 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 5 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Conceded more than five' 	 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS > 5 GROUP BY F_AWAY UNION ALL

                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Wins' 						AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS > F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Win with clean sheet' 		AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS > F_AGOALS AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Draws' 						AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Losses' 						AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS < F_AGOALS GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Failed to score'				AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Clean sheets'					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Both teams to score' 			AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS > 0 AND F_AGOALS > 0 GROUP BY F_HOME UNION ALL

                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Wins' 						AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS > F_HGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Win with clean sheet' 		AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS > F_HGOALS AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Draws' 						AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = F_HGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Losses' 						AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS < F_HGOALS GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Failed to score'				AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Clean sheets'					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Both teams to score' 			AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS > 0 AND F_HGOALS > 0 GROUP BY F_AWAY UNION ALL

                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '1-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 1 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '2-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 2 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '3-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 3 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '4-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 4 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '5-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 5 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Won by more than 5 to nil' 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS > 5 AND F_AGOALS = 0 GROUP BY F_HOME UNION ALL

                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '1-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 1 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '2-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 2 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '3-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 3 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '4-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 4 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '5-0 wins' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 5 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Won by more than 5 to nil' 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS > 5 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL

                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '1-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 1 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '2-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 2 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '3-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 3 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '4-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 4 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, '5-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 5 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Lost by more than 5 to nil' 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS > 5 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL

                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '1-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 1 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '2-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 2 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '3-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 3 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '4-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 4 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, '5-0 losses' 					AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 5 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Lost by more than 5 to nil' 	AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS > 5 AND F_AGOALS = 0 GROUP BY F_AWAY UNION ALL

                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Drew 0-0' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 0 AND F_HGOALS = 0 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Drew 1-1' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 1 AND F_HGOALS = 1 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Drew 2-2'	 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 2 AND F_HGOALS = 2 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Drew 3-3' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 3 AND F_HGOALS = 3 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Drew 4-4' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 4 AND F_HGOALS = 4 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Drew 5-5' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 5 AND F_HGOALS = 5 GROUP BY F_HOME UNION ALL
                SELECT F_HOME AS N, 'WSL' AS C, 'H' as L, 'Drew by more than 5-5' 	 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS > 5 AND F_HGOALS > 5 AND F_AGOALS=F_HGOALS GROUP BY F_HOME UNION ALL

                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Drew 0-0' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 0 AND F_HGOALS = 0 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Drew 1-1' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 1 AND F_HGOALS = 1 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Drew 2-2'	 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 2 AND F_HGOALS = 2 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Drew 3-3' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 3 AND F_HGOALS = 3 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Drew 4-4' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 4 AND F_HGOALS = 4 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Drew 5-5' 				 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS = 5 AND F_HGOALS = 5 GROUP BY F_AWAY UNION ALL
                SELECT F_AWAY AS N, 'WSL' AS C, 'A' as L, 'Drew by more than 5-5' 	 AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_AGOALS > 5 AND F_HGOALS > 5 AND F_AGOALS=F_HGOALS GROUP BY F_AWAY UNION ALL

                SELECT 'LEAGUE WIDE' AS N, 'WSL' AS C, 'H' as L, 'Total wins by a 1-0 score' AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 1 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'WSL' AS C, 'H' as L, 'Total wins by a 2-0 score' AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 2 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'WSL' AS C, 'H' as L, 'Total wins by a 3-0 score' AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 3 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'WSL' AS C, 'H' as L, 'Total wins by a 4-0 score' AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 4 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'WSL' AS C, 'H' as L, 'Total wins by a 5-0 score' AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 5 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'WSL' AS C, 'H' as L, 'Total wins by a 6-0 score' AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 6 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'WSL' AS C, 'H' as L, 'Total wins by a 7-0 score' AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 7 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'WSL' AS C, 'H' as L, 'Total wins by a 8-0 score' AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 8 AND F_AGOALS = 0 UNION ALL
                SELECT 'LEAGUE WIDE' AS N, 'WSL' AS C, 'H' as L, 'Total wins by a 9-0 score' AS D, COUNT(*) AS V FROM all_results_wsl_one WHERE F_HGOALS = 9 AND F_AGOALS = 0


                ) a
                WHERE( MOD(V+1,100)=0 OR MOD(V+1,50)=0 OR MOD(V+1,25)=0 OR MOD(V+1,10)=0  OR MOD(V+1,5)=0)
                GROUP BY N, C, L, D, V
                ORDER BY V DESC");
			$pdo->execute();
			return $pdo->returnCountAll('0t_wsl_miles');
		}

		/**
		 * @return bool|string
		 */
		public function updater_last38() {

			$pdo = new pdodb();
			$pdo->query("TRUNCATE TABLE 0t_last38");
			$pdo->execute();
			
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L,         
				SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, 
				SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BOURNEMOUTH a WHERE F_HOME='BOURNEMOUTH' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BOURNEMOUTH b WHERE F_AWAY='BOURNEMOUTH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L,         
				SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, 
				SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SWANSEA a WHERE F_HOME='SWANSEA' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SWANSEA b WHERE F_AWAY='SWANSEA' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BLACKPOOL a WHERE F_HOME='BLACKPOOL' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BLACKPOOL b WHERE F_AWAY='BLACKPOOL' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BURNLEY a WHERE F_HOME='BURNLEY' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BURNLEY b WHERE F_AWAY='BURNLEY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__STOKE a WHERE F_HOME='STOKE' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__STOKE b WHERE F_AWAY='STOKE' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__HULL a WHERE F_HOME='HULL' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__HULL b WHERE F_AWAY='HULL' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__READING a WHERE F_HOME='READING' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__READING b WHERE F_AWAY='READING' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WIGAN a WHERE F_HOME='WIGAN' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WIGAN b WHERE F_AWAY='WIGAN' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WOLVES a WHERE F_HOME='WOLVES' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WOLVES b WHERE F_AWAY='WOLVES' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__PORTSMOUTH a WHERE F_HOME='PORTSMOUTH' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__PORTSMOUTH b WHERE F_AWAY='PORTSMOUTH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WEST_BROM a WHERE F_HOME='WEST_BROM' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WEST_BROM b WHERE F_AWAY='WEST_BROM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BIRMINGHAM a WHERE F_HOME='BIRMINGHAM' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BIRMINGHAM b WHERE F_AWAY='BIRMINGHAM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__FULHAM a WHERE F_HOME='FULHAM' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__FULHAM b WHERE F_AWAY='FULHAM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BRADFORD a WHERE F_HOME='BRADFORD' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BRADFORD b WHERE F_AWAY='BRADFORD' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WATFORD a WHERE F_HOME='WATFORD' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WATFORD b WHERE F_AWAY='WATFORD' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__CHARLTON a WHERE F_HOME='CHARLTON' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__CHARLTON b WHERE F_AWAY='CHARLTON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BARNSLEY a WHERE F_HOME='BARNSLEY' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BARNSLEY b WHERE F_AWAY='BARNSLEY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SUNDERLAND a WHERE F_HOME='SUNDERLAND' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SUNDERLAND b WHERE F_AWAY='SUNDERLAND' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__DERBY a WHERE F_HOME='DERBY' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__DERBY b WHERE F_AWAY='DERBY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__MIDDLESBROUGH a WHERE F_HOME='MIDDLESBROUGH' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__MIDDLESBROUGH b WHERE F_AWAY='MIDDLESBROUGH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BOLTON a WHERE F_HOME='BOLTON' GROUP BY M_OPP 
				UNION ALL 
				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BOLTON b WHERE F_AWAY='BOLTON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__N_FOREST a WHERE F_HOME='N_FOREST' GROUP BY M_OPP 
			  			UNION ALL 
			  			SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__N_FOREST b WHERE F_AWAY='N_FOREST' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__LEICESTER a WHERE F_HOME='LEICESTER' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__LEICESTER b WHERE F_AWAY='LEICESTER' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__C_PALACE a WHERE F_HOME='C_PALACE' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__C_PALACE b WHERE F_AWAY='C_PALACE' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SWINDON a WHERE F_HOME='SWINDON' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SWINDON b WHERE F_AWAY='SWINDON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SHEFF_WED a WHERE F_HOME='SHEFF_WED' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SHEFF_WED b WHERE F_AWAY='SHEFF_WED' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__QPR a WHERE F_HOME='QPR' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__QPR b WHERE F_AWAY='QPR' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__MAN_UTD a WHERE F_HOME='MAN_UTD' GROUP BY M_OPP 
			  					UNION ALL 
			  					SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__MAN_UTD b WHERE F_AWAY='MAN_UTD' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__COVENTRY a WHERE F_HOME='COVENTRY' GROUP BY M_OPP 
			  					UNION ALL 
			  					SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__COVENTRY b WHERE F_AWAY='COVENTRY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BLACKBURN a WHERE F_HOME='BLACKBURN' GROUP BY M_OPP 
			  					UNION ALL 
			  					SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__BLACKBURN b WHERE F_AWAY='BLACKBURN' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WIMBLEDON a WHERE F_HOME='WIMBLEDON' GROUP BY M_OPP 
			  					UNION ALL 
			  					SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WIMBLEDON b WHERE F_AWAY='WIMBLEDON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__LEEDS a WHERE F_HOME='LEEDS' GROUP BY M_OPP 
			  					UNION ALL 
			  					SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__LEEDS b WHERE F_AWAY='LEEDS' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__IPSWICH a WHERE F_HOME='IPSWICH' GROUP BY M_OPP 
			  					UNION ALL 
			  					SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__IPSWICH b WHERE F_AWAY='IPSWICH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__EVERTON a WHERE F_HOME='EVERTON' GROUP BY M_OPP 
			  					UNION ALL 
			  					SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__EVERTON b WHERE F_AWAY='EVERTON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SPURS a WHERE F_HOME='SPURS' GROUP BY M_OPP UNION ALL SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SPURS b WHERE F_AWAY='SPURS' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__NORWICH a WHERE F_HOME='NORWICH' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__NORWICH b WHERE F_AWAY='NORWICH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WEST_HAM a WHERE F_HOME='WEST_HAM' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__WEST_HAM b WHERE F_AWAY='WEST_HAM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();
			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SOUTHAMPTON a WHERE F_HOME='SOUTHAMPTON' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SOUTHAMPTON b WHERE F_AWAY='SOUTHAMPTON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SHEFF_UTD a WHERE F_HOME='SHEFF_UTD' GROUP BY M_OPP 
			  					UNION ALL 
			  					SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__SHEFF_UTD b WHERE F_AWAY='SHEFF_UTD' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__OLDHAM a WHERE F_HOME='OLDHAM' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__OLDHAM b WHERE F_AWAY='OLDHAM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__NEWCASTLE a WHERE F_HOME='NEWCASTLE' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__NEWCASTLE b WHERE F_AWAY='NEWCASTLE' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__MAN_CITY a WHERE F_HOME='MAN_CITY' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__MAN_CITY b WHERE F_AWAY='MAN_CITY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__LIVERPOOL a WHERE F_HOME='LIVERPOOL' GROUP BY M_OPP 
			  			UNION ALL 
			  			SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__LIVERPOOL b WHERE F_AWAY='LIVERPOOL' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__CHELSEA a WHERE F_HOME='CHELSEA' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__CHELSEA b WHERE F_AWAY='CHELSEA' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__ASTON_VILLA a WHERE F_HOME='ASTON_VILLA' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__ASTON_VILLA b WHERE F_AWAY='ASTON_VILLA' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__ARSENAL a WHERE F_HOME='ARSENAL' GROUP BY M_OPP 
			  				UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__ARSENAL b WHERE F_AWAY='ARSENAL' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

			$pdo->query("INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT F_HOME M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(F_HGOALS>F_AGOALS,1,0)=1) W, SUM(IF(F_HGOALS=F_AGOALS,1,0)=1) D, SUM(IF(F_HGOALS < F_AGOALS ,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__CARDIFF a WHERE F_HOME='CARDIFF' GROUP BY M_OPP 
	   		  				 UNION ALL 
			  				SELECT F_AWAY M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W, SUM(IF(F_AGOALS=F_HGOALS,1,0)=1) D, SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) FS, SUM(IF(F_HGOALS=0,1,0)=1) CS, SUM(IF(F_AGOALS > 0 AND F_HGOALS > 0,1,0)=1) BTTS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS, ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38__CARDIFF b WHERE F_AWAY='CARDIFF' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC");
			$pdo->execute();

		
			return $pdo->returnCountAll('0t_last38');
		}
		
		/**
		 * @param $url
		 * @return array|string
		 */
		public function getCSVdata($url)
		{

			$array = '';
			$file = fopen($url, 'r');
			while (($line = fgetcsv($file)) !== FALSE) {
				$array[] = $line;
			}
			array_shift($array); // remove the CSV column headings

			return $array;
		}

		/**
		 * returns returns a SQL
		 *
		 * @param mixed $leagueID
		 * @param mixed $type
		 * @return string $sql
		 */
		function _processFaDevLeagueResults($leagueID, $type) {

			$url 	 = "http://full-time.thefa.com/ListPublicResult.do?divisionseason=".$leagueID;
			$sql     = ''; // should be empty
			$league  = '';
			$date    = '';
			$home    = '';
			$away    = '';
			$a_goals = '';
			$h_goals = '';
			$raw     = $this->getCurlResponse( $url );
			$content = $this->removeLines($raw);

			$content = str_replace( " - "   , "-"   , $content );
			$content = str_replace( "   "   , " "   , $content );
			$content = str_replace( "-"     , ","   , $content );

			$table   = $this->subStringingByPosition( '<h3>Results</h3>', '<div id="Ad_Left">', $content );

			preg_match_all( "|<tr(.*)</tr>|U", $table, $rows );
			foreach ( $rows[0] as $row ) {

				if ( ( strpos( $row, '<th' ) === FALSE ) ) {
					preg_match_all( "|<td(.*)</td>|U", $row, $cells );
					//      = trim(strip_tags( $cells[0][0] ));

					$league = $this->upperTrimStrippedCell($cells[0][1]);
					$date   = $this->upperTrimStrippedCell($cells[0][2]);
					$home   = $this->upperTrimStrippedCell($cells[0][3]);
					$result = $this->upperTrimStrippedCell($cells[0][4]); // 5 is half-time but it isn't recorded often enough
					$away   = $this->upperTrimStrippedCell($cells[0][6]);

					$home   = $this->swapOutTeamNames(trim($home));
					$away   = $this->swapOutTeamNames(trim($away));
					$date   = $this->makeIsoDateFromString($date);

					$result = explode( ",", $result );

					if ($result['0'] != 'p'):
						$h_goals = (int) $result['0'];
						$a_goals = (int) $result['1'];
					endif;

				}
				
				if ( $league == 'L' && is_int($h_goals) == TRUE && is_int($a_goals) == TRUE) {

					$sql .= 'INSERT IGNORE INTO ' . $type . ' (F_DATE, F_HOME, F_HGOALS, F_AGOALS, F_AWAY) '. PHP_EOL;
					$sql .= 'VALUES ("' . $date . '","' . $home . '","' . $h_goals . '","' . $a_goals . '","' . $away . '");' . PHP_EOL;

				}

			}

			return $sql;
		}

		/**
		 * Updates the Subs Usage View
		 * @param $table
		 * @return string
		 */
		function updater_subsUsage($table) {

			$dollar = '';
			$names  = '';
			$a = array();
			$pdo = new pdodb();
			$go = new utility();
			$sql = "SELECT DISTINCT a.F_NAME, c.F_SQUADNO FROM cfc_fixture_events a, cfc_fixtures b, meta_squadno c WHERE b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL')
					AND a.F_GAMEID = b.F_ID and b.F_COMPETITION='PREM' AND a.F_NAME = c.F_NAME AND b.F_DATE >= c.F_START 
					AND ( b.F_DATE < c.F_END or c.F_END IS NULL) AND F_TEAM ='1' AND F_EVENT IN ('SUBOFF','SUBON') ORDER BY c.F_SQUADNO ASC";
			$pdo->query($sql);
			$rows 	 = $pdo->rows();
			foreach($rows as $row):
				if(!in_array($row['F_SQUADNO'], $a)){
					$a[]=$row['F_SQUADNO'];
					$squadNo = $row['F_SQUADNO'];
				} else {
					$a[]=$row['F_SQUADNO'].'i';
					$squadNo = $row['F_SQUADNO'].'i';
				}
				$dollar .= "count(case when b.F_NAME ='". $row['F_NAME'] ."' THEN 1 END) '".$squadNo."', ";
				$names  .= $go->_V($row['F_NAME']);
			endforeach;
			$sql ="Create or replace view $table as SELECT DISTINCT d.F_SQUADNO, a.F_NAME as F_SUBNAME, ". $dollar ." COUNT(*) as GT
						   FROM  cfc_fixture_events a,  cfc_fixture_events b, cfc_fixtures c, meta_squadno d
						   WHERE a.F_GAMEID = b.F_GAMEID AND a.F_GAMEID = c.F_ID AND a.F_MINUTE = b.F_MINUTE AND c.F_COMPETITION = 'PREM' AND a.F_EVENT = 'SUBOFF' AND b.F_EVENT = 'SUBON' 
						   AND a.F_TEAM =1 AND b.F_TEAM =1 AND a.F_NAME = d.F_NAME AND a.F_DATE >= d.F_START AND (a.F_DATE < d.F_END or d.F_END IS NULL)
						   AND a.F_DATE >  (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL')
						   AND d.F_NAME in (SELECT distinct F_NAME from cfc_fixture_events x, cfc_fixtures z WHERE x.F_TEAM ='1' AND x.F_EVENT IN ('SUBOFF','SUBON') 
						    AND z.F_COMPETITION='PREM' AND x.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL') AND x.F_GAMEID = z.F_ID)
						   GROUP BY a.F_NAME ORDER BY d.F_SQUADNO ASC";
			return $sql;
		}

		/**
		 * returns SQL
		 *
		 * @param mixed $url
		 * @param mixed $type
		 * @param mixed $starter
		 * @return string $sql
		 */
		function _processMatchResults($url,$starter,$type) {

			$sql            = '';
			$date           = '';
			$home           = '';
			$away           = '';
			$a_goals        = '';
			$h_goals        = '';
			$first          = NULL;
			$ht_home_goals  = '0';
			$at_home_goals  = '0';

			$raw = $this->getCurlResponse( $url );
			$content = $this->removeLines( $raw );

			// $content = str_replace( '</tr><tr class="status5">','', $content);
			$content    = str_replace('data-dymek="','</td><td>', $content);
			$content    = str_replace('class="black matchAction" ','',$content);
			$content    = $this->replaceDashesSpacesForComma( $content );
			$table      = $this->subStringingByPosition( $starter, 'contentright', $content );

			preg_match_all( "|<tr(.*)</tr>|U", $table, $rows );

			$i = 0; // set counter
			foreach ( $rows[0] as $row ) {

				if($i <= 10) {
					// check counter, we only want last 10 results anyway. (this should limit hits to max of 13 rather than 53 that got us banned).

					if ( ( strpos( $row, '<th' ) === FALSE ) ) {
						preg_match_all( "|<td(.*)</td>|U", $row, $cells );

						$date  = trim( strip_tags( $cells[0][1] ) );
						$date  = $this->makeIsoDateFromString($date);
						$s    = explode( '<a href="', $cells[0][3] );
						$t    = explode( '">', $s[1] );
						$href = $t[0];
						$href = str_replace( ',', '-', $href );
						$url  = "http://www.futbol24.com" . $href;

						$home   = $this->upperTrimStrippedCell( $cells[0][2] );
						$result = $this->upperTrimStrippedCell( $cells[0][3] );
						$away   = $this->upperTrimStrippedCell( $cells[0][4] );

						$response = $this->getMatchDetails( $url );

						if ( ! is_array( $response ) ) {
							// $sql = 'error';
						} else {
							if ( isset( $response['first'] ) && $response['first'] != "" ) {
								$first = $response['first'];
							} else {
								$first = NULL;
							};
							$ht_home_goals = $response['ht_hgoals'];
							$at_home_goals = $response['ht_agoals'];
						}

						$result = explode( ",", $result );

						if ( strtoupper( $result['0'] ) != 'P' ):
							$h_goals = (int) $result['0'];
							$a_goals = (int) $result['1'];
						endif;

					}

					if ( $date != '--' && isset( $home ) && isset( $away ) && isset($h_goals) && isset($a_goals) && is_int( $h_goals ) == TRUE && is_int( $a_goals ) == TRUE ) {

						$home_ready = $this->swapOutTeamNames( $home );
						$away_ready = $this->swapOutTeamNames( $away );

						$sql .= 'INSERT IGNORE INTO ' . $type . ' (F_DATE, F_HOME, F_HGOALS, F_AGOALS, F_AWAY, F_1G, HT_HGOALS, HT_AGOALS) ' . PHP_EOL;
						$sql .= 'VALUES ("' . $date . '","' . $home_ready . '","' . $h_goals . '","' . $a_goals . '","' . $away_ready . '","' . $first . '","' . $ht_home_goals . '","' . $at_home_goals . '");' . PHP_EOL;
					}
					$i ++; // increment the counter
				}

			}
			
			return $sql;
		}

		/**
		 * Gets first goal and HT score from Prem Results
		 * @param $url
		 * @return mixed
		 */
		public function getMatchDetails( $url ) {
			
			$return  = '';
			$raw     = $this->getCurlResponse( $url );
			$content = $this->removeLines( $raw );
			$data    = $this->subStringingByPosition( '<table>', '<tfoot>', $content );

			preg_match_all( "|<tr(.*)</tr>|U", $data, $rows );
			foreach ( $rows[0] as $row ) {

				if ( ( strpos( $row, '<th' ) === FALSE ) ) {
					preg_match_all( "|<td(.*)</td>|U", $row, $cells );
					$minute = $this->upperTrimStrippedCell($cells[0][0]); // minute or HT/FT marker
					$result = $this->upperTrimStrippedCell($cells[0][2]); // result

					$result = str_replace( " - ", "-", $result );
					$result = explode( "-", $result );

					if ( strtoupper( $result['0'] ) != 'P' ):
						$h_goals = (int) $result['0'];
						$a_goals = (int) $result['1'];

						if ( $h_goals == 1 && $a_goals == 0 ) {
							$f_1G = 'H'; // home side scored first
						} else if ( $h_goals == 0 && $a_goals == 1 ) {
							$f_1G = 'A'; // away side scored first
						} else if ( $h_goals == 0 && $a_goals == 0 ) {
							$f_1G = NULL; // nobody scored
						}

						if ( isset( $f_1G ) ) {
							$callback['first'] = $f_1G;
						}

						if ( $minute == 'HT' ) {

							$ht_hgoals = $h_goals;
							$ht_agoals = $a_goals;
						}

						if ( isset( $ht_hgoals ) && isset( $ht_agoals ) ) {

							$callback['ht_hgoals'] = $ht_hgoals;
							$callback['ht_agoals'] = $ht_agoals;
						}

					endif;
				}

				if ( isset( $callback ) ) {
					$return = $callback;
				} else {
					$return = 'error';
				}
			}

			return $return;
		}

		/**
		 * Updates the WSL data, prints and returns details
		 * @param $string
		 * @param $table
		 * @param $league
		 * @param $year
		 * @return string
		 */
		public function UpdateWSL( $string, $table, $league, $year ) {

			try {
				$url = "http://www.futbol24.com/national/England/Womens-Super-League-{$league}/{$year}/results/";
				$pdo = new pdodb();
				$pdo->query("select count(*) as F_COUNT from {$table} where F_DATE > (Select F_DATE from 000_config where F_LEAGUE = 'WSL')");
				$row = $pdo->row();
				$original = $row['F_COUNT'];
				$message  = "Current {$table} row count: {$original}.".PHP_EOL;
				$sql = $this->_processMatchResults( $url, '<div class="table loadingContainer">', $table );
				$counter    = substr_count($sql, 'INSERT');
				$message .=  "New {$table} row count : {$counter}.".PHP_EOL;
				$pdo->query( $sql );
				$pdo->execute();
				$lastRowAndCount = $pdo->lastInsertId() . ' ' . $pdo->rowCount();
				$message .= "{$string} Results {$lastRowAndCount}".PHP_EOL;

			} catch (PDOException $e) {

				$message = "DB Error: The record could not be added to WSL. " . $e->getMessage() ;

			} catch (Exception $e) {

				$message = "Adding SQL to WSL table failed";

			}

			return $message;
		}

		/**
		 * Updates the WDL data, prints and returns details
		 * @param $string
		 * @param $table
		 * @param $id
		 * @return string
		 */
		public function updateWDL( $string, $table, $id ) {

			try {
				$pdo = new pdodb();
				$pdo->query("select count(*) as F_COUNT from {$table} where F_DATE > (Select F_DATE from 000_config where F_LEAGUE = 'WDL')");
				$row = $pdo->row();
				$original = $row['F_COUNT'];
				$message  = "Current {$table} row count: {$original}.".PHP_EOL;
				$sql = $this->_processFaDevLeagueResults( $id, $table );
				$counter  = substr_count($sql, 'INSERT');
				$message .= "New {$table} row count : {$counter}.".PHP_EOL;
				$pdo->query( $sql );
				$pdo->execute();
				$lastRowAndCount = $pdo->lastInsertId() . ' ' . $pdo->rowCount();
				$message .= "{$string} Results {$lastRowAndCount}".PHP_EOL;

			} catch (PDOException $e) {

				$message = "DB Error: The record could not be added to WDL. " . $e->getMessage() ;

			} catch (Exception $e) {

				$message = "Adding SQL to WDL table failed";

			}

			return $message;


		}

		/**
		 * @param $url
		 * @return mixed
		 */
		public function getCurlResponse( $url ) {

			$ch          = curl_init();
			$headers = array();
			$ua = $this->generateRandomUA();
			$headers[] = 'User-Agent: '. $ua;
			$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
			$headers[] = 'Accept-Language: en-GB,en;q=0.8';
			$headers[] = 'Cache-Control: no-cache';
			$headers[] = 'Connection: keep-alive';
			$headers[] = 'DNT: 1';
			$headers[] = 'Pragma:no-cache';

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, $ua);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FAILONERROR, true);
			curl_setopt($ch, CURLOPT_VERBOSE, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 800);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_TIMEOUT, 4000);

			$result['URL']      = $url;
			$result['DATA']     = curl_exec($ch);

			curl_close($ch);

			return $result['DATA'];

		}

		/**
		 * @return mixed
		 */
		public function generateRandomUA(){

			$agents = [
				'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36',
				'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
				'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0',
				'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.101 Safari/537.36',
				'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36',
				'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36',
				'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11) AppleWebKit/601.1.56 (KHTML, like Gecko) Version/9.0 Safari/601.1.56',
				'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36',
				'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_1) AppleWebKit/601.2.7 (KHTML, like Gecko) Version/9.0.1 Safari/601.2.7',
				'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko',
			];

			$k = array_rand($agents);
			return $agents[$k];

		}

		/**
		 * @param $raw
		 * @return mixed
		 */
		public function removeLines( $raw ) {
			$newlines = array ( "\t", "\n", "\r", "\x20\x20", "\0", "\x0B", "<br/>", "<p>", "</p>", "<br>" );
			$content  = str_replace( $newlines, " ", html_entity_decode( $raw ) );

			return $content;
		}

		/**
		 * @param $cell
		 * @return string
		 */
		public function upperTrimStrippedCell( $cell ) {
			return strtoupper( trim( strip_tags( $cell ) ) );
		}

		/**
		 * @param $starter
		 * @param $ender
		 * @param $content
		 * @return string
		 */
		public function subStringingByPosition( $starter, $ender, $content ) {
			$start = strpos( $content, $starter );
			$end   = strpos( $content, $ender);
			$table = substr( $content, $start, $end - $start );

			return $table;
		}

		/**
		 * @param $content
		 * @return mixed
		 */
		public function replaceDashesSpacesForComma( $content ) {
			$array   = [ "-", "   ", " - " ];
			$content = str_replace( $array, ",", $content );

			return $content;
		}

		/**
		 * @param $date
		 * @return array|string
		 */
		public function makeIsoDateFromString( $date ) {

			$date  = explode( " ", $date );
			$date  = $date['0'];

			if(strpos($date,'/')) {
				$date = explode( "/", $date );
			} else {
				$date = explode( ".", $date );
			}
			$day   = $date['0'];
			$month = $date['1'];
			$yearLength = strlen($date['2']);
			if($yearLength == 2) {
				$year  = "20" . $date['2'];
			} else {
				$year = $date['2'];
			}
			return $year . "-" . $month . "-" . $day;

		}

		/**
		 * @param $file
		 * @return string
		 */
		public function getStoredValue($file)
		{

			$data = serialize('no data');
			if (file_exists($file)) :
				$data = file_get_contents($file);
			endif;

			return $data;
		}

		/**
		 * @param $file
		 * @param $message
		 * @return int
		 */
		public function writeToFileStore($file, $message)
		{

			$data = file_put_contents($file, $message);

			return $data;
		}

		/**
		 * @param $url
		 * @return mixed
		 */
		public function getJsonFromCurl($url)  {

			$json = $this->getCurlResponse( $url );

			return json_decode($json);
		}

		/**
		 * @param $url
		 * @return mixed
		 */
		public function getJsonArrayFromCurl($url) {

			$json = $this->getCurlResponse( $url );

			return json_decode($json, TRUE);
		}
	}

	$updater = new updater();
