<?php /* Template Name: # m-referee */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// Form handler
				$ref = $go->inputUpClean($_GET['ref']);
				if (isset($ref) && $ref !='')
				{
					$referee = $go->ref($ref);
				// end form handler
					/********************************************/

					$bit = $go->goBitly("https://thechels.co.uk/analysis/referees/?ref=$ref");
					$message1 = "#Stats #CFC Results analysis of #Chelsea games with Referee: $referee -  $bit.";

					$pdo = new pdodb();
					$pdo->query('SELECT SUM(IF(F_RESULT="W",1,0)) AS W, SUM(IF(F_RESULT="D",1,0)) AS D, SUM(IF(F_RESULT="L",1,0)) AS L,
								ROUND((SUM(IF(F_RESULT="W"=1,1,0))/COUNT(*))*100,2) AS WP, ROUND((SUM(IF(F_RESULT="D"=1,1,0))/COUNT(*))*100,2) AS DP,
								ROUND((SUM(IF(F_RESULT="L"=1,1,0))/COUNT(*))*100,2) AS LP, MAX(F_DATE) as MXD, count(*) as GT FROM cfc_fixtures WHERE F_REF=:ref');
					$pdo->bind(':ref',$ref);
					$row = $pdo->row();

					$W      =$row['W'];
					$D      =$row['D'];
					$L      =$row['L'];
					$WP     =$row['WP'];
					$DP     =$row['DP'];
					$LP     =$row['LP'];
					$GT     =$row['GT'];
					$date   =$row['MXD'];

					$message2='Chelsea are W'.$W.' ('.$WP.'%), D'.$D.' ('.$DP.'%) & L'.$L.' ('.$LP.'%) of '.$GT.' games with '.$referee.' as the official.';

					$pdo = new pdodb();
					$pdo->query('SELECT F_OPP, F_FOR, F_AGAINST, F_DATE FROM cfc_fixtures WHERE F_DATE=:date');
					$pdo->bind(':date',$date);
					$row = $pdo->row();

					$OPP    = $go->_V($row['F_OPP']);
					$FX     = $row['F_FOR'];
					$AX     = $row['F_AGAINST'];
					$DX     = $row['F_DATE'];

					$message3='Our last meeting with '.$referee.' was on the '.$DX.' against '.$OPP.' when it finished '.$FX.'-'.$AX.'.';

					$melinda->goTweet($message1,'APP');
					print $melinda->goMessage($message1,'success');

					$melinda->goTweet($message2,'APP');
					print $melinda->goMessage($message2,'success');

					$melinda->goTweet($message3,'APP');
					print $melinda->goMessage($message3,'success');

					print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");

				}
				else
				{
					?>
					<form action="../" class="form">
						<div class="form-group">
							<select name="mySelectbox" class="form-control">
								<option value="" class="bolder"> -- Choose a Referee --</option>
								<?php

									$pdo = new pdodb();
									$pdo->query('SELECT DISTINCT F_REF FROM cfc_fixtures WHERE F_REF IS NOT NULL ORDER BY F_REF ASC');
									$rows = $pdo->rows();

									foreach($rows as $row) {
										?><option value="<?php the_permalink();?>?ref=<?php echo $row['F_REF']; ?>"><?php echo $row['F_REF'];  ?></option>
									<?php   } ?>
							</select>
						</div>
						<?php print $go->getSubmit(); ?>
					</form>
				<?php } ?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
