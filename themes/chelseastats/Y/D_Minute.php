<?php /* Template Name: # D Minute by Minute */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special">Chelsea - Goals For and Against by Minute Groupings </h4> 
<br/>
<h3>All Competitions for the 2015-16 season</h3>
<?php

$sql="
SELECT '01' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE <'5' 
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '02' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='5' AND F_MINUTE <10
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE  
UNION ALL
SELECT '03' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='10' AND F_MINUTE <15
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '04' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='15' AND F_MINUTE <20
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '05' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='20' AND F_MINUTE <25
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '06' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='25' AND F_MINUTE <30
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '07' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='30' AND F_MINUTE <35
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE  
UNION ALL
SELECT '08' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='35' AND F_MINUTE <40
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '09' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='40' AND F_MINUTE <45
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '10' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='45' AND F_MINUTE <50
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '11' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='50' AND F_MINUTE <55
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '12' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='55' AND F_MINUTE <60
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '13' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='60' AND F_MINUTE <65
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '14' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='65' AND F_MINUTE <70
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '15' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='70' AND F_MINUTE <75
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '16' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='75' AND F_MINUTE <80
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE 
UNION ALL
SELECT '17' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='80' AND F_MINUTE <85
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '18' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='85' AND F_MINUTE <90
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '19' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='90' 
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE  
ORDER BY F_VALUE ASC
";

$sql2="
SELECT '01' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE <'5' 
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '02' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='5' AND F_MINUTE <10
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE  
UNION ALL
SELECT '03' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='10' AND F_MINUTE <15
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '04' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='15' AND F_MINUTE <20
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '05' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='20' AND F_MINUTE <25
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '06' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='25' AND F_MINUTE <30
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '07' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='30' AND F_MINUTE <35
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE  
UNION ALL
SELECT '08' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='35' AND F_MINUTE <40
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '09' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='40' AND F_MINUTE <45
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '10' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='45' AND F_MINUTE <50
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '11' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='50' AND F_MINUTE <55
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '12' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='55' AND F_MINUTE <60
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '13' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='60' AND F_MINUTE <65
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '14' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='65' AND F_MINUTE <70
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '15' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='70' AND F_MINUTE <75
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '16' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='75' AND F_MINUTE <80
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE 
UNION ALL
SELECT '17' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='80' AND F_MINUTE <85
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '18' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='85' AND F_MINUTE <90
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate GROUP BY F_VALUE
UNION ALL
SELECT '19' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='90' 
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate  GROUP BY F_VALUE  
ORDER BY F_VALUE ASC
";
?>
<div class="graph-container">
<div id="bars2" style="width:690px; height:300px;">
<script type="text/javascript"  id="source">
$(function () {
      var d1 = [
            <?php
                $pdo = new pdodb();
                $pdo->query($sql);
                $pdo->bind(':cdate','2015-08-01');
                $rows = $pdo->rows();
                foreach($rows as $row) {
                    $f1 = $row["F_VALUE"];
                    $f2 = $row["F_CNT"];
            ?>
            [<?php echo $f1; ?>, <?php echo $f2; ?> ],
            <?php   }  ?>
            ['NULL','NULL'] ];

      var d2 = [
          <?php
              $pdo = new pdodb();
              $pdo->query($sql2);
              $pdo->bind(':cdate','2015-08-01');
              $rows = $pdo->rows();
              foreach($rows as $row) {
                  $f21 = $row["F_VALUE"];
                  $f22 = $row["F_CNT"];
          ?>
          [<?php echo $f21; ?>+0.34 , <?php echo $f22; ?> ],
          <?php  }  ?>
          ['NULL','NULL'] ];

//noinspection OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS
		var options = {stack: 0, series: { bars: { active: true, show: true, fill: true, barWidth: 0.29} }
,grid:   { hoverable: true, clickable: true}
,legend:{ position: 'nw', noColumns: 1}
,yaxis: { min: 0, max: 30, ticks: [ 0,2,4,6,8,10,12,14,16,18,20,22,24,26,28,[30, "Goals"] ]}
,xaxis: { min: 1, max:20, ticks: [ 
[01, "0-4"], [02,"5-9"], [03, "10-14"], [04, "15-19" ], [05, "20-24"], [06, "25-29"], [07, "30-34"], 
[08, "35-39"], [09, "40-44"], [10, "45-49"], [11, "50-54"], [12, "55-59"], [13, "60-64"], [14, "65-69"],  [15, "70-74"], [16, "75-79"], [17, "80-84"], [18, "85-89"], [19, "90+"]  ] }
   };

$.plot($("#bars2"), 
         [{
		label: "Goals For",     
		data: d1
	} ,
	{	
		label: "Goals Against", 
		data: d2
	}]
	,  options );  }
     );
</script>
</div>
</div>
<div style="clear:both;"><p>&nbsp;</p></div>
<h3>All Competitions for the 2014-15 season</h3>

<?php

$sql="
SELECT '01' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE <'5' 
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '02' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='5' AND F_MINUTE <10
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE  
UNION ALL
SELECT '03' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='10' AND F_MINUTE <15
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '04' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='15' AND F_MINUTE <20
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '05' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='20' AND F_MINUTE <25
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '06' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='25' AND F_MINUTE <30
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '07' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='30' AND F_MINUTE <35
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE  
UNION ALL
SELECT '08' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='35' AND F_MINUTE <40
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '09' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='40' AND F_MINUTE <45
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '10' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='45' AND F_MINUTE <50
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '11' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='50' AND F_MINUTE <55
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '12' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='55' AND F_MINUTE <60
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '13' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='60' AND F_MINUTE <65
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '14' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='65' AND F_MINUTE <70
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '15' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='70' AND F_MINUTE <75
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '16' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='75' AND F_MINUTE <80
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE 
UNION ALL
SELECT '17' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='80' AND F_MINUTE <85
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '18' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='85' AND F_MINUTE <90
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '19' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='90' 
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE  
ORDER BY F_VALUE ASC
";

$sql2="
SELECT '01' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE <'5' 
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '02' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='5' AND F_MINUTE <10
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE  
UNION ALL
SELECT '03' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='10' AND F_MINUTE <15
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '04' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='15' AND F_MINUTE <20
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '05' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='20' AND F_MINUTE <25
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '06' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='25' AND F_MINUTE <30
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '07' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='30' AND F_MINUTE <35
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE  
UNION ALL
SELECT '08' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='35' AND F_MINUTE <40
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '09' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='40' AND F_MINUTE <45
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '10' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='45' AND F_MINUTE <50
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '11' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='50' AND F_MINUTE <55
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '12' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='55' AND F_MINUTE <60
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '13' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='60' AND F_MINUTE <65
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '14' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='65' AND F_MINUTE <70
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '15' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='70' AND F_MINUTE <75
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '16' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='75' AND F_MINUTE <80
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE 
UNION ALL
SELECT '17' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='80' AND F_MINUTE <85
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '18' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='85' AND F_MINUTE <90
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate GROUP BY F_VALUE
UNION ALL
SELECT '19' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='90' 
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :cdate AND F_DATE < :edate  GROUP BY F_VALUE  
ORDER BY F_VALUE ASC
";
?>
<div class="graph-container">
<div id="bars99" style="width:690px; height:300px;">
<script type="text/javascript"  id="source">
$(function () {
        var d1 = [
            <?php
                $pdo = new pdodb();
                $pdo->query($sql);
                $pdo->bind(':cdate','2014-08-01');
                $pdo->bind(':edate','2015-05-31');
                $rows = $pdo->rows();
                foreach($rows as $row) {
                    $f1 = $row["F_VALUE"];
                    $f2 = $row["F_CNT"];
            ?>
      [<?php echo $f1; ?>, <?php echo $f2; ?> ],
      <?php   }  ?>
      ['NULL','NULL'] ];

        var d2 = [
            <?php
                $pdo = new pdodb();
                $pdo->query($sql2);
                $pdo->bind(':cdate','2014-08-01');
                $pdo->bind(':edate','2015-05-31');
                $rows = $pdo->rows();
                foreach($rows as $row) {
                    $f21 = $row["F_VALUE"];
                    $f22 = $row["F_CNT"];
            ?>
            [<?php echo $f21; ?>+0.34 , <?php echo $f22; ?> ],
            <?php  }  ?>
      ['NULL','NULL'] ];

//noinspection OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS
		var options = {stack: 0, series: { bars: { active: true, show: true, fill: true, barWidth: 0.29} }
,grid:   { hoverable: true, clickable: true}
,legend:{ position: 'nw', noColumns: 1}
,yaxis: { min: 0, max: 30, ticks: [ 0,2,4,6,8,10,12,14,16,18,20,22,24,26,28,[30, "Goals"] ]}
,xaxis: { min: 1, max:20, ticks: [ 
[01, "0-4"], [02,"5-9"], [03, "10-14"], [04, "15-19" ], [05, "20-24"], [06, "25-29"], [07, "30-34"], 
[08, "35-39"], [09, "40-44"], [10, "45-49"], [11, "50-54"], [12, "55-59"], [13, "60-64"], [14, "65-69"],  [15, "70-74"], [16, "75-79"], [17, "80-84"], [18, "85-89"], [19, "90+"]  ] }
   };

$.plot($("#bars99"), 
         [{
		label: "Goals For",     
		data: d1
	} ,
	{	
		label: "Goals Against", 
		data: d2
	}]
	,  options );  }
     );
</script>
</div>
</div>
<div style="clear:both;"><p>&nbsp;</p></div>
<h3>All Competitions and Seasons since 2009/10</h3>
<?php
$sql="
SELECT '01' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE <'5' 
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '02' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='5' AND F_MINUTE <10
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE  
UNION ALL
SELECT '03' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='10' AND F_MINUTE <15
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '04' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='15' AND F_MINUTE <20
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '05' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='20' AND F_MINUTE <25
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '06' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='25' AND F_MINUTE <30
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '07' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='30' AND F_MINUTE <35
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE  
UNION ALL
SELECT '08' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='35' AND F_MINUTE <40
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '09' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='40' AND F_MINUTE <45
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '10' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='45' AND F_MINUTE <50
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '11' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='50' AND F_MINUTE <55
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '12' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='55' AND F_MINUTE <60
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '13' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='60' AND F_MINUTE <65
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '14' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='65' AND F_MINUTE <70
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '15' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='70' AND F_MINUTE <75
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '16' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='75' AND F_MINUTE <80
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE 
UNION ALL
SELECT '17' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='80' AND F_MINUTE <85
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '18' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='85' AND F_MINUTE <90
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '19' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='90' 
AND F_TEAM='1' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE  
ORDER BY F_VALUE ASC
";

$sql2="
SELECT '01' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE <'5' 
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '02' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='5' AND F_MINUTE <10
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE  
UNION ALL
SELECT '03' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='10' AND F_MINUTE <15
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '04' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='15' AND F_MINUTE <20
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '05' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='20' AND F_MINUTE <25
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '06' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='25' AND F_MINUTE <30
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '07' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='30' AND F_MINUTE <35
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE  
UNION ALL
SELECT '08' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='35' AND F_MINUTE <40
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '09' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='40' AND F_MINUTE <45
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '10' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='45' AND F_MINUTE <50
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '11' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='50' AND F_MINUTE <55
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '12' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='55' AND F_MINUTE <60
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '13' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='60' AND F_MINUTE <65
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '14' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='65' AND F_MINUTE <70
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '15' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='70' AND F_MINUTE <75
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '16' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='75' AND F_MINUTE <80
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE 
UNION ALL
SELECT '17' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='80' AND F_MINUTE <85
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '18' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='85' AND F_MINUTE <90
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate GROUP BY F_VALUE
UNION ALL
SELECT '19' AS F_VALUE, COUNT(*) AS F_CNT FROM cfc_fixture_events where F_MINUTE >='90' 
AND F_TEAM='0' AND F_EVENT IN ('GOAL', 'PKGOAL', 'OGOAL') AND F_DATE > :ddate  GROUP BY F_VALUE  
ORDER BY F_VALUE ASC
";
?>
<div class="graph-container">
<div id="bars" style="width:690px; height:400px;">
<script type="text/javascript"  id="source">
$(function () {
        var d1 = [
            <?php
                $pdo = new pdodb();
                $pdo->query($sql);
                $pdo->bind(':ddate','2009-08-01');
                $rows = $pdo->rows();
                foreach($rows as $row) {
                    $f1 = $row["F_VALUE"];
                    $f2 = $row["F_CNT"];
            ?>
            [<?php echo $f1; ?>, <?php echo $f2; ?> ],
            <?php   }  ?>
            ['NULL','NULL'] ];

        var d2 = [
            <?php
                $pdo = new pdodb();
                $pdo->query($sql2);
                $pdo->bind(':ddate','2009-08-01');
                $rows = $pdo->rows();
                foreach($rows as $row) {
                    $f21 = $row["F_VALUE"];
                    $f22 = $row["F_CNT"];
            ?>
            [<?php echo $f21; ?>+0.34 , <?php echo $f22; ?> ],
            <?php  }  ?>
            ['NULL','NULL'] ];

//noinspection OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS,OctalIntegerJS
		var options = {stack: 0, series: { bars: { active: true, show: true, fill: true, barWidth: 0.29} }
,grid:   { hoverable: true, clickable: true}
,legend:{ position: 'nw', noColumns: 1}
,yaxis: { min: 0, max: 76, ticks: [ 0,2,4,6,8,10,12,14,16,18,20,22,24,26,28,30,32,34,36,38,40,42,44,46,48,50,52,54,56,58,60,62,64,66,68,70,72,74,[76, "Goals"] ]}
,xaxis: { min: 1, max:20, ticks: [ 
[01, "0-4"], [02,"5-9"], [03, "10-14"], [04, "15-19" ], [05, "20-24"], [06, "25-29"], [07, "30-34"], 
[08, "35-39"], [09, "40-44"], [10, "45-49"], [11, "50-54"], [12, "55-59"], [13, "60-64"], [14, "65-69"],  [15, "70-74"], [16, "75-79"], [17, "80-84"], [18, "85-89"], [19, "90+"]  ] }
   };

$.plot($("#bars"), 
         [{
		label: "Goals For",     
		data: d1
	} ,
	{	
		label: "Goals Against", 
		data: d2
	}]
	,  options );  }
     );
</script>
</div>
</div>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<script src="/media/themes/ChelseaStats/js/jquery.flot.grow.js" type="text/javascript"></script>
<?php get_footer(); ?>
