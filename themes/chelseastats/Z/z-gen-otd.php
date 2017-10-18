<?php /* Template Name:  # Z ** Gen OnThisDay */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<h1>On This Day</h1>
			<h3>Results Summary from this day in history</h3>
			<?php
				$pdo = new pdodb();
				$pdo->query("SELECT F_DATE, SUM(IF(F_RESULT='W'=1,1,0)) AS F_WIN, SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAW, SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSS, COUNT(*) AS F_TOTAL
             FROM cfc_fixtures WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now() + INTERVAL 0 DAY))");
				$row = $pdo->row();
				$W=$row['F_WIN'];
				$D=$row['F_DRAW'];
				$L=$row['F_LOSS'];
				$T=$row['F_TOTAL'];
				$I=$row['F_DATE'];
				$I=explode('-',$I);
				$I=$I[1].'-'.$I[2];
				if  ( $T > 0 ) {
					print '<p>On This Day (' . $I . ') - Chelsea played ' . $T . ', winning ' . $W . ', drawing ' . $D . ' and losing ' . $L . '.<br/>';
				}

				$pdo = new pdodb();
				$pdo->query("SELECT F_DATE, SUM(IF(F_RESULT='W'=1,1,0)) AS F_WIN, SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAW, SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSS, COUNT(*) AS F_TOTAL
             FROM wsl_fixtures WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now() + INTERVAL 0 DAY))");
				$row = $pdo->row();
				$W=$row['F_WIN'];
				$D=$row['F_DRAW'];
				$L=$row['F_LOSS'];
				$T=$row['F_TOTAL'];
				$I=$row['F_DATE'];
				$I=explode('-',$I);
				$I=$I[1].'-'.$I[2];
				if  ( $T > 0 ) {
					print 'On This Day (' . $I . ') - Chelsea Ladies played ' . $T . ', winning ' . $W . ', drawing ' . $D . ' and losing ' . $L . '.</p>';
				}

			?>
			<p style="text-align:justify;">For a detailed look at those results see our <a href="/otd/" title="Chelsea FC On This Day by ChelseaStats">On This Day page</a>.</p>
			<h3>Key events on this day in history</h3>
			<p>
				<?php
					$pdo = new pdodb();
					$pdo->query("SELECT F_NAME, F_NOTES, F_DATE, YEAR(F_DATE) as F_YEAR FROM cfc_dates
       WHERE MONTH(F_DATE) =(SELECT MONTH(now())) 
       AND DAY(F_DATE)=(SELECT DAY(now() + INTERVAL 0 DAY)) 
       ORDER BY F_DATE DESC");
					$rows = $pdo->rows();
					foreach($rows as $row) {
						print "On This Day (".$row['F_YEAR'].") - ".$go->_V($row['F_NAME'])." - ".$row['F_NOTES']."<br/>";
					}
					print '</p><p><strong>'. $row['F_DATE'] .'</strong></p>';
				?>
			<h1>On This Day +1</h1>
			<h3>Results Summary from this day in history</h3>
			<?php
				$pdo = new pdodb();
				$pdo->query("SELECT F_DATE, SUM(IF(F_RESULT='W'=1,1,0)) AS F_WIN, SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAW, SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSS, COUNT(*) AS F_TOTAL
             FROM cfc_fixtures WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now() + INTERVAL 1 DAY))");
				$row = $pdo->row();
				$W=$row['F_WIN'];
				$D=$row['F_DRAW'];
				$L=$row['F_LOSS'];
				$T=$row['F_TOTAL'];
				$I=$row['F_DATE'];
				$I=explode('-',$I);
				$I=$I[1].'-'.$I[2];
				if  ( $T > 0 ) {
					print '<p>On This Day (' . $I . ') - Chelsea played ' . $T . ', winning ' . $W . ', drawing ' . $D . ' and losing ' . $L . '.<br/>';
				}

				$pdo = new pdodb();
				$pdo->query("SELECT F_DATE, SUM(IF(F_RESULT='W'=1,1,0)) AS F_WIN, SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAW, SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSS, COUNT(*) AS F_TOTAL
             FROM wsl_fixtures WHERE MONTH(F_DATE) =(SELECT MONTH(now())) AND DAY(F_DATE)=(SELECT DAY(now() + INTERVAL 1 DAY))");
				$row = $pdo->row();
				$W=$row['F_WIN'];
				$D=$row['F_DRAW'];
				$L=$row['F_LOSS'];
				$T=$row['F_TOTAL'];
				$I=$row['F_DATE'];
				$I=explode('-',$I);
				$I=$I[1].'-'.$I[2];
				if  ( $T > 0 ) {
					print 'On This Day (' . $I . ') - Chelsea Ladies played ' . $T . ', winning ' . $W . ', drawing ' . $D . ' and losing ' . $L . '.</p>';
				}

			?>
			<p style="text-align:justify;">For a detailed look at those results see our <a href="/otd/" title="Chelsea FC On This Day by ChelseaStats">On This Day page</a>.</p>
			<h3>Key events on this day in history</h3>
			<p>
				<?php
					$pdo = new pdodb();
					$pdo->query("SELECT F_NAME, F_NOTES, F_DATE, YEAR(F_DATE) as F_YEAR FROM cfc_dates
       WHERE MONTH(F_DATE) =(SELECT MONTH(now())) 
       AND DAY(F_DATE)=(SELECT DAY(now() + INTERVAL 1 DAY)) 
       ORDER BY F_DATE DESC");
					$rows = $pdo->rows();
					foreach($rows as $row) {
						print "On This Day (".$row['F_YEAR'].") - ".$go->_V($row['F_NAME'])." - ".$row['F_NOTES']."<br/>";
					}
					print '</p><p><strong>'. $row['F_DATE'] .'</strong></p>';
				?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
