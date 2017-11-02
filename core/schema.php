<?php
	/*
	Plugin Name: CFC View Schema
	Description: Creates the view schema
	Version: 3.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

		class schema {
			
			/**
			 * schema constructor.
			 */
			function __construct() {

					$this->big7     = "('MAN_UTD', 'CHELSEA', 'ARSENAL', 'SPURS', 'EVERTON', 'LIVERPOOL', 'MAN_CITY')";
					$this->ever6    = "('MAN_UTD', 'CHELSEA', 'ARSENAL', 'SPURS', 'EVERTON', 'LIVERPOOL')";
					$this->ldn      = "('WEST_HAM', 'QPR', 'FULHAM', 'BRENTFORD', 'CHARLTON', 'C_PALACE', 'MILLWALL', 'ARSENAL', 'SPURS', 'CHELSEA', 'WIMBLEDON')";
					$this->swldn    = "('QPR',  'FULHAM',  'BRENTFORD',  'CHELSEA')";

			}

			/**
			 * create a base table grouping big 7 team results for by Year for each PL season
			 * @return string
			 */
			function _0V_base_YRBIG() {

				$big7 = $this->big7;

				$sql = "CREATE TABLE 0T_base_YRBIG AS
							select
							c.F_LABEL AS YR,
							a.F_HOME AS Team,
							('H') LOC,
							count(a.F_HOME) AS PLD,
							sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
							sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
							sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
							sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS,
							sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
							sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
							sum(a.F_HGOALS) AS F,
							sum(a.F_AGOALS) AS A,
							sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
							round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)))
							/ count(a.F_HOME)),3) AS PPG,
							sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
							from all_results a, cfc_metaseasons c
							where ((a.F_HOME in {$big7} )
							and (a.F_AWAY in {$big7} ))
							and a.F_DATE > c.F_SDATE AND a.F_DATE < c.F_EDATE
							group by c.F_LABEL, a.F_HOME
							union all
							select
							c.F_LABEL AS YR,
							b.F_AWAY AS Team,
							('A') LOC,
							count(b.F_AWAY) AS PLD,
							sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
							sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
							sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
							sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS,
							sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
							sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
							sum(b.F_AGOALS) AS F,
							sum(b.F_HGOALS) AS A,
							sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
							round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)))
							/ count(b.F_HOME)),3) AS PPG,
							sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
							from all_results b , cfc_metaseasons c
							where ((b.F_HOME in {$big7} )
							and (b.F_AWAY in {$big7} ))
							and b.F_DATE > c.F_SDATE AND b.F_DATE < c.F_EDATE
							group by c.F_LABEL,b.F_AWAY ";


				return $sql;
			}

			/**
			 * create a base table of all sub apps this season Subs on, Premier League games only
			 * @return string
			 */
			function _0v_analysis_subs_this() {

				$sql = "CREATE OR REPLACE VIEW 0v_analysis_subs_this as SELECT
				F_NAME, sum(X_MINUTES) as F_MINS, sum(F_SHOTS) as F_SHOTS, sum(F_SHOTSON) as F_SHOTSON, sum(F_GOALS) as F_GOALS, sum(F_ASSISTS) as F_ASSISTS, count(*) as PLD
				FROM cfc_fixtures_players a, cfc_fixtures b
				WHERE F_SUBS = 1 AND a.F_GAMEID = b.F_ID AND b.F_COMPETITION = 'PREM'
				AND a.F_DATE > (select F_DATE from 000_config where F_LEAGUE = 'PL')
				GROUP BY F_NAME";

				return $sql;
			}

			/**
			 * create a base table grouping big 7 team results for all PL seasons
			 * @return string
			 */
			function _0V_base_BIG() {

				$big7 = $this->big7;

				$sql = "CREATE OR REPLACE VIEW 0V_base_BIG AS
					select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
					sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
					sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
					sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
					sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
					sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
					sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
					round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
					sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
					from all_results a where ((a.F_HOME in {$big7} ) and (a.F_AWAY in {$big7} )) group by a.F_HOME
					union all
					select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
					sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
					sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
					sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
					sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
					sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
					sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
					round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
					sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
					from all_results b where ((b.F_HOME in {$big7} ) and (b.F_AWAY in {$big7} )) group by b.F_AWAY";

				return $sql;
			}

			/**
			 * create a base table grouping big 7 team results for this season
			 * @return string
			 */
			function _0V_base_BIG_this() {

				$big7 = $this->big7;

				$sql = "CREATE OR REPLACE VIEW 0V_base_BIG_this AS
				SELECT a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
				sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
				sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
				sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
				sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
				sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
				sum(a.F_HGOALS) AS F,sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
				round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
				sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
				from all_results a where ((a.F_HOME in {$big7} ) and (a.F_AWAY in {$big7} ))
				and a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='BIG')
				group by a.F_HOME
				union all
				SELECT b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
				sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
				sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
				sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
				sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
				sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
				sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
				round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
				sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
				from all_results b where ((b.F_HOME in {$big7} ) and (b.F_AWAY in {$big7} ))
				and b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='BIG')
				group by b.F_AWAY";


				return $sql;
			}

			/**
			 * create a base table grouping big 7 team results under Jose Mourinho (both spells)
			 * @return string
			 */
			function _0V_base_BIG_TSO() {

				$big7 = $this->big7;

				$sql = "CREATE OR REPLACE VIEW 0V_base_BIG_TSO AS
					select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						FROM all_results a WHERE (((a.F_HOME in {$big7} ) AND (a.F_AWAY in {$big7} ))
						)
						AND (( a.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER ='25')
						AND a.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER ='25')
						) OR ( a.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER ='34')
						AND a.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER ='34')
						)
						)
						group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						FROM all_results b WHERE (((b.F_HOME in {$big7} ) AND (b.F_AWAY in {$big7} ))
						)
						AND (( b.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER ='25')
						AND b.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER ='25')
						) OR ( b.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER ='34')
						AND b.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER ='34')
						)
						)
						group by b.F_AWAY";


				return $sql;
			}

			/**
			 * create a base table of team records vs Chelsea in the PL
			 * @return string
			 */
			function _0V_base_CFC() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_CFC AS
							select
							A.F_HOME AS Team,
							count(A.F_HOME) AS PLD,
							sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,
							sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,
							sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,
							sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,
							sum((if((A.F_HGOALS> 0 AND A.F_AGOALS > 0),1,0) = 1)) AS BTTS,
							sum(A.F_HGOALS) AS F, sum(A.F_AGOALS) AS A, sum((A.F_HGOALS - A.F_AGOALS)) AS GD,
							round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,
							sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
							from all_results A where ((A.F_HOME = 'CHELSEA') or (A.F_AWAY = 'CHELSEA')) group by A.F_HOME
							union all
							select
							B.F_AWAY AS Team,
							count(B.F_AWAY) AS PLD,
							sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,
							sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,
							sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,
							sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,
							sum((if((A.F_HGOALS> 0 AND A.F_AGOALS > 0),1,0) = 1)) AS BTTS,
							sum(B.F_AGOALS) AS F,sum(B.F_HGOALS) AS A, sum((B.F_AGOALS - B.F_HGOALS)) AS GD,
							round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
							sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
							from all_results B where ((B.F_HOME = 'CHELSEA') or (B.F_AWAY = 'CHELSEA'))
							group by B.F_AWAY";

				return $sql;
			}

			/**
			 * create a base table of team records vs Chelsea in the PL since date
			 * @param $date
			 * @return string
			 */
			function _0V_base_CFC2($date) {

				$sql = "CREATE OR REPLACE VIEW 0V_base_CFC AS
					select A.F_HOME AS Team,count(A.F_HOME) AS PLD,sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS,sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,sum(A.F_HGOALS) AS F,sum(A.F_AGOALS) AS A,sum((A.F_HGOALS - A.F_AGOALS)) AS GD,round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS from all_results A
					where ((A.F_HOME in ('CHELSEA')) OR (A.F_AWAY in ('CHELSEA')))
					and F_DATE > $date
					group by A.F_HOME
					union all
					select B.F_AWAY AS Team,count(B.F_AWAY) AS PLD,sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS,sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,sum(B.F_AGOALS) AS F,sum(B.F_HGOALS) AS A,sum((B.F_AGOALS - B.F_HGOALS)) AS GD,round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
					from all_results B
					where ((B.F_HOME in  ('CHELSEA'))  OR (B.F_AWAY in ('CHELSEA')))
					and F_DATE >  $date
					group by B.F_AWAY";

				return $sql;
			}

			/**
			 * create a base table of team records at close
			 * @return string
			 */
			function _0V_base_close_this() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_close_this AS
					select a.F_HOME AS Team,
					('H') LOC,
					count(a.F_HOME) AS PLD,
					sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
					sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
					sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
					sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
					sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
					sum(a.F_HGOALS) AS F,sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
					round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
					sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
					from all_results a
					where (a.F_HGOALS <= a.F_AGOALS + 1) AND (a.F_HGOALS >= a.F_AGOALS - 1 )
					and a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='CLOSE')
					group by a.F_HOME
					union all
					select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
					sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
					sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
					sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
					sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
					sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
					sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
					round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
					sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
					from all_results b
					where (b.F_HGOALS <= b.F_AGOALS + 1) AND (b.F_HGOALS >= b.F_AGOALS - 1 )
					and b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='CLOSE')
					group by B.F_AWAY";


				return $sql;
			}

			/**
			 * create a base table of team records at close
			 * @return string
			 */
			function _0V_base_close() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_close AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS,
						sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a
						where (a.F_HGOALS <= a.F_AGOALS + 1) AND (a.F_HGOALS >= a.F_AGOALS - 1 )
						group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS,
						sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b
						where (b.F_HGOALS <= b.F_AGOALS + 1) AND (b.F_HGOALS >= b.F_AGOALS - 1 )
						group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base view for Division 1 and Premier League all time
			 * @return string
			 */
			function _0V_base_COMBINE() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_COMBINE AS
						select a.F_HOME AS Team, ('DIV') LGE, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS,
						sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_pre a group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('DIV') LGE, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS,
						sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_pre b
						group by b.F_AWAY
						union all
						select a.F_HOME AS Team, ('PREM') LGE, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('PREM') LGE, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b
						group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base list of current pl teams
			 * @return string
			 */
			function _0V_base_current_pl_teams() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_current_pl_teams as
				SELECT DISTINCT F_HOME as Team FROM all_results
				WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL')
				UNION ALL
				SELECT DISTINCT F_AWAY as Team FROM all_results
				WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE = 'PL')";

				return $sql;
			}

			/**
			 * create a base table grouping ever present 7 team results by season and location
			 * @return string
			 */
			function _0V_base_EVER() {

				$ever6 = $this->ever6;

				$sql = "CREATE OR REPLACE VIEW 0V_base_EVER AS
					select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
					sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
					sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
					sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
					sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
					sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
					sum(a.F_HGOALS) AS F,  sum(a.F_AGOALS) AS A,
					sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
					round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
					sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
					from all_results a where ((a.F_HOME in {$ever6} ) and (a.F_AWAY in {$ever6} )) group by a.F_HOME
					union all
					select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
					sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
					sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
					sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
					sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
					sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
					sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
					round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
					sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
					from all_results b where ((b.F_HOME in {$ever6} ) and (b.F_AWAY in {$ever6} )) group by b.F_AWAY";

				return $sql;
			}

			/**
			 * create a base table grouping ever present 7 team results by season and location
			 * @return string
			 */
			function _0V_base_EVER_this() {

				$ever6 = $this->ever6;

				$sql = "CREATE OR REPLACE VIEW 0V_base_EVER_this AS
					select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
					sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
					sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
					sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
					sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
					sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
					sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
					round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
					sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
					from all_results a
					where ((a.F_HOME in {$ever6} )
					and (a.F_AWAY in {$ever6} ))
					and a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='EVER')
					group by a.F_HOME
					union all
					select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
					sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
					sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
					sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
					sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
					sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
					sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
					round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
					sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
					from all_results b
					where ((b.F_HOME in {$ever6} )
					and (b.F_AWAY in {$ever6} ))
					and b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='EVER') group by b.F_AWAY";

				return $sql;
			}

			/**
			 * base view Game rank for results page
			 * @return string
			 */
			function _0V_base_GRANK() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_RefRANK as
					SELECT '1' AS F_ORDER, 'Home' as F_LOC, 'GT' as F_KEY, 'ALL' as Team,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures WHERE F_LOCATION='H' GROUP BY F_ORDER, F_LOCATION, F_KEY, TEAM
					union all
					SELECT '2' AS F_ORDER, 'Away' as F_LOC, 'GT' as F_KEY, 'ALL' as Team,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures WHERE F_LOCATION='A' GROUP BY F_ORDER, F_LOCATION, F_KEY, TEAM
					union all
					SELECT '3' AS F_ORDER, 'Neutral' as F_LOC, 'GT' as F_KEY, 'ALL' as Team,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures WHERE F_LOCATION='N' GROUP BY F_ORDER, F_LOCATION, F_KEY, TEAM
					union all
					SELECT '4' as F_ORDER, 'Total' as F_LOC, 'GT' as F_KEY, 'ALL' as Team,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, nSUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures
					union all
					SELECT  '1' as F_ORDER, 'Home' as F_LOC, SUBSTRING(F_OPP,1,1) AS F_KEY, F_OPP AS Team,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures  WHERE F_LOCATION='H' GROUP BY F_ORDER, F_LOCATION, F_KEY, F_OPP
					union all
					SELECT  '2' as F_ORDER, 'Away' as F_LOC, SUBSTRING(F_OPP,1,1) AS F_KEY, F_OPP AS Team,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures  WHERE F_LOCATION='A' GROUP BY F_ORDER, F_LOCATION, F_KEY, F_OPP
					union all
					SELECT  '3' as F_ORDER, 'Neutral' as F_LOC, mSUBSTRING(F_OPP,1,1) AS F_KEY, F_OPP AS Team,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS,  SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures  WHERE F_LOCATION='N' GROUP BY F_ORDER, F_LOCATION, F_KEY, F_OPP
					union all
					SELECT  '4' as F_ORDER, 'Total' as F_LOC, SUBSTRING(F_OPP,1,1) AS F_KEY, F_OPP AS Team,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures  GROUP BY F_ORDER, F_KEY, F_OPP
					ORDER BY F_ORDER ASC, F_KEY ASC, Team ASC";

				return $sql;
			}

			/**
			 * base view Game rank for results page
			 * @return string
			 */
			function _0V_base_REFRANK() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_REFRANK as
					SELECT '1' AS F_ORDER, 'Home' as F_LOC, 'GT' as F_KEY, 'ALL' as Referee,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures WHERE F_LOCATION='H' GROUP BY F_ORDER, F_LOCATION, F_KEY
					union all
					SELECT '2' AS F_ORDER, 'Away' as F_LOC, 'GT' as F_KEY, 'ALL' as Team,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures WHERE F_LOCATION='A' GROUP BY F_ORDER, F_LOCATION, F_KEY
					union all
					SELECT '3' AS F_ORDER, 'Neutral' as F_LOC, 'GT' as F_KEY, 'ALL' as Referee,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures WHERE F_LOCATION='N' GROUP BY F_ORDER, F_LOCATION, F_KEY
					union all
					SELECT '4' as F_ORDER, 'Total' as F_LOC, 'GT' as F_KEY, 'ALL' as Referee,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures
					union all
					SELECT  '1' as F_ORDER, 'Home' as F_LOC, SUBSTRING(F_REF,1,1) AS F_KEY, F_REF AS Referee,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures  WHERE F_LOCATION='H' GROUP BY F_ORDER, F_LOCATION, F_KEY, F_REF
					union all
					SELECT  '2' as F_ORDER, 'Away' as F_LOC, SUBSTRING(F_REF,1,1) AS F_KEY, F_REF AS Referee,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures  WHERE F_LOCATION='A' GROUP BY F_ORDER, F_LOCATION, F_KEY, F_REF
					union all
					SELECT  '3' as F_ORDER, 'Neutral' as F_LOC, SUBSTRING(F_REF,1,1) AS F_KEY, F_REF AS Referee,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS,  SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures  WHERE F_LOCATION='N' GROUP BY F_ORDER, F_LOCATION, F_KEY, F_REF
					union all
					SELECT  '4' as F_ORDER, 'Total' as F_LOC, SUBSTRING(F_REF,1,1) AS F_KEY, F_REF AS Referee,
					SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
					SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
					SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
					SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
					ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
					ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
					ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
					SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
					SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
					ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
					SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
					ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
					FROM cfc_fixtures  GROUP BY F_ORDER, F_KEY, F_REF
					ORDER BY F_ORDER ASC, F_KEY ASC, Referee ASC";

				return $sql;
			}

			/**
			 * compare results from this season with like for like to last season
			 * @return string
			 */
			function _0V_base_ISG() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_ISG as
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_HOME = b.F_HOME AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_HOME = b.F_HOME AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED1')
						AND b.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED1')
						AND a.F_HOME = b.F_HOME
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED1')
						AND b.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED1')
						AND a.F_HOME = b.F_HOME
						UNION ALL
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED1')
						AND b.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED1')
						AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED1')
						AND b.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED1')
						AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED2')
						AND b.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED2')
						AND a.F_HOME = b.F_HOME
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED2')
						AND b.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED2')
						AND a.F_HOME = b.F_HOME
						UNION ALL
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED2')
						AND b.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED2')
						AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED2')
						AND b.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED2')
						AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED3')
						AND b.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED3')
						AND a.F_HOME = b.F_HOME
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED3')
						AND b.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED3')
						AND a.F_HOME = b.F_HOME
						UNION ALL
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED3')
						AND b.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED3')
						AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results a, all_results b, meta_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						AND a.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='PROMOTED3')
						AND b.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='RELEGATED3')
						AND a.F_AWAY = b.F_AWAY";


				return $sql;
			}

			/**
			 * display league table from ISG results
			 * @return string
			 */
			function _0V_base_ISG_table() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_ISG_table AS
						select a.F_HOME AS Team, ('H') LOC,  a.F_LABEL, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS,
						sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from 0V_base_ISG a
						where a.F_LABEL = (select y.F_LABEL from meta_seasons y, 000_config z where y.F_SDATE = z.F_DATE and z.F_LEAGUE = 'PL')
						group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  b.F_LABEL, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from 0V_base_ISG b
						where b.F_LABEL = (select y.F_LABEL from meta_seasons y, 000_config z where y.F_SDATE = z.F_DATE and z.F_LEAGUE = 'PL')
						group by b.F_AWAY
						union all
						select a.F_HOME AS Team, ('H') LOC, a.F_LABEL, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS,
						sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from 0V_base_ISG a
						where a.F_LABEL = (select y.F_LABEL from meta_seasons y, 000_config z where y.F_SDATE = z.F_DATE and z.F_LEAGUE = 'PLm1')
						group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, b.F_LABEL, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from 0V_base_ISG b
						where b.F_LABEL = (select y.F_LABEL from meta_seasons y, 000_config z where y.F_SDATE = z.F_DATE and z.F_LEAGUE = 'PLm1')
						group by b.F_AWAY";

				return $sql;
			}

			/**
			 * create base table for ISG values
			 * @return string
			 */
			function _0V_base_ISG_totals() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_ISG_totals as
						SELECT F_LABEL as Label, Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS,
						SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
						FROM 0V_base_ISG_table GROUP BY Label, Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";

				return $sql;
			}

			/**
			 * Base view  of all London teams in the PL (Watford do not count)
			 *
			 * @return string
			 */
			function _0V_base_LDN() {

				$ldn = $this->ldn;

				$sql = "CREATE OR REPLACE VIEW 0V_base_LDN AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS,
						sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)))
						/ count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME in $ldn ) and (a.F_AWAY in $ldn )) group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME in $ldn ) and (b.F_AWAY in $ldn )) group by B.F_AWAY";

				return $sql;
			}

			/**
			 * "Base view  of all non-London teams in the PL
			 * @return string
			 */
			function _0V_base_LDN_non() {

				$ldn = $this->ldn;

				$sql = "CREATE OR REPLACE VIEW 0V_base_LDN_non AS
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME in {$ldn} ) and (b.F_AWAY not in {$ldn} ))
						group by b.F_AWAY";

				return $sql;
			}

			/**
			 * Base view of all non-London teams in the PL - this season
			 * @return string
			 */
			function _0V_base_LDN_non_this() {

				$ldn = $this->ldn;

				$sql = "CREATE OR REPLACE VIEW 0V_base_LDN_non_this AS
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME in {$ldn} ) and (b.F_AWAY not in {$ldn} ))
						and b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='LDN') group by b.F_AWAY";

				return $sql;
			}

			/**
			 * Base view  of all London teams in the PL (Watford do not count) - this season
			 * @return string
			 */
			function _0V_base_LDN_this() {

				$ldn = $this->ldn;

				$sql = "CREATE OR REPLACE VIEW 0V_base_LDN_this AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME in {$ldn} ) and (a.F_AWAY in {$ldn} ))
						and a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='LDN') group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME in {$ldn} ) and (b.F_AWAY in {$ldn} ))
						and b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='LDN') group by b.F_AWAY";

				return $sql;
			}

			/**
			 * London league base table under Jose Mourinho
			 * @return string
			 */
			function _0V_base_LDN_TSO() {

				$ldn = $this->ldn;

				$sql = "CREATE OR REPLACE VIEW 0V_base_LDN_TSO AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						FROM all_results a WHERE (((a.F_HOME in {$ldn}) AND (a.F_AWAY in {$ldn} ))
						)
						AND (( a.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER ='25')
						AND a.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER ='25')
						) OR ( a.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER ='34')
						AND a.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER ='34')
						)
						)
						group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						FROM all_results b WHERE (((b.F_HOME in {$ldn} ) AND (b.F_AWAY in {$ldn} ))
						)
						AND (( b.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER ='25')
						AND b.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER ='25')
						) OR ( b.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER ='34')
						AND b.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER ='34')
						)
						)
						group by b.F_AWAY";

				return $sql;
			}

			/**
			 * base view for cfc managers
			 * @return string
			 */
			function _0V_base_mgr() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_mgr as
						SELECT 'CFC' AS F_TYPE, b.F_ORDER, b.F_SNAME, b.F_DOB, b.F_TROPHIES,
						YEAR(b.F_SDATE) as S_YEAR, YEAR(b.F_EDATE) as E_YEAR, b.F_SDATE as S_DATE, b.F_EDATE as E_DATE,
						SUM(IF(a.F_RESULT<>'0',1,0)=1) AS PLD,
						SUM(IF(a.F_RESULT='W',1,0)=1) W, SUM(IF(a.F_RESULT='D',1,0)=1) D, SUM(IF(a.F_RESULT='L',1,0)=1) L,
						SUM(IF(a.F_FOR=0,1,0)=1) FS, SUM(IF(a.F_AGAINST=0,1,0)=1) CS,
						SUM(a.F_FOR) AS F_FOR, SUM(a.F_AGAINST) AS F_AGAINST, SUM(a.F_FOR)-SUM(a.F_AGAINST) AS GD,
						COALESCE((SUM(IF(a.F_RESULT='W',1,0)=1))*3+(SUM(IF(a.F_RESULT='D',1,0)=1)),0) AS PTS,
						COALESCE(ROUND(((SUM(IF(a.F_RESULT='W',1,0)=1))*3  +(SUM(IF(a.F_RESULT='D',1,0)=1)))  /(SUM(IF(a.F_RESULT<>'0',1,0)=1)),3),0) AS PPG,
						COALESCE(ROUND((SUM(IF(a.F_RESULT='W',1,0)=1)/SUM(IF(a.F_RESULT<>'0',1,0)=1))*100,3),0) AS F_WINPER,
						COALESCE(ROUND((SUM(IF(a.F_RESULT='D',1,0)=1)/SUM(IF(a.F_RESULT<>'0',1,0)=1))*100,3),0) AS F_DRAWPER,
						COALESCE(ROUND((SUM(IF(a.F_RESULT='L',1,0)=1)/SUM(IF(a.F_RESULT<>'0',1,0)=1))*100,3),0) AS F_LOSSPER,
						COALESCE(ROUND((((SUM(IF(a.F_RESULT='W',1,0)=1))  +(SUM(IF(a.F_RESULT='D',1,0)=1)))  /SUM(IF(a.F_RESULT<>'0',1,0)=1))*100,3),0) AS F_UNDER
						FROM cfc_fixtures a, cfc_managers b
						WHERE a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE
						GROUP BY F_TYPE, b.F_ORDER, b.F_SNAME, b.F_SDATE, b.F_EDATE, b.F_DOB, b.F_TROPHIES
						UNION ALL
						SELECT 'WSL' AS F_TYPE, b.F_ORDER, b.F_SNAME, b.F_DOB, b.F_TROPHIES,
						YEAR(b.F_SDATE) as S_YEAR, YEAR(b.F_EDATE) as E_YEAR, b.F_SDATE as S_DATE, b.F_EDATE as E_DATE,
						SUM(IF(a.F_RESULT<>'0',1,0)=1) AS PLD,
						SUM(IF(a.F_RESULT='W',1,0)=1) W, SUM(IF(a.F_RESULT='D',1,0)=1) D, SUM(IF(a.F_RESULT='L',1,0)=1) L,
						SUM(IF(a.F_FOR=0,1,0)=1) FS, SUM(IF(a.F_AGAINST=0,1,0)=1) CS,
						SUM(a.F_FOR) AS F_FOR, SUM(a.F_AGAINST) AS F_AGAINST, SUM(a.F_FOR)-SUM(a.F_AGAINST) AS GD,
						COALESCE((SUM(IF(a.F_RESULT='W',1,0)=1))*3+(SUM(IF(a.F_RESULT='D',1,0)=1)),0) AS PTS,
						COALESCE(ROUND(((SUM(IF(a.F_RESULT='W',1,0)=1))*3  +(SUM(IF(a.F_RESULT='D',1,0)=1)))  /(SUM(IF(a.F_RESULT<>'0',1,0)=1)),3),0) AS PPG,
						COALESCE(ROUND((SUM(IF(a.F_RESULT='W',1,0)=1)/SUM(IF(a.F_RESULT<>'0',1,0)=1))*100,3),0) AS F_WINPER,
						COALESCE(ROUND((SUM(IF(a.F_RESULT='D',1,0)=1)/SUM(IF(a.F_RESULT<>'0',1,0)=1))*100,3),0) AS F_DRAWPER,
						COALESCE(ROUND((SUM(IF(a.F_RESULT='L',1,0)=1)/SUM(IF(a.F_RESULT<>'0',1,0)=1))*100,3),0) AS F_LOSSPER,
						COALESCE(ROUND((((SUM(IF(a.F_RESULT='W',1,0)=1))  +(SUM(IF(a.F_RESULT='D',1,0)=1)))  /SUM(IF(a.F_RESULT<>'0',1,0)=1))*100,3),0) AS F_UNDER
						FROM wsl_fixtures a, wsl_managers b
						WHERE a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE
						GROUP BY F_TYPE, b.F_ORDER, b.F_SNAME, b.F_SDATE, b.F_EDATE, b.F_DOB, b.F_TROPHIES
						ORDER BY F_TYPE, F_ORDER DESC";

				return $sql;
			}

			/**
			 * Base table for Per90 stats used
			 * @return string
			 */
			function _0V_base_Per90s() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_Per90s as
						SELECT a.F_NO, a.F_NAME,  sum(a.F_GOALS) AS F_GOALS, sum(a.F_SHOTS) AS F_SHOTS,
						sum(a.F_SHOTSON) AS F_SHOTSON, sum(a.F_ASSISTS) AS F_ASSISTS, sum(a.F_FOULSSUF) AS F_FOULSSUF,
						sum(a.X_MINUTES) AS F_MINS, (sum(a.F_GOALS) / (sum(a.X_MINUTES) / 90)) AS GP90,
						(sum(a.F_ASSISTS) / (sum(a.X_MINUTES) / 90)) AS AP90, (sum((a.F_GOALS + a.F_ASSISTS)) / (sum(a.X_MINUTES) / 90)) AS PP90,
						(sum(a.F_FOULSSUF) / (sum(a.X_MINUTES) / 90)) AS FSP90
						from cfc_fixtures_players a, cfc_players b,  meta_squadno c, cfc_fixtures d
						where a.F_NAME =  b.F_NAME  and  c.F_SQUADNO = a.F_NO and c.F_END is null
						and  a.F_DATE >= (select 000_config.F_DATE from 000_config where F_LEAGUE = 'PL') and a.F_GAMEID = d.F_ID
						and d.F_COMPETITION = 'PREM' group by a.F_NO,a.F_NAME  having sum(a.X_MINUTES) > 0 order by PP90 desc";

				return $sql;
			}

			/**
			 * base view for Premier League all time
			 * @return string
			 */
			function _0V_base_PL() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b group by b.F_AWAY";

				return $sql;
			}

			/**
			 * base view for Premier League all time
			 * @return string
			 */
			function _0V_base_PL_mgr() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_mgr AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.f_date >= (select F_SDATE from cfc_managers order by F_ORDER desc limit 1)
						group by a.F_HOME 
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.f_date > (select F_SDATE from cfc_managers order by F_ORDER desc limit 1)
						group by b.F_AWAY";

				return $sql;
			}

			/**
			 * base view for the premier league - by goal difference
			 * @return string
			 */
			function _0V_base_PL_GDIFF() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PLGDIFF AS
						SELECT TEAM, ROUND( (SUM(F)/SUM(PLD)) - (SUM(A)/SUM(PLD)) ,3) AS DIFF FROM 0V_base_PL ORDER BY DIFF DESC";

				return $sql;
			}

			/**
			 * base view for the premier league - post new year
			 * @return string
			 */
			function _0V_base_PL_post() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_post AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where month(a.F_DATE) in ('1','2','3','4','5','6')
						group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b
						where month(b.F_DATE) in ('1','2','3','4','5','6') group by B.F_AWAY";


				return $sql;
			}

			/**
			 * base view for the premier league - pre new year
			 * @return string
			 */
			function _0V_base_PL_pre() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_pre AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where month(a.F_DATE) in ('7','8','9','10','11','12')
						group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b
						where month(b.F_DATE) in ('7','8','9','10','11','12') group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base table for the premier league - this season - Shots instead of goals
			 * @return string
			 */
			function _0V_base_PL_shots() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_shots AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.H_Shots > a.A_Shots),1,0) = 1)) AS W,
						sum((if((a.H_Shots = a.A_Shots),1,0) = 1)) AS D,
						sum((if((a.H_Shots < a.A_Shots),1,0) = 1)) AS L,
						sum((if((a.H_Shots = 0),1,0) = 1)) AS FS, sum((if((a.A_Shots = 0),1,0) = 1)) AS CS,
						sum((if((a.A_Shots > 0 AND a.H_Shots > 0),1,0) = 1)) AS BTTS,
						sum(a.H_Shots) AS F, sum(a.A_Shots) AS A, sum((a.H_Shots - a.A_Shots)) AS GD,
						round((sum((((if((a.H_Shots > a.A_Shots),1,0) = 1) * 3) + (if((a.H_Shots = a.A_Shots),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.H_Shots > a.A_Shots),1,0) = 1) * 3) + (if((a.H_Shots = a.A_Shots),1,0) = 1))) AS PTS
						from all_ShotsLeague a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.A_Shots > b.H_Shots),1,0) = 1)) AS W,
						sum((if((b.A_Shots = b.H_Shots),1,0) = 1)) AS D,
						sum((if((b.A_Shots < b.H_Shots),1,0) = 1)) AS L,
						sum((if((b.A_Shots = 0),1,0) = 1)) AS FS, sum((if((b.H_Shots = 0),1,0) = 1)) AS CS,
						sum((if((b.A_Shots > 0 AND b.H_Shots > 0),1,0) = 1)) AS BTTS,
						sum(b.A_Shots) AS F, sum(b.H_Shots) AS A, sum((b.A_Shots - b.H_Shots)) AS GD,
						round((sum((((if((b.A_Shots > b.H_Shots),1,0) = 1) * 3) + (if((b.A_Shots = b.H_Shots),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.A_Shots > b.H_Shots),1,0) = 1) * 3) + (if((b.A_Shots = b.H_Shots),1,0) = 1))) AS PTS
						from all_ShotsLeague b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base table for the premier league - this season - SOT instead of goals
			 * @return string
			 */
			function _0V_base_PL_shotsOn() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_shotsOn AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.H_SoT > a.A_SoT),1,0) = 1)) AS W,
						sum((if((a.H_SoT = a.A_SoT),1,0) = 1)) AS D,
						sum((if((a.H_SoT < a.A_SoT),1,0) = 1)) AS L,
						sum((if((a.H_SoT = 0),1,0) = 1)) AS FS, sum((if((a.A_SoT = 0),1,0) = 1)) AS CS,
						sum((if((a.A_SoT > 0 AND a.H_SoT > 0),1,0) = 1)) AS BTTS,
						sum(a.H_SoT) AS F, sum(a.A_SoT) AS A, sum((a.H_SoT - a.A_SoT)) AS GD,
						round((sum((((if((a.H_SoT > a.A_SoT),1,0) = 1) * 3) + (if((a.H_SoT = a.A_SoT),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.H_SoT > a.A_SoT),1,0) = 1) * 3) + (if((a.H_SoT = a.A_SoT),1,0) = 1))) AS PTS
						from all_SoTLeague a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.A_SoT > b.H_SoT),1,0) = 1)) AS W,
						sum((if((b.A_SoT = b.H_SoT),1,0) = 1)) AS D,
						sum((if((b.A_SoT < b.H_SoT),1,0) = 1)) AS L,
						sum((if((b.A_SoT = 0),1,0) = 1)) AS FS, sum((if((b.H_SoT = 0),1,0) = 1)) AS CS,
						sum((if((b.A_SoT > 0 AND b.H_SoT > 0),1,0) = 1)) AS BTTS,
						sum(b.A_SoT) AS F, sum(b.H_SoT) AS A, sum((b.A_SoT - b.H_SoT)) AS GD,
						round((sum((((if((b.A_SoT > b.H_SoT),1,0) = 1) * 3) + (if((b.A_SoT = b.H_SoT),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.A_SoT > b.H_SoT),1,0) = 1) * 3) + (if((b.A_SoT = b.H_SoT),1,0) = 1))) AS PTS
						from all_SoTLeague b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base table for the premier league - this season
			 * @return string
			 */
			function _0V_base_PL_this() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_this AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') group by B.F_AWAY";


				return $sql;
			}

			/**
			 * base view for the premier league - this season - team concedes first
			 * @return string
			 */
			function _0V_base_PL_this_1C() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_this_1C AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and a.F_1G = 'A' group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and b.F_1G = 'H' group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base view for the premier league - this season - team scores first
			 * @return string
			 */
			function _0V_base_PL_this_1S() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_this_1S AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A,  sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and a.F_1G ='H' group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and b.F_1G ='A' group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base table for the premier league - this season - team is drawing at half-time
			 * @return string
			 */
			function _0V_base_PL_this_D_HT() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_this_D_HT AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and a.HT_HGOALS = a.HT_AGOALS group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and b.HT_HGOALS = b.HT_AGOALS group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base table for the premier league - this season - team is losing at half-time
			 * @return string
			 */
			function _0V_base_PL_this_L_HT() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_this_L_HT AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and a.HT_HGOALS < a.HT_AGOALS group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and b.HT_HGOALS > b.HT_AGOALS group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base view for the premier league - this season - post new year
			 * @return string
			 */
			function _0V_base_PL_this_post() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_this_post AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL')
						and a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='cutoff') group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL')
						and b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='cutoff') group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base view for the premier league - this season - pre new year
			 * @return string
			 */
			function _0V_base_PL_this_pre() {
				
				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_this_pre AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL')
						and a.F_DATE <= (select F_DATE from 000_config where F_LEAGUE='cutoff') group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL')
						and b.F_DATE <= (select F_DATE from 000_config where F_LEAGUE='cutoff') group by B.F_AWAY";
				
				return $sql;
			}

			/**
			 * base view for the premier league - this season - team is winning or drawing at half-time
			 * @return string
			 */
			function _0V_base_PL_this_WD_HT() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_this_WD_HT AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F,  sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and a.HT_HGOALS >= a.HT_AGOALS group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and b.HT_HGOALS <= b.HT_AGOALS group by B.F_AWAY";


				return $sql;
			}

			/**
			 * base view for the premier league - this season - team is winning at half-time
			 * @return string
			 */
			function _0V_base_PL_this_W_HT() {
				
				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_this_W_HT AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and a.HT_HGOALS > a.HT_AGOALS group by a.F_HOME
						union all 
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') and b.HT_HGOALS < b.HT_AGOALS group by B.F_AWAY";
				
				return $sql;
			}

			/**
			 * base view for the premier league - by year
			 * @return string
			 */
			function _0V_base_PL_year() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PL_year AS
							select c.f_label as year, a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
							sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
							sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
							sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
							sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
							sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
							sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
							round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
							sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
							from all_results a, meta_seasons c WHERE  a.F_DATE > c.F_SDATE AND a.F_DATE < c.F_EDATE group by year,a.F_HOME
							union all 
							select c.f_label as year, b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
							sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
							sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
							sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
							sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
							sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
							sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
							round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
							sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
							from all_results b, meta_seasons c WHERE  b.F_DATE > c.F_SDATE AND b.F_DATE < c.F_EDATE group by year, b.F_AWAY";
				return $sql;
			}

			/**
			 * base view for Premier League all time
			 * @return string
			 */
			function _0V_base_PRE() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_PRE AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_pre a group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_pre b group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base table for the big 7 by location
			 * @return string
			 */
			function _0V_base_PRJ() {

				$big7 = $this->big7;

				$sql = "CREATE OR REPLACE VIEW 0V_base_PRJ AS
						select a.F_HOME AS Team,'H' AS LOC,count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if(((a.F_AGOALS > 0) and (a.F_HGOALS > 0)),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F,sum(a.F_AGOALS) AS A,
						sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME in {$big7} ) and (a.F_AWAY not in {$big7}  )) group by a.F_HOME
						union all
						select b.F_AWAY AS Team,'A' AS LOC,count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if(((b.F_AGOALS > 0) and (b.F_HGOALS > 0)),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F,sum(b.F_HGOALS) AS A,sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME not in {$big7}  ) and (b.F_AWAY in {$big7}  )) group by b.F_AWAY
						union all
						select a.F_HOME AS Team,'H' AS LOC,count(a.F_HOME) AS PLD,sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if(((a.F_AGOALS > 0) and (a.F_HGOALS > 0)),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F,sum(a.F_AGOALS) AS A,
						sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME not in {$big7}  ) and (a.F_AWAY in {$big7}  )) group by a.F_HOME
						union all
						select b.F_AWAY AS Team,'A' AS LOC,count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if(((b.F_AGOALS > 0) and (b.F_HGOALS > 0)),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F,sum(b.F_HGOALS) AS A,
						sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME in {$big7}  ) and (b.F_AWAY not in {$big7}  )) group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base table for the big 7 by year - this season
			 * @return string
			 */
			function _0V_base_PRJ_this() {

				$big7 = $this->big7;

				$sql = "CREATE OR REPLACE VIEW 0V_base_PRJ_this AS
						select a.F_HOME AS Team,'H' AS LOC,count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if(((a.F_AGOALS > 0) and (a.F_HGOALS > 0)),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F,sum(a.F_AGOALS) AS A,
						sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME in {$big7}  ) and (a.F_AWAY not in {$big7}  )
						and (a.F_DATE > (select 000_config.F_DATE from 000_config where (000_config.F_LEAGUE = 'BIG')))) group by a.F_HOME
						union all
						select b.F_AWAY AS Team,'A' AS LOC,count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if(((b.F_AGOALS > 0) and (b.F_HGOALS > 0)),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F,sum(b.F_HGOALS) AS A,sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME not in {$big7}  ) and (b.F_AWAY in {$big7}  )
						and (b.F_DATE > (select 000_config.F_DATE from 000_config where (000_config.F_LEAGUE = 'BIG')))) group by b.F_AWAY
						union all
						select a.F_HOME AS Team,'H' AS LOC,count(a.F_HOME) AS PLD,sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if(((a.F_AGOALS > 0) and (a.F_HGOALS > 0)),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F,sum(a.F_AGOALS) AS A,
						sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME not in {$big7}  ) and (a.F_AWAY in {$big7}  )
						and (a.F_DATE > (select 000_config.F_DATE from 000_config where (000_config.F_LEAGUE = 'BIG')))) group by a.F_HOME
						union all
						select b.F_AWAY AS Team,'A' AS LOC,count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if(((b.F_AGOALS > 0) and (b.F_HGOALS > 0)),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F,sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME in {$big7}  ) and (b.F_AWAY not in {$big7}  )
						and (b.F_DATE > (select 000_config.F_DATE from 000_config where (000_config.F_LEAGUE = 'BIG')))) group by B.F_AWAY";


				return $sql;
			}

			/**
			 * base table using pythagoras theorem for goals to points
			 * @return string
			 */
			function _0V_base_pythag_this() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_pythag_this as SELECT *,
						round(((f*f)/((f*f)+(a*a))*100),3) as Pythag from 0V_base_PL_this ORDER BY  Pythag desc";

				return $sql;
			}

			/**
			 * base south west london derby league - all time
			 * @return string
			 */
			function _0V_base_SWLDN() {

				$swldn = $this->swldn;

				$sql = "CREATE OR REPLACE VIEW 0V_base_SWLDN AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME in {$swldn} ) and (a.F_AWAY in {$swldn} )) group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME in {$swldn} ) and (b.F_AWAY in {$swldn} )) group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base south west london derby league - this season
			 * @return string
			 */
			function _0V_base_SWLDN_this() {

				$swldn = $this->swldn;

				$sql = "CREATE OR REPLACE VIEW 0V_base_SWLDN_this AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME in {$swldn} ) and (a.F_AWAY in {$swldn} ))
						and a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='LDN') group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME in {$swldn} ) and (b.F_AWAY in {$swldn} ))
						and b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='LDN') group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base view of the premier league excluding big 7 teams - all time
			 * @return string
			 */
			function _0V_base_T13() {

				$big7 = $this->big7;

				$sql = "CREATE OR REPLACE VIEW 0V_base_T13 AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME NOT IN {$big7} ) and (a.F_AWAY NOT IN {$big7}  )) group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME NOT IN {$big7}  ) and (b.F_AWAY NOT IN {$big7}  )) group by B.F_AWAY";
				
				return $sql;
			}

			/**
			 * base view of the premier league excluding big 7 teams - this season
			 * @return string
			 */
			function _0V_base_T13_this() {

				$big7 = $this->big7;

				$sql = "CREATE OR REPLACE VIEW 0V_base_T13_this AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F,sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where ((a.F_HOME NOT IN {$big7}  ) and (a.F_AWAY NOT IN {$big7}  ))
						and a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='T13') group by a.F_HOME
						union all 
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where ((b.F_HOME NOT IN {$big7}  ) and (b.F_AWAY NOT IN {$big7}  ))
						and b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='T13') group by B.F_AWAY";
				
				return $sql;
			}

			/**
			 * base view for all time Mourinho record
			 * @return string
			 */
			function _0V_base_TSO() {
				
				$sql = "CREATE OR REPLACE VIEW 0V_base_TSO AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						FROM all_results a
						WHERE  ( a.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER='25')
						AND a.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER='25') )
						OR ( a.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER='34')
						AND a.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER='34') )
						group by a.F_HOME
						union all 
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						FROM all_results b
						WHERE ( b.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER='25')
						AND b.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER='25') )
						OR ( b.F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER='34')
						AND b.F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER='34') )
						group by b.F_AWAY";
				
				return $sql;
			}

			/**
			 * base Womens Development league north - all time
			 * @return string
			 */
			function _0V_base_WDL_north() {
				
				$sql = "CREATE OR REPLACE VIEW 0V_base_WDL_north AS
						select A.F_HOME AS Team, ('H') LOC,  count(A.F_HOME) AS PLD,
						sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,
						sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,
						sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,
						sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((A.F_AGOALS > 0 AND A.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(A.F_HGOALS) AS F, sum(A.F_AGOALS) AS A, sum((A.F_HGOALS - A.F_AGOALS)) AS GD,
						round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,
						sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wdl_north A group by A.F_HOME
						union all
						select B.F_AWAY AS Team, ('A') LOC, count(B.F_AWAY) AS PLD,
						sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,
						sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,
						sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,
						sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((B.F_AGOALS > 0 AND B.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(B.F_AGOALS) AS F, sum(B.F_HGOALS) AS A, sum((B.F_AGOALS - B.F_HGOALS)) AS GD,
						round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
						sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wdl_north B
						group by B.F_AWAY";


				return $sql;
			}

			/**
			 * base Womens Development league north - this season
			 * @return string
			 */
			function _0V_base_WDL_north_this() {
				
				$sql = "CREATE OR REPLACE VIEW 0V_base_WDL_north_this AS
						select A.F_HOME AS Team, ('H') LOC,  count(A.F_HOME) AS PLD,
						sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,
						sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,
						sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,
						sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((A.F_AGOALS > 0 AND A.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(A.F_HGOALS) AS F, sum(A.F_AGOALS) AS A, sum((A.F_HGOALS - A.F_AGOALS)) AS GD,
						round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,
						sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wdl_north A where A.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WDL') group by A.F_HOME
						union all 
						select B.F_AWAY AS Team, ('A') LOC, count(B.F_AWAY) AS PLD,
						sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,
						sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,
						sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,
						sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((B.F_AGOALS > 0 AND B.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(B.F_AGOALS) AS F, sum(B.F_HGOALS) AS A, sum((B.F_AGOALS - B.F_HGOALS)) AS GD,
						round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
						sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wdl_north B where B.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WDL') group by B.F_AWAY";


				return $sql;
			}

			/**
			 * base Womens Development league south - all time
			 * @return string
			 */
			function _0V_base_WDL_south() {
				
				$sql = "CREATE OR REPLACE VIEW 0V_base_WDL_south AS
						select A.F_HOME AS Team, ('H') LOC,  count(A.F_HOME) AS PLD,
						sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,
						sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,
						sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,
						sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((A.F_AGOALS > 0 AND A.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(A.F_HGOALS) AS F, sum(A.F_AGOALS) AS A, sum((A.F_HGOALS - A.F_AGOALS)) AS GD,
						round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,
						sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wdl_south A group by A.F_HOME
						union all
						select B.F_AWAY AS Team, ('A') LOC, count(B.F_AWAY) AS PLD,
						sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,
						sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,
						sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,
						sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((B.F_AGOALS > 0 AND B.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(B.F_AGOALS) AS F, sum(B.F_HGOALS) AS A, sum((B.F_AGOALS - B.F_HGOALS)) AS GD,
						round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
						sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wdl_south B group by B.F_AWAY";


				return $sql;
			}

			/**
			 * base Womens Development league south - this season
			 * @return string
			 */
			function _0V_base_WDL_south_this() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WDL_south_this AS
						select A.F_HOME AS Team, ('H') LOC,  count(A.F_HOME) AS PLD,
						sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,
						sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,
						sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,
						sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((A.F_AGOALS > 0 AND A.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(A.F_HGOALS) AS F, sum(A.F_AGOALS) AS A, sum((A.F_HGOALS - A.F_AGOALS)) AS GD,
						round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,
						sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wdl_south A where A.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WDL') group by A.F_HOME
						union all
						select B.F_AWAY AS Team, ('A') LOC, count(B.F_AWAY) AS PLD,
						sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,
						sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,
						sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,
						sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((B.F_AGOALS > 0 AND B.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(B.F_AGOALS) AS F, sum(B.F_HGOALS) AS A, sum((B.F_AGOALS - B.F_HGOALS)) AS GD,
						round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
						sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wdl_south B where B.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WDL') group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base table for Womens rankings
			 * @return string
			 */
			function _0V_base_WRANK() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WRANK as
						SELECT '1' AS F_ORDER, 'Home' as F_LOC, 'GT' as F_KEY, 'ALL' as Team,
						SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
						SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
						SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
						SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
						ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
						ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
						SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
						SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
						ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
						SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
						ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
						FROM wsl_fixtures WHERE F_LOCATION='H' GROUP BY F_ORDER, F_LOCATION, F_KEY, TEAM
						union all
						SELECT  '2' AS F_ORDER, 'Away' as F_LOC, 'GT' as F_KEY, 'ALL' as Team,
						SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
						SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
						SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
						SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
						ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
						ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
						SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
						SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
						ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
						SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
						ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
						FROM wsl_fixtures WHERE F_LOCATION='A' GROUP BY F_ORDER, F_LOCATION, F_KEY, TEAM
						union all
						SELECT '3' AS F_ORDER, 'Neutral' as F_LOC, 'GT' as F_KEY, 'ALL' as Team,
						SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
						SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
						SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
						SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
						ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
						ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
						SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
						SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
						ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
						SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
						ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
						FROM wsl_fixtures WHERE F_LOCATION='N' GROUP BY F_ORDER, F_LOCATION, F_KEY, TEAM
						union all
						SELECT '4' as F_ORDER, 'Total' as F_LOC, 'GT' as F_KEY, 'ALL' as Team,
						SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
						SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
						SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
						SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
						ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
						ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
						SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
						SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
						ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
						SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
						ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
						FROM wsl_fixtures
						union all
						SELECT '1' as F_ORDER, 'Home' as F_LOC, SUBSTRING(F_OPP,1,1) AS F_KEY, F_OPP AS Team,
						SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
						SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
						SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
						SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
						ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
						ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
						SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
						SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
						ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
						SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
						ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
						FROM wsl_fixtures  WHERE F_LOCATION='H' GROUP BY F_ORDER, F_LOCATION, F_KEY, F_OPP
						union all
						SELECT '2' as F_ORDER, 'Away' as F_LOC, SUBSTRING(F_OPP,1,1) AS F_KEY, F_OPP AS Team,
						SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
						SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
						SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
						SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
						ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
						ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
						SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
						SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
						ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
						SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
						ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
						FROM wsl_fixtures  WHERE F_LOCATION='A' GROUP BY F_ORDER, F_LOCATION, F_KEY, F_OPP
						union all
						SELECT '3' as F_ORDER, 'Neutral' as F_LOC, SUBSTRING(F_OPP,1,1) AS F_KEY, F_OPP AS Team,
						SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
						SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
						SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
						SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
						ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
						ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
						SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
						SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
						ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
						SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
						ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
						FROM wsl_fixtures  WHERE F_LOCATION='N' GROUP BY F_ORDER, F_LOCATION, F_KEY, F_OPP
						union all
						SELECT '4' as F_ORDER, 'Total' as F_LOC, SUBSTRING(F_OPP,1,1) AS F_KEY, F_OPP AS Team,
						SUM(IF(F_RESULT<>'0'=1,1,0)) AS F_PLD,
						SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
						SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
						SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_WINPER,
						ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_DRAWPER,
						ROUND((SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_LOSSPER,
						ROUND((SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2)+ ROUND((SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT<>'0'=1,1,0)) )*100,2) AS F_UNDER,
						SUM(IF(F_AGAINST='0'=1,1,0)) AS F_CLEAN, SUM(IF(F_FOR='0'=1,1,0)) AS F_FAILED,
						SUM(F_FOR) AS F_FOR, SUM(F_AGAINST) AS F_AGAINST, SUM(F_FOR)-SUM(F_AGAINST) AS F_GD,
						ROUND(SUM(F_FOR)/SUM(IF(F_RESULT<>'0'=1,1,0)),3) AS F_GFPG, ROUND(SUM(F_AGAINST)/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_GAPG,
						SUM((IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS F_POINTS, SUM((IF(F_RESULT='L'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)) AS A_POINTS,
						ROUND(((SUM(IF(F_RESULT='W'=1,1,0))*3) + SUM(IF(F_RESULT='D'=1,1,0)))/SUM(IF(F_RESULT<>'0'=1,1,0)),3)  AS F_PPG
						FROM wsl_fixtures  GROUP BY F_ORDER, F_KEY, F_OPP
						ORDER BY F_ORDER ASC, F_KEY ASC, Team ASC";


				return $sql;
			}

			/**
			 * base FA Womens super league one - all time
			 * @return string
			 */
			function _0V_base_WSL1() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL1 AS
						select A.F_HOME AS Team, ('H') LOC,  count(A.F_HOME) AS PLD,
						sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,
						sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,
						sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,
						sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((A.F_AGOALS > 0 AND A.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(A.F_HGOALS) AS F, sum(A.F_AGOALS) AS A, sum((A.F_HGOALS - A.F_AGOALS)) AS GD,
						round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,
						sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one A group by A.F_HOME
						union all
						select B.F_AWAY AS Team, ('A') LOC, count(B.F_AWAY) AS PLD,
						sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,
						sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,
						sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,
						sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((B.F_AGOALS > 0 AND B.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(B.F_AGOALS) AS F, sum(B.F_HGOALS) AS A, sum((B.F_AGOALS - B.F_HGOALS)) AS GD,
						round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
						sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one B group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base FA Womens super league one - thi season
			 * @return string
			 */
			function _0V_base_WSL1_this() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL1_this AS
						select A.F_HOME AS Team, ('H') LOC,  count(A.F_HOME) AS PLD,
						sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,
						sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,
						sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,
						sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((A.F_AGOALS > 0 AND A.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(A.F_HGOALS) AS F, sum(A.F_AGOALS) AS A, sum((A.F_HGOALS - A.F_AGOALS)) AS GD,
						round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,
						sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one A where A.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL') group by A.F_HOME
						union all
						select B.F_AWAY AS Team, ('A') LOC, count(B.F_AWAY) AS PLD,
						sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,
						sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,
						sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,
						sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((B.F_AGOALS > 0 AND B.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(B.F_AGOALS) AS F, sum(B.F_HGOALS) AS A, sum((B.F_AGOALS - B.F_HGOALS)) AS GD,
						round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
						sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one B where B.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL') group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base FA Womens super league two - all time
			 * @return string
			 */
			function _0V_base_WSL2() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL2 AS
						select A.F_HOME AS Team, ('H') LOC,  count(A.F_HOME) AS PLD,
						sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,
						sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,
						sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,
						sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((A.F_AGOALS > 0 AND A.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(A.F_HGOALS) AS F, sum(A.F_AGOALS) AS A, sum((A.F_HGOALS - A.F_AGOALS)) AS GD,
						round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,
						sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_two A group by A.F_HOME
						union all
						select B.F_AWAY AS Team, ('A') LOC, count(B.F_AWAY) AS PLD,
						sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,
						sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,
						sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,
						sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((B.F_AGOALS > 0 AND B.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(B.F_AGOALS) AS F, sum(B.F_HGOALS) AS A, sum((B.F_AGOALS - B.F_HGOALS)) AS GD,
						round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
						sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_two B group by B.F_AWAY";

				return $sql;
			}

			/**
			 * base FA Womens super league two - all time
			 * @return string
			 */
			function _0V_base_WSL2_this() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL2_this AS
						select A.F_HOME AS Team, ('H') LOC,  count(A.F_HOME) AS PLD,
						sum((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1)) AS W,
						sum((if((A.F_HGOALS = A.F_AGOALS),1,0) = 1)) AS D,
						sum((if((A.F_HGOALS < A.F_AGOALS),1,0) = 1)) AS L,
						sum((if((A.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((A.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((A.F_AGOALS > 0 AND A.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(A.F_HGOALS) AS F, sum(A.F_AGOALS) AS A, sum((A.F_HGOALS - A.F_AGOALS)) AS GD,
						round((sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) / count(A.F_HOME)),3) AS PPG,
						sum((((if((A.F_HGOALS > A.F_AGOALS),1,0) = 1) * 3) + (if((A.F_HGOALS = A.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_two A where A.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL') group by A.F_HOME
						union all
						select B.F_AWAY AS Team, ('A') LOC, count(B.F_AWAY) AS PLD,
						sum((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1)) AS W,
						sum((if((B.F_AGOALS = B.F_HGOALS),1,0) = 1)) AS D,
						sum((if((B.F_AGOALS < B.F_HGOALS),1,0) = 1)) AS L,
						sum((if((B.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((B.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((B.F_AGOALS > 0 AND B.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(B.F_AGOALS) AS F, sum(B.F_HGOALS) AS A, sum((B.F_AGOALS - B.F_HGOALS)) AS GD,
						round((sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) / count(B.F_HOME)),3) AS PPG,
						sum((((if((B.F_AGOALS > B.F_HGOALS),1,0) = 1) * 3) + (if((B.F_AGOALS = B.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_two B where B.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL') group by B.F_AWAY";

				return $sql;
			}

			/**
			 * compare results from this season with like for like to last season
			 * @return string
			 */
			function _0V_base_WSL_ISG() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_ISG as
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results_wsl_one a, all_results_wsl_one b, meta_wsl_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND a.F_HOME = b.F_HOME AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results_wsl_one a, all_results_wsl_one b, meta_wsl_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND a.F_HOME = b.F_HOME AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results_wsl_one a, all_results_wsl_one b, meta_wsl_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND a.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='WSL_PROMOTED1')
						AND b.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='WSL_RELEGATED1')
						AND a.F_HOME = b.F_HOME
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results_wsl_one a, all_results_wsl_one b, meta_wsl_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND a.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='WSL_PROMOTED1')
						AND b.F_AWAY = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='WSL_RELEGATED1')
						AND a.F_HOME = b.F_HOME
						UNION ALL
						SELECT z.F_LABEL, a.F_HOME, a.F_AWAY, a.F_HGOALS, a.F_AGOALS
						FROM all_results_wsl_one a, all_results_wsl_one b, meta_wsl_seasons z
						WHERE a.F_DATE > z.F_SDATE AND a.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND a.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='WSL_PROMOTED1')
						AND b.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='WSL_RELEGATED1')
						AND a.F_AWAY = b.F_AWAY
						UNION ALL
						SELECT z.F_LABEL, b.F_HOME, b.F_AWAY, b.F_HGOALS, b.F_AGOALS
						FROM all_results_wsl_one a, all_results_wsl_one b, meta_wsl_seasons z
						WHERE b.F_DATE > z.F_SDATE AND b.F_DATE < z.F_EDATE
						AND a.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND b.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSLm1')
						AND b.F_DATE < (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL')
						AND a.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='WSL_PROMOTED1')
						AND b.F_HOME = (SELECT F_VALUE FROM 000_configs WHERE F_FIELD='WSL_RELEGATED1')
						AND a.F_AWAY = b.F_AWAY";

				return $sql;
			}

			/**
			 * display league table from ISG results requires two year identifiers
			 * @param $thisYear
			 * @param $lastYear
			 * @return string
			 */
			function _0V_base_WSL_ISG_table($thisYear,$lastYear) {

				$thisYear = isset($thisYear) ? $thisYear : "2016";
				$lastYear = isset($lastYear) ? $lastYear : "2015";


				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_ISG_table AS
						select a.F_HOME AS Team, ('H') LOC,  a.F_LABEL, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from 0V_base_WSL_ISG a where a.F_LABEL='$thisYear' group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  b.F_LABEL, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from 0V_base_WSL_ISG b where b.F_LABEL='$thisYear' group by b.F_AWAY
						union all
						select a.F_HOME AS Team, ('H') LOC, a.F_LABEL, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from 0V_base_WSL_ISG a where a.F_LABEL='$lastYear' group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, b.F_LABEL, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from 0V_base_WSL_ISG b where b.F_LABEL='$lastYear' group by b.F_AWAY";

				return $sql;
			}

			/**
			 * create base table for ISG values
			 * @return string
			 */
			function _0V_base_WSL_ISG_totals() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_ISG_totals as
						SELECT F_LABEL as Label, Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS,
						SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
						FROM 0V_base_WSL_ISG_table GROUP BY Label, Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";

				return $sql;
			}

			/**
			 * Base table for WSL Per90 stats used
			 * @return string
			 */
			function _0V_base_WSL_Per90s() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_Per90s as
						SELECT a.F_NO, a.F_NAME, sum(a.F_GOALS) AS F_GOALS,(sum(a.F_GOALS) / (sum(a.X_MINUTES) / 90)) AS GP90
						from wsl_fixtures_players a, wsl_players b,  meta_wsl_squadno c, wsl_fixtures d
						where a.F_NAME =  b.F_NAME and  c.F_SQUADNO = a.F_NO and c.F_END is null
						and  a.F_DATE >= (select 000_config.F_DATE from 000_config where F_LEAGUE = 'WSL')
						and a.F_GAMEID = d.F_ID group by a.F_NO,a.F_NAME having sum(a.X_MINUTES) > 0 order by GP90 desc";

				return $sql;
			}

			/**
			 * @return string
			 */
			function _0V_base_last38() {
				// $purpose = "base Last 38 league";

				$sql = "CREATE OR REPLACE VIEW 0V_base_last38 AS
			select t.M_OPP AS Team, t.PLD AS PLD, t.W AS W, t.D AS D, t.L AS L, t.FS AS FS, t.CS AS CS, t.BTTS AS BTTS, t.F AS F, t.A AS A, t.GD AS GD, t.PPG AS PPG, t.PTS AS PTS
			from 0t_last38 t";

				$sql .= "BEGIN
      	TRUNCATE TABLE 0t_last38;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BOURNEMOUTH a WHERE F_HOME='BOURNEMOUTH' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BOURNEMOUTH b WHERE F_AWAY='BOURNEMOUTH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SWANSEA a WHERE F_HOME='SWANSEA' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SWANSEA b WHERE F_AWAY='SWANSEA' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BLACKPOOL a WHERE F_HOME='BLACKPOOL' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BLACKPOOL b WHERE F_AWAY='BLACKPOOL' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BURNLEY a WHERE F_HOME='BURNLEY' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BURNLEY b WHERE F_AWAY='BURNLEY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_STOKE a WHERE F_HOME='STOKE' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_STOKE b WHERE F_AWAY='STOKE' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_HULL a WHERE F_HOME='HULL' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_HULL b WHERE F_AWAY='HULL' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_READING a WHERE F_HOME='READING' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_READING b WHERE F_AWAY='READING' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WIGAN a WHERE F_HOME='WIGAN' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WIGAN b WHERE F_AWAY='WIGAN' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WOLVES a WHERE F_HOME='WOLVES' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WOLVES b WHERE F_AWAY='WOLVES' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_PORTSMOUTH a WHERE F_HOME='PORTSMOUTH' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_PORTSMOUTH b WHERE F_AWAY='PORTSMOUTH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WEST_BROM a WHERE F_HOME='WEST BROM' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WEST_BROM b WHERE F_AWAY='WEST BROM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BIRMINGHAM a WHERE F_HOME='BIRMINGHAM' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BIRMINGHAM b WHERE F_AWAY='BIRMINGHAM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_FULHAM a WHERE F_HOME='FULHAM' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_FULHAM b WHERE F_AWAY='FULHAM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BRADFORD a WHERE F_HOME='BRADFORD' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BRADFORD b WHERE F_AWAY='BRADFORD' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WATFORD a WHERE F_HOME='WATFORD' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WATFORD b WHERE F_AWAY='WATFORD' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_CHARLTON a WHERE F_HOME='CHARLTON' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_CHARLTON b WHERE F_AWAY='CHARLTON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BARNSLEY a WHERE F_HOME='BARNSLEY' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BARNSLEY b WHERE F_AWAY='BARNSLEY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SUNDERLAND a WHERE F_HOME='SUNDERLAND' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SUNDERLAND b WHERE F_AWAY='SUNDERLAND' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_DERBY a WHERE F_HOME='DERBY' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_DERBY b WHERE F_AWAY='DERBY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_MIDDLESBROUGH a WHERE F_HOME='MIDDLESBROUGH' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_MIDDLESBROUGH b WHERE F_AWAY='MIDDLESBROUGH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BOLTON a WHERE F_HOME='BOLTON' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BOLTON b WHERE F_AWAY='BOLTON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_N_FOREST a WHERE F_HOME='N FOREST' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_N_FOREST b WHERE F_AWAY='N FOREST' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_LEICESTER a WHERE F_HOME='LEICESTER' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_LEICESTER b WHERE F_AWAY='LEICESTER' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_C_PALACE a WHERE F_HOME='C PALACE' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_C_PALACE b WHERE F_AWAY='C PALACE' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SWINDON a WHERE F_HOME='SWINDON' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SWINDON b WHERE F_AWAY='SWINDON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SHEFF_WED a WHERE F_HOME='SHEFF WED' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SHEFF_WED b WHERE F_AWAY='SHEFF WED' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_QPR a WHERE F_HOME='QPR' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_QPR b WHERE F_AWAY='QPR' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_MAN_UTD a WHERE F_HOME='MAN UTD' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_MAN_UTD b WHERE F_AWAY='MAN UTD' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_COVENTRY a WHERE F_HOME='COVENTRY' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_COVENTRY b WHERE F_AWAY='COVENTRY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BLACKBURN a WHERE F_HOME='BLACKBURN' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_BLACKBURN b WHERE F_AWAY='BLACKBURN' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WIMBLEDON a WHERE F_HOME='WIMBLEDON' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WIMBLEDON b WHERE F_AWAY='WIMBLEDON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_LEEDS a WHERE F_HOME='LEEDS' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_LEEDS b WHERE F_AWAY='LEEDS' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_IPSWICH a WHERE F_HOME='IPSWICH' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_IPSWICH b WHERE F_AWAY='IPSWICH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_EVERTON a WHERE F_HOME='EVERTON' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_EVERTON b WHERE F_AWAY='EVERTON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SPURS a WHERE F_HOME='SPURS' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SPURS b WHERE F_AWAY='SPURS' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_NORWICH a WHERE F_HOME='NORWICH' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_NORWICH b WHERE F_AWAY='NORWICH' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WEST_HAM a WHERE F_HOME='WEST HAM' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_WEST_HAM b WHERE F_AWAY='WEST HAM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SOUTHAMPTON a WHERE F_HOME='SOUTHAMPTON' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SOUTHAMPTON b WHERE F_AWAY='SOUTHAMPTON' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SHEFF_UTD a WHERE F_HOME='SHEFF UTD' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_SHEFF_UTD b WHERE F_AWAY='SHEFF UTD' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_OLDHAM a WHERE F_HOME='OLDHAM' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_OLDHAM b WHERE F_AWAY='OLDHAM' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_NEWCASTLE a WHERE F_HOME='NEWCASTLE' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_NEWCASTLE b WHERE F_AWAY='NEWCASTLE' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_MAN_CITY a WHERE F_HOME='MAN CITY' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_MAN_CITY b WHERE F_AWAY='MAN CITY' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_LIVERPOOL a WHERE F_HOME='LIVERPOOL' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_LIVERPOOL b WHERE F_AWAY='LIVERPOOL' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_CHELSEA a WHERE F_HOME='CHELSEA' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_CHELSEA b WHERE F_AWAY='CHELSEA' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_ASTON_VILLA a WHERE F_HOME='ASTON VILLA' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_ASTON_VILLA b WHERE F_AWAY='ASTON VILLA' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC;
		INSERT INTO 0t_last38 SELECT M_OPP, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM ( SELECT `F_HOME` M_OPP, COUNT(F_HOME) AS PLD, SUM(IF(`F_HGOALS`>`F_AGOALS`,1,0)=1) W, SUM(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1) D, SUM(IF(`F_HGOALS`<`F_AGOALS`,1,0)=1) L, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS-F_AGOALS) GD, SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_HGOALS`>`F_AGOALS`,1,0)=1)*3+(IF(`F_HGOALS`=`F_AGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_ARSENAL a WHERE F_HOME='ARSENAL' GROUP BY M_OPP UNION ALL SELECT `F_AWAY` M_OPP, COUNT(F_AWAY) AS PLD, SUM(IF(`F_AGOALS`>`F_HGOALS`,1,0)=1) W, SUM(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1) D, SUM(IF(`F_AGOALS`<`F_HGOALS`,1,0)=1) L, SUM(IF(F_AGOALS=0,1,0)=1) CS, SUM(IF(F_HGOALS=0,1,0)=1) FS, SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS-F_HGOALS) GD, SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1)) PTS, ROUND(SUM((IF(`F_AGOALS`>`F_HGOALS`,1,0)=1)*3+(IF(`F_AGOALS`=`F_HGOALS`,1,0)=1))/COUNT(F_HOME),3) PPG FROM 38_ARSENAL b WHERE F_AWAY='ARSENAL' GROUP BY M_OPP ) a GROUP BY M_OPP ORDER BY PPG DESC, PTS DESC, GD DESC, M_OPP DESC";


				return $sql;
			}

			/**
			 * base Last 38 league -  active PL teams
			 * @return string
			 */
			function _0V_base_last38_this() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_last38_this AS
						SELECT t.M_OPP AS Team, t.PLD AS PLD, t.W AS W, t.D AS D, t.L AS L, t.FS AS FS, t.CS AS CS,
						t.BTTS AS BTTS, t.F AS F, t.A AS A, t.GD AS GD, t.PPG AS PPG, t.PTS AS PTS
						FROM 0t_last38 t WHERE t.M_OPP IN ( SELECT DISTINCT team FROM 0V_base_current_pl_teams)";

				return $sql;
			}

			/**
			 * base view opposition managers
			 * @return string
			 */
			function _0V_base_oppoMgr() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_oppoMgr  AS
						select  SUBSTRING(Fullname,1,1) AS N_KEY, Fullname, Sname AS F_NAME2, Fname AS F_NAME,
						PLD, W, D, L, round(sum(((W / PLD) * 100)),2) AS F_WINPER, round(sum(((D / PLD) * 100)),2) AS F_DRAWPER,
						round(sum(((L / PLD) * 100)),2) AS F_LOSSPER, sum( W + W + W + D) AS PTS, round((( W + W + W + D ) / PLD),3) AS PPG,
						First, Last from cfc_oppomgr group by FullName order by round((( W + W + W  + D) / PLD ),3) desc";

				return $sql;
			}

			/**
			 * basic league table selection
			 * @param $table_name
			 * @return string
			 */
			function _selection( $table_name ) {

				$selector = "SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS,
              SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
              FROM $table_name GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";

				return $selector;
			}

			/**
			 * basic league table selection with years
			 * @param $table_name
			 * @return string
			 */
			function _selection_year( $table_name ) {

				$selector = "SELECT year, Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS,
            				SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
            				FROM $table_name GROUP BY year, Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";

				return $selector;
			}

			/**
			 * Base Results table with totals
			 * @return string
			 */
			function _0V_base_RES() {
				
				$sql ="CREATE OR REPLACE VIEW `0V_base_RES` AS 
						select `F_LOCATION` AS `F_LOC`,'GT' AS `F_KEY`,'ALL' AS `Team`,
						sum(if(((`F_RESULT` <> '0') = 1),1,0)) AS `F_PLD`,
						sum(if(((`F_RESULT` = 'W') = 1),1,0)) AS `F_WINS`,
						sum(if(((`F_RESULT` = 'D') = 1),1,0)) AS `F_DRAWS`,
						sum(if(((`F_RESULT` = 'L') = 1),1,0)) AS `F_LOSSES`,
						round(((sum(if(((`F_RESULT` = 'W') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2) AS `F_WINPER`,
						round(((sum(if(((`F_RESULT` = 'D') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2) AS `F_DRAWPER`,
						round(((sum(if(((`F_RESULT` = 'L') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2) AS `F_LOSSPER`,
						(round(((sum(if(((`F_RESULT` = 'W') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2)
						+ round(((sum(if(((`F_RESULT` = 'D') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2)) AS `F_UNDER`,
						sum(if(((`F_AGAINST` = '0') = 1),1,0)) AS `F_CLEAN`,
						sum(if(((`F_FOR` = '0') = 1),1,0)) AS `F_FAILED`,
						sum(`F_FOR`) AS `F_FOR`,
						sum(`F_AGAINST`) AS `F_AGAINST`,
						(sum(`F_FOR`) - sum(`F_AGAINST`)) AS `F_GD`,
						round((sum(`F_FOR`) / sum(if(((`F_RESULT` <> '0') = 1),1,0))),3) AS `F_GFPG`,
						round((sum(`F_AGAINST`) / sum(if(((`F_RESULT` <> '0') = 1),1,0))),3) AS `F_GAPG`,
						((sum(if(((`F_RESULT` = 'W') = 1),1,0)) * 3) + sum(if(((`F_RESULT` = 'D') = 1),1,0))) AS `F_POINTS`,
						round((((sum(if(((`F_RESULT` = 'W') = 1),1,0)) * 3) + sum(if(((`F_RESULT` = 'D') = 1),1,0)))
						/ sum(if(((`F_RESULT` <> '0') = 1),1,0))),3) AS `F_PPG`
						from `cfc_fixtures` group by `F_LOCATION` 
						union all 
						select 'Total' AS `F_LOC`,'GT' AS `F_KEY`,'ALL' AS `Team`,
						sum(if(((`F_RESULT` <> '0') = 1),1,0)) AS `F_PLD`,
						sum(if(((`F_RESULT` = 'W') = 1),1,0)) AS `F_WINS`,
						sum(if(((`F_RESULT` = 'D') = 1),1,0)) AS `F_DRAWS`,
						sum(if(((`F_RESULT` = 'L') = 1),1,0)) AS `F_LOSSES`,
						round(((sum(if(((`F_RESULT` = 'W') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2) AS `F_WINPER`,
						round(((sum(if(((`F_RESULT` = 'D') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2) AS `F_DRAWPER`,
						round(((sum(if(((`F_RESULT` = 'L') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2) AS `F_LOSSPER`,
						(round(((sum(if(((`F_RESULT` = 'W') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2)
						+ round(((sum(if(((`F_RESULT` = 'D') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2)) AS `F_UNDER`,
						sum(if(((`F_AGAINST` = '0') = 1),1,0)) AS `F_CLEAN`,
						sum(if(((`F_FOR` = '0') = 1),1,0)) AS `F_FAILED`,
						sum(`F_FOR`) AS `F_FOR`,
						sum(`F_AGAINST`) AS `F_AGAINST`,
						(sum(`F_FOR`) - sum(`F_AGAINST`)) AS `F_GD`,
						round((sum(`F_FOR`) / sum(if(((`F_RESULT` <> '0') = 1),1,0))),3) AS `F_GFPG`,
						round((sum(`F_AGAINST`) / sum(if(((`F_RESULT` <> '0') = 1),1,0))),3) AS `F_GAPG`,
						((sum(if(((`F_RESULT` = 'W') = 1),1,0)) * 3) + sum(if(((`F_RESULT` = 'D') = 1),1,0))) AS `F_POINTS`,
						round((((sum(if(((`F_RESULT` = 'W') = 1),1,0)) * 3) + sum(if(((`F_RESULT` = 'D') = 1),1,0)))
						/ sum(if(((`F_RESULT` <> '0') = 1),1,0))),3) AS `F_PPG`
						from `cfc_fixtures` 
						union all 
						select `F_LOCATION` AS `F_LOC`,substr(`F_OPP`,1,1) AS `F_KEY`,`F_OPP` AS `Team`,
						sum(if(((`F_RESULT` <> '0') = 1),1,0)) AS `F_PLD`,
						sum(if(((`F_RESULT` = 'W') = 1),1,0)) AS `F_WINS`,sum(if(((`F_RESULT` = 'D') = 1),1,0)) AS `F_DRAWS`,
						sum(if(((`F_RESULT` = 'L') = 1),1,0)) AS `F_LOSSES`,
						round(((sum(if(((`F_RESULT` = 'W') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2) AS `F_WINPER`,
						round(((sum(if(((`F_RESULT` = 'D') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2) AS `F_DRAWPER`,
						round(((sum(if(((`F_RESULT` = 'L') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2) AS `F_LOSSPER`,
						(round(((sum(if(((`F_RESULT` = 'W') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2)
						+ round(((sum(if(((`F_RESULT` = 'D') = 1),1,0)) / sum(if(((`F_RESULT` <> '0') = 1),1,0))) * 100),2)) AS `F_UNDER`,
						sum(if(((`F_AGAINST` = '0') = 1),1,0)) AS `F_CLEAN`,sum(if(((`F_FOR` = '0') = 1),1,0)) AS `F_FAILED`,sum(`F_FOR`) AS `F_FOR`,sum(`F_AGAINST`) AS `F_AGAINST`,
						(sum(`F_FOR`) - sum(`F_AGAINST`)) AS `F_GD`,
						round((sum(`F_FOR`) / sum(if(((`F_RESULT` <> '0') = 1),1,0))),3) AS `F_GFPG`,round((sum(`F_AGAINST`) / sum(if(((`F_RESULT` <> '0') = 1),1,0))),3) AS `F_GAPG`,
						(sum((if(((`F_RESULT` = 'W') = 1),1,0) * 3)) + sum(if(((`F_RESULT` = 'D') = 1),1,0))) AS `F_POINTS`,
						round((((sum(if(((`F_RESULT` = 'W') = 1),1,0)) * 3) + sum(if(((`F_RESULT` = 'D') = 1),1,0)))
						/ sum(if(((`F_RESULT` <> '0') = 1),1,0))),3) AS `F_PPG`
						from `cfc_fixtures` group by `F_LOCATION`,substr(`F_OPP`,1,1),`F_OPP` order by `F_LOC`,`F_KEY`,`Team`";
				
				return $sql;
			}

			/**
			 * Base table for Goal Diff counts by PL season
			 * @return string
			 */
			function _0V_base_goaldiffpl() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_goaldiffpl AS
						SELECT m.f_label AS lbl, (f.f_for - f.f_against) AS F, COUNT( * ) AS A
						FROM meta_seasons m, cfc_fixtures f WHERE m.f_sdate < f.f_date
						AND m.f_edate >= f.f_date AND f.f_competition =  'PREM'
						GROUP BY m.f_label, (f.f_for - f.f_against) ASC";

				return $sql;
			}

			/**
			 * Base Table for Progress Chelsea League
			 * @return string
			 */
			function _0V_base_progress_cfc() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_progress_cfc AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL')
						and a.F_AWAY in (Select F_AWAY from all_results WHERE F_HOME ='CHELSEA' and F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL') )
						group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL')
						and b.F_HOME in (Select F_HOME from all_results WHERE F_AWAY ='CHELSEA' and F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL'))
						group by b.F_AWAY";


				return $sql;
			}

			/**
			 * Base Table for fancy stats report
			 * @return string
			 */
			function _0V_base_PDO_this() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_pdo_this AS
				SELECT a.Team, sum(a.F) as h_goals, sum(a.A) as a_goals, sum(b.F) as h_shots, sum(b.A) as a_shots,
				round(sum(a.F)/sum(b.F),6) as h_sh,
				round((sum(b.A)-sum(a.A))/sum(b.A),6) as h_sv,
			    round(100 * (((sum(a.F)/sum(b.F)) + ((sum(b.A)-sum(a.A))/sum(b.A)))),3) as h_PDO
				from 0V_base_PL_this a, 0V_base_Shots_this b
				where a.Team = b.Team and a.LOC = b.LOC
				group by a.Team";

				return $sql;

			}

			/**
			 * Base Table for Country report
			 * @return string
			 */
			function _0V_base_country() {
				$sql = "CREATE OR REPLACE VIEW 0V_base_country AS 
				select F_COUNTRY AS N_COUNTRY,count(0) AS PLD,
				sum(if(((F_RESULT = 'W') = 1),1,0)) AS W,
				sum(if(((F_RESULT = 'D') = 1),1,0)) AS D,
				sum(if(((F_RESULT = 'L') = 1),1,0)) AS L,
				sum(if(((F_AGAINST = '0') = 1),1,0)) AS CS,
				sum(if(((F_FOR = '0') = 1),1,0)) AS FS,
				sum(F_FOR) AS F,
				sum(F_AGAINST) AS A,
				sum((F_FOR - F_AGAINST)) AS GD,
				sum(((if(((F_RESULT = 'W') = 1),1,0) * 3) + if(((F_RESULT = 'D') = 1),1,0))) AS PTS 
				from cfc_fixtures where (F_COUNTRY <> 'ENGLAND') 
				group by F_COUNTRY 
				order by F_COUNTRY desc";

				return $sql;
			}

			/**
			 * base view for the premier league - this season - team concedes first
			 * @return string
			 */
			function _0V_base_WSL_this_1C() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_this_1C AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and a.F_1G = 'A' group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and b.F_1G = 'H' group by b.F_AWAY";

				return $sql;
			}

			/**
			 * base view for the premier league - this season - team scores first
			 * @return string
			 */
			function _0V_base_WSL_this_1S() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_this_1S AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A,  sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and a.F_1G ='H' group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC, count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and b.F_1G ='A' group by b.F_AWAY";

				return $sql;
			}

			/**
			 * base table for the premier league - this season - team is drawing at half-time
			 * @return string
			 */
			function _0V_base_WSL_this_D_HT() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_this_D_HT AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and a.HT_HGOALS = a.HT_AGOALS group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and b.HT_HGOALS = b.HT_AGOALS group by b.F_AWAY";

				return $sql;
			}

			/**
			 * base table for the premier league - this season - team is losing at half-time
			 * @return string
			 */
			function _0V_base_WSL_this_L_HT() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_this_L_HT AS
						select a.F_HOME AS Team, ('H') LOC,  count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and a.HT_HGOALS < a.HT_AGOALS group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and b.HT_HGOALS > b.HT_AGOALS group by b.F_AWAY";

				return $sql;
			}

			/**
			 * base view for the premier league - this season - team is winning or drawing at half-time
			 * @return string
			 */
			function _0V_base_WSL_this_WD_HT() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_this_WD_HT AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F,  sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and a.HT_HGOALS >= a.HT_AGOALS group by a.F_HOME
						union all
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and b.HT_HGOALS <= b.HT_AGOALS group by b.F_AWAY";


				return $sql;
			}

			/**
			 * base view for the premier league - this season - team is winning at half-time
			 * @return string
			 */
			function _0V_base_WSL_this_W_HT() {

				$sql = "CREATE OR REPLACE VIEW 0V_base_WSL_this_W_HT AS
						select a.F_HOME AS Team, ('H') LOC, count(a.F_HOME) AS PLD,
						sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
						sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
						sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
						sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
						sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
						round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) / count(a.F_HOME)),3) AS PPG,
						sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one a where a.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and a.HT_HGOALS > a.HT_AGOALS group by a.F_HOME
						union all 
						select b.F_AWAY AS Team, ('A') LOC,  count(b.F_AWAY) AS PLD,
						sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
						sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
						sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
						sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
						sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
						sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
						round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) / count(b.F_HOME)),3) AS PPG,
						sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
						from all_results_wsl_one b where b.F_DATE > (select F_DATE from 000_config where F_LEAGUE='WSL') and b.HT_HGOALS < b.HT_AGOALS group by b.F_AWAY";

				return $sql;
			}

		}

	$schema = new schema();