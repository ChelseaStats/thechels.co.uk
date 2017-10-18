<?php /* Template Name: # m-oppomgr */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
    <div id="content">
        <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<?php
// Form handler
$mgr = $_GET['mgr']; 
if (isset($mgr) && $mgr !='') 
{

$pdo = new pdodb();
$pdo->query('SELECT W, D, L, PPG, Last FROM 0V_base_oppoMgr WHERE FullName=:mgr');
$pdo->bind(':mgr',$mgr);    
$row = $pdo->row();    
    
$w      =   $row['W'];
$d      =   $row['D'];
$l      =   $row['L'];
$ppg    =   $row['PPG'];
$date   =   $row['Last'];
    
$mgr_name   = explode(',',$mgr);
$names      = stripslashes(ucwords($mgr_name[1].' '.$mgr_name[0]));
// end form handler

$short_url = $go->goBitly("https://thechels.co.uk/opposition-manager-rank/");
$message1  = "1/ #Stats #Chelsea are W$w D$d L$l against $names (with $ppg ppg) - $short_url";
$message2  = "2/ #Chelsea's last meeting with $names was $date - $short_url";

    $melinda->goTweet($message1,'APP');
    print $melinda->goMessage($message1,'success');

    $melinda->goTweet($message2,'APP');
    print $melinda->goMessage($message2,'success');


    print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");

}
else
{
?>
    <form action="../" class="form form-control">
    <div class="form-group">
		<label class="control-label" for="mySelectbox">Choose Manager:</label>
		<select id="MySelectBox" name="mySelectbox" class="form-control">
		<option value="" class="bolder"> -- Choose a Oppo Manager --</option>
		<?php

		$pdo = new pdodb();
		$pdo->query('SELECT FullName FROM 0V_base_oppoMgr ORDER BY FullName ASC');
		$rows = $pdo->rows();
		//create array of pairs of x and y values
		foreach($rows as $row) {
		?>
		<option value="<?php the_permalink();?>?mgr=<?php echo $row['FullName']; ?>"><?php echo $row['FullName']; ?></option>
		<?php   }    ?>
		</select>
    </div>
<?php print $go->getSubmit(); ?>
</form>
<?php } ?>
</div>
<?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
