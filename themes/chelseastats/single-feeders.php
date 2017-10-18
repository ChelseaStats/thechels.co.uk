<?php /*  Template Name: # X PT Single Feeders */ ?>
<?php get_header(); ?>
    <div id="content">
        <div id="contentleft">
            <article>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h2><a href="/feeders">[Feeder]</a> : <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                <p id="meta <?php echo $post->ID; ?>" class="date">
                    Published on <?php the_time('Y-m-d'); ?> by
                    <?php if (get_the_author_meta('twitter')) { ?>
	                    <a href="<?php the_author_meta('twitter'); ?>"><?php the_author(); ?></a><?php } else { the_author(); } ?>
	                    <span class="pull-right"><?php edit_post_link('Edit') ?></span>
                </p>
                <div style="clear:both; height:5px;"></div>
                <?php the_content(__('Read more'));?>
                <div style="clear:both; height:5px;"></div>
                <p class="alert alert-success"><a href="/feeders">Read more feeders</a></p>
            </article>
            <aside id="discuss">
                <?php echo do_shortcode('[auth]'); ?>
                <div class="navigation well">
                    <div class="prev-link pull-left">&larr; <?php previous_post_link('%link', 'Older articles'); ?></div>
                    <div class="next-link pull-right"><?php next_post_link('%link', 'Newer articles'); ?> &rarr; </div>
                </div>

	            <div class="well well-small">
		            <strong>Share this page: </strong>
		            <br/><br/>
	<span class="sharer-container">
		<span class="rwd-line sharers"><a href="http://twitter.com/share?text=<?php the_title(); ?> by @ChelseaStats &url=<?php the_permalink() ?>&hashtags=CFC,Chelsea,ChelseaFC"><i class="fa fa-fw fa-3x fa-twitter-square"></i>Twitter</a></span>
		<span class="rwd-line sharers"><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>"><i class="fa fa-fw fa-3x fa-facebook-square"></i>Facebook</a></span>
		<span class="rwd-line sharers"><a href="https://plus.google.com/share?url=<?php the_permalink() ?>"><i class="fa fa-fw fa-3x fa-google-plus-square"></i>Google+</a></span>
		<span class="rwd-line sharers"><a href="https://www.linkedin.com/shareArticle?url=<?php the_permalink() ?>"><i class="fa fa-fw fa-3x fa-linkedin-square"></i>LinkedIn</a></span>
		<span class="rwd-line sharers"><a href="https://tumblr.com/widgets/share/tool?canonicalUrl=<?php the_permalink() ?>&hashtags=CFC,Chelsea,ChelseaFC"><i class="fa fa-fw fa-3x fa-tumblr-square"></i>Tumblr</a></span>
		<span class="rwd-line sharers"><a href="https://www.reddit.com/submit?url=<?php the_permalink() ?>&hashtags=CFC,Chelsea,ChelseaFC"><i class="fa fa-fw fa-3x fa-reddit-square"></i>Reddit</a></span>
		<span class="rwd-line sharers"><a href="mailto:?subject=I wanted to share this article with you from @ChelseaStats&amp;body=<?php the_title(); ?> on TheChels.co.uk at <?php the_permalink() ?>"><i class="fa fa-fw fa-3x fa-envelope-square"></i>Email</a></span>
	</span>
	            </div>
            </aside>
            <?php endwhile; else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
        </div>
        <?php get_template_part('sidebar');?>
    </div>
    <!-- The main column ends  -->
<?php get_footer(); ?>
