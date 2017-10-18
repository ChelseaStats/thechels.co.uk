<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<p id="meta <?php echo $post->ID; ?>" class="date">
Article published on <?php the_time('Y-m-d'); ?> by
<?php if (get_the_author_meta('twitter')) { ?>
<a href="<?php the_author_meta('twitter'); ?>"><?php the_author(); ?></a><?php } else { the_author(); } ?>
	in <?php the_category(', ') ?>.
	<span class="pull-right"><?php edit_post_link('Edit') ?></span>
</p>
<div style="clear:both; height:5px;"></div>
<?php the_content(__('Read more'));?>
<div style="clear:both; height:10px;"></div>
<?php echo do_shortcode('[auth]'); ?>
	<div class="well well-small">
		<strong>Category: </strong><?php the_category(', ') ?>
		<br/><br/>
		<strong>Tags: </strong><?php the_tags(' ',' | '); ?>
	</div>
<?php endwhile;?>

<div class="navigation well visible-phone">
      <div class="prev-link pull-left" >&larr; <?php next_posts_link('Older articles'); ?></div>
      <div class="next-link pull-right"><?php previous_posts_link('Newer articles'); ?> &rarr;</div>
</div>

<?php wp_pagenavi(); ?>
<?php else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
