<?php /* Template Name: # i coeff */ ?>
<?php get_header();?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php

				print $melinda->goMessage( '<a href="http://kassiesa.home.xs4all.nl/bert/uefa/data/method4/trank2016.html" target="_blank">UEFA Team Ranking 2016</a>', 'info');

				//Get data in local variable
				$v01=$_POST['F01'];
				$v02=$_POST['F02'];
				$v03=$_POST['F03'];
				$v04=$_POST['F04'];

				// check for null values
				// Notes can be null
				// field F_ID is auto-incremental
				if (isset($v01) && $v01!=="" && $v02!=="" && $v03!=="" && $v04!=="" ) {
					$pdo = new pdodb();

					$pdo->query("SELECT COUNT(*) AS Counter from cfc_coefficient WHERE F_YEAR = :v01");
					$pdo->bind(':v01' ,$v01);
					$pdo->execute();
					$result = $pdo->row();

					if(isset($result) && $result['Counter'] > 0) {

						try {

							$pdo->query( "UPDATE cfc_coefficient SET F_COEFF=:v02, F_TOTAL=:v03, F_POS=:v04 WHERE F_YEAR=:v01" );
							$pdo->bind( ':v01', $v01 );
							$pdo->bind( ':v02', $v02 );
							$pdo->bind( ':v03', $v03 );
							$pdo->bind( ':v04', $v04 );

							$result = $pdo->execute();

							$message1 = "1 updated added for :  $v01  :  $v02 :  $v03 : $v04 ";
							$message2 = "ID given: " . $pdo->lastInsertId();

							print $melinda->goMessage( $message1, 'success' );
							print $melinda->goMessage( $message2, 'info' );
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						} catch ( PDOException $e ) {

							print $melinda->goMessage( "DB Error: The record could not be added.<br>" . $e->getMessage(), 'error' );
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						} catch ( Exception $e ) {

							print $melinda->goMessage( "General Error: The record could not be added.<br>" . $e->getMessage(), 'error' );
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						}

					} else {

						try {

							$pdo->query("INSERT INTO cfc_coefficient (F_COEFF, F_TOTAL, F_POS, F_YEAR) values (:v02, :v03, :v04, :v01 )");
							$pdo->bind( ':v01', $v01 );
							$pdo->bind( ':v02', $v02 );
							$pdo->bind( ':v03', $v03 );
							$pdo->bind( ':v04', $v04 );

							$result = $pdo->execute();

							$message1 = "1 added added for :  $v01  :  $v02 :  $v03 : $v04 ";
							$message2 = "ID given: " . $pdo->lastInsertId();

							print $melinda->goMessage( $message1, 'success' );
							print $melinda->goMessage( $message2, 'info' );
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						} catch ( PDOException $e ) {

							print $melinda->goMessage( "DB Error: The record could not be added.<br>" . $e->getMessage(), 'error' );
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						} catch ( Exception $e ) {

							print $melinda->goMessage( "General Error: The record could not be added.<br>" . $e->getMessage(), 'error' );
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						}

					}

				}  else {
					?>
					<form method="post" action="<?php the_permalink();?>">

						<div class="form-group">
							<label for="F01">Year:
								<input type = "number" name = "F01" value = "" class = "form-control"/>
							</label>
						</div>

						<div class="form-group">
							<label for="F02">Coeff:
							<input type="text" name="F02" value=""  class="form-control"/>
							</label>
						</div>

						<div class="form-group">
							<label for="F03">Total:
							<input type="text" name="F03" value=""  class="form-control"/>
							</label>
						</div>

						<div class="form-group">
							<label for="F04">Rank:
							<input type="number" name="F04" value=""  class="form-control"/>
							</label>
						</div>

						<div class="form-group">
							<input name="add" type="submit" id="add" value="Submit" class="btn btn-primary"/>
						</div>
					</form>
				<?php } ?>

			<h3>UEFA Coefficients Table</h3>
			<?php
				//================================================================================
				$sql = "select F_YEAR, F_COEFF, F_TOTAL, F_POS from cfc_coefficient order by F_YEAR asc";
				outputDataTable( $sql, 'Coefficient');
				//================================================================================
			?>



		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
