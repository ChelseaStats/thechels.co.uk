<?php /* Template Name:  # Z Matching Players */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
	<div id="content">
		<div id="contentleft">
			<?php print $go->goAdminMenu(); ?>
			<h4 class="special"> <?php the_title(); ?> Audit</h4>
			<?php
				if(isset($_GET['m1']) ? $name1 = $_GET['m1'] : $name1='JOHN_OBI_MIKEL');
				if(isset($_GET['m2']) ? $name2 = $_GET['m2'] : $name2='NEMANJA_MATIC');

				$display1 = $go->_V($name1);
				$display2 = $go->_V($name2);

				print "<h3>All Results with both {$display1} and {$display2} starting</h3>";

				//================================================================================
				$sql = "select CONCAT(F_ID,',',F_DATE) as MX_DATE, F_OPP as Team, F_COMPETITION, F_LOCATION as Loc, F_RESULT, F_FOR, F_AGAINST
						from cfc_fixtures where f_id in (
                        SELECT F_GAMEID FROM cfc_fixtures_players WHERE F_NAME='$name1' and F_APPS='1'
                        and F_GAMEID in ( SELECT F_GAMEID FROM cfc_fixtures_players WHERE F_NAME='$name2' and F_APPS='1') )";
				outputDataTable( $sql, 'DATES');
				//================================================================================

			?>
		</div>
		<?php get_template_part('sidebar');?>
	</div>
	<div class="clearfix"><p>&nbsp;</p></div>
	<!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
