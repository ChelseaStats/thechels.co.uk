<?php /* Template Name:  # Z Private home */ ?>
<?php get_header(); ?>
<?php if (current_user_can('level_10')) : ?>
<div id="content">
<div id="contentleft">
        <?php print $go->goAdminMenu(); ?>
        <h4 class="special"> <?php the_title(); ?> Audit</h4>

	<div style="padding: 0 5px;">

	    <?php

			$today = new DateTime("now");
	    	$pdo   = new pdodb();

		    $pdo->query("select max(F_DATE) as DateVar from all_results_wsl_one");
			$row=$pdo->row();
		    $date_var = new DateTime($date_var = $row['DateVar']);
		    $interval = $date_var->diff($today);
		    if($interval->days > 6) {
			    print '<div class="alert alert-warning">WSL results table has not been updated in: '.$interval->days.' days</div>';
		    }

		    $pdo->query("select max(F_DATE) as DateVar from all_results_wsl_two");
		    $row=$pdo->row();
		    $date_var = new DateTime($date_var = $row['DateVar']);
		    $interval = $date_var->diff($today);
		    if($interval->days > 6) {
			    print '<div class="alert alert-warning">WSL 2 results table has not been updated in: '.$interval->days.' days</div>';
		    }

		    $pdo->query("select max(F_DATE) as DateVar from all_results_wdl_north");
		    $row=$pdo->row();
		    $date_var = new DateTime($date_var = $row['DateVar']);
		    $interval = $date_var->diff($today);
		    if($interval->days > 6) {
			    print '<div class="alert alert-warning">WDL North results table has not been updated in: '.$interval->days.' days</div>';
		    }

		    $pdo->query("select max(F_DATE) as DateVar from all_results_wdl_south");
		    $row=$pdo->row();
		    $date_var = new DateTime($date_var = $row['DateVar']);
		    $interval = $date_var->diff($today);
		    if($interval->days > 6) {
			    print '<div class="alert alert-warning">WDL South results table has not been updated in: '.$interval->days.' days</div>';
		    }

		    $pdo->query("select max(F_DATE) as DateVar from all_results");
		    $row=$pdo->row();
		    $date_var = new DateTime($date_var = $row['DateVar']);
		    $interval = $date_var->diff($today);
		    if($interval->days > 4) {
			    print '<div class="alert alert-warning">EPL results table has not been updated in: '.$interval->days.' days</div>';
		    }

		    $pdo->query("select max(F_DATE) as DateVar from o_appstats");
		    $row=$pdo->row();
		    $date_var = new DateTime($date_var = $row['DateVar']);
		    $interval = $date_var->diff($today);
		    if($interval->days > 3) {
			    print '<div class="alert alert-warning">APP table has not been updated in: '.$interval->days.' days</div>';
		    }

		    $pdo->query("select max(F_DATE) as DateVar from cfc_dates");
		    $row=$pdo->row();
		    $date_var = new DateTime($date_var = $row['DateVar']);
		    $interval = $date_var->diff($today);
		    if($interval->days > 5) {
			    print '<div class="alert alert-warning">On This Day table has not been updated in: '.$interval->days.' days</div>';
		    }


		    $pdo->query("select distinct(concat(F_HOME,',',F_AWAY)) as Result from o_tempFootballData201516 
						 where F_DATE > (select F_DATE from 000_config where F_LEAGUE = 'PL')
						 and (concat(F_HOME,',',F_AWAY)) not in (select distinct(concat(F_HOME,',',F_AWAY)) as Result 
						 from all_results where F_DATE > (select F_DATE from 000_config where F_LEAGUE = 'PL'))");
		    $rows = $pdo->rows();
		    if(!empty($rows)) {
			    foreach ( $rows as $row ) {
				    $teams = explode( ',', $row['Result'] );
				    $teams = $teams['0'] . ' v ' . $teams['1'];
				    print '<div class="alert alert-warning">' . $teams . ' has not been updated in EPL table</div>';
			    }
		    }
	    ?>

        <h3>Men Inserts</h3>

            <ul>
                <li>
	                <a href="/a/i-config/"> Season Config</a>
	                | <a href="/a/i-progress-configs/"> Progress Config</a>
	                | <a href="/a//i-squadno/"> Squadno</a>
                    | <a href="/a/i-insert-app/"> APP</a>
                    | <a href="/a/i-insert-coeff/"> Coeff</a>

                </li>
	            <li>
		              <a href="/a/i-insert-date/"> Date</a>
	                | <a href="/a/i-insert-epl/"> EPL</a>
	                | <a href="/a/i-insert-fun/"> Fun</a>
                    | <a href="/a/i-insert-dob/"> DOB</a>
	            </li>
	            <li>
	                  <a href="/a/i-insert-since/"> Since</a>
	                | <a href="/a/i-insert-finance/"> Finance</a>
	                | <a href="/a/i-insert-cabinet/">Trophies</a>
	                | <a href="/a//z-match-events-m/">Events</a>
                </li>
                <li>
                      <a href="/a/z-match-inserter-m/">Match Insert</a>
                    | <a href="/a/z-get-stato-m/">Get Stats Data</a>
	                | <a href="/a/i-insert-keeper/">CS keeper</a>
	                | <a href="/a/i-insert-cleansheets/">Clean Sheets</a>

                </li>
            </ul>
		<h3>Processors</h3>
			<ul>
                <li>
	                  <a href="/a/z-updater-minutes/"> Minutes</a>
	                | <a href="/a/z-get-stato-shots/"> Shot Locations</a>
	                | <a href="/a/z-get-football-data/"> Football Data</a>
	                | <a href="/a/z-gen-shots-flow/"> Shots Flow</a>
	                | <a href="/a/z-gen-flot/"> Flot Graphics</a>
                </li>
            </ul>

		<h3>Generators</h3>
		    <ul>
                <li>
	                  <a href="/a/gen-cfc-drafter/"> CFC Drafts</a>
	                | <a href="/a/gen-wsl-drafter/"> WSL Drafts</a>
	                | <a href="/a/gen-tbl-drafter/"> TBL Drafts</a>
	            </li>
			    <li>
				      <a href="/a/gen-checklist/"> Generate Checklist</a>
				    | <a href="/a/z-cann-table/"> Cann Table</a>
				    | <a href="/statistics/"> Stats Report</a>
				    | <a href="/a/matching-players/">Matching Players</a>
				    | <a href="/a/z-view-schema/"> Schema</a>
			    </li>
			    <li>
	                  <a href="/a/z-dailypost/"> Daily</a>
	                | <a href="/a/z-weekly/"> Weekly</a>
				    | <a href="/a/z-otd/"> OnThisDay</a>
				    | <a href="/a/z-preview/"> Preview</a>
				</li>

            </ul>

        <h3>Women Inserts</h3>

            <ul class="tml-user-links" style="list-style-type:square;">
                <li>
	                  <a href="/a/z-match-inserter-f/"> Match Insert</a>
                    | <a href="/a/z-match-events-f/"> Match Events</a>
	                | <a href="/a/z-get-stato-f/"> Stats Data</a>
                </li>

            </ul>

        <h3>Other Things</h3>

        <ul class="tml-user-links" style="list-style-type:square;">
            <li>
                  <a href="/a/o-films/"> Films</a>
                | <a href="/a/o-teams/"> Teams</a>
                | <a href="/a/o-mac/"> Mac</a>
                | <a href="/a/o-ios/"> iOS</a>
	            | <a href="/a/o-salary/"> Salary</a>
	            | <a href="/a/o-company/"> Company i/e</a>

            </li>

        </ul>


        <h3>Admin</h3>

            <ul class="tml-user-links" style="list-style-type:square;">
                <li>
                      <a href="//dev.io">dev.io</a>
                    | <a href="//thechels.co.uk">TheChels</a>
                    | <a href="//thechels.co.uk/wp-admin">Post</a>
	                | <a href="/wp-admin/">Dashboard</a>
	                | <a href="/log-out/">Log Out</a>
                </li>  
                
                <li>                   
                      <a href="//cpanel.thechels.co.uk/">Cpanel  CFC</a>
                    | <a href="//chelseasupporterstrust.com/">Cpanel  CST</a>
	                | <a href="http://www.thechels.uk">www</a>
                    | <a href="https://m.thechels.uk/">Muk</a>
                </li>
                
                <li>
                      <a href="//espnfc.com/team/fixtures?id=363&cc=5739">Espn</a>
                    | <a href="http://full-time.thefa.com/Index.do?divisionseason=248057289">WDL N</a>
	                | <a href="http://full-time.thefa.com/Index.do?divisionseason=193927709">WDL S</a>
	                | <a href="http://www.futbol24.com/national/England/Womens-Super-League-1/2015/results/#statLR-Page=0">WSL 1</a>
	                | <a href="http://www.futbol24.com/national/England/Womens-Super-League-2/2015/results/#statLR-Page=0">WSL 2</a>
                </li>
                
		<li>
		      <a href="//fawslstats.tumblr.com">Tumblr</a>
                    | <a href="//github.com/ChelseaStats">Github</a>
                    | <a href="//www.cloudflare.com/my-websites">CloudFare</a>
                    | <a href="//tools.pingdom.com/fpt/#!/mvNZ9XNIb/https://thechels.co.uk">Pingdom</a>
                    | <a href="//bitly.com/">Bit.ly</a>
                    | <a href="//ifttt.com/dashboard">IFTTT</a>
                </li>
                
                <li>
                      <a href="//en.gravatar.com/site/login">Gravatar</a>
                    | <a href="//developers.google.com/speed/pagespeed/insights">PageSpeed</a>
                    | <a href="//gtmetrix.com/">GT Metrix</a>
                    | <a href="//analytics.twitter.com/user/ChelseaStats/tweets">Twitalyics</a>
                </li>
                
                <li>
                      <a href="//kdp.amazon.com/">Kindle</a>
                    | <a href="//sellercentral.amazon.co.uk/">Seller</a>
                    | <a href="//affiliate-program.amazon.co.uk/">Affiliate</a>
                    | <a href="//amzn.to/Chelseastats">Amzn</a>
                    | <a href="//www.gumroad.com/ChelseaStats">Gum</a>
                    | <a href="//www.redbubble.com/account/sales/by_work">Redbubble</a>
				</li>
		
                <li>
                      <a href="castro://export">Castro</a>	
                    | <a href="//my.cloudabove.com">SwB</a>
                    | <a href="//secure.nominet.org.uk/auth/login.html">Nominet</a>
                    | <a href="//profiles.wordpress.org/chelseastats">WP.org</a>
                    | <a href="//wck2.companieshouse.gov.uk/93c363217ff93d00c50862f2860309c7/compdetails">Ltd</a>

                </li>
            </ul>

		<h3>Sponsorship strings</h3>

		<div class="alert alert-warning">Get all the latest Chelsea gear on <a href="http://u.thechels.uk/cfc-amazon">Amazon</a></div>

		<div class="alert alert-warning">Offering some of the best website hosting packages and prices around. <a href="http://webstash.uk">Get 10% off your order when you use code: THECHELS</a>.</div>

		<div class="alert alert-warning">Curated Chelsea FC statistics - get our mobile web app <a href="https://m.thechels.uk">m.thechels.uk</a></div>

		<div class="alert alert-warning">Article and Data based RSS feeds - <a href="https://thechels.co.uk/rss-feeds/">available for free</a>.</div>

		<div class="alert alert-warning">Stand out with business cards, stickers and posters with 10% off at <a href="https://www.moo.com/share/276h2k">Moo.com</a></div>

		<div class="alert alert-warning">Your company message here - <a href="https://thechels.co.uk/sponsorship/">Sponsorships available now</a></div>

		<div class="alert alert-warning">Sign up to Dropbox - for at least 2GB of free cloud storage and <a href="https://db.tt/ocJGgY5">get 500mb extra for free</a></div>


	</div>
	<h3>Current Squad</h3>
	<?php
		//================================================================================
		$sql = "SELECT F_SQUADNO, F_NAME as N_LINK_NAME FROM meta_squadno WHERE F_END IS NULL ORDER BY F_SQUADNO ASC LIMIT 30";
		outputDataTable( $sql, 'small');
		//================================================================================
	?>
 	<h3>Last 10 app stats</h3>
	<?php
		//================================================================================
		$sql = "SELECT F_DATE as N_DATE, F_TEXT as F_NOTES FROM o_appstats ORDER BY F_ID DESC LIMIT 10";
		outputDataTable( $sql, 'small');
		//================================================================================
	?>
	<h3>Last 10 dates</h3>
	<?php
	    //================================================================================
        $sql = "SELECT F_DATE as N_DATE, F_NAME as N_LINK_NAME, F_NOTES FROM cfc_dates ORDER BY F_DATE DESC LIMIT 10";
        outputDataTable( $sql, 'small');
	    //================================================================================
	?>
	<h3>Last 10 Premier League Results</h3>
	<?php
		//================================================================================
		$sql="SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results WHERE
		      F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') ORDER BY F_ID DESC LIMIT 10";
		outputDataTable( $sql, 'small');
		//================================================================================ 
	?>
<div class="clearfix"><p>&nbsp;</p></div>
</div>
<?php get_template_part('sidebar');?>
</div>
    <div class="clearfix"><p>&nbsp;</p></div>
    <!-- The main column ends  -->
<?php endif; ?>
<?php get_footer(); ?>
