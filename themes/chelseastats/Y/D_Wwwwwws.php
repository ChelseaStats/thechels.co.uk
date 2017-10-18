<<<<<<< Updated upstream
<?php /* Template Name: # D wwwwwws */ ?>
<?php get_header(); ?>
<div id="content">
	<div id="contentleft">
		<h4 class="special">Where were we when we were shit?</h4>
		<br/>
		<p>Opposition fans often remark about Chelsea's support suggesting that we have only been around since 2003, about the same time we started ruining football for everyone else.</p>
		<p>We take a look at 10 randomly selected games from our history, modern or otherwise. <a href="<?php the_permalink(); ?>/?<?php echo md5(rand(1,5000));?>">click to reload</a>.</p>
		<?php
			// lets get a random id between the min and max
			$pdo = new pdodb();
			$pdo->query("select min(F_ID) as my_min, max(F_ID) as my_max FROM cfc_fixtures");
			$row = $pdo->row();
			$min= $row["my_min"];
			$max= $row["my_max"];
			// calculate the ten games
			$r=rand($min+10,$max-50);
			$rd1=$r+1;
			$rd2=$r+2;
			$rd3=$r+3;
			$rd4=$r+4;
			$rd5=$r+5;
			$rd6=$r+6;
			$rd7=$r+7;
			$rd8=$r+8;
			$rd9=$r+9;
			// calculate the date and season from the id.

			$pdo = new pdodb();
			$pdo->query("SELECT F_DATE as MY_DATE FROM cfc_fixtures WHERE F_ID=:rid");
			$pdo->bind(':rid',$r);
			$row = $pdo->row();
			$date= $row['MY_DATE']; // 2010-09-01
			// must be an easier way
			$pp1 = substr($date, 0,4);
			$pp2 = substr($date, 2,2);
			$pp3='0'.$pp2+1;
			$pp4=$pp1-1;
			$subdate=substr($date, 5,2);
			// if which season? didn't i write a function for this
			if ($subdate>06) {
				$season = $pp1.'/'.$pp3; //2010/11
			} else {
				$season = $pp4.'/'.$pp2; //2009/10
			}
			//================================================================================
			$sql="SELECT CONCAT(a.F_ID,',',a.F_DATE) as MX_DATE, a.F_COMPETITION, a.F_OPP as M_TEAM, a.F_LOCATION as LOC, a.F_RESULT, a.F_FOR, a.F_AGAINST,a.F_ATT
      FROM cfc_fixtures a WHERE F_ID IN ($r,$rd1,$rd2,$rd3,$rd4,$rd5,$rd6,$rd7,$rd8,$rd9) ORDER BY MX_DATE asc";
			outputDataTable( $sql, 'M Squad');
			//================================================================================
		?>
		<?php
			//================================================================================
			$pdo = new pdodb();
			$pdo->query("SELECT
	SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0)) AS wonhome,
	SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0)) AS wonaway,
	SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0)) AS wonnewt,
	SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0)) AS losthome,
	SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0)) AS lostaway,
	SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0)) AS lostnewt,
	SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0)) AS drewhome,
	SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0)) AS drewaway,
	SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0)) AS drewnewt,
	SUM(IF( F_LOCATION='H'=1,1,0)) AS tothome,
	SUM(IF( F_LOCATION='A'=1,1,0)) AS totaway,
	SUM(IF( F_LOCATION='N'=1,1,0)) AS totnewt,
	SUM(IF( F_RESULT='W'=1,1,0)) AS totwon,
	SUM(IF( F_RESULT='L'=1,1,0)) AS totlost,
	SUM(IF( F_RESULT='D'=1,1,0)) AS totdrew,
	count(*) as total FROM cfc_fixtures
	WHERE F_ID IN (:rd,:rd1,:rd2,:rd3,:rd4,:rd5,:rd6,:rd7,:rd8,:rd9)");
			$pdo->bind(':rd' ,$r);
			$pdo->bind(':rd1',$rd1);
			$pdo->bind(':rd2',$rd2);
			$pdo->bind(':rd3',$rd3);
			$pdo->bind(':rd4',$rd4);
			$pdo->bind(':rd5',$rd5);
			$pdo->bind(':rd6',$rd6);
			$pdo->bind(':rd7',$rd7);
			$pdo->bind(':rd8',$rd8);
			$pdo->bind(':rd9',$rd9);
			$value = $pdo->row();

			//================================================================================

			$home_total 	= $value["tothome"];
			$away_total 	= $value["totaway"];
			$new_total      = $value["totnewt"];

			if(isset($home_total) && $home_total>0) {
				$hwper	= round (  ( $value["wonhome"] 	/ $home_total ) * 100 , 2);
				$hdper	= round (  ( $value["drewhome"] / $home_total ) * 100 , 2);
				$hlper	= round (  ( $value["losthome"] / $home_total ) * 100 , 2);
				print $go->_comparebars3('Home'	    ,$hwper,$hdper,$hlper);
			}

			if(isset($away_total) && $away_total>0) {
				$awper	= round (  ( $value["wonaway"] 	/ $away_total) * 100 , 2);
				$adper	= round (  ( $value["drewaway"] / $away_total) * 100 , 2);
				$alper	= round (  ( $value["lostaway"] / $away_total) * 100 , 2);
				print $go->_comparebars3('Away'	    ,$awper,$adper,$alper);
			}

			if(isset($new_total ) && $new_total >0) {
				$nwper	= round (  ( $value["wonnewt"] 	/ $new_total) * 100 , 2);
				$ndper	= round (  ( $value["drewnewt"] / $new_total) * 100 , 2);
				$nlper	= round (  ( $value["lostnewt"] / $new_total) * 100 , 2);
				print $go->_comparebars3('Neutral'	,$nwper,$ndper,$nlper);
			}

		?>
		<h3>Season and Manager Detail</h3>
		<?php
			//================================================================================

			$pdo = new pdodb();
			$pdo->query("SELECT F_YEAR, F_POSITION, F_WON, F_DREW, F_LOSS, F_FOR, F_AGAINST FROM cfc_positions WHERE F_YEAR=:season");
			$pdo->bind(':season',$season);
			$row = $pdo->row();
			$ix=$go->tcr_sub($row['F_POSITION']);
		?>
		<p style="text-align:justify;">
			Of the 10 games selected the Blues played <?php echo $value["tothome"];?> games at home, winning  <?php echo $value["wonhome"];?>
			drawing  <?php echo $value["drewhome"];?> and losing <?php echo $value["losthome"];?>. Whilst away from home Chelsea
			played <?php echo $value["totaway"];?>, winning  <?php echo $value["wonaway"];?>
			drawing  <?php echo $value["drewaway"];?> and losing <?php echo $value["lostaway"];?>.
		</p>
		<?php
			Print "<p>At the end of the ".$row['F_SEASON']." season Chelsea went on to finish ".$ix.", winning a total of ".$row['F_WON']." games, drawing ".$row['F_DREW']."
		and losing ".$row['F_LOSS'].", scoring a total of ".$row['F_FOR']."  goals and conceding ".$row['F_AGAINST'].".</p>";
			/**********************************************************************************/

			$pdo = new pdodb();
			$pdo->query("SELECT F_SNAME, F_WINPER, F_UNDER, S_DATE, E_DATE, PLD FROM 0V_base_mgr WHERE S_DATE <=:date AND E_DATE >=:date ");
			$pdo->bind(':date',$date);
			$row = $pdo->row();

			Print "<p>The manager in charge was ".$row['F_SNAME'].", (".$row['S_DATE']." &dash; ".$row['E_DATE']."), ";
			Print "who had a win percentage of ".$row['F_WINPER']."% and had an undefeated percentage of ".$row['F_UNDER']."% from managing a total ".$row['PLD']." games.</p>";

			/**********************************************************************************/

			// lets only show this if date exists, this errors a lot so this might help
			if(isset($date) && $date !='') :

				print '<h3>Other results over the calendar year</h3>';
				$tt  = substr($date,0,4);
				$sql = "SELECT concat(F_ID,',',F_DATE) AS MX_DATE, F_COMPETITION, F_LOCATION, F_RESULT, F_OPP as M_TEAM, F_FOR, F_AGAINST
					FROM cfc_fixtures WHERE substr( F_DATE, 1, 4 ) = $tt GROUP BY F_ID, F_DATE, F_LOCATION, F_RESULT, F_OPP, F_FOR, F_AGAINST
					ORDER BY F_DATE DESC LIMIT 25";
				outputDataTable( $sql, 'Top Res');

			endif;

		?>
		<h3>Attendances for next 25 home games with average.</h3>
		<div class="graph-container">
			<div id="avgatt" style="width:690px;height:250px">
				<?php
					$pdo = new pdodb();
					$pdo->query("SELECT AVG(F_ATT) as F_ATT  FROM cfc_fixtures WHERE substr(F_DATE,1,4)= :tt AND F_LOCATION='H' AND F_ATT IS NOT NULL ORDER BY F_DATE ASC LIMIT 25");
					$pdo->bind(':tt',$tt);
					$row = $pdo->row();
					$avg = $row["F_ATT"];
				?>
				<script type="text/javascript"  id="source">
					$(function ()
						{
							// a null signifies separate line segments
							//first set of variables from array
							var d1 = [  [1, <?php echo $avg; ?> ],  [50, <?php echo $avg; ?>  ] ];

							var d2 = [
								<?php
								$i=0;
								$pdo = new pdodb();
								$pdo->query("SELECT  F_ATT  FROM cfc_fixtures WHERE substr(F_DATE,1,4)= :tt AND F_LOCATION='H' AND F_ATT IS NOT NULL ORDER BY F_DATE ASC LIMIT 25");
								$pdo->bind(':tt',$tt);
								$rows = $pdo->rows();
								foreach($rows as $row) {
								$f1=$row["F_ATT"];
								?>
								[<?php echo $i; ?>,<?php echo $f1; ?>],
								<?php $i++; } ?>
								[26, 'NULL' ] ];
// plot these values to the placeholder div & let jquery-flot do its thing

							$.plot($("#avgatt"),
								[
									{ color: '#888888', label: "Average", data: d1,  lines: { show: true}, points: { show: false } },
									{ label: " Attendance", data: d2,  lines: { show: true}, points: { show: true } }
								],
								{
									legend: { position: 'ne', noColumns:1},
									grid: {hoverable:false, clickable:true},
									tooltip: true,
									yaxis: { min:0, max: 90000, ticks: [ 0,5000,10000,15000,20000,25000,30000,35000,40000,45000,50000,55000,60000,65000,70000,75000,80000,85000,90000] },
									xaxis: { min:1, max:25, ticks: [ [ 25," Games" ] ]}
								}
							);
						}
					);
				</script>
			</div>
		</div>
	</div>
	<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<script src="/media/themes/ChelseaStats/js/jquery.flot.grow.js" type="text/javascript"></script>
<?php get_footer(); ?>
=======
<?php /* Template Name: # D wwwwwws */ ?>
<?php get_header(); ?>
<div id="content">
	<div id="contentleft">
		<h4 class="special">Where were we when we were shit?</h4>
		<br/>
		<p>Opposition fans often remark about Chelsea's support suggesting that we have only been around since 2003, about the same time we started ruining football for everyone else.</p>
		<p>We take a look at 10 randomly selected games from our history, modern or otherwise. <a href="<?php the_permalink(); ?>/?<?php echo md5(rand(1,5000));?>">click to reload</a>.</p>
		<?php
			// lets get a random id between the min and max
			$pdo = new pdodb();
			$pdo->query("select min(F_ID) as my_min, max(F_ID) as my_max FROM cfc_fixtures");
			$row = $pdo->row();
			$min= $row["my_min"];
			$max= $row["my_max"];
			// calculate the ten games
			$r=rand($min+10,$max-50);
			$rd1=$r+1;
			$rd2=$r+2;
			$rd3=$r+3;
			$rd4=$r+4;
			$rd5=$r+5;
			$rd6=$r+6;
			$rd7=$r+7;
			$rd8=$r+8;
			$rd9=$r+9;
			// calculate the date and season from the id.

			$pdo = new pdodb();
			$pdo->query("SELECT F_DATE as MY_DATE FROM cfc_fixtures WHERE F_ID=:rid");
			$pdo->bind(':rid',$r);
			$row = $pdo->row();
			$date= $row['MY_DATE']; // 2010-09-01
			// must be an easier way
			$pp1 = substr($date, 0,4);
			$pp2 = substr($date, 2,2);
			/** @noinspection PhpWrongStringConcatenationInspection */
			$pp3     = '0' . $pp2 + 1;
			$pp4     =$pp1-1;
			$subdate =substr($date, 5,2);
			// if which season? didn't i write a function for this
			if ($subdate>06) {
				$season = $pp1.'/'.$pp3; //2010/11
			} else {
				$season = $pp4.'/'.$pp2; //2009/10
			}
			//================================================================================
			$sql="SELECT CONCAT(a.F_ID,',',a.F_DATE) as MX_DATE, a.F_COMPETITION, a.F_OPP as M_TEAM, a.F_LOCATION as LOC, a.F_RESULT, a.F_FOR, a.F_AGAINST,a.F_ATT
      FROM cfc_fixtures a WHERE F_ID IN ($r,$rd1,$rd2,$rd3,$rd4,$rd5,$rd6,$rd7,$rd8,$rd9) ORDER BY MX_DATE asc";
			outputDataTable( $sql, 'M Squad');
			//================================================================================
		?>
		<?php
			//================================================================================
			$pdo = new pdodb();
			$pdo->query("SELECT
	SUM(IF(F_RESULT='W' AND F_LOCATION='H'=1,1,0)) AS wonhome,
	SUM(IF(F_RESULT='W' AND F_LOCATION='A'=1,1,0)) AS wonaway,
	SUM(IF(F_RESULT='W' AND F_LOCATION='N'=1,1,0)) AS wonnewt,
	SUM(IF(F_RESULT='L' AND F_LOCATION='H'=1,1,0)) AS losthome,
	SUM(IF(F_RESULT='L' AND F_LOCATION='A'=1,1,0)) AS lostaway,
	SUM(IF(F_RESULT='L' AND F_LOCATION='N'=1,1,0)) AS lostnewt,
	SUM(IF(F_RESULT='D' AND F_LOCATION='H'=1,1,0)) AS drewhome,
	SUM(IF(F_RESULT='D' AND F_LOCATION='A'=1,1,0)) AS drewaway,
	SUM(IF(F_RESULT='D' AND F_LOCATION='N'=1,1,0)) AS drewnewt,
	SUM(IF( F_LOCATION='H'=1,1,0)) AS tothome,
	SUM(IF( F_LOCATION='A'=1,1,0)) AS totaway,
	SUM(IF( F_LOCATION='N'=1,1,0)) AS totnewt,
	SUM(IF( F_RESULT='W'=1,1,0)) AS totwon,
	SUM(IF( F_RESULT='L'=1,1,0)) AS totlost,
	SUM(IF( F_RESULT='D'=1,1,0)) AS totdrew,
	count(*) as total FROM cfc_fixtures
	WHERE F_ID IN (:rd,:rd1,:rd2,:rd3,:rd4,:rd5,:rd6,:rd7,:rd8,:rd9)");
			$pdo->bind(':rd' ,$r);
			$pdo->bind(':rd1',$rd1);
			$pdo->bind(':rd2',$rd2);
			$pdo->bind(':rd3',$rd3);
			$pdo->bind(':rd4',$rd4);
			$pdo->bind(':rd5',$rd5);
			$pdo->bind(':rd6',$rd6);
			$pdo->bind(':rd7',$rd7);
			$pdo->bind(':rd8',$rd8);
			$pdo->bind(':rd9',$rd9);
			$value = $pdo->row();

			//================================================================================

			$home_total 	= $value["tothome"];
			$away_total 	= $value["totaway"];
			$new_total      = $value["totnewt"];

			if(isset($home_total) && $home_total>0) {
				$hwper	= round (  ( $value["wonhome"] 	/ $home_total ) * 100 , 2);
				$hdper	= round (  ( $value["drewhome"] / $home_total ) * 100 , 2);
				$hlper	= round (  ( $value["losthome"] / $home_total ) * 100 , 2);
				print $go->_comparebars3('Home'	    ,$hwper,$hdper,$hlper);
			}

			if(isset($away_total) && $away_total>0) {
				$awper	= round (  ( $value["wonaway"] 	/ $away_total) * 100 , 2);
				$adper	= round (  ( $value["drewaway"] / $away_total) * 100 , 2);
				$alper	= round (  ( $value["lostaway"] / $away_total) * 100 , 2);
				print $go->_comparebars3('Away'	    ,$awper,$adper,$alper);
			}

			if(isset($new_total ) && $new_total >0) {
				$nwper	= round (  ( $value["wonnewt"] 	/ $new_total) * 100 , 2);
				$ndper	= round (  ( $value["drewnewt"] / $new_total) * 100 , 2);
				$nlper	= round (  ( $value["lostnewt"] / $new_total) * 100 , 2);
				print $go->_comparebars3('Neutral'	,$nwper,$ndper,$nlper);
			}

		?>
		<h3>Season and Manager Detail</h3>
		<?php
			//================================================================================

			$pdo = new pdodb();
			$pdo->query("SELECT F_YEAR, F_POSITION, F_WON, F_DREW, F_LOSS, F_FOR, F_AGAINST FROM cfc_positions WHERE F_YEAR=:season");
			$pdo->bind(':season',$season);
			$row = $pdo->row();
			$ix=$go->tcr_sub($row['F_POSITION']);
		?>
		<p style="text-align:justify;">
			Of the 10 games selected the Blues played <?php echo $value["tothome"];?> games at home, winning  <?php echo $value["wonhome"];?>
			drawing  <?php echo $value["drewhome"];?> and losing <?php echo $value["losthome"];?>. Whilst away from home Chelsea
			played <?php echo $value["totaway"];?>, winning  <?php echo $value["wonaway"];?>
			drawing  <?php echo $value["drewaway"];?> and losing <?php echo $value["lostaway"];?>.
		</p>
		<?php
			Print "<p>At the end of the ".$row['F_SEASON']." season Chelsea went on to finish ".$ix.", winning a total of ".$row['F_WON']." games, drawing ".$row['F_DREW']."
		and losing ".$row['F_LOSS'].", scoring a total of ".$row['F_FOR']."  goals and conceding ".$row['F_AGAINST'].".</p>";
			/**********************************************************************************/

			$pdo = new pdodb();
			$pdo->query("SELECT F_SNAME, F_WINPER, F_UNDER, S_DATE, E_DATE, PLD FROM 0V_base_mgr WHERE S_DATE <=:date AND E_DATE >=:date ");
			$pdo->bind(':date',$date);
			$row = $pdo->row();

			Print "<p>The manager in charge was ".$row['F_SNAME'].", (".$row['S_DATE']." &dash; ".$row['E_DATE']."), ";
			Print "who had a win percentage of ".$row['F_WINPER']."% and had an undefeated percentage of ".$row['F_UNDER']."% from managing a total ".$row['PLD']." games.</p>";

			/**********************************************************************************/

			// lets only show this if date exists, this errors a lot so this might help
			if(isset($date) && $date !='') :

				print '<h3>Other results over the calendar year</h3>';
				$tt  = substr($date,0,4);
				$sql = "SELECT concat(F_ID,',',F_DATE) AS MX_DATE, F_COMPETITION, F_LOCATION, F_RESULT, F_OPP as M_TEAM, F_FOR, F_AGAINST
					FROM cfc_fixtures WHERE substr( F_DATE, 1, 4 ) = $tt GROUP BY F_ID, F_DATE, F_LOCATION, F_RESULT, F_OPP, F_FOR, F_AGAINST
					ORDER BY F_DATE DESC LIMIT 25";
				outputDataTable( $sql, 'Top Res');

			endif;

		?>
		<h3>Attendances for next 25 home games with average.</h3>
		<div class="graph-container">
			<div id="avgatt" style="width:690px;height:250px">
				<?php
					$pdo = new pdodb();
					$pdo->query("SELECT AVG(F_ATT) as F_ATT  FROM cfc_fixtures WHERE substr(F_DATE,1,4)= :tt AND F_LOCATION='H' AND F_ATT IS NOT NULL ORDER BY F_DATE ASC LIMIT 25");
					$pdo->bind(':tt',$tt);
					$row = $pdo->row();
					$avg = $row["F_ATT"];
				?>
				<script type="text/javascript"  id="source">
					$(function ()
						{
							// a null signifies separate line segments
							//first set of variables from array
							var d1 = [  [1, <?php echo $avg; ?> ],  [50, <?php echo $avg; ?>  ] ];

							var d2 = [
								<?php
								$i=0;
								$pdo = new pdodb();
								$pdo->query("SELECT  F_ATT  FROM cfc_fixtures WHERE substr(F_DATE,1,4)= :tt AND F_LOCATION='H' AND F_ATT IS NOT NULL ORDER BY F_DATE ASC LIMIT 25");
								$pdo->bind(':tt',$tt);
								$rows = $pdo->rows();
								foreach($rows as $row) {
								$f1=$row["F_ATT"];
								?>
								[<?php echo $i; ?>,<?php echo $f1; ?>],
								<?php $i++; } ?>
								[26, 'NULL' ] ];
// plot these values to the placeholder div & let jquery-flot do its thing

							$.plot($("#avgatt"),
								[
									{ color: '#888888', label: "Average", data: d1,  lines: { show: true}, points: { show: false } },
									{ label: " Attendance", data: d2,  lines: { show: true}, points: { show: true } }
								],
								{
									legend: { position: 'ne', noColumns:1},
									grid: {hoverable:false, clickable:true},
									tooltip: true,
									yaxis: { min:0, max: 90000, ticks: [ 0,5000,10000,15000,20000,25000,30000,35000,40000,45000,50000,55000,60000,65000,70000,75000,80000,85000,90000] },
									xaxis: { min:1, max:25, ticks: [ [ 25," Games" ] ]}
								}
							);
						}
					);
				</script>
			</div>
		</div>
	</div>
	<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<script src="/media/themes/ChelseaStats/js/jquery.flot.grow.js" type="text/javascript"></script>
<?php get_footer(); ?>
>>>>>>> Stashed changes
