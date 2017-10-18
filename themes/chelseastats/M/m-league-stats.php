<?php /* Template Name: # m-league-stats*/ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
    <div id="content">
    <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<?php
$tweet=$_GET['tw']; 
if (isset($tweet) && $tweet !='')  {
switch ($tweet) {
/********************************************************************************************************************/
case 'T01': //  CFC
	$sql="SELECT Team as N, sum(CS) as V FROM 0V_base_PL_this 
            GROUP BY Team ORDER BY sum(CS) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for Clean Sheets (this season): ";
	break;
/********************************************************************************************************************/
case 'T02': // CFC
	$sql="SELECT Team as N, sum(FS) as V FROM 0V_base_PL_this 
            GROUP BY Team ORDER BY SUM(FS) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for failing to score (this season): ";
	break;
/********************************************************************************************************************/
case 'T03': // CFC
	$sql="SELECT Team as N, sum(F) as V FROM 0V_base_PL_this 
            GROUP BY Team ORDER BY SUM(F) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for scoring (this season): ";
	break;
/********************************************************************************************************************/
case 'T04': // CFC
	$sql="SELECT Team as N, sum(A) as V FROM 0V_base_PL_this 
            GROUP BY Team ORDER BY SUM(A) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for conceding (this season): ";
	break;   
/********************************************************************************************************************/    
case 'T05': //  CFC
	$sql="SELECT Team as N, sum(CS) as V FROM 0V_base_PL 
            GROUP BY Team ORDER BY SUM(CS) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for Clean Sheets (all time): ";
	break;
/********************************************************************************************************************/
case 'T06': // CFC
	$sql="SELECT Team as N, sum(FS) as V FROM 0V_base_PL 
            GROUP BY Team ORDER BY SUM(FS) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for failing to score (all time): ";
	break;
/********************************************************************************************************************/
case 'T07': // CFC
	$sql="SELECT Team as N, sum(F) as V FROM 0V_base_PL 
            GROUP BY Team ORDER BY SUM(F) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for scoring (all time): ";
	break;
/********************************************************************************************************************/
case 'T08': // CFC
	$sql="SELECT Team as N, sum(A) as V FROM 0V_base_PL 
            GROUP BY Team ORDER BY SUM(A) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for conceding (all time): ";
	break;
/********************************************************************************************************************/
case 'T09': //  CFC
	$sql="SELECT Team as N, sum(CS) as V FROM 0V_base_PL_this WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(CS) DESC  LIMIT 0,5";
	$message="#Stats Top 3 PL teams for Clean Sheets at home (this season): ";
	break;
/********************************************************************************************************************/
case 'T10': // CFC
	$sql="SELECT Team as N, sum(FS) as V FROM 0V_base_PL_this WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(FS) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for failing to score at home (this season): ";
	break;
/********************************************************************************************************************/
case 'T11': // CFC
	$sql="SELECT Team as N, sum(F) as V FROM 0V_base_PL_this WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(F) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for scoring at home (this season): ";
	break;
/********************************************************************************************************************/
case 'T12': // CFC
	$sql="SELECT Team as N, sum(A) as V FROM 0V_base_PL_this WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(A) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for conceding at home (this season): ";
	break; 
/********************************************************************************************************************/    
case 'T13': //  CFC
	$sql="SELECT Team as N, sum(CS) as V FROM 0V_base_PL WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(CS) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for Clean Sheets at home (all time): ";
	break;
/********************************************************************************************************************/
case 'T14': // CFC
        $sql="SELECT Team as N, sum(FS) as V FROM 0V_base_PL WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(FS) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for failing to score at home (all time): ";
	break;
/********************************************************************************************************************/
case 'T15': // CFC
	$sql="SELECT Team as N, sum(F) as V FROM 0V_base_PL WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(F) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for scoring at home (all time): ";
	break;
/********************************************************************************************************************/
case 'T16': // CFC
	$sql="SELECT Team as N, sum(A) as V FROM 0V_base_PL WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(A) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for conceding at home (all time): ";
	break;
/********************************************************************************************************************/
case 'T17': //  CFC
	$sql="SELECT Team as N, sum(CS) as V FROM 0V_base_PL_this WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(CS) DESC  LIMIT 0,5";
	$message="#Stats Top 3 PL teams for Clean Sheets away (this season): ";
	break;
/********************************************************************************************************************/
case 'T18': // CFC
	$sql="SELECT Team as N, sum(FS) as V FROM 0V_base_PL_this WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(FS) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for failing to score away (this season): ";
	break;
/********************************************************************************************************************/
case 'T19': // CFC
	$sql="SELECT Team as N, sum(F) as V FROM 0V_base_PL_this WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(F) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for scoring away (this season): ";
	break;
/********************************************************************************************************************/
case 'T20': // CFC
	$sql="SELECT Team as N, sum(A) as V FROM 0V_base_PL_this WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(A) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for conceding away (this season): ";
	break;
/********************************************************************************************************************/    
case 'T21': //  CFC
	$sql="SELECT Team as N, sum(CS) as V FROM 0V_base_PL WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(CS) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for Clean Sheets away (all time): ";
	break;
/********************************************************************************************************************/
case 'T22': // CFC
	$sql="SELECT Team as N, sum(FS) as V FROM 0V_base_PL WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(FS) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for failing to score away (all time): ";
	break;
/********************************************************************************************************************/
case 'T23': // CFC
	$sql="SELECT Team as N, sum(F) as V FROM 0V_base_PL WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(F) DESC  LIMIT 0,3";
	$message="#Stats Top 3 PL teams for scoring away (all time): ";
	break;
/********************************************************************************************************************/
case 'T24': // CFC
	$sql="SELECT Team as N, sum(A) as V FROM 0V_base_PL WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(A) DESC  LIMIT 0,3";
	$message="#Stats Worst 3 PL teams for conceding away (all time): ";
	break;
/********************************************************************************************************************/    
case 'T25': // CFC
	$sql="SELECT Team as N, sum(BTTS) as V FROM 0V_base_PL_this 
            GROUP BY Team ORDER BY SUM(BTTS) DESC  LIMIT 0,3";
	$message="#Stats 3 PL teams for most BTTS (this season): ";
	break;
/********************************************************************************************************************/ 
case 'T26': // CFC
	$sql="SELECT Team as N, sum(BTTS) as V FROM  0V_base_PL 
            GROUP BY Team ORDER BY SUM(BTTS) DESC  LIMIT 0,3";
	$message="#Stats 3 PL teams for most BTTS (all time): ";
	break;
/********************************************************************************************************************/ 
case 'T27': // CFC
	$sql="SELECT Team as N, sum(BTTS) as V FROM 0V_base_PL_this  WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(BTTS) DESC  LIMIT 0,3";
	$message="#Stats 3 PL teams for most BTTS at home (this season): ";
	break;
/********************************************************************************************************************/ 
case 'T28': // CFC
	$sql="SELECT Team as N, sum(BTTS) as V FROM 0V_base_PL WHERE LOC='H'
            GROUP BY Team ORDER BY SUM(BTTS) DESC  LIMIT 0,3";
	$message="#Stats 3 PL teams for most BTTS at home (all time): ";
	break;
/********************************************************************************************************************/ 
case 'T29': // CFC
	$sql="SELECT Team as N, sum(BTTS) as V FROM 0V_base_PL_this WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(BTTS) DESC  LIMIT 0,3";
	$message="#Stats 3 PL teams for most BTTS away (this season): ";
	break;
/********************************************************************************************************************/ 
case 'T30': // CFC
	$sql="SELECT Team as N, sum(BTTS) as V FROM 0V_base_PL WHERE LOC='A'
            GROUP BY Team ORDER BY SUM(BTTS) DESC  LIMIT 0,3";
	$message="#Stats 3 PL teams for most BTTS away (all time): ";
	break;
/********************************************************************************************************************/ 
     
    
}
    $pdo = new pdodb();
    $pdo->query($sql);
    $rows = $pdo->rows();
    
    foreach ($rows as $row) {
           $ns[] = $row['N'];
           $vs[] = $row['V'];
         }

                    $n0=$ns[0];
                    $v0=$vs[0];
                    $n1=$ns[1];
                    $v1=$vs[1];
                    $n2=$ns[2];
                    $v2=$vs[2];

                $step1  = $n0.' ('.$v0.'), '.$n1.' ('.$v1.') & '.$n2.' ('.$v2.')';
         	$output = $go->_V($step1);
$message = $message.' '.$output;

    $melinda->goTweet($message,'APP');
    print $melinda->goMessage($message,'success');
    print $go->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");

} else {
/********************************************************************************************************************/
?>
    <div class="row-fluid">
        <div class="span4 offset8">
        <form action="../" class="form">
            <div id="filter-2" class="widget widget_archive">
		        <span class="form-filter">
                    <div class="form-group">
                        <select name="mySelectbox" class="form-control">
                        <option value="" class="bolder">-- This Season (all) --</option>
                        <option value="<?php the_permalink();?>?tw=T01">top 3 Clean Sheets</option>
                        <option value="<?php the_permalink();?>?tw=T02">top 3 Failed to score</option>
                        <option value="<?php the_permalink();?>?tw=T03">top 3 Goals for</option>
                        <option value="<?php the_permalink();?>?tw=T04">top 3 Against</option>
                        <option value="<?php the_permalink();?>?tw=T25">top 3 BTTS</option>

                        <option value="" class="bolder">-- All time (all) --</option>
                        <option value="<?php the_permalink();?>?tw=T05">top 3 Clean Sheets</option>
                        <option value="<?php the_permalink();?>?tw=T06">top 3 Failed to score</option>
                        <option value="<?php the_permalink();?>?tw=T07">top 3 Goals for</option>
                        <option value="<?php the_permalink();?>?tw=T08">top 3 Against</option>
                        <option value="<?php the_permalink();?>?tw=T26">top 3 BTTS</option>

                        <option value="" class="bolder">-- This Season (H) --</option>
                        <option value="<?php the_permalink();?>?tw=T09">top 3 Clean Sheets</option>
                        <option value="<?php the_permalink();?>?tw=T10">top 3 Failed to score</option>
                        <option value="<?php the_permalink();?>?tw=T11">top 3 Goals for</option>
                        <option value="<?php the_permalink();?>?tw=T12">top 3 Against</option>
                        <option value="<?php the_permalink();?>?tw=T27">top 3 BTTS</option>

                        <option value="" class="bolder">-- All time (H) --</option>
                        <option value="<?php the_permalink();?>?tw=T13">top 3 Clean Sheets</option>
                        <option value="<?php the_permalink();?>?tw=T14">top 3 Failed to score</option>
                        <option value="<?php the_permalink();?>?tw=T15">top 3 Goals for</option>
                        <option value="<?php the_permalink();?>?tw=T16">top 3 Against</option>
                        <option value="<?php the_permalink();?>?tw=T28">top 3 BTTS</option>

                        <option value="" class="bolder">-- This Season (A) --</option>
                        <option value="<?php the_permalink();?>?tw=T17">top 3 Clean Sheets</option>
                        <option value="<?php the_permalink();?>?tw=T18">top 3 Failed to score</option>
                        <option value="<?php the_permalink();?>?tw=T19">top 3 Goals for</option>
                        <option value="<?php the_permalink();?>?tw=T20">top 3 Against</option>
                        <option value="<?php the_permalink();?>?tw=T29">top 3 BTTS</option>

                        <option value="" class="bolder">-- All time (A) --</option>
                        <option value="<?php the_permalink();?>?tw=T21">top 3 Clean Sheets</option>
                        <option value="<?php the_permalink();?>?tw=T22">top 3 Failed to score</option>
                        <option value="<?php the_permalink();?>?tw=T23">top 3 Goals for</option>
                        <option value="<?php the_permalink();?>?tw=T24">top 3 Against</option>
                        <option value="<?php the_permalink();?>?tw=T30">top 3 BTTS</option>
                        </select>
                    </div>
                </span>
            </div>
                <?php print $go->getSubmit(); ?>
        </form>
        </div>
    </div>
<?php } ?>
    </div>
    <?php get_template_part('sidebar');?>
    </div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
    <?php endif; ?>
    <?php get_footer(); ?>
