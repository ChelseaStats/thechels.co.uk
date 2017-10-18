<?php /*  Template Name: # D TBL EPL This Split */ ?>
<?php get_header(); ?>
<div id="content">
	<div id="contentleft">
		<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
		<p>Premier League records split before and after New Year's Day.</p>
		<p>Often media outlets report a league table in the calendar year, so this page has both splits pre/post New Year's Day.</p>
		<p>It is likely teams will not have played the same number of games per split and indeed an even number of home and away fixtures so use with caution.</p>
		<?php print $go->getTableKey(); ?>
		<?php
		print '<h3>Records before New Year</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_PL_this_pre
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'pre');
		//================================================================================

		print '<h3>Records after New Year</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_PL_this_post
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'Post');
		//================================================================================


		print '<h3>Records before New Year (All time Premier League)</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_PL_pre
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'pre');
		//================================================================================

		print '<h3>Records after New Year (All time Premier League)</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_PL_post
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'Post');
		//================================================================================
		?>
	</div>
	<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
