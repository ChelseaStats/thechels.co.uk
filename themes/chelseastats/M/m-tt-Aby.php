<?php /* Template Name: # m-T5 away by*/ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<p>top 5 home teams by number of defeats by the away team chosen</p>
			<?php
				$team = $go->_Q($_GET['team']);

				if (isset($team) && $team !='')  {

					$pdo = new pdodb();
					$pdo->query('SELECT F_HOME N, count(*) as V FROM all_results WHERE F_AGOALS > F_HGOALS AND F_AWAY =:team
								 GROUP BY F_HOME ORDER BY count(*) DESC LIMIT 0,5');
					$pdo->bind(':team',$team);
					$rows = $pdo->rows();
					foreach($rows as $row) {
						$ns[] = $row['N'];
						$vs[] = $row['V'];
					}
					$n0=$ns[0];
					$v0=$vs[0];
					$n1=$ns[1];
					$v1=$vs[1];
					$n2=$ns[2];
					$v2=$vs[2];
					$n3=$ns[3];
					$v3=$vs[3];
					$n4=$ns[4];
					$v4=$vs[4];

					$nv=$n0.' ('.$v0.'), '.$n1.' ('.$v1.'), '.$n2.' ('.$v2.'), '.$n3.' ('.$v3.') & '.$n4.' ('.$v4.')';
					$nv = $go->_V($nv);

					$team = $go->_V($team);
					$message ="#Stats Top 5 most PL wins away by ".$team.": ".$nv;

					$melinda->goTweet($message,'APP');
					print $melinda->goMessage($message,'success');
					print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");

				} else {
					/********************************************************************************************************************/
					?>
					<form action="../" class="form">
						<div class="form-group">
							<select name="mySelectbox" class="form-control">
								<option value="" class="bolder"> -- Choose a Club --</option>
								<?php

									$pdo = new pdodb();
									$pdo->query('SELECT DISTINCT F_HOME as Team FROM all_results WHERE F_HOME IS NOT NULL ORDER BY F_HOME ASC');
									$rows = $pdo->rows();

									foreach($rows as $row) {
										$f1 = $go->_V($row['Team']);
										$f2 = $go->_Q($row['Team']);
										?>
										<option value="<?php the_permalink();?>?team=<?php echo $f2; ?>"><?php echo $f1; ?></option>
									<?php    }    ?>
							</select>
						</div>
						<?php print $go->getSubmit(); ?>
					</form>
				<?php } ?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
