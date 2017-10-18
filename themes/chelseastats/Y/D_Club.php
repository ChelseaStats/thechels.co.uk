<?php /* Template Name: # D Home Club */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h2><a href="<?php the_permalink() ?>" rel="bookmark">Club Analysis</a></h2>
<p id="meta" class="date"></p>
<div style="clear:both; height:5px;"></div>
<p>Here you can view analysis and information about our Chairmen as well as our UEFA coefficients and more.</p>

<p>Or perhaps it's Chelsea Financial Accounts, Choose from the links below</p>
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