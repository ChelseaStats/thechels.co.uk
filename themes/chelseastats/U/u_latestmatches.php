<?php /* Template Name: # U Latest Matches */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<?php
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) { 
 
$title = 'Chelsea Ladies';

$sql = "SELECT DISTINCT F_OPP as L_TEAM, CONCAT(F_ID,',',MAX(F_DATE)) as LX_T_DATE, MAX(F_DATE) as noshowX_T_DATE,
(SELECT CONCAT(F_ID,',',MAX(F_DATE)) FROM wsl_fixtures b WHERE F_RESULT='W' AND b.F_OPP=a.F_OPP) AS  LX_W_DATE,
(SELECT CONCAT(F_ID,',',MAX(F_DATE)) FROM wsl_fixtures c WHERE F_RESULT='D' AND c.F_OPP=a.F_OPP) AS LX_D_DATE,
(SELECT CONCAT(F_ID,',',MAX(F_DATE)) FROM wsl_fixtures d WHERE F_RESULT='L' AND d.F_OPP=a.F_OPP) AS LX_L_DATE
FROM wsl_fixtures a GROUP BY F_OPP ORDER BY noshowX_T_DATE DESC";

} else {
 
$title = 'Chelsea';

$sql = "SELECT DISTINCT F_OPP as M_TEAM, CONCAT(F_ID,',',MAX(F_DATE)) as MX_T_DATE, MAX(F_DATE) as noshwomX_T_DATE,
(SELECT CONCAT(F_ID,',',MAX(F_DATE)) FROM cfc_fixtures b WHERE F_RESULT='W' AND b.F_OPP=a.F_OPP) AS MX_W_DATE,
(SELECT CONCAT(F_ID,',',MAX(F_DATE)) FROM cfc_fixtures c WHERE F_RESULT='D' AND c.F_OPP=a.F_OPP) AS MX_D_DATE,
(SELECT CONCAT(F_ID,',',MAX(F_DATE)) FROM cfc_fixtures d WHERE F_RESULT='L' AND d.F_OPP=a.F_OPP) AS MX_L_DATE
FROM cfc_fixtures a GROUP BY F_OPP ORDER BY noshwomX_T_DATE DESC";

}
?>

<h4 class="special"><?php echo $title; ?> - Latest Matches versus Opposition with Last Result Dates</h4>
<?php
//================================================================================
 outputDataTable( $sql, 'last match');
//================================================================================
?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
