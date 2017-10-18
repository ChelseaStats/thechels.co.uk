<?php /* Template Name: # Z m-stato2 */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
	<div id="contentleft">
	        <?php print $go->goAdminMenu(); ?>
	        <h4 class="special"> <?php the_title(); ?>- FULL ESPN STATS LOADER</h4>



				<h6><a href='http://www.espnfc.co.uk/lineups?gameId=450899' target='_blank'>Espn Fixtures</a></h6>

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
		$url = "http://www.espn.co.uk/football/match?gameId={$url_id}";

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
		print "<div class='alert alert-info'>{$date} - {$local} - {$oppo}</div>";
		
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

		$updater = new updater();
		$raw     = $updater->getCurlResponse( $url );
		$content = $updater->removeLines($raw);
		
		$start = '<div id="gamepackage-game-lineups" data-module="lineups"';
		$end   = '<div id="gamepackage-soccer-commentary" data-module="commentary">';
		$content = $updater->subStringingByPosition( $start, $end, $content );

		$content = str_replace( '</td>'   , ''   , $content );
		$content = str_replace( '</tr>'   , ''   , $content );
		$content = str_replace( '<td colspan="3">'  , ''   , $content );
		$content = str_replace( 'style="display: block;"'   , ''   , $content );
		$content = str_replace('style=" display:inline-block; width: 24px;"', 'class="squadno"', $content);
		$content = str_replace( '<span style="background-color:#f2f2f2;" class="bar-total">', '', $content );
		$content = str_replace( '<span style="background-color:#034694; width:100%; opacity: 0.7;" class="bar-percentage"></span>' , '', $content );
		$content = str_replace( '<span style="background-color:#034694; width:100%;" class="bar-percentage"></span>' , '', $content );
		
		$content = preg_replace('#<span class="icon-font-before(.*?)</span>#', '', $content);
		$content = str_replace( '&emsp;','',$content);
		$content = str_replace( '&nbsp;','',$content);
		$content = str_replace( ' &nbsp;','',$content);
		$content = explode("accordion-item", $content);
		$content = array_filter($content, function($value) { return $value !== ''; });
		
		
		$fields = [ 'Saves', 'Goals', 'Shots' ,'Shots on Target' ,'Fouls Committed' ,'Fouls Against', 'Assist', 'Assists', 'Offsides', 'Discipline', 'Yellow', 'Red'];
		
			$rowData = array();
			$i = 0;
		foreach($content as $item) {
		
							$data = explode("</span>", $item);
							$data = array_filter($data, function($value) { return $value !== ''; });
							
							$stats = array();
								foreach($data as $stat) {
												
										$stats[] = trim(strip_tags($stat));
										
								}
								
								
								$remove_data_item_number = array_shift($stats);
								//$remove_data_item_number = array_pop($stats);
							
								
								$stats = array_filter($stats, function($value) { return $value !== ''; });
								
								
								foreach($fields as $field) {
										if(($key = array_search($field, $stats)) !== false) {
											unset($stats[$key]);
										}
								}
						
								foreach ($stats as $k => $v) {
									
									if(strpos(strtoupper($v),$oppo) !== FALSE) {
									  $rowData[$i] = '*';
									 	$i++;
									}	
									
									if(strpos(strtoupper($v), "CHELSEA") !== FALSE) {	
										$rowData[$i] = '*';
									 	$i++;
									}	
									
									if(strpos(strtoupper($v), "SUBSTITUTES") !== FALSE) {	
										$rowData[$i] = '*';
									 	$i++;
									}	
								
										$rowData[$i] .= "'". trim(strip_tags($v)) . "',";
								
								
								}
					$i++;
		}
		
		$newlist = array();
		
		foreach($rowData as $key => $value) {
		  $v = trim(strip_tags(str_replace("No.       Name", "", $value)));
			$newlist[] = explode('*',$v);
		}
		
		$newlist = array_filter($newlist, function($value) { return $value !== ''; });
		
		$rowData = $newlist;
	
		
		
		
	//	$rowdata = explode($exploders, $rowData);
	//	$arrays = explode("name", $rowData);
		
							
		

		$new = array();
		foreach($rowData as $value) {
		  foreach($value as $v) {
		      $new[] = $v;
		    }
		}	
		
		
		$marker = FALSE;
		print '<pre>';
		foreach($new as $k => $v) {
				
							if(isset($v) && $v != '') {
							
									$sql = "INSERT INTO cfc_fixtures_players (F_APPs, F_SUBS, F_UNUSED, F_NO, F_NAME, F_GOALS, F_SHOTSON, F_SHOTS, F_FOULSCOM, F_FOULSSUF, F_ASSISTS, F_OFFSIDES, F_YC, F_RC, F_GAMEID)".PHP_EOL;
									
									if($clubMarker != TRUE) {
										  if(strpos(strtoupper($v), 'CHELSEA')) {
										     $clubMarker = TRUE;
										  }
									   }
									   
									if($clubMarker == TRUE) {
									
										   if($marker != TRUE) {
											  if(strpos(strtoupper($v), 'SUBSTITUTES')) {
											     $marker = TRUE;
											  }
										   }
										  
										  if($marker == TRUE) {
												$sql .= "values ( '0','0','1',".$v ."{$gamer});";
										   } else {
												$sql .= "values ( '1','0','0',".$v ."{$gamer});";
										   }
										   
										   if(strpos($sql, 'Game') != TRUE 
										 		 && strpos($sql, 'Chelsea') != TRUE
										 		// && strpos($sql, 'Substitutes') != TRUE 
										 	) {
							
										   		print $sql.PHP_EOL;
										   		print '<br/>';
										   }
										   
									}
							
							    
							
							}
							
							
					
		}
		
		print '</pre>';
		
		/**************************************************************************************/

		// echo '</textarea>';
			echo '<br/>';
			

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
