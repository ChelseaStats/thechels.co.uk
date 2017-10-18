<?php /* Template Name: # i wsl results */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				//Get data in local variable
				$v01 = $_POST['F01']; //date
				$v02 = $go->_Q($_POST['F02']); //team
				$v03 = $_POST['F03']; // for
				$v04 = $_POST['F04']; // against
				$v05 = $_POST['F05']; // location
				$v06 = $_POST['F06']; // result
				$v07 = $_POST['F07']; // attendance
				$v08 = $_POST['F08']; // referee
				$v09 = $_POST['F09']; // time
				$v10 = strtoupper($_POST['F10']); // COMP
				$v11 = $_POST['F11']; // minutes

				// check for null values
				// Notes can be null
				// field F_ID is auto-incremental
				if (isset($v01) && $v01!=="" && $v02!=="" && $v03!=="" && $v04!=="" && $v05!=="" && $v06!=="") {

					try {
						$pdo = new pdodb();
						$pdo->query('INSERT INTO wsl_fixtures (F_DATE, F_MINUTES, F_OPP, F_FOR, F_AGAINST, F_LOCATION, F_RESULT, F_ATT, F_REF, F_TIME, F_COMPETITION)
	                                 VALUES (:v01, :v11, :v02, :v03, :v04, :v05, :v06, :v07, :v08, :v09, :v10)');

						$pdo->bind(':v01' , $v01);
						$pdo->bind(':v02' , $v02);
						$pdo->bind(':v03' , $v03);
						$pdo->bind(':v04' , $v04);
						$pdo->bind(':v05' , $v05);
						$pdo->bind(':v06' , $v06);
						$pdo->bind(':v07' , $v07);
						$pdo->bind(':v08' , $v08);
						$pdo->bind(':v09' , $v09);
						$pdo->bind(':v10' , $v10);
						$pdo->bind(':v11' , $v11);

						$result = $pdo->execute();

						$message1 ="1 row added for  ". $v01 ." : ". $v02 ." : ". $v03 ." : ". $v04;
						$message2 ="ID given: ".$pdo->lastInsertId();


						print $melinda->goMessage($message1,'success');
						print $melinda->goMessage($message2,'info');


						print $go->getAnother("/a/z-match-events-f/","Add Events");
						print $go->getAnother("/a/z-get-stato-f/","Add Player Stats");

						print $go->getOptionMenu();



					} catch (PDOException $e) {

						print $melinda->goMessage( "DB Error: The record could not be added.<br>".$e->getMessage(), 'error' );
						print $go->getOptionMenu();

					} catch (Exception $e) {

						print $melinda->goMessage( "General Error: The record could not be added.<br>".$e->getMessage() , 'error');
						print $go->getOptionMenu();

					}


					$checklist = new checklister();
					print $checklist->generateIssue( "new match: {$v02}" , $checklist->checklist_wsl_results() );
				}

				else {
					?>
					<form method="post" action="<?php the_permalink();?>">

						<div class="form-group">
							<label for="F01">Date: </label>
								<input type="date" class="form-control" name="F01" value=""/>
							
						</div>

						<div class="form-group">
							<label for="F11">Minutes: </label>
								<input type="number" class="form-control" name="F11" value="90"/>
						
						</div>

						<div class="form-group">
							<label for="F02">Team: </label>
								<input type="text" class="form-control" name="F02" value=""/>
						
						</div>

						<div class="form-group">
							<label for="F03">For: </label>
								<input type="number" class="form-control" name="F03" value=""/>
						
						</div>

						<div class="form-group">
							<label for="F04">Against: </label>
								<input type="number" class="form-control" name="F04" value=""/>
							
						</div>
						
							<div class="form-group"><label for="F05">Location: </label>
								    <select name="F05">
	                    <option value="H">H</option>
	                    <option value="A">A</option>
	                    <option value="N">N</option>
	                   </select>
	                   
							</div>

								<div class="form-group"><label for="F06">Result: </label>
								     <select name="F06">
	                    <option value="W">W</option>
	                    <option value="D">D</option>
	                    <option value="L">L</option>
	                   </select>
	                  
								</div>

						<div class="form-group">
							<label for="F07">Attendance: </label>
								<input type="number" class="form-control" name="F07" value=""/>
							
						</div>

						<div class="form-group">
							<label for="F08">Referee: </label>
								<input type="text" class="form-control" name="F08" value=""/>
						
						</div>
			
						<div class="form-group">
						    <label for="F09">Time: </label>
									<input id="F09" type="time" name="F09" value="14:00"/>
								
						</div>
						
						
								<div class="form-group"><label for="F10">Competition: </label>
									   <select name="F10">
	                    <option value="WSL">WSL</option>
	                    <option value="UWCL">UWCL</option>
	                    <option value="CC">CC</option>  
	                    <option value="FAC">FA Cup</option>
	                   </select>
	                  
	               </div>    

						<div class="form-group">
							<input name="add" type="submit" id="add" value="Submit" class="btn btn-primary" /></div>

					</form>
				<?php } ?>
		</div>
		<?php get_template_part('wsl-sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
