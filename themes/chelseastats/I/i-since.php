<?php /* Template Name: # i since */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// define variables
				$v01 = $go->_Q($_POST['F01']);
				$v02 = ($_POST['F02']);
				$v03 = ($_POST['F03']);
				$v04 = $go->_Q($_POST['F04']);
				// Check data
				if ( isset($v01) && $v01!=="" && $v02!=="" && $v03!=="" ) {


					try {
						$pdo = new pdodb();
						$pdo->query('INSERT INTO cfc_since (F_TEAM, F_DATE, F_NOTES, F_COMPETITION) VALUES (:v1,:v2,:v3,:v4)');
						$pdo->bind(':v1' ,$v01);
						$pdo->bind(':v2' ,$v02);
						$pdo->bind(':v3' ,$v03);
						$pdo->bind(':v4' ,$v04);

						$result = $pdo->execute();

						$message1  = "1 record inserted: $v01 ($v02) $v03 ($v04)";
						$message2  = "ID given: ".$pdo->lastInsertId();

						print $melinda->goMessage($message1,'success');
						print $melinda->goMessage($message2,'info');
						print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");

					} catch (PDOException $e) {

						print $melinda->goMessage( "DB Error: The record could not be added.<br>".$e->getMessage(), 'error' );
						print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

					} catch (Exception $e) {

						print $melinda->goMessage( "General Error: The record could not be added.<br>".$e->getMessage() , 'error');
						print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

					}


				}  else  { ?>

					<form method="POST" action="<?php the_permalink();?>">

						<div class="form-group">
							<label for="F01">Team:
								<input type="text" id="F01" name="F01" value=""  class="form-control" style="text-transform:uppercase;" onkeyup="this.value=this.value.toUpperCase();"/>
							</label>
						</div>

						<div class="form-group">
							<label for="F02">Date:
								<input type="date" id="F02" name="F02" value=""  class="form-control"/>
							</label>
						</div>

						<div class="form-group">
							<label for="F03">Description:</label>
							<textarea rows="3" name="F03" id="F03" style="width:90%;" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="F04">Competition:</label>
							<input type="text" id="F04" name="F04" value=""  class="form-control"/>
						</div>

						<div class="form-group">
							<input type="submit" name="Submit" value="Submit" class="btn btn-primary"/>
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
