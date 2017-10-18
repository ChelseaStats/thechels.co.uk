<?php /* Template Name: # D TBL Close  */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<p>A alternative table of the Premier League where by only 'close' results are taken into account.</p>

<p>The 'close' idea comes from  Ben Pugsley (<a href="http://twitter.com/BenjaminPugsley">@BenjaminPugsley</a>) which looks at a number of metrics in football when the score differential in a game is -1, 0 or +1, for example 3-2, 5-4, 2-1, 1-0, 0-0 and 4-4 etc.</p>

<p>The premise is that around 85% or all results are 'close' and that some metrics like goal difference are overrated or skewed due to a team suffering a particularly bad day and end up giving up 6, 7 or 8 goals.</p>

<p>The first three tables shows the league table split by home, away and overall. The fourth table shows an all time record in the Premier League.</p>

<p><b>note:</b> Teams won't have necessarily played the same number of games, due to only certain scorelines being used. Points per game is more valuable than traditional points in this regard.</p>

<p><b>note:</b> These tables only consider close results at full-time, if a team wins 2-1 but goes 2-0 up their goal difference at close would be +2 (1-0 and 2-0 are close, but scoring 1 at 2-0 down is not).
				so for these tables things like goals scored, conceded and then of course goal difference underrepresented.</p>

<?php print $go->getTableKey(); ?>

<h3>Close Premier League - Total</h3>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_close_this 
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
 outputDataTable( $sql, 'OVERALL');
//================================================================================
?>

<h3>Close Premier League - Home</h3>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_close_this WHERE LOC='H' 
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
 outputDataTable( $sql, 'H');
//================================================================================
?>

<h3>Close Premier League - Away</h3>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_close_this WHERE LOC='A' 
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
 outputDataTable( $sql, 'A');
//================================================================================
?>



<h3>All Time Close Premier League</h3>
<?php
//================================================================================
$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, 
      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS 
      FROM 0V_base_close
      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
 outputDataTable( $sql, 'ALLTIME');
//================================================================================
?>

</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
