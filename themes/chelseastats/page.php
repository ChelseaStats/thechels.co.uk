<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<p id="meta" class="date"></p>
<div style="clear:both; height:5px;"></div>
<?php the_content(__('Read more'));?>
<div style="clear:both;"></div>
<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
<?php posts_nav_link(' &#8212; ', __('&laquo; Newer Stats'), __('Older Stats &raquo;')); ?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>