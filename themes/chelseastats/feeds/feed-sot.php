<?php /*  Template Name: # XML feed Shotd */
	header('Content-Type: text/xml; charset=utf-8');
	$rss            = new utility();
	$url 		    = "http://thechels.co.uk/rss-feeds/";
	$feed		    = "Premier League Shots on Target by ChelseaStats";
	$desc		    = "Premier League Shots on Target results and tables";
	$title_all 	= "Premier League Shots on Target Table ({$rss->getSeasonalDate(date('Y-m-d'))})";
	$title_this	    = "Premier League Shots on Target Table";
	$type           = "sot";

	$query_key      = "SELECT F_DATE as D, F_HOME as H, F_AWAY as A FROM o_tempFootballData201617
						ORDER BY F_DATE DESC LIMIT 1";

	$query_all     = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
				   		FROM 0V_base_Shots_on_this GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";

	$query_results  = "SELECT F_DATE as D, F_HOME as H_TEAM, H_SOT as HG, A_SOT as AG, F_AWAY as A_TEAM
			 		  	FROM o_tempFootballData201617 ORDER BY F_DATE DESC LIMIT 10";


	$rss->doRSS($url, $feed, $desc, $title_this, $title_all, $query_key, $query_this='', $query_all, $query_results, $type);