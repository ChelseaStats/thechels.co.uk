<?php /*  Template Name: # XML feed EPL */
	header('Content-Type: text/xml; charset=utf-8');
	$rss            = new utility();
	$url 		    = "http://thechels.co.uk/rss-feeds/";
	$feed		    = "The Progress League by ChelseaStats";
	$desc		    = "The Progress League results and tables";
	$title_this 	= "The Progress League Table ({$rss->getSeasonalDate(date('Y-m-d'))})";
	$type           = "progress";

	$query_key      = "SELECT F_DATE as D, F_HOME as H, F_AWAY as A FROM all_results ORDER BY F_DATE DESC LIMIT 1";

	$query_all      = "select a.Team as N_NAME, a.PTS-b.PTS as PTS from 0V_base_ISG_totals a, 0V_base_ISG_totals b where a.Team = b.Team 
			   and a.Label = (select y.F_LABEL from meta_seasons y, 000_config z where y.F_SDATE = z.F_DATE and z.F_LEAGUE = 'PL')
			   and b.Label = (select y.F_LABEL from meta_seasons y, 000_config z where y.F_SDATE = z.F_DATE and z.F_LEAGUE = 'PLm1')
			   group by a.Team order by PTS desc";

	$query_results  = "SELECT F_DATE as D, F_HOME as H_TEAM, F_HGOALS as HG, F_AGOALS as AG, F_AWAY as A_TEAM 
			   FROM all_results ORDER BY F_DATE DESC LIMIT 10";

	$rss->doRSS($url, $feed, $desc, $title_this, $title_all, $query_key, $query_this='', $query_all, $query_results, $type);