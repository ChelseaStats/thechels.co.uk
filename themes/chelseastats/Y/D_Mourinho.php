<?php /* Template Name: # D Mourinho */ ?>
<?php get_header(); ?>

<div id="content">
<h4 class="special"><a href="<?php get_permalink();?>">The Chelsea FC Statistical Record of Jose Mourinho</a></h4>
<p>A complete archive and analysis of every Chelsea game under Jose Mourinho.</p>
<h3>Complete Summary by Result under Jose Mourinho</h3>
<?php
//================================================================================
$sql_tbl1="SELECT SUM(IF(F_RESULT='W' ,1,0)) AS win,SUM(IF(F_RESULT='D' ,1,0)) AS draw, SUM(IF(F_RESULT='L' ,1,0)) AS loss,
			sum((if((F_FOR = 0),1,0) = 1)) AS FS,
			sum((if((F_AGAINST = 0),1,0) = 1)) AS CS,
			sum((if((F_FOR> 0 AND F_AGAINST > 0),1,0) = 1)) AS BTTS,
			sum(F_FOR) AS F,
			sum(F_AGAINST) AS A,
			sum((F_FOR - F_AGAINST)) AS GD,
		  count(*) AS Total FROM cfc_fixtures a, cfc_managers b WHERE b.F_SNAME like 'MOURINHO%'
		  AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE";
outputDataTable( $sql_tbl1, 'Competition');
//================================================================================
?>

<h3>Complete Summary by Location and Result under Jose Mourinho</h3>
<?php
//================================================================================
$sql_tbl2="SELECT
            SUM(IF(F_RESULT='W' AND F_LOCATION='H',1,0)) AS hwin, SUM(IF(F_RESULT='D' AND F_LOCATION='H',1,0)) AS hdraw, SUM(IF(F_RESULT='L' AND F_LOCATION='H',1,0)) AS hloss,
            SUM(IF(F_RESULT='W' AND F_LOCATION='A',1,0)) AS awin, SUM(IF(F_RESULT='D' AND F_LOCATION='A',1,0)) AS adraw, SUM(IF(F_RESULT='L' AND F_LOCATION='A',1,0)) AS aloss,
            SUM(IF(F_RESULT='W' AND F_LOCATION='N',1,0)) AS nwin, SUM(IF(F_RESULT='D' AND F_LOCATION='N',1,0)) AS ndraw, SUM(IF(F_RESULT='L' AND F_LOCATION='N',1,0)) AS nloss,
            SUM(IF(F_RESULT='W',1,0)) AS twin, SUM(IF(F_RESULT='D',1,0)) AS tdraw, SUM(IF(F_RESULT='L',1,0)) AS tloss,
            count(*) AS Total FROM cfc_fixtures a, cfc_managers b
            WHERE b.F_SNAME like 'MOURINHO%' AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE";
outputDataTable( $sql_tbl2, 'Competition');
//================================================================================
?>
<h3>Complete Summary by Competition, Location and Result under Jose Mourinho</h3>
<?php
//================================================================================
$sql_tbl3="SELECT a.F_COMPETITION,
            SUM(IF(F_RESULT='W' AND F_LOCATION='H',1,0)) AS hwin, SUM(IF(F_RESULT='D' AND F_LOCATION='H',1,0)) AS hdraw, SUM(IF(F_RESULT='L' AND F_LOCATION='H',1,0)) AS hloss,
            SUM(IF(F_RESULT='W' AND F_LOCATION='A',1,0)) AS awin, SUM(IF(F_RESULT='D' AND F_LOCATION='A',1,0)) AS adraw, SUM(IF(F_RESULT='L' AND F_LOCATION='A',1,0)) AS aloss,
            SUM(IF(F_RESULT='W' AND F_LOCATION='N',1,0)) AS nwin, SUM(IF(F_RESULT='D' AND F_LOCATION='N',1,0)) AS ndraw, SUM(IF(F_RESULT='L' AND F_LOCATION='N',1,0)) AS nloss,
            SUM(IF(F_RESULT='W',1,0)) AS twin, SUM(IF(F_RESULT='D',1,0)) AS tdraw, SUM(IF(F_RESULT='L',1,0)) AS tloss,
            count(*) AS Total FROM cfc_fixtures a, cfc_managers b WHERE b.F_SNAME like 'MOURINHO%' AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE GROUP BY a.F_COMPETITION";
outputDataTable( $sql_tbl3, 'Competition');
//================================================================================
?>

<br/>
<h3>Results Frequency: Goals For and Against Table </h3>
<br/>
<?php 
//================================================================================
$sql = "SELECT a.F_FOR, a.F_AGAINST, count(*) AS F_COUNT, ROUND((count(*)/(SELECT COUNT(*) FROM cfc_fixtures a, cfc_managers b WHERE b.F_SNAME like 'MOURINHO%' 
        AND a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE))*100,3) as F_PER FROM cfc_fixtures a, cfc_managers b WHERE b.F_SNAME like 'MOURINHO%'
        AND a.F_DATE >= b.F_SDATE  AND a.F_DATE <= b.F_EDATE GROUP BY F_FOR, F_AGAINST ORDER BY F_COUNT DESC";
 outputDataTable( $sql, 'Month by Month');
//================================================================================
?>

<h3>Goal differential by game under Jose Mourinho</h3>
<div class="graph-container">
<div id="bar" style="width:960px; height:400px;">
<script type="text/javascript"  id="source">
$(function () {
  var d1 = [
<?php
// Perform Query
    $pdo = new pdodb();
	$pdo->query("SELECT F_DATE, F_FOR-F_AGAINST as F_GD FROM cfc_fixtures
         WHERE  (  F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER='25') AND F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER='25') )
         OR ( F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER='34') AND F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER='34') )
         ORDER BY F_DATE ASC");
	$rows = $pdo->rows();
	$chartpostion = 1;
	foreach($rows as $row) {
        print '['.$chartpostion.','.$row["F_GD"].'],';
        $chartpostion++;
    }
?>
['NULL','NULL'] ];
$.plot($("#bar"),  [ { data: d1 } ],
{ grid: {hoverable: true, clickable: true}, bars: { show: true,  fill: true, lineWidth: 1}, yaxis: { ticks: [-4,-3,-2,-1,0,1,2,3,4,5,6,7] }, xaxis: { ticks: 20 }
});
});
</script>
</div>
</div>
<h3>London Premier League Table under Mourinho (both spells)</h3>
<?php
//================================================================================
$sql="SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
      FROM 0V_base_LDN_TSO GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
outputDataTable( $sql, 'LDN-MOU');
//================================================================================
?>

<h3>Big 7 League Table under Mourinho (both spells)</h3>
<?php
//================================================================================
$sql="SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
      FROM 0V_base_BIG7_TSO GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
outputDataTable( $sql, 'LDN-MOU');
//================================================================================
?>

<h3>Premier League Table under Mourinho (both spells)</h3>
<?php
//================================================================================
$sql="SELECT Team,  SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
      FROM 0V_base_TSO GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
outputDataTable( $sql, 'TSO-MOU');
//================================================================================
?>

<h3>Complete Results Archive under Jose Mourinho</h3>
<?php 
//================================================================================
$sql="SELECT CONCAT(F_ID,',',F_DATE) as MX_DATE, F_COMPETITION, F_OPP AS F_TEAM, F_RESULT, F_FOR, F_AGAINST, F_LOCATION, F_REF FROM cfc_fixtures 
         WHERE  (  F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER='25') AND F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER='25') )
         OR ( F_DATE > (SELECT F_SDATE FROM cfc_managers WHERE F_ORDER='34') AND F_DATE < (SELECT F_EDATE FROM cfc_managers WHERE F_ORDER='34') )
	 ORDER BY F_DATE ASC";
outputDataTable($sql,'Mou');
//================================================================================
?>

</div>
<div style="clear:both;"><p>&nbsp;</p></div>
<!-- The main column ends  -->
<script src="/media/themes/ChelseaStats/js/jquery.flot.grow.js" type="text/javascript"></script>
<?php  get_footer(); ?>