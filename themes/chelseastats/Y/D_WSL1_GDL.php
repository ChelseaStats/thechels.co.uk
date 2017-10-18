<?php /* Template Name: # D TBL WSL1 GDL */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_WSL1_this
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	$raw = returnDataTable( $sql, 'OVERALL');
	//================================================================================
	print $go->CannNamStyle($raw,'Goal Diff','10'). PHP_EOL;
?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
