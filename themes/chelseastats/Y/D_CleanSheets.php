<?php /* Template Name: # D Clean Sheets */
?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special">Clean Sheets by Goalkeeper</h4>
 <?php
//================================================================================
$sql = "SELECT F_NAME, F_SYEAR, F_EYEAR, F_CLEAN, F_SUBS FROM cfc_cleansheets ORDER BY F_CLEAN DESC";
 outputDataTable( $sql, 'CleanSheets');
//================================================================================
 ?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>