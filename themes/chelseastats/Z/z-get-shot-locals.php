<?php /* Template Name: # Z ** ShotLocals */ ?>
<?php get_header();?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
    <div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?></h4>
<?php

    error_reporting(E_ALL ^ E_NOTICE);
    ini_set('user_agent', 'Mozilla/5.0');
    ini_set('xdebug.var_display_max_depth', 100000);
    ini_set('xdebug.var_display_max_children', 512000);
    ini_set('xdebug.var_display_max_data', 10240000);

    // use curl to load the html
    /******************************************************************************/

    function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
        curl_setopt($ch, CURLOPT_URL, $url);

        $raw = curl_exec($ch);
        curl_close($ch);

        return $raw;
    }

    function _debug($title,$var) {

        print '<pre>';
        print '<h4>'.$title.'</h4>';
        print_r($var);
        print '</pre>';

    }

    function _stato($url, $location, $league, $year, $match, $team, $oppo, $grouping)  {

        $raw=file_get_contents_curl($url) or die('could not select');
        // $newlines=array("\t","\n","\r","\x20\x20","\0","\x0B","<br/>","<p>","</p>","<br>");
        // $content=str_replace($newlines, "", html_entity_decode($raw));

        // here is the start and finish points we don't care about the stuff either side
        $start=strpos($raw,'<h2>Shots - All attempts</h2>');
        $end = strpos($raw,'</svg>');

        $table = substr($raw,$start,$end-$start);

        // oh but wait there is loads of junk here we can strip out too
        $table = str_replace('<svg',"\n",$table);

        $table = str_replace('<img',"\n",$table);

        $table = str_replace('<defs>'," ",$table);
        $table = str_replace('</def>'," ",$table);

        $table = str_replace('/><line class="pitch-object',"\n",$table);
        $table = str_replace('marker-end="url(#smallblue)"','',$table);
        $table = str_replace('style="stroke:blue;stroke-width:3"','',$table);
        $table = str_replace('style="stroke:red;stroke-width:3"','',$table);
        $table = str_replace('marker-end="url(#smallred)"','',$table);
        $table = str_replace('marker-end="url(#smalldeepskyblue)"','',$table);
        $table = str_replace('style="stroke:deepskyblue;stroke-width:3"','',$table);
        $table = str_replace('<image x="0" y="0" width="760" height="529" xlink:href="/sites/fourfourtwo.com/modules/custom/statzone/files/statszone_football_pitch.png"','',$table);
        $table = str_replace('<','',$table);
        $table = str_replace('>','',$table);
        $table = str_replace('style="stroke:yellow;stroke-width:3"','',$table);

        $start =  'xlink:href="/sites/fourfourtwo.com/modules/custom/statzone/files/statszone_football_pitch_shot.png"';

        $table = explode($start,$table);

        $table = $table['1'];

        $table = str_replace('marker-start="url(#'," ",$table);
        $table = str_replace('marker-end="url(#bigyellow)"'," ",$table);
        $table = str_replace('marker-end="url(#bigred)"'," ",$table);
        $table = str_replace('marker-end="url(#bigblue)"'," ",$table);
        $table = str_replace('marker-end="url(#bigdarkgrey)"'," ",$table);
        $table = str_replace(')"'," ",$table);
        $table = str_replace('style="stroke:darkgrey;stroke-width:3"',"",$table);

        $table = str_replace(' x',',x',$table);
        $table = str_replace(' y',',y',$table);
        $table = str_replace('" ','"',$table);
        $table = str_replace('big',',',$table);
        $table = str_replace('end','',$table);
        $table = str_replace('"','',$table);
        $table = str_replace('-',', ',$table);
        $table = str_replace('timer','',$table);

        $table = str_replace('x1=','',$table);
        $table = str_replace('x2=','',$table);
        $table = str_replace('y1=','',$table);
        $table = str_replace('y2=','',$table);

        $table = str_replace('yellow','Goal',$table);
        $table = str_replace('blue','Save',$table);
        $table = str_replace('red','Wide',$table);
        $table = str_replace('darkgrey','Block',$table);
        $table = str_replace('   /',"\n\n",$table);
        $table = str_replace(' ,',',',$table);
        $table = str_replace('  ,',',',$table);
        $table = str_replace(', ',',',$table);
        $table = str_replace("/","",$table);
        $table = rtrim($table);

        // poop poop poop
	    $local = $location == 'H' ? $location = 'home' : $location = 'away';

        $prefix = $local.",".$league .",".$year.",".$match.",".$oppo.",".$grouping;
        $newlines=array("\t","\n","\r","\x20\x20","\0","\x0B");
        $content=str_replace($newlines, '<br/>'. $prefix, html_entity_decode($table));

	    $values ='';
        // print what is left to screen.
        // print '<pre style="font-size:0.75em;">';

	    // print "Delete from cfc_shotLocations where f_match = '$match' and f_team = '$grouping'; ".PHP_EOL;
	    $sql1 =  "Delete from cfc_shotLocations where f_match = '$match' and f_team = '$grouping'; ".PHP_EOL;

	    // print "INSERT INTO cfc_shotLocations ".PHP_EOL;
	    // print " (f_location, f_league, f_season, f_match, f_opponent, f_team, f_half, f_minute, f_shot_type,".PHP_EOL;
	    // print "  f_coordX, f_coordY, f_endX, f_endY )".PHP_EOL;
	    // print "VALUES".PHP_EOL;

	    $sql2 = "INSERT INTO cfc_shotLocations ".PHP_EOL;
	    $sql2 .= " (f_location, f_league, f_season, f_match, f_opponent, f_team, f_half, f_minute, f_shot_type,".PHP_EOL;
	    $sql2 .= "  f_coordX, f_coordY, f_endX, f_endY )".PHP_EOL;
	    $sql2 .= "VALUES".PHP_EOL;
		
		$explode = explode('<br/>',$content);



		foreach($explode as $row):
			$row = str_replace("," ,"','" , $row);
			$row = trim($row);
			$values .= "('$row'),".PHP_EOL;

		endforeach;

	    $values = str_replace("(''),","",$values);
	    $values = rtrim($values);
		$values = rtrim($values,',');
	    $values = $values .";";
	    $values = str_replace("'',","",$values);
	    // print $values;
	    $sql2 .= $values;
	   // print '</pre>';

	    $pdo = new pdodb();
	    $pdo->query($sql1);
	    $pdo->execute();
	    $id_def_1 = $pdo->rowCount();
	    print "<div class='alert alert-info'>Rows deleted from cfc_shotLocations: {$id_def_1} rows</div>";

	    $pdo->query($sql2);
		$pdo->execute();
	    $id_def_1 = $pdo->lastInsertId() .' '. $pdo->rowCount();
	    print "<div class='alert alert-info'>Rows inserted into cfc_shotLocations : {$id_def_1} rows</div>";


	    $counter = $pdo->returnCountAll('cfc_shotLocations');
	    print "<div class='alert alert-info'>Total rows in cfc_shotLocations : {$counter} rows</div>";

    }


	$location =  isset($_POST['location']) ? $_POST['location'] : $_POST['location'];
    $league =  isset($_POST['league']) ? $_POST['league'] : $_POST['league'];
    $year   =  isset($_POST['years'])   ? $_POST['years']   : $_POST['years'];
    $match  =  isset($_POST['match'])  ? $_POST['match']  : $_POST['match'];
    $team  =   isset($_POST['team'])   ? $_POST['team']   : $_POST['team'];

    $url_1 = "http://www.fourfourtwo.com/statszone/{$league}-{$year}/matches/{$match}/team-stats/{$team}/";
    $url_2 = "http://www.fourfourtwo.com/statszone/{$league}-{$year}/matches/{$match}/team-stats/8/";


if (isset($match) && isset($team) && $match !== '' && $team !== '') {

            $array = array('01');

     	 // shot type array but we only care about all of them at the moment so use 01.
	 // $array = array('01','02','03','04','05','55','56','06','07','08','09','10','11','12','13','14');

            foreach ($array as $k => $v) {
            	
                $query_1 = $url_1.'0_SHOT_'.$v.'#tabs-wrapper-anchor';
                print '<br/><b>'. $team .'</b>';
                _stato( $query_1, $location, $league, $year, $match, "8" , $team, 'opponent');
                
                $query_2 = $url_2.'0_SHOT_'.$v.'#tabs-wrapper-anchor';
                print '<br/><b>08</b>';
                _stato( $query_2, $location, $league, $year, $match, "8" , $team, 'Chelsea');
            }

} else {
?>
	<form name="form" method="POST" action="<?php the_permalink();?>">

        <div class="form-group">
            <label for="league">league Ref:</label>
            <select name="league" id="league">
                <option value="8">Premier League</option>
                <option value="23">La Liga</option>
                <option value="21">Serie A</option>
                <option value="22">Bundesliga</option>
                <option value="24">Ligue 1</option>

            </select>
        </div>

        <div class="form-group">
            <label for="years">year Ref:</label>
            <select name="years" id="years">
	            <option value="2016">2016</option>
	            <option value="2015">2015</option>
	            <option value="2014">2014</option>
                <option value="2013">2013</option>
                <option value="2012">2012</option>
                <option value="2011">2011</option>
                <option value="2010">2010</option>
                <option value="2009">2009</option>
                <option value="2008">2008</option>
                <option value="2007">2007</option>
                <option value="2006">2006</option>
                <option value="2005">2005</option>
                <option value="2004">2004</option>
            </select>
        </div>


        <div class="form-group">
		<label for="match">match ID:</label>
        <input name="match"   type="text" id="match">
        </div>
        
        <div class="form-group">
		<label for="team">Opponent Team ID:</label>
        <input name="team"   type="text" id="team">
        </div>

		<div class="form-group">
			<label for="location">Location (H/A):</label>
			<input name="location"   type="text" id="location">
		</div>
        
        <div class="form-group">
        <input type="submit" value="submit" class="btn btn-primary">
        </div>

</form>

	<br/>
	<?php
        //================================================================================
        $sql = "SELECT   f_team as Team, f_match as PLD, count(*) as F from cfc_shotLocations group by  f_team, f_match order by f_match desc";
         outputDataTable( $sql, 'ALL TIME PL');
        //================================================================================

	?>
<?php } ?>
    </div>
    <?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
