<?php get_header(); ?>
<div id="content">
<div id="contentleft">
	<h4 class="special">Search Results:</h4>
	<br/>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<p id="meta <?php echo $post->ID; ?>" class="date">
Article published on <?php the_time('Y-m-d'); ?> by
<?php if (get_the_author_meta('twitter')) { ?>
<a href="<?php the_author_meta('twitter'); ?>"><?php the_author(); ?></a><?php } else { the_author(); } ?> 
<?php if (get_the_author_meta('url')) { ?>
of <a href="<?php the_author_meta('url'); ?>"><?php the_author_meta('websitename'); ?></a><?php } else {  } ?> 
| <a href="http://twitter.com/share?text=<?php the_title(); ?> by @ChelseaStats&url=<?php the_permalink() ?>&hashtags=CFC,Chelsea">Share on Twitter</a>
| <?php edit_post_link('Edit') ?>
</p>
<div style="clear:both; height:5px;"></div>
	<?php the_excerpt();?>
<div style="clear:both; height:10px;"></div>
	<?php echo do_shortcode('[auth]'); ?>
	<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
<div class="navigation well visible-phone">
      <div class="prev-link pull-left" >&larr; <?php next_posts_link('Older articles'); ?></div>
      <div class="next-link pull-right"><?php previous_posts_link('Newer articles'); ?> &rarr;</div>
</div>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
