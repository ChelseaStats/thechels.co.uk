<?php /* Template Name: # i keep */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// define variables
				$v01 = strtoupper($_POST['F01']);
				$v02 = date('Y');

				// Check data
				if ( isset($v01) && $v01!=="" ) {

					try {
						$pdo = new pdodb();
						$pdo->query('INSERT IGNORE INTO cfc_cleansheets (F_NAME, F_SYEAR) VALUES (:v1,:v2)');
						$pdo->bind(':v1'    ,$v01);
						$pdo->bind(':v2'    ,$v02);

						$result = $pdo->execute();

						$message1  = "1 record inserted: $v01 ($v02)";
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
							<label for="F01">Name (First Surname):
								<input type="text" id="F01" name="F01" value=""/>
							</label>
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