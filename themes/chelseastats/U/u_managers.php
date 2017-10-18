<?php /* Template Name: # U Managers */ ?>
<?php get_header(); ?>
<div id="content">
<?php
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) { 
$title = 'Chelsea Ladies Managers';
$mgrsql = "SELECT F_ORDER, F_SNAME AS L_SURNAME, S_DATE, E_DATE, PLD, W, D, L, F_FOR, F_AGAINST, GD, FS, CS, F_WINPER, F_UNDER, PTS, PPG, F_TROPHIES FROM 0V_base_mgr
           WHERE F_TYPE='WSL' GROUP BY F_ORDER ORDER BY F_ORDER DESC";
$sql1 = "SELECT F_ORDER, F_WINPER FROM 0V_base_mgr WHERE F_TYPE='WSL' ORDER BY F_ORDER ASC";
$sql2 = "SELECT F_ORDER, F_UNDER  FROM 0V_base_mgr WHERE F_TYPE='WSL' ORDER BY F_ORDER ASC";
$sql3 = "SELECT F_ORDER, PLD      FROM 0V_base_mgr WHERE F_TYPE='WSL' ORDER BY F_ORDER ASC";

} else {
$title = 'Chelsea Managers';
$mgrsql = "SELECT F_ORDER, F_SNAME AS F_SURNAME, S_DATE, E_DATE, PLD, W, D, L, F_FOR, F_AGAINST, GD, FS, CS, F_WINPER, F_UNDER, PTS, PPG, F_TROPHIES FROM 0V_base_mgr
           WHERE F_TYPE='CFC' GROUP BY F_ORDER ORDER BY F_ORDER DESC";
$sql1 = "SELECT F_ORDER, F_WINPER FROM 0V_base_mgr WHERE F_TYPE='CFC' ORDER BY F_ORDER ASC";
$sql2 = "SELECT F_ORDER, F_UNDER  FROM 0V_base_mgr WHERE F_TYPE='CFC' ORDER BY F_ORDER ASC";
$sql3 = "SELECT F_ORDER, PLD      FROM 0V_base_mgr WHERE F_TYPE='CFC' ORDER BY F_ORDER ASC";

}
?>
<h4 class="special"><?php echo $title; ?> - Results analysis</h4>
<?php print $go->getTableKey(); ?>
<h3>Games Managed, Win and Undefeated Percentages</h3>
<div class="graph-container">
<div id="placeholder" style="width:960px; height:250px;">
<script type="text/javascript"  id="source">
$(function () {
  var d1 = [
<?php
    $pdo = new pdodb();
    $pdo->query($sql1);
    $rows = $pdo->rows();
    foreach ($rows as $row) {
        $f11 = $row["F_ORDER"];
        $f12 = $row["F_WINPER"];
?>
[<?php echo $f11; ?>, <?php echo $f12; ?> ],
<?php  } ?>
['NULL','NULL'] ];

var d2 = [
<?php
    $pdo = new pdodb();
    $pdo->query($sql2);
    $rows = $pdo->rows();
    foreach ($rows as $row) {
        $f21 = $row["F_ORDER"];
        $f22 = $row["F_UNDER"];
?>
[<?php echo $f21; ?>, <?php echo $f22; ?> ],
<?php } ?>
['NULL','NULL'] ];

var d3 = [
<?php
    $pdo = new pdodb();
    $pdo->query($sql3);
    $rows = $pdo->rows();
    foreach ($rows as $row) {
        $f31 = $row["F_ORDER"];
        $f32 = $row["PLD"];
?>
[<?php echo $f31; ?>, <?php echo $f32; ?> ],
<?php ; } ?>
['NULL','NULL'] ];


  $.plot($("#placeholder"),
          [ 
{ data: d3, label: "Games", bars: { show: true, align:"center", barWidth:0.6  }},
{ data: d1, label: "win %", lines: { show: true }, points: {show:true}, yaxis:2},
{ data: d2, label: "Undefeated %", color: '#666666', lines: { show: true }, points: {show:true}, yaxis:2 }
          ],
            { 
    y2axis: { min:0, max:130, ticks: [00, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100, [110, "%"], [120, " "], [130, " "] ] },
    yaxis: { min:0, max:1300, ticks: [00, 100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300 ] },
    xaxis: { min:0, max: 37, ticks: [ [0, " "] , 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24,25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, [37, " "] ] },
    legend:{ position: 'nw', noColumns: 3},
    grid: {hoverable:true, clickable:true},
    tooltip: true
            }
		);
				}
	);


</script>
</div>
</div>
<h3>Managerial Analysis: Managerial Performance</h3>
<?php 
//================================================================================
 outputDataTable( $mgrsql, 'Managers');
//================================================================================
?>
<div style="clear:both;"><p>&nbsp;</p></div>
</div>
<script src="/media/themes/ChelseaStats/js/jquery.flot.grow.js" type="text/javascript"></script>
<?php get_footer(); ?>
