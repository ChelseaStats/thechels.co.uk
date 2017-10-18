<?php /* Template Name: # D TBL L38 */ ?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
<?php echo do_shortcode('[last38]'); ?>
<?php print $go->getTableKey(); ?>

	<h3>Last 38 - limited to active Premier League teams</h3>
	<?php
		//================================================================================
		$sql="SELECT Team, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS FROM 0V_base_last38_this
		ORDER BY PPG DESC, PTS DESC, GD DESC, Team DESC";
		outputDataTable( $sql, 'L38 League');
		//================================================================================
	?>
	
	<h3>Last 38 - all previous and current Premier League teams</h3>
		<?php
		//================================================================================
		$sql="SELECT Team, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS FROM 0V_base_last38
		ORDER BY PPG DESC, PTS DESC, GD DESC, Team DESC";
		 outputDataTable( $sql, 'L38 League');
		//================================================================================
	?>

</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
