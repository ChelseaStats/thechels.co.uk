<?php /* Template Name: # Z ** View StatsLists */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				$table = 'cfc_fixtures_players';
				print $go->getPlayerDataFromField($table, 'x_minutes');
				print $go->getPlayerDataFromField($table, 'F_APPS');
				print $go->getPlayerDataFromField($table, 'F_SUBS');
				print $go->getPlayerDataFromField($table, 'F_SHOTS');
				print $go->getPlayerDataFromField($table, 'F_SHOTSON');
				print $go->getPlayerDataFromField($table, 'F_GOALS');
				print $go->getPlayerDataFromField($table, 'F_ASSISTS');
				print $go->getPlayerDataFromField($table, 'F_FOULSSUF');
				print $go->getPlayerDataFromField($table, 'F_FOULSCOM');
				print $go->getPlayerDataFromField($table, 'F_YC');
				print $go->getPlayerDataFromField($table, 'F_RC');

			print '<h4>Per 90s</h4>';
				
				print $go->getPlayerPer90DataFromField($table, 'F_SHOTS');
				print $go->getPlayerPer90DataFromField($table, 'F_SHOTSON');
				print $go->getPlayerPer90DataFromField($table, 'F_GOALS');
				print $go->getPlayerPer90DataFromField($table, 'F_ASSISTS');
				print $go->getPlayerPer90DataFromField($table, 'F_FOULSSUF');
				print $go->getPlayerPer90DataFromField($table, 'F_FOULSCOM');
				print $go->getPlayerPer90DataFromField($table, 'F_YC');
				print $go->getPlayerPer90DataFromField($table, 'F_RC');

			?>
		</div>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
