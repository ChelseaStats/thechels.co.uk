<?php /* Template Name: # D Mapping */ ?>
<?php get_header();?>
<div id="content">
<div id="contentleft">
<h2><a href="<?php the_permalink(); ?>">Every Chelsea game vs Opposition and Referee</a></h2>
<br/>
<h3>Teams</h3>
<ul>
<?php
$pdo = new pdodb();


$pdo->query("SELECT DISTINCT F_OPP FROM cfc_fixtures WHERE F_OPP IS NOT NULL ORDER BY F_OPP ASC");
$rows = $pdo->rows();
foreach($rows as $row) {
	$V = $go->_V($row["F_OPP"]);
	$Q = $go->_Q($row["F_OPP"]);
	?>
	<li><a href="<?php get_home_url(); ?>/analysis/results/?team=<?php echo $Q; ?>"
	       title="Chelsea vs <?php echo $V; ?> Complete Stats history and head to head record">
			Chelsea vs <?php echo $V; ?> Complete Stats history and head to head record</a></li>
	<php } ?>
</ul>
<h3>Referees</h3>
<ul>
<?php
$pdo->query("SELECT DISTINCT F_REF AS F_REF FROM cfc_fixtures WHERE F_REF IS NOT NULL ORDER BY F_REF ASC");
$refRows = $pdo->rows();
foreach($refRows as $refRow) {
	$f1=($refRow["F_REF"]);
	$nice_ref = preg_split("/[\s,]+/",$f1);
	$f2= ucwords(strtolower($nice_ref[1]." ".$nice_ref[0]));
}
?>
	<li>Referee: <a href="<?php get_home_url(); ?>/analysis/referees/?ref=<?php echo $f1; ?>" title="Every <?php echo $f2; ?> performance,results and stats against Chelsea">
			<?php echo $f2; ?> performance, results and stats against Chelsea</a></li>

<?php } ?>
</ul>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>