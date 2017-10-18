<?php /* Template Name:# i f-events */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// define variables
				$v01 = $go->_Q($_POST['F01']); //name
				$v03 = ($_POST['F03']); // event
				$v04 = ($_POST['F04']); // team
				$v05 = ($_POST['F05']); // minute
				$v06 = ($_POST['F06']); // gameid

				try {
					$pdo = new pdodb();
					$pdo->query('SELECT F_DATE FROM wsl_fixtures WHERE F_ID = :f_id');
					$pdo->bind(':f_id', $v06);
					$row = $pdo->row();
					$v02 = $row['F_DATE'];

				} catch (PDOException $e) {

					print $melinda->goMessage( "DB Error: The record could not be selected.<br>".$e->getMessage(), 'error' );
					print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

				} catch (Exception $e) {

					print $melinda->goMessage( "General Error: The record could not be selected.<br>".$e->getMessage() , 'error');
					print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

				}


				// Check data
				if ( isset($v01) && $v01!=="" && $v02!=="" && $v03!=="" ) {

					try {
						$pdo->query('INSERT INTO wsl_fixture_events (F_NAME, F_DATE, F_EVENT, F_TEAM, F_MINUTE, F_GAMEID) VALUES (:v1,:v2,:v3,:v4,:v5,:v6)');
						$pdo->bind(':v1' ,$v01);
						$pdo->bind(':v2' ,$v02);
						$pdo->bind(':v3' ,$v03);
						$pdo->bind(':v4' ,$v04);
						$pdo->bind(':v5' ,$v05);
						$pdo->bind(':v6' ,$v06);

						$result = $pdo->execute();

						$message1  = "1 record inserted: $v01 :  $v02 : $v03 : $v04 : $v05 : $v06 : $v07 ";
						$message2  = "ID given: ".$pdo->lastInsertId();

						print $melinda->goMessage($message1,'success');
						print $melinda->goMessage($message2,'info');
						print $go->getOptionMenu();

					} catch (PDOException $e) {

						print $melinda->goMessage( "DB Error: The record could not be added.<br>".$e->getMessage(), 'error' );
						print $go->getOptionMenu();

					} catch (Exception $e) {

						print $melinda->goMessage( "General Error: The record could not be added.<br>".$e->getMessage() , 'error');
						print $go->getOptionMenu();
					}





				}  else  { ?>
					<form method="POST" action="<?php the_permalink();?>">

						<div class="form-group">
							<label for="F01">Name:
								<input class="form-control" type="text" name="F01" value=""/>
							</label>
						</div>

						<div class="form-group">
							<label for="F03">Event:
								<select name="F03" class="form-control">
									<optgroup id="opt1" label="Goals">
										<option value="GOAL">goal</option>
										<option value="PKGOAL">pkgoal</option>
										<option value="PKMISS">pkmiss</option>
										<option value="OGOAL">ogoal</option>
									</optgroup>
									<optgroup id="opt2" label="Subs">
										<option value="SUBON">subon</option>
										<option value="SUBOFF">suboff</option>
									</optgroup>
									<optgroup id="opt3" label="Cards">
										<option value="YC">YC</option>
										<option value="RC">RC</option>
									</optgroup>
								</select>
							</label>
						</div>

						<div class="form-group">
							<label for="F04">Team (1 or 0):
								<input type="number" name="F04" class="form-control" value=""/>
							</label>
						</div>

						<div class="form-group">
							<label for="F04">Minute:
								<input type="number" name="F05" class="form-control" value=""/>
							</label>
						</div>
						
						<div class="form-group">
							<label for="F06">Game ID:
								<input type="number" name="F06" class="form-control" value=""/>
							</label>
						</div>

						<div class="form-group">
							<input type="submit" name="Submit" value="Submit" class="btn btn-primary"/>
						</div>

					</form>
				<?php } ?>
		</div>
		<?php get_template_part('wsl-sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
