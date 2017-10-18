<?php /* Template Name: # D TBL Big7 */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<p>A micro league of the Premier League's big 7 teams and how they compare against each other. The first three tables show performance from this season split by home, away and overall records, the final table shows an all time premier league record.</p>
<?php print $go->getTableKey(); ?>

	<h3>Big 7 Premier League - Total</h3>
	<?php
		//================================================================================
		$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
      FROM 0V_base_BIG_this
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'OVERALL');
		//================================================================================
	?>

	<h3>Big 7 Premier League - Home</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_BIG_this WHERE LOC='H'
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>

	<h3>Big 7 Premier League - Away</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_BIG_this WHERE LOC='A'
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>

	<h3>All Time Big 7 Premier League</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_BIG
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>

<h3>References</h3>
<p>For an explanation of these categorisations, <a href="http://www.twitter.com/simongleave">Simon Gleave</a> wrote about the concept of the <a href="https://scoreboardjournalism.wordpress.com/2013/12/30/introducing-the-superior-7-and-the-threatened-13/">Superior 7 and Threatened 13</a>
    on his blog <a href="http://www.scoreboardjournalism.wordpress.com">Scoreboard Journalism</a> in December 2013.</p>

    <p>This concept still exists despite Everton’s performance in the 2014-15 season as it is based on the longer term. However, Southampton are threatening to transform the categories into 'Excellent 8 and Threatened 12' if they repeat their recent performances next season.</p>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>