<?php /* Template Name: # Z ** Updater Minutes */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
	<div id="contentleft">
	<?php print $go->goAdminMenu(); ?>
	<h4 class="special"> <?php the_title(); ?></h4>
	<?php
	$v01        = $_POST['F01']; //checker
	$submit     = $_POST['submit']; //checker
	$type       = empty($_POST['type']) ? '0' : $_POST['type'];  // switch men(1) or wsl(0)

	if (isset($v01) && $v01 == '1') {

		if( $submit=='Process Mins' && $type == '1') {

			$minutes_1 = "UPDATE cfc_fixture_events a SET a.f_team='0' WHERE a.f_date > '2001-08-01' AND a.f_name NOT IN (SELECT b.f_name FROM cfc_fixtures_players b WHERE b.f_gameid = a.f_gameid)";

			$minutes_2 = "update cfc_fixtures_players  a inner join cfc_fixtures b on a.F_GAMEID = b.F_ID set a.x_minutes = b.f_minutes
							where a.f_apps= '1' and a.f_date > '2001-08-01'";

			$minutes_3 = "update cfc_fixtures_players  a set a.x_minutes = '-1'  where a.f_subs  = '1' and a.f_date > '2001-08-01'";

			$minutes_4 = "update cfc_fixtures_players  a set a.x_minutes = '0'  where a.f_unused = '1' and a.f_date > '2001-08-01'";

			$minutes_5 = "update cfc_fixtures_players a inner join cfc_fixture_events b on a.f_name=b.f_name set a.x_minutes = (case when ( b.f_minute ) = 0 then 1 else b.f_minute end)
							where a.f_gameid=b.f_gameid and b.f_event = 'SUBOFF' and a.f_date > '2001-08-01' and a.f_apps='1'";

			$minutes_6 = "update cfc_fixtures_players a inner join cfc_fixture_events b on a.f_name=b.f_name set a.x_minutes = b.f_minute
							where a.f_gameid=b.f_gameid and b.f_event = 'RC' and a.f_date > '2001-08-01' and a.f_apps='1'";

			$minutes_7 = "update cfc_fixtures_players a set a.x_minutes = (select f_minute_diff
							FROM ( select b.f_name, b.f_gameid,  (case when ( c.f_minute - b.f_minute ) = 0 then 1 else ( c.f_minute - b.f_minute ) end)  as f_minute_diff
							FROM cfc_fixture_events c, cfc_fixture_events b where c.f_name=b.f_name and c.f_gameid = b.f_gameid and c.f_event  in ('RC','SUBOFF') and b.f_event = 'SUBON'
							group by f_name ) z where f_name= a.f_name and f_gameid = a.f_gameid and a.f_subs='1' and a.f_date > '2001-08-01' ) where a.f_subs='1'";

			$minutes_8 = "update cfc_fixtures_players a inner join cfc_fixture_events b on a.f_name=b.f_name inner join cfc_fixtures d on a.f_gameid = d.f_id
							set a.x_minutes =  (case when (d.f_minutes - b.f_minute) = 0 then 1 else (d.f_minutes - b.f_minute) end)
							where a.f_gameid = b.f_gameid and b.f_event = 'SUBON'and a.f_date > '2001-08-01' and a.f_subs='1' and a.x_minutes in ('-1','0') ";

		} elseif ( $submit=='Process Mins' && $type == '0' ) {

			$minutes_1 = "UPDATE wsl_fixture_events a SET a.f_team='0' WHERE a.f_date > '2015-01-01' AND a.f_name NOT IN (SELECT b.f_name FROM wsl_fixtures_players b WHERE b.f_gameid = a.f_gameid)";

			$minutes_2 = "update wsl_fixtures_players  a inner join wsl_fixtures b on a.F_GAMEID = b.F_ID set a.x_minutes = b.f_minutes
							where a.f_apps= '1' and a.f_date > '2015-01-01'";

			$minutes_3 = "update wsl_fixtures_players  a set a.x_minutes = '-1'  where a.f_subs  = '1' and a.f_date > '2015-01-01'";

			$minutes_4 = "update wsl_fixtures_players  a set a.x_minutes = '0'  where a.f_unused = '1' and a.f_date > '2015-01-01'";

			$minutes_5 = "update wsl_fixtures_players a inner join wsl_fixture_events b on a.f_name=b.f_name set a.x_minutes = (case when ( b.f_minute ) = 0 then 1 else b.f_minute end)
							where a.f_gameid=b.f_gameid and b.f_event = 'SUBOFF' and a.f_date > '2015-01-01' and a.f_apps='1'";

			$minutes_6 = "update wsl_fixtures_players a inner join wsl_fixture_events b on a.f_name=b.f_name set a.x_minutes = b.f_minute
							where a.f_gameid=b.f_gameid and b.f_event = 'RC' and a.f_date > '2015-01-01' and a.f_apps='1'";

			$minutes_7 = "update wsl_fixtures_players a set a.x_minutes = (select f_minute_diff
							FROM ( select b.f_name, b.f_gameid,  (case when ( c.f_minute - b.f_minute ) = 0 then 1 else ( c.f_minute - b.f_minute ) end)  as f_minute_diff
							FROM wsl_fixture_events c, wsl_fixture_events b where c.f_name=b.f_name and c.f_gameid = b.f_gameid and c.f_event  in ('RC','SUBOFF') and b.f_event = 'SUBON'
							group by f_name ) z where f_name= a.f_name and f_gameid = a.f_gameid and a.f_subs='1' and a.f_date > '2015-01-01' ) where a.f_subs='1'";

			$minutes_8 = "update wsl_fixtures_players a inner join wsl_fixture_events b on a.f_name=b.f_name inner join wsl_fixtures d on a.f_gameid = d.f_id
							set a.x_minutes =  (case when (d.f_minutes - b.f_minute) = 0 then 1 else (d.f_minutes - b.f_minute) end)
							where a.f_gameid = b.f_gameid and b.f_event = 'SUBON'and a.f_date > '2015-01-01' and a.f_subs='1' and a.x_minutes in ('-1','0') ";

		}
		else {

			print "Error".PHP_EOL;
			print "v01  is : {$v01}".PHP_EOL;
			print "submit  is : {$submit}".PHP_EOL;
			print "Type is : {$type}".PHP_EOL;
			exit();
		}


		print '<div class="alert alert-info">';

		$pdo = new pdodb();
		$pdo->query($minutes_1);
		$pdo->execute();
		$id_def_1 = $pdo->lastInsertId() .' '. $pdo->rowCount();
		print 'Success (default fix 1) ' .$id_def_1.'<br/>';

		$pdo->query($minutes_2);
		$pdo->execute();
		$id_def_2 = $pdo->lastInsertId() .' '. $pdo->rowCount();
		print 'Success (default fix 2) ' .$id_def_2.'<br/>';

		$pdo->query($minutes_3);
		$pdo->execute();
		$id_def_3 = $pdo->lastInsertId() .' '. $pdo->rowCount();
		print 'Success (default fix 3) ' .$id_def_3.'<br/>';

		$pdo->query($minutes_4);
		$pdo->execute();
		$id_def_4 = $pdo->lastInsertId() .' '. $pdo->rowCount();
		print 'Success (default fix 4) ' .$id_def_4.'<br/>';

		$pdo->query($minutes_5);
		$pdo->execute();
		$id_def_5 = $pdo->lastInsertId() .' '. $pdo->rowCount();
		print 'Success (default fix 5) ' .$id_def_5.'<br/>';

		$pdo->query($minutes_6);
		$pdo->execute();
		$id_def_6 = $pdo->lastInsertId() .' '. $pdo->rowCount();
		print 'Success (default fix 6) ' .$id_def_6.'<br/>';

		$pdo->query($minutes_7);
		$pdo->execute();
		$id_def_7 = $pdo->lastInsertId() .' '. $pdo->rowCount();
		print 'Success (default fix 7) ' .$id_def_7.'<br/>';

		$pdo->query($minutes_8);
		$pdo->execute();
		$id_def_8 = $pdo->lastInsertId() .' '. $pdo->rowCount();
		print 'Success (default fix 8) ' .$id_def_8.'<br/>';
		print '</div>';

		print $go->getOptionMenu();


	}
		else {

	?>
			<form method="post" action="<?php the_permalink();?>">

				<input type="hidden" name="F01" value="1"/>

				<div class="form-group">
					<div class="checkbox">
						<label for="type">Deselect for WSL
							<input type="checkbox" id="type" name="type" value="1" checked />
						</label>
					</div>
				</div>

				<div class="form-group">
					<input name="submit" type="submit" id="submit" value="Process Mins" class="btn btn-primary"/> 
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