<?php /* Template Name: # Z ** Updater EPL */ ?>
<?php get_header(); ?>
<?php

	if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4> 
			<?php
				$pdo                   = new pdodb();
				$go                    = new utility();
				$melinda               = new melinda();
				$startingValue         = $go->getSeasonalDate( date('Y-m-d') );
				$yearMarker            = $go->getYearMarkerFromDate( $startingValue );
				$shortId               = $go->getShortDateID( $yearMarker );
				$thisYearNextYear      = $go->getThisYearNextYearFromDate();
				$baseFootballDataTable = "o_tempFootballData{$yearMarker}";
				$plResultsTable        = "all_results";
				$SubsUsage_this        = "0V_SubsUsage_this";
                $footballData          = "http://www.football-data.co.uk/mmz4281/{$shortId}/E0.csv";
				$urlEPL1               = "http://www.futbol24.com/national/England/Premier-League/{$thisYearNextYear}/results/";


				print "<div class='alert alert-info'>";
					$pdo->query("SELECT COUNT(*) as CNT FROM {$baseFootballDataTable}");
					$row = $pdo->row();
					$count = $row['CNT'];
					print 'Current Football data row count : '. $count;
					$return = $updater->createFootballDataBase( $baseFootballDataTable,  $footballData);
					$messages = "Football-Data Inserted into {$baseFootballDataTable} : {$return} rows".PHP_EOL;
					print '<br/>';
					print 'New Football data row count : '. $count;
				print "</div>";

					$sql = "SELECT F_DATE, F_HOME H_TEAM, F_AWAY A_TEAM, H_FOULS, A_FOULS, H_CARDS, A_CARDS, H_SHOTS, A_SHOTS, H_SOT, A_SOT 
							FROM {$baseFootballDataTable} ORDER BY F_ID DESC LIMIT 10";
				    outputDataTable( $sql, 'Output');

				/** Subs Usage */
				print "<div class='alert alert-warning'>";

					$pdo->query("select count(*) as F_COUNT from {$SubsUsage_this}");
					$row = $pdo->row();
					$original = $row['F_COUNT'];
					Print "<p>Current {$SubsUsage_this} row count: {$original}.</p>";
					$sql = $updater->updater_subsUsage($SubsUsage_this);
					$pdo->query($sql);
					$result = $pdo->execute();
					if($result) {
						$messages .= 'Subs Usage Table updated'.PHP_EOL;
						$melinda->goMessage('Subs Usage View updated','success');
					}
					$pdo->query("select count(*) as F_COUNT from {$SubsUsage_this}");
					$row = $pdo->row();
					$counter = $row['F_COUNT'];
					print "<p>New {$SubsUsage_this} row count : {$counter}.</p>";
					$pdo->query( $sql );
					$pdo->execute();
				print "</div>";


				/** EPL 1 */
				print "<div class='alert alert-warning'>";
				$pdo->query("select count(*) as F_COUNT from {$plResultsTable} where F_DATE > (Select F_DATE from 000_config where F_LEAGUE = 'PL')");
				$row = $pdo->row();
				$original = $row['F_COUNT'];
				Print "<p>Current {$plResultsTable} row count: {$original}.</p>";
				$sql = $updater->_processMatchResults( $urlEPL1, '<div class="table loadingContainer">', $plResultsTable );
				$counter    = substr_count($sql, 'INSERT');
				print "<p>New {$plResultsTable} rows found : {$counter}.</p>";
				if(isset($sql) && $sql !='') {
					$pdo->query( $sql );
					$pdo->execute();
					$lastRowAndCount = $pdo->lastInsertId() . ' ' . $pdo->rowCount();
				}
				$messages .= "PL Results {$lastRowAndCount}" . PHP_EOL;
				print "</div>";

					$display = "SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM, F_1G as f0, HT_HGOALS, HT_AGOALS 
						  		FROM {$plResultsTable} WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') ORDER BY F_ID DESC LIMIT 10";
					outputDataTable( $display, 'small');

				$melinda->goSlack($messages, 'UpdaterBot', 'soccer', 'bots' );

				print "<div class='alert alert-info'>";
					$pdo->query("SELECT COUNT(*) as CNT FROM 0t_miles");
					$row = $pdo->row();
					$count = $row['CNT'];
					print "<p>Current milestones row count : {$count}.</p>";
					print "<p>New milestones row count : {$updater->updater_milestones()}.</p>";
				print "</div>";


				print "<div class='alert alert-info'>";
					$pdo->query("SELECT COUNT(*) as CNT FROM  0t_last38");
					$row = $pdo->row();
					$count = $row['CNT'];
					Print "<p>Current Last38 row count: {$count}.</p>";
					print "<p>New Last38 row count : {$updater->updater_last38()}.</p>";
				print "</div>";

				print $go->getOptionMenu();

			?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
