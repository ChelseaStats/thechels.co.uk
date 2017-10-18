<?php /* Template Name: # o salary */ ?>
<?php get_header();?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php print $go->goAdminMenu(); ?>
			<?php
				//Get data in local variable
				$v01 = ($_POST['F01']); // company
				$v02 = ($_POST['F02']); // year
				// Check data
				if (isset($v01) && $v01!=="" && isset($v02) && $v02!=="" ) {

					try {
						$pdo = new pdodb();
						$pdo->query('INSERT INTO o_salary (F_YEAR, F_SALARY) VALUES (:v01,:v02)');
						$pdo->bind(':v01' ,$v01);
						$pdo->bind(':v02' ,$v02);
						$result = $pdo->execute();
						$message1  = "1 record inserted: $v01";
						$message2  = "ID given: ".$pdo->lastInsertId();
						$output = stripslashes($v01);

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

				}  else  {
					?>
					<form method="POST" action="<?php the_permalink();?>">

						<div class="form-group control-group">
							<label class="control-label" for="F01">Year:</label>
							<div class="controls">
								<input type="date" id="F01" name="F01" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F02">Salary:</label>
							<div class="controls">
								<input type="number" id="F02" name="F02" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group">
							<input type="submit" name="Submit" value="Submit" class="btn btn-primary"/>
						</div>

					</form>
				<?php } ?>
				
	    	<div class="clear"><br/></div>
		<?php
			//================================================================================
			$sql = "SELECT F_YEAR, F_SALARY as F_WAGE,
					round((((F_SALARY/100)*66)/12),2) as F_MONTHLY, 
					round(((((F_SALARY/100)*66)/52)/37),2) as F_HOURLY 				
					FROM o_salary ORDER BY F_YEAR asc limit 60";
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
