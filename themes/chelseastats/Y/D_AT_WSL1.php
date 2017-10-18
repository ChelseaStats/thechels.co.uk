<?php /* Template Name: # D TBL WSL 1 AT*/ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
	<p>How teams, who have featured in every FAWSL season, compare in an all time league record.</p>
	<p>The first table shows the all time record, the second and third tables show the table split either side of the mid-season break.</p>
	<?php print $go->getTableKey(); ?>

	<h3>All Time FA Women's Super League</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	      FROM 0V_base_WSL1
	      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>

	<h3>All Time FA Women's Super League before mid-season break</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD,
			round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	FROM
	 (
	SELECT 'H' AS LOC, F_HOME Team, COUNT(F_HOME) AS PLD,
	SUM(IF(F_HGOALS > F_AGOALS,1,0)=1) W,
	SUM(IF(F_HGOALS = F_AGOALS,1,0)=1) D,
	SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L,
	SUM(IF(F_HGOALS = 0,1,0)=1) FS,
	SUM(IF(F_AGOALS = 0,1,0)=1) CS,
	SUM(IF(F_AGOALS > 0 AND F_HGOALS >0,1,0)=1) BTTS,
	SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS - F_AGOALS) GD,
	ROUND(SUM((IF(F_HGOALS > F_AGOALS,1,0)=1)*3+(IF(F_HGOALS = F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_HGOALS > F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS FROM all_results_wsl_one a
	WHERE DATE_FORMAT(F_DATE, '%m%d') >= '0101'
	  AND DATE_FORMAT(F_DATE, '%m%d') <= '0708'  GROUP BY Team
	UNION ALL
	SELECT 'A' AS LOC, F_AWAY Team, COUNT(F_AWAY) AS PLD,
	SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W,
	SUM(IF(F_AGOALS = F_HGOALS,1,0)=1) D,
	SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L,
	SUM(IF(F_AGOALS = 0,1,0)=1) FS,
	SUM(IF(F_HGOALS = 0,1,0)=1) CS,
	SUM(IF(F_AGOALS > 0 AND F_HGOALS >0,1,0)=1) BTTS,
	SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS - F_HGOALS) GD,
	ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS = F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS = F_HGOALS,1,0)=1)) PTS
	FROM all_results_wsl_one b
	WHERE DATE_FORMAT(F_DATE, '%m%d')  >= '0101'
	  AND DATE_FORMAT(F_DATE, '%m%d')  <= '0709'  GROUP BY Team
	) a
	GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC
	";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>



	<h3>All Time FA Women's Super League after mid-season break</h3>
	<?php
	//================================================================================
	$sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD,
			round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	FROM
	 (
	SELECT 'H' AS LOC, F_HOME Team, COUNT(F_HOME) AS PLD,
	SUM(IF(F_HGOALS > F_AGOALS,1,0)=1) W,
	SUM(IF(F_HGOALS = F_AGOALS,1,0)=1) D,
	SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L,
	SUM(IF(F_HGOALS = 0,1,0)=1) FS,
	SUM(IF(F_AGOALS = 0,1,0)=1) CS,
	SUM(IF(F_AGOALS > 0 AND F_HGOALS >0,1,0)=1) BTTS,
	SUM(F_HGOALS) F, SUM(F_AGOALS) A, SUM(F_HGOALS - F_AGOALS) GD,
	ROUND(SUM((IF(F_HGOALS > F_AGOALS,1,0)=1)*3+(IF(F_HGOALS = F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_HGOALS > F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS FROM all_results_wsl_one a
	WHERE DATE_FORMAT(F_DATE, '%m%d') >= '0709'
	  AND DATE_FORMAT(F_DATE, '%m%d') <= '1225'  GROUP BY Team
	UNION ALL
	SELECT 'A' AS LOC, F_AWAY Team, COUNT(F_AWAY) AS PLD,
	SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W,
	SUM(IF(F_AGOALS = F_HGOALS,1,0)=1) D,
	SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L,
	SUM(IF(F_AGOALS = 0,1,0)=1) FS,
	SUM(IF(F_HGOALS = 0,1,0)=1) CS,
	SUM(IF(F_AGOALS > 0 AND F_HGOALS >0,1,0)=1) BTTS,
	SUM(F_AGOALS) F, SUM(F_HGOALS) A, SUM(F_AGOALS - F_HGOALS) GD,
	ROUND(SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS = F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_AGOALS > F_HGOALS,1,0)=1)*3+(IF(F_AGOALS = F_HGOALS,1,0)=1)) PTS
	FROM all_results_wsl_one b
	WHERE DATE_FORMAT(F_DATE, '%m%d')  >= '0709'
	  AND DATE_FORMAT(F_DATE, '%m%d')  <= '1225'  GROUP BY Team
	) a
	GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC
	";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================
	?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
