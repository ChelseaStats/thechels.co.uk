<?php /* Template Name: # Z m-stato */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
	<div id="contentleft">
	        <?php print $go->goAdminMenu(); ?>
	        <h4 class="special"> <?php the_title(); ?>- FULL ESPN STATS LOADER</h4>



				<h6><a href='http://www.espnfc.co.uk/club/chelsea/363/fixtures' target='_blank'>Espn Fixtures</a></h6>

				<form name="form" method="POST" action="<?php the_permalink();?>">

					<div class="form-group">
						<label for="url">URL or ID:</label>
						<input name="url" type="text" id="url" class="form-control">
					</div>

					<div class="form-group">
						<label for="gamer">Game id:</label>
						<input name="gamer" type="number" id="gamer" class="form-control" value = <?php print $value = $go->get_maxGameId(); ?>
					</div>

					<div class="form-group">
						<div class="checkbox">
							<label for="submit_check1">submit check (players)
								<input type="checkbox" id="submit_check1" name="submit_check1" value="1" checked>
							</label>
						</div>
					</div>
					<div class="form-group">
						<div class="checkbox">
							<label for="submit_check2">submit check (events)
								<input type="checkbox" id="submit_check2" name="submit_check2" value="1" checked>
							</label>
						</div>
					</div>
					<br/>
					<input type="submit" name="Submit" value="Submit" class="btn btn-primary">
				</form>
	<?php
	/******************************************************************************/

		// $go->debugger($_POST);

		$url_id	= $_POST['url'];
		$url_id = filter_var($url_id, FILTER_SANITIZE_NUMBER_INT);
		$url = 'http://www.espnfc.co.uk/gamecast/statistics/id/'.$url_id.'/statistics.html';

		$gamer	= $go->inputUpClean($_POST['gamer']);

		$submit_check1  = isset($_POST['submit_check1']) ? $_POST['submit_check1'] : '0' ;
		$submit_check2  = isset($_POST['submit_check2']) ? $_POST['submit_check2'] : '0' ;

		$pdo = new pdodb();

		$pdo->query('SELECT F_DATE, F_LOCATION, F_OPP FROM cfc_fixtures WHERE F_ID = :f_id');
		$pdo->bind(':f_id', $gamer);
		$row 	 = $pdo->row();
		$date    = $row['F_DATE'];
		$local   = $row['F_LOCATION'];
		$oppo    = $row['F_OPP'];
		
		print "<div class='alert alert-info'>{$url}</div>";

	if (isset($url) && $url !== '' && $gamer !== '' && $date !== '' && $local !== '')  {

		/**************************************************************************************/

		$pdo->query('INSERT IGNORE INTO data_source (F_ESPN, F_GAMEID) VALUES (:url_id,:gamer_id)');
		$pdo->bind(':url_id',$url_id);
		$pdo->bind(':gamer_id',$gamer);
		$pdo->execute();
		$source_id = $pdo->lastInsertId();

		echo '<div class="alert alert-warning">last insert id: '.$source_id.'<br/>';
		printf("Inserted data_source log row: %d\n </div>", $pdo->rowCount());


		/**************************************************************************************/

		$raw = $go->goCurl($url);
		$newlines=array("\t","\n","\r","\x20\x20","\0","\x0B","<br/>","<p>","</p>","<br>");
		$content=str_replace($newlines, "", html_entity_decode($raw));
		$content=str_replace('-','0',$content);

		/**************************************************************************************/

	print '<h5>output</h5>';



	$neutral = $content;

	$start=strpos($content,'<div class="span012 column">');
	$end = strpos($content,'<div class="span06 column last">');
	$content = substr($content,$start,$end-$start);

		if( strlen($content)=='0') {

		print '<p>going to alternate version</p>';

		$start=strpos($neutral,'tab0cont playerstats');
		$end = strpos($neutral,'casterListener');
		$content = substr($neutral,$start,$end-$start);

		}

		if($local ==='H') {
		$h_start=strpos($content,'home0team');
		$h_end = strpos($content,'</section>');
		$table = substr($content,$h_start,$h_end-$h_start);
		$table = explode ('<tr class="subheader team0color"><th colspan="13" class="tb0substitutes home0team">Substitutes</th></tr>',$table);

		}

		if($local ==='A') {
		$a_start=strpos($content,'away0team');
		$a_end = strpos($content,'</section>');
		$table = substr($content,$a_start,$a_end-$a_start);
		$table = explode ('<tr class="subheader team0color"><th colspan="13" class="tb0substitutes away0team">Substitutes</th></tr>',$table);

		}

		if($local ==='N') {

		    $t_start = strpos($neutral,'<div class="span-12 column">');
		    $t_end   = strpos($neutral,'<div class="span06 column last">');
		    $table  = substr($content,$t_start,$t_end-$t_start);

		    if( strlen($table)=='0') {
		    $start=strpos($neutral,'tab0cont playerstats');
		    $end = strpos($neutral,'casterListener');
		    $table = substr($neutral,$start,$end-$start);

		    }

		    $t1  = explode ('<tr class="subheader team0color"><th colspan="13" class="tb0substitutes home0team">Substitutes</th></tr>',$table);
		    $t2  = explode ('<tr class="subheader team0color"><th colspan="13" class="tb0substitutes away0team">Substitutes</th></tr>',$table);

		    $t1[1] = explode('id="away0team"',$t1[1]);
		    $t2[0] = explode('id="away0team"',$t2[0]);

		    $table = array();

		    $table[0] = $t1[0];
		    $table[1] = $t1[1][0];
		    $table[2] = $t2[0][1];
		    $table[3] = $t2[1];

		}


		$rr = '<tr><td>0</td></tr>';
		$sql = ' ';

			print '<br/>';
			print '<textarea style="font-size:0.675em; width:95%; height:200px;">';

			print "DELETE FROM cfc_fixtures_players where f_gameid={$gamer}";
			$sql .= "DELETE FROM cfc_fixtures_players where f_gameid={$gamer};";

			preg_match_all("|<tr(.*)</tr>|U",$table[0].$rr,$rows);
			foreach ($rows[0] as $row) {
				if ( ( strpos( $row, '<th' ) === FALSE ) ) {
					// sq_no, name, SH ,SG ,G ,A ,OF ,FD ,FC ,SV ,YC ,RC
					preg_match_all( "|<td(.*)</td>|U", $row, $cells );
					$squad_number = strip_tags( $cells[0][1] );
					$names_subs   = ( $cells[0][2] );
					$SH           = strip_tags( $cells[0][3] );
					$SG           = strip_tags( $cells[0][4] );
					$G            = strip_tags( $cells[0][5] );
					$A            = strip_tags( $cells[0][6] );
					$OF           = strip_tags( $cells[0][7] );
					$FD           = strip_tags( $cells[0][8] );
					$FC           = strip_tags( $cells[0][9] );
					$SV           = strip_tags( $cells[0][10] );
					$YC           = strip_tags( $cells[0][11] );
					$RC           = strip_tags( $cells[0][12] );
					$apps         = '1';
					// we don't need to check for sub activity as they started!
					$subs   = '0';
					$unused = '0';

					if ( $squad_number != '' ) {
						echo "INSERT INTO cfc_fixtures_players (F_DATE,F_NO,F_SHOTS,F_SHOTSON,F_GOALS,F_ASSISTS,F_OFFSIDES,F_FOULSSUF, F_FOULSCOM, F_SAVES,F_YC,F_RC,F_APPS,F_SUBS,F_UNUSED,F_GAMEID) \n";
						echo "VALUES ('{$date}','{$squad_number}','{$SH}','{$SG}','{$G}','{$A}','{$OF}','{$FD}','{$FC}','{$SV}','{$YC}','{$RC}','{$apps}','{$subs}','{$unused}','{$gamer}'); \n";

						$sql .= "INSERT INTO cfc_fixtures_players (F_DATE,F_NO,F_SHOTS,F_SHOTSON,F_GOALS,F_ASSISTS,F_OFFSIDES,F_FOULSSUF, F_FOULSCOM, F_SAVES,F_YC,F_RC,F_APPS,F_SUBS,F_UNUSED,F_GAMEID)";
						$sql .= "VALUES ('{$date}','{$squad_number}','{$SH}','{$SG}','{$G}','{$A}','{$OF}','{$FD}','{$FC}','{$SV}','{$YC}','{$RC}','{$apps}','{$subs}','{$unused}','{$gamer}');";
						}
				}
			}

			// subs
			preg_match_all("|<tr(.*)</tr>|U",$table[1].$rr,$rows);
			foreach ($rows[0] as $row) {
				if ( ( strpos( $row, '<th' ) === FALSE ) ) {
					// sq_no, name, SH ,SG ,G ,A ,OF ,FD ,FC ,SV ,YC ,RC
					preg_match_all( "|<td(.*)</td>|U", $row, $cells );
					$squad_number = strip_tags( $cells[0][1] );
					$names_subs   = ( $cells[0][2] );
					$SH           = strip_tags( $cells[0][3] );
					$SG           = strip_tags( $cells[0][4] );
					$G            = strip_tags( $cells[0][5] );
					$A            = strip_tags( $cells[0][6] );
					$OF           = strip_tags( $cells[0][7] );
					$FD           = strip_tags( $cells[0][8] );
					$FC           = strip_tags( $cells[0][9] );
					$SV           = strip_tags( $cells[0][10] );
					$YC           = strip_tags( $cells[0][11] );
					$RC           = strip_tags( $cells[0][12] );
					$apps         = '0';
					if ( strpos( $names_subs, 'Substitution' ) !== FALSE ) {
						$subs   = '1';
						$unused = '0';
					} else {
						$subs   = '0';
						$unused = '1';
					}

					if ( $squad_number != '' ) {
						echo "INSERT INTO cfc_fixtures_players (F_DATE,F_NO,F_SHOTS,F_SHOTSON,F_GOALS,F_ASSISTS,F_OFFSIDES,F_FOULSSUF, F_FOULSCOM, F_SAVES,F_YC,F_RC,F_APPS,F_SUBS,F_UNUSED,F_GAMEID) \n";
						echo "VALUES ('{$date}','{$squad_number}','{$SH}','{$SG}','{$G}','{$A}','{$OF}','{$FD}','{$FC}','{$SV}','{$YC}','{$RC}','{$apps}','{$subs}','{$unused}','{$gamer}'); \n";

						$sql .= "INSERT INTO cfc_fixtures_players (F_DATE,F_NO,F_SHOTS,F_SHOTSON,F_GOALS,F_ASSISTS,F_OFFSIDES,F_FOULSSUF, F_FOULSCOM, F_SAVES,F_YC,F_RC,F_APPS,F_SUBS,F_UNUSED,F_GAMEID)";
						$sql .= "VALUES ('{$date}','{$squad_number}','{$SH}','{$SG}','{$G}','{$A}','{$OF}','{$FD}','{$FC}','{$SV}','{$YC}','{$RC}','{$apps}','{$subs}','{$unused}','{$gamer}');";
						}
				}
			}

		/////////////// if neutral show them all /////////////////////

		if($local=='N') {

			print '</textarea><div class="alert alert-error">Neutral Venue - Insert Manually</div><h5>other team</h5><textarea style="font-size:0.75em; width: 95%; height:20px;">';

			// subs
			preg_match_all( "|<tr(.*)</tr>|U", $table[2] . $rr, $rows );
			foreach ( $rows[0] as $row ) {
				if ( ( strpos( $row, '<th' ) === FALSE ) ) {
					// sq_no, name, SH ,SG ,G ,A ,OF ,FD ,FC ,SV ,YC ,RC
					preg_match_all( "|<td(.*)</td>|U", $row, $cells );
					$squad_number = strip_tags( $cells[0][1] );
					$names_subs   = ( $cells[0][2] );
					$SH           = strip_tags( $cells[0][3] );
					$SG           = strip_tags( $cells[0][4] );
					$G            = strip_tags( $cells[0][5] );
					$A            = strip_tags( $cells[0][6] );
					$OF           = strip_tags( $cells[0][7] );
					$FD           = strip_tags( $cells[0][8] );
					$FC           = strip_tags( $cells[0][9] );
					$SV           = strip_tags( $cells[0][10] );
					$YC           = strip_tags( $cells[0][11] );
					$RC           = strip_tags( $cells[0][12] );
					$apps         = '1';
					// we don't need to check for sub activity as they started!
					$subs   = '0';
					$unused = '0';

					if ( $squad_number != '' ) {
						echo "INSERT INTO cfc_fixtures_players (F_DATE,F_NO,F_SHOTS,F_SHOTSON,F_GOALS,F_ASSISTS,F_OFFSIDES,F_FOULSSUF, F_FOULSCOM, F_SAVES,F_YC,F_RC,F_APPS,F_SUBS,F_UNUSED,F_GAMEID) \n";
						echo "VALUES ('{$date}','{$squad_number}','{$SH}','{$SG}','{$G}','{$A}','{$OF}','{$FD}','{$FC}','{$SV}','{$YC}','{$RC}','{$apps}','{$subs}','{$unused}','{$gamer}'); \n";

						$sql .= "INSERT INTO cfc_fixtures_players (F_DATE,F_NO,F_SHOTS,F_SHOTSON,F_GOALS,F_ASSISTS,F_OFFSIDES,F_FOULSSUF, F_FOULSCOM, F_SAVES,F_YC,F_RC,F_APPS,F_SUBS,F_UNUSED,F_GAMEID)";
						$sql .= "VALUES ('{$date}','{$squad_number}','{$SH}','{$SG}','{$G}','{$A}','{$OF}','{$FD}','{$FC}','{$SV}','{$YC}','{$RC}','{$apps}','{$subs}','{$unused}','{$gamer}');";
					}
				}
			}

			preg_match_all( "|<tr(.*)</tr>|U", $table[3] . $rr, $rows );
			foreach ( $rows[0] as $row ) {
				if ( ( strpos( $row, '<th' ) === FALSE ) ) {
					// sq_no, name, SH ,SG ,G ,A ,OF ,FD ,FC ,SV ,YC ,RC
					preg_match_all( "|<td(.*)</td>|U", $row, $cells );
					$squad_number = strip_tags( $cells[0][1] );
					$names_subs   = ( $cells[0][2] );
					$SH           = strip_tags( $cells[0][3] );
					$SG           = strip_tags( $cells[0][4] );
					$G            = strip_tags( $cells[0][5] );
					$A            = strip_tags( $cells[0][6] );
					$OF           = strip_tags( $cells[0][7] );
					$FD           = strip_tags( $cells[0][8] );
					$FC           = strip_tags( $cells[0][9] );
					$SV           = strip_tags( $cells[0][10] );
					$YC           = strip_tags( $cells[0][11] );
					$RC           = strip_tags( $cells[0][12] );
					$apps         = '0';

					if ( strpos( $names_subs, 'Substitution' ) !== FALSE ) {
						$subs   = '1';
						$unused = '0';
					} else {
						$subs   = '0';
						$unused = '1';
					}

					if ( $squad_number != '' ) {
						echo "INSERT INTO cfc_fixtures_players (F_DATE,F_NO,F_SHOTS,F_SHOTSON,F_GOALS,F_ASSISTS,F_OFFSIDES,F_FOULSSUF, F_FOULSCOM, F_SAVES,F_YC,F_RC,F_APPS,F_SUBS,F_UNUSED,F_GAMEID) \n";
						echo "VALUES ('{$date}','{$squad_number}','{$SH}','{$SG}','{$G}','{$A}','{$OF}','{$FD}','{$FC}','{$SV}','{$YC}','{$RC}','{$apps}','{$subs}','{$unused}','{$gamer}'); \n";

						//$sql .= "INSERT INTO cfc_fixtures_players (F_DATE,F_NO,F_SHOTS,F_SHOTSON,F_GOALS,F_ASSISTS,F_OFFSIDES,F_FOULSSUF, F_FOULSCOM, F_SAVES,F_YC,F_RC,F_APPS,F_SUBS,F_UNUSED,F_GAMEID)";
						//$sql .= "VALUES ('{$date}','{$squad_number}','{$SH}','{$SG}','{$G}','{$A}','{$OF}','{$FD}','{$FC}','{$SV}','{$YC}','{$RC}','{$apps}','{$subs}','{$unused}','{$gamer}');";
					}
				}
			}

		} // end if local = N

			echo '</textarea>';
			echo '<br/>';


		/******************************************************************************/
		/******************************************************************************/
		/******************************************************************************/
		/******************************************************************************/

		$raw_events      = $go->goCurl( $url );
		$newlines_events = array ( "\t", "\n", "\r", "\x20\x20", "\0", "\x0B", "<br/>", "<p>", "</p>", "<br>" );
		$content  = str_replace( $newlines_events, "", html_entity_decode( $raw_events ) );
		//$content  = str_replace( '-', '0', $content );

		$names = array ();

		$event_array = array ('GOAL','OGOAL','PKGOAL','PKMISS','YC','RC','SUBON'); // no suboff has handled separately as data source sucks

		/******************************************************************************/

		print '<h5>output</h5>';

		$neutral = $content;

		$start   = strpos( $content, '<div class="span-12 column">' );
		$end     = strpos( $content, '<div class="span-6 column last">' );
		$content = substr( $content, $start, $end - $start );


		if ( strlen( $content ) == '0' ) {
			$start   = strpos( $neutral, 'tab-cont playerstats' );
			$end     = strpos( $neutral, 'casterListener' );
			$content = substr( $neutral, $start, $end - $start );

		}

		$rr = '<tr><td>0</td></tr>';

		preg_match_all( "|<tr(.*)</tr>|U", $content . $rr, $rows );
		foreach ( $rows[0] as $row ) {
			if ( ( strpos( $row, '<th' ) === FALSE ) ) {
				// sq_no, name, SH ,SG ,G ,A ,OF ,FD ,FC ,SV ,YC ,RC
				preg_match_all( "|<td(.*)</td>|U", $row, $cells );
				$position     = strip_tags( $cells[0][0] );  // junk and not needed.
				$squad_number = strip_tags( $cells[0][1] );
				$names[] = ( $cells[0][2] ); // junk and not needed.

			}
		}


		$names = implode( '<br/>', $names );


		$names = '<table><tbody><tr>' . $names;
		$names = $names . "/n</tbody></table>";


		$names = str_replace( '<br>', '', $names );
		$names = str_replace( "<tr>", "\n<tr>", $names );
		$names = str_replace( '<div>', '', $names );

		$names = str_replace( '</a>', '</a></td>', $names );
		$names = str_replace( '<a ', '<td><a ', $names );
		$names = str_replace( '<div ', '<td ', $names );
		$names = str_replace( '</div>', '</td>', $names );
		$names = str_replace( '<br/>', '</tr>', $names );
		$names = str_replace( '<span>', "", $names );
		$names = str_replace( '</span>', "", $names );

		$names = str_replace( "<td><td>", '<td>', $names );
		$names = str_replace( "</td></td>", '</td>', $names );
		$names = str_replace( '<td> ', '<td>', $names );
		$names = str_replace( '<br/>', '', $names );
		$names = str_replace( "</tr><td>", '</tr><tr><td>', $names );
		$names = str_replace( '</a>', "</span>", $names );
		$names = str_replace( '</tr></tr></tr>', "</tr>", $names );
		$names = str_replace( "<td></td>","", $names );
		$names = str_replace( "<tr></tr>","", $names );
		$names = str_replace( "<td>\n</td>","", $names );
		$names = str_replace( "<br></td>","", $names );
		$names = str_replace( '<span>', "", $names );
		$names = str_replace( '<tr>', "</tr><tr>", $names );



		$names = str_replace( "onmouseout=\"tooltip.hide();", '', $names );
		$names = str_replace( "onmouseover=\"tooltip.show('", '', $names );

		$names = str_replace( "'", '', $names );
		$names = str_replace( '"', '', $names );

		$names = str_replace( ';', '', $names );
		$names = str_replace( ') >', '', $names );

		$names = str_replace( 'target=_blanktitle=',"", $names );
		$names = str_replace( 'target=_blank title=',"", $names );
		$names = str_replace( 'href=',"", $names );
		$names = str_replace( 'alt=',"", $names );

		$names = str_replace( ' - ', '</td><td>', $names );
		$names = str_replace( 'Yellow Card', 'YC', $names );
		$names = str_replace( 'Red Card', 'RC', $names );
		$names = str_replace( 'Own Goal', 'OGOAL', $names );
		$names = str_replace( 'Goal', 'GOAL', $names );
		$names = str_replace( 'Penalty - Scored', 'PKGOAL', $names );
		$names = str_replace( 'Penalty - Misses', 'PKMISS', $names );
		$names = str_replace( ' + ', '+', $names );
		$names = str_replace( 'Substitution', 'SUBON', $names );
		$names = str_replace( 'Off:', '</td><td>SUBOFF |', $names );


		$names = str_replace( ' class=soccer-icons soccer-icons-yellowcard', ">", $names );
		$names = str_replace( ' class=soccer-icons soccer-icons-owngoal', ">", $names );
		$names = str_replace( ' class=soccer-icons soccer-icons-subinout', ">", $names );
		$names = str_replace( ' class=soccer-icons soccer-icons-subout', ">", $names );
		$names = str_replace( ' class=soccer-icons soccer-icons-subin', ">", $names );
		$names = str_replace( ' class=soccer-icons soccer-icons-goal', ">", $names );
		$names = str_replace( ' class=soccer-icons soccer-icons-redcard', ">", $names );

		$names = str_replace( '<strong>', "", $names );
		$names = str_replace( '</strong>', "", $names );
		$names = str_replace( '|', "</td><td>", $names );

		$names = str_replace( ' SUBON', "SUBON", $names );
		$names = str_replace( 'SUBOFF ', "SUBOFF", $names );

		// $names = str_replace( '/', '', $names );
		// $names = str_replace( '\\', '', $names );

		$names = preg_replace( '/"[^"]+"/', '', $names );
		$names = preg_replace( "/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i", '<$1$2>', $names );

		$names = str_replace( '\<br/>','',$names);
		$names = str_replace( '<a>', '', $names );
		$names = str_replace( '</a>', '', $names );
		$names = str_replace( '</tr></tr>', "</tr>", $names );

		$names = str_replace( '<td>', "</td><td>", $names );

		$names = str_replace( '<td><td>', "<td>", $names );
		$names = str_replace( '</td></td>', "</td>", $names );
		$names = str_replace( '\</td>', "</td>", $names );
		$names = str_replace( '<td> ', "<td>", $names );
		$names = str_replace( '</span>', "", $names );
		$names = str_replace( '<td>Penalty</td><td>Scored</td>', '<td>PKGOAL</td>', $names );
		$names = str_replace( '<td>GOAL</td><td>Header</td>', '<td>GOAL</td>', $names );
		$names = str_replace( '<td>GOAL</td><td>Free-kick</td>', '<td>GOAL</td>', $names );

		$rr2   = '<td>0</td>';
		$names = trim( $names );

		// $go->debugger($names);
		print '<br/><textarea style="font-size:0.675em; width:95%; height:200px;">';

		print "DELETE FROM cfc_fixture_events where F_GAMEID ='$gamer'; \n";
		$sql_events =  "DELETE FROM cfc_fixture_events where F_GAMEID ='$gamer'; \n";

		preg_match_all( "|<tr(.*)</tr>|U", $names . $rr2, $rows );
		foreach ( $rows[0] as $row ) {
			if ( ( strpos( $row, '<th' ) === FALSE ) ) {
				// Name, event, minute, event, minute ...
				// Name, event, minute, event, name

				preg_match_all( "|<td(.*)</td>|U", $row, $cells );
				$name    = strip_tags( $cells[0][0] );
				$event   = strip_tags( $cells[0][1] );
				$minute  = strip_tags( $cells[0][2] );
				$event2  = strip_tags( $cells[0][3] );
				$minute2 = strip_tags( $cells[0][4] );
				$event3  = strip_tags( $cells[0][5] );
				$minute3 = strip_tags( $cells[0][6] );
				$event4  = strip_tags( $cells[0][7] );
				$minute4 = strip_tags( $cells[0][8] );
				$event5  = strip_tags( $cells[0][9] );
				$minute5 = strip_tags( $cells[0][10] );
				$team    = '1';
				$half    = 'NULL';


				// Generic mapper 1 event per player
				if ( $name != '' && $event != '' ) {
					$minute = $go->get_minute( $minute );
					$half   = $go->get_half( $minute );
					$name   = $go->get_prepare_text($name);

					echo " INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID) \n";
					echo " VALUES ('{$date}','{$name}','{$event}','{$minute}','{$half}','{$team}','{$gamer}'); \n";

					$sql_events .=  " INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID)";
					$sql_events .=  " VALUES ('{$date}','{$name}','{$event}','{$minute}','{$half}','{$team}','{$gamer}');";

				}

				// secondary
				if ( $go->get_contains($event2,$event_array) === TRUE && $minute2 != '' ) {
					$x_name   = $go->get_prepare_text($name);
					$x_event  = trim( $event2 );
					$x_minute = $go->get_minute( $minute2 );
					$x_half   = $go->get_half( $x_minute );

					echo "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID) \n";
					echo "VALUES ('{$date}','{$x_name}','{$x_event}','{$x_minute}','{$x_half}','{$team}','{$gamer}'); \n";

					$sql_events .= "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID)";
					$sql_events .= "VALUES ('{$date}','{$x_name}','{$x_event}','{$x_minute}','{$x_half}','{$team}','{$gamer}');";
				}


				if ( strpos( $event2, 'SUBOFF' ) !== FALSE ) {
					$x_name   = $go->get_prepare_text($minute2);
					$x_event  = 'SUBOFF';
					$x_minute = $minute; // use original minute of sub
					if ( $x_name != '' && $x_event != '' ) {
						$x_minute      = $go->get_minute( $x_minute );
						$x_half        = $go->get_half( $x_minute );

						echo "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID) \n";
						echo "VALUES ('{$date}','{$x_name}','{$x_event}','{$x_minute}','{$x_half}','{$team}','{$gamer}'); \n";

						$sql_events .= "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID)";
						$sql_events .= "VALUES ('{$date}','{$x_name}','{$x_event}','{$x_minute}','{$x_half}','{$team}','{$gamer}');";

					}
				}

				// tertiary
				if ( $go->get_contains($event3,$event_array) === TRUE && $minute3 != '' ) {
					$w_name   = $go->get_prepare_text($name);
					$w_event = trim( $event3 );
					$w_minute = $go->get_minute( $minute3 );
					$w_half   = $go->get_half( $w_minute );

					echo "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID) \n";
					echo "VALUES ('{$date}','{$w_name}','{$w_event}','{$w_minute}','{$w_half}','{$team}','{$gamer}'); \n";

					$sql_events .= "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID)";
					$sql_events .= "VALUES ('{$date}','{$w_name}','{$w_event}','{$w_minute}','{$w_half}','{$team}','{$gamer}');";
				}

				if ( strpos( $event3, 'SUBOFF' ) !== FALSE ) {
					$w_name   = $go->get_prepare_text($minute3);
					$w_event  = 'SUBOFF';
					$w_minute = $minute;
					if ( $w_name != '' && $w_event != '' ) {
						$w_minute  = $go->get_minute( $w_minute );
						$w_half    = $go->get_half( $w_minute );

						echo "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID) \n";
						echo "VALUES ('{$date}','{$w_name}','{$w_event}','{$w_minute}','{$w_half}','{$team}','{$gamer}'); \n";

						$sql_events .=  "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID)";
						$sql_events .=  "VALUES ('{$date}','{$w_name}','{$w_event}','{$w_minute}','{$w_half}','{$team}','{$gamer}');";
					}

				}

				// quaternary
				if ( $go->get_contains($event4,$event_array) === TRUE && $minute4 != '' ) {
					$z_name  = $go->get_prepare_text($name);
					$z_event = trim( $event4 );
					$z_minute = $go->get_minute( $minute4 );
					$z_half   = $go->get_half( $z_minute );

					echo "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID) \n";
					echo "VALUES ('{$date}','{$z_name}','{$z_event}','{$z_minute}','{$z_half}','{$team}','{$gamer}'); \n";

					$sql_events .= "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID)";
					$sql_events .= "VALUES ('{$date}','{$z_name}','{$z_event}','{$z_minute}','{$z_half}','{$team}','{$gamer}');";
				}

				if ( strpos( $event4, 'SUBOFF' ) !== FALSE ) {
					$z_name   = $go->get_prepare_text($minute4);
					$z_event  = 'SUBOFF';
					$z_minute = $minute;
					if ( $z_name != '' && $z_event != '' ) {
						$z_minute  = $go->get_minute( $z_minute );
						$z_half    = $go->get_half( $z_minute );
						echo "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID) \n";
						echo "VALUES ('{$date}','{$z_name}','{$z_event}','{$z_minute}','{$z_half}','{$team}','{$gamer}'); \n";

						$sql_events .= "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID)";
						$sql_events .= "VALUES ('{$date}','{$z_name}','{$z_event}','{$z_minute}','{$z_half}','{$team}','{$gamer}');";
					}

				}

				// 5
				if ( $go->get_contains($event5,$event_array) === TRUE && $minute5 != '' ) {
					$q_name  = $go->get_prepare_text($name);
					$q_event = trim( $event5 );
					$q_minute = $go->get_minute( $minute5 );
					$q_half   = $go->get_half( $q_minute );

					echo "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID) \n";
					echo "VALUES ('{$date}','{$q_name}','{$q_event}','{$q_minute}','{$q_half}','{$team}','{$gamer}'); \n";

					$sql_events .= "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID)";
					$sql_events .= "VALUES ('{$date}','{$q_name}','{$q_event}','{$q_minute}','{$q_half}','{$team}','{$gamer}');";
				}

				if ( strpos( $event5, 'SUBOFF' ) !== FALSE ) {
					$q_name   = $go->get_prepare_text($minute5);
					$q_event  = 'SUBOFF';
					$q_minute = $minute;
					if ( $q_name != '' && $q_event != '' ) {
						$q_minute  = $go->get_minute( $q_minute );
						$q_half    = $go->get_half( $q_minute );
						echo "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID) \n";
						echo "VALUES ('{$date}','{$q_name}','{$q_event}','{$q_minute}','{$q_half}','{$team}','{$gamer}'); \n";

						$sql_events .= "INSERT INTO cfc_fixture_events (F_DATE,F_NAME,F_EVENT,F_MINUTE,F_HALF,F_TEAM,F_GAMEID)";
						$sql_events .= "VALUES ('{$date}','{$q_name}','{$q_event}','{$q_minute}','{$q_half}','{$team}','{$gamer}');";
					}

				}



			} // end if
		} // end foreach

		echo "UPDATE cfc_fixture_events a SET a.f_team='0' WHERE F_GAMEID = '{$gamer}' AND a.f_name NOT IN
						(SELECT b.f_name FROM cfc_fixtures_players b WHERE b.f_gameid = a.f_gameid); \n";

		$sql_events .= "UPDATE cfc_fixture_events a SET a.f_team='0' WHERE F_GAMEID = '{$gamer}' AND a.f_name NOT IN
						(SELECT b.f_name FROM cfc_fixtures_players b WHERE b.f_gameid = a.f_gameid);";

		echo '</textarea>';
		echo '<br/>';




		if ($submit_check1 === '1') {

			// insert players
			$pdo = new pdodb();
			$pdo->query($sql);
			$pdo->execute();
			$id = $pdo->lastInsertId() .' '. $pdo->rowCount();

			print '<div class="alert alert-success">Success (players) '.$id.'</div>';

			// process players data with names and fixes

			echo '<div class="alert alert-success">Success (players names processor)<br/>';

			try {

				$pdo->query( "UPDATE cfc_fixtures_players b SET b.F_NAME= ( SELECT a.F_NAME FROM meta_squadno a
                      WHERE ( b.F_NO=a.F_SQUADNO and a.F_START <= b.F_DATE ) AND ( b.F_DATE <= a.F_END or a.F_END is null ))
                      WHERE b.F_NO <>'0' and b.F_NAME is null " );
				$pdo->execute();

			} catch (PDOException $e) {

				print "DB Error: There are two or more records with the same active name or squadno.<br/>".$e->getMessage();

			} catch (Exception $e) {

				print "General Error: The record could not be added.<br/>".$e->getMessage();

			}


			printf("Affected rows (ALL CFC META SQUAD): %d\n <br/>", $pdo->rowCount());

			$pdo->query("UPDATE cfc_fixtures SET x_comps='1' WHERE f_competition IN ('PREM','DIV1OLD','DIV2OLD','FAC','CS','LC')");
			$pdo->execute();
			printf("Affected rows (SET X COMPS 1): %d\n <br/>", $pdo->rowCount());

			$pdo->query("UPDATE cfc_fixtures SET x_comps='0' WHERE f_competition NOT IN ('PREM','DIV1OLD','DIV2OLD','FAC','CS','LC')");
			$pdo->execute();
			printf("Affected rows (SET X COMPS 0): %d\n <br/>", $pdo->rowCount());

			$pdo->query("UPDATE cfc_explayers  SET F_GPG=COALESCE(ROUND( F_GOALS/(F_APPS+F_SUBS),4),0)");
			$pdo->execute();
			printf("Affected rows (UPDATE explayers GPG): %d\n <br/>", $pdo->rowCount());

			$pdo->query("UPDATE cfc_fixtures_players a SET F_GOAL_CONVERSION=COALESCE(ROUND(F_GOALS/F_SHOTS,4),0)");
			$pdo->execute();
			printf("Affected rows (CONVERSION,0): %d\n <br/>", $pdo->rowCount());

			$pdo->query("UPDATE cfc_fixtures_players a SET F_ACCURACY=COALESCE(ROUND((F_SHOTSON/F_SHOTS),4),0)");
			$pdo->execute();
			printf("Affected rows (ACCURACY,0): %d\n <br/>", $pdo->rowCount());

			$pdo->query("UPDATE cfc_fixtures_players a SET F_SAVES='0' WHERE F_SAVES IS NULL OR F_SAVES='' ");
			$pdo->execute();
			printf("Affected rows (SAVES): %d\n <br/>", $pdo->rowCount());
			

			$pdo->query("UPDATE cfc_keepers W
                      INNER JOIN (
                        SELECT B.F_NAME, SUM(A.F_AGAINST) AS F_SUM
                        FROM cfc_fixtures A
                                INNER JOIN cfc_fixtures_players B ON A.F_ID = B.F_GAMEID
                                INNER JOIN cfc_keepers P ON P.F_NAME = B.F_NAME
                          WHERE B.F_APPS='1' AND B.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL')
                        GROUP BY B.F_NAME
                      ) B ON W.F_NAME = B.F_NAME
                    SET W.F_CONCEDED = B.F_SUM");
			$pdo->execute();
			printf("Affected rows (CFC GA: UPDATE): %d\n <br/>", $pdo->rowCount());

			$pdo->query("UPDATE cfc_keepers W
                  INNER JOIN (
                    SELECT B.F_NAME, COUNT(A.F_AGAINST) AS F_COUNT
                    FROM cfc_fixtures A
                        INNER JOIN cfc_fixtures_players B ON A.F_ID = B.F_GAMEID
                        INNER JOIN cfc_keepers P ON P.F_NAME = B.F_NAME
                        WHERE A.F_AGAINST='0' AND B.F_APPS='1' AND B.F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE ='PL')
                    GROUP BY B.F_NAME
                  ) B ON W.F_NAME = B.F_NAME
                SET W.F_CLEAN= B.F_COUNT");
			$pdo->execute();
			printf("Affected rows (CFC CS: UPDATE): %d\n <br/>", $pdo->rowCount());

			print '</div>';



		}	else {

			print '<div class="alert alert-error">Failed to insert (players) '.$id.'</div>';
		}

		if ($submit_check2 === '1') {

			$pdo = new pdodb();
			$pdo->query($sql_events);
			$pdo->execute();
			$id = $pdo->lastInsertId() .' '. $pdo->rowCount();

			echo '<div class="alert alert-warning">Success (events) '.$id.'</div>';

		}	else {

			echo '<div class="alert alert-error">Failed to insert (events) '.$id.'</div>';
		}


		print $go->getOptionMenu();
		
	} else {		echo '<span class="block-message block-message-warning">Enter the URL to be analysed</span>';
		}
	?>
	</div>
	</div>
	<?php get_template_part('sidebar');?>
</div>
<div class="clearfix"><p>&nbsp;</p></div>
<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
