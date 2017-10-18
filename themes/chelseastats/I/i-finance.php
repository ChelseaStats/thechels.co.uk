<?php /* Template Name: # i finance */ ?>
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
				$v03 = ($_POST['F03']); // turnover
				$v04 = ($_POST['F04']); // pl
				$v05 = ($_POST['F05']); // wage
				$v06 = ($_POST['F06']); // strgl
				$v07 = ($_POST['F07']); // transfer
				$v08 = ($_POST['F08']); // squad
				if($v03 > 0) { $v09 = round(($v05 / $v03),6); } else { $v09 = 0;}; // ratio
				$v10 = ($_POST['F09']); // play staff
				$v11 = ($_POST['F10']); // nonstaff
				$v12 = $v10 + $v11; //totalstaff
				if($v05 > 0) { $v13 = round(($v05 / $v12),6); } else { $v13 = 0;}; //avgsal

				// Check data
				if (isset($v01) && $v01!=="" && isset($v02) && $v02!=="" ) {

					try {
						$pdo = new pdodb();
						$pdo->query('INSERT INTO cfc_finances (F_COMPANY, F_YEAR, F_TURNOVER, F_PL, F_WAGE, F_STRGL, F_TRANSFER,
															  F_SQUAD, F_RATIO, F_PLAYSTAFF, F_NONPSTAFF, F_TOTSTAFF, F_AVGSAL)
									VALUES (:v01,:v02,:v03,:v04,:v05,:v06,:v07,:v08,:v09,:v10,:v11,:v12,:v13)');
						$pdo->bind(':v01' ,$v01);
						$pdo->bind(':v02' ,$v02);
						$pdo->bind(':v03' ,$v03);
						$pdo->bind(':v04' ,$v04);
						$pdo->bind(':v05' ,$v05);
						$pdo->bind(':v06' ,$v06);
						$pdo->bind(':v07' ,$v07);
						$pdo->bind(':v08' ,$v08);
						$pdo->bind(':v09' ,$v09);
						$pdo->bind(':v10' ,$v10);
						$pdo->bind(':v11' ,$v11);
						$pdo->bind(':v12' ,$v12);
						$pdo->bind(':v13' ,$v13);


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
							<label class="control-label" for="F01">Business:</label>
							<div class="controls">
								<input type="text" id="F01" name="F01" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F02">Year:</label>
							<div class="controls">
								<input type="text" id="F02" name="F02" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F03">Turnover:</label>
							<div class="controls">
								<input type="text" id="F03" name="F03" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F04">Profit/Loss:</label>
							<div class="controls">
								<input type="text" id="F04" name="F04" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F05">Wages:</label>
							<div class="controls">
								<input type="text" id="F05" name="F05" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F06">STRGL:</label>
							<div class="controls">
								<input type="text" id="F06" name="F06" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F07">Transfer:</label>
							<div class="controls">
								<input type="text" id="F07" name="F07" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F08">Squad Value:</label>
							<div class="controls">
								<input type="text" id="F08" name="F08" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F09">Playing Staff:</label>
							<div class="controls">
								<input type="text" id="F09" name="F09" value="" class="form-control"/>
							</div>
						</div>

						<div class="form-group control-group">
							<label class="control-label" for="F10">Non Playing Staff:</label>
							<div class="controls">
								<input type="text" id="F10" name="F10" value="" class="form-control"/>
							</div>
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
