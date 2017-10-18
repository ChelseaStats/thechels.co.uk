<?php /* Template Name: # o company */ ?>
<?php get_header();?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php print $go->goAdminMenu(); ?>
			<?php
				//Get data in local variable
				$v01 = ($_POST['F01']); // date
				$v02 = ($_POST['F02']); // label
				$v03 = ($_POST['F03']); // income/expenditure
				$v04 = ($_POST['F04']); // value


				// Check data
				if (isset($v01) && $v01!=="" && isset($v02) && $v02!=="" ) {

					try {
						$pdo = new pdodb();
						$pdo->query('INSERT INTO o_company (F_YEAR, F_LABEL, F_TYPE, F_VALUE ) VALUES (:v01,:v02,:v03,:v04)');
						$pdo->bind(':v01' ,$v01);
						$pdo->bind(':v02' ,$v02);
						$pdo->bind(':v03' ,$v03);
						$pdo->bind(':v04' ,$v04);

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
							<div class="controls">
								<label class="control-label" for="F01">Date:
									<input type="date" id="F01" name="F01" value="" class="form-control"/>
								</label>
							</div>
						</div>

						<div class="form-group control-group">
							<div class="controls">
								<label class="control-label" for="F02">label:
									<input type="text" id="F02" name="F02" value="" class="form-control"/>
								</label>
						</div>


						<div class="form-group control-group">
							<div class="controls">
								<label class="control-label" for="F03">type (i/e):
									<input type="text" id="F03" name="F03" value="" class="form-control"/>
								</label>
							</div>
						</div>

						<div class="form-group control-group">
							<div class="controls">
								<label class="control-label" for="F04">Value:
									<input type="number" id="F04" name="F04" value="" class="form-control"/>
								</label>
							</div>
						</div>

						<div class="form-group">
							<input type="submit" name="Submit" value="Submit" class="btn btn-primary"/>
						</div>

					</form>
				<?php } ?>
			<div class="clear"><br/></div>
			<?php
				$date = date('Y');
				//================================================================================
				$sql = "SELECT year(F_YEAR) as F_YEAR, F_LABEL, F_TYPE as company_type, F_VALUE FROM o_company
						WHERE year(F_YEAR) = '$date' ORDER BY F_TYPE desc, F_VALUE desc limit 60";
				outputDataTable( $sql, 'small');
				//================================================================================
			?>

			<?php
				//================================================================================
				$sql = "SELECT year(F_YEAR) as F_YEAR,
						sum((if((F_TYPE = 'income'),F_VALUE,0))) AS F_INCOME,
						sum((if((F_TYPE = 'expenditure'),F_VALUE,0))) AS F_EXPENDITURE,
						(sum((if((F_TYPE = 'income'),F_VALUE,0))) - sum((if((F_TYPE = 'expenditure'),F_VALUE,0)))) AS F_BALANCE
						FROM o_company group by year(F_YEAR)";
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
