<?php /* Template Name: # D Chairmen */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special">Chairman by Years and Length in Position</h4>
 <?php
//================================================================================
$sql = "select F_NAME, F_SYEAR, F_EYEAR, F_TIME from cfc_chairman order by F_SYEAR desc";
 outputDataTable( $sql, 'Chairman');
//================================================================================
 ?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>