<?php /* Template Name: # D Cabinet */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark">Trophy Cabinet</a></h4>
<p>A list of major trophy successes</p>
<?php
//================================================================================
$sql = "SELECT F_YR, F_CUP as N_COMP, F_COUNT FROM cfc_cabinet order by F_YR DESC";
outputDataTable( $sql, 'Competition');
//================================================================================
?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>