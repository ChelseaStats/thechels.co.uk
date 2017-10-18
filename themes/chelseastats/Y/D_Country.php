<?php /* Template Name: # D CountryRank */ ?>
<?php get_header();?> 
<div id="content">
<div id="contentleft">
<h4 class="special">Country Totals by Opposition's Country</h4>
<p>The table below assumes all wins as 3 points, draws as 1 point, regardless of competition and all competitions are included.</p>
<p>Teams are put into their country of league participation rather than their 'nationality'. for example Swansea and Cardiff are counted as England. England results are excluded.</p>
<?php print $go->getTableKey(); ?>

<?php 
//================================================================================
$sql = "SELECT N_COUNTRY, PLD AS F_PLD,
		W AS F_WINS, ROUND((W/PLD)*100,2) AS F_WINPER,
		D AS F_DRAWS, ROUND((D/PLD)*100,2) AS F_DRAWPER,
		L AS F_LOSSES, ROUND((L/PLD)*100,2) AS F_LOSSPER,
		CS AS F_CLEAN, FS AS F_FAILED, F AS F_FOR, A AS F_AGAINST,
		GD AS F_GD, PTS AS F_POINTS, ROUND(PTS/PLD,3) AS PPG
		FROM 0V_base_country
		GROUP BY N_COUNTRY
		ORDER BY PPG DESC";
outputDataTable( $sql, 'COUNTRY');
//================================================================================
?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>