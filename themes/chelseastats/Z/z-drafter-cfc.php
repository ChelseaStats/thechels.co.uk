<?php /* Template Name:  # Z ** Draft CFC */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<?php
				$date 		    = date('Y-m-d');
				$oppo 		    = $_POST['oppo'];
				$gw 		    = $_POST['gw'];
				$ssn		    = $_POST['ssn'];
				$scorers	    = $_POST['scorers'];
				$assists	    = $_POST['assists'];

				$gameid	        = isset($_POST['gamer'])  ? $_POST['gamer']   : $value = $go->get_maxGameId(); ;

				$form_otd    	= isset($_POST['otd']) 	  ? $_POST['otd']     : '0' ;
				$form_points    = isset($_POST['points']) ? $_POST['points']  : '0' ;
				$form_ratings   = isset($_POST['ratings']) ? $_POST['ratings']  : '0' ;
				$form_round     = isset($_POST['round'])  ? $_POST['round']   : '0' ;
				$form_starts    = isset($_POST['starts']) ? $_POST['starts']  : '0' ;
				$form_subs      = isset($_POST['subs'])   ? $_POST['subs']    : '0' ;
				$form_per90     = isset($_POST['per90'])  ? $_POST['per90']   : '0' ;
				$form_mgrcom    = isset($_POST['mgrcom']) ? $_POST['mgrcom']  : '0' ;
				$form_chance    = isset($_POST['chance']) ? $_POST['chance']  : '0' ;
				$form_ccbm      = isset($_POST['ccbm'])   ? $_POST['ccbm']    : '0' ;
				$form_zone      = isset($_POST['zone'])   ? $_POST['zone']    : '0' ;
				$form_hs        = isset($_POST['hs'])   ? $_POST['hs']    : '0' ;

				if(isset($oppo) && $oppo !='') {

					if ($form_ratings == 1) {

						print '<div class="alert alert-info">';
						$post_id = $go->cfc_CreateRatingsPost( $gw, $ssn, $oppo );
						print $post_id . ' :- Ratings feeder created<br/>';
						print '</div>';
					}

					print "<div class='alert alert-info'>";

					if ($form_points == 1) {

						$post_id  = $go->cfc_CreateThreePointsPost();
						print $post_id . ' :- Three Points post created<br/>';

					}

					if ($form_otd == 1) {

						$post_id  = $go->cfc_CreateOtdPost();
						print $post_id . ' :- On This Day posts created<br/>';

					}

					$posts = array (

						// automated
						array('post'=> $form_round , 'category' => array('1')   , 'content' => $go->get_StatsRoundup(),          'title' => 'Gameweek '.$gw.' '.$ssn.': Premier League Stats Roundup', 'tags' => ''),
						array('post'=> $form_starts, 'category' => array('1')   , 'content' => $go->get_ResultsByStart(),        'title' => 'Gameweek '.$gw.' '.$ssn.': Cumulative Results Per Starter', 'tags' => ''),
						array('post'=> $form_subs  , 'category' => array('1')   , 'content' => $go->get_SubPerf(),               'title' => 'Gameweek '.$gw.' '.$ssn.': Cumulative Substitute Contribution', 'tags' => ''),
						array('post'=> $form_per90 , 'category' => array('623') , 'content' => $go->get_production90(),          'title' => 'Gameweek '.$gw.' '.$ssn.': Player Production Per 90', 'tags' => $scorers .','. $assists),
						array('post'=> $form_mgrcom, 'category' => array('594') , 'content' => $go->get_MgrCompare(),            'title' => 'Gameweek '.$gw.' '.$ssn.': The Manager Comparison League',
						      'tags' => 'Antonio Conte, Andre Villas Boas,Avram Grant,Carlo Ancelotti,Claudio Ranieri,David Webb,Gianluca Vialli, Glenn Hoddle, Graham Rix,Guus Hiddink,Jose Mourinho,Phil Scolari, Rafael Benitez, Ray Wilkins,Roberto Di Matteo,Ruud Gullit'),
						array('post'=> $form_chance, 'category' => array('631') , 'content' => $go->get_plcc(),                  'title' => 'Gameweek '.$gw.' '.$ssn.': Premier League Chance Conversion', 'tags' => $scorers),
						array('post'=> $form_zone  , 'category' => array('574') , 'content' => $go->get_zone(), 		         'title' => 'Gameweek '.$gw.' '.$ssn.': The Statszone : '.$oppo.'', 'tags' => ''),
						array('post'=> $form_hs    , 'category' => array('1')   , 'content' => "[hs]". $go->get_HeadlineStats('Chelsea'), 'title' => 'Gameweek '.$gw.' '.$ssn.': Headline Statistics', 'tags' => ''),
						array('post'=> $form_ccbm  , 'category' => array('680') , 'content' => $go->get_shotsAnalysis($oppo,$gw, $ssn, $gameid),    'title' => 'Gameweek '.$gw.' '.$ssn.': Shots Analysis', 'tags' => ''),

					);

					foreach ($posts as $array) {

						$adder    = $array['post'];
						$category = $array['category'];
						$content  = $array['content'];
						$title    = $array['title'];
						$tags     = $array['tags'];
						$post_id  = '';

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
							<input name="gw"   type="number" id="gw" value = "<?php print $value = $go->get_gameWeek(); ?>" >
						</div>

						<div class="form-group">
							<label for="ssn">ssn:</label>
							<input name="ssn"   type="text" id="ssn" value = "<?php print $value = $go->get_ssn(); ?>">
						</div>

						<div class="form-group">
							<label for="oppo">Oppo (nice):</label>
							<input name="oppo"   type="text" id="oppo" value = "<?php print $value = $go->get_oppo(); ?>">
						</div>

						<div class="form-group">
							<label for="scorers">scorers (tags):</label>
							<input name="scorers"   type="text" id="scorers" value = "<?php print $value = $go->get_scorers(); ?>">
						</div>
						<div class="form-group">
							<label for="assists">assisted (tags):</label>
							<input name="assists"   type="text" id="assists" value =" <?php print $value = $go->get_assisters(); ?>">
						</div>


						<div class="form-group">
							<label for="gamer">Game id:</label>
							<input name="gamer" type="number" id="gamer" class="form-control" value = "<?php print $value = $go->get_maxGameId(); ?>">
						</div>


						<div class="form-group">

							<div class="checkbox"><label for="points">   <input type="checkbox" id="points" name="points" value="1" > 3 Points</label> </div>
							<div class="checkbox"><label for="otd">      <input type="checkbox" id="otd" name="otd" value="1" >On This Day</label> </div>
							<br/>
							<br/>
							<div class="checkbox"><label for="ratings">  <input type="checkbox" id="ratings" name="ratings" value="1" checked> Ratings</label> </div>
							<div class="checkbox"><label for="round">    <input type="checkbox" id="round" name="round" value="1" checked> Roundup</label> </div>
							<div class="checkbox"><label for="starts">   <input type="checkbox" id="starts" name="starts" value="1" checked> Results by starters</label> </div>
							<div class="checkbox"><label for="subs">     <input type="checkbox" id="subs" name="subs" value="1" checked> Sub performance</label> </div>
							<div class="checkbox"><label for="per90">    <input type="checkbox" id="per90" name="per90" value="1" checked> Production Per90</label> </div>
							<div class="checkbox"><label for="mgrcom">   <input type="checkbox" id="mgrcom" name="mgrcom" value="1" checked> Manager Compare League</label> </div>
							<div class="checkbox"><label for="chance">   <input type="checkbox" id="chance" name="chance" value="1" checked> Chance Conversion</label> </div>
							<div class="checkbox"><label for="ccbm">     <input type="checkbox" id="ccbm" name="ccbm" value="1" checked> Shots Analysis</label> </div>
							<div class="checkbox"><label for="zone">     <input type="checkbox" id="zone" name="zone" value="1" checked> Statszone report</label> </div>
							<div class="checkbox"><label for="hs">      <input type="checkbox" id="hs" name="hs" value="1" checked> Headline Stats report</label> </div>
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
