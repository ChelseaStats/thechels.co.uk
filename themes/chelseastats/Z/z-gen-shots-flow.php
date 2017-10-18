<?php /* Template Name: # Z ** Gen ShotsFlow */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<form name="form" method="POST" action="<?php the_permalink();?>">
					<div class="form-group">
						<label for="url">URL or ID:</label>
						<input name="url" type="text" id="url" class="form-control" value = <?php print $value = $go->get_ESPNid($go->get_maxGameId()); ?> >
					</div>
					<div class="form-group">
						<label for="gamer">Game id:</label>
						<input name="gamer" type="number" id="gamer" class="form-control" value = <?php print $value = $go->get_maxGameId(); ?> >
					</div>
				<br/>
					<div class="form-group">
				<input type="submit" name="Submit" value="Submit" class="btn btn-primary">
					</div>
			</form>
			<h3>Last 10</h3>
			<?php
				//------------------------------------------------------
				$sql = "select a.F_GAMEID as PLD, a.F_ESPN, b.F_OPP as Team
						from data_source a, cfc_fixtures b
						where b.F_ID = a.F_GAMEID
						and b.F_COMPETITION='PREM'
						order by F_GAMEID DESC Limit 10";
				outputDataTable( $sql, 'CSBM');
			 //------------------------------------------------------


				$url_id	= $_POST['url'];
				$url_id = filter_var($url_id, FILTER_SANITIZE_NUMBER_INT);
				$url = "http://www.espnfc.co.uk/gamepackage10/data/gamecast?gameId={$url_id}&langId=0&snap=0";


				$gamer	= $go->inputUpClean($_POST['gamer']);

				print '<h3>url</h3>';
				print "<p><a href='{$url}'>{$gamer}</a></p>";


				if(isset($gamer) && $gamer!='') {

					$dollar = $go->goCurl( $url );

					libxml_use_internal_errors(true);
					$sxe = simplexml_load_string($dollar);
					if (!$sxe) {
						echo "Failed loading XML\n";
						foreach(libxml_get_errors() as $error) {
							echo "\t", $error->message;
						}
					} else {

						$xml = new SimpleXMLElement( $dollar );

						$pdo = new pdodb();
						/* delete old records */
						$pdo->query( "DELETE FROM cfc_fixtures_shots WHERE F_GAMEID = :gamer" );
						$pdo->bind( ':gamer', $gamer );
						$pdo->execute();
						?>
						<h3>Shots Flow</h3>
						<table class = "tablesorter">
							<thead>
							<tr>
								<th>Order</th>
								<th>Flow</th>
								<th>Minute</th>
								<th>Player</th>
								<th>Club</th>
							</tr>
							</thead>
							<tbody>

							<?php
								$i     = 0;
								$y     = 0;
								$club  = 0;
								$graph = "[0,0],";
								foreach ( $xml->{'shots'}->{'play'} as $play ) {
									foreach ( $play->result as $event ) {

										// reset the club so it's new each time
										$club = 0;

										// some formatting fixes
										$event = str_replace( '<br>', ",", $event );
										$event = str_replace( '<b>', "<br/>", $event );
										$event = str_replace( '</b>', "", $event );
										$event = str_replace( "' ", "", $event );
										$event = str_replace( "'", "", $event );
										$event = str_replace( " - ", ",", $event );
										$event = str_replace( " , ", ",", $event );
										$event = strip_tags( trim( $event ) );

										// explode
										$events = explode( ",", $event );

										// tidy up 4 key values
										$minute = $go->get_minute( $events['1'] );
										$minute = str_replace( '<br>', "", $minute );

										$type = $events['2'];

										$player = $events['0'];
										$player = $go->get_prepare_text( $player );
										$player = str_replace( "&#239;", "i", $player );
										$player = str_replace( "&#233;", "e", $player );
										$player = str_replace( "&#225;", "a", $player );
										$player = str_replace( "&#224;", "a", $player );
										$player = str_replace( "&#243;", "o", $player );
										$player = str_replace( "&#237;", "i", $player );

										$player = $go->_Q( $player );
										if($player == "NGOLO_KANTE") {
											$player = "N'GOLO_KANTE";
										}

										// check if one of us
										$club = $go->get_current_player( $gamer, $player );

										// if us then increment
										if ( $club === 1 ) {
											$i ++;
										} else {
											$i --;
										}

										$y ++;

										// output
										print "<tr><td>" . $y . "</td><td>" . $i . "</td><td>" . $minute . "</td><td>" . $go->_V( $player ) . "</td><td>" . $club . "</td></tr>" . PHP_EOL;

										$graph .= "[" . $y . "," . $i . "],";

										try {

											/* insert new records */
											$pdo->query( "INSERT ignore INTO cfc_fixtures_shots (F_GAMEID,F_ORDER,F_FLOW,F_MINUTE,F_PLAYER,F_CLUB) VALUES (:gamer, :y, :i, :minutes, :player, :club)" );
											$pdo->bind( ':gamer', $gamer );
											$pdo->bind( ':y', $y );
											$pdo->bind( ':i', $i );
											$pdo->bind( ':minutes', $minute );
											$pdo->bind( ':player', $player );
											$pdo->bind( ':club', $club );
											$pdo->execute();


										} catch ( PDOException $e ) {

											print $melinda->goMessage( "DB Error: The record could not be added.<br>" . $e->getMessage(), 'error' );
											print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

										} catch ( Exception $e ) {

											print $melinda->goMessage( "General Error: The record could not be added.<br>" . $e->getMessage(), 'error' );
											print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

										}

									}
								}
								$graph .= "[null,null]";
							?>
							</tbody>
						</table>

						<script src="/media/themes/ChelseaStats/js/jquery.flot.083.js" type="text/javascript"></script>
						<script src="/media/themes/ChelseaStats/js/base64.js" type="text/javascript"></script>
						<script src="/media/themes/ChelseaStats/js/jquery.flot.canvas.js" type="text/javascript"></script>
						<script src="/media/themes/ChelseaStats/js/canvas2image.js" type="text/javascript"></script>
						<script src="/media/themes/ChelseaStats/js/jquery.flot.saveAsImage.js?b=8898" type="text/javascript"></script>
						
						<script src="/media/themes/ChelseaStats/js/jquery.flot.labels.js" type="text/javascript"></script>



						<?php $pdo = new pdodb(); ?>

						<h3>One Game Shot Locations</h3>
						<p>Mapping Chelsea and Opponents's shots and goals (excluding pens and own goals) in the most recent Premier League game.</p>
						<div class = "graph-container">
							<div id = "shotLocalsOneGame" style = "width:690px;height:490px; background: url('/media/themes/ChelseaStats/js/pitch.png?v=20161213') top left no-repeat;">
								<script type = "text/javascript" id = "source">
									$(function () {
											var options = {
												xaxis: { min: -800, max: 800, ticks: [ ], color: "#ffffff", tickLength: 0, axisLabelUseCanvas:false },
												yaxis: { min: -160, max: 1080, ticks: [ ], color: "#ffffff", tickLength: 0, axisLabelUseCanvas:false },
												grid:  { hoverable: true, clickable: true, backgroundColor: null, borderWidth: 0 },
												points: { show: true, fill: true, fillColor: false, radius: 2 },
												showLabels: false, canvasRender: true, canvas: true,
												legend:{ position: 'se', noColumns: 4}
											};

											var awayShots = [
												<?php
												$pdo->query("Select f_coordX as f_y, f_coordY as f_x  from cfc_shotLocations where f_team !='Chelsea' and f_shot_type not in ('goal','pen')
													 and f_match = (select f_match from cfc_shotLocations order by f_id desc limit 1)");
												$rows = $pdo->rows();
												$output = $go->returnHorizontalAwayFlotCoords($rows);
												print $output;
												?>
											];

											var awayGoals = [
												<?php
												$pdo->query("Select f_coordX as f_y, f_coordY as f_x  from cfc_shotLocations where f_team !='Chelsea' and f_shot_type in ('goal')
											             and f_match = (select f_match from cfc_shotLocations order by f_id desc limit 1)");
												$rows = $pdo->rows();
												$output = $go->returnHorizontalAwayFlotCoords($rows);
												print $output;
												?>
											];

											var homeShots = [
												<?php
												$pdo->query("Select f_coordX as f_y, f_coordY as f_x  from cfc_shotLocations where f_team ='Chelsea' and f_shot_type not in ('goal','pen')
														 and f_match = (select f_match from cfc_shotLocations order by f_id desc limit 1)");
												$rows = $pdo->rows();
												$output = $go->returnHorizontalHomeFlotCoords($rows);
												print $output;
												?>
											];

											var homeGoals = [
												<?php
												$pdo->query("Select f_coordX as f_y, f_coordY as f_x from cfc_shotLocations where f_team ='Chelsea' and f_shot_type in ('goal')
														 and f_match = (select f_match from cfc_shotLocations order by f_id desc limit 1)");
												$rows = $pdo->rows();
												$output = $go->returnHorizontalHomeFlotCoords($rows);
												print $output;
												?>
											];

											$.plot($("#shotLocalsOneGame"),
												[

													{ label: "Opponent Shots", data: awayShots, color:"#888888" },
													{ label: "Opponent Goals", data: awayGoals, color:"#333333" },
													{ label: "Chelsea Shots", data: homeShots, color:"#ffd480" },
													{ label: "Chelsea Goals", data: homeGoals, color:"#306eff" }
												]
												,options);
											$('.axisLabels').css('color','#000000');
											// $('.xAxis').css('display','none'); seems to work without these, maybe css caching?
											// $('.yAxis').css('display','none');
										}
									);
								</script>
							</div>
						</div>


						<h3>All Shot Locations</h3>
						<p>Mapping Chelsea and Opponents's shots and goals (excluding pens and own goals) in the Premier League this season.</p>
						<div class = "graph-container">
							<div id = "shotLocalsOverall" style = "width:690px;height:490px; background: url('/media/themes/ChelseaStats/js/pitch.png?v=20161213') top left no-repeat;">
								<script type = "text/javascript" id = "source">
									$(function () {
											var options = {
												xaxis: { min: -800, max: 800, ticks: [ ], color: "#ffffff", tickLength: 0, axisLabelUseCanvas:false },
												yaxis: { min: -160, max: 1080, ticks: [ ], color: "#ffffff", tickLength: 0, axisLabelUseCanvas:false },
												grid:  { hoverable: true, clickable: true, backgroundColor: null, borderWidth: 0 },
												points: { show: true, fill: true, fillColor: false, radius: 2 },
												showLabels: false, canvasRender: true, canvas: true,
												legend:{ position: 'se', noColumns: 4}
											};

											var awayShots = [
												<?php
												$pdo->query("Select f_coordX as f_y, f_coordY as f_x from cfc_shotLocations where f_team !='Chelsea' and f_season = '2016' and f_shot_type not in ('goal','pen') ");
												$rows = $pdo->rows();
												$output = $go->returnHorizontalAwayFlotCoords($rows);
												print $output;
												?>
											];

											var awayGoals = [
												<?php
												$pdo->query("Select f_coordX as f_y, f_coordY as f_x from cfc_shotLocations where f_team !='Chelsea' and f_season = '2016' and f_shot_type in ('goal') ");
												$rows = $pdo->rows();
												$output = $go->returnHorizontalAwayFlotCoords($rows);
												print $output;
												?>
											];


											var homeShots = [
												<?php
												$pdo->query("Select f_coordX as f_y, f_coordY as f_x from cfc_shotLocations where f_team ='Chelsea' and f_season = '2016' and f_shot_type not in ('goal','pen') ");
												$rows = $pdo->rows();
												$output = $go->returnHorizontalHomeFlotCoords($rows);
												print $output;
												?>
											];

											var homeGoals = [
												<?php
												$pdo->query("Select f_coordX as f_y, f_coordY as f_x from cfc_shotLocations where f_team ='Chelsea' and f_season = '2016' and f_shot_type in ('goal') ");
												$rows = $pdo->rows();
												$output = $go->returnHorizontalHomeFlotCoords($rows);
												print $output;
												?>
											];

											$.plot($("#shotLocalsOverall"),
												[

													{ label: "Opponent Shots", data: awayShots, color:"#888888" },
													{ label: "Opponent Goals", data: awayGoals, color:"#333333" },
													{ label: "Chelsea Shots", data: homeShots, color:"#ffd480" },
													{ label: "Chelsea Goals", data: homeGoals, color:"#306eff" }
												]
												,options);
											$('.axisLabels').css('color','#000000');

										}
									);
								</script>
							</div>
						</div>
						
						<h3>Shots Plus/Minus Flow</h3>
						<div class = "graph-container">
							<div id = "shotsflow" style = "width:690px;height:250px">
								<script type = "text/javascript" id = "source">
									$(function () {
											// a null signifies separate line segments
											//first set of variables from array
											var d1 = [<?php echo $graph; ?>];
											// plot these values to the placeholder div & let jquery-flot do its thing
											$.plot($("#shotsflow"),
												[ { data: d1, lines: {show: true}, points: {show: true},  color: '#306EFF' } ],
												{
													grid: {hoverable: false, clickable: true}, tooltip: false,  canvas : true,
													yaxis: { min: -20,  max: 22, ticks: [-20, -18, -16, -14, -12, -10, -8, -6, -4, -2, 0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, [ 22, 'Flow'] ], axisLabelUseCanvas: true },
													xaxis: {min: 0, max: <?php echo round($y,-1)+5; ?>, axisLabelUseCanvas: true}
												}
											);
										}
									);
								</script>
							</div>
						</div>

						<?php
						$sql = "select (case f_club when 1 then 'Chelsea'
 							else (select F_OPP from cfc_fixtures where F_ID = {$gamer} )
 							END)
 							as MIN_TEAM,
							0 							 as 'F00',
							sum(if(f_minute < 4 ,1,0)=1) as 'F05',
							sum(if(f_minute < 9 ,1,0)=1) as 'F10',
							sum(if(f_minute < 14,1,0)=1) as 'F15',
							sum(if(f_minute < 19,1,0)=1) as 'F20',
							sum(if(f_minute < 24,1,0)=1) as 'F25',
							sum(if(f_minute < 29,1,0)=1) as 'F30',
							sum(if(f_minute < 34,1,0)=1) as 'F35',
							sum(if(f_minute < 39,1,0)=1) as 'F40',
							sum(if(f_minute < 44,1,0)=1) as 'F45',
							sum(if(f_minute < 49,1,0)=1) as 'F50',
							sum(if(f_minute < 54,1,0)=1) as 'F55',
							sum(if(f_minute < 59,1,0)=1) as 'F60',
							sum(if(f_minute < 64,1,0)=1) as 'F65',
							sum(if(f_minute < 69,1,0)=1) as 'F70',
							sum(if(f_minute < 74,1,0)=1) as 'F75',
							sum(if(f_minute < 79,1,0)=1) as 'F80',
							sum(if(f_minute < 84,1,0)=1) as 'F85',
							sum(if(f_minute < 89,1,0)=1) as 'F90',
							sum(if(f_minute >  0,1,0)=1) as 'FFT'
							from cfc_fixtures_shots
							where F_GAMEID = '{$gamer}'
							group by f_club";

							$pdo->query("select F_OPP from cfc_fixtures where F_ID = :gid");
							$pdo->bind(':gid', $gamer);
							$result = $pdo->row();
							$opponent_name = $result['F_OPP'];

							$pdo->query($sql);
							$data = $pdo->rows();
							$team = "";
							$k ='';
							$v ='';
							$i = 0;
							$team['0'] = '';
							$team['1'] = '';
							foreach($data as $row) {

								foreach ( $row as $k=>$v ) {

								$team[$i] .= "[" . $k . "," . $v . "],";
								}

								$team[$i] .= "[null,null]";

								$i++;
							}

							$opp = str_replace('[MIN_TEAM,'.$opponent_name.'],' , '', $team['0']);
							$cfc = str_replace('[MIN_TEAM,Chelsea],'    , '', $team['1']);

							$opponent_name = $go->_V($opponent_name);

							$cfc = str_replace('FFT', '95', $cfc);
							$opp = str_replace('FFT', '95', $opp);

							$cfc = str_replace('F', '', $cfc);
							$opp = str_replace('F', '', $opp);


						?>
						<h3>Cumulative shots by minute graph</h3>

						<div class = "graph-container">
							<div id = "ChanceByMinute" style = "width:690px;height:250px">
								<script type = "text/javascript" id = "source">
									$(function () {
											// a null signifies separate line segments
											//first set of variables from array
											var d1 = [<?php echo $cfc; ?>]; // Chelsea
											var d2 = [<?php echo $opp; ?>]; // Opponent

											// plot these values to the placeholder div & let jquery-flot do its thing
											$.plot($("#ChanceByMinute"),
												[ { data: d1, lines: {show: true}, points: {show: true}, color: '#306EFF' },
												  { data: d2, lines: {show: true}, points: {show: true}, color: '#edc240' } ],
												{
													grid: {hoverable: false, clickable: true}, tooltip: false,  canvas : true,
													legend:{ position: 'nw', noColumns: 2},
													yaxis: { min: 0,  max: 32, ticks: [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30, [ 32, 'Shots' ]], axisLabelUseCanvas: true },
													xaxis: {min: 0, max: 100 ,ticks: [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, [95, 'FT']], axisLabelUseCanvas: true}
												}
											);
										}
									);
								</script>
							</div>
						</div>
				<?php } }  ?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
	<!-- The main column ends  -->
<?php get_footer(); ?>
