<?php /* Template Name: # U Players Historic */ ?>
<?php get_header(); ?>
<div id="content">
<?php
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) {
?>
<h4 class="special">Chelsea Ladies - Player Data</h4>
<h3>Historic player data from 2011 to date</h3>
 <?php
//================================================================================
$sql = "SELECT c.F_NAME as N_NAME, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_GOALS) as F_GOALS, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(x_minutes) as F_MINS
FROM wsl_fixtures_players a, meta_wsl_squadno c
WHERE c.F_SQUADNO = a.F_NO AND a.F_DATE >= c.F_START AND (  a.F_DATE < c.F_END or c.F_END is NULL)
GROUP BY c.F_NAME  ORDER BY c.F_NAME  ASC";
 outputDataTable( $sql, 'Ladies');
//================================================================================
} else { ?>
<h4 class="special">Chelsea - Player data</h4>
<h3>Outfield Players</h3>
<?php
//================================================================================
// $sql = "SELECT F_SQUADNO, F_NAME, F_POS, F_APPS, F_SUBS, F_GOALS, F_SHOTS, F_SHOTSON, F_ASSISTS, F_FOULSCOM, F_FOULSSUF, F_YC, F_RC FROM cfc_players ORDER BY F_SQUADNO ASC";
$sql = "SELECT a.F_NAME as N_LINK_NAME, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) F_UNUSED, sum(a.F_GOALS) as F_GOALS,
sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, 
sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(x_minutes) as F_MINS
FROM cfc_fixtures_players a, meta_squadno c
WHERE c.F_SQUADNO = a.F_NO AND a.F_DATE >= c.F_START AND ( a.F_DATE < c.F_END or c.F_END is NULL)
GROUP BY a.F_NAME ORDER BY c.F_NAME ASC";
 outputDataTable( $sql, 'M Squad');
//================================================================================
}
?>
<!-- The main column ends  -->
</div>
<?php get_footer(); ?>
