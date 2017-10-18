<?php /* Template Name: # U Monthly */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<?php
$cc=$_GET['comp'];
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) { 

    $wcc = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM wsl_fixtures WHERE F_RESULT='W' AND F_COMPETITION = :cc GROUP BY F_MONTH, F_RESULT";

    $w = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM wsl_fixtures WHERE F_RESULT='W' GROUP BY F_MONTH, F_RESULT";

    $dcc = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM wsl_fixtures WHERE F_RESULT='D'  AND F_COMPETITION = :cc GROUP BY F_MONTH, F_RESULT";

    $d = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM wsl_fixtures WHERE F_RESULT='D' GROUP BY F_MONTH, F_RESULT";

    $lcc = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM wsl_fixtures WHERE F_RESULT='L'  AND F_COMPETITION = :cc GROUP BY F_MONTH, F_RESULT";

    $l = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM wsl_fixtures WHERE F_RESULT='L' GROUP BY F_MONTH, F_RESULT";

    $sqlcc = "SELECT MONTHNAME(STR_TO_DATE(MONTH(F_DATE) , '%m')) as F_MONTHNAME,
        SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,   ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
        SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,  ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
        SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES, ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
        SUM(IF(F_RESULT IS NOT NULL=1,1,0)) AS F_TOTAL FROM wsl_fixtures  WHERE F_COMPETITION='$cc' GROUP BY MONTH(F_DATE) ORDER BY MONTH(F_DATE) asc";

    $sql = "SELECT MONTHNAME(STR_TO_DATE(MONTH(F_DATE) , '%m')) as F_MONTHNAME,
        SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,   ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
        SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,  ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
        SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES, ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
        SUM(IF(F_RESULT IS NOT NULL=1,1,0)) AS F_TOTAL FROM wsl_fixtures GROUP BY MONTH(F_DATE) ORDER BY MONTH(F_DATE) asc";

    $sql2004cc = "SELECT MONTHNAME(STR_TO_DATE(MONTH(F_DATE) , '%m')) as F_MONTHNAME,
        SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,   ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
        SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,  ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
        SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES, ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
        SUM(IF(F_RESULT IS NOT NULL=1,1,0)) AS F_TOTAL FROM wsl_fixtures  WHERE F_COMPETITION='$cc' AND F_DATE > '2004-06-01' GROUP BY MONTH(F_DATE) ORDER BY MONTH(F_DATE) asc";

    $sql2004 = "SELECT MONTHNAME(STR_TO_DATE(MONTH(F_DATE) , '%m')) as F_MONTHNAME,
        SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,   ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
        SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,  ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
        SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES, ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
        SUM(IF(F_RESULT IS NOT NULL=1,1,0)) AS F_TOTAL FROM wsl_fixtures WHERE F_DATE > '2004-06-01' GROUP BY MONTH(F_DATE) ORDER BY MONTH(F_DATE) asc";
?>
<h4 class="special">Chelsea Ladies Monthly Results Record for <?php if (isset($cc))  { echo "$cc "; } else { echo "All Competitions "; } ?></h4>
    <p>All Chelsea Ladies' results grouped by Month with competition filter. The first table shows all results the second all results from the start of the 2004 season.</p>
    <div class="row-fluid">
        <div class="span4 offset8">
            <div id="filter-2" class="widget widget_archive">
      		<span class="form-filter">
                <select name="filter-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
                    <option value="">Competition Filter</option>
                    <option value="<?php the_permalink() ?>?comp=WSL">Women's Super League</option>
                    <option value="<?php the_permalink() ?>?comp=PREM">Women's Premier League</option>
                    <option value="<?php the_permalink() ?>?comp=FAC">Women's FA Cup</option>
                    <option value="<?php the_permalink() ?>?comp=LC" >Women's League Cup</option>
                    <option value="<?php the_permalink() ?>?comp=CONTINENTAL%20CUP" >Women's Continental Cup</option>
                </select>
                </span>
            </div>
        </div>
    </div>
<?php    
} else {

    $wcc = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM cfc_fixtures WHERE F_RESULT='W' AND F_COMPETITION = :cc GROUP BY F_MONTH, F_RESULT";

    $w = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM cfc_fixtures WHERE F_RESULT='W' GROUP BY F_MONTH, F_RESULT";

    $dcc = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM cfc_fixtures WHERE F_RESULT='D'  AND F_COMPETITION = :cc GROUP BY F_MONTH, F_RESULT";

    $d = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM cfc_fixtures WHERE F_RESULT='D' GROUP BY F_MONTH, F_RESULT";

    $lcc = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM cfc_fixtures WHERE F_RESULT='L'  AND F_COMPETITION = :cc GROUP BY F_MONTH, F_RESULT";

    $l = "SELECT MONTH(F_DATE) AS F_MONTH, COUNT(F_RESULT) AS F_COUNT FROM cfc_fixtures WHERE F_RESULT='L' GROUP BY F_MONTH, F_RESULT";

    $sqlcc = "SELECT MONTHNAME(STR_TO_DATE(MONTH(F_DATE) , '%m')) as F_MONTHNAME,
        SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,   ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
        SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,  ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
        SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES, ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
        SUM(IF(F_RESULT IS NOT NULL=1,1,0)) AS F_TOTAL FROM cfc_fixtures  WHERE F_COMPETITION='$cc' GROUP BY MONTH(F_DATE) ORDER BY MONTH(F_DATE) asc";

    $sql = "SELECT MONTHNAME(STR_TO_DATE(MONTH(F_DATE) , '%m')) as F_MONTHNAME,
        SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,   ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
        SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,  ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
        SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES, ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
        SUM(IF(F_RESULT IS NOT NULL=1,1,0)) AS F_TOTAL FROM cfc_fixtures GROUP BY MONTH(F_DATE) ORDER BY MONTH(F_DATE) asc";

    $sql2004cc = "SELECT MONTHNAME(STR_TO_DATE(MONTH(F_DATE) , '%m')) as F_MONTHNAME,
        SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,   ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
        SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,  ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
        SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES, ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
        SUM(IF(F_RESULT IS NOT NULL=1,1,0)) AS F_TOTAL FROM cfc_fixtures  WHERE F_COMPETITION='$cc' AND F_DATE > '2004-06-01' GROUP BY MONTH(F_DATE) ORDER BY MONTH(F_DATE) asc";

    $sql2004 = "SELECT MONTHNAME(STR_TO_DATE(MONTH(F_DATE) , '%m')) as F_MONTHNAME,
        SUM(IF(F_RESULT='W'=1,1,0)) AS F_WINS,   ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_WINPER,
        SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAWS,  ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_DRAWPER,
        SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSSES, ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS F_LOSSPER,
        SUM(IF(F_RESULT IS NOT NULL=1,1,0)) AS F_TOTAL FROM cfc_fixtures WHERE F_DATE > '2004-06-01' GROUP BY MONTH(F_DATE) ORDER BY MONTH(F_DATE) asc";
?>
<h4 class="special">Chelsea - Monthly Results Record for <?php if (isset($cc))  { echo "$cc "; } else { echo "All Competitions "; } ?></h4>
    <p>All Chelsea's results grouped by Month with competition filter. The first table shows all results the second all results from the start of the 2004 season.</p></p>
    <div class="row-fluid">
        <div class="span4 offset8">
            <div id="filter-2" class="widget widget_archive">
      		<span class="form-filter">
                <select name="filter-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
                    <option value="">Competition Filter</option>
                    <option value="" class="bolder"> -- League -- </option>
                    <option value="<?php the_permalink() ?>?comp=PREM">Premier League</option>
                    <option value="<?php the_permalink() ?>?comp=DIV1OLD">Division 1 (old)</option>
                    <option value="<?php the_permalink() ?>?comp=DIV2OLD">Division 2 (old)</option>
                    <option value="" class="bolder"> -- Europe -- </option>
                    <option value="<?php the_permalink() ?>?comp=UCL">UEFA Champions League</option>
                    <option value="<?php the_permalink() ?>?comp=UEFAC">UEFA Cup</option>
                    <option value="<?php the_permalink() ?>?comp=ECWC">European Cup Winners Cup</option>
                    <option value="<?php the_permalink() ?>?comp=ESC">European Super Cup</option>
                    <option value="" class="bolder"> -- Cups -- </option>
                    <option value="<?php the_permalink() ?>?comp=FAC">FA Cup</option>
                    <option value="<?php the_permalink() ?>?comp=LC">League Cup</option>
                    <option value="<?php the_permalink() ?>?comp=CS">Charity/Community Shield</option>
                    <option value="<?php the_permalink() ?>?comp=FAIRS">Fairs Cup</option>
                    <option value="<?php the_permalink() ?>?comp=FMC">Full Members cup</option>
                </select>
                </span>
            </div>
        </div>
    </div>
<?php } ?>
<h3>Results by Month Graph</h3>
<div class="graph-container">
  <div id="bars" style="width:690px;height:400px;">
<script id="source"  type="text/javascript">
$(function () {

 var d1 = [ 
    <?php
        // Results processing

        if (isset($cc)) {
             $pdo = new pdodb();
             $pdo->query($wcc);
             $pdo->bind(':cc',$cc);
             $rows = $pdo->rows();
             } else {
             $pdo = new pdodb();
             $pdo->query($w);
             $rows = $pdo->rows();
             }
             foreach($rows as $row) {
                $f51 = $row["F_MONTH"];
                $f52 = $row["F_COUNT"];
    ?>
[<?php echo $f51; ?>, <?php echo $f52; ?> ],;
<?php  }  ?>
<?php print ",['NULL','NULL'] ] "; ?>

 //noinspection UnterminatedStatementJS
		var d2 = [ 
    <?php
        // Results processing
        if (isset($cc)) {
             $pdo = new pdodb();
             $pdo->query($dcc);
             $pdo->bind(':cc',$cc);
             $rows = $pdo->rows();
             } else {
             $pdo = new pdodb();
             $pdo->query($d);
             $rows = $pdo->rows();
             }
             foreach($rows as $row) {
                $f61 = $row["F_MONTH"];
                $f62 = $row["F_COUNT"];
    ?>
[<?php echo $f61; ?>.3, <?php echo $f62; ?> ],
<?php  }  ?>
<?php print ",['NULL','NULL'] ] "; ?>


 //noinspection UnterminatedStatementJS
		var d3 = [
     <?php
         // Results processing
         if (isset($cc)) {
              $pdo = new pdodb();
              $pdo->query($lcc);
              $pdo->bind(':cc',$cc);
              $rows = $pdo->rows();
              } else {
              $pdo = new pdodb();
              $pdo->query($l);
              $rows = $pdo->rows();
              }
              foreach($rows as $row) {
                $f71 = $row["F_MONTH"];
                $f72 = $row["F_COUNT"];
     ?>
[<?php echo $f71; ?>.6, <?php echo $f72; ?> ],
<?php }  ?>
<?php print ",['NULL','NULL'] ] "; ?>

var options = {stack: 0, series: { bars: { active: true, show: true, fill: true, barWidth: 0.25} }
,grid:   { hoverable: true, clickable: true}
,legend:{ position: 'ne', noColumns: 3}
,yaxis: { min: 0, max: 300, ticks: [ 0,25,50,75,100,125,150,175,200,225,250,275,300 ]}
,xaxis: { min: 1, max:13, ticks: [ [1, "Jan"], [2,"Feb"], [3, "Mar"], [4, "Apr" ], [5, "May"], [6, "Jun"], [7, "Jul"], [8, "Aug"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dec"], [13, " "] ] }
   };

$.plot($("#bars"), [ {label: "Wins by Month", data: d1}, {label: "Draws by Month", data: d2}, {label: "Losses by Month", data: d3}  ],  options );  }
     );
</script>
</div>
</div>
<br/>
<h3>Results by Month (all Time)</h3>
<?php 
if (isset($cc)) {
    //================================================================================
    outputDataTable( $sqlcc, 'monthly');
    //================================================================================
} else {
    //================================================================================
    outputDataTable( $sql, 'monthly');
    //================================================================================
}
?>
<h3>Results by Month (Since 2004)</h3>
<?php 
if (isset($cc))  {
    //================================================================================
    outputDataTable( $sql2004cc, 'm04');
    //================================================================================
} else  {
    //================================================================================
    outputDataTable( $sql2004, 'm04');
    //================================================================================
}
?>
<div style="clear:both;"><p>&nbsp;</p></div>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
