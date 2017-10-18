<?php /*  Template Name: # X Date Archive */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<p>A list of month and years and count of articles within each time period</p>
<p>
<?php wp_get_archives( array( 'type' => 'monthly', 'show_post_count' => 1 ) ); ?>
</p>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>