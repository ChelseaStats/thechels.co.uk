<?php /* Template Name:# i CFC Results */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<div class="span 12">
				<?php
					//Get data in local variable
					$v01=$_POST['F01']; //date
					$v02a=strtoupper($_POST['F02']); //nice opp
					$v02=str_replace(" ","_",$v02a); // tidier
					$v03=$_POST['F03']; // for
					$v04=$_POST['F04']; // against
					$v05=strtoupper($_POST['F05']); // location
					$v06=strtoupper($_POST['F06']); // result
					$v07=$_POST['F07']; // attendance
					$v08=strtoupper($_POST['F08']); // referee
					$v09=$_POST['F09']; // time
					$v10=$_POST['F10']; // possession
					$v11=$_POST['F11']; // Corners For
					$v12=$_POST['F12']; // Corners Against
					$v13=$_POST['F13']; // Fouls
					$v14=$_POST['F14']; // Fouls
					$v15=$_POST['F15']; // Shots for
					$v16=$_POST['F16']; // Shots Against
					$v17=$_POST['F17']; // Shots ON for
					$v18=$_POST['F18']; // Shots ON Against
					$v19=$_POST['F19']; // COMP
					$v21=strtoupper($_POST['F21']); // country
					$v22=$_POST['F22']; //nice oppo mgr
					$v23=$_POST['F23']; // minutes
					// check for null values
					// Notes can be null
					// field F_ID is auto-incremental
					if (isset($v01) && $v01!=="" && $v02!=="" && $v03!=="" && $v04!=="" && $v05!=="" && $v06!=="")  {


						try {
							$pdo = new pdodb();
							$pdo->query('INSERT INTO cfc_fixtures (F_DATE, F_OPP, F_RESULT, F_LOCATION,
								        F_FOR, F_AGAINST, F_REF, F_ATT, F_TIME, F_POSSESSION, F_H_CORNERS, F_A_CORNERS, F_H_FOULS,
								        F_A_FOULS, F_H_ATTEMPTSOFF, F_A_ATTEMPTSOFF, F_H_ATTEMPTSON, F_A_ATTEMPTSON, F_COMPETITION,
								        F_COUNTRY, F_MINUTES)  VALUES (:v01, :v02, :v06, :v05, :v03, :v04, :v08, :v07, :v09, :v10, :v11, :v12,
								        :v13, :v14, :v15, :v16, :v17, :v18, :v19, :v21, :v23)');

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
							$pdo->bind(':v14' ,$v14);
							$pdo->bind(':v15' ,$v15);
							$pdo->bind(':v16' ,$v16);
							$pdo->bind(':v17' ,$v17);
							$pdo->bind(':v18' ,$v18);
							$pdo->bind(':v19' ,$v19);
							$pdo->bind(':v21' ,$v21);
							$pdo->bind(':v23' ,$v23);

							$result = $pdo->execute();

							$message1 = "1 row added for  ". $v01 ." : ". $v02 ." : ". $v03 ." : ". $v04;
							$message2 = "ID given: ".$pdo->lastInsertId();

							print $melinda->goMessage($message1,'success');
							print $melinda->goMessage($message2,'info');



						} catch (PDOException $e) {

							print $melinda->goMessage( "DB Error: The record could not be added.<br>".$e->getMessage(), 'error' );
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						} catch (Exception $e) {

							print $melinda->goMessage( "General Error: The record could not be added.<br>".$e->getMessage() , 'error');
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						}

					}

					if ( isset($v06) && $v06!==""  && $v22!=="" ) {

						try {

							$pdo = new pdodb();

							$explode =  explode(',',$v22);
							$oppo_sur = str_replace(" ","_",$explode[0]);
							$opp_fir  = str_replace(" ","_",$explode[1]);

							switch ( $v06 ) {
								case 'W':
									$pdo->query( 'INSERT INTO cfc_oppomgr (FullName,Sname,Fname,First,Last,PLD,W,D,L)  VALUES (:m2,:sn,:fn,:m1,:m1,"1","1","0","0") ON DUPLICATE KEY
	                                  UPDATE W=(W+1), LAST = :m1, PLD = (PLD+1) ');
									break;
								case 'D':
									$pdo->query( 'INSERT INTO cfc_oppomgr (FullName,Sname,Fname,First,Last,PLD,W,D,L)  VALUES (:m2,:sn,:fn,:m1,:m1,"1","0","1","0") ON DUPLICATE KEY
	                                  UPDATE D=(D+1), LAST = :m1, PLD = (PLD+1) ');
									break;
								case 'L':
									$pdo->query( 'INSERT INTO cfc_oppomgr (FullName,Sname,Fname,First,Last,PLD,W,D,L) VALUES (:m2,:sn,:fn,:m1,:m1,"1","0","0","1") ON DUPLICATE KEY
	                                  UPDATE L=(L+1), LAST = :m1, PLD = (PLD+1) ');
									break;
							}
							$pdo->bind( ':sn', $oppo_sur);
							$pdo->bind( ':fn', $opp_fir);
							$pdo->bind( ':m1', $v01 );
							$pdo->bind( ':m2', $v22 );
							$result       = $pdo->execute();
							$message_Mgr3 = "1 manager updated or inserted: " . $v01 . " :  " . $v22 . " :";
							print $melinda->goMessage( $message_Mgr3, 'success' );


							$checklist = new checklister();
							// Check competition
							if($v19 == 'PREM') {
								print $checklist->generateIssue( "new match: {$v02}", $checklist->checklist_cfc_results() );
							} else {
								print $checklist->generateIssue( "new match: {$v02}", $checklist->checklist_cfc_results_nonPL() );
							}


							print '<div class="row-fluid span12">';
							print $go->getAnother("/a/z-get-stato-m/","Get Stats");
							print '</div>';

						} catch (PDOException $e) {

							print $melinda->goMessage( "DB Error: The record could not be added.<br>".$e->getMessage(), 'error' );
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						} catch (Exception $e) {

							print $melinda->goMessage( "General Error: The record could not be added.<br>".$e->getMessage() , 'error');
							print $go->getAnother( strtok( $_SERVER["REQUEST_URI"], '?' ), "Again" );

						}






					} else {
						?>
						<form method="post" action="<?php the_permalink();?>" autocapitalize="characters">
							<div class="span5">

								<div class="form-group"><label for="F01">Date:</label>
									<input id="F01" type="date" name="F01" value="<?php echo date('Y-m-d') ?>"/></div>

								<div class="form-group"><label for="F02">Nice Team:</label>
									<input id="F02" type="text" name="F02" value=""  style="text-transform:uppercase;"
									       on keyup="javascript:this.value=this.value.toUpperCase();"/></div>

								<div class="form-group"><label for="F03">For:</label>
									<input id="F03" type="number" name="F03" value=""/></div>

								<div class="form-group"><label for="F04">Against:</label>
									<input id="F04" type="number" name="F04" value=""/></div>

								<div class="form-group"><label for="F05">Location:</label>
								    <select name="F05">
	                    <option value="H">H</option>
	                    <option value="A">A</option>
	                    <option value="N">N</option>
	                   </select>
									</div>

								<div class="form-group"><label for="F06">Result:</label>
								     <select name="F06">
	                    <option value="W">W</option>
	                    <option value="D">D</option>
	                    <option value="L">L</option>
	                   </select>
								</div>

								<div class="form-group"><label for="F19">Competition:</label>
									   <select name="F19">
	                    <option value="PREM">Premier League</option>
	                    <option value="UCL">UCL</option>
	                    <option value="UEL">Europa</option>
	                    <option value="ESC">European Super Cup</option>            
	                    <option value="FAC">FA Cup</option>
	                    <option value="LC">League Cup</option>
	                    <option value="CS">Comm Shield</option>
	                   </select>
	               </div>    
									
								<div class="form-group"><label for="F07">Attendance:</label>
									<input id="F07" type="text" name="F07" value=""/></div>

								<div class="form-group"><label for="F08">Referee:</label>
									<input id="F08" type="text" name="F08" value=""
									       style="text-transform:uppercase;" on keyup="javascript:this.value=this.value.toUpperCase();"/>
								</div>

								<div class="form-group"><label for="F09">Time:</label>
									<input id="F09" type="time" name="F09" value="15:00"/></div>

								<div class="form-group"><label for="F21">Country:</label>
									<input id="F21" type="text" name="F21" value="England"
									       style="text-transform:uppercase;" on keyup="javascript:this.value=this.value.toUpperCase();"/>
								</div>

								<div class="form-group"><label for="F23">Minutes:</label>
									<input id="F23" type="number" name="F23" value="90"/>
								</div>

							</div>

							<div class="span5">
								<div class="form-group"><label for="F10">Possession:</label>
									<input id="F10" type="text" name="F10" value=""/></div>

								<div class="form-group"><label for="F11">Corners For:</label>
									<input id="F11" type="number" name="F11" value=""/></div>

								<div class="form-group"><label for="F12">Corners Against:</label>
									<input id="F12" type="number" name="F12" value=""/></div>

								<div class="form-group"><label for="F13">Fouls Committed:</label>
									<input id="F13" type="number" name="F13" value=""/></div>

								<div class="form-group"><label for="F14">Fouls Suffered:</label>
									<input id="F14" type="number" name="F14" value=""/></div>

								<div class="form-group"><label for="F15">Shots For:</label>
									<input id="F15" type="number" name="F15" value=""/></div>

								<div class="form-group"><label for="F16">Shots Against:</label>
									<input id="F16" type="number" name="F16" value=""/></div>

								<div class="form-group"><label for="F17">Shots On For:</label>
									<input id="F17" type="number" name="F17" value=""/></div>

								<div class="form-group"><label for="F18">Shots On Against:</label>
									<input id="F18" type="number" name="F18" value=""/></div>

								<div class="form-group"><label for="F22">Opposition MGR:</label>
									<input id="F22" type="text" name="F22" value=""/></div>

								<div class="form-group">
									<input name="add" type="submit" id="add" value="Submit" class="btn btn-primary" />
								</div>
							</div>
						</form>
					<?php } ?>
			</div>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
