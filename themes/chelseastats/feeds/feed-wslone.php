<?php /*  Template Name: # XML feed one */
	header('Content-Type: text/xml; charset=utf-8');
	$rss            = new utility();
	$thisYear       = date('Y-m-d');
	$url 		    = "http://thechels.co.uk/rss-feeds/";
	$feed		    = "FAWSL 1 by ChelseaStats";
	$desc		    = "The FAWSL 1 results and tables";
	$title_this     = "FA WSL 1 Table ({$thisYear})";
	$title_all  	= "All Time FA WSL 1 Table";
	$type           = "wslone";

	$query_key      = "SELECT F_DATE as D, F_HOME as H, F_AWAY as A
						FROM all_results_wsl_one ORDER BY F_DATE DESC LIMIT 1";

	$query_this     = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
				   		FROM 0V_base_WSL1_this GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";

	$query_all      = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
				   		FROM 0V_base_WSL1 GROUP BY Team ORDER BY PTS DESC, GD DESC, PPG DESC, Team DESC";

	$query_results  = "SELECT F_DATE as D, F_HOME as H_TEAM, F_HGOALS as HG, F_AGOALS as AG, F_AWAY as A_TEAM
			 		  	FROM all_results_wsl_one ORDER BY F_DATE DESC LIMIT 10";

	$rss->doRSS($url, $feed, $desc, $title_this, $title_all, $query_key, $query_this, $query_all, $query_results, $type);
