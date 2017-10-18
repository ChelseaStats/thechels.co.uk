<?php /* Template Name: # D TBL EPL MGR */?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark">The Manager League</a></h4>
	<p>A look at the league table if it started when the current manager took charge of Chelsea. In the majority of cases for other clubs this would replicate the
	<a href="/premier-league-table/">Current Premier League Table</a> but at Chelsea it is common for the board to change managers midway through a season.</p>
	<p>This Table monitors their performance against other sides since the start of the season or their appointment date and can span multiple seasons.</p>
	<?php print $go->getTableKey(); ?>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS,
      SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	  FROM 0V_base_PL_mgr GROUP BY Team ORDER BY PTS DESC, GD DESC, Team DESC, PPG DESC";
 outputDataTable( $sql, 'Total MGR League');
//================================================================================
?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>