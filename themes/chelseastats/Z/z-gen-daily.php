<?php /* Template Name:  # Z ** Gen Daily Post */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				$hidden     = $_POST['hidden'];
				$location   = $_POST['location'];
				$city       = $_POST['city'];
				$embed      = $_POST['embedurl'];
				$date       = $_POST['date'];

				if(isset($hidden) && $hidden !='') {

					print "<div class='alert alert-info'>";

							if ($hidden == 'hidden') {

								$post_id  = $go->get_daily($location,$city,$embed,$date);

								print $post_id . ' - Daily created.';

							}

						Print "</div>";

				} else { ?>

					<form method="POST" action="<?php the_permalink();?>">

							<div class="form-group">
								<label for="location">location:</label>
								<input name="location"   type="text" id="location" placeholder="SW6 1HS" value="SW6 1HS" />
							</div>

							<div class="form-group">
								<label for="country">country:</label>
								<input name="country"   type="text" id="country" placeholder="England" value="England" />
							</div>


							<div class="form-group">
								<label for="embedurl">Embed:</label>
								<input name="embedurl"   type="text" id="embedurl" placeholder="url" value="" />
							</div>

						<?php
							$now    = date('Y-m-d');
							$three  = date('Y-m-d', strtotime("+3 days"));

						?>

							<div class="form-group">
								<label for="date">date:</label>
								<input name="date"   type="date" id="date" min="<?php echo $now;?>" max="<?php echo $three; ?>" placeholder="" value="" />
							</div>
							
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
