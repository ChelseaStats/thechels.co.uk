<?php /*  Template Name: # D TBL ATCOMB */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<p>All time record of top flight</p>
<p><small>Assumed 3 points for a win</small></p>
<?php print $go->getTableKey(); ?>
<br/>
 <?php
//================================================================================
$sql = "SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, 
    round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_COMBINE
    GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
 outputDataTable( $sql, 'ALL TIME COMBINE');
//================================================================================
 ?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
