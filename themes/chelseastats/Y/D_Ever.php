<?php /* Template Name: # D TBL Ever6 */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
	<p>How teams, who have featured in every premier league season (Premier League ever-presents), compare in a micro league against each other.</p>
	<p>The three table shows performance from this season split by home, away and overall record, the final table an all time premier league record.</p>
<?php print $go->getTableKey(); ?>

<h3>Ever 6 Premier League - Total</h3>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_EVER_this 
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
 outputDataTable( $sql, 'OVERALL');
//================================================================================
?>


<h3>Ever 6 Premier League - Home</h3>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_EVER_this WHERE LOC='H' 
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
 outputDataTable( $sql, 'OVERALL');
//================================================================================
?>

<h3>Ever 6 Premier League - Away</h3>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_EVER_this WHERE LOC='A' 
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
 outputDataTable( $sql, 'OVERALL');
//================================================================================
?>

<h3>All Time Ever 6 Premier League</h3>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_EVER GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
 outputDataTable( $sql, 'OVERALL');
//================================================================================
?>

</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
