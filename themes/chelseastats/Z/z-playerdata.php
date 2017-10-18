<?php /* Template Name:  # Z Private playerdata */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
    <div id="content">
        <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>

<h3>Total match players by season</h3>
<?php
//================================================================================
$sql = "SELECT a.F_NAME, b.F_LABEL as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) as F_SUBS,
        SUM(a.F_UNUSED) as F_SUBSU, SUM(F_GOALS) as F_GOALS
		FROM cfc_fixtures_players a, meta_seasons b
		WHERE a.F_DATE >= b.F_SDATE AND a.F_DATE <= b.F_EDATE
		GROUP BY F_ID, a.F_NAME
		union all
		SELECT a.F_NAME, 'Total' as F_ID, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) as F_SUBS,
		SUM(a.F_UNUSED) as F_SUBSU, SUM(F_GOALS) as F_GOALS
		FROM cfc_fixtures_players a
		GROUP BY a.F_NAME
        ORDER BY F_NAME ASC, F_ID ASC";
outputDataTable( $sql, 'no events');
//================================================================================
?>
        </div>
        <?php get_template_part('sidebar');?>
    </div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
