<?php
	/*  Template Name: # XML feed History */
	header('Content-Type: text/xml; charset=utf-8');

	$url 		 = "http://thechels.co.uk/rss-feeds/";
	$feed		 = "History Checker by ChelseaStats";
	$desc		 = "On This Day History Checker";
	$title_this  = "History Checker";
	$title_all   = "History Checker";
	$type        = "history";

	$query_key = "SELECT F_DATE as D, Month(F_DATE) as H, Day(F_DATE) as A FROM cfc_dates WHERE month(now()) = month(F_DATE) and  day(now()) = day(F_DATE) order by F_DATE DESC";

	$query_all = "SELECT F_DATE, F_NAME, F_NOTES FROM cfc_dates WHERE (
 		    DAYOFYEAR(now())   = DAYOFYEAR(F_DATE) or DAYOFYEAR(now())+1 = DAYOFYEAR(F_DATE) or 
 		    DAYOFYEAR(now())+2 = DAYOFYEAR(F_DATE) or  DAYOFYEAR(now())+3 = DAYOFYEAR(F_DATE)
			) order by day(F_DATE) asc, month(F_DATE) asc";

	$query_results  = "SELECT F_DATE as D, F_HOME as H_TEAM, F_HGOALS as HG, F_AGOALS as AG, F_AWAY as A_TEAM
 		   FROM all_results ORDER BY F_DATE DESC LIMIT 10";

	$rss = new utility();
	$rss->doRSS($url, $feed, $desc, $title_this, $title_all, $query_key, $query_this='', $query_all, $query_results, $type);
