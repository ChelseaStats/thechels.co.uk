<?php /* Template Name: # D TBL LDN */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<div style="clear:both; height:5px;"></div>
<p>A look at all London based sides in the premier League and their results against each other as a micro-league table. Data shows for this season, and a summary of all time premier league.</p>
<p>The London league is split with home, away and overall table, There is also this season's South West London league and all time South West London Premier League</p>
<?php print $go->getTableKey(); ?>

<h3>Last 10 results</h3>
<?php
//================================================================================
$sql="SELECT F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results WHERE
(
((F_HOME in ('WEST_HAM','QPR','FULHAM','BRENTFORD','CHARLTON','C_PALACE','MILLWALL','ARSENAL','SPURS','CHELSEA','WIMBLEDON'))
AND F_AWAY in ('WEST_HAM','QPR','FULHAM','BRENTFORD','CHARLTON','C_PALACE','MILLWALL','ARSENAL','SPURS','CHELSEA','WIMBLEDON'))
)
AND F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='LDN')
ORDER BY F_DATE DESC LIMIT 10";
 outputDataTable( $sql, 'home');
//================================================================================
?>
	<h3>London Premier League - Total</h3>
	<?php
		//================================================================================
		$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_LDN_this
        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'GTT');
		//================================================================================
	?>

	<h3>London Premier League - Home</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	        FROM 0V_base_LDN_this WHERE LOC='H'
	        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'GTH');
	//================================================================================
	?>

	<h3>London Premier League - Away</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS,SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	        FROM 0V_base_LDN_this WHERE LOC='A'
	        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'GTA');
	//================================================================================
	?>

	<h3>All Time London Premier League</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD,
	round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_LDN
	GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>


	<h3>South West London Premier League</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_SWLDN_this
	        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'SWLDN');
	//================================================================================
	?>

	<h3>All Time South West London Premier League</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD,
	round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_SWLDN
	GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'SWLDNGT');
	//================================================================================
	?>


	<h3>Against London Teams (in London) - Premier League Table</h3>
	<?php
		$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD,
	round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_LDN_non_this
	GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'LDN_non');
		//================================================================================
	?>

	<h3>All Time Against London Teams (in London) - Premier League Table</h3>
	<?php
		$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD,
	round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_LDN_non
	GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'LDN_non');
		//================================================================================
	?>


</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>