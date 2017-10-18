<?php /* Template Name: # Z ** Gen CannTables */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
<div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<?php 
    if(isset($_GET['col']) ? $col = $_GET['col'] : $col='10');
	if(isset($_GET['label']) ? $label = $_GET['label'] : $label='Points');
?>
<h3>Premier League Cann Table on column <?php echo $col.' labelled '.$label; ?></h3>
<?php
	$sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
			      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS, (sum(F)+sum(A)) as F_GPG
			      FROM 0V_base_PL_this
			      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";

	outputDataTable( $sql, 'OVERALL');

	print '<hr/>';

	$raw = returnDataTable( $sql, 'OVERALL');
	print $go->CannNamStyle($raw, $label, $col);
?>
</div>
<?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
