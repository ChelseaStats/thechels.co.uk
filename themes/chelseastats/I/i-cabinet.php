<?php /* Template Name: # i trophy cabinet */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// define variables
				$v01 = ($_POST['F01']);
				$v02 = ($_POST['F02']);
				$v03 = ($_POST['F03']);

				// Check data
				if ( isset($v01) && $v01!=="" && $v02!=="" && $v03!=="" ) {


					try {
						$pdo = new pdodb();
						$pdo->query('INSERT INTO cfc_cabinet (F_YR, F_CUP, F_COUNT ) VALUES (:v1,:v2,:v3)');
						$pdo->bind(':v1' ,$v01);
						$pdo->bind(':v2' ,$v02);
						$pdo->bind(':v3' ,$v03);

						$result = $pdo->execute();

						$message1  = "1 record inserted: {$v01} {$v02} {$v03}.";
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
							<label for="F01">Date:</label>
							<input type="text" id="F01" name="F01" value=""  class="form-control"/>
						</div>

						<div class="form-group">
							<label for="F02">Description:</label>
							<input type="text" id="F02" name="F02" value=""  class="form-control"/>
						</div>
						<div class="form-group">
							<label for="F03">Total:</label>
							<input type="number" id="F03" name="F03" value=""  class="form-control"/>
						</div>
						<div class="form-group">
							<input type="submit" name="Submit" value="Submit" class="btn btn-primary"/>
						</div>

					</form>
				<?php } ?>

			<?php
				//================================================================================
				$sql = "SELECT F_YR, F_CUP as N_COMP, F_COUNT FROM cfc_cabinet order by F_YR DESC";
				outputDataTable( $sql, 'Competition');
				//================================================================================
			?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
