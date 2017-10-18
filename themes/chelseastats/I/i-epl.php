<?php /* Template Name:  # i* (ALL) EPL */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// define variables
				$v00 = ($_POST['F00']);
				$v01 = $go->_Q($_POST['F01']);
				$v02 = $go->_Q($_POST['F02']);
				$v03 = ($_POST['F03']);
				$v04 = ($_POST['F04']);
				$v05 = ($_POST['F05']);
				$v06 = ($_POST['F06']);
				$v08 = ($_POST['F08']);

				// Check data
				if ( isset($v01) && $v01!=="" && $v02!=="" ) {

					try {
						$pdo = new pdodb();
						$pdo->query('INSERT INTO all_results (F_DATE, F_1G, F_HOME, F_AWAY, F_HGOALS, F_AGOALS, HT_HGOALS, HT_AGOALS)  VALUES (:v1,:v8,:v2,:v3,:v4,:v5,:v6,:v7)');
						$pdo->bind(':v1' ,$v00);
						$pdo->bind(':v8' ,$v08);
						$pdo->bind(':v2' ,$v01);
						$pdo->bind(':v3' ,$v02);
						$pdo->bind(':v4' ,$v03);
						$pdo->bind(':v5' ,$v04);
						$pdo->bind(':v6' ,$v05);
						$pdo->bind(':v7' ,$v06);

						$result = $pdo->execute();

						$message1 = "1 record inserted: $v00 for $v01  $v03  : $v04  $v02 :";
						$message2 = "ID given: ".$pdo->lastInsertId();

						print $melinda->goMessage($message1,'success');
						print $melinda->goMessage($message2,'info');
						print $go->getOptionMenu();

					} catch (PDOException $e) {

						print $melinda->goMessage( "DB Error: The record could not be added.<br>".$e->getMessage(), 'error' );
						print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

					} catch (Exception $e) {

						print $melinda->goMessage( "General Error: The record could not be added.<br>".$e->getMessage() , 'error');
						print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

					}

				}
				else  { ?>
					<form method="POST" class="form-horizontal" action="<?php the_permalink();?>">

						<div class="form-group control-group">
							<label class="control-label" for="F00">Date:</label>
							<div class="controls">
								<input type="date" id="F00" name="F00" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F08">1st Goal (H/A):</label>
							<div class="controls">
								<input type="text" id="F08" name="F08" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F01">Home:</label>
							<div class="controls">
								<input type="text" id="F01" name="F01" value="" class="form-control" style="text-transform:uppercase;"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F02">Away:</label>
							<div class="controls">
								<input type="text" id="F02" name="F02" value=""   class="form-control" style="text-transform:uppercase;"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F03">Home Goals:</label>
							<div class="controls">
								<input type="number" id="F03" name="F03" value=""  class="form-control" step="1" Min="0"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F04">Away Goals:</label>
							<div class="controls">
								<input type="number" id="F04" name="F04" value=""  class="form-control" step="1" Min="0"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F05">HT Home Goals:</label>
							<div class="controls">
								<input type="number" id="F05" name="F05" value=""  class="form-control" step="1" Min="0"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F06">HT Away Goals:</label>
							<div class="controls">
								<input type="number" id="F06" name="F06" value=""  class="form-control" step="1" Min="0"/>
							</div>
						</div>

						<div class="form-group control-group">
							<div class="controls offset2">
								<input type="submit" name="Submit" value="Submit" class="btn btn-primary"/>
							</div>
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
