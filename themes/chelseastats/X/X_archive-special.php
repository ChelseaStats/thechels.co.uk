<?php /* Template Name: # X Archive Special */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
	<?php 
			$query = new WP_Query( 'posts_per_page=12' );
			if (have_posts()) : while (have_posts()) : the_post(); 
	?>
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>

<?php the_excerpt();?>
<div style="clear:both;"></div>
<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>

<p>You'll also find useful links to other pages on the site as well as links to our applications, api and accounts on other sites</p>

<h3>Social Media</h3>

<ul>
	<li><a href="//twitter.com/ChelseaStats">Twitter</a></li>
	<li><a href="//u.thechels.uk/InstaCFC">Instagram</a></li>
	<li><a href="//facebook.com/ChelseaStats">Facebook</a></li>
	<li><a href="//pinterest.com/chelseastats/chelsea/">Pinterest</a></li>
	<li><a href="https://reddit.com/user/ChelseaStats">Reddit</a></li>
	<li><a href="https://ifttt.com/p/chelseastats/shared">IFTTT</a></li>
	<li><a href="//github.com/chelseastats">Github</a></li>
	<li><a href="//www.redbubble.com/people/chelseastats">Redbubble</a></li>
	<li><a href="http://amzn.to/thechels">Amazon</a></li>
</ul>


<ul>
<li>Follow <a title="Fawsl Stats" href="//twitter.com/FawslStats">@fawslStats</a> - our sister twitter account 
and automated women's football 'bot'.</li>
<li>With results and league table data published through <a title="Fawsl Stats" href="//fawslstats.tumblr.com">Tumblr</a>.</li>
</ul>

<h3>Mobile App</h3>
<ul>
<li><a href="https://m.thechels.uk/" title="Mobile app ChelseaStats">ChelseaStats curated data Web App</a> (free).</li>
</ul>

<h3>Api</h3>
<ul>
<li><a href="https://api.thechels.uk/" title="free Chelsea Stats data">data API outputting Json</a> (free).</li>
</ul>

<h3>Sponsorship Opportunities</h3>
<ul>
<li><a href="/sponsorship/" title="Sponsor ChelseaStats">Sponsor for the entire site or for an article category.</a></li>
</ul>

<h3>Other Archive and Information Pages</h3>
<ul>
<li><a href="/sitemap/" title="Sitemap">Sitemap</a></li>
<li><a href="/date/" title="Archives by Date">Date archives</a></li>
<li><a href="/category/" title="Archives by Category">Category archives</a></li>
<li><a href="/this-week/" title="Articles published this week">Articles published this week</a></li>
<li><a href="/writers/" title="Staff Writers">Staff Writers and Contributors</a></li>
<li><a href="/glossary/" title="glossary and nicknames">Glossary and terminology</a></li>
<li><a href="/reference/" title="References and Sources">References and Sources</a></li>
<li><a href="/rss-feeds/" title="Syndicated Site feed">Syndicated RSS feed</a></li>

</ul>


<h3>News Monitoring</h3>
	<ul>
		<li><a href="/news/stats/" title="Stats News">Statistics</a> - Rendering of a twitter list of key sports based statistics accounts.</li>
		<li><a href="/news/breaking/" title="Breaking News">Breaking News</a> -  Rendering of a twitter list of breaking news accounts.</li>
	</ul>



<h3>The Last 30 Posts</h3>
		<br/>
<?php wp_get_archives(array ('type' => 'postbypost', 'limit' =>'30', 'style' =>'list') ); ?>

<h3>The Categories</h3>
		<br/>
	<?php $args = array(
	'show_option_all'    => '',
	'orderby'            => 'name',
	'order'              => 'ASC',
	'style'              => 'list',
	'show_count'         => 0,
	'hide_empty'         => 1,
	'use_desc_for_title' => 1,
	'hierarchical'       => null,
	'title_li'           => null,
	'show_option_none'   => __('No categories'),
	'number'             => null,
	'echo'               => 1,
	'depth'              => 0,
	'current_category'   => 0,
	'pad_counts'         => 0,
	'taxonomy'           => 'category',
	'walker'             => null
	); ?>
	<?php wp_list_categories($args); ?>

<h3>The Archives</h3>
		<br/>
		<?php wp_get_archives('type=monthly'); ?>

<h3>Tag Archives</h3>
<p>Tags are shown in alphabetical order and their size is an indication of usage (the larger, the more articles tagged).</p>
<p id="page-tag-archive">
     <?php wp_tag_cloud('number=200&unit=px&smallest=8&largest=32'); ?>
</p>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
