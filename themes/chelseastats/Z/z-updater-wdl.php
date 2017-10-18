<?php /* Template Name: # Z ** Updater WDL */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4> 
			<?php
				$go                    = new utility();
				$melinda               = new melinda();

				$message = "Updating..";
				$message .= $updater->updateWDL('WDL South' , 'all_results_wdl_south'   , '627893283' );
				
				$message .= $updater->updateWDL('WDL North' , 'all_results_wdl_north'   , '307682937' );


				$melinda->goSlack( $message, 'UpdaterBot' ,'soccer','bots');

				print $go->getOptionMenu();

			?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
