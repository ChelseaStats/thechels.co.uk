<?php /* Template Name: # D Former Players */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark">Full list of ex-players</a></h4>
<p>A complete list of former blues with basic summary statistics</p>
<?php
if (is_admin()) {
//================================================================================
$sql = "SELECT SUBSTR(F_SNAME,1,1) as N_KEY, CONCAT(F_SNAME,',',F_FNAME) as N_NAME, F_SNAME, F_FNAME, F_EDATE, F_SDATE, F_APPS, F_SUBS, F_GOALS, F_GPG FROM cfc_explayers order by F_EDATE DESC";
 outputDataTable( $sql, 'Ex Players');
//================================================================================
}
else {
//================================================================================
$sql = "SELECT F_SNAME, F_FNAME, F_EDATE, F_SDATE, F_APPS, F_SUBS, F_GOALS, F_GPG FROM cfc_explayers order by F_EDATE DESC";
 outputDataTable( $sql, 'Ex Players');
//================================================================================
}
?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>