<?php /* Template Name: # U Home Analysis */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<?php
$page = get_permalink($post->ID);
if (strpos($page,'ladies') !== false) { 
$title = "Chelsea Ladies";
} else {
$title = "Chelsea";
}
?>

<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php echo $title; ?> FC - Analysis</a></h4>
<p>Here you can view every competitive result in our history, see our current form, some detailed match analysis as well as analysis based on the result frequency, competition, referee and manager all with graphs and data tables. Just select from the links below.</p>
<p>The content is updated automatically after every result, so check back often!</p>
<br/>
<?php
  $children = wp_list_pages('title_li=&child_of='.$post->ID.'&echo=0');
  if ($children) { ?>
  <ul>
  <?php echo $children; ?>
  </ul>
  <?php } ?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>