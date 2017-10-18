<?php /* Template Name: # U Form Guide */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<?php
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) { 
$base99 = 'wsl_fixtures'; 
?>
<h4 class="special">Chelsea Ladies - Current Form Guide</h4>
<div class="table-container">
<table class="tablesorter">
    <thead>
        <tr>
            <th>Type</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
        </tr>
    </thead>
    <tbody>
			<tr>
				<?php
				$pdo = new pdodb();
				$pdo->query("SELECT F_RESULT FROM wsl_fixtures ORDER BY F_DATE DESC LIMIT 6");
				$rows = $pdo->rows();
				?>
				<td>Current Form</td>
				<?php foreach($rows as $row) { print '<td align="right">'. $row['F_RESULT'] .'</td>'; } ?>
			</tr>
			<tr>
				<?php
				$pdo = new pdodb();
				$pdo->query("SELECT F_RESULT FROM wsl_fixtures WHERE F_LOCATION='H' ORDER BY F_DATE DESC LIMIT 6");
				$rows = $pdo->rows();
				?>
				<td>Current Form (home)</td>
				<?php foreach($rows as $row) { print '<td align="right">'. $row['F_RESULT'] .'</td>'; } ?>
			</tr>
			<tr>
				<?php
				$pdo = new pdodb();
				$pdo->query("SELECT F_RESULT FROM wsl_fixtures WHERE F_LOCATION='A' ORDER BY F_DATE DESC LIMIT 6");
				$rows = $pdo->rows();
				?>
				<td>Current Form (away)</td>
				<?php foreach($rows as $row) { print '<td align="right">'. $row['F_RESULT'] .'</td>'; } ?>
			</tr>
    </tbody>
</table>
</div>
<br/>
<?php
	$pdo = new pdodb();
	$pdo->query("SELECT
				ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				FROM (SELECT F_RESULT FROM wsl_fixtures a ORDER BY F_DATE DESC LIMIT 6) a");
	$row = $pdo->row();
	print $go->_comparebars3('Last 6*',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/***************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				FROM (SELECT F_RESULT FROM wsl_fixtures a ORDER BY F_DATE DESC LIMIT 38) a");
	$row = $pdo->row();
	print $go->_comparebars3('Last 38*',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/***************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				FROM (SELECT F_RESULT FROM wsl_fixtures a WHERE F_COMPETITION IN ('WSL') ORDER BY F_DATE DESC) a");
	$row = $pdo->row();
	print $go->_comparebars3("Women's Super League",$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/***************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				FROM (SELECT F_RESULT FROM wsl_fixtures a ORDER BY F_DATE DESC) a");
	$row = $pdo->row();
	print $go->_comparebars3('All Time*',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/***************************************************************************************/
    
} else {
?>
<h4 class="special">Chelsea - Current Form Guide</h4>
<div class="table-container">
<table class="tablesorter">
    <thead>
        <tr>
            <th>Type</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
        </tr>
    </thead>
	<tbody>
	<tr>
		<?php
		$pdo = new pdodb();
		$pdo->query("SELECT F_RESULT FROM cfc_fixtures ORDER BY F_DATE DESC LIMIT 6");
		$rows = $pdo->rows();
		?>
		<td>Current Form</td>
		<?php foreach($rows as $row) { print '<td align="right">'. $row['F_RESULT'] .'</td>'; } ?>
	</tr>

	<tr>
		<?php
		$pdo = new pdodb();
		$pdo->query("SELECT F_RESULT FROM cfc_fixtures WHERE F_LOCATION='H' ORDER BY F_DATE DESC LIMIT 6");
		$rows = $pdo->rows();
		?>
		<td>Current Form (home)</td>
		<?php foreach($rows as $row) { print '<td align="right">'. $row['F_RESULT'] .'</td>'; } ?>
	</tr>
	<tr>
		<?php
		$pdo = new pdodb();
		$pdo->query("SELECT F_RESULT FROM cfc_fixtures WHERE F_LOCATION='A' ORDER BY F_DATE DESC LIMIT 6");
		$rows = $pdo->rows();
		?>
		<td>Current Form (away)</td>
		<?php foreach($rows as $row) { print '<td align="right">'. $row['F_RESULT'] .'</td>'; } ?>
	</tr>
	</tbody>
</table>
</div>
<?php
/*************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				 ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				 ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				 ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				 FROM (SELECT F_RESULT FROM cfc_fixtures a ORDER BY F_DATE DESC LIMIT 6) a");
	$row = $pdo->row();
	print $go->_comparebars3('Last 6*',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/*************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				 ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				 ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				 ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				 FROM (SELECT F_RESULT FROM cfc_fixtures a WHERE F_COMPETITION='PREM' ORDER BY F_DATE DESC LIMIT 6) a");
	$row = $pdo->row();
	print $go->_comparebars3('Last 6 Premier League',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/*************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				 ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				 ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				 ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				 FROM (SELECT F_RESULT FROM cfc_fixtures a ORDER BY F_DATE DESC LIMIT 38) a");
	$row = $pdo->row();
	print $go->_comparebars3('Last 38*',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/*************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				 ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				 ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				 ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				 FROM (SELECT F_RESULT FROM cfc_fixtures a WHERE F_COMPETITION='PREM' ORDER BY F_DATE DESC LIMIT 38) a");
	$row = $pdo->row();
	print $go->_comparebars3('Last 38 Premier League',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/*************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				 ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				 ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				 ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				 FROM (SELECT F_RESULT FROM cfc_fixtures a WHERE F_DATE >'2003-06-01' ORDER BY F_DATE DESC) a");
	$row = $pdo->row();
	print $go->_comparebars3('Since Roman Abramovich Takeover*',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/*************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				 ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				 ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				 ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				 FROM (SELECT F_RESULT FROM cfc_fixtures a WHERE F_DATE >'1992-06-01' ORDER BY F_DATE DESC) a");
	$row = $pdo->row();
	print $go->_comparebars3('Since The Inception Of The Premier League*',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/*************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				 ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				 ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				 ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				 FROM (SELECT F_RESULT FROM cfc_fixtures a WHERE F_DATE >'1992-06-01' and F_COMPETITION='PREM' ORDER BY F_DATE DESC) a");
	$row = $pdo->row();
	print $go->_comparebars3('All Time Premier League',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/*************************************************************************************/
	$pdo = new pdodb();
	$pdo->query("SELECT
				 ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_WIN,
				 ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_DRAW,
				 ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,1) AS F_LOSS
				 FROM (SELECT F_RESULT FROM cfc_fixtures a ORDER BY F_DATE DESC) a");
	$row = $pdo->row();
	print $go->_comparebars3('All Time*',$row["F_WIN"],$row["F_DRAW"],$row["F_LOSS"]);

/*************************************************************************************/
 }  
?>
<div class="well well-small">
<p>*values are representative of all competitions and data we have recorded</p>
</div>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
