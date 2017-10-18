<?php /* Template Name: # m-form*/ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
    <div id="content">
        <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<?php
// Form handler
$var=$_GET['var']; 
if (isset($var) && $var !='')  {	
		$type = substr($var, 0, 1);
		$var  = (int) substr($var, 1);
/********************************************************************************************************************/
    
switch($type):
	case 'H':
	case 'A':
    
		$sql="SELECT SUM(IF(F_RESULT='W'=1,1,0)) W, SUM(IF(F_RESULT='D'=1,1,0)) D, SUM(IF(F_RESULT='L'=1,1,0)) L,
		ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS WP,
		ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS DP,
		ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS LP
		FROM (SELECT F_RESULT FROM cfc_fixtures a WHERE F_LOCATION=:type ORDER BY F_DATE DESC LIMIT :var) a";
        $pdo = new pdodb();
        $pdo->query($sql);
        $pdo->bind(':type',$type);
        $pdo->bind(':var',$var);
	break;
	
	case 'T':
	default:
		$sql="SELECT SUM(IF(F_RESULT='W'=1,1,0)) W, SUM(IF(F_RESULT='D'=1,1,0)) D, SUM(IF(F_RESULT='L'=1,1,0)) L,
		ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS WP,
		ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS DP,
		ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS LP
		FROM (SELECT F_RESULT FROM cfc_fixtures a ORDER BY F_DATE DESC LIMIT :var) a";
        $pdo = new pdodb();
        $pdo->query($sql);
        $pdo->bind(':var',$var);
	break;	
endswitch;			
    
$result = $pdo->row();				    
$W  = $result["W"];
$D  = $result["D"];
$L  = $result["L"];
$WP = $result["WP"];
$DP = $result["DP"];
$LP = $result["LP"];
				         
switch ($type):
	Case 'H':
	$message = '#stats #Chelsea are W'.$W.' ('.$WP.'%), D'.$D.' ('.$DP.'%) & L'.$L.' ('.$LP.'%) from the last '.$var.' home games in all competitions #cfc';
        break;    
	Case 'A':
	$message = '#stats #Chelsea are W'.$W.' ('.$WP.'%), D'.$D.' ('.$DP.'%) & L'.$L.' ('.$LP.'%) from the last '.$var.' away games in all competitions #cfc';
        break;   
	Case 'T':
	default:
        $message = '#stats #Chelsea are W'.$W.' ('.$WP.'%), D'.$D.' ('.$DP.'%) & L'.$L.' ('.$LP.'%) from the last '.$var.' games in all competitions #cfc';
        break;
endswitch;					


    $melinda->goTweet($message,'APP');
    print $melinda->goMessage($message,'success');
    print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");

} else {
    
/********************************************************************************************************************/
?>
            <div class="row-fluid">
                <div class="span4 offset8">
                    <div id="filter-2" class="widget widget_archive">
						<span class="form-filter">
							<form action="../" class="form">
								<div class="form-group">
									<select name="mySelectbox" class="form-control">
									<option value="" class="bolder">-- (All) Form guide --</option>
									<option value="<?php the_permalink();?>?var=T5">5 games</option>
									<option value="<?php the_permalink();?>?var=T6">6 games</option>
									<option value="<?php the_permalink();?>?var=T10">10 games</option>
									<option value="<?php the_permalink();?>?var=T12">12 games</option>
									<option value="<?php the_permalink();?>?var=T15">15 games</option>
									<option value="<?php the_permalink();?>?var=T19">19 games</option>
									<option value="<?php the_permalink();?>?var=T38">38 games</option>
									<option value="<?php the_permalink();?>?var=T50">50 games</option>
									<option value="<?php the_permalink();?>?var=T76">76 games</option>
									<option value="<?php the_permalink();?>?var=T100">100 games</option>
									<option value="<?php the_permalink();?>?var=T114">114 games</option>
									<option value="<?php the_permalink();?>?var=T200">200 games</option>
									<option value="<?php the_permalink();?>?var=T250">250 games</option>
									<option value="<?php the_permalink();?>?var=T300">300 games</option>
									<option value="<?php the_permalink();?>?var=T500">500 games</option>
									<option value="" class="bolder">-- (Home) Form guide --</option>
									<option value="<?php the_permalink();?>?var=H5">5 games</option>
									<option value="<?php the_permalink();?>?var=H6">6 games</option>
									<option value="<?php the_permalink();?>?var=H10">10 games</option>
									<option value="<?php the_permalink();?>?var=H12">12 games</option>
									<option value="<?php the_permalink();?>?var=H15">15 games</option>
									<option value="<?php the_permalink();?>?var=H19">19 games</option>
									<option value="<?php the_permalink();?>?var=H38">38 games</option>
									<option value="<?php the_permalink();?>?var=H50">50 games</option>
									<option value="<?php the_permalink();?>?var=H76">76 games</option>
									<option value="<?php the_permalink();?>?var=H100">100 games</option>
									<option value="<?php the_permalink();?>?var=H114">114 games</option>
									<option value="<?php the_permalink();?>?var=H200">200 games</option>
									<option value="<?php the_permalink();?>?var=H250">250 games</option>
									<option value="<?php the_permalink();?>?var=H300">300 games</option>
									<option value="<?php the_permalink();?>?var=H500">500 games</option>
									<option value="" class="bolder">-- (Away) Form guide --</option>
									<option value="<?php the_permalink();?>?var=A5">5 games</option>
									<option value="<?php the_permalink();?>?var=A6">6 games</option>
									<option value="<?php the_permalink();?>?var=A10">10 games</option>
									<option value="<?php the_permalink();?>?var=A12">12 games</option>
									<option value="<?php the_permalink();?>?var=A15">15 games</option>
									<option value="<?php the_permalink();?>?var=A19">19 games</option>
									<option value="<?php the_permalink();?>?var=A38">38 games</option>
									<option value="<?php the_permalink();?>?var=A50">50 games</option>
									<option value="<?php the_permalink();?>?var=A76">76 games</option>
									<option value="<?php the_permalink();?>?var=A100">100 games</option>
									<option value="<?php the_permalink();?>?var=A114">114 games</option>
									<option value="<?php the_permalink();?>?var=A200">200 games</option>
									<option value="<?php the_permalink();?>?var=A250">250 games</option>
									<option value="<?php the_permalink();?>?var=A300">300 games</option>
									<option value="<?php the_permalink();?>?var=A500">500 games</option>
									</select>
								</div>
						</span>
					</div>
				</div>
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
