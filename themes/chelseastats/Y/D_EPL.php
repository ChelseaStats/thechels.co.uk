<?php /*  Template Name: # D TBL EPL */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<p>Up to date league table and results for the Premier League.</p>

	<h3>Breakdown of the Premier League</h3>
	<ul>
		<li><a href="/premier-league-table-half-time/" title="Latest Premier League table for this season based on half-time result">Latest Premier League Table based on half-time result</a>
			<p>The current league standings, including failed to score, clean sheet record and points per game as well as all the usual data</p></li>

		<li><a href="/first-goal-premier-league/" title="Latest Premier League table for this season based on results when scoring or conceding opening goal">Premier League Table on 1st Goal</a>
			<p>The current league standings, including failed to score, clean sheets, points per game split on scoring or conceding the game's first goal</p></li>

		<li><a href="/premier-league-new-years-day-split/" title="Latest Premier League table split about New Year's day">Premier League New Year split</a>
			<p>The current league standings split about New Year's Day - first/second half of season breakdown</p></li>

		<li><a href="/all-time-premier-league-table/" title="current all time Premier League table">All Time Premier League Table</a>
			<p>A mammoth league table recording the entire Premier League as a league table</p></li>
	</ul>


<?php print $go->getTableKey(); ?>

		<h3>Last 10 results</h3>
		<?php
		//================================================================================
		$sql="SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results WHERE
		      F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
		      ORDER BY F_ID DESC LIMIT 10";
		 outputDataTable( $sql, 'home');
		//================================================================================
		?>

        <h3>The current Premier League table (overall)</h3>
        <?php
        //================================================================================
        $sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
               SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
               FROM 0V_base_PL_this
               GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
         outputDataTable( $sql, 'ALL TIME PL');
        //================================================================================
         ?>

		<?php // if ( is_user_logged_in() )  : ?>

        <h3>The current Premier League table (home)</h3>
        <?php
        //================================================================================
        $sql="SELECT Team, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS
				FROM 0V_base_PL_this
				WHERE LOC ='H'
				ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
        outputDataTable( $sql, 'HOME');
        //================================================================================
        ?>

        <h3>The current Premier League table (away)</h3>
        <?php
        //================================================================================
        $sql="SELECT Team, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS
				FROM 0V_base_PL_this
				WHERE LOC ='A'
				ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
        outputDataTable( $sql, 'AWAY');
        //================================================================================
        ?>

		<?php // endif; ?>

</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>