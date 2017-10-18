<?php /* Template Name:  # Z ** Draft WSL */ ?>
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

				$form_wslpro        = isset($_POST['wslpro'])       ? $_POST['wslpro']          : '0' ;
				$form_wsl           = isset($_POST['wsl'])          ? $_POST['wsl']             : '0' ;
				$form_wsl_cann      = isset($_POST['wsl_cann'])     ? $_POST['wsl_cann']        : '0' ;
				$form_wsl_goaldiff  = isset($_POST['wsl_goaldiff']) ? $_POST['wsl_goaldiff']    : '0' ;
				$form_wsl_summary   = isset($_POST['wsl_summary'])  ? $_POST['wsl_summary']     : '0' ;


				if(isset($gw) && $gw !='') {

					print "<div class='alert alert-info'>";
					
					$posts = array (

						// automated
						array('post'=> $form_wslpro         , 'category' => array('473','638') , 'content' => $go->get_drafter_table('wslpro'),    'title' => 'Gameweek '.$gw.' '.$ssn.': The WSL Progress Report', 'tags' => ''),
						array('post'=> $form_wsl            , 'category' => array('473')       , 'content' => $go->get_drafter_table('wsl'),     'title' => 'Gameweek '.$gw.' '.$ssn.': Women\'s Super League Table', 'tags' => ''),
						array('post'=> $form_wsl_cann       , 'category' => array('473','160') , 'content' => $go->get_drafter_table('wsl_cann'),   'title' => 'Gameweek '.$gw.' '.$ssn.': WSL Cann Table', 'tags' => ''),
						array('post'=> $form_wsl_goaldiff   , 'category' => array('473','498') , 'content' => $go->get_drafter_table('wsl_goaldiff'), 'title' => 'Gameweek '.$gw.' '.$ssn.': WSL Goal Difference League', 'tags' => ''),
						array('post'=> $form_wsl_summary    , 'category' => array('473','498') , 'content' => $go->get_wsl_summary(), 'title' => 'Gameweek '.$gw.' '.$ssn.': WSL Summary Stats', 'tags' => '')
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
							<input name="gw"   type="number" id="gw">
						</div>

						<div class="form-group">
							<label for="ssn">ssn:</label>
							<input name="ssn"   type="text" id="ssn" placeholder="2016" value="2016">
						</div>

						<div class="form-group">

							<div class="checkbox"><label for="wslpro">          <input type="checkbox" id="wslpro" name="wslpro" value="1" checked> WSL Progress</label> </div>
							<div class="checkbox"><label for="wsl">             <input type="checkbox" id="wsl" name="wsl" value="1" checked> WSL</label> </div>
							<div class="checkbox"><label for="wsl_cann">        <input type="checkbox" id="wsl_cann" name="wsl_cann" value="1" checked> WSL cann</label> </div>
							<div class="checkbox"><label for="wsl_goaldiff">    <input type="checkbox" id="wsl_goaldiff" name="wsl_goaldiff" value="1" checked> WSL Goal Diff</label> </div>
							<div class="checkbox"><label for="wsl_summary">     <input type="checkbox" id="wsl_summary" name="wsl_summary" value="1" checked> WSL Summaries</label> </div>
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
