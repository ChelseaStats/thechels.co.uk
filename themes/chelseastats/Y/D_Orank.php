<?php /* Template Name: # D Orank */ ?>
<?php get_header();?> 
<div id="content">
<h4 class="special">Chelsea results against Opposition (in all competitions)</h4>
<p style="text-align:justify;">Every team from every competitive game updated automatically after every fixture.</p>
<?php print $go->getTableKey(); ?>

<h3>Total Overall Record</h3>
<?php 
//================================================================================
$sql = "SELECT F_LOC as LOC, F_PLD, F_WINS, F_DRAWS,  F_LOSSES, F_WINPER, F_DRAWPER, F_LOSSPER, F_UNDER, F_CLEAN, F_FAILED, F_FOR, F_AGAINST, F_GD, F_POINTS, F_PPG 
		FROM 0V_base_GRANK WHERE F_KEY='GT' AND Team='ALL' ";
 outputDataTable( $sql, 'RANK');
//================================================================================
?>
<h3>Opposition Overall Record</h3>
<?php 
//================================================================================
$sql = "SELECT F_KEY AS N_KEY, Team as F_TEAM, F_PLD, F_WINS, F_DRAWS, F_LOSSES, F_WINPER, F_DRAWPER, F_LOSSPER, F_UNDER, F_CLEAN, F_FAILED, F_FOR, F_AGAINST, F_GD, F_POINTS, F_PPG
		FROM 0V_base_GRANK WHERE F_KEY <> 'GT' AND Team <> 'ALL' and F_LOC='TOTAL' ";
 outputDataTable( $sql, 'RANK');
//================================================================================
?>
<div style="clear:both;"></div>
<!-- The main column ends  -->
<?php get_footer(); ?>