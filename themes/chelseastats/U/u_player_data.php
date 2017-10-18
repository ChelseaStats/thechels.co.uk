<?php /* Template Name: # U Player Data */ ?>
<?php

	$name = isset($_GET['plyr']) ? $_GET['plyr'] : null;
	$keep = isset($_GET['kpr']) ? $_GET['kpr'] : null;

		if($name === null && $keep === null ) {

			header('Location:https://thechels.co.uk/analysis/players/');

		} elseif($keep === null) {

			$v_name = $go->_V( $name );
			?>
			<?php get_header(); ?>
			<div id = "content">
			<?php
			print '<h4 class="special">Chelsea Player Data - ' . $v_name . '.</h4>';

			print '<h3>Stats by game this season</h3>';
				//================================================================================
				$sql = "SELECT d.F_DATE, d.F_OPP as F_TEAM, d.F_LOCATION as LOC, d.F_RESULT, a.F_APPS , a.F_SUBS, a.F_UNUSED, a.F_GOALS, a.F_SHOTS, a.F_SHOTSON, a.F_ASSISTS, a.F_FOULSCOM, a.F_FOULSSUF, a.F_YC, a.F_RC, a.X_MINUTES as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
					WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
					AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
					AND a.F_GAMEID = d.F_ID
					AND a.F_NAME='$name'
					ORDER BY d.F_DATE asc";
				outputDataTable( $sql, 'M Squad' );
				//================================================================================

				print '<h3>Results summary this season</h3>';
				//================================================================================
				$sql = "SELECT  d.F_RESULT, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) as F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.X_MINUTES) as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
					WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
					AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
					AND a.F_GAMEID = d.F_ID
					AND a.F_NAME='$name'
					GROUP BY d.F_RESULT
					ORDER BY d.F_RESULT asc";
				outputDataTable( $sql, 'M Squad' );
				//================================================================================

			print '<h3>Stats by location this season</h3>';
			//================================================================================
			$sql = "SELECT d.F_LOCATION as LOC, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_GOALS) as F_GOALS, sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
					WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
					AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
					AND a.F_GAMEID = d.F_ID
					AND a.F_NAME='$name'
					GROUP BY LOC
					union all
					SELECT 'Total' as LOC, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_GOALS) as F_GOALS, sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
					WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
					AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
					AND a.F_GAMEID = d.F_ID
					AND a.F_NAME='$name'
					GROUP BY LOC
					ORDER BY LOC ASC";
			outputDataTable( $sql, 'Player Data by competition' );
			//================================================================================

				print '<h3>Results summary by location this season</h3>';
				//================================================================================
				$sql = "SELECT d.F_RESULT, d.F_LOCATION as LOC,  sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) as F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.X_MINUTES) as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
					WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
					AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
					AND a.F_GAMEID = d.F_ID
					AND a.F_NAME='$name'
					GROUP BY F_RESULT, LOC
					ORDER BY F_RESULT asc, LOC desc";
				outputDataTable( $sql, 'M Squad' );
				//================================================================================

				print '<h3>Stats by competition this season</h3>';
				//================================================================================
				$sql = "SELECT d.F_COMPETITION, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_GOALS) as F_GOALS, sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
						FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
						WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
						AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
						AND a.F_GAMEID = d.F_ID
						AND a.F_NAME='$name'
						GROUP BY F_COMPETITION
						ORDER BY F_COMPETITION ASC";
				outputDataTable( $sql, 'Player Data by competition' );
				//================================================================================

				print '<h3>Stats by competition this season (when starting)</h3>';
				//================================================================================
				$sql = "SELECT d.F_COMPETITION, sum(a.F_APPS) as F_APPS, sum(a.F_GOALS) as F_GOALS, sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
					WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
					AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
					AND a.F_GAMEID = d.F_ID
					AND a.F_NAME='$name'
					and a.F_APPS = '1'
					GROUP BY F_COMPETITION
					ORDER BY F_COMPETITION ASC";
				outputDataTable( $sql, 'Player Data by competition' );
				//================================================================================


				print '<h3>Total Stats by Season</h3>';
			//================================================================================
			$sql = "SELECT e.F_LABEL as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_GOALS) as F_GOALS, sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, cfc_fixtures d, meta_seasons e
					WHERE a.F_NAME=b.F_NAME
					AND a.F_GAMEID = d.F_ID
					AND a.F_DATE >= e.F_SDATE AND a.F_DATE <= e.F_EDATE
					AND a.F_NAME='$name'
					GROUP BY F_ID
					union all
					SELECT 'Total' as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_GOALS) as F_GOALS, sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, cfc_fixtures d
					WHERE a.F_NAME=b.F_NAME
					AND a.F_GAMEID = d.F_ID
					AND a.F_NAME='$name'
					GROUP BY F_ID
					ORDER BY F_ID ASC";
			outputDataTable( $sql, 'Player Data by Season' );
			//================================================================================

				print '<h3>Total Stats by Season (when starting)</h3>';
				//================================================================================
				$sql = "SELECT e.F_LABEL as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_GOALS) as F_GOALS, sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, cfc_fixtures d, meta_seasons e
					WHERE a.F_NAME=b.F_NAME
					AND a.F_GAMEID = d.F_ID
					AND a.F_DATE >= e.F_SDATE AND a.F_DATE <= e.F_EDATE
					AND a.F_NAME='$name'
					and a.F_APPS = '1'
					GROUP BY F_ID
					union all
					SELECT 'Total' as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_GOALS) as F_GOALS, sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
					FROM cfc_fixtures_players a, cfc_players b, cfc_fixtures d
					WHERE a.F_NAME=b.F_NAME
					AND a.F_GAMEID = d.F_ID
					AND a.F_NAME='$name'
					and a.F_APPS = '1'
					GROUP BY F_ID
					ORDER BY F_ID ASC";
				outputDataTable( $sql, 'Player Data by Season' );
				//================================================================================

		}

		else {

				$v_keep = $go->_V( $keep );
			?>
			<?php get_header(); ?>
				<div id = "content">
					<?php
						print '<h4 class="special">Chelsea Player Data - ' . $v_keep . '.</h4>';

						print '<p>Goals against and save% are in beta and should not be used for any meaningful analysis.
								They currently ignore whether the player is active on the pitch which is patently incorrect/unfair.</p>';
						print '<h3>Stats by game this season</h3>';
						//================================================================================
						$sql = "SELECT CONCAT(d.F_ID,',',d.F_DATE) as MX_DATE, d.F_OPP as F_TEAM, d.F_LOCATION as LOC, d.F_RESULT, a.F_APPS , a.F_SUBS, a.F_UNUSED, a.F_SAVES, d.F_AGAINST as F_AGAINST,
								round((a.F_SAVES/(a.F_SAVES+d.F_AGAINST)*100),2) as F_SAVEPER, a.F_YC, a.F_RC, a.x_minutes as F_MINS
								FROM cfc_fixtures_players a, cfc_keepers b, meta_squadno c, cfc_fixtures d
								WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
								AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
								AND a.F_GAMEID = d.F_ID
								AND a.F_NAME='$keep'
								ORDER BY d.F_DATE asc";
						outputDataTable( $sql, 'M Squad' );
						//================================================================================

						print '<h3>Stats by location this season</h3>';
						//================================================================================
						$sql = "SELECT d.F_LOCATION as LOC, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_SAVES) as F_SAVES, sum(d.F_AGAINST) as F_AGAINST,
								round((sum(a.F_SAVES)/(sum(a.F_SAVES)+sum(d.F_AGAINST))*100),2) as F_SAVEPER, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
								FROM cfc_fixtures_players a, cfc_keepers b, meta_squadno c, cfc_fixtures d
								WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
								AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
								AND a.F_GAMEID = d.F_ID
								AND a.F_NAME='$keep'
								GROUP BY LOC
								union all
								SELECT 'Total' as LOC, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_SAVES) as F_SAVES, sum(d.F_AGAINST)  as F_AGAINST,
								round((sum(a.F_SAVES)/(sum(a.F_SAVES)+sum(d.F_AGAINST))*100),2) as F_SAVEPER, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
								FROM cfc_fixtures_players a, cfc_players b, meta_squadno c, cfc_fixtures d
								WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
								AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
								AND a.F_GAMEID = d.F_ID
								AND a.F_NAME='$keep'
								GROUP BY LOC
								ORDER BY LOC ASC";
						outputDataTable( $sql, 'Player Data by competition' );
						//================================================================================

						print '<h3>Stats by competition this season</h3>';
						//================================================================================
						$sql = "SELECT d.F_COMPETITION, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_SAVES) as F_SAVES, sum(d.F_AGAINST)  as F_AGAINST,
								round((sum(a.F_SAVES)/(sum(a.F_SAVES)+sum(d.F_AGAINST))*100),2) as F_SAVEPER, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
								FROM cfc_fixtures_players a, cfc_keepers b, meta_squadno c, cfc_fixtures d
								WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
								AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
								AND a.F_GAMEID = d.F_ID
								AND a.F_NAME='$keep'
								GROUP BY F_COMPETITION
								ORDER BY F_COMPETITION ASC";
						outputDataTable( $sql, 'Player Data by competition' );
						//================================================================================

						print '<h3>Stats by competition this season (when starting)</h3>';
						//================================================================================
						$sql = "SELECT d.F_COMPETITION, sum(a.F_APPS) as F_APPS, sum(a.F_SAVES) as F_SAVES, sum(d.F_AGAINST)  as F_AGAINST,
								round((sum(a.F_SAVES)/(sum(a.F_SAVES)+sum(d.F_AGAINST))*100),2) as F_SAVEPER, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
								FROM cfc_fixtures_players a, cfc_keepers b, meta_squadno c, cfc_fixtures d
								WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
								AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL')
								AND a.F_GAMEID = d.F_ID
								AND a.F_NAME='$keep'
								and a.F_APPS = '1'
								GROUP BY F_COMPETITION
								ORDER BY F_COMPETITION ASC";
						outputDataTable( $sql, 'Player Data by competition' );
						//================================================================================


						print '<h3>Total Stats by Season</h3>';
						//================================================================================
						$sql = "SELECT e.F_LABEL as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_SAVES) as F_SAVES, sum(d.F_AGAINST)  as F_AGAINST,
								round((sum(a.F_SAVES)/(sum(a.F_SAVES)+sum(d.F_AGAINST))*100),2) as F_SAVEPER, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
								FROM cfc_fixtures_players a, cfc_keepers b, cfc_fixtures d, meta_seasons e
								WHERE a.F_NAME=b.F_NAME
								AND a.F_GAMEID = d.F_ID
								AND a.F_DATE >= e.F_SDATE AND a.F_DATE <= e.F_EDATE
								AND a.F_NAME='$keep'
								GROUP BY F_ID
								union all
								SELECT 'Total' as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_SAVES) as F_SAVES, sum(d.F_AGAINST)  as F_AGAINST,
								round((sum(a.F_SAVES)/(sum(a.F_SAVES)+sum(d.F_AGAINST))*100),2) as F_SAVEPER, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
								FROM cfc_fixtures_players a, cfc_keepers b, cfc_fixtures d
								WHERE a.F_NAME=b.F_NAME
								AND a.F_GAMEID = d.F_ID
								AND a.F_NAME='$keep'
								GROUP BY F_ID
								ORDER BY F_ID ASC";
						outputDataTable( $sql, 'Player Data by Season' );
						//================================================================================


						print '<h3>Total Stats by Season (when starting)</h3>';
						//================================================================================
						$sql = "SELECT e.F_LABEL as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_SAVES) as F_SAVES, sum(d.F_AGAINST)  as F_AGAINST,
								round((sum(a.F_SAVES)/(sum(a.F_SAVES)+sum(d.F_AGAINST))*100),2) as F_SAVEPER, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
								FROM cfc_fixtures_players a, cfc_keepers b, cfc_fixtures d, meta_seasons e
								WHERE a.F_NAME=b.F_NAME
								AND a.F_GAMEID = d.F_ID
								AND a.F_DATE >= e.F_SDATE AND a.F_DATE <= e.F_EDATE
								AND a.F_NAME='$keep'
								and a.F_APPS ='1'
								GROUP BY F_ID
								union all
								SELECT 'Total' as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_SAVES) as F_SAVES, sum(d.F_AGAINST)  as F_AGAINST,
								round((sum(a.F_SAVES)/(sum(a.F_SAVES)+sum(d.F_AGAINST))*100),2) as F_SAVEPER, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(a.x_minutes) as F_MINS
								FROM cfc_fixtures_players a, cfc_keepers b, cfc_fixtures d
								WHERE a.F_NAME=b.F_NAME
								AND a.F_GAMEID = d.F_ID
								AND a.F_NAME='$keep'
								and a.F_APPS ='1'
								GROUP BY F_ID
								ORDER BY F_ID ASC";
						outputDataTable( $sql, 'Player Data by Season' );
						//================================================================================
						}
		?>
		<!-- The main column ends  -->
		<p>* Use this data with caution as we are still back-filling historic matches. Data should be good since 2002 in terms of appearances, goals and cards, but data sources are sketchy on other stats.</p>
	</div>
<?php get_footer(); ?>
