<?php /* Template Name: # U Results */ ?>
<?php get_header(); ?>
<div id="content">
<?php
$limit = isset($_GET['show']) ? $_GET['show'] : '38';

$opp    =   $_GET['team'];
if (isset($opp)) { 
$qt = $go->_Q($opp);
$vt = $go->_V($opp);
}
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) {

	$title  = 'Chelsea Ladies';
	$base99 ='wsl_fixtures';
	$view = '0V_base_WRANK';

	if (isset($limit) && $limit!='') {

		$resquery="SELECT CONCAT(F_ID,',',F_DATE) as LX_DATE, F_OPP as L_TEAM, F_COMPETITION as L_COMPETITION, F_LOCATION as LOC, F_RESULT,
		F_FOR, F_AGAINST, F_ATT, F_REF as L_REF, F_NOTES FROM ".$base99." ORDER BY F_DATE DESC LIMIT $limit";
	}

	if (isset($opp)) {

		$resquery="SELECT CONCAT(F_ID,',',F_DATE) as LX_DATE, F_OPP as L_TEAM, F_COMPETITION as L_COMPETITION, F_LOCATION as LOC, F_RESULT,
		F_FOR, F_AGAINST, F_ATT, F_REF as L_REF, F_NOTES FROM ".$base99." WHERE F_OPP='".$qt."' ORDER BY F_DATE DESC";

		$o_rank = "SELECT F_LOC as LOC, F_PLD, F_WINS, F_DRAWS,  F_LOSSES, F_WINPER, F_DRAWPER, F_LOSSPER, F_UNDER, F_CLEAN, F_FAILED, F_FOR, F_AGAINST, F_GFPG, F_GAPG,
		F_GD, F_POINTS, F_PPG FROM $view WHERE Team='".$qt."' order by F_ORDER ASC";

		$pdo = new pdodb();
	    $pdo->query('SELECT F_FOR, F_AGAINST, F_POINTS, A_POINTS FROM 0V_base_WRANK WHERE Team = :team AND F_LOC = :loc ');
	    $pdo->bind(':team', $qt);
	    $pdo->bind(':loc', "TOTAL");
	    $row = $pdo->row();
	    $vF = $row['F_FOR'];
	    $vA = $row['F_AGAINST'];
	    $pF = $row['F_POINTS'];
	    $pA = $row['A_POINTS'];

	} else {

		$resquery="SELECT CONCAT(F_ID,',',F_DATE) as LX_DATE, F_OPP as L_TEAM, F_COMPETITION as L_COMPETITION, F_LOCATION as LOC, F_RESULT,
		F_FOR, F_AGAINST, F_ATT, F_REF as L_REF, F_NOTES FROM ".$base99." ORDER BY F_DATE DESC LIMIT $limit";

		$o_rank = "SELECT F_LOC as LOC, F_PLD, F_WINS, F_DRAWS,  F_LOSSES, F_WINPER, F_DRAWPER, F_LOSSPER, F_UNDER, F_CLEAN, F_FAILED, F_FOR, F_AGAINST, F_GFPG, F_GAPG,
		F_GD, F_POINTS, F_PPG FROM $view WHERE F_KEY='GT' AND Team='ALL' order by F_ORDER ASC";

		$pdo = new pdodb();
	    $pdo->query('SELECT F_FOR, F_AGAINST, F_POINTS, A_POINTS FROM 0V_base_WRANK WHERE F_KEY= :key AND F_LOC= :loc');
	    $pdo->bind(':key' , "GT");
	    $pdo->bind(':loc', "TOTAL");
	    $row = $pdo->row();
	    $vF = $row['F_FOR'];
	    $vA = $row['F_AGAINST'];
	    $pF = $row['F_POINTS'];
	    $pA = $row['A_POINTS'];
	}

} else {

	$title  = 'Chelsea';
	$base99 ='cfc_fixtures';
	$view = '0V_base_GRANK';

	if (isset($limit) && $limit!='') {

		$resquery="SELECT CONCAT(F_ID,',',F_DATE) as MX_DATE, F_OPP as F_TEAM, F_COMPETITION, F_LOCATION as LOC, F_RESULT,
					F_FOR, F_AGAINST, F_ATT, F_REF, F_NOTES FROM ".$base99." ORDER BY F_DATE DESC LIMIT $limit";
	}

	if (isset($opp)) {
		$resquery="SELECT CONCAT(F_ID,',',F_DATE) as MX_DATE, F_OPP as F_TEAM, F_COMPETITION, F_LOCATION as LOC,  F_RESULT,
		F_FOR, F_AGAINST, F_ATT, F_REF, F_NOTES FROM ".$base99." WHERE F_OPP='".$qt."' ORDER BY F_DATE DESC LIMIT $limit";

		$o_rank = "SELECT F_LOC as LOC, F_PLD, F_WINS, F_DRAWS,  F_LOSSES, F_WINPER, F_DRAWPER, F_LOSSPER, F_UNDER, F_CLEAN, F_FAILED, F_FOR, F_AGAINST, F_GFPG, F_GAPG,
		F_GD, F_POINTS, F_PPG FROM $view WHERE Team='".$qt."' order by F_ORDER ASC";

		$pdo = new pdodb();
	    $pdo->query('SELECT F_FOR, F_AGAINST, F_POINTS, A_POINTS FROM 0V_base_GRANK WHERE Team = :team AND F_LOC = :loc ');
	    $pdo->bind(':team', $qt);
	    $pdo->bind(':loc', "TOTAL");
	    $row = $pdo->row();
	    $vF = $row['F_FOR'];
	    $vA = $row['F_AGAINST'];
	    $pF = $row['F_POINTS'];
	    $pA = $row['A_POINTS'];

	} else {

		$resquery="SELECT CONCAT(F_ID,',',F_DATE) as MX_DATE, F_OPP as F_TEAM, F_COMPETITION, F_LOCATION as LOC,  F_RESULT,
		F_FOR, F_AGAINST, F_ATT, F_REF, F_NOTES FROM ".$base99." ORDER BY F_DATE DESC LIMIT $limit";

		$o_rank = "SELECT F_LOC as LOC, F_PLD, F_WINS, F_DRAWS,  F_LOSSES, F_WINPER, F_DRAWPER, F_LOSSPER, F_UNDER, F_CLEAN, F_FAILED, F_FOR, F_AGAINST, F_GFPG, F_GAPG,
		F_GD, F_POINTS, F_PPG FROM $view WHERE F_KEY='GT' AND Team='ALL' order by F_ORDER ASC";

		$pdo = new pdodb();
	    $pdo->query('SELECT F_FOR, F_AGAINST, F_POINTS, A_POINTS FROM 0V_base_GRANK WHERE F_KEY= :key AND F_LOC= :loc');
	    $pdo->bind(':key' , "GT");
	    $pdo->bind(':loc', "TOTAL");
	    $row = $pdo->row();
	    $vF = $row['F_FOR'];
	    $vA = $row['F_AGAINST'];
	    $pF = $row['F_POINTS'];
	    $pA = $row['A_POINTS'];
	}

}
?>
<h4 class="special"><?php echo $title; ?> Results Archive against :<?php if (isset($vt))  { echo " $vt "; } else { echo " All teams "; } ?></h4>
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
<?php if(isset($o_rank)) { ?>
<h3>Overall Summary</h3>
<?php print $go->getTableKey(); ?>
<?php	
//================================================================================	
 outputDataTable( $o_rank, 'RANK');
//================================================================================
}
	if(isset($pdo)) {   print $go->_generateRatio('Goal Ratio (Percentage share of goals) ',$vF,$vA);  }
	if(isset($pdo)) {   print $go->_generateRatio('Points Ratio (Percentage share of points gained) ',$pF,$pA);  }

	$url = $_SERVER['REQUEST_URI'];
	//remove previous show query

	if(strpos($url,'?') !== false) {
		$url .= '&';
	} else {
		$url .= '?';
	}

	$url = preg_replace('(.show=\d{1,4})', '', $url);

	?>
			<h3>Results
				<span> (limited to last
					<a href="<?php echo $url; ?>show=38"    >38</a> |
					<a href="<?php echo $url; ?>show=50"    >50</a> |
					<a href="<?php echo $url; ?>show=100"   >100</a> |
					<a href="<?php echo $url; ?>show=200"   >200</a> |
					<a href="<?php echo $url; ?>show=500"   >500</a> |
					<a href="<?php echo $url; ?>show=1000"  >1000</a> |
					<a href="<?php echo $url; ?>show=9999"  >All</a>
				results)</span>
			</h3>

	<?php
	//================================================================================
	outputDataTable( $resquery, 'Results');
	//================================================================================
	?>
<div style="clear:both;"><p>&nbsp;</p></div>
<!-- The main column ends  -->
</div>
<?php get_footer(); ?>
