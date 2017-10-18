<?php /* Template Name: # o-films */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// define variables
				$v01 = (strtoupper($_POST['F01']));
				$v02 = ($_POST['F02']);


				if(isset($v01) && $v01!='') {
					$imdb = new imdb();
					$film = $imdb->getMovieInfo( $v01, $getExtraInfo = FALSE );
					
					$v01  = strtoupper($film['title']);
					$v03  = $film['title_id'];
					$v04  = $film['year'];

					// Check data
					if ( isset($v01) && $v01!="" && $v02!="" && $v03!="" && $v04 !="" ) {

							try {
								$pdo = new pdodb();
								$pdo->query('INSERT INTO o_lists_films (F_TITLE, F_RATING, F_IMDB, F_YEAR) VALUES (:v1,:v2,:v3,:v4)');
								$pdo->bind(':v1' ,$v01);
								$pdo->bind(':v2' ,$v02);
								$pdo->bind(':v3' ,$v03);
								$pdo->bind(':v4' ,$v04);

								$result = $pdo->execute();

								$message1  = "1 record inserted: $v01 $v02 $v03 $v04";
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

					}

				}  else  {

					?>

					<form method="POST" action="<?php the_permalink();?>">

						<div class="form-group">
							<label for="F01">title (it is ok to include year too):<br/>
							<input type="text" id="F01" name="F01" value=""  class="form-control" style="text-transform:uppercase;"/>
							</label>
						</div>

						<div class="form-group">
							<label for="F02">rating:<br/>
							<input type="text" id="F02" name="F02" value=""  class="form-control"/>
							</label>
						</div>


						<div class="form-group">
							<input type="submit" name="Submit" value="Submit" class="btn btn-primary"/>
						</div>

					</form>
					<div class="clear"><br/></div>
					<?php  } ?>


			<?php
				print '<div class="clear" style="clear:both;"><br/></div>';
				//================================================================================
				$sql = "SELECT F_TITLE, F_RATING, F_IMDB, F_YEAR FROM o_lists_films order by F_ID desc limit 20";
				outputDataTable( $sql, 'small');
				//================================================================================

			?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
