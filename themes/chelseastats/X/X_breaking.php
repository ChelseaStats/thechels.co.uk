<?php /*  Template Name: # X news/Breaking */ ?>
<?php get_header(); ?>
	<style>
		.contentleft body { font: 12px/1.5 Calbri, Verdana, Tahoma; color: #030303; }
		.contentleft h1,h2,h3,h4,h5,h6 { color: #485AB9; }
		.contentleft a { color:#333389; text-decoration:none;}
		.contentleft a:hover { text-decoration:underline; }
		.contentleft ul {padding:2em; list-style-type:none;}
		.contentleft li {list-style-type:none; border-bottom:1px solid #EDEDED;  padding-bottom:2em; padding-top:2em;}
		.stamp { font-size:10px; color:#9a9a9a; padding-right:4px; border-right:1px solid #9a9a9a;}
	</style>
	<div id="content">
		<div id="contentleft">
			<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
			<p>Breaking News (twitter list) by <a href="http://twitter.com/ChelseaStats">@ChelseaStats</a>:</p>
			<?php
				$lister = new lister();
				$lister->getTweets('news');
			?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<!-- The main column ends  -->
<?php get_footer(); ?>

