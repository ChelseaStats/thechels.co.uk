<?php /*  Template Name: # D TBL ATPL */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<p>All time record of every Premier League team</p>
<?php print $go->getTableKey(); ?>
<br/>
	<h3>All Time</h3>
	 <?php
		//================================================================================
		$sql = "SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_PL GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	    outputDataTable( $sql, 'ALL TIME PL');
		//================================================================================
	 ?>
	<h3>All Time Premier League table (home)</h3>
	<?php
		//================================================================================
		$sql="SELECT Team, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS
		FROM 0V_base_PL WHERE LOC ='H' ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
		outputDataTable( $sql, 'HOME');
		//================================================================================
	?>

	<h3>All Time League table (away)</h3>
	<?php
		//================================================================================
		$sql="SELECT Team, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS
		FROM 0V_base_PL WHERE LOC ='A' ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
		outputDataTable( $sql, 'AWAY');
		//================================================================================
	?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>