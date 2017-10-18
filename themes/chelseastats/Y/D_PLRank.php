<?php /* Template Name: # D EPL Rank */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<p style="text-align:justify;">Every other Premier League team's record against Chelsea, where a win means a Chelsea loss, Failed to score is a Chelsea clean sheet etc.</p>
<p style="text-align:justify;">Updated automatically after every fixture. Initially ranked by points, then goal difference.</p>
<?php print $go->getTableKey(); ?>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_CFC WHERE Team <>'CHELSEA' 
      GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
 outputDataTable( $sql, 'OVERALL');
//================================================================================
?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>