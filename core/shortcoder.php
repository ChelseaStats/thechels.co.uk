<?php
	/*
	Plugin Name: CFC ShortCodes
	Description: A few handy shortcodes
	Version: 11.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	// to remove individual
	// function remove_shortcode('shortcodeID')
	*/

	defined( 'ABSPATH' ) or die();
	
	class shortcoder {
		
		/** shortcoder constructor */
		function __construct() {
			
				add_shortcode('fancystats'	    , array($this, 'fancy_func' ));
				add_shortcode('prod'		    , array($this, 'prod_func' ));
				add_shortcode('charts'		    , array($this, 'charts_func' ));
				add_shortcode('shotsleague'	    , array($this, 'shotsleague_func' ));
				add_shortcode('shotsonleague'   , array($this, 'shotsonleague_func' ));
				add_shortcode('procfc'		    , array($this, 'progresscfc_func' ));
				add_shortcode('progress'	    , array($this, 'progress_func' ));
				add_shortcode('progress_wsl'    , array($this, 'progress_wsl_func' ));
				add_shortcode('fancast'		    , array($this, 'fan_func' ));
				add_shortcode('last38'		    , array($this, 'last38_func' ));
				add_shortcode('firstxgames'	    , array($this, 'firstxgames_func' ));
				add_shortcode('lastxgames'	    , array($this, 'lastxgames_func' ));
				add_shortcode('statsz'		    , array($this, 'statsz_func' ));
				add_shortcode('cann'		    , array($this, 'cann_func' ));
				add_shortcode('cann-foot'	    , array($this, 'cann_foot_func' ));
				add_shortcode('gdl'			    , array($this, 'gdl_func' ));
				add_shortcode('sixes'		    , array($this, 'sixes_func' ));
				add_shortcode('pls'			    , array($this, 'pls_func' ));
				add_shortcode('plcc'		    , array($this, 'plcc_func' ));
				add_shortcode('ccbm'		    , array($this, 'ccbm_func' ));
				add_shortcode('shotsanalysis'   , array($this, 'shotsanalysis_func' ));
				add_shortcode('locals'		    , array($this, 'locals_func' ));
				add_shortcode('crps'		    , array($this, 'crps_func' ));
				add_shortcode('subsperf'	    , array($this, 'subsperf_func' ));
				add_shortcode('passdiff'	    , array($this, 'passdiff_func' ));
				add_shortcode('passstats'	    , array($this, 'passstats_func' ));
				add_shortcode('hs'			    , array($this, 'hs_func' ));
				add_shortcode('otd'			    , array($this, 'otd_func' ));
				add_shortcode('daily'		    , array($this, 'daily_func' ));
				add_shortcode('cs'			    , array($this, 'chelseastat_shortcode' ));
				add_shortcode('rs'			    , array($this, 'refereestat_shortcode' ));
				add_shortcode('os'			    , array($this, 'oppositionstat_shortcode' ));
				add_shortcode('bet'			    , array($this, 'bet_shortcode' ));
				add_shortcode('dyk'			    , array($this, 'dyk_shortcode' ));
				add_shortcode('src'			    , array($this, 'src_shortcode' ));
				add_shortcode('ask'			    , array($this, 'ask_shortcode' ));
				add_shortcode('auth'		    , array($this, 'auth_shortcode' ));
				add_shortcode('chad'		    , array($this, 'chad_func' ));
				add_shortcode('eci'			    , array($this, 'eci_func' ));
					
		}
		
		/** Fancy Stats Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function fancy_func( $atts, $content = null ){

			$dollar  = '<p style="text-align:justify;">
						<abbr data-toggle="tooltip" data-placement="top" title="100 * (Scoring Percentage + Saves Percentage)" class="initialism">PDO</abbr>
						is the sum of a teams scoring percentage (goals/shots on target) and its save percentage (saves/shots on target against) multipled by 100 (sometimes 1000).
						PDO is a proxy for luck; a team with a low PDO will almost certainly to regress back to 100 (the mean) and can be considered unlucky. Although it regresses heavily to the mean,
						but some teams have proven PDO is sustainable to a certain degree by having an elite attack/defence.</p>'.PHP_EOL;

			$dollar .= '<p style="text-align:justify;">
						<abbr data-toggle="tooltip" data-placement="top" title="Shots For / (Shots For + Shots Against)" class="initialism">TSR</abbr>
						is the ratio of how many shots are taken for vs against, there is a reasonably strong correlation to points and goal difference.</p>'.PHP_EOL;

			$dollar .= '<p style="text-align:justify;">
						<abbr data-toggle="tooltip" data-placement="top" title="Shots on Target For / (Shots on Target For + Shots on Target Against)" class="initialism">SOTR</abbr>
						is similar to TSR but focuses solely on Shots on Target. It is repeatable year on year and can be a good forecast of relative future success (If a team continues to out shoot
						the opponent goals and wins should follow).</p>'.PHP_EOL;

			return $dollar;
		}

		/** Per90 Production POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function prod_func( $atts, $content = null ){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4777" alt="Prod_master" src="https://thechels.co.uk/media/uploads/prod_master.gif"/></p>'.PHP_EOL;
			$dollar .= '<p style="text-align:justify;">Player production focuses on how many points (goals and assists) are created in the Premier League this season.</p><p style="text-align:justify;">Data is provided on a per 90 minutes basis, this provides a better metric over a per game basis or the raw numbers. You can read more on the topic with this useful introduction on the <a href="https://www.statsbomb.com/2013/08/an-introduction-to-the-per-90-metric/" rel="nofollow">excellent Statsbomb website</a>.<p style="text-align:justify;">Players leaving the club during the season are excluded.</p>';
			$dollar .= '<p style="text-align:justify;">Common Key for tables:';
			$dollar .= ' <abbr data-toggle="tooltip" data-placement="top" title="Goals per 90 minutes" class="initialism">GP90</abbr>,';
			$dollar .= ' <abbr data-toggle="tooltip" data-placement="top" title="Assists per 90 minutes" class="initialism">AP90</abbr>,';
			$dollar .= ' and';
			$dollar .= ' <abbr data-toggle="tooltip" data-placement="top" title="All (goals and assists) per 90 minutes" class="initialism">ALLP90</abbr>. Tables are sortable just click the column headers to sort; use shift key to sort on multiple columns.</p>';

			return $dollar;
		}

		/** Charts Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function charts_func( $atts, $content = null ){

			$dollar =	'<p style="text-align:justify;">Premier League charts after the latest round of matches.</p>';

			return $dollar;
		}

		/** shots league POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function shotsleague_func( $atts, $content = null ){

			$dollar =	'<p style="text-align:justify;">The Shots League, ranks teams based on their head to head matches but uses shots instead of goals to award points.</p>';
			$dollar .=	'<p style="text-align:justify;">The table can show which teams are dominant in creating shots compared to their opponent and when compared to the actual league table might point to a
														a team\'s problems whether it\'s creation of shots or their conversion to goals.</p>';
			return $dollar;
		}

		/** shots on league POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function shotsonleague_func( $atts, $content = null ){

			$dollar =	'<p style="text-align:justify;">The Shots on Target League, ranks teams based on their head to head matches but uses shots on target instead of goals to award points.</p>';
			$dollar .=	'<p style="text-align:justify;">The table can show which teams are dominant in creating shots compared to their opponent and when compared to the actual league table might point to a
														a team\'s problems whether it\'s shot accuracy or their conversion to goals.</p>';
			return $dollar;
		}

		/** Progress CFC league POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function progresscfc_func( $atts, $content = null ){

			$dollar  =	'<p style="text-align:justify;">The Comparable Results League looks at all the Premier League fixtures this season that match Chelsea\'s schedule.</p>';
			$dollar .=	'<p style="text-align:justify;">The table provides an insight into fixture scheduling/difficulty and removes home/away advantage by looking at matching fixtures and although the number of fixtures will not match
														for much of the early parts of the season, the points per game can be indicative of performance.</p>';

			return $dollar;
		}

		/** Progress Report POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function progress_func( $atts, $content = null ){

			$dollar  =  '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4685" src="/media/uploads/progress_master.gif" alt="Progress League" /></p>'.PHP_EOL;
			$dollar .=	'<p style="text-align:justify;">The Progress Report is based on an idea by @SimonGleave that is effectively a seasonal points differential that compares the results of each team to comparable fixtures from last season, including swapping out relegated teams for their promoted counterparts.</p>';
			$dollar .=	'<p style="text-align:justify;">The premise is to show if a team is improving against the same opponents and it may show a better reflection of league standing as it ignores the impact of fixture scheduling. For example a team could be top of the league after being scheduled to play the promoted sides and sides who finished in the bottom half last season but actually have fewer points compared to the previous season.</p>';
			$dollar .=	'<p>Newly promoted teams are excluded.</p>';

			return $dollar;
		}

		/** Progress Report POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function progress_wsl_func( $atts, $content = null ){

			// Notice no graphic, they use a default WSL one in the drafter-wsl file
			$dollar  =	'<p style="text-align:justify;">The Progress Report is based on an idea by @SimonGleave that is effectively a seasonal points differential that compares the results of each team to comparable fixtures from last season, including swapping out relegated teams for their promoted counterparts.</p>';
			$dollar .=	'<p style="text-align:justify;">The premise is to show if a team is improving against the same opponents and it may show a better reflection of league standing as it ignores the impact of fixture scheduling. For example a team could be top of the league after being scheduled to play the promoted sides and sides who finished in the bottom half last season but actually have fewer points compared to the previous season.</p>';
			$dollar .=	'<p>Newly promoted teams are excluded.</p>';

			return $dollar;
		}

		/** Chelsea Fancast Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function fan_func( $atts, $content = null ){

			$dollar = '<div class="alert alert-success"><p style="text-align:justify;">You can <a href="https://chelseafancast.com/">listen and interact with the Chelsea Football Fancast live</a> Monday nights from 7pm, <a href="https://chelseafancast.com/">visit their website</a> and follow them on twitter <a href="https://www.twitter.com/ChelseaFancast">@ChelseaFancast</a> as <a href="https://www.twitter.com/ChelseaChadder">@ChelseaChadder</a> provides the podcast with a stats roundup.</p></div>';

			return $dollar;
		}

		/** Last 38 League POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function last38_func( $atts, $content = null ){

			$dollar  = '<p style="text-align:justify;">The Last 38 league is a look at how the Premier League table would finish when based on a team\'s performance over their last 38 league games based on an idea by <a href="https://twitter.com/OmarChaudhuri">@OmarChaudhuri</a>.</p>';
			$dollar .= '<p style="text-align:justify;">The data is updated on a rolling basis after every gameweek and all teams with at least some Premier League experience <a href="/last-38-league/">are included</a> and in some cases for newly promoted sides data will include ';
			$dollar .= 'their previous results even if these occurred several years ago. For the weekly update articles the table has been limited to only show active Premier League teams.</p>';
			$dollar .= '<p style="text-align:justify;">Teams are ordered by PPG, then by PTS, GD and finally by opposition name.</p>';

			return $dollar;

		}

		/** First x games POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function firstxgames_func( $atts, $content = null ){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4598" alt="Managerial Comparison Chelsea" src="https://thechels.co.uk/media/uploads/mc_master.gif" width="690" height="200" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align:justify;">A periodical look at our manager\'s performance in the Premier League compared to our former managers over the same number of games.</p>';
			$dollar .= '<p style="text-align:justify;">The first table focuses on the start of their career at Chelsea limited to the number of games managed by the current manager; A good indicator if they have settled in well and are inline with the owner\'s and supporter\'s expectations.</p>';
			$dollar .= '<h3>Manager Comparison by Opening League Games</h3>';

			return $dollar;
		}

		/** Last x games POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function lastxgames_func( $atts, $content = null ){

			$dollar  = '<p style="text-align:justify;">The second table focuses on the end of their career at Chelsea, limited to the number of games managed by the current manager; A good indicator as to whether their form is better or worse than those previously sacked by the owner and the board.</p>';
			$dollar .= '<h3>Manager Comparison by Ending League Games</h3>';

			return $dollar;
		}

		/** Statszone Shortcode
		 *
		 * @return string
		 */
		function statsz_func(){

			$dollar = '<div class="bs-callout bs-statszone"><h4>Stats Zone</h4><p style="text-align:justify;">Stats Zone is a <a href="//itunes.apple.com/us/app/fourfourtwo-soccer-stats-zone/id453744566?mt=8">free iPhone application</a> from <a href="//fourfourtwo.com/statszone/" target="_blank">fourfourtwo magazine</a> powered by <a href="https://www.optasports.com/" target="_blank">Opta stats</a> and is updated live in-play, and pre-loaded with all data from previous seasons across the top leagues in Europe. <a href="https://itunes.apple.com/gb/app/europa-league-fourfourtwo/id563211066?mt=8">You can also follow <a href="https://twitter.com/statszone">@statszone</a> on twitter. Check out the <a href="/statszone-key">Key for the definitions</a>.</p></div>';

			return $dollar;
		}

		/** Cann Table Shortcode
		 *
		 * @return string
		 */
		function cann_func(){

			$dollar = '<p style="text-align:justify;">The Cann table aims to give you some idea of the actual points gap between the teams in the league by listing them next to their current points total. Where teams are tied on points, teams are then ranked by goal difference from left to right and games played are shown in brackets.</p>';

			return $dollar;

		}

		/** Cann table Footer Shortcode
		 *
		 * @return string
		 */
		function cann_foot_func(){

			$dollar = '<div class="bs-callout bs-cann"><p style="text-align:justify;">From January 1998 up until her tragic death before the end of the 2002-2003 season, Jenny Cann published the ‘Visual League Table’ rather than simply producing a list of names and numbers. This later became known as <a href="//www.chiark.greenend.org.uk/~mikepitt/cann-table.html" target="_blank">The Cann Table</a>.</p></div>';

			return $dollar;
		}

		/** Goal Difference League POST Shortcode
		 *
		 * @return string
		 */
		function gdl_func(){

			$dollar = '<p style="text-align:justify;">A look at the league table when ranking by goal difference, an obvious indicator of performance. Where teams are tied, the team with the highest points total is shown first.</p>';

			return $dollar;
		}

		/** Saturday Sixes POST Shortcode
		 *
		 * @return string
		 */
		function sixes_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-1260" alt="Saturday Sixes - 6 key Chelsea Stats to see you through the weekend." src="https://thechels.co.uk/media/uploads/ss_master.gif" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align:justify;">Six key stats to see you through the weekend.</p>';

			return $dollar;
		}

		/** Premier League Scorers POST Shortcode
		 *
		 * @return string
		 */
		function pls_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4596" alt="Premier League Goal Scorers ChelseaStats" src="https://thechels.co.uk/media/uploads/pls_master.gif" width="690" height="200" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align:justify;">Premier League goalscorers so far this season split by penalties and with comparison to previous seasons. Own goals listed by season below.</p>';

			return $dollar;
		}
		
		/** Premier league Chance Conversion POST shortcode
		 *
		 * @return string
		 */
		function plcc_func(){

			$dollar  ='<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4685" src="/media/uploads/plcc_master.gif" alt="Premier League Chance Conversion" /></p>'.PHP_EOL;
			$dollar .='<p style="text-align:justify;">This season, moving away from our regular premier league scorers post after every matchday, we’ll look at chance conversion, this will also include the goals scored in the premier league, but will also provide more insight into who is getting chances and more importantly who is converting them.</p>';
			$dollar .='<p style="text-align:justify;">Players will be added to the table as they make the matchday squad throughout the season.</p>';

			return $dollar;
		}

		/** Cumulative chances by minute POST shortcode
		 *
		 * @return string
		 */
		function ccbm_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4685" src="/media/uploads/ccbm_master.gif" alt="Premier League Cumulative chances by minute" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align:justify;"></p>';
			
			return $dollar;
		}

		/** Shots analysis
		 * @param      $atts
		 * @param null $content
		 * @return string
		 */
		function shotsanalysis_func( $atts, $content = null ) {

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4685" src="/media/uploads/sa_master.gif" alt="Premier League Chelsea Shots Analysis" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align:justify;">This article looks at our most recent match against '.$content.' analysing  how the game played out in terms of shots for both teams.</p>';

			return $dollar;
		}

		/** Shot Locations POST Shortcode
		 *
		 * @return string
		 */
		function locals_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4685" src="/media/uploads/locals_master.gif" alt="Premier League Cumulative Shot and Goal Locations" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align:justify;">The graphic below shows our cumulative shots and goals in the Premier League this season excluding own goals and penalties, based on data from Opta.</p>';

			return $dollar;
		}

		/** Cumulative results per starter POST Shortcode
		 *
		 * @return string
		 */
		function crps_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4685" src="/media/uploads/starter_master.gif" alt="Premier League Results by Starters" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align:justify;">The table below shows our results in the Premier League by starter, the data is just raw figures and does not take into account the length of start – an injury after 10 minutes for example.</p>';
			$dollar .= '<p style="text-align:justify;">It also does not take into account the level of opposition, but it may hint at which player has added to the team’s results compared to a colleague in a similar position.</p>';
			$dollar .= '<p style="text-align:justify;">We have also included goals for and against in total and on a per game basis too.</p>';

			return $dollar;
		}

		/** Subs Performance POST Shortcode
		 *
		 * @return string
		 */
		function subsperf_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4685" src="/media/uploads/subs_master.gif" alt="Premier League Substitute Attacking Performance" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align:justify;">The table below shows the attacking contribution of our substitutes in the Premier League this season.</p>';
			$dollar .= '<p style="text-align:justify;">As the data builds up over a season, this might indicate who the manager prefers and who might be deserving of a place in the starting 11.</p>';

			return $dollar;

		}

		/** Pass Differential POST Shortcode
		 *
		 * @return string
		 */
		function passdiff_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4594" alt="Passing Differential ChelseaStats" src="https://thechels.co.uk/media/uploads/pd_master.gif" width="690" height="200" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align: justify;">The following table shows the current squad and how they have contributed to the team\'s passing so far this season.</p>';
			$dollar .= '<p style="text-align: justify;">The figure is the differential between the percentage of the team\'s successful passes minus the percentage of the team\'s misplaced passes that the player has contributed to.</p>';
			$dollar .= '<p style="text-align: justify;">The higher the number the better as it shows a player is involved lots in passing but rarely gives it away, negative values point to a player who perhaps tries a killer pass or speculative play, expect goalkeepers, who are forced to kick long into a 50/50 aerial duel, and lone strikers (often isolated and surrounded by defenders), to rank badly.</p>';

			return $dollar;
		}

		/** Passing Stats POST shortcode
		 *
		 * @return string
		 */
		function passstats_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4594" alt="Passing ChelseaStats" src="https://thechels.co.uk/media/uploads/pass_master.gif" width="690" height="200" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align: justify;">The following table shows the current squad and how they have contributed to the team\'s passing in the Premier League so far this season. The figures include percentages of the team\'s overall performance.</p>';
			$dollar .= '<p style="text-align: justify;">Some players may appear to misplace a higher percentage of the teams misplaced passes but this maybe due to the sort of player they are and the types of passes attempted, for example creative players may try more speculative passes in congested areas compared to a centre-back finding a midfielder 10 yards away.</p>';
			$dollar .= '<p>Each week we will tag the article with the players who completed the most passes in that week';

			return $dollar;

		}

		/** Headline Stats POST shortcode
		 *
		 * @return string
		 */
		function hs_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4594" alt="Headline Stats by ChelseaStats" src="https://thechels.co.uk/media/uploads/hs_master.gif" width="690" height="200" /></p>'.PHP_EOL;
			
			return $dollar;
		}
		
		/** On This Day POST shortcode
		 *
		 * @return string
		 */
		function otd_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4594" alt="On This Day by ChelseaStats" src="https://thechels.co.uk/media/uploads/otd_master.gif" width="690" height="200" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align: justify;">A look back at what happened on this day in history, including results summary and key events.</p>';

			return $dollar;
		}

		/** On This Day POST shortcode
		 *
		 * @return string
		 */
		function daily_func(){

			$dollar  = '<p style="text-align:justify;"><img class="aligncenter size-full wp-image-4594" alt="On This Day by ChelseaStats" src="https://thechels.co.uk/media/uploads/otd_master.gif" width="690" height="200" /></p>'.PHP_EOL;
			$dollar .= '<p style="text-align: justify;">A look a head of what is happening today with a look back at this day in history, including results summary and key events.</p>';

			return $dollar;
		}

		/** Chelsea stat alert shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function chelseastat_shortcode( $atts, $content = null ) {

			$dollar = '<div class="bs-callout bs-chelsea"><h4>Key Chelsea Stat</h4><p style="text-align:justify">' . $content . '</p></div>';

			return $dollar;
		}

		/** Ref stat alert shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function refereestat_shortcode( $atts, $content = null ) {

			$dollar = '<div class="bs-callout bs-referee"><h4>Key Referee Stat</h4><p style="text-align:justify">' . $content . '</p></div>';

			return $dollar;
		}

		/** Oppo stat alert shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function oppositionstat_shortcode( $atts, $content = null ) {

			$dollar = '<div class="bs-callout bs-opposition"><h4>Key Opposition Stat</h4><p style="text-align:justify">' . $content . '</p></div>';

			return $dollar;
		}

		/** bet shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function bet_shortcode( $atts, $content = null ) {

			extract(shortcode_atts(array("href" => 'http://thechels.uk/CFCBetVictor'), $atts));

			$dollar = '<p>&nbsp;</p>';

			return $dollar;
		}

		/** Did you know bootstrap label shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function dyk_shortcode( $atts, $content = null ){

			$dollar = '<p style="text-align:justify;"><span class="label label-success">Did You Know?</span> '.$content.'.</p>';

			return $dollar;
		}

		/** source linked url shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function src_shortcode($atts, $content = null) {

			extract(shortcode_atts(array("href" => 'https://'), $atts));

			$dollar = '<p style="text-align:justify;"><span class="label label-info">Source: </span>&nbsp;&nbsp;<a href="'.$href.'">'.$content.' <i class="fa fa-chevron-right"></i></a></p>';

			return $dollar;
		}

		/** Ask ChelseaStats shortcode
		 *
		 * @return string
		 */
		function ask_shortcode( ){

			$dollar ='<p style="text-align:justify;" class="alert alert-info">You can Ask ChelseaStats on twitter (@ChelseaStats) or by email (' .antispambot('ask@thechels.co.uk'). ') and the best will be selected and featured in an article. Remember to check out our mobile app at <a href="https://m.thechels.uk" target="_blank">m.thechels.uk</a> for curated Chelsea Statistics.</p>';

			return $dollar;
		}
		
		/** Author Footer Shortcode
		 *
		 * @return string
		 */
		function auth_shortcode(){

			$dollar  = '<p style="text-align:justify;">';
			$dollar .= '<span class="rwd-line line2">';
			$dollar .= '<span class="label label-info">Twitter</span>';
			$dollar .= '  <a href="https://twitter.com/intent/user?screen_name=ChelseaStats">You should follow @ChelseaStats</a>. </span>';
			$dollar .= '<span class="rwd-line line2"><span class="label label-success">RSS</span>';
			$dollar .= '  <a href="/feed/" title="subscribe to ChelseaStats RSS Feed">Subscribe now to keep up to date</a>. </span>';
			$dollar .= '<span class="rwd-line line2"><span class="label label-inverse">Sponsor</span>';
			$dollar .= '  <a href="/sponsorship/" title="Sponsor us">Sponsor us!</a>';
			$dollar .= '</span>';
			$dollar .= '</p>';

			return $dollar;
		}

		/** Chad POST Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function chad_func( $atts, $content = null ){

			$dollar  = '<p style="text-align:justify;" class="alert alert-success">You can purchase and download a detailed statistical report of any Chelsea player produced by ';
			$dollar .= '<a href="https://www.twitter.com/ChelseaChadder">@ChelseaChadder</a> including legends such as Drogba, Osgood, Lampard, Nevin, Luiz, Mata, Dixon and Wise with data from their time at Chelsea Football Club. ';
			$dollar .= 'It includes all of their games, goals as well as own goals and red cards as applicable.</p>';

			return $dollar;
		}

		/** EuroClubIndex Shortcode
		 *
		 * @param      $atts
		 * @param null $content
		 *
		 * @return string
		 */
		function eci_func( $atts, $content = null ){

		$dollar  = '<p style="text-align: justify;" class="alert alert-success">The Euro Club Index (ECI) is a ranking of the football teams in the highest division of all European countries, that shows their relative playing ';
		$dollar .= 'strengths at a given point in time, and the development of playing strengths in time. You can view the entire ranking and methodology at <a href="//www.euroclubindex.com">EuroClubIndex.com</a> and you can follow ';
		$dollar .= 'their updates on twitter via <a href="https://twitter.com/EuroClubIndex">@EuroClubIndex</a> Or view <a href="https://thechels.co.uk/club/euro-club-index/">Chelsea\'s ECI ranking since 2007</a> here.</p>';

		return $dollar;
		
		}

	}
	
	$sc = new shortcoder();
