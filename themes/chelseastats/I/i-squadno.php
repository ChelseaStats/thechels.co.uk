<?php /* Template Name: # i squadno */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// define variables
				$v01 = $go->_Q($_POST['F01']);
				$v02 = $_POST['F02'];

				$v03  =  isset($_POST['F03'])  ? $_POST['F03']  : $_POST['F03'];
				$v04  =  isset($_POST['F04'])  ? $_POST['F04']  : null ;

				// Check data
				if ( isset($v01) && $v01 != "" && isset($v02) && $v02 != "" && isset($v03) && $v03 !="" && isset($v04) && $v04 !="" ) {

						try {
							$pdo = new pdodb();
							$pdo->query('INSERT INTO meta_squadno (F_NAME, F_SQUADNO, F_START, F_END) VALUES (:v1, :v2, :v3, :v4)
										on DUPLICATE KEY UPDATE F_END = :v4');
							$pdo->bind(':v1' ,$v01);
							$pdo->bind(':v2' ,$v02);
							$pdo->bind(':v3' ,$v03);
							$pdo->bind(':v4' ,$v04);

							$result = $pdo->execute();

							$message1  = "1 record inserted: $v01 ( $v02 - $v03 )";
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

					print "<p style='clear:both;'>&nbsp;</p>";


				}  else  { ?>

					<form method="POST" action="<?php the_permalink();?>">

						<div class="form-group">
							<label for="F01">Name:
							<input type="text" id="F01" name="F01" value=""  class="form-control" style="text-transform:uppercase;"/>
							</label>
						</div>

						<div class="form-group">
							<label for="F02">Number:
								<input type="number" id="F02" name="F02" value=""  class="form-control"/>
							</label>
						</div>

						<div class="form-group">
							<label for="F03">Start Date:
								<input type="date" id="F03" name="F03" value=""  class="form-control" />
							</label>
						</div>

						<div class="form-group">
							<label for="F04">End Date:
								<input type="date" id="F04" name="F04" value=""  class="form-control" />
							</label>
						</div>

						<div class="form-group">
							<input type="submit" name="Submit" value="Submit" class="btn btn-primary"/>
						</div>

					</form>
				<?php } ?>

			<p style="clear:both;">&nbsp;</p>

			<h3>Squad Number Table</h3>
			<?php
				//================================================================================
				$sql = "select F_SQUADNO , F_NAME as N_NAME, F_START as F_SDATE, F_END as F_EDATE from meta_squadno where F_END is NULL order by F_SQUADNO asc";
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
