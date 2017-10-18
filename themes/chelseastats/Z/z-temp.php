<?php /* Template Name: # Z Temp TBL Gen */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
<div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<p>Tables</p>
<ul>
<li><a href="/premier-league-table/">League</a></li>
<li><a href="/london-league//">London</a></li>
<li><a href="/big-7-vs-t13/">Big 7 vs T13</a></li>
<li><a href="/the-big-seven-league/">Big 7</a></li>
<li><a href="/t13/">t13</a></li>
<li><a href="/close/">close</a></li>
<li><a href="/last-38-league/">last38</a></li>
</ul>
<?php

    if(isset($_GET['sd']) ? $sdate = $_GET['sd'] : $sdate='2003-08-01');
    if(isset($_GET['ed']) ? $edate = $_GET['ed'] : $edate='2016-06-01');
    if(isset($_GET['team']) ? $home_team = $_GET['team'] : $home_team='Chelsea');

	print "<h3>Premier League Table from {$sdate} to {$edate} inclusive</h3>";

	$sql="SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, 
	 SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	FROM 
	(
	SELECT 
	'H' AS LOC, F_HOME Team, 
	COUNT(F_HOME) AS PLD,
	SUM(IF(F_HGOALS > F_AGOALS,1,0)=1) W,
	SUM(IF(F_HGOALS = F_AGOALS,1,0)=1) D,
	SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L,
	SUM(IF(F_HGOALS = 0,1,0)=1) FS,
	SUM(IF(F_AGOALS = 0,1,0)=1) CS,
	SUM(F_HGOALS) F,
	SUM(F_AGOALS) A,
	SUM(F_HGOALS-F_AGOALS) GD,
	ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS
	FROM all_results a
	WHERE  F_DATE >= '$sdate'
	AND    F_DATE <= '$edate'
	GROUP BY Team
	UNION ALL
	SELECT 
		'A' AS LOC, F_AWAY Team, 
		COUNT(F_AWAY) AS PLD,
		SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W,
		SUM(IF(F_AGOALS = F_HGOALS,1,0)=1) D,
		SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L,
		SUM(IF(F_AGOALS = 0,1,0)=1) FS,
		SUM(IF(F_HGOALS = 0,1,0)=1) CS,
		SUM(F_AGOALS) F,
		SUM(F_HGOALS) A,
		SUM(F_AGOALS-F_HGOALS) GD,
		ROUND(SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
		SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS
		FROM all_results b
		WHERE  F_DATE >= '$sdate'
		AND    F_DATE <= '$edate'
		GROUP BY Team
		) w
		GROUP BY Team
		ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
		 outputDataTable( $sql, 'OVERALL');
		//================================================================================

	print "<h3>Big 7 League Table from {$sdate} to {$edate} inclusive</h3>";

	$sql="SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, 
	 SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	FROM 
	(
	SELECT 
	'H' AS LOC, F_HOME Team, 
	COUNT(F_HOME) AS PLD,
	SUM(IF(F_HGOALS > F_AGOALS,1,0)=1) W,
	SUM(IF(F_HGOALS = F_AGOALS,1,0)=1) D,
	SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L,
	SUM(IF(F_HGOALS = 0,1,0)=1) FS,
	SUM(IF(F_AGOALS = 0,1,0)=1) CS,
	SUM(F_HGOALS) F,
	SUM(F_AGOALS) A,
	SUM(F_HGOALS-F_AGOALS) GD,
	ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS
	FROM all_results a
	WHERE  F_DATE >= '$sdate'
	AND    F_DATE <= '$edate'
	AND ((a.F_HOME in ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY'))
	AND (a.F_AWAY in ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY')))
	GROUP BY Team
	UNION ALL
	SELECT 
	'A' AS LOC, F_AWAY Team, 
	COUNT(F_AWAY) AS PLD,
	SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W,
	SUM(IF(F_AGOALS = F_HGOALS,1,0)=1) D,
	SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L,
	SUM(IF(F_AGOALS = 0,1,0)=1) FS,
	SUM(IF(F_HGOALS = 0,1,0)=1) CS,
	SUM(F_AGOALS) F,
	SUM(F_HGOALS) A,
	SUM(F_AGOALS-F_HGOALS) GD,
	ROUND(SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS
	FROM all_results b
	WHERE  F_DATE >= '$sdate'
	AND    F_DATE <= '$edate'
	AND ((b.F_HOME in ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY'))
	AND (b.F_AWAY in ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY')))
	GROUP BY Team
	) w
	GROUP BY Team
	ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================

	print "<h3>Threatened 13 League Table from {$sdate} to {$edate} inclusive</h3>";


	$sql="SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, 
	 SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	FROM 
	(
	SELECT 
	'H' AS LOC, F_HOME Team, 
	COUNT(F_HOME) AS PLD,
	SUM(IF(F_HGOALS > F_AGOALS,1,0)=1) W,
	SUM(IF(F_HGOALS = F_AGOALS,1,0)=1) D,
	SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L,
	SUM(IF(F_HGOALS = 0,1,0)=1) FS,
	SUM(IF(F_AGOALS = 0,1,0)=1) CS,
	SUM(F_HGOALS) F,
	SUM(F_AGOALS) A,
	SUM(F_HGOALS-F_AGOALS) GD,
	ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS
	FROM all_results a
	WHERE  F_DATE >= '$sdate'
	AND    F_DATE <= '$edate'
	AND ((a.F_HOME NOT IN ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY'))
	AND (a.F_AWAY NOT IN ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY')))
	GROUP BY Team
	UNION ALL
	SELECT 
	'A' AS LOC, F_AWAY Team, 
	COUNT(F_AWAY) AS PLD,
	SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W,
	SUM(IF(F_AGOALS = F_HGOALS,1,0)=1) D,
	SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L,
	SUM(IF(F_AGOALS = 0,1,0)=1) FS,
	SUM(IF(F_HGOALS = 0,1,0)=1) CS,
	SUM(F_AGOALS) F,
	SUM(F_HGOALS) A,
	SUM(F_AGOALS-F_HGOALS) GD,
	ROUND(SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS
	FROM all_results b
	WHERE  F_DATE >= '$sdate'
	AND    F_DATE <= '$edate'
	AND ((b.F_HOME NOT IN ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY'))
	AND (b.F_AWAY NOT IN ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY')))
	GROUP BY Team
	) w
	GROUP BY Team
	ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================

	print "<h3>London Premier League Table from {$sdate} to {$edate} inclusive</h3>";

	$sql="SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, 
	 SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	 from (
	select a.F_HOME AS Team,
	('H') LOC, 
	count(a.F_HOME) AS PLD,
	sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
	sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
	sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
	sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS,
	sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS,
	sum(a.F_HGOALS) AS F,sum(a.F_AGOALS) AS A,
	sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
	round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) 
	/ count(a.F_HOME)),3) AS PPG,
	sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS 
	from all_results a 
	where ((a.F_HOME in ('WEST_HAM','QPR','FULHAM','BRENTFORD','CHARLTON','C_PALACE','MILLWALL','ARSENAL','SPURS','CHELSEA','WIMBLEDON'))
	and (a.F_AWAY in ('WEST_HAM','QPR','FULHAM','BRENTFORD','CHARLTON','C_PALACE','MILLWALL','ARSENAL','SPURS','CHELSEA','WIMBLEDON')))
	and a.F_DATE >= '$sdate' 
	and a.F_DATE <= '$edate'
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
	sum(b.F_AGOALS) AS F,sum(b.F_HGOALS) AS A,
	sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
	round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) 
	/ count(b.F_HOME)),3) AS PPG,
	sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS 
	from all_results b 
	where ((b.F_HOME in ('WEST_HAM','QPR','FULHAM','BRENTFORD','CHARLTON','C_PALACE','MILLWALL','ARSENAL','SPURS','CHELSEA','WIMBLEDON'))
	and (b.F_AWAY in ('WEST_HAM','QPR','FULHAM','BRENTFORD','CHARLTON','C_PALACE','MILLWALL','ARSENAL','SPURS','CHELSEA','WIMBLEDON')))
	and b.F_DATE >= '$sdate' 
	and b.F_DATE <= '$edate'
	group by b.F_AWAY) w
	GROUP BY Team
	ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================

	print "<h3>Big 7 League Table from {$sdate} to {$edate} inclusive</h3>";

	$sql="SELECT F_LABEL as F_YEAR, Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, 
	 SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	FROM 
	(
	SELECT l.F_LABEL, 'H' AS LOC, F_HOME Team, 
	COUNT(F_HOME) AS PLD,
	SUM(IF(F_HGOALS > F_AGOALS,1,0)=1) W,
	SUM(IF(F_HGOALS = F_AGOALS,1,0)=1) D,
	SUM(IF(F_HGOALS < F_AGOALS,1,0)=1) L,
	SUM(IF(F_HGOALS = 0,1,0)=1) FS,
	SUM(IF(F_AGOALS = 0,1,0)=1) CS,
	SUM(F_HGOALS) F,
	SUM(F_AGOALS) A,
	SUM(F_HGOALS-F_AGOALS) GD,
	ROUND(SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_HGOALS>F_AGOALS,1,0)=1)*3+(IF(F_HGOALS=F_AGOALS,1,0)=1)) PTS
	FROM all_results a, meta_seasons l
	WHERE  a.F_DATE >= '$sdate'
	AND    a.F_DATE <= '$edate'
	AND    a.F_DATE > l.F_SDATE 
	AND    a.F_DATE < l.F_EDATE
	AND ((a.F_HOME in ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY'))
	AND (a.F_AWAY in ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY')))
	GROUP BY F_LABEL, Team
	UNION ALL
	SELECT l.F_LABEL, 'A' AS LOC, F_AWAY Team, 
	COUNT(F_AWAY) AS PLD,
	SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W,
	SUM(IF(F_AGOALS = F_HGOALS,1,0)=1) D,
	SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L,
	SUM(IF(F_AGOALS = 0,1,0)=1) FS,
	SUM(IF(F_HGOALS = 0,1,0)=1) CS,
	SUM(F_AGOALS) F,
	SUM(F_HGOALS) A,
	SUM(F_AGOALS-F_HGOALS) GD,
	ROUND(SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS
	FROM all_results b, meta_seasons l
	WHERE  b.F_DATE >= '$sdate'
	AND    b.F_DATE <= '$edate'
	AND    b.F_DATE > l.F_SDATE 
	AND    b.F_DATE < l.F_EDATE
	AND ((b.F_HOME in ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY'))
	AND (b.F_AWAY in ('MAN_UTD','CHELSEA','ARSENAL','SPURS','EVERTON','LIVERPOOL','MAN_CITY')))
	GROUP BY F_LABEL, Team
	) w
	GROUP BY F_LABEL, Team
	ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
	 outputDataTable( $sql, 'OVERALL');
	//================================================================================

	print "<h3>Record of teams traveling to {$home_team} from  {$sdate} to {$edate} inclusive</h3>";

	$sql = "SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, 
	 SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	FROM 
	(
	SELECT  F_AWAY Team, 
	COUNT(F_AWAY) AS PLD,
	SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W,
	SUM(IF(F_AGOALS = F_HGOALS,1,0)=1) D,
	SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L,
	SUM(IF(F_AGOALS = 0,1,0)=1) FS,
	SUM(IF(F_HGOALS = 0,1,0)=1) CS,
	SUM(F_AGOALS) F,
	SUM(F_HGOALS) A,
	SUM(F_AGOALS-F_HGOALS) GD,
	ROUND(SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS
	FROM all_results b
	WHERE  F_DATE >= '$sdate'
	AND    F_DATE <= '$edate'
	and F_HOME = '$home_team'
	GROUP BY Team
	) a
	GROUP BY Team
	ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
	outputDataTable( $sql, 'OVERALL');

	print "<h3>Record of teams traveling to {$home_team} from start of the Premier League to {$edate} inclusive</h3>";

	$sql = "SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, 
	 SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	FROM 
	(
	SELECT  F_AWAY Team, 
	COUNT(F_AWAY) AS PLD,
	SUM(IF(F_AGOALS > F_HGOALS,1,0)=1) W,
	SUM(IF(F_AGOALS = F_HGOALS,1,0)=1) D,
	SUM(IF(F_AGOALS < F_HGOALS,1,0)=1) L,
	SUM(IF(F_AGOALS = 0,1,0)=1) FS,
	SUM(IF(F_HGOALS = 0,1,0)=1) CS,
	SUM(F_AGOALS) F,
	SUM(F_HGOALS) A,
	SUM(F_AGOALS-F_HGOALS) GD,
	ROUND(SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1))/COUNT(F_HOME),3) PPG,
	SUM((IF(F_AGOALS>F_HGOALS,1,0)=1)*3+(IF(F_AGOALS=F_HGOALS,1,0)=1)) PTS
	FROM all_results b
	WHERE  F_DATE >= '1992-07-01'
	AND    F_DATE <= '$edate'
	and F_HOME = '$home_team'
	GROUP BY Team
	) a
	GROUP BY Team
	ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";
	outputDataTable( $sql, 'OVERALL');
?>

</div>
<?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
