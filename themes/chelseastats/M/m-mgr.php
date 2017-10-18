<?php /* Template Name: # m-mgr */ ?>
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
$pdo->query('SELECT W, D, L, GD, PPG, F_FOR as F, F_AGAINST as A, CS, FS FROM 0V_base_mgr WHERE F_SNAME=:mgr');
$pdo->bind(':mgr',$mgr);    
$row = $pdo->row();

$w   = $row['W'];
$d   = $row['D'];
$l   = $row['L'];
$gd  = $row['GD'];
$ppg = $row['PPG'];
$F   = $row['F'];
$A   = $row['A'];
$CS  = $row['CS'];
$FS  = $row['FS'];
$mgr_name = ucwords(strtolower($mgr));

if($gd>0) { $gd='+'.$gd; }
if($gd<0) { $gd='-'.$gd; }

// end form handler
/*********************        Bitly Key authorisation                     ***********************/
$url        = "http://thechels.uk/CFCmgrs";
$message1   = "1/ #Stats #Chelsea's record with $mgr_name stands at:  W$w D$d L$l (GD$gd) and with $ppg PPG - $url (1/2)";
$message2   = "2/ $mgr_name also has a record of F$F A$A FS$FS and CS$CS $url (2/2) #CFC";
    

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
<select name="mySelectbox" class="form-control">
<option value="" class="bolder"> -- Choose our Manager --</option>
<?php
    
$pdo = new pdodb();
$pdo->query('SELECT F_SNAME FROM 0V_base_mgr ORDER BY F_SNAME ASC');
$rows = $pdo->rows();
//create array of pairs of x and y values
foreach ($rows as $row) { 
?>
<option value="<?php the_permalink();?>?mgr=<?php echo $row['F_SNAME']; ?>"><?php echo $row['F_SNAME']; ?></option>
<?php    }    ?>
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
