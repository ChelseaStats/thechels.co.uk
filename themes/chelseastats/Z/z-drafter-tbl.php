<?php /* Template Name:  # Z ** Draft TBL */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
		
			<?php
				$date 		    = date('Y-m-d');
				$gw 		    = $_POST['gw'];
				$ssn		    = $_POST['ssn'];

				$form_pro       = isset($_POST['pro'])    ? $_POST['pro']     : '0' ;
				$form_pl        = isset($_POST['pl'])     ? $_POST['pl']      : '0' ;
				$form_ever      = isset($_POST['ever6'])  ? $_POST['ever6']   : '0' ;
				$form_big       = isset($_POST['big7'])   ? $_POST['big7']    : '0' ;
				$form_ldn       = isset($_POST['ldn'])    ? $_POST['ldn']     : '0' ;
				$form_last      = isset($_POST['last38']) ? $_POST['last38']  : '0' ;
				$form_cann      = isset($_POST['cann'])   ? $_POST['cann']    : '0' ;
				$form_goaldiff  = isset($_POST['goaldiff']) ? $_POST['goaldiff'] : '0' ;
				$form_shots     = isset($_POST['shots'])   ? $_POST['shots']    : '0' ;
				$form_shotson   = isset($_POST['shotson']) ? $_POST['shotson'] : '0' ;
				$form_procfc    = isset($_POST['procfc']) ? $_POST['procfc'] : '0' ;
				$form_fancy     = isset($_POST['fancy']) ? $_POST['fancy'] : '0' ;
				$form_charts    = isset($_POST['charts']) ? $_POST['charts'] : '0' ;
				$form_fouls     = isset($_POST['fouls']) ? $_POST['fouls'] : '0' ;



				if(isset($gw) && $gw !='') {

					print "<div class='alert alert-info'>";
					
					$posts = array (

						// automated
						array('post'=> $form_pro   , 'category' => array('638') , 'content' => $go->get_drafter_table('pro'),    'title' => 'Gameweek '.$gw.' '.$ssn.': The Progress Report', 'tags' => ''),
						array('post'=> $form_pl    , 'category' => array('171') , 'content' => $go->get_drafter_table('pl'),     'title' => 'Gameweek '.$gw.' '.$ssn.': Premier League Table', 'tags' => ''),
						array('post'=> $form_ldn   , 'category' => array('519') , 'content' => $go->get_drafter_table('ldn'),    'title' => 'Gameweek '.$gw.' '.$ssn.': The London League', 'tags' => ''),
						array('post'=> $form_big   , 'category' => array('632') , 'content' => $go->get_drafter_table('big'),    'title' => 'Gameweek '.$gw.' '.$ssn.': The Big 7 League', 'tags' => ''),
						array('post'=> $form_last  , 'category' => array('591') , 'content' => $go->get_drafter_table('last38'), 'title' => 'Gameweek '.$gw.' '.$ssn.': The Last 38 League', 'tags' => ''),
						array('post'=> $form_ever  , 'category' => array('633') , 'content' => $go->get_drafter_table('ever'),   'title' => 'Gameweek '.$gw.' '.$ssn.': The Ever 6 League', 'tags' => ''),
						array('post'=> $form_cann  , 'category' => array('160') , 'content' => $go->get_drafter_table('cann'),   'title' => 'Gameweek '.$gw.' '.$ssn.': Cann Table', 'tags' => ''),
						array('post'=> $form_goaldiff  , 'category' => array('498') , 'content' => $go->get_drafter_table('goaldiff'), 'title' => 'Gameweek '.$gw.' '.$ssn.': Goal Difference League', 'tags' => ''),
						array('post'=> $form_shots     , 'category' => array('171') , 'content' => $go->get_drafter_table('shots'),   'title' => 'Gameweek '.$gw.' '.$ssn.': Shots League', 'tags' => ''),
						array('post'=> $form_shotson   , 'category' => array('171') , 'content' => $go->get_drafter_table('shotson'), 'title' => 'Gameweek '.$gw.' '.$ssn.': Shots on Target League', 'tags' => ''),
						array('post'=> $form_procfc    , 'category' => array('171') , 'content' => $go->get_drafter_table('procfc'), 'title' => 'Gameweek '.$gw.' '.$ssn.': The Comparable Fixtures League', 'tags' => ''),
						array('post'=> $form_fancy     , 'category' => array('171') , 'content' => $go->get_drafter_table('fancy'), 'title' => 'Gameweek '.$gw.' '.$ssn.': Fancy Stats', 'tags' => ''),
						array('post'=> $form_charts    , 'category' => array('171') , 'content' => $go->get_ChartAnalysis($gw, $ssn), 'title' => 'Gameweek '.$gw.' '.$ssn.': Charts', 'tags' => ''),
						array('post'=> $form_fouls    , 'category' => array('171') , 'content' => $go->get_drafter_table('fouls'), 'title' => 'Gameweek '.$gw.' '.$ssn.': Fouls and Cards', 'tags' => ''),


					);
					foreach ($posts as $array) {

						$adder    = $array['post'];
						$category = $array['category'];
						$content  = $array['content'];
						$title    = $array['title'];
						$tags     = $array['tags'];

						if ( $adder == 1 ) {

							$post_id = $go->programmatically_create_post( $category, $content, $title, $tags );

						}

						if ( - 1 == $post_id || - 2 == $post_id ) {

								// The post wasn't created or the page already exists
								print 'Error creating post: ' . $title . ' (reason: ' . $post_id . ')';

						} else {

							if ( $adder == 1 ) {
								print  $post_id . ' :- ' . $title . '<br/>';
							}

						}

					}

					Print "</div>";

				} else { ?>
					<form action="<?php the_permalink();?>" method="POST">

						<div class="form-group">
							<label for="gw">Gameweek:</label>
							<input name="gw"   type="number" id="gw" value = <?php print $value = $go->get_gameWeek(); ?> >
						</div>

						<div class="form-group">
							<label for="ssn">ssn:</label>
							<input name="ssn"   type="text" id="ssn" value = <?php print $value = $go->get_ssn(); ?> >
						</div>


						<div class="form-group">

							<div class="checkbox"><label for="big7">     <input type="checkbox" id="big7" name="big7" value="1" checked> Big 7 League</label> </div>
							<div class="checkbox"><label for="ever6">    <input type="checkbox" id="ever6" name="ever6" value="1" checked> Ever 6 League</label> </div>
							<div class="checkbox"><label for="ldn">      <input type="checkbox" id="ldn" name="ldn" value="1" checked> London League</label> </div>
							<div class="checkbox"><label for="last38">   <input type="checkbox" id="last38" name="last38" value="1" checked> Last 38 League</label>  </div>
							<div class="checkbox"><label for="pl">       <input type="checkbox" id="pl" name="pl" value="1" checked> Premier League</label> </div>
							<div class="checkbox"><label for="pro">      <input type="checkbox" id="pro" name="pro" value="1" checked> Progress League</label></div>
							<div class="checkbox"><label for="cann">     <input type="checkbox" id="cann" name="cann" value="1" checked> Cann</label> </div>
							<div class="checkbox"><label for="goaldiff"> <input type="checkbox" id="goaldiff" name="goaldiff" value="1" checked> Goal Diff</label> </div>
							<div class="checkbox"><label for="shots">       <input type="checkbox" id="shots" name="shots" value="1" checked> Shots League</label> </div>
							<div class="checkbox"><label for="shotson">     <input type="checkbox" id="shotson" name="shotson" value="1" checked> Shots On League</label> </div>
							<div class="checkbox"><label for="procfc">      <input type="checkbox" id="procfc" name="procfc" value="1" checked> Comparable CFC League</label> </div>
							<div class="checkbox"><label for="fancy">      <input type="checkbox" id="fancy" name="fancy" value="1" checked> Fancy Stats</label> </div>
							<div class="checkbox"><label for="charts">      <input type="checkbox" id="charts" name="charts" value="1" checked> Charts Stats</label> </div>
							<div class="checkbox"><label for="fouls">      <input type="checkbox" id="fouls" name="fouls" value="1" checked> Fouls/Cards</label> </div>



						</div>

						<div class="form-group">
							<input type="submit" value="submit" class="btn btn-primary">
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
