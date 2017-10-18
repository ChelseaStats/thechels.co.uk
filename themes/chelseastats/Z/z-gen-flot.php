<?php /* Template Name: # Z ** flot */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
	<div id="contentleft">
	<?php print $go->goAdminMenu(); ?>
	<h4 class="special"> <?php the_title(); ?></h4>
		<script src="/media/themes/ChelseaStats/js/jquery.flot.083.js" type="text/javascript"></script>
		<script src="/media/themes/ChelseaStats/js/base64.js" type="text/javascript"></script>
		<script src="/media/themes/ChelseaStats/js/jquery.flot.canvas.js" type="text/javascript"></script>
		<script src="/media/themes/ChelseaStats/js/canvas2image.js" type="text/javascript"></script>
		<script src="/media/themes/ChelseaStats/js/jquery.flot.saveAsImage.js" type="text/javascript"></script>
		<script src="/media/themes/ChelseaStats/js/jquery.flot.labels.js" type="text/javascript"></script>
		<?php  $pdo = new pdodb(); ?>

		<h3>Shots per game (analysisShots)</h3>
		<p>Mapping team's shots per game, for vs against, in the Premier League this season</p>
		<div class = "graph-container">
			<div id = "shots" style = "width:675px;height:400px; background-color:#ffffff;">
				<script type = "text/javascript" id = "source">
					$(function () {

							<?php
							$pdo->query("SELECT Team as Label, sum(F)/(sum(PLD)) as F, sum(A)/sum(PLD) as A from 0V_base_Shots_this group by Team");
							$rows = $pdo->rows();
							?>

							var options = {
								yaxis: { min: 5, max: 22, autoscaleMargin: 1, tickDecimals: 0, ticks: [ 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21, [22 , 'A'] ], color: "#bababa", axisLabelUseCanvas: true },
								xaxis: { min: 5, max: 22, autoscaleMargin: 1, tickDecimals: 0, ticks: [ 5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,[22 , 'F'] ], color: "#bababa", axisLabelUseCanvas: true },
								grid:  { hoverable: true, clickable: true, backgroundColor: "#ffffff", borderColor: "#666666"}
							};

							<?php
								 $teams = '';
								 $datas = '';

								foreach($rows as $row):
									$datas .= "[{$row['F']} , {$row['A']} ], ".PHP_EOL;
									$teams .=" \"{$go->_V($row['Label'])}\", ";
								endforeach;

								$datas = rtrim($datas);
								$datas = rtrim($datas, ",");

								$teams = rtrim($teams);
								$teams = rtrim($teams, ",");

							?>

							var data = [ <?php print $datas; ?>];
							var clubs= [ <?php print $teams; ?>];

							var dataset = { data: data, points: { show: true,  fill: true }, showLabels: true, labels: clubs, labelPlacement: "right",
								cColor: "#306EFF", tooltip: true,  canvasRender: true, canvas: true   };

							$.plot($("#shots"),[dataset],options);
						}
					)
				</script>
			</div>
		</div>

		<h3>Shots on Target per game (analysisSOT)</h3>
		<p>Mapping team's shots on target per game, for vs against, in the Premier League this season</p>
		<div class = "graph-container">
			<div id = "shotson" style = "width:675px;height:400px; background-color:#ffffff;">
				<script type = "text/javascript" id = "source">
					$(function () {

							<?php
							$pdo = new pdodb();
							$pdo->query("SELECT Team as Label, sum(F)/(sum(PLD)) as F, sum(A)/sum(PLD) as A from 0V_base_Shots_on_this group by Team");
							$rows = $pdo->rows();
							?>

							var options = {
								yaxis: { min: 1, max: 10, autoscaleMargin: 1, tickDecimals: 0, ticks: [ 1,2,3,4,5,6,7,8,9, [10 , 'A'] ], color: "#bababa", axisLabelUseCanvas: true },
								xaxis: { min: 1, max: 10, autoscaleMargin: 1, tickDecimals: 0, ticks: [ 1,2,3,4,5,6,7,8,9, [10 , 'F'] ], color: "#bababa", axisLabelUseCanvas: true },
								grid:  { hoverable: true, clickable: true, backgroundColor: "#ffffff", borderColor: "#666666"}
							};

							<?php
								 $teams = '';
								 $datas = '';

								foreach($rows as $row):
									$datas .= "[{$row['F']} , {$row['A']} ], ".PHP_EOL;
									$teams .=" \"{$go->_V($row['Label'])}\", ";
								endforeach;

								$datas = rtrim($datas);
								$datas = rtrim($datas, ",");

								$teams = rtrim($teams);
								$teams = rtrim($teams, ",");
							?>

							var data = [ <?php print $datas; ?>];
							var clubs= [ <?php print $teams; ?>];

							var dataset = { data: data, points: { show: true,  fill: true }, showLabels: true, labels: clubs, labelPlacement: "right",
								cColor: "#306EFF", tooltip: true,  canvasRender: true, canvas: true   };

							$.plot($("#shotson"),[dataset],options);
						}
					);
				</script>
			</div>
		</div>

		<h3>Goals per game (analysisGPG)</h3>
		<p>Mapping team's goals per game, for vs against, in the Premier League this season</p>
		<div class = "graph-container">
			<div id = "goals" style = "width:675px;height:400px; background-color:#ffffff;">
				<script type = "text/javascript" id = "source">
					$(function () {

							<?php
							$pdo = new pdodb();
							$pdo->query("SELECT Team, sum(F)/(sum(PLD)) as F, sum(A)/sum(PLD) as A from 0V_base_PL_this group by Team");
							$rows = $pdo->rows();
							?>

							var options = {
								yaxis: { min: 0.2, max: 2.8, autoscaleMargin: 0.5, tickDecimals: 1,  ticks: [ 0.2,0.4,0.6,0.8,1,1.2,1.4,1.6,1.8,2,2.2,2.4,2.6, [2.8 , 'A'] ], color: "#bababa", axisLabelUseCanvas: true },
								xaxis: { min: 0.2, max: 2.8, autoscaleMargin: 0.5, tickDecimals: 1,  ticks: [ 0.2,0.4,0.6,0.8,1,1.2,1.4,1.6,1.8,2,2.2,2.4,2.6, [2.8 , 'F'] ], color: "#bababa", axisLabelUseCanvas: true },
								grid:  { hoverable: true, clickable: true, backgroundColor: "#ffffff", borderColor: "#666666"}
							};

							<?php
								 $teams = '';
								 $datas = '';

								foreach($rows as $row):
									$datas .= "[{$row['F']} , {$row['A']} ], ".PHP_EOL;
									$teams .=" \"{$go->_V($row['Team'])}\", ";
								endforeach;

								$datas = rtrim($datas);
								$datas = rtrim($datas, ",");

								$teams = rtrim($teams);
								$teams = rtrim($teams, ",");

							?>

							var data = [ <?php print $datas; ?>];
							var clubs= [ <?php print $teams; ?>];


							var dataset = { data: data, points: { show: true,  fill: true }, showLabels: true, labels: clubs, labelPlacement: "right",
								cColor: "#306EFF", tooltip: true,  canvasRender: true, canvas: true   };

							$.plot($("#goals"),[dataset],options);
						}
					);
				</script>
			</div>
		</div>

		<h3>Goal Ratio vs Shots On Target Ratio (analysisGRvSOTR)</h3>
		<ul>
			<li>GR - goals for / (goals for + goals against)</li>
			<li>SOTR - Shots on Target for / (Shots on Target For + Shots on Target Against)</li>
		</ul>
		<div class = "graph-container">
			<div id = "GRvsSOTR" style = "width:675px;height:400px; background-color:#ffffff;">
				<script type = "text/javascript" id = "source">
					$(function () {

							<?php
							$pdo->query("SELECT a.Team as Label,
										 round(sum(a.F)/(sum(a.F)+SUM(a.A)),3) AS GR,
										 round(SUM(b.F)/(SUM(b.F)+SUM(b.A)),3) AS SOTR
										 FROM 0V_base_PL_this a, 0V_base_Shots_on_this b
										 where a.Team = b.Team group by Label");
							$rows = $pdo->rows();
							?>

							var options = {
								yaxis: { min: 0.2, max: 1, autoscaleMargin: 0.5,  tickDecimals: 2, ticks: [ 0.2,0.25, 0.30, 0.35, 0.40, 0.45, 0.5, 0.55, 0.60, 0.65, 0.70, 0.75, 0.80, 0.85, 0.90, 0.95, [1.0 , 'GR'] ], color: "#bababa", axisLabelUseCanvas: true },
								xaxis: { min: 0.2, max: 1, autoscaleMargin: 0.5,  tickDecimals: 2, ticks: [ 0.2,0.25, 0.30, 0.35, 0.40, 0.45, 0.5, 0.55, 0.60, 0.65, 0.70, 0.75, 0.80, 0.85, 0.90, 0.95, [1.0 , 'SOTR'] ], color: "#bababa", axisLabelUseCanvas: true },
								grid:  { hoverable: true, clickable: true, backgroundColor: "#ffffff", borderColor: "#666666"}
							};

							<?php
							$teams = '';
							$datas = '';

							foreach($rows as $row):
								$datas .= "[{$row['GR']} , {$row['SOTR']} ], ".PHP_EOL;
								$teams .=" \"{$go->_V($row['Label'])}\", ";
							endforeach;

							$datas = rtrim($datas);
							$datas = rtrim($datas, ",");

							$teams = rtrim($teams);
							$teams = rtrim($teams, ",");

							?>

							var data = [ <?php print $datas; ?>];
							var clubs= [ <?php print $teams; ?>];

							var dataset = { data: data, points: { show: true,  fill: true }, showLabels: true, labels: clubs, labelPlacement: "right",
								cColor: "#306EFF", tooltip: true,  canvasRender: true, canvas: true   };

							$.plot($("#GRvsSOTR"),[dataset],options);
						}
					);
				</script>
			</div>
		</div>

		<h3>Attacking Effectiveness (analysisAttack)</h3>
		<div class = "graph-container">
			<div id = "AttEff" style = "width:675px;height:400px; background-color:#ffffff;">
				<script type = "text/javascript" id = "source">
					$(function () {

							<?php
							$pdo->query("SELECT a.Team as Label,
									round(sum(b.F)/(sum(a.F)),3) AS A,
									round(sum(b.F)/(sum(a.PLD)),3) AS F
									FROM 0V_base_PL_this a, 0V_base_Shots_on_this b
									where a.Team = b.Team group by Label");
							$rows = $pdo->rows();
							?>

							var options = {
								yaxis: { min: 1, max: 5, tickDecimals: 1, ticks: [ 1,1.5,2.0,2.5,3.0,3.5,4.0,4.5, [ 5 , 'SOT/Game'] ], color: "#bababa", axisLabelUseCanvas: true },
								xaxis: { min: 1, max: 8, tickDecimals: 1, ticks: [ 1,1.5,2.0,2.5,3.0,3.5,4.0,4.5,5.0,5.5,6.0,6.5,7.0,7.5, [ 8 , 'SOT/Goal'] ], color: "#bababa", axisLabelUseCanvas: true },
								grid:  { hoverable: true, clickable: true, backgroundColor: "#ffffff", borderColor: "#666666"}
							};

							<?php
							$teams = '';
							$datas = '';

							foreach($rows as $row):
								$datas .= "[{$row['F']} , {$row['A']} ], ".PHP_EOL;
								$teams .=" \"{$go->_V($row['Label'])}\", ";
							endforeach;

							$datas = rtrim($datas);
							$datas = rtrim($datas, ",");

							$teams = rtrim($teams);
							$teams = rtrim($teams, ",");

							?>

							var data = [ <?php print $datas; ?>];
							var clubs= [ <?php print $teams; ?>];

							var dataset = { data: data, points: { show: true,  fill: true }, showLabels: true, labels: clubs, labelPlacement: "right",
								cColor: "#306EFF", tooltip: true,  canvasRender: true, canvas: true   };

							$.plot($("#AttEff"),[dataset],options);
						}
					);
				</script>
			</div>
		</div>


		<hr/><hr/>

		<h3>Substitute time</h3>
		<p>When do we make subs?</p>
		<div class = "graph-container">
			<div id = "subs" style = "width:675px;height:400px; background-color:#ffffff;">
				<script type = "text/javascript" id = "source">
					$(function () {

							<?php
							// AND e.F_DATE > (SELECT b.F_DATE FROM 000_config b WHERE F_LEAGUE = 'PL')
							// , ticks: [ 1,2,3,4,5,6,7,8,9, [300 , 'Counter']]
							$pdo->query("SELECT e.F_MINUTE, Count(*) AS F_COUNTER
										 FROM cfc_fixture_events e, cfc_fixtures f
										 WHERE e.F_TEAM = '1' AND f.F_ID = e.F_GAMEID AND e.F_EVENT = 'SUBON'
										 AND f.F_COMPETITION = 'PREM'
										 GROUP BY e.F_MINUTE");
							$rows = $pdo->rows();
							?>

							var options = {
								yaxis: { min: 0, max: 150, autoscaleMargin: 1, color: "#bababa", axisLabelUseCanvas: true },
								xaxis: { min: 0, max: 95, autoscaleMargin: 1, ticks: [ 0,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90, [95 , 'Minutes'] ], color: "#bababa", axisLabelUseCanvas: true },
								grid:  { hoverable: true, clickable: true, backgroundColor: "#ffffff", borderColor: "#666666"},
								stack: 0, series: { bars: { active: true, show: true, fill: true, barWidth: 0.25}}
							};

							<?php
							$datas = '';

							foreach($rows as $row):
								$datas .= "[{$row['F_MINUTE']} , {$row['F_COUNTER']} ], ".PHP_EOL;

							endforeach;

							$datas = rtrim($datas);
							$datas = rtrim($datas, ",");

							?>

							var data = [ <?php print $datas; ?>];

							var dataset = { data: data, cColor: "#306EFF", tooltip: true,  canvasRender: true, canvas: true   };

							$.plot($("#subs"),[dataset],options);
						}
					)
				</script>
			</div>
		</div>

		<h3>Chelsea Shots on target by season</h3>
		<p>Mapping Chelsea's shots on target per game, per season, for vs against, in the Premier League </p>
		<div class = "graph-container">
			<div id = "chelseaSOT" style = "width:675px;height:400px; background-color:#ffffff;">
				<script type = "text/javascript" id = "source">
					$(function () {

							<?php
							$pdo->query("SELECT Label, sum(F)/(sum(PLD)) as F, sum(A)/sum(PLD) as A from
	                            (SELECT b.f_label as Label, sum(a.F_H_ATTEMPTSON) as F, sum(a.F_A_ATTEMPTSON) as A, count(*) as PLD
	                             FROM cfc_fixtures a, meta_seasons b WHERE a.F_DATE < b.F_EDATE and a.F_DATE >= b.F_SDATE
	                             and a.F_COMPETITION='PREM' and b.f_label >= '2000-01' group by b.f_label) a group by Label");
							$rows = $pdo->rows();
							?>

							var options = {
								yaxis: { min: 0, max: 8, ticks: [ 0,1,2,3,4,5,6,7, [8 , 'A'] ],    color: "#bababa", axisLabelUseCanvas: true },
								xaxis: { min: 4, max: 11, ticks: [ 4,5,6,7,8,9,10, [11 , 'F'] ],          color: "#bababa", axisLabelUseCanvas: true },
								grid:  { hoverable: true, clickable: true, backgroundColor: "#ffffff", borderColor: "#666666"}
							};

							<?php
							$teams = '';
							$datas = '';

							foreach($rows as $row):
								$datas .= "[{$row['F']} , {$row['A']} ], ".PHP_EOL;
								$teams .=" \"{$go->_V($row['Label'])}\", ";
							endforeach;

							$datas = rtrim($datas);
							$datas = rtrim($datas, ",");

							$teams = rtrim($teams);
							$teams = rtrim($teams, ",");

							?>

							var data = [ <?php print $datas; ?>];
							var clubs= [ <?php print $teams; ?>];

							var dataset = { data: data, points: { show: true,  fill: true }, showLabels: true, labels: clubs, labelPlacement: "right",
								cColor: "#306EFF", tooltip: true,  canvasRender: true, canvas: true   };

							$.plot($("#chelseaSOT"),[dataset],options);
						}
					);
				</script>
			</div>
		</div>

		<h3>Chelsea Goals by season</h3>
		<p>Mapping Chelsea's goals per game, per season, for vs against, in the Premier League </p>
		<div class = "graph-container">
			<div id = "chelseaGoals" style = "width:675px;height:400px; background-color:#ffffff;">
				<script type = "text/javascript" id = "source">
					$(function () {

							<?php
							$pdo->query("SELECT Label, sum(F)/(sum(PLD)) as F, sum(A)/sum(PLD) as A from
 							(SELECT b.f_label as Label, sum(a.F_FOR) as F, sum(a.F_AGAINST) as A, count(*) as PLD
 							 FROM cfc_fixtures a, meta_seasons b WHERE a.F_DATE < b.F_EDATE and a.F_DATE >= b.F_SDATE
 							 and a.F_COMPETITION='PREM' and b.f_label >= '2000-01' group by b.f_label) a group by Label");
							$rows = $pdo->rows();
							?>

							var options = {
								yaxis: { min: 0, max: 2, ticks: [ 0, 0.25, 0.5, 0.75, 1.00, 1.25, 1.50, 1.75, [2 , 'A'] ], color: "#bababa", axisLabelUseCanvas: true },
								xaxis: { min: 1, max: 3, ticks: [ 1, 1.25, 1.5, 1.75, 2.00, 2.25, 2.50, 2.75, [3 , 'F'] ], color: "#bababa", axisLabelUseCanvas: true },
								grid:  { hoverable: true, clickable: true, backgroundColor: "#ffffff", borderColor: "#666666"}
							};

							<?php
							$teams = '';
							$datas = '';

							foreach($rows as $row):
								$datas .= "[{$row['F']} , {$row['A']} ], ".PHP_EOL;
								$teams .=" \"{$go->_V($row['Label'])}\", ";
							endforeach;

							$datas = rtrim($datas);
							$datas = rtrim($datas, ",");

							$teams = rtrim($teams);
							$teams = rtrim($teams, ",");

							?>

							var data = [ <?php print $datas; ?>];
							var clubs= [ <?php print $teams; ?>];

							var dataset = { data: data, points: { show: true,  fill: true }, showLabels: true, labels: clubs, labelPlacement: "right",
								cColor: "#306EFF", tooltip: true,  canvasRender: true, canvas: true   };

							$.plot($("#chelseaGoals"),[dataset],options);
						}
					);
				</script>
			</div>
		</div>

		<h3>Goal Differential</h3>
		<p>Frequency of Goal Differentials for the season, compared to previous seasons.</p>
		<div class="graph-container">
			<div id="bars2" style = "width:675px;height:350px; background-color:#ffffff;">
				<script type="text/javascript"  id="source">

					<?php

					$sql = "SELECT  m.f_label as lbl, (f.f_for - f.f_against) AS F, COUNT( * ) as A FROM meta_seasons m, cfc_fixtures f
						WHERE m.f_sdate < f.f_date AND m.f_edate >= f.f_date AND f.f_competition = 'PREM'
						and f_date > (Select f_date from 000_config where f_league = 'PL')
						GROUP BY (f.f_for - f.f_against) ASC";

					$sql2 = "SELECT m.f_label as lbl, (f.f_for - f.f_against) AS F, COUNT( * ) as A FROM meta_seasons m, cfc_fixtures f
						WHERE m.f_sdate < f.f_date AND m.f_edate >= f.f_date AND f.f_competition = 'PREM'
						and f_date > (Select f_date from 000_config where f_league = 'PLm1')
						and f_date < (Select f_date from 000_config where f_league = 'PL')
						GROUP BY (f.f_for - f.f_against) ASC";

					$sql3 = "SELECT m.f_label as lbl, (f.f_for - f.f_against) AS F, COUNT( * ) as A FROM meta_seasons m, cfc_fixtures f
						WHERE m.f_sdate < f.f_date AND m.f_edate >= f.f_date AND f.f_competition = 'PREM'
						and f_date > (Select f_date from 000_config where f_league = 'PLm2')
						and f_date < (Select f_date from 000_config where f_league = 'PLm1')
						GROUP BY (f.f_for - f.f_against) ASC";

					$sql4 = "SELECT m.f_label as lbl, (f.f_for - f.f_against) AS F, COUNT( * ) as A FROM meta_seasons m, cfc_fixtures f
						WHERE m.f_sdate < f.f_date AND m.f_edate >= f.f_date AND f.f_competition = 'PREM'
						and f_date > (Select f_date from 000_config where f_league = 'PLm3')
						and f_date < (Select f_date from 000_config where f_league = 'PLm2')
						GROUP BY (f.f_for - f.f_against) ASC";


					$lbl1 = '';
					$lbl2 = '';
					$lbl3 = '';
					$lbl4 = '';
					?>



					$(function () {
							var d1 = [
								<?php
								$pdo->query($sql);
								$rows = $pdo->rows();
								foreach($rows as $row) {
								$f1 = $row["F"];
								$f2 = $row["A"];
								$lbl1 = $row['lbl'];
								?>
								[<?php echo $f1; ?>, <?php echo $f2; ?> ],
								<?php   }  ?>
								['NULL','NULL'] ];

							var d2 = [
								<?php

								$pdo->query($sql2);
								$rows = $pdo->rows();
								foreach($rows as $row) {
								$f21 = $row["F"];
								$f22 = $row["A"];
								$lbl2 = $row['lbl'];
								?>
								[<?php echo $f21; ?>+0.24 , <?php echo $f22; ?> ],
								<?php  }  ?>
								['NULL','NULL'] ];

							var d3 = [
								<?php

								$pdo->query($sql3);
								$rows = $pdo->rows();
								foreach($rows as $row) {
								$f21 = $row["F"];
								$f22 = $row["A"];
								$lbl3 = $row['lbl'];
								?>
								[<?php echo $f21; ?>+0.48 , <?php echo $f22; ?> ],
								<?php  }  ?>
								['NULL','NULL'] ];

							var d4 = [
								<?php

								$pdo->query($sql4);
								$rows = $pdo->rows();
								foreach($rows as $row) {
								$f21 = $row["F"];
								$f22 = $row["A"];
								$lbl4 = $row['lbl'];
								?>
								[<?php echo $f21; ?>+0.72 , <?php echo $f22; ?> ],
								<?php  }  ?>
								['NULL','NULL'] ];

							var options = {stack: 0, series: { bars: { active: true, show: true, fill: true, barWidth: 0.18} }
								, grid:   { hoverable: true, clickable: true}, legend:{ position: 'nw', noColumns: 1}
								, yaxis: { min: 0, max: 15, tickDecimals:0, ticks: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,[15, "Count"] ]}
								, xaxis: { min: -5, max:8,  tickDecimals:0, ticks: [ -5,-4,-3,-2,-1,0,1,2,3,4,5,6,7, [8, "GD"] ] }
								, canvasRender: true, canvas: true
							};

							$.plot($("#bars2"), [
									{ label: "<?php echo $lbl1; ?>", data: d1, color:"#306eff" },
									{ label: "<?php echo $lbl2; ?>", data: d2, color:"#edc240" },
									{ label: "<?php echo $lbl3; ?>", data: d3, color:"#989898" },
									{ label: "<?php echo $lbl4; ?>", data: d4, color:"#cdcdcd" }
								] ,
								options
							)
						}
					);

				</script>
			</div>
		</div>

		<h3>Goal Differential frequency by season in the Premier League</h3>
		<?php
			$gd_sql = "SELECT lbl as F_YEAR,
					sum(if(F = '-8', A, 0)) as fm8, sum(if(F = '-7', A, 0)) as fm7,
					sum(if(F = '-6', A, 0)) as fm6, sum(if(F = '-5', A, 0)) as fm5,
					sum(if(F = '-4', A, 0)) as fm4, sum(if(F = '-3', A, 0)) as fm3,
					sum(if(F = '-2', A, 0)) as fm2, sum(if(F = '-1', A, 0)) as fm1,
					sum(if(F = '0', A, 0) ) as f0,
					sum(if(F = '1', A, 0) ) as f1, sum(if(F = '2', A, 0) ) as f2,
					sum(if(F = '3', A, 0) ) as f3, sum(if(F = '4', A, 0) ) as f4,
					sum(if(F = '5', A, 0) ) as f5, sum(if(F = '6', A, 0) ) as f6,
					sum(if(F = '7', A, 0) ) as f7, sum(if(F = '8', A, 0) ) as f8
					FROM 0V_base_goaldiffpl group by lbl";
			outputDataTable( $gd_sql,'GoalDiffer');
		?>
</div>
<?php get_template_part('sidebar');?>
</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
