<?php /* Template Name: # D TBL EPL Cann */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<?php
echo do_shortcode('[cann]');

	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_PL_this
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	$raw = returnDataTable( $sql, 'OVERALL');
	//================================================================================

	print $go->CannNamStyle($raw,'Points','12');

// make sexy
echo do_shortcode('[cann-foot]');
?>
</div> 
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
