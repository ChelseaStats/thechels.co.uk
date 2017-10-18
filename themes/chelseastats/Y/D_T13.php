<?php /* Template Name: # D TBL T13 */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
	<p>A micro league of the Premier League's threatened 13 teams and how they compare against each other. The first three tables show performance from this season split by home, away and overall records. The final table shows an all time premier league record.</p>
	<p>The threatened 13 is an idea from Simon Gleave (<a href="http://twitter.com/SimonGleave">@SimonGleave</a>) which looks at the league without the <a href="/the-big-seven-league">big 7 teams</a>.</p>
	<p>The Premise behind this is that these teams threatened with relegation would need to earn an average 1.5 points per game against their 12 rivals to survive.</p>
	<p><b>12 (other teams) x 2 (fixtures) x 1.5 (ppg) = 36 points</b></p>
	<p>This effectively gives these teams 14 free matches against the big 7 each season and any points gained in these matches would be a bonus that could see some of these teams finish in the top half.</p>

<?php print $go->getTableKey(); ?>

	<h3>Last 10 results</h3>
	<?php
	//================================================================================
	$sql="SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results WHERE
	      F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
	      AND F_HOME NOT IN ('ARSENAL','CHELSEA','MAN UTD','MAN CITY','LIVERPOOL','SPURS','EVERTON')
	      AND F_AWAY NOT IN ('ARSENAL','CHELSEA','MAN UTD','MAN CITY','LIVERPOOL','SPURS','EVERTON')
	      ORDER BY F_ID DESC LIMIT 10";
	 outputDataTable( $sql, 'home');
	//================================================================================
	?>

	<h3>Threatened 13 Premier League - Total</h3>
	<?php
		//================================================================================
		$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
      FROM 0V_base_T13_this
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
		outputDataTable( $sql, 'OVERALL');
		//================================================================================
	?>

	<h3>Threatened 13 Premier League - Home</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_T13_this WHERE LOC='H'
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'H');
	//================================================================================
	?>

	<h3>Threatened 13 Premier League - Away</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_T13_this WHERE LOC='A'
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'A');
	//================================================================================
	?>

	<h3>All Time Threatened 13 Premier League</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_T13
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'ALLTIME');
	//================================================================================
	?>

</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>