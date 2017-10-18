<?php /* Template Name: # m-per90 */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// Form handler
				$tweet=$_GET['tw'];
				if (isset($tweet) && $tweet !='')  {
					switch ($tweet) {
						/********************************************************************************************************************/
						case 'T01': //  CFC
							$sql="SELECT F_NAME N, GP90 V FROM 0V_base_Per90s ORDER BY V DESC LIMIT 0,3";
							$url="http://thechels.uk/top3cfc";
							$message="#CFC's top 3 #PL players for goals per 90: ";
							break;
						/********************************************************************************************************************/
						case 'T02': // CFC
							$sql="SELECT F_NAME N, AP90 V FROM 0V_base_Per90s ORDER BY V DESC LIMIT 0,3";
							$url="http://thechels.uk/top3cfc";
							$message="#CFC's top 3 #PL players for assists per 90: ";
							break;
						/********************************************************************************************************************/
						case 'T03': // CFC
							$sql="SELECT F_NAME N, PP90 V FROM 0V_base_Per90s ORDER BY V DESC LIMIT 0,3";
							$url="http://thechels.uk/top3cfc";
							$message="#Chelsea's top 3 #PL players for g+a per 90: ";
							break;
						/********************************************************************************************************************/
						case 'T04': // CFC
							$sql="SELECT F_NAME N, FSP90 V FROM 0V_base_Per90s ORDER BY V DESC LIMIT 0,3";
							$url="http://thechels.uk/top3cfc";
							$message="#CFC's top 3 #PL players fouls suffered per 90: ";
							break;
						/********************************************************************************************************************/
						case 'T05': // CFC
							$sql="SELECT F_NAME N, (F_SHOTS/(F_MINS/90)) V FROM 0V_base_Per90s ORDER BY V DESC LIMIT 0,3";
							$url="http://thechels.uk/top3cfc";
							$message="#CFC's top 3 #PL players total shots per 90: ";
							break;
						/********************************************************************************************************************/
						case 'T06': // CFC
							$sql="SELECT F_NAME N, (F_SHOTSON/(F_MINS/90))  V FROM 0V_base_Per90s ORDER BY V DESC LIMIT 0,3";
							$url="http://thechels.uk/top3cfc";
							$message="#CFC's top 3 #PL players shots on target per 90: ";
							break;
						case 'T07': //  CFC
							$sql="SELECT F_NAME N, GP90 V FROM 0V_base_WSL_Per90s ORDER BY V DESC LIMIT 0,3";
							$url="http://thechels.uk/1zb7eX2";
							$message="#CLFC Top 3 ladies for goals per90 (all comps): ";
							break;
						/********************************************************************************************************************/
						default:
							exit();
							break;
						/********************************************************************************************************************/
					}

					$pdo = new pdodb();
					$pdo->query($sql);
					$rows = $pdo->rows();

					foreach($rows as $row) {
						$ns[] = $row['N'];
						$vs[] = $row['V'];
					}

					$n0=$ns[0];
					$v0=$vs[0];
					$n1=$ns[1];
					$v1=$vs[1];
					$n2=$ns[2];
					$v2=$vs[2];

					$nv1= $go->_V($n0.' ('.$v0.'), '.$n1.' ('.$v1.') & '.$n2.' ('.$v2.')');
					$nv=ucwords(strtolower($nv1));
					$message = $message.' '.$nv.' - '.$url;
					$melinda->goTweet($message,'APP');
					print $melinda->goMessage($message,'success');
					print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");

				} else {
					/********************************************************************************************************************/
					?>
					<form action="../" class="form">
						<div class="form-group">
							<select name="mySelectbox" class="form-control">
								<option value="" class="bolder">-- Choose a stat type --</option>
								<option value="<?php the_permalink();?>?tw=T01">Goals Per 90</option>
								<option value="<?php the_permalink();?>?tw=T02">Assists per 90</option>
								<option value="<?php the_permalink();?>?tw=T03">Points per 90</option>
								<option value="<?php the_permalink();?>?tw=T04">fouls suffered per 90</option>
								<option value="<?php the_permalink();?>?tw=T05">Total Shots per 90</option>
								<option value="<?php the_permalink();?>?tw=T06">Shots on per 90</option>
								<option value="<?php the_permalink();?>?tw=T07">WSL Goals Per 90</option>


							</select>
						</div>
						<?php print $go->getSubmit(); ?>
					</form>
					<div class="clearfix"><p>&nbsp;</p></div>
				<?php } ?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>