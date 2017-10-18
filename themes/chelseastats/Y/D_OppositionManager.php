<?php /* Template Name: # D Oppo MGR */ ?>
<?php get_header();?> 
<div id="content">
<h4 class="special">Chelsea results against Opposition Managers (in all competitions).</h4>
<p style="text-align:justify;">Every manager from every competitive game updated automatically after every fixture.</p>
<?php print $go->getTableKey(); ?>
<?php 
//================================================================================
$sql = "SELECT F_NAME2, F_NAME, PLD, W, D, L,  F_WINPER, F_DRAWPER, F_LOSSPER, F_WINPER+F_DRAWPER AS F_UNDER, PTS, PPG,
		`First`, `Last` FROM 0V_base_oppoMgr ORDER BY F_NAME2 ASC, F_NAME ASC, PPG  DESC, PTS DESC";
 outputDataTable( $sql, 'OPPOMGRRANK');
//================================================================================

//================================================================================
/*
$sql = "SELECT SUBSTRING(F_NAME2,1,1) AS N_KEY, CONCAT(F_NAME2,',',F_NAME) AS N_NAME, F_NAME2, F_NAME, PLD, W, D, L,  F_WINPER, F_DRAWPER, F_LOSSPER, F_WINPER+F_DRAWPER AS F_UNDER, PTS, PPG, `First` as S_DATE, `Last` AS N_DATE
FROM 1V_OPPOMGR ORDER BY N_NAME ASC, PPG  DESC, PTS DESC";
 outputDataTable( $sql, 'OPPOMGRRANK');
*/
//================================================================================
?>
<div style="clear:both;"></div>
<!-- The main column ends  -->
<?php get_footer(); ?>