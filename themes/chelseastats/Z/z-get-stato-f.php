<?php /* Template Name: # Z f-stato wsl */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?>  - Ladies Match Stats</h4>
			<?php

				if (isset($_POST['submit']) && $_POST['submit']=='submit')
				{
//process the form here:

					$query = "INSERT INTO wsl_fixtures_players (F_NO, F_DATE, F_GOALS, F_YC, F_RC, F_APPS, F_SUBS, F_UNUSED, F_GAMEID) VALUES <br/>";

					$game=$_POST['gameid'];

					$pdo = new pdodb();
					$pdo->query('SELECT F_DATE FROM wsl_fixtures WHERE F_ID = :f_id');
					$pdo->bind(':f_id', $game);
					$row  = $pdo->row();
					$date = $row['F_DATE'];

					$count=count($_post['user']);

					for ( $i=0; $i<($count); $i++)
					{
// inner loop start
						foreach ($_POST['user'][$i] as $k=>$v) {
							if ($k == 'plname') {
								echo "The name you entered was $v.<br>\n";
							} else {
								echo "You also entered '$v' for '$k'.<br>\n";
							}
						}
// inner loop end
					}

					echo ('<br/><br/>');
					foreach($_POST['user'] as $k=>$v){
						$query .= "('".$v['no']."','".$date."' , '".$v['goals']."', '".$v['yc']."', '".$v['rc']."', '".$v['apps']."' , '".$v['subs']."' , '".$v['unused']."' ,' ".$game."'),"  .PHP_EOL;
					}

					$query .=' '.PHP_EOL;
					//$query = substr_replace($query,"",-6);

					$query .="UPDATE wsl_fixtures_players b SET b.F_NAME= ( SELECT a.F_NAME FROM meta_wsl_squadno a
                  WHERE ( b.F_NO=a.F_SQUADNO and a.F_START <= b.F_DATE ) 
                  AND ( b.F_DATE <= a.F_END or a.F_END is null ))
                  WHERE b.F_NO <>'0' and ( b.F_NAME is null or b.F_NAME =''); \n " .PHP_EOL;

					$query .=' '.PHP_EOL;


					$query .=" UPDATE wsl_fixtures SET x_comps='1'
   				WHERE f_competition IN ('WSL','FAC','CS','LC','CC'); \n " .PHP_EOL;
					$query .=" UPDATE wsl_fixtures SET x_comps='0'
 				WHERE f_competition NOT IN ('WSL','FAC','CS','LC','CC'); \n " .PHP_EOL;

// data to screen
					echo '<pre>';
					echo $query;
					echo '</pre>';
// data to screen

					
					Print $go->getOptionMenu();


				}
				else
				{
					?>
					<form action="<?php the_permalink();?>" method="POST">
						<p>
							<label for='gameid'>Game ID</label>
							<input type="number" name="gameid" class="form-control"	value='<?php print $go->get_maxGameId('women'); ?>' required />
						</p>

						<table class="tablesorter">
							<thead><tr><th>No</th><th>Goals</th><th>YC</th><th>RC</th><th>Apps</th><th>Subs</th><th>unused</th></tr></thead>
							<tbody>

							<?php  for ( $a = 0; $a < 11; $a++) {		?>
								<tr>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][no]"    value='0'  step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][goals]" value='0'  min="0" max="9" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][yc]"    value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][rc]"    value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][apps]"  value='1'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][subs]"  value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][unused]"  value='0'  min="0" max="1" step="1" required/></td>
								</tr>
							<?php } ?>

							<?php  for ($a = 12; $a < 15; $a++) {		?>
								<tr>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][no]"    value='0'  step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][goals]" value='0'  min="0" max="9" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][yc]"    value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][rc]"  	value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][apps]" value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][subs]" value='1'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][unused]" value='0'  min="0" max="1" step="1" required/></td>
								</tr>
							<?php } ?>
							<?php  for ($a = 15; $a < 19; $a++) {		?>
								<tr>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][no]"    value='0'  step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][goals]" value='0'  min="0" max="9" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][yc]"    value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][rc]"  	value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][apps]" value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][subs]" value='0'  min="0" max="1" step="1" required/></td>
									<td><input style="width:60px;" type="number" name="user[<?php echo $a; ?>][unused]" value='1'  min="0" max="1" step="1" required/></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						<input type="submit" name="submit" value="submit" class="btn btn-primary"/>
					</form>
				<?php } ?>
		</div>
		<?php get_template_part('wsl-sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
