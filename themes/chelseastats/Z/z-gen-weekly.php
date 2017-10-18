<?php /* Template Name:  # Z ** Gen WeeklyPost */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				$date 		    = date('Y-m-d');
				$hidden 		= $_POST['hidden'];

				if(isset($hidden) && $hidden !='') {

					print "<div class='alert alert-info'>";

							if ($hidden == 'hidden') {

								$post_id  = $go->cfc_create_weekly_post($date);

								print $post_id . ' - Weekly Roundup created.';

							}

						Print "</div>";

				} else { ?>

					<form action="<?php the_permalink();?>" method="POST">
						<div class="form-group">
							<input type="hidden" value="hidden" name="hidden">
							<input type="submit" value="submit" class="btn btn-primary">
						</div>

					</form>

				<?php } ?>

		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
