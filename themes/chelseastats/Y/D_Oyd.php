<?php
/*
Template Name: # D On Your Day
*/
?>
<?php get_header(); ?>
<div id="content">
<div id="contentleft">
<h4 class="special">On Your Day - Statistics from any given date</h4>
<?php
// get variables
$date=$_POST["date"];
$type=$_POST["type"];
$submit=$_POST["submit"];
$maxdate=date('Y-m-d');

if(isset($date) && $date!='' && $type!='' && $submit=='1') {

    $pdo = new pdodb();
    $pdo->query("SELECT
    SUM(IF(F_RESULT='W'=1,1,0)) AS W, ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS WP,
    SUM(IF(F_RESULT='D'=1,1,0)) AS D, ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS DP,
    SUM(IF(F_RESULT='L'=1,1,0)) AS L, ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2)  AS LP,
    SUM(IF(F_RESULT IS NOT NULL=1,1,0)) AS GT FROM cfc_fixtures WHERE F_DATE >=:date");
    $pdo->bind(':date',$date);
    $row = $pdo->row();
    $W	= $row["W"];
    $WP	= $row["WP"];
    $D	= $row["D"];
    $DP	= $row["DP"];
    $L	= $row["L"];
    $LP	= $row["LP"];
    $GT	= $row["GT"];

    $pdo = new pdodb();
    $pdo->query("Select ifnull(count(*),0) as M from cfc_managers where F_SDATE >= :date");
    $pdo->bind(':date',$date);
    $row = $pdo->row();
    $M   = $row["M"];

    $pdo = new pdodb();
    $pdo->query("Select ifnull(sum(F_TROPHIES),0) as T from cfc_managers where F_SDATE >= :date");
    $pdo->bind(':date',$date);
    $row = $pdo->row();
    $T   = $row["T"];

    $pdo = new pdodb();
    $pdo->query("SELECT ROUND(AVG(F_ATT),0) as A from cfc_fixtures where F_DATE >= :date");
    $pdo->bind(':date',$date);
    $row = $pdo->row();
    $A   = $row["A"];


print "<p>A great way to share your Chelsea history with your twitter followers.</p>";

switch ($type) {

	case "opt1":
	print '<div class="alert alert-success"><p>Since I was born ('.$date.') #Chelsea, have W'.$W.' ('.$WP.'%) D'. $D .' ('.$DP.'%) of '.$GT.' games in all comps<br/><small> via thechels.co.uk/day by @ChelseaChadder</small></p></div>';
	
	print '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://thechels.co.uk/day" data-text="Since I was born ('.$date.') #Chelsea, have W'.$W.' ('.$WP.'%) D'. $D .' ('.$DP.'%) of '.$GT.' games in all comps" data-via="ChelseaChadder" data-size="large" data-related="ChelseaStats" data-count="none">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> <br/><hr/><br/>';
	
	print '<div class="alert alert-success"><p>Since I was born ('.$date.') #Chelsea, have averaged a gate of '.$A.' per home game in all competitions<br/><small> via thechels.co.uk/day by @ChelseaChadder</small></p></div>';
	
	print '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://thechels.co.uk/day" data-text="Since I was born ('.$date.') #Chelsea, have averaged a gate of '.$A.' per home game in all competitions" data-via="ChelseaChadder" data-size="large" data-related="ChelseaStats" data-count="none">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> <br/><hr/><br/>';
	
	print '<div class="alert alert-success"><p>Since I was born ('.$date.') #Chelsea, have had '.$M.' managers and have won '.$T.' trophies<br/><small> via thechels.co.uk/day by @ChelseaChadder</small></p></div>';
	
	print '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://thechels.co.uk/day" data-text="Since I was born ('.$date.') #Chelsea, have had '.$M.' managers and have won '.$T.' trophies" data-via="ChelseaChadder" data-size="large" data-related="ChelseaStats" data-count="none">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> <br/><hr/><br/>';
	print '<a href="/day">Try again?</a>';
	break;
	
	
	case "opt2":
	print '<div class="alert alert-success"><p>Since I started supporting ('.$date.') #Chelsea, have W'.$W.' ('.$WP.'%) D'. $D .' ('.$DP.'%) of '.$GT.' games in all comps<br/><small> via thechels.co.uk/day by @ChelseaChadder</small></p></div>';
	
	print '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://thechels.co.uk/day" data-text="Since I started supporting ('.$date.') #Chelsea, have W'.$W.' ('.$WP.'%) D'. $D .' ('.$DP.'%) of '.$GT.' games in all comps" data-via="ChelseaChadder" data-size="large" data-related="ChelseaStats" data-count="none">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> <br/><hr/><br/>';
	
	print '<div class="alert alert-success"><p>Since I started supporting ('.$date.') #Chelsea, have averaged a gate of '.$A.' per home game in all competitions<br/><small> via thechels.co.uk/day by @ChelseaChadder</small></p></div>';
	
	print '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://thechels.co.uk/day" data-text="Since I started supporting ('.$date.') #Chelsea, have averaged a gate of '.$A.' per home game in all competitions" data-via="ChelseaChadder" data-size="large" data-related="ChelseaStats" data-count="none">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> <br/><hr/><br/>';
	
	print '<div class="alert alert-success"><p>Since I started supporting ('.$date.') #Chelsea, have had '.$M.' managers and have won '.$T.' trophies<br/><small> via thechels.co.uk/day by @ChelseaChadder</small></p></div>';
	
	print '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://thechels.co.uk/day" data-text="Since I started supporting ('.$date.') #Chelsea, have had '.$M.' managers and have won '.$T.' trophies" data-via="ChelseaChadder" data-size="large" data-related="ChelseaStats" data-count="none">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> <br/><hr/><br/>';
	print '<a href="/day">Try again?</a>';
	break;
	
	case "opt3":
	
	print '<div class="alert alert-success"><p>Since '.$date.', #Chelsea have W'.$W.' ('.$WP.'%) D'. $D .' ('.$DP.'%) of '.$GT.' games in all comps<br/><small> via thechels.co.uk/day by @ChelseaChadder</small></p></div>';
	
	print '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://thechels.co.uk/day"  data-text="Since '.$date.', #Chelsea have W'.$W.' ('.$WP.'%) D'. $D .' ('.$DP.'%) of '.$GT.' games in all comps" data-via="ChelseaChadder" data-size="large" data-related="ChelseaStats" data-count="none">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> <br/><hr/><br/>';
	
	print '<div class="alert alert-success"><p>Since '.$date.', #Chelsea have averaged a gate of '.$A.' per home game in all competitions
	<br/><small> via thechels.co.uk/day by @ChelseaChadder</small></p></div>';
	
	print '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://thechels.co.uk/day"  data-text="Since '.$date.', #Chelsea have averaged a gate of '.$A.' per home game in all competitions" data-via="ChelseaChadder" data-size="large" data-related="ChelseaStats" data-count="none">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> <br/><hr/><br/>';
	
	print '<div class="alert alert-success"><p>Since '.$date.', #Chelsea have had '.$M.' managers and have won '.$T.' trophies
	<br/><small> via thechels.co.uk/day by @ChelseaChadder</small></p></div>';
	
	print '<a href="https://twitter.com/share" class="twitter-share-button" data-url="https://thechels.co.uk/day" data-text="Since '.$date.', #Chelsea have had '.$M.' managers and have won '.$T.' trophies" data-via="ChelseaChadder" data-size="large" data-related="ChelseaStats" data-count="none">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> <br/><hr/><br/>';
	
	print '<a href="/day" class="btn" value="Try Again?">Try again?</a>';
	
	print '<br/><br/>';
	break;
	
	}

}  else { 
?>
<p>Pick a date and the type of query to find out about your history</p>

<form action="<?php echo $SERVER['PHP_SELF']; ?>" Method="POST">
	<fieldset>
	<p><b>1: Select a date:</b></p>
	<input id="date" name="date" style="width:250px; height:30px;" type="date" min="1905-03-10" max="<?php echo $maxdate; ?>" placeholder="insert date YYYY-MM-DD">
		<br/>	<br/>
	<p><b>2: Choose an option:</b></p>
	<label for="opt1"><input type="radio" name="type" id="opt1" value="opt1" /> 
	Date of Birth</label><div style="clear:both;"></div>
	<label for="opt2"><input type="radio" name="type" id="opt2" value="opt2" /> 
	Supported from</label><div style="clear:both;"></div>
	<label for="opt3"><input type="radio" name="type" id="opt3" value="opt3" /> 
	Other</label><div style="clear:both;"></div>
		<br/>	<br/>
		
	<p><b>3: go!</b></p>
	<button id="submit" name="submit" value="1" class="btn btn-primary" type="submit">Submit</button>
	
	</fieldset>
</form>
<p>Common examples:</p>
<ul>
<li>Your date of birth</li>
<li>Date of first started supporting</li>
<li>Date of first game</li>
<li>A year or 2, 5, or 10 years a go</li>
<li>Since manager started</li>
</ul>
<?php } ?>
</div>
<?php get_template_part('sidebar');?>
</div>
<!-- The main column ends  -->
<?php get_footer(); ?>
