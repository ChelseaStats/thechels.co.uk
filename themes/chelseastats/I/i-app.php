<?php /* Template Name: # i app */ ?>
<?php get_header();?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php print $go->goAdminMenu(); ?>
			<?php
				//Get data in local variable

				$v01 = mt_rand('1','24'); // get random number
				$v02 = $_POST['F02'];
				$v03 = str_replace('@','',$_POST['F03']);
				$v04 = date("Y-m-d");
				$insert       = empty($_POST['insert']) ? '0' : $_POST['insert'];  // switch insert(1) or not(0)
				// Check data
				if ( $v01!=="" && $v02!=="" && $v03!=="" && $v04!=="" ) {


					try {
						$pdo = new pdodb();
						$pdo->query('INSERT INTO o_appstats (F_IMAGEID, F_TEXT, F_AUTHOR, F_DATE ) VALUES (:v1,:v2,:v3,:v4)');
						$pdo->bind(':v1' ,$v01);
						$pdo->bind(':v2' ,$v02);
						$pdo->bind(':v3' ,$v03);
						$pdo->bind(':v4' ,$v04);
						$result = $pdo->execute();

						$message1  = "1 record inserted: $v02 by @$v03";
						$message2  = "ID given: ".$pdo->lastInsertId();
						$output = stripslashes($v02);

						$melinda->goHooks("{$output} - (via @{$v03}).",'m.thechels.uk','114');
						$melinda->goSlack("{$output} - (via @{$v03}).",'Stat Bot','cfc','bots');

						if($v03 ='ChelseaStats' && isset($insert) && $insert == '1'):
							$melinda->goTweet("{$output} - https://m.thechels.uk","APP");
						endif;

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
					
<script>
      function countChar(val) {
        var len = val.value.length;
        if (len >= 140) {
          val.value = val.value.substring(0, 120);
        } else {
          $('#charNum').text(120 - len);
        }
      }
</script>
					<form method="POST" action="<?php the_permalink();?>">


						<div class="form-group">
							<label for="F02">Text: (<span id="charNum"></span>)</label>
							<textarea onkeyup="countChar(this)" rows="3" name="F02" id="F02" style="width:90%;" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="F03">Author:</label>
							<input type="text" name="F03" id="F03" value="" class="form-control"/>
						</div>
   						
   						
						
						<div class="form-group">
							<div class="checkbox">
								<label for="insert">Check to tweet this
									<input type="checkbox" id="insert" name="insert" value="1" />
								</label>
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
