<?php /* Template Name: # Z ** View Schema */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?></h4>
			<p>View Schema</p>
				<?php
					$method = isset($_GET['m']) ? $_GET['m'] : '0V_base_LDN_non' ;
					$up     = isset($_GET['up']) ? $_GET['up'] : 'false' ;


					if(method_exists($schema,$method)) {
						$sql = $schema->$method();
					} else {
						$sql = "Method not found";
					}

					print_r($sql);

					if(isset($up) & strtoupper($up) == 'TRUE') {

						$pdo = new pdodb();
						$pdo->query($sql);
						$pdo->execute();

						$m = new melinda();
						$m->goMessage( 'updated', 'success');

					}

				?>
		</div>
		<div id="sidebar" class="desktop">
			<div id="sideimages">
				<a href="https://twitter.com/ChelseaStats" class="twitter-follow-button" data-show-count="true" data-text-color = "#0080ff" data-size="small">Follow @ChelseaStats</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				<br/>
			</div>
			<ul class="nav nav-list">
			<li class="nav-header">List of methods</li>
			<?php
				$class_methods = get_class_methods($schema);
						foreach ($class_methods as $method_name) {
							echo "<li><a href='?m={$method_name}'>{$method_name}</a></li>";
						}

			?>
				<li class="divider"></li>
			</ul>
		</div>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
