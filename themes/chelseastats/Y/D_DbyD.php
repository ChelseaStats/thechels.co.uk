<?php /* Template Name: # D DayByDay */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special">Chelsea - Day by Day Results</h4>
<br/>
<h3> Results by Day of the week.</h3>
<?php 
//================================================================================
$sql="SELECT 
	DAYNAME(F_DATE) AS F_DAY,
	SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
	ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
	SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
	ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
	SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
	ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
	COUNT(*) AS F_PLD FROM cfc_fixtures
	GROUP BY DAYNAME(F_DATE)";
 outputDataTable( $sql, 'daynames');
// -- DAYOFYEAR(F_DATE) as F_DAY,
//================================================================================
?>
<div style="clear:both;"><p>&nbsp;</p></div>
<h3> Results by Month and Day.</h3>
<br/>
<?php 
//================================================================================
$sql="SELECT 
	MONTHNAME(STR_TO_DATE(MONTH(F_DATE) , '%m')) as F_MONTHNAME,
	DAY(F_DATE) AS F_DAY,
	SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,
	ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
	SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,
	ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
	SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES,
	ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
	COUNT(*) AS F_PLD FROM cfc_fixtures
	GROUP BY MONTH(F_DATE), DAY(F_DATE)
	ORDER BY MONTH(F_DATE) ASC, F_DAY ASC";
 outputDataTable( $sql, 'daybyday');
//================================================================================
?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
