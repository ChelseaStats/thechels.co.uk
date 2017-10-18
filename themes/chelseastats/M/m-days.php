<?php /*  Template Name: # m-days */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				// Form handler
				$day=$go->inputUpClean($_GET['day']);
				if (isset($day) && $day!='')  {

					$pdo = new pdodb();
					$pdo->query('SELECT DAYNAME(F_DATE) AS Y,
						SUM(IF(F_RESULT="W"=1,1,0)) AS W, ROUND(SUM(IF(F_RESULT="W"=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS WP,
						SUM(IF(F_RESULT="D"=1,1,0)) AS D, ROUND(SUM(IF(F_RESULT="D"=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS DP,
						SUM(IF(F_RESULT="L"=1,1,0)) AS L, ROUND(SUM(IF(F_RESULT="L"=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS LP,
						COUNT(*) AS P FROM cfc_fixtures WHERE DAYNAME(F_DATE)=:day');
					$pdo->bind(':day',$day);
					$row = $pdo->row();

					$Y	= ucwords(strtolower($row['Y']));
					$W	= $row['W'];
					$WP	= $row['WP'];
					$D	= $row['D'];
					$DP	= $row['DP'];
					$L	= $row['L'];
					$LP	= $row['LP'];
					$P	= $row['P'];

					$message1="#stats It's $Y. Great! #Chelsea are W$W ($WP%), D$D ($DP%) & L$L ($LP%) of $P games played on a $Y #cfc";

					$melinda->goTweet($message1,'APP');
					print $melinda->goMessage($message1,'success');

////////////////////////////////////////////////////////////////////////////////

					$pdo->query('SELECT DAYNAME(F_DATE) AS Y, SUM(IF(F_RESULT="W"=1,1,0)) AS W,
						ROUND(SUM(IF(F_RESULT="W"=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS WP, SUM(IF(F_RESULT="D"=1,1,0)) AS D,
						ROUND(SUM(IF(F_RESULT="D"=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS DP, SUM(IF(F_RESULT="L"=1,1,0)) AS L,
						ROUND(SUM(IF(F_RESULT="L"=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS LP, COUNT(*) AS P
						FROM (SELECT * FROM cfc_fixtures WHERE DAYNAME(F_DATE)=:day ORDER BY F_DATE DESC LIMIT 10) B');
					$pdo->bind(':day',$day);
					$row = $pdo->row();
					$Y2  = ucwords(strtolower($row['Y']));
					$W2  = $row['W'];
					$WP2 = $row['WP'];
					$D2  = $row['D'];
					$DP2 = $row['DP'];
					$L2  = $row['L'];
					$LP2 = $row['LP'];
					$P2  = $row['P'];

					$message2="#stats including a W$W2 ($WP2%), D$D2 ($DP2%) & L$L2 ($LP2%) record from our last $P2 games played on a $Y2 #cfc";

					$melinda->goTweet($message2,'APP');
					print   $melinda->goMessage($message2,'success');

////////////////////////////////////////////////////////////////////////////////			

					$pdo->query('SELECT F_DATE AS DD, F_OPP AS T, F_FOR AS F, F_AGAINST AS A, F_LOCATION AS L FROM cfc_fixtures
                         WHERE DAYNAME(F_DATE)=:day ORDER BY F_DATE DESC LIMIT 1');
					$pdo->bind(':day',$day);
					$row = $pdo->row();
					$T3	= $go->_V($row['T']);
					$F3	= $row['F'];
					$A3	= $row['A'];
					$L3	= $go->local($row['L']);
					$DD	= $row['DD'];
					$D3=ucwords(strtolower($day));

					$message3="#stats our last match on a $D3 was against $T3 $L3 it finished ($F3 - $A3) date:($DD) #cfc";

					$melinda->goTweet($message3,'APP');
					print   $melinda->goMessage($message3,'success');

////////////////////////////////////////////////////////////////////////////////
					print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),'GO');
				}
				else  {
					?>
					<form action="../" class="form">
						<div class="form-group">
							<select name="mySelectbox" class="form-control">
								<option value="" class="bolder"> -- Choose a Day --</option>
								<option value="<?php the_permalink();?>?day=Monday">Monday</option>
								<option value="<?php the_permalink();?>?day=Tuesday">Tuesday</option>
								<option value="<?php the_permalink();?>?day=Wednesday">Wednesday</option>
								<option value="<?php the_permalink();?>?day=Thursday">Thursday</option>
								<option value="<?php the_permalink();?>?day=Friday">Friday</option>
								<option value="<?php the_permalink();?>?day=Saturday">Saturday</option>
								<option value="<?php the_permalink();?>?day=Sunday">Sunday</option>
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
