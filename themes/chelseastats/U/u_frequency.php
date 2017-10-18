<?php /* Template Name: # U Frequency */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<?php
$opp=$_GET['team']; 
if (isset($opp)) { 
$qa = $go->_Q($opp);
$va = $go->_V($opp);
}
$page = get_permalink($post->ID);
	if (strpos($page,'ladies') !== false) {
	?>
	<h4 class="special">Chelsea Ladies - Results frequency in the all competitions against :
		<?php if ( isset( $va ) ) { echo " $va"; } else { echo " All teams "; } ?></h4>
	<?php } else {  ?>
	<h4 class="special">Chelsea - Results frequency in the all competitions against :
		<?php if (isset($va))  { echo " $va"; } else { echo " All teams "; } ?></h4>
	<?php } ?>

<div class="row-fluid">
  <div class="span4 offset8">
      <div id="filter-2" class="widget widget_archive">
      		<span class="form-filter">
                    <select name="filter-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
	                    <option value="">Team Filter</option>
	                    <?php
	                    if (strpos($page,'ladies') !== false) {
		                    $dropquery="SELECT DISTINCT F_OPP FROM wsl_fixtures WHERE F_OPP IS NOT NULL ORDER BY F_OPP ASC";
	                    } else {
		                    $dropquery="SELECT DISTINCT F_OPP FROM cfc_fixtures WHERE F_OPP IS NOT NULL ORDER BY F_OPP ASC";
	                    }
	                    $pdo = new pdodb();
	                    $pdo->query($dropquery);
	                    $rows = $pdo->rows();

	                    foreach($rows as $row){
		                    $vt_form = $go->_V($row['F_OPP']);
		                    $qt_form = $go->_Q($row['F_OPP']);
		                    ?>
		                    <option value="<?php the_permalink() ?>?team=<?php echo $qt_form; ?>"><?php echo $vt_form; ?></option>
	                    <?php
	                    }
	                    ?>
                    </select>
	        </span>
    </div>
  </div>
</div>

<h3>Summary</h3>
<div class="graph-container">
  <div id="bubbles" style="width:690px;height:400px;">
<script id="source"  type="text/javascript">
$(function () {

<?php
	print 'var d1 = [ ';

if (strpos($page,'ladies') !== false) {

$pdo = new pdodb();

	if (isset($opp)) {
		$pdo->query("SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT FROM wsl_fixtures  WHERE F_OPP=:qa GROUP BY F_FOR, F_AGAINST");
		$pdo->bind(':qa',$qa);
	} else {
		$pdo->query("SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT FROM wsl_fixtures GROUP BY F_FOR, F_AGAINST");
	}

} else {

	if (isset($opp)) {
		$pdo->query("SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT FROM cfc_fixtures WHERE F_OPP=:qa GROUP BY F_FOR, F_AGAINST");
		$pdo->bind(':qa',$qa);
	} else {
		$pdo->query("SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT FROM cfc_fixtures GROUP BY F_FOR, F_AGAINST");
	}

}
	$rows = $pdo->rows();

	foreach($rows as $row) {

			$f11 = $row["F_FOR"];
			$f12 = $row["F_AGAINST"];
			$f13 = $row["F_COUNT"];

			$f13a = ( $f13 * 2 ) / 31.4529;
			$f13b = ( $f13 * 2 ) / 314.529;

			if (isset($opp))  {
			 print '['.$f11.','.$f12.','.$f13a.' ],';
			 } else {
			 print '['.$f11.','.$f12.','.$f13b.' ],';
			 }
   }
?>
<?php print "['NULL', 'NULL', 'NULL'] ];";?>

var options = { series: 
 { grow: {active: false }, bubbles: { active: true, show: true, fill: false, lineWidth: 2 } }
,grid:   { hoverable: true, clickable: true}
,legend:{ position: 'ne'}
,yaxis: { min: -1, max:9, ticks: [ [-1," "],0,1,2,3,4,5,6,7,8, [9, 'Against'] ] }
,xaxis: { min: -1, max:14, ticks: [ [-1," "],0,1,2,3,4,5,6,7,8,9,10,11,12,13, [14, 'For'] ] }
,tooltip: true
   };

$.plot($("#bubbles"), [ {label: "Size in order of occurrences", data: d1} ], 
                         options );
                         }
     );
</script>
</div>
</div>
<p>The size of the blobs indicate the frequency of the result, the larger the blob the higher the count of that result. Overtime the less common results 13-0 for example will disappear but can be shown when looking at detail by team.</p>
<h3>Results Frequency: Goals For and Against Table </h3>
<?php
if (strpos($page,'ladies') !== false) {
	$base = 'wsl_fixtures';
}  else {
	$base = 'cfc_fixtures';
}

if (isset($opp)) 
{ 
//================================================================================
$sql = "SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT, ROUND((count(*)/(select count(*) from $base where F_OPP='$qa'))*100,3) as F_PER FROM $base
WHERE F_OPP='$qa' GROUP BY F_FOR, F_AGAINST ORDER BY F_COUNT DESC";
 outputDataTable( $sql, 'Month by Month');
//================================================================================
}
else
{ 
//================================================================================
$sql = "SELECT F_FOR, F_AGAINST, count(*) AS F_COUNT, ROUND((count(*)/(Select count(*) from $base))*100,3) as F_PER FROM $base
GROUP BY F_FOR, F_AGAINST ORDER BY F_COUNT DESC";
 outputDataTable( $sql, 'Month by Month');
//================================================================================
}
?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
