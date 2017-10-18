<?php /*  Template Name: # X The Week */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<p>Articles published in the last 7 days; Expect Chelsea statistics, roundups, league tables, Statszone analysis and opinion.</p>
<?php query_posts("showposts=25") ?>
<?php while (have_posts()) : the_post(); ?>

<?php $my_limit = 7 * 86400; // days * seconds per day
$post_age = date('U') - get_post_time('U');
if ($post_age < $my_limit) { ?>

<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
<p id="meta <?php echo $post->ID; ?>" class="date">
Article published on <?php the_time('Y-m-d'); ?> by
<?php if (get_the_author_meta('twitter')) { ?>
<a href="<?php the_author_meta('twitter'); ?>"><?php the_author(); ?></a><?php } else { the_author(); } ?> 
<?php if (get_the_author_meta('url')) { ?>
of <a href="<?php the_author_meta('url'); ?>"><?php the_author_meta('websitename'); ?></a><?php } else {  } ?> 
| <?php edit_post_link('Edit') ?>
</p>
<div style="clear:both; height:5px;"></div>
<?php the_excerpt();?>
<div style="clear:both;"></div>
<?php echo do_shortcode('[auth]'); ?>
<hr/>
<?php } ?>
<?php endwhile; ?>

</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
