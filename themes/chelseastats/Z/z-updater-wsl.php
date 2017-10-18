<?php /* Template Name: # Z ** Updater WSL */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4> 
			<?php
				$go                    = new utility();
				$melinda               = new melinda();
				$pdo                   = new pdodb();
				$wslyear               = date('Y');

				$message = "Updating..";
				$message .= $updater->UpdateWSL('WSL 1'     , 'all_results_wsl_one'     , 1, $wslyear);
				$message .= $updater->UpdateWSL('WSL 2'     , 'all_results_wsl_two'     , 2, $wslyear);

				print "<div class='alert alert-info'>";
					$pdo->query("SELECT COUNT(*) as CNT FROM  0t_wsl_miles");
					$row = $pdo->row();
					$count = $row['CNT'];
					$message .= "Current wsl milestones row count : {$count}.".PHP_EOL;
					$message .= "New wsl milestones row count : {$updater->updater_wsl_milestones()}.".PHP_EOL;

				print "Current wsl milestones row count : {$count}.<br/>".PHP_EOL;
				print "New wsl milestones row count : {$updater->updater_wsl_milestones()}.".PHP_EOL;
				Print '</div>';

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
