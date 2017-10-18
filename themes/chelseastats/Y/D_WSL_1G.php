<?php /*  Template Name: # D TBL WSL 1G */ ?>
<?php get_header(); ?>
<div id="content">
	<div id="contentleft">
		<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
		<p>Women's Super League full time records based on scoring or conceding the game's first goal.</p>
		<P>Historically around 70% of teams that score go on to win the game in men's football.</P>
		<?php print $go->getTableKey(); ?>
		<?php
		print '<h3>Records When Scoring First</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_WSL_this_1S
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'Scoring 1st');
		//================================================================================

		print '<h3>Records When Conceding First</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_WSL_this_1C
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'Conceding 1st');
		//================================================================================


		?>
	</div>
	<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
