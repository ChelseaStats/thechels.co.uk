<?php /* Template Name:  # Z Private audit */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?> Audit</h4>

			<h3>Last 10 Events with zero minute</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_GAMEID AS F_ID, CONCAT(F_GAMEID,',',F_DATE) as MX_DATE, f_minute AS F_MINS, F_EVENT, F_NAME
						FROM cfc_fixture_events WHERE f_minute = 0 ORDER BY F_DATE DESC
						LIMIT 10";
				outputDataTable( $sql, 'DATES');
				//================================================================================
			?>
			<h3>Last 10 sub-ons without f_sub</h3>
			<?php
				//================================================================================
				$sql = "SELECT a.f_date, a.f_name, a.f_gameid, a.f_apps, a.f_subs, a.f_unused, a.x_minutes as mins, b.f_event, b.f_minute, b.f_name
						FROM  cfc_fixtures_players a
						INNER JOIN  cfc_fixture_events b ON a.f_name = b.f_name
						WHERE b.f_event =  'SUBON'
						AND a.f_subs =  '0'
						AND a.f_gameid = b.f_gameid
						ORDER BY a.f_date DESC
						LIMIT 0 , 10";
				outputDataTable( $sql, 'DATES');
				//================================================================================
			?>
			<h3>Last 10 DOBS</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_DOB as N_DATE, F_NAME FROM `cfc_dobs`  ORDER BY F_ID DESC LIMIT 10";
				outputDataTable( $sql, 'DATES');
				//================================================================================
			?>

			<h3>Matches with more than 11 players with 90 minutes</h3>

			<?php
				//================================================================================
				$sql = "SELECT F_DATE, F_GAMEID, count(*) as Players 
						FROM `cfc_fixtures_players` WHERE `X_MINUTES` = 90 
						group by `F_DATE`, F_GAMEID having Players > 11 
						order by f_date desc";
				outputDataTable( $sql, 'DATES');
				//================================================================================
			?>

			<h3>Duplicate Players/Dates in fixtures</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_DATE as N_DATE, F_NAME, COUNT(*) FROM cfc_fixtures_players GROUP BY F_DATE, F_NAME
	HAVING COUNT(*) >1";
				outputDataTable( $sql, 'dups');
				//================================================================================
			?>
			<h3>Last 10 players with duplicate dobs</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_DOB as N_DATE, F_NAME, COUNT(*) FROM cfc_dobs GROUP BY F_DOB, F_NAME
	HAVING COUNT(*) > 1 ORDER BY COUNT(*) DESC limit 10";
				outputDataTable( $sql, 'no events');
				//================================================================================
			?>
			<h3>Last 10 players with duplicate key events</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_DATE as N_DATE, F_NAME, COUNT(*) FROM cfc_dates GROUP BY F_DATE, F_NAME
		HAVING COUNT(*) > 1 ORDER BY COUNT(*) DESC limit 10";
				outputDataTable( $sql, 'no events');
				//================================================================================
			?>
			<h3>Last 10 matches missing game stats (all comps)</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_ID, CONCAT(F_ID,',',F_DATE) as MX_DATE, F_OPP as Team, F_COMPETITION
		FROM cfc_fixtures WHERE F_H_CORNERS IS NULL OR F_A_CORNERS IS NULL OR F_H_FOULS IS NULL OR F_A_FOULS IS NULL OR F_H_ATTEMPTSOFF IS NULL OR F_A_ATTEMPTSOFF IS NULL OR F_H_ATTEMPTSON IS NULL OR F_A_ATTEMPTSON IS NULL
		ORDER BY F_DATE DESC LIMIT 10";
				outputDataTable( $sql, 'Blanks');
				//================================================================================
			?>
			<h3>Last 10 league matches missing game stats</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_ID, CONCAT(F_ID,',',F_DATE) as MX_DATE, F_OPP as Team, F_COMPETITION
		FROM cfc_fixtures WHERE F_COMPETITION='PREM' AND (F_H_CORNERS IS NULL OR F_A_CORNERS IS NULL OR F_H_FOULS IS NULL OR F_A_FOULS IS NULL OR F_H_ATTEMPTSOFF IS NULL OR F_A_ATTEMPTSOFF IS NULL OR F_H_ATTEMPTSON IS NULL OR F_A_ATTEMPTSON IS NULL)
		ORDER BY F_DATE DESC LIMIT 10";
				outputDataTable( $sql, 'Blanks');
				//================================================================================
			?>
			<h3>Since year 1992 matches missing game stats by Competition</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_COMPETITION, count(*) as PLD
		FROM cfc_fixtures WHERE F_DATE > '1992-08-01' AND (F_H_CORNERS IS NULL OR F_A_CORNERS IS NULL OR F_H_FOULS IS NULL OR F_A_FOULS IS NULL OR F_H_ATTEMPTSOFF IS NULL OR F_A_ATTEMPTSOFF IS NULL OR F_H_ATTEMPTSON IS NULL OR F_A_ATTEMPTSON IS NULL )
		GROUP BY F_COMPETITION";
				outputDataTable( $sql, 'Blanks');
				//================================================================================
			?>
			<h3>How many times total players recorded per game</h3>
			<?php
				//================================================================================
				$sql = "SELECT LOC, count(*) as PLD FROM (
        	SELECT count(*) as LOC FROM cfc_fixtures_players GROUP BY F_DATE) a 
        	GROUP BY LOC ORDER BY LOC ASC";
				outputDataTable( $sql, 'no events');
				//================================================================================
			?>
			<h3>Last 10 matches with no match players</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_ID, F_OPP as F_TEAM, CONCAT(F_ID,',',F_DATE) as MX_DATE, F_LOCATION, F_COMPETITION,
        	F_RESULT, F_FOR, F_AGAINST FROM cfc_fixtures
		WHERE F_DATE NOT IN (select distinct(F_DATE) from cfc_fixtures_players)
		ORDER BY F_DATE DESC limit 10";
				outputDataTable( $sql, 'no events');
				//================================================================================
			?>
			<h3>Last 10 League matches with no events</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_ID, F_OPP as F_TEAM, CONCAT(F_ID,',',F_DATE) as MX_DATE, F_LOCATION, F_COMPETITION, F_RESULT, F_FOR, F_AGAINST
        	FROM cfc_fixtures
		WHERE F_DATE NOT IN (select F_DATE from cfc_fixture_events)
		AND F_COMPETITION = 'PREM'
		ORDER BY F_DATE DESC limit 10";
				outputDataTable( $sql, 'no events');
				//================================================================================
			?>
			<h3>Last 5 matches with unequal goal events</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_ID, MX_DATE, F_EVENTS AS F_FOR, F_GOALS AS F_AGAINST
        FROM (SELECT F_ID, CONCAT(F_ID,',',F_DATE) as MX_DATE, (Select COUNT(*)
		FROM cfc_fixture_events b WHERE F_EVENT LIKE '%GOAL%' AND b.F_GAMEID=x.F_ID GROUP BY F_GAMEID, F_DATE)
		AS F_EVENTS, (SELECT SUM(F_FOR+F_AGAINST)
		FROM cfc_fixtures a WHERE a.F_ID=x.F_ID  GROUP BY F_ID, F_DATE ) AS F_GOALS FROM cfc_fixtures x
		WHERE F_FOR+F_AGAINST > 0
		AND F_DATE > '2002-01-01'
	    GROUP BY F_ID, F_DATE
		ORDER BY F_DATE ASC) Y
		WHERE F_EVENTS <> F_GOALS
		ORDER BY MX_DATE ASC LIMIT 5";
				outputDataTable( $sql, 'BAD events');
				//================================================================================
			?>
			<h3>Last 10 matches with no referee</h3>
			<?php
				//================================================================================
				$sql = "SELECT F_ID, F_OPP as F_TEAM, CONCAT(F_ID,',',F_DATE) as MX_DATE, F_LOCATION, F_COMPETITION, F_RESULT, F_FOR, F_AGAINST
		FROM cfc_fixtures WHERE (F_REF = 'UNKNOWN' OR F_REF IS NULL)
		ORDER BY F_DATE DESC limit 10";
				outputDataTable( $sql, 'no events');
				//================================================================================
			?>
			<h3>Total Goals For by Result this season</h3>
			<?php
				//================================================================================
				$sql="SELECT F, SUM(W) AS W, SUM(D) AS D, SUM(L) AS L, SUM(PLD) AS PLD
		        	FROM (
			        	SELECT F_HGOALS as F,
			                sum(if((F_HGOALS > F_AGOALS),1,0) = 1) AS W,
			                sum(if((F_HGOALS = F_AGOALS),1,0) = 1) AS D,
			                sum(if((F_HGOALS < F_AGOALS),1,0) = 1) AS L,
			                count(*) as PLD
					FROM all_results WHERE F_DATE > 
						(select F_DATE from 000_config where F_LEAGUE='PL')
					GROUP BY F_HGOALS
					UNION ALL
					SELECT F_AGOALS as F,
			                sum(if((F_HGOALS < F_AGOALS),1,0) = 1) AS W,
					sum(if((F_HGOALS = F_AGOALS),1,0) = 1) AS D,
					sum(if((F_HGOALS > F_AGOALS),1,0) = 1) AS L,
			                count(*) as PLD
					FROM all_results WHERE F_DATE > 
						(select F_DATE from 000_config where F_LEAGUE='PL')
					GROUP BY F_AGOALS
				) b
				GROUP BY F 
				ORDER BY F ASC";
				outputDataTable( $sql, 'OVERALL');

			?>
			<h3>Home Goals For by Result this season</h3>
			<?php
				//================================================================================
				$sql="SELECT F_HGOALS as F,
		                sum(if((F_HGOALS > F_AGOALS),1,0) = 1) AS W,
		                sum(if((F_HGOALS = F_AGOALS),1,0) = 1) AS D,
		                sum(if((F_HGOALS < F_AGOALS),1,0) = 1) AS L,
		                count(*) as PLD
				FROM all_results WHERE F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL')
				GROUP BY F_HGOALS";
				outputDataTable( $sql, 'OVERALL');
				//================================================================================
			?>
			<h3>Away Goals For by Result this season</h3>
			<?php
				$sql="SELECT F_AGOALS as F,
		                sum(if((F_HGOALS < F_AGOALS),1,0) = 1) AS W,
				sum(if((F_HGOALS = F_AGOALS),1,0) = 1) AS D,
				sum(if((F_HGOALS > F_AGOALS),1,0) = 1) AS L,
		                count(*) as PLD
				FROM all_results WHERE F_DATE > (select F_DATE from 000_config where F_LEAGUE='PL')
				GROUP BY F_AGOALS";
				outputDataTable( $sql, 'OVERALL');
				//================================================================================


			?>

			<h3>Chelsea Goals For by Result</h3>
			<?php
				//================================================================================
				$sql="SELECT F_FOR,
		                sum(if((F_RESULT='W'),1,0) = 1) AS W,
		                sum(if((F_RESULT='D'),1,0) = 1) AS D,
		                sum(if((F_RESULT='L'),1,0) = 1) AS L,
		                count(*) as PLD
						FROM cfc_fixtures WHERE F_COMPETITION='PREM'
						GROUP BY F_FOR";
				outputDataTable( $sql, 'OVERALL');
				//================================================================================
			?>
			<h3>Chelsea Goals Against by Result</h3>
			<?php
				//================================================================================
				$sql="SELECT F_AGAINST,
		                sum(if((F_RESULT='W'),1,0) = 1) AS W,
		                sum(if((F_RESULT='D'),1,0) = 1) AS D,
		                sum(if((F_RESULT='L'),1,0) = 1) AS L,
		                count(*) as PLD
						FROM cfc_fixtures WHERE F_COMPETITION='PREM'
						GROUP BY F_AGAINST";
				outputDataTable( $sql, 'OVERALL');
				//================================================================================
			?>
			<h3>League Summary Stats</h3>
			<?php
				//================================================================================
				$sql="SELECT b.F_LABEL as F_YEAR, sum(if((F_HGOALS > F_AGOALS),1,0) = 1) AS W, sum(if((F_HGOALS = F_AGOALS),1,0) = 1) AS D, sum(if((F_HGOALS < F_AGOALS),1,0) = 1) AS L,
        		sum(if((F_HGOALS = 0),1,0) = 1) AS CS, sum(if((F_AGOALS = 0),1,0) = 1) AS FS, sum(F_HGOALS ) AS F, sum(F_AGOALS ) AS A, sum(F_HGOALS-F_AGOALS) AS GD,
        		sum(F_HGOALS+F_AGOALS) AS F_GOALS, count(*) as PLD
			    FROM all_results a, meta_seasons b WHERE a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE GROUP BY b.F_LABEL ORDER BY b.F_LABEL DESC limit 0,50";
				outputDataTable( $sql, 'RESULTS');
				//================================================================================
			?>

			<?php
				//================================================================================
				$sql="SELECT year as F_YEAR, LOC, Team, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS FROM 0V_base_PL_year WHERE team = 'CHELSEA' ";
				outputDataTable( $sql, 'RESULTS');
				//================================================================================
			?>

		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
