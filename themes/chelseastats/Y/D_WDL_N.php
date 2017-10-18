<?php /* Template Name: # D TBL WDLN */ ?>
<?php get_header(); ?>
<div id="content">
	<div id="contentleft">
		<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
		<p>All the usual results and tables for the Women's Development League (North) used in comparing Chelsea Ladies
			Development squad who play in the <a href="/wdl-south">Women's Development League (South)</a>.</p>
		<?php print $go->getTableKey(); ?>

		<h3>FA Women's Development League (North) - Latest Results</h3>
		<?php
			//================================================================================
			$sql = "SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results_wdl_north
        WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WDL') ORDER BY F_ID DESC LIMIT 10";
			outputDataTable( $sql, 'OVERALL');
			//================================================================================
		?>

		<h3>FA Women's Development League (North) - Total</h3>
		<?php
			//================================================================================
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD,
			      round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_WDL_north_this
			      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
			outputDataTable( $sql, 'OVERALL');
			//================================================================================
		?>

		<h3>FA Women's Development League (North) - Home</h3>
		<?php
			//================================================================================
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_WDL_north_this WHERE LOC='H' 
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
			outputDataTable( $sql, 'OVERALL');
			//================================================================================
		?>

		<h3>FA Women's Development League (North) - Away</h3>
		<?php
			//================================================================================
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_WDL_north_this WHERE LOC='A' 
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
			outputDataTable( $sql, 'OVERALL');
			//================================================================================
		?>

		<h3>All Time FA Women's Development League (North)</h3>
		<?php
			//================================================================================
			$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD,
      round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WDL_north
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
			outputDataTable( $sql, 'OVERALL');
			//================================================================================
		?>
	</div>
	<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
