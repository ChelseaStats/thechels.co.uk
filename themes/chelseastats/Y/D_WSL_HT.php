<?php /*  Template Name: # D TBL WSL HT */ ?>
<?php get_header(); ?>
<div id="content">
	<div id="contentleft">
		<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
		<p>Women's Super League full time records based on result situation at half-time.</p>
		<p>It is likely some teams will not appear in these tables as they have not be been in a winning or losing position at the interval.</p>
		<?php print $go->getTableKey(); ?>
		<?php
		print '<h3>Records When Winning at HT</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_WSL_this_W_HT
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'Winning @ HT');
		//================================================================================

		print '<h3>Records When Drawing at HT</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_WSL_this_D_HT
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'Drawing @ HT');
		//================================================================================


		print '<h3>Records When Losing at HT</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_WSL_this_L_HT
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'Losing @ HT');
		//================================================================================


		print '<h3>Records When Winning or Drawing at HT</h3>';
		//================================================================================
		$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
		FROM 0V_base_WSL_this_WD_HT
		GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'Not losing @ HT');
		//================================================================================



		?>
	</div>
	<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
