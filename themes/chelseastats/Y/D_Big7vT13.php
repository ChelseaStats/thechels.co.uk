<?php /* Template Name: # D TBL Big7 vs T13 */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<div style="clear:both; height:5px;"></div>
<p>A look at how the <a href="https://thechels.co.uk/the-big-seven-league/">big 7 sides</a> fair up against the <a href="https://thechels.co.uk/threatened-13/">threatened 13</a> (T13) teams.</p>
<p>Results against opponents from within the same set are ignored so big 7 teams will have 26 fixtures, T13 teams will have just 14, so PPG is probably more of an indicator than pure points.</p>
<?php print $go->getTableKey(); ?>

	<h3>Big 7 vs T13 Premier League - Total</h3>
	<?php
		//================================================================================
		$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM `0V_base_PRJ_this`
        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'GTT');
		//================================================================================
	?>

	<h3>Big 7 vs T13 Premier League - Home</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	        FROM `0V_base_PRJ_this` WHERE LOC='H'
	        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'GTH');
	//================================================================================
	?>

	<h3>Big 7 vs T13 Premier League - Away</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS,SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	        FROM `0V_base_PRJ_this` WHERE LOC='A'
	        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'GTA');
	//================================================================================
	?>

	<h3>Big 7 vs T13 All Time Premier League - Total</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM `0V_base_PRJ`
	        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'GTT');
	//================================================================================
	?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>