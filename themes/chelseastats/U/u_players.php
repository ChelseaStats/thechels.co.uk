<?php /* Template Name: # U Players */ ?>
<?php get_header(); ?>
<div id="content">
<?php
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) {
?>
<h4 class="special">Chelsea Ladies - Player Data</h4>
<?php print $go->_L_get_date() ?>
<h3>Goalkeepers</h3>
 <?php
//================================================================================
$sql = "SELECT a.F_NO, c.F_NAME as N_NAME, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_GOALS) as F_GOALS,
sum(a.F_ASSISTS) as F_ASSISTS,  sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(x_minutes) as F_MINS
FROM wsl_fixtures_players a, wsl_players b, meta_wsl_squadno c
WHERE a.F_NAME=b.F_NAME and a.F_DATE >= (select F_DATE from 000_config where F_LEAGUE='WSL') AND b.F_POS = 'GK'
and c.F_SQUADNO = a.F_NO and c.F_END IS NULL
GROUP BY a.F_NO, c.F_NAME  ORDER BY a.F_NO ASC";
 outputDataTable( $sql, 'LadiesGK');
//================================================================================
?>
<h3>Outfield Players</h3>
<?php
//================================================================================
$sql = "SELECT a.F_NO, c.F_NAME as N_NAME, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) as F_UNUSED, sum(a.F_GOALS) as F_GOALS,
sum(a.F_ASSISTS) as F_ASSISTS,  sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(x_minutes) as F_MINS
FROM wsl_fixtures_players a, wsl_players b, meta_wsl_squadno c
WHERE a.F_NAME=b.F_NAME and a.F_DATE >= (select F_DATE from 000_config where F_LEAGUE='WSL')  AND b.F_POS != 'GK'
and c.F_SQUADNO = a.F_NO AND c.F_NAME = a.F_NAME and c.F_END IS NULL
GROUP BY a.F_NO, c.F_NAME ORDER BY a.F_NO ASC";
 outputDataTable( $sql, 'LadiesPlayers');
//================================================================================
} else { ?>

<h4 class="special">Chelsea - Player data</h4>
<?php print $go->_M_get_date() ?>
<h3>Goalkeepers</h3>
<?php 
//================================================================================
// $sql="SELECT  F_SQUADNO, F_NAME, F_POS, F_APPS, F_SUBS, F_CLEAN, F_CONCEDED, F_SAVES, F_FOULSCOM, F_FOULSSUF, F_YC, F_RC	FROM cfc_keepers ORDER BY F_SQUADNO ASC";

$sql = "SELECT a.F_NO, a.F_NAME as N_KEEP_NAME, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) F_UNUSED, sum(a.F_SAVES) as F_SAVES, sum(a.F_GOALS) as F_GOALS,
sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, 
sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(x_minutes) as F_MINS
FROM cfc_fixtures_players a, cfc_keepers b, meta_squadno c
WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL AND b.F_POS = 'GK'
AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL') 
GROUP BY a.F_NO, a.F_NAME ORDER BY a.F_NO ASC";

 outputDataTable( $sql, 'M Squad');
//================================================================================
?>
<h3>Outfield Players</h3>
<?php
//================================================================================
// $sql = "SELECT F_SQUADNO, F_NAME, F_POS, F_APPS, F_SUBS, F_GOALS, F_SHOTS, F_SHOTSON, F_ASSISTS, F_FOULSCOM, F_FOULSSUF, F_YC, F_RC FROM cfc_players ORDER BY F_SQUADNO ASC";

$sql = "SELECT a.F_NO, a.F_NAME as N_LINK_NAME, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) F_UNUSED, sum(a.F_GOALS) as F_GOALS, 
sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM, 
sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC, sum(x_minutes) as F_MINS
FROM cfc_fixtures_players a, cfc_players b, meta_squadno c
WHERE a.F_NAME=b.F_NAME and c.F_SQUADNO = a.F_NO and c.F_END IS NULL AND b.F_POS != 'GK'
AND a.F_DATE >= (select F_DATE from 000_config WHERE F_LEAGUE='PL') 
GROUP BY a.F_NO, a.F_NAME ORDER BY a.F_NO ASC";
 outputDataTable( $sql, 'M Squad');
//================================================================================
}
?>
<!-- The main column ends  -->
</div>
<?php get_footer(); ?>
