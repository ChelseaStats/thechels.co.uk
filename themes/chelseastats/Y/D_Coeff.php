<?php /* Template Name: # D UEFA COEFF */ ?>
<?php get_header(); ?>
	<div id="content">
		<div id="contentleft">
			<h4 class="special">UEFA Coefficients Graph</h4>
			<p class="justify">A History of our UEFA Coefficient rankings, updated after each matchday. The last 5 year's values are taken into account by UEFA when producing pot seedings.</p>
			<h3>Summary</h3>
			<div class="graph-container">
				<div id="coeff01" style="width:690px;height:300px">
					<script type="text/javascript"  id="source">
						$(function ()
							{
								// a null signifies separate line segments
								//first set of variables from array
								var d1 = [
									<?php
									$pdo = new pdodb();
									$pdo->query("SELECT max(F_YEAR) as F_YEAR from cfc_coefficient");
									$row = $pdo->row();
									$max_year = 1 + $row['F_YEAR'];



									$pdo->query("SELECT F_YEAR, F_COEFF FROM cfc_coefficient ORDER BY F_YEAR ASC");
									$rows = $pdo->rows();
										foreach($rows as $row){
											$f1 = $row["F_YEAR"];
											$f2 = $row["F_COEFF"];
											print '['.$f1.','.$f2.'],';
										}
									?>
									[1998, 'NULL' ] ,
									[<?php echo $max_year; ?>, 'NULL' ] ];

								var d2 = [
									<?php

									$pdo->query("SELECT F_YEAR, F_TOTAL FROM cfc_coefficient ORDER BY F_YEAR ASC");
									$rows = $pdo->rows();
										foreach($rows as $row){
											$f21 = $row["F_YEAR"];
											$f22 = $row["F_TOTAL"];
											print '['.$f21.','.$f22.'],';
										}
									?>
									[1998, 'NULL' ] ,
									[<?php echo $max_year; ?>, 'NULL' ] ];


								var d3 = [
									<?php
									$years_list = '';
									$pdo->query("SELECT F_YEAR, F_POS FROM cfc_coefficient ORDER BY F_YEAR ASC");
									$rows = $pdo->rows();
										foreach($rows as $row){
											$f31 = $row["F_YEAR"];
											$f32 = -$row["F_POS"];
												//intercept the years to use for the axis label
												$years_list .= $row["F_YEAR"].', ';

											print '['.$f31.','.$f32.'],';
										}
								?>
									[1998, 'NULL' ] ,
									[<?php echo $max_year; ?>, 'NULL' ] ];

								// plot these values to the placeholder div & let jquery-flot do its thing

								$.plot($("#coeff01"),
									[
										{ label: "Coeff", data: d1,  bars: { show: true, align:"center", barWidth:0.55, fill: true } },
										{ label: "Total", data: d2,  lines: { show: true}, points: { show: true }  },
										{ color:'#999999', label: "Rank" , data: d3,  lines: { show: true}, points: { show: true }, yaxis:2 }
									] ,
									{
										legend: { position: 'nw' , noColumns: 3},
										yaxis:  { ticks: [0,10,20,30,40,50,60,70,80,90,100,110,120,130,140,150,[160, "Coeff"] ]},
										y2axis: { ticks: [ [-30,30], [-28,28], [-26,26],[-24,24], [-22,22], [-20,20],[-18, 18],[-16, 16],[-14, 14],[-12, 12],[-10, 10],[-8, 8],[-6, 6],[-4, 4],[-2, 2],[0, 1], [2, "Rank"] ] },
										xaxis:  { ticks: [ [1998,"Year"], <?php echo $years_list;?> [<?php echo $max_year; ?>, " "] ], tickDecimals: 0 }

									}
						)
						}
						)
					</script>
				</div>
			</div>
			<h3>UEFA Coefficients Table</h3>
			<?php
			//================================================================================
			$sql = "select F_YEAR, F_COEFF, F_TOTAL, F_POS from cfc_coefficient order by F_YEAR asc";
			outputDataTable( $sql, 'Coefficient');
			//================================================================================
			?>
			<br/>
			<?php
			/*
			 * [src url="http://www.xs4all.nl/~kassiesa/bert/uefa/calc.html"]kassiesa/bert/ - For more information on how the coefficients are calculated[/src]
			 *
			 */
			?>
			<p><a href="http://www.xs4all.nl/~kassiesa/bert/uefa/calc.html">For more information on how the coefficients are calculated</a></p>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<script src="/media/themes/ChelseaStats/js/jquery.flot.grow.js" type="text/javascript" ></script>
	<!-- The main column ends  -->
<?php get_footer(); ?>
