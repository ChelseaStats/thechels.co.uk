<?php
	/*  Template Name: # XML feed Cann */
	header('Content-Type: text/xml; charset=utf-8');
	$rss        = new utility();
	$url 		= "http://thechels.co.uk/rss-feeds/";
	$feed		= "Cann Table by ChelseaStats";
	$desc		= "Cann Table";
	$title_this = "Cann Table ({$rss->getSeasonalDate(date('Y-m-d'))})";
	$title_all  = "Cann Table";
	$type       = "cann";

	$query_key  = "SELECT F_DATE as D, F_HOME as H, F_AWAY as A FROM all_results ORDER BY F_DATE DESC LIMIT 1";

	$query_all  = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
			      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
			      FROM 0V_base_PL_this
			      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";

	$raw        = returnDataTable( $query_all, 'OVERALL');

	$query_results  = "SELECT F_DATE as D, F_HOME as H_TEAM, F_HGOALS as HG, F_AGOALS as AG, F_AWAY as A_TEAM
 		   FROM all_results ORDER BY F_DATE DESC LIMIT 10";


	$rss->doRSS($url, $feed, $desc, $title_this, $title_all, $query_key, $query_this='', $query_all, $query_results, $type, $raw);
