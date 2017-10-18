<?php
/* 
Template Name: Category archive
*/
?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">

<?php if (is_category('')) : ?>

<h4 class="special">Category: <?php single_cat_title( '', true ); ?></h4>
<?php $category = get_category( get_query_var('cat') ); ?>
<p>Subscribe to  the <a href="<?php echo get_category_feed_link( $category->cat_ID )?>">RSS feed</a> to keep up to date with all posts in this
category.</p>
<hr/>

<?php 
query_posts($query_string . "&posts_per_page=15"); 
if (have_posts()) : while (have_posts()) : the_post(); ?>
<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<p id="meta <?php echo $post->ID; ?>" class="date">
Article published on <?php the_time('Y-m-d'); ?> by
<?php if (get_the_author_meta('twitter')) { ?>
<a href="<?php the_author_meta('twitter'); ?>"><?php the_author(); ?></a><?php } else { the_author(); } ?>
	in <?php the_category(', ') ?>.
	<span class="pull-right"><?php edit_post_link('Edit') ?></span>
</p>
<div style="clear:both; height:5px;"></div>
	<?php the_excerpt();?>
	<div style="clear:both;"></div>
	<?php echo do_shortcode('[auth]'); ?>
        <hr/>
	<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>

<div class="navigation well visible-phone">
      <div class="prev-link pull-left" >&larr; <?php next_posts_link('Older articles'); ?></div>
      <div class="next-link pull-right"><?php previous_posts_link('Newer articles'); ?> &rarr;</div>
</div>

<br/><?php wp_pagenavi(); ?>
<!------------------- Category with slugs ----------------------------------------->


<?php else : ?>


<!------------------------ category no slug --------------------------------------->
<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<p id="meta" class="date"></p>
<div style="clear:both; height:5px;"></div>
<p>A list of article categories and the number or articles within each group</p>
<p>
<?php $args = array(
	'show_option_all'    => '',
	'orderby'            => 'name',
	'order'              => 'ASC',
	'style'              => 'none',
	'show_count'         => 1,
	'hide_empty'         => 1,
	'use_desc_for_title' => 1,
	'child_of'           => 0,
	'feed'               => '',
	'feed_type'          => '',
	'feed_image'         => '',
	'exclude'            => '',
	'exclude_tree'       => '',
	'include'            => '',
	'hierarchical'       => 0,
	'title_li'           => __( '' ),
	'show_option_none'   => __('No categories'),
	'number'             => null,
	'echo'               => 1,
	'depth'              => 0,
	'current_category'   => 0,
	'pad_counts'         => 0,
	'taxonomy'           => 'category',
	'walker'             => null
); ?>
<?php wp_list_categories( $args ); ?> 
</p>
<!------------------------ category no slug --------------------------------------->

<?php endif; ?>

</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
