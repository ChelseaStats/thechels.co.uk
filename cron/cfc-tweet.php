<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	$message = '';
	$tweet = rand( 1, 38 ); // pick a random number and then tweet it
	switch ( $tweet ) {
		case 1: // REF
			$message = "#Stats Results archive by referees, including W/D/L % Choose their name from the table or drop down list http://thechels.uk/chelsREF  #chelsea #cfc";
			break;
		case 2: // RES FREQ
			$message = "#Stats Results frequency overall and against opposition - most common scorelines between sides http://thechels.uk/chelsRF #chelsea #cfc";
			break;
		case 3: // WWWWWWS
			$message = "#Stats Where were we when we were shit - a look at 10 random games from our past. http://thechels.uk/wwwwwws #chelsea #cfc";
			break;
		case 4: // LADIES
			$message = "#Stats Check out http://thechels.uk/CLFCanalysis  for up to date stats on #chelseaLadies #oneclub";
			break;
		case 5: // MEN
			$message = "#Stats Check out http://thechels.uk/CFCanalysis  for up to date stats #chelsea #cfc";
			break;
		case 6: // Last Meeting
			$message = "#Stats When was the last time we played them? http://thechels.uk/CFClastly including last win/loss/draw #chelsea #cfc";
			break;
		case 7: // League Positions
			$message = "#Stats Check out http://thechels.uk/CFCpos for yearly performance, league positions and attendances #chelsea #cfc";
			break;
		case 8: // Month by Month
			$message = "#Stats Check out http://thechels.uk/CFCmbym for month by month performance #chelsea #cfc";
			break;
		case 9: // Day by Day
			$message = "#Stats Check out http://thechels.uk/CFCdaybyday for day by day performance #chelsea #cfc";
			break;
		case 10: // Form Guide
			$message = "#Stats Check out http://thechels.uk/CFCformguide for latest #Chelsea form guide, last 6 and 38 games to all-time premier league, Roman era and all time #cfc";
			break;
		case 11: // MGR
			$message = "#Stats Check out http://thechels.uk/CFCmgrs for up to date stats on our managers, see their performance, win percentages and compare #cfc";
			break;
		case 12: // OPPOSITION RANK
			$message = "#Stats Check out http://thechels.uk/CFC_Orank for all opposition ranked by points, win/loss % and goals +/- against #Chelsea #cfc";
			break;
		case 13: // OPPOSITION MGR
			$message = "#Stats Check out http://thechels.uk/OppoMGR for all opposition managers ranked by points, W/D/L & %s against #Chelsea #cfc";
			break;
		case 14: // OPPO PL RANK
			$message = "#Stats Check out http://thechels.uk/PLvsCFC for team's all time Premier League record vs #Chelsea #CFC #PL";
			break;
		case 15: // finance
			$message = "#Stats Check out http://thechels.uk/CFC_financials to get up to date key financial stats for Chelsea FC Limited and the PLC. #Chelsea #cfc";
			break;
		case 16: // This Week
			$message = "#Stats Check out what's been published on the website in the last 7 days https://thechels.co.uk/this-week/ #CFC #ChelseaStats";
			break;
		case 17: // COUNTRY
			$message = "#Stats Check out https://thechels.co.uk/country/ for our performance against our opposition's country #Chelsea #cfc";
			break;
		case 18: // ATPL
			$message = "#Stats All Time Premier League Table - http://thechels.uk/cfcATPL #CFC #Chelsea";
			break;
		case 19: // TPLT
			$message = "#Stats Current Premier League Table - http://thechels.uk/PLtable #CFC #Chelsea";
			break;
		case 20: // L38
			$message = "#Stats The Last 38 League Table - http://thechels.uk/Last38 #CFC #Chelsea";
			break;
		case 21: // LDN
			$message = "#Stats The London League (this season and all time #PL) #LDN - http://thechels.uk/CFC-LDN #CFC #Chelsea";
			break;
		case 22: // Ever7
			$message = "#Stats #ever6 micro league - the 6 ever present teams in the in the PL - http://thechels.uk/ever6league #CFC #Chelsea";
			break;
		case 23: // Big 7
			$message = "#Stats #big7 micro league - the 7 big PL teams - http://thechels.uk/big7league #CFC #Chelsea";
			break;
		case 24: // Data
			$message = "#Stats Various data tables, leagues and analysis - http://thechels.uk/CFCdata #CFC #Chelsea";
			break;
		case 25: // mgr
			$message = "#Stats The league table if it had started when current manager was appointed - http://thechels.uk/CFCmgr #CFC #Chelsea";
			break;
		case 26: // uefa
			$message = "#Stats history of our UEFA coefficients - http://thechels.uk/cfccoeff #CFC #Chelsea";
			break;
		case 27: // mobile 1
			$message = "#Stats Check out http://m.thechels.uk on your iPhones, iPads, BBs and Androids for easy to view data, regularly updated #Mobile #Chelsea #cfc";
			break;
		case 28: // mobile 2
			$message = "#Stats Check out http://m.thechels.uk on your iPhones, iPads, BBs and Androids for easy to view data, regularly updated #Mobile #Chelsea #cfc";
			break;
		case 29: // RSS
			$message = "#Stats Check out http://thechels.co.uk/rss-feeds/ for the #big7 #last38 #epl #wsl #wdl results & tables as well as our main #RSS feed. #Chelsea #Cfc";
			break;
		case 30: // Redbubble
			$message = "#Stats Check us out on RedBubble? http://www.redbubble.com/people/chelseastats";
			break;
		case 31: // api
			$message = "A free data api https://api.thechels.uk/ #json #data #Chelsea #cfc";
			break;
		case 32: // support
			$message = "#Stats Check out https://thechels.co.uk/support for ways to help us";
			break;
		case 33: // women
			$message = "Check out https://thechels.co.uk/women for quick access to all our #WoSo tables";
			break;
		case 34: // fawslstats
			$message = "Check out and follow @fawslStats for #FAWSL #WSL1 #WSL2 #WDLNorth #WDLSouth Stats #Woso";
			break;
		case 35: // 19thMayBot
			$message = "Check out and follow @19thMayBot for annual 'live' tweeting of that night in Munich ( open source : https://github.com/ChelseaStats/19thMayBot )";
			break;
		case 36: // ChelseaPuzzles
			$message = "Check out and follow @ChelseaPuzzles for word games";
			break;
		case 37: // HoroFootball
			$message = "Check out and follow @HoroFootball for daily football horoscopes  ( open source : https://github.com/ChelseaStats/football-horoscopes )";
			break;
		case 38: // Social Media
			$message = "Follow ChelseaStats on Social media https://www.thechels.uk/";
			break;
	}

	$melinda->goTweet( $message , 'App' );
	$melinda->goTelegram("<b>Links:</b> {$message}");
	exit();