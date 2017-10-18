<?php /* Template Name: # D Finance */ ?>
<?php get_header(); ?>
<div id="content">
<h4 class="special">Chelsea Key Financial Statistics</h4>
<p>Historical financial statistics for both the Limited company and PLC as submitted to Companies House.</p>
<h3>Chelsea Football Club Limited (&pound;M)</h3>
<div class="graph-container">
<div id="placeholder0" style="width:960px;height:250px">
<script type="text/javascript"  id="source">
$(function () {
   var d1 = [ 
    <?php
    $pdo = new pdodb();
    $pdo->query("SELECT F_YEAR, F_PL FROM cfc_finances WHERE F_COMPANY='CFC LTD' ORDER BY F_YEAR ASC");
    $rows = $pdo->rows();
    foreach ($rows as $row) {
        $f11 = $row["F_YEAR"];
        $f12 = $row["F_PL"];
    ?>
[<?php echo $f11; ?>, <?php echo $f12; ?> ],
<?php } ?>
    ['2016','NULL'] ];


 var d2 = [
     <?php
     $pdo = new pdodb();
     $pdo->query("SELECT F_YEAR, F_TURNOVER FROM cfc_finances WHERE F_COMPANY='CFC LTD' ORDER BY F_YEAR ASC");
     $rows = $pdo->rows();
     foreach ($rows as $row) {
         $f21 = $row["F_YEAR"];
         $f22 = $row["F_TURNOVER"];
     ?>
     [<?php echo $f21; ?>, <?php echo $f22; ?> ],
     <?php } ?>
    ['2016','NULL'] ];


 var d3 = [
     <?php
     $pdo = new pdodb();
     $pdo->query("SELECT F_YEAR, F_WAGE FROM cfc_finances WHERE F_COMPANY='CFC LTD' ORDER BY F_YEAR ASC");
     $rows = $pdo->rows();
     foreach ($rows as $row) {
         $f31 = $row["F_YEAR"];
         $f32 = $row["F_WAGE"];
     ?>
     [<?php echo $f31; ?>, <?php echo $f32; ?> ],
     <?php } ?>
     ['2016','NULL'] ];

 $.plot($("#placeholder0"), [
        {
            label: "CFC LTD Profit/Loss", data: d1,
            lines: { show: true}, points: { show: true }
        },
  {
            label: "CFC LTD Turnover", data: d2,
            lines: { show: true}, points: { show: true }
        },
  {
            label: "CFC LTD Wages", data: d3,
            lines: { show: true}, points: { show: true }
        }
			   ],

{
legend: { position: 'se', noColumns: 3 },
xaxis: { ticks: [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016 ] },
yaxis: { ticks: [ [-250,"-250m"], [-200,"-200m"], [-150 ,"-150m"], [-100,"-100m"], [-50,"-50m"],[0,"0m"], [50,"50m"], [100,"100m"], [150,"150m"], [200,"200m"], [250,"250m"], [300,"300m"], [350,"350m"], [400,"400m"] ] } 
}
);
});
</script>
</div>
</div>
<h3>Financial Analysis: Key Financial Statistics by Year - Chelsea Football Club Limited</h3>
<?php 
// Perform Query
$query="SELECT * from cfc_finances where F_COMPANY='CFC LTD' order by F_YEAR DESC";
$pdo = new pdodb();
$pdo->query($query);
$rows = $pdo->rows();
?>
<div class="table-container">
<table width="100%" class="tablesorter">
<thead>
<tr>
<th WIDTH="50px" >Year</th>
<th>Turnover</th>
<th>Profit/Loss</th>
<th>Wages</th>
<th>STRGL*</th>
<th>Wages/Turnover</th>
<th>Playing Staff</th>
<th>Non-Playing Staff</th>
<th>Total Staff</th>
<th>Average Wage</th>
</tr>
</thead>
<tbody>
<?php
        foreach ($rows as $row) {
            $f01 = $row["F_YEAR"];
            $f02 = $row["F_TURNOVER"];
            $f03 = $row["F_PL"];
            $f04 = $row["F_WAGE"];
            $f05 = $row["F_STRGL"];
            $f06 = $row["F_RATIO"];
            $f07 = $row["F_PLAYSTAFF"];
            $f08 = $row["F_NONPSTAFF"];
            $f09 = $row["F_TOTSTAFF"];
            $f10 = $row["F_AVGSAL"];
            ?>
            <tr>
            <td align="right"><?php echo $f01; ?></td>
            <td align="right" class="nowrap"><nobr>&pound; <?php echo $f02; ?> m</nobr></td>
            <td align="right" class="nowrap"><nobr>&pound; <?php echo $f03; ?> m</nobr></td>
            <td align="right" class="nowrap"><nobr>&pound; <?php echo $f04; ?> m</nobr></td>
            <td align="right" class="nowrap"><nobr>&pound; <?php echo $f05; ?> m</nobr></td>
            <td align="right"><?php echo $f06; ?></td>
            <td align="right"><?php echo $f07; ?></td>
            <td align="right"><?php echo $f08; ?></td>
            <td align="right"><?php echo $f09; ?></td>
            <td align="right" class="nowrap"><nobr>&pound; <?php echo $f10; ?> m</nobr></td>
            </tr>
<?php } ?>
</tbody></table>
</div>
<h3> Chelsea PLC (&pound;M)</h3>
<div class="graph-container">
<div id="placeholder1" style="width:960px;height:250px">
<script type="text/javascript"  id="source">
$(function () {
   var d1 = [ 
    <?php
    $pdo = new pdodb();
    $pdo->query("SELECT F_YEAR, F_PL FROM cfc_finances WHERE F_COMPANY='CFC PLC' ORDER BY F_YEAR ASC");
    $rows = $pdo->rows();
    foreach($rows as $row) {
            $f11 = $row["F_YEAR"];
            $f12 = $row["F_PL"];
    ?>
    [<?php echo $f11; ?>, <?php echo $f12; ?> ],
    <?php } ?>
    ['2016','NULL'] ];


 var d2 = [
     <?php
     $pdo = new pdodb();
     $pdo->query("SELECT F_YEAR, F_TURNOVER FROM cfc_finances WHERE F_COMPANY='CFC PLC' ORDER BY F_YEAR ASC");
     $rows = $pdo->rows();
     foreach($rows as $row) {
             $f21 = $row["F_YEAR"];
             $f22 = $row["F_TURNOVER"];
     ?>
    [<?php echo $f21; ?>, <?php echo $f22; ?> ],
    <?php } ?>
    ['2016','NULL'] ];


 var d3 = [
     <?php
     $pdo = new pdodb();
     $pdo->query("SELECT F_YEAR, F_WAGE FROM cfc_finances WHERE F_COMPANY='CFC PLC' ORDER BY F_YEAR ASC");
     $rows = $pdo->rows();
     foreach($rows as $row) {
             $f31 = $row["F_YEAR"];
             $f32 = $row["F_WAGE"];
     ?>
     [<?php echo $f31; ?>, <?php echo $f32; ?> ],
     <?php } ?>
     ['2016','NULL'] ];

 $.plot($("#placeholder1"), [
        {
            label: "CFC PLC Profit/Loss", data: d1,
            lines: { show: true}, points: { show: true }
        },
  {
            label: "CFC PLC Turnover", data: d2,
            lines: { show: true}, points: { show: true }
        },
  {
            label: "CFC PLC Wages", data: d3,
            lines: { show: true}, points: { show: true }
        }
			   ],

{
legend: { position: 'se', noColumns: 3 },
xaxis: { ticks: [2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016 ] },
yaxis: { ticks: [ [-250,"-250m"], [-200,"-200m"], [-150 ,"-150m"], [-100,"-100m"], [-50,"-50m"],[0,"0m"], [50,"50m"], [100,"100m"], [150,"150m"], [200,"200m"], [250,"250m"], [300,"300m"], [350,"350m"], [400,"400m"] ] } 
}
);
});
</script>
</div>
</div>
<h3>Financial Analysis: Key Finance Statistics by Year - Chelsea FC PLC</h3>
<div class="table-container">
<?php 
        $pdo = new pdodb();
        $pdo->query("SELECT * from cfc_finances where F_COMPANY='CFC PLC' order by F_YEAR DESC");
        $rows = $pdo->rows();

echo "<table width=\"100%\" cellpadding=\"1px\" cellspacing=\"1px\" id=\"tablesorter finance\" class=\"tablesorter\">
<thead>
<tr class=\"trheader\">
<th WIDTH=\"50px\" >Year</th>
<th>Turnover</th>
<th>Profit/Loss</th>
<th>Wages</th>
<th>STRGL *</th>
<th>Wages/Turnover</th>
<th>Playing Staff</th>
<th>Non-Playing Staff</th>
<th>Total Staff</th>
<th>Average Wage</th>
</tr></thead><tbody>";

        foreach ($rows as $row) {
                $f11 = $row["F_YEAR"];
                $f12 = $row["F_TURNOVER"];
                $f13 = $row["F_PL"];
                $f14 = $row["F_WAGE"];
                $f15 = $row["F_STRGL"];
                $f16 = $row["F_RATIO"];
                $f17 = $row["F_PLAYSTAFF"];
                $f18 = $row["F_NONPSTAFF"];
                $f19 = $row["F_TOTSTAFF"];
                $f20 = $row["F_AVGSAL"];
?>
        <tr>
        <td align="right"><?php echo $f11; ?></td>
        <td align="right" class="nowrap"><nobr>&pound; <?php echo $f12; ?> m</nobr></td>
        <td align="right" class="nowrap"><nobr>&pound; <?php echo $f13; ?> m</nobr></td>
        <td align="right" class="nowrap"><nobr>&pound; <?php echo $f14; ?> m</nobr></td>
        <td align="right" class="nowrap"><nobr>&pound; <?php echo $f15; ?> m</nobr></td>
        <td align="right"><?php echo $f16; ?></td>
        <td align="right"><?php echo $f17; ?></td>
        <td align="right"><?php echo $f18; ?></td>
        <td align="right"><?php echo $f19; ?></td>
        <td align="right" class="nowrap"><nobr>&pound; <?php echo $f20; ?> m</nobr></td>
        </tr>
<?php } ?>
</tbody></table>
</div>
<div class="well well-small">
<p><strong>Notes:</strong></p>
<p>STRGL: Statement of Recognised gains and losses (historical cost loss for year).</p>
<p>Chelsea currently employ approximately 1000 (2014: 600) temporary match day staff not included here.</p>
</div>
<div style="clear:both;"><br/></div>
<!-- The main column ends  -->
</div>
<script src="/media/themes/ChelseaStats/js/jquery.flot.grow.js" type="text/javascript" ></script>
<?php get_footer(); ?>
