<?php /*  Template Name: # D TBL MODEL EPL */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
        <h3>Predictive 2015-16 Premier League</h3>
        <?php
        //================================================================================
        $sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
               SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
               FROM 
               (
               select a.F_HOME AS Team,
('H') LOC, 
count(a.F_HOME) AS PLD,
sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS,
sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
sum(a.F_HGOALS) AS F,
sum(a.F_AGOALS) AS A,
sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)))
/ count(a.F_HOME)),3) AS PPG,
sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
from cfc_model_results a
group by a.F_HOME
union all 
select b.F_AWAY AS Team,
('A') LOC, 
count(b.F_AWAY) AS PLD,
sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS,
sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS,
sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
sum(b.F_AGOALS) AS F,
sum(b.F_HGOALS) AS A,
sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)))
/ count(b.F_HOME)),3) AS PPG,
sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
from cfc_model_results b
group by b.F_AWAY
               ) v
               GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
         outputDataTable( $sql, 'ALL TIME PL');
        //================================================================================
         ?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
