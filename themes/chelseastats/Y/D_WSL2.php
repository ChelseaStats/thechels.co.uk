<?php /* Template Name: # D TBL WSL 2 */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
	<p>How teams, who have featured in every FAWSL2 season, compare in an all time league record.</p>
	<p>The first table shows the latest results, the second shows the current standings at home, third current standings away and then a combined table (normal league table) followed by an all time record.</p>
	<?php print $go->getTableKey(); ?>

	<h3>FA Women's Super League 2 - Latest Results</h3>
	<?php
	//================================================================================
	$sql = "SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results_wsl_two
	        WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL') ORDER BY F_ID DESC LIMIT 10";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>

	<h3>FA Women's Super League 2 - Total</h3>
	<?php
		//================================================================================
		$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
      FROM 0V_base_WSL2_this
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'OVERALL');
		//================================================================================
	?>

	<h3>FA Women's Super League 2 - Home</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_WSL2_this WHERE LOC='H'
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>

	<h3>FA Women's Super League 2 - Away</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_WSL2_this WHERE LOC='A'
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>

</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
