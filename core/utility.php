<?php
	/*
	Plugin Name: CFC Utility Class
	Description: Adds a class of api methods
	Version: 11.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();


class utility {

	    public $status;
	    public $data;

		/**
		 * utility constructor.
		 */
		function __construct() {
		    }

	    /**
	     * @param  mixed $tweet
	     * @return mixed $tweet
	     */
	    function writeLinks( $tweet ) {
	        //for http links
	        $tweet = preg_replace( '!http://([a-zA-Z0-9./-]+[a-zA-Z0-9/-])!i', ' <a href="\\0" target="_blank">\\0</a> ', $tweet );
	        // for https links because my regex is lame.
	        $tweet = preg_replace( '!https://([a-zA-Z0-9./-]+[a-zA-Z0-9/-])!i', ' <a href="\\0" target="_blank">\\0</a> ', $tweet );
	        //for hash tags
	        $tweet = preg_replace( "/#([a-z_0-9]+)/i", ' <a href="http://twitter.com/search/$1">$0</a> ', $tweet );
	        //for mentions
	        $tweet = preg_replace( "/\B[@]([a-zA-Z0-9_]{1,20})/i", ' <a target="_blank" class="twtr-atreply" href="https://twitter.com/$1">@$1</a> ', $tweet );

	        // the order of the regular expressions are very important.
	        return $tweet;
	    }

		/**
		 * @param        $html
		 * @param string $char_set
		 *
		 * @return string
		 */
		function esc_html( $html, $char_set = 'UTF-8' )	{
	        if ( empty( $html ) ) {
	            return '';
	        }
	        $html = (string) $html;
	        $html = htmlspecialchars( $html, ENT_QUOTES, $char_set );
	        return $html;
	    }

	    /** Get another url button
	     * @param mixed $url href location
	     * @param mixed $label button label
	     * @return string
	     */
	    function getAnother( $url, $label = 'Continue' ) {
	        return '<span class="another"><a href="' . $url . '"  class="btn btn-primary">' . $label . '</a></span>';
	    }

	    /** prints a button for a drop-down box
	     * @return string
	     */
	    function getSubmit() {

	        $dollar  = '<div class="row-fluid"><div class="span12"><div class="form-group">'.PHP_EOL;
		    $dollar .= '<input type="button" class="form-control btn btn-primary" 
							onclick="window.open(this.form.mySelectbox.options[this.form.mySelectbox.selectedIndex].value,\'_top\');"  value="Go">'.PHP_EOL;
		    $dollar .= '</div></div></div>'.PHP_EOL;

	        return $dollar;
	    }
	
	    /**
	     * Returns initials of a name
	     *
	     * @param $name
	     *
	     * @return string
	     */
	    function getInitials($name) {
	        $initials ='';
	        $name = $this->_V($name); // tidy it first
	        $names = preg_split("/[\s,_-]+/",$name);
	        foreach($names as $name):
	            $initials .= $name['0'];
	        endforeach;

	        return $initials;
	    }

	    /**
	     * returns a tooltip
	     *
	     * @param mixed $label
	     * @param mixed $title
	     * @return string $return
	     */
	    function getTooltip($label,$title) {
	        $return = '<abbr data-toggle="tooltip" data-placement="top" title="'.$title.'">'.$label.'</abbr>';
	        return $return;
	    }

	    /**
	     * Calculates percentage of numerator and denominator.
	     *
	     * @param int|float $numerator
	     * @param int|float $denominator
	     * @param int $decimals
	     * @param string $dec_point
	     * @param string $thousands_sep
	     * @return int|float
	     */
	    public static function getPercentage($numerator, $denominator, $decimals = 2, $dec_point = '.', $thousands_sep = ',')
	    {
	        return number_format(($numerator / $denominator) * 100, $decimals, $dec_point, $thousands_sep);
	    }

	    /**
	     * returns a group of buttons
	     *
	     * @return string $dollar;
	     */
	    function getOptionMenu() {

	        $dollar = '<div class="row-fluid"><div class="span12">';
		    $dollar .= $this->getAnother( '/a/z-updater/'           , "EPL Updater" );
		    $dollar .= $this->getAnother( '/a/z-updater-minutes/'   , "Process Mins" );
		    $dollar .= $this->getAnother( '/a/z-get-stato-f/'       , "WSL Player Stats" );
		    $dollar .= $this->getAnother(strtok($_SERVER["REQUEST_URI"],'?'),"Again");
	        $dollar .= '</div></div>';

	        return $dollar;

	    }

	    /**
	     * returns a Boolean
	     *
	     * @param mixed $gameid
	     * @param mixed $player
	     * @return boolean
	     */
	    function get_current_player($gameid,$player) {

	        $pdo = new pdodb();
	        $pdo->query("select count(*) as CNT from cfc_fixtures_players where F_NAME = :player and F_GAMEID = :gameid");
	        $pdo->bind('player',$player);
	        $pdo->bind('gameid',$gameid);
	        $row = $pdo->row();

	        if($row['CNT'] > 0 ) {
	            return 1;
	        }
	        else {
	            return 0;
	        }
	    }
	    
	    /**
	     * returns summed row of data for a player, this season.
	     *
	     * @param mixed $player
	     * @return boolean
	     */
	    function get_playerSummary($player) {
	   
	        $pdo = new pdodb();
	        $pdo->query("select F_NO, F_NAME, sum(a.F_APPS) as F_APPS, sum(a.F_SUBS) F_SUBS, sum(a.F_UNUSED) F_UNUSED, sum(a.F_GOALS) as F_GOALS, sum(a.F_SHOTS) as F_SHOTS, sum(a.F_SHOTSON) as F_SHOTSON, sum(a.F_ASSISTS) as F_ASSISTS, sum(a.F_FOULSCOM) as F_FOULSCOM,  sum(a.F_FOULSSUF) as F_FOULSSUF, sum(a.F_YC) as F_YC, sum(a.F_RC) as F_RC from cfc_fixtures_players where F_NAME = :player 
	        	and F_DATE > SELECT F_DATE from 000_config where F_LEAGUE='PL'");
	        $pdo->bind('player',$player);
	        $row = $pdo->row();

	        if($row['CNT'] > 0 ) {
	            return 1;
	        }
	        else {
	            return 0;
	        }
	    }

		/**
	 * Parses a site and returns content
	 * @param mixed $url
	 * @return mixed $raw
	 */
	    function goCurl( $url ) {
		    
		    $ch          = curl_init();
		    curl_setopt( $ch, CURLOPT_HEADER, 0 );
			    $headers   = array ();
			    $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
			    $headers[] = 'Host: www.gooele.co.uk';
			    $headers[] = 'Referer: http://www.google.co.uk/';
			    $headers[] = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0';
			    $headers[] = 'X-MicrosoftAjax: Delta=true';

			curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		    //Set curl to return the data instead of printing it to the browser.
		    curl_setopt( $ch, CURLOPT_URL, $url );
		    curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
		    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 400 );
		    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		    $result['EXE'] = curl_exec( $ch );
		    $result['INF'] = curl_getinfo( $ch );
		    $result['ERR'] = curl_error( $ch );
		    $raw           = curl_exec( $ch );
		    curl_close( $ch );

		    return $raw;

	    }
	
	    /**
	     * Get minute from string
	     *
	     * @param  string $minute
	     * @return int $minute
	     */
	    function get_minute($minute) {
	        if ( strpos( $minute, '+' ) ) {
	            $minutes = explode( '+', $minute );
	            $minute = trim($minutes[0]);
	        }
	        return  $minute;
	    }

	    /**
	     * Returns the half of the game based on minute
	     *
	     * @param  int $minute
	     * @return int $half
	     */
	    function get_half($minute) {

	        $half = null;

	        if ( $minute <= 45 ) {
	            $half = 1;
	        }
	        if ( $minute >= 46 ) {
	            $half = 2;
	        }
	        if ( $minute >= 91 ) {
	            $half = 3;
	        }
	        if ( $minute >= 106 ) {
	            $half = 4;
	        }

	        return $half;

	    }

	    /**
	     * Checks if string is in array
	     *
	     * @param mixed $str
	     * @param mixed $arr
	     * @return bool
	     */
	    function get_contains($str, array $arr)
	    {
	        foreach($arr as $a) {
	            if (stripos($str,$a) !== false) return true;
	        }
	        return false;
	    }

		/**
		 * Gets max ID from fixtures
		 * @param string $value
		 * @return  $limit the maximum value
		 */
	    function get_maxGameId($value ='men') {

		    if ( $value == 'wsl' || $value == 'women' ) :
			    $table = 'wsl_fixtures';
		    else:
			    $table = 'cfc_fixtures';
		    endif;

	        $pdo = new pdodb();
	        $pdo->query("select max(f_id) as F_VALUE from {$table}");
	        $row = $pdo->row();
	        return $limit = $row['F_VALUE'];
	    }
	    
	    
		/**
		 * Gets gamweek string from fixtures
		 * @param string $value
		 * @return string $gw
		 */	    
	    function get_gameWeek() {
	    
	    	$pdo = new pdodb();
	      $pdo->query("SELECT SUM(PLD) as PLD FROM 0V_base_PL_this 
                     WHERE Team ='CHELSEA' GROUP BY Team");
        $rows  = $pdo->resultset();
        foreach($rows as $row) {
             $gw = intval($row['PLD']);
        }
        if($gw < 10) { $gw = '0'.$gw; }
	      return $gw;
	    }
		/**
		 * Gets gamweek string from fixtures
		 * @param string $value
		 * @return string $gw
		 */	    
	    function get_oppo() {
	    
	    	$pdo = new pdodb();
		    $pdo->query("SELECT F_OPP as team from cfc_fixtures order by F_DATE desc limit 1");
        $row  = $pdo->row();
        
        return $this->_V($row['team']);
	    }

			/**
			* Gets a bunch of scorers from latest game
			* @param array $rows
			* @return string $string
			*/
			function get_scorers() {
			
				$pdo = new pdodb();
		    $pdo->query("SELECT distinct f_name as name from cfc_fixtures_players Where f_goals > 0 and f_gameid = (select max(f_id) as id from cfc_fixtures) 
		    order by F_NAME asc");
        $rows  = $pdo->rows();
				return $this->commaString($rows);
			}

			/**
			* Gets a bunch of assists from latest game
			* @param array $rows
			* @return string $string
			*/
			function get_assisters() {
				$pdo = new pdodb();
		    $pdo->query("SELECT distinct f_name as name from cfc_fixtures_players Where f_assists > 0 and f_gameid = (select max(f_id) as id from cfc_fixtures) 
		    order by F_NAME asc");
        $rows  = $pdo->rows();
				return $this->commaString($rows);
			}
			
			/**
			* Turns column of data into a comma string
			* @param array $rows
			* @return string $string
			*/
			function commaString($rows) {
				
					$string = '';
					foreach($rows as $row) {
						$string .= $this->_V($row['name']). ', ';
					}
						$string = rtrim($string,',');
					return $string;
			}
				    
     /**
		 * Gets season string from fixtures
		 * @param string $value
		 * @return string $ssn
		 */	    
	    function get_ssn() {
	     
	      $date = date('Y-m-d');
	      $ssn  = $this->getSeasonalDate($date);
	      return $ssn;
	    }	    

			/** get ESPN ID for ShotsFlow
			 * @param $gameid
			 * @return mixed
			 */
			function get_ESPNid($gameid) {
	
				$pdo = new pdodb();
				$pdo->query("select F_ESPN as F_VALUE from data_source where F_GAMEID = {$gameid}");
				$row = $pdo->row();
				return $limit = $row['F_VALUE'];
			}
			
			

	    /**
	     * Gets max ID from table
	     *
	     * @param string $table
	     * @return int $limit
	     */
	    function get_maxValue($table) {

	        $pdo = new pdodb();
	        $pdo->query("select max(f_id) as F_VALUE from ".$table);
	        $row = $pdo->row();
	        return $limit = $row['F_VALUE'];
	    }

	    /**
	     * Converts URL to a bitly URL &format=txt&
	     *
	     * @param  string $url
	     * @return string $url
	     */
	    function goBitly( $url ) {
	        $encoded_url = urlencode( $url );
	        $site_url    = ( "https://api-ssl.bitly.com/v3/shorten?format=txt&access_token=6a02cf5579e0ff1245cd66a0db40d83ac28ac27e&longUrl=$encoded_url" );
	        $ch = curl_init($site_url);
	        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	        $bitly_return = curl_exec($ch);

	        if ( $bitly_return !='' || $bitly_return !='ALREADY_A_BITLY_LINK') {
	            $url = $bitly_return;
	        }

	        return $url;
	    }

	    /**
	     * prints admin menu
	     *
	     * @return string $dollar
	     */
	    function goAdminMenu() {

	        $dollar =  '<div class="row-fluid">
						<div class="span4 pull-right">
						<div id="filter-2" class="widget widget_archive">
						<span class="form-filter">
						<select name="filter-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="">Page Filter</option>';
	        $pages = get_pages( array ( 'post_status' => 'private', 'parent' => '5981' ) );
	        foreach ( $pages as $pagg ) {
	            $dollar .= '<option value="' . get_page_link( $pagg->ID ) . '" >' . $pagg->post_title . '</option>';
	        }
	        $dollar .= '</select></span></div></div></div>';

	        return $dollar;

	    }

	    /**
	     * Makes a string ready for the DB and free from encoding issues
	     *
	     * @param  string $name
	     * @return string $name
	     */
	    function get_prepare_text($name) {

	        // swap out foreign characters. this is better.
	        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
	            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
	            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
	            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
	            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y',
	            'Ğ'=>'G', 'İ'=>'I', 'Ş'=>'S', 'ğ'=>'g', 'ı'=>'i', 'ş'=>'s', 'ü'=>'u', );

	        $name = strtr( $name, $unwanted_array );

	        $name = strtoupper(str_replace(' ','_',trim($name)));

	        return $name;

	    }

	    /**
	     * Prepares string for displaying
	     *
	     * @param  string $input
	     * @return string $output
	     *
	     */
	    function _V( $input ) {

	        $output = implode('-', array_map('ucfirst', explode('-', ucwords(strtolower(str_replace('_',' ',$input))))));

	        return $output;
	    }

	    /**
	     * Prepares string for querying DB
	     *
	     * @param  string $input
	     * @return string $value
	     *
	     */
	    function _Q( $input ) {

	        $value = strtoupper( str_replace( ' ', '_', $input ) );

	        return $value;
	    }

		/**
		 * @param $i
		 * @return array
		 */
	    function _Y($i)
		{
			//return just the year from a mysql iso standard date
			$i = explode('-', $i);
			$i = $i[0];

			return $i;
		}

	    /**
	     * upper cases and strips tags ready for input
	     *
	     * @param  string $value
	     * @return string $value
	     *
	     */
	    function inputUpClean( $value ) {

		    $value = addslashes( $value );
	        // Strip any tags from the value.
	        $value = strip_tags( $value );
	        // Return the value out of the function.
	        $value = str_replace( ' ', '_', $value );
	        $value = strtoupper( $value );

	        return $value;
	    }

	    /**
	     * Escapes variable
	     *
	     * @param  string $input
	     * @return string $input
	     */
	    function escaping( $input ) {
	        $input = addslashes( $input );
	        $input = str_replace( "\'", "''", $input );

	        return $input;
	    }

	    /**
	     * Creates Hash from 3 vars
	     *
	     * @param string $date
	     * @param string $home
	     * @param string $away
	     * @return string $rand
	     */
	    function getkey( $date, $home, $away ) {
	        $rand = md5( $date . '-' . $home . '-' . $away );

	        return $rand;
	    }

	    /**
	     * creates the sites RSS feeds
	     *
	     * @param string $url
	     * @param string $feed
	     * @param string $desc
	     * @param string $title_this
	     * @param string $title_all
	     * @param string $query_key
	     * @param string $query_this
	     * @param string $query_all
	     * @param string $query_results
	     * @param string $type
	     * @param string $raw
	     */
	    function doRSS( $url, $feed, $desc, $title_this, $title_all, $query_key, $query_this, $query_all, $query_results, $type, $raw = '' ) {
		    $xml = '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
		    $xml .= '<rss version="2.0"
						xmlns:content="http://purl.org/rss/1.0/modules/content/"
						xmlns:wfw="http://wellformedweb.org/CommentAPI/"
						xmlns:webfeeds="http://webfeeds.org/rss/1.0"
						xmlns:dc="http://purl.org/dc/elements/1.1/"
						xmlns:atom="http://www.w3.org/2005/Atom"
						xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
						xmlns:slash="http://purl.org/rss/1.0/modules/slash/" >' . PHP_EOL;
		    $xml .= '<channel>' . PHP_EOL;
		    $xml .= '<sy:updatePeriod>hourly</sy:updatePeriod>'.PHP_EOL;
		    $xml .= '<sy:updateFrequency>1</sy:updateFrequency>'.PHP_EOL;
		    $xml .= '<generator>thechels.co.uk/rss-feeds/ (@ChelseaStats and @fawslstats)</generator>' . PHP_EOL;
		    $xml .= '<title>' . $feed . '</title>' . PHP_EOL;
		    $xml .= '<description>' . $desc . '</description>' . PHP_EOL;
		    $xml .= '<webfeeds:cover image="https://thechels.co.uk/media/themes/ChelseaStats/img/logo.png" />' . PHP_EOL;
		    $xml .= '<webfeeds:accentColor>#326ea1</webfeeds:accentColor>' . PHP_EOL;
		    $xml .= '<webfeeds:related layout="card" target="browser"/>' . PHP_EOL;
		    $xml .= '<webfeeds:analytics id="UA-61731032-1" engine="GoogleAnalytics"/>' . PHP_EOL;
		    $xml .= '<link>' . $url . '</link>' . PHP_EOL;
		    $xml .= '<ttl>1440</ttl>' . PHP_EOL;
		    $xml .= '<atom:link href="http://thechels.co.uk/?feed=' . $type . '" rel="self" type="application/atom+xml" />' . PHP_EOL;
		    $xml .= '<copyright>Copyright ChelseaStats ' . date( 'Y' ) . '</copyright>' . PHP_EOL;
		    $xml .= '<item>' . PHP_EOL;
		    $xml .= '<pubDate>' . date( "D, d M Y H:i:s O", time() ) . '</pubDate>' . PHP_EOL;
		    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		    $pdo = new pdodb();
		    $pdo->query( $query_key );
		    $row       = $pdo->row();
		    $main_date = $row['D'];
		    $HO        = $row['H'];
		    $AO        = $row['A'];
		    $rand      = $this->getkey( '2016x' . $main_date, $HO, $AO );

		    if ( $type == 'history' ) {
			    $xml .= "<title>{$HO} / {$AO}  - {$desc}</title>" . PHP_EOL;
		    } else {
		        $xml .= '<title>' . $main_date . ' - ' . $desc . '</title>' . PHP_EOL;
	        }

		    $xml .= '<link>https://thechels.co.uk/rss-feeds/#' . $rand . '</link>' . PHP_EOL;
	        $xml .= '<description><![CDATA[';
	        //**** Only do this season (below) if set ****//
	        if ( isset( $query_this ) && $query_this != '' ) {
	            $xml .= '<h3>' . $title_this . '</h3>';
	            //================================================================================
	            $pdo->query( $query_this );
	            $rows = $pdo->rows();
	            $xml .= '<div class="table-container"><table class="tablesorter"><thead>' . PHP_EOL;
	            $xml .= '<tr><th>Team</th><th>PLD</th><th>W</th><th>D</th><th>L</th><th>FS</th><th>CS</th><th>BTTS</th><th>F</th><th>A</th><th>GD</th><th>PPG</th><th>PTS</th></tr>' . PHP_EOL;
	            $xml .= '</thead><tbody>' . PHP_EOL;
	            foreach ( $rows as $row ) {
	                $H01 = $this->_V( $row['Team'] );
	                $H02 = $row['PLD'];
	                $H03 = $row['W'];
	                $H04 = $row['D'];
	                $H05 = $row['L'];
	                $H06 = $row['FS'];
	                $H07 = $row['CS'];
	                $H08 = $row['BTTS'];
	                $H09 = $row['F'];
	                $H10 = $row['A'];
	                $H11 = $row['GD'];
	                $H12 = $row['PPG'];
	                $H13 = $row['PTS'];
	                $xml .= '<tr><td>' . $H01 . '</td><td>' . $H02 . '</td><td>' . $H03 . '</td><td>' . $H04 . '</td><td>' . $H05 . '</td><td>' . $H06 . '</td><td>' . $H07 . '</td>
						<td>' . $H08 . '</td><td>' . $H09 . '</td><td>' . $H10 . '</td><td>' . $H11 . '</td><td>' . $H12 . '</td><td>' . $H13 . '</td></tr>' . PHP_EOL;
	            }
	            $xml .= '</tbody></table></div>' . PHP_EOL;
	        }
	        //**** Only do this season (above) if set ****//

	        //================================================================================
	        $xml .= '<h3>' . $title_all . '</h3>';
	        //================================================================================
	        $pdo->query( $query_all );
	        $rows = $pdo->rows();
	        if ( $type == 'progress') {

	            $xml .= '<table class="tablesorter small"><thead>' . PHP_EOL;
	            $xml .= '<tr><th>Team</th><th>PtsD</th></tr>' . PHP_EOL;
	            $xml .= '</thead><tbody>' . PHP_EOL;
	            foreach ( $rows as $row ) {
	                $H01 = $this->_V( $row['N_NAME'] );
	                $H02 = $row['PTS'];
	                $xml .= '<tr><td>' . $H01 . '</td><td>' . $H02 . '</td></tr>' . PHP_EOL;
	            }
	            $xml .= '</tbody></table>' . PHP_EOL;

	            $xml .= '<p><small>Key: PtsD - Points Differential of results from this season to comparable results from last season</small></p>' . PHP_EOL;

	        }
	        elseif ( $type == 'history') {

	            $xml .= '<table class="tablesorter small"><thead>' . PHP_EOL;
	            $xml .= '<tr><th>Date</th><th>Name</th><th>Note</th></tr>' . PHP_EOL;
	            $xml .= '</thead><tbody>' . PHP_EOL;
	            foreach ( $rows as $row ) {
	                $H01 = $row['F_DATE'];
	                $H02 = $this->_V( $row['F_NAME'] );
	                $H03 = $row['F_NOTES'];
	                $xml .= '<tr><td>' . $H01 . '</td><td>' . $H02 . '</td><td>' . $H03 . '</td></tr>' . PHP_EOL;
	            }
	            $xml .= '</tbody></table>' . PHP_EOL;

	            $xml .= '<p><small>Future historic events checker</small></p>' . PHP_EOL;

	        }
	        elseif ( $type == 'cann') {
	            $dollar = do_shortcode('[cann]'). PHP_EOL;
	            $xml .= $dollar;
	            $xml .= $this->CannNamStyle($raw,'Points','12'). PHP_EOL;
	            $dollar = do_shortcode('[cann-foot]') . PHP_EOL;
	            $xml .= $dollar;
	        }
	        elseif ( $type == 'gdl') {
	            $dollar = do_shortcode('[gdl]');
	            $xml .= $dollar;
	            $xml .= $this->CannNamStyle($raw,'Goal Diff','10'). PHP_EOL;

	        }
	        elseif ( $type == 'wslcann') {
	            $dollar = do_shortcode('[cann]'). PHP_EOL;
	            $xml .= $dollar;
	            $xml .= $this->CannNamStyle($raw,'Points','12'). PHP_EOL;
	            $dollar = do_shortcode('[cann-foot]') . PHP_EOL;
	            $xml .= $dollar;
	        }
	        elseif ( $type == 'wslgdl') {
	            $dollar = do_shortcode('[gdl]');
	            $xml .= $dollar;
	            $xml .= $this->CannNamStyle($raw,'Goal Diff','10'). PHP_EOL;

	        }
	        else {
	            $xml .= '<div class="table-container"><table class="tablesorter"><thead>' . PHP_EOL;
	            $xml .= '<tr><th>Team</th><th>PLD</th><th>W</th><th>D</th><th>L</th><th>FS</th><th>CS</th><th>BTTS</th><th>F</th><th>A</th><th>GD</th><th>PPG</th><th>PTS</th></tr>' . PHP_EOL;
	            $xml .= '</thead><tbody>' . PHP_EOL;
	            foreach ( $rows as $row ) {
	                $H01 = $this->_V( $row['Team'] );
	                $H02 = $row['PLD'];
	                $H03 = $row['W'];
	                $H04 = $row['D'];
	                $H05 = $row['L'];
	                $H06 = $row['FS'];
	                $H07 = $row['CS'];
	                $H08 = $row['BTTS'];
	                $H09 = $row['F'];
	                $H10 = $row['A'];
	                $H11 = $row['GD'];
	                $H12 = $row['PPG'];
	                $H13 = $row['PTS'];
	                $xml .= '<tr><td>' . $H01 . '</td><td>' . $H02 . '</td><td>' . $H03 . '</td><td>' . $H04 . '</td><td>' . $H05 . '</td><td>' . $H06 . '</td><td>' . $H07 . '</td>
					<td>' . $H08 . '</td><td>' . $H09 . '</td><td>' . $H10 . '</td><td>' . $H11 . '</td><td>' . $H12 . '</td><td>' . $H13 . '</td></tr>' . PHP_EOL;
	            }
	            $xml .= '</tbody></table></div>' . PHP_EOL;

	            $xml .= '<p><small>Key: PLD - played, FS - failed to score, CS - clean sheets, BTTS - both teams to score, GD - goal difference, PPG - Points per game, PTS - Points</small></p>' . PHP_EOL;
	            //================================================================================
	        }

	        $xml .= '<h3>Last 10 results</h3>';
	        $xml .= '<ul>' . PHP_EOL;
	        //================================================================================
	        $pdo->query( $query_results );
	        $rows = $pdo->rows();
	        foreach ( $rows as $row ) {
	            $HO = $this->_V( $row['H_TEAM'] );
	            $HG = $this->_V( $row['HG'] );
	            $AG = $this->_V( $row['AG'] );
	            $AO = $this->_V( $row['A_TEAM'] );
	            $DD = $this->_V( $row['D'] );
	            $xml .= '<li> (' . $DD . ') ' . $HO . ' ' . $HG . '-' . $AG . ' ' . $AO . '</li>' . PHP_EOL;
	        }
	        //================================================================================
	        $xml .= '</ul>' . PHP_EOL;
	        $xml .= '<footer>' . PHP_EOL;
	        $xml .= '<hr/>'.PHP_EOL;
	        $xml .= '<p><small>Data provided by <a href="https://twitter.com/ChelseaStats">@ChelseaStats</a>, <a href="https://twitter.com/FawslStats">@FawslStats</a>  &amp; ';
	        $xml .= '<a href="https://thechels.co.uk">TheChels.co.uk</a> &copy; '. date( 'Y' ) .' All rights reserved.</small></p>' . PHP_EOL;
		    $xml .= '<p><small><a href="https://thechels.co.uk/rss-feeds/" target="_blank">Get more feeds</a>
				| <a href="https://m.TheChels.uk/" target="_blank">App</a>
				| <a href="https://github.com/ChelseaStats/Issues/issues/new/">Report Issues</a>
				| <a href="https://TheChels.co.uk/sponsorship" target="_blank">Sponsor Us</a></small></p>'.PHP_EOL;
		    $xml .= '<p><small><a href="https://thechels.co.uk/support/">ChelseaStats is supported by readers like you, click here to help out</a>.</small></p>'.PHP_EOL;
		    $xml .= '</footer>]]></description>' . PHP_EOL;
	        $xml .= '<guid>http://thechels.co.uk/rss-feeds/?#' . $rand . '</guid>' . PHP_EOL;
	        $xml .= '</item></channel></rss>';
	        print trim( $xml );
	    }

	    /**
	     * Creates WordPress post
	     *
	     * @param  void
	     * @return string $post_id
	     */
	    function cfc_CreateOtdPost() {

	        $otd_content = '[otd]
					[dyk]Something Something[/dyk]';

	        $date       = date( 'Y-m-d' );
	        $post_array = array (
	            'post_title'    => 'On This Day ' . $date,
	            'post_name'     => 'on-this-day-' . $date,
	            'post_content'  => $otd_content,
	            'post_author'   => 1,
	            'post_category' => array ( '1' )
	        );
	        // Insert the post into the database
	        $post_id = wp_insert_post( $post_array );

	        return $post_id;
	    }

	    /**
	     * Creates WordPress post
	     *
	     * @return string $post_id
	     */
	    function cfc_CreateThreePointsPost() {

	        $three_points_content = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/3pts_master.gif" alt="Three Points" />
									<h3>1: Three Points</h3>
									<p>Something a bit different, three things every week - for the weekend. Mostly thoughts,
									stats, things of interest, things off topic and probably a vine too in a usually short
									format post. Comments and questions welcome just tweet @ChelseaStats using #3points
									to get your link or question features.</p>
									<p>Recommended reading/watching:</p>
									<ul>
									<li><a title="#" href="#">#</a></li>
									<li><a title="#" href="#">#</a></li>
									<li><a title="#" href="#">#</a></li>
									</ul>
									<h3>2:</h3>
									<p>2</p>
									<h3>3:</h3>
									<p>3</p>';

	        $date       = date( 'Y-m-d' );
	        $post_array = array (
	            'post_title'    => 'Three Points',
	            'post_name'     => 'three-points-' . $date,
	            'post_content'  => $three_points_content,
	            'post_author'   => 1,
	            'post_category' => array ( '1' )
	        );
	        // Insert the post into the database
	        $post_id = wp_insert_post( $post_array );

	        return $post_id;
	    }

	    /**
	     * Creates WordPress post needs gameweek and opponent
	     * @param  string $gw
	     * @param  string $ssn
	     * @param  string $oppo
	     * @return string $post_id
	     */
	    function cfc_CreateRatingsPost( $gw, $ssn, $oppo ) {

		    $home       = site_url();
	        $post_array = array (
	            'post_title'   => "Gameweek {$gw} {$ssn}: Player Ratings - Chelsea vs {$oppo}",
	            'post_name'    => "Gameweek-{$gw}-{$ssn}-Player-Ratings-Chelsea-vs-{$oppo}",
	            'post_content' => "<img class='aligncenter size-full wp-image-4685' src='{$home}/media/uploads/ratings_master_thin.gif' alt='Premier League' />
									<p>players</p><p><i>based on nothing but my opinion</i>.</p>",
	            'post_type'    => "feeders"
	        );
	        // Insert the post into the database
	        $post_id = wp_insert_post( $post_array );

	        return $post_id;
	    }

	    /**
	     * Creates WordPress post
	     *
	     * @param  void
	     * @return string $markup
	     */
	    function get_plcc() {
	        // Premier League Chance Conversion Content
	        $markup = "[plcc]";
	        //================================================================================
	        $sql = "SELECT F_NAME as N_NAME, sum(F_SHOTS) as F_SHOTS, sum(F_SHOTSON) as F_SHOTSON,
								  COALESCE(ROUND(((sum(F_SHOTSON)/sum(F_SHOTS))*100),2),'N/A') AS F_SHOTACC, sum(F_GOALS) as F_GOALS,
								  COALESCE(ROUND(((sum(F_GOALS)/sum(F_SHOTS))*100),2),'N/A') AS F_GOALCON
								  FROM cfc_fixtures_players a, cfc_fixtures b, 000_config c
								  WHERE a.F_GAMEID=b.F_ID AND b.F_COMPETITION='PREM' AND b.F_DATE > c.F_DATE AND c.F_LEAGUE = 'PL'
								  GROUP BY F_NAME ORDER BY SUM(F_GOALS) DESC";
	        $markup .= returnDataTable( $sql, 'PLCC' );

	        return $markup;
	    }

	    /**
	     * Creates WordPress post
	     *
	     * @param  void
	     * @return string $markup
	     */
	    function get_MgrCompare() {

	        //==============================================================================
	        $pdo = new pdodb();
	        $pdo->query( "SELECT count(*) as GT FROM cfc_fixtures a, cfc_managers b where a.F_DATE >= b.F_SDATE and a.F_DATE <= b.F_EDATE  and a.F_COMPETITION='PREM' and F_ORDER = (select max(F_ORDER) from cfc_managers)" );
	        $row   = $pdo->row();
	        $limit = $row['GT'];

	        if ( ! isset( $limit ) ) : $limit = '500'; endif;
	        //==============================================================================

	        $markup = "[firstxgames]";

	        $sql = "SELECT SNAME AS N_MGR, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS,
				      SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
				      round(sum((W*3)+(D))/sum(PLD),3) PPG,
				      SUM(W*3)+(D) PTS
				FROM
				(
				SELECT F_ORDER, F_SNAME AS SNAME,
				COUNT(F_SNAME) AS PLD,
				SUM(IF(F_RESULT='W',1,0)=1) W,
				SUM(IF(F_RESULT='D',1,0)=1) D,
				SUM(IF(F_RESULT='L',1,0)=1) L,
				SUM(IF(F_FOR=0,1,0)=1) FS,
				SUM(IF(F_AGAINST=0,1,0)=1) CS,
				SUM(F_FOR) F,
				SUM(F_AGAINST) A,
				SUM(F_FOR-F_AGAINST) GD
				FROM
				(
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='19' ORDER BY A.F_DATE ASC LIMIT 0,$limit)
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='20' ORDER BY A.F_DATE ASC LIMIT 0,$limit)
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='21' ORDER BY A.F_DATE ASC LIMIT 0,$limit)
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='22' ORDER BY A.F_DATE ASC LIMIT 0,$limit)
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='23' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='24' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='25' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='26' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='27' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='28' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='29' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='30' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='31' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='32' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='33' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='34' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='35' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='36' ORDER BY A.F_DATE ASC LIMIT 0,$limit )
	
				) b
				GROUP BY F_ORDER, F_SNAME
				) a
				GROUP BY F_ORDER, SNAME
				ORDER BY PPG DESC, PTS DESC, GD DESC, SNAME DESC";

	        $markup .= returnDataTable( $sql, 'Total TSO League' );
	        $markup .= "[lastxgames]";


	        $sql = "SELECT SNAME AS N_MGR, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS,
				      SUM(CS) CS, SUM(F) F, SUM(A) A, SUM(GD) GD,
				      round(sum((W*3)+(D))/sum(PLD),3) PPG,
				      SUM(W*3)+(D) PTS
				FROM
				(
				SELECT F_ORDER, F_SNAME AS SNAME,
				COUNT(F_SNAME) AS PLD,
				SUM(IF(F_RESULT='W',1,0)=1) W,
				SUM(IF(F_RESULT='D',1,0)=1) D,
				SUM(IF(F_RESULT='L',1,0)=1) L,
				SUM(IF(F_FOR=0,1,0)=1) FS,
				SUM(IF(F_AGAINST=0,1,0)=1) CS,
				SUM(F_FOR) F,
				SUM(F_AGAINST) A,
				SUM(F_FOR-F_AGAINST) GD
				FROM
				(
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='19' ORDER BY A.F_DATE DESC LIMIT 0,$limit)
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='20' ORDER BY A.F_DATE DESC LIMIT 0,$limit)
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='21' ORDER BY A.F_DATE DESC LIMIT 0,$limit)
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='22' ORDER BY A.F_DATE DESC LIMIT 0,$limit)
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='23' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='24' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='25' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='26' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='27' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='28' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='29' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='30' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='31' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='32' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='33' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='34' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='35' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				UNION ALL
				( SELECT B.F_ORDER, B.F_SNAME, A.F_RESULT, A.F_FOR, A.F_AGAINST FROM cfc_fixtures A, cfc_managers B WHERE A.F_DATE >= B.F_SDATE AND A.F_DATE <= B.F_EDATE AND A.F_COMPETITION='PREM' AND F_ORDER='36' ORDER BY A.F_DATE DESC LIMIT 0,$limit )
				) b
				GROUP BY F_ORDER, F_SNAME
				) a
				GROUP BY F_ORDER, SNAME
				ORDER BY PPG DESC, PTS DESC, GD DESC, SNAME DESC";

	        $markup .= returnDataTable( $sql, 'Total TSO League' );

	        return $markup;
	    }

	    /**
	     * Creates WordPress post
	     *
	     * @param  void
	     * @return string $markup
	     */
	    function get_production90() {

	        $markup = "[prod]";

	        //================================================================================
	        $sql = "SELECT F_NAME as N_NAME, F_GOALS as F90_G, F_ASSISTS as F90_A, F_MINS as F90_M, GP90, AP90, PP90 as ALLP90 FROM 0V_base_Per90s order by PP90 desc";
	        //================================================================================

	        $markup .= returnDataTable( $sql, 'Prod90' );

	        return $markup;
	    }

	    /**
	     * Creates a WordPress post
	     *
	     * @param  void
	     * @return string $markup
	     */
	    function get_ResultsByStart() {

	        $markup = "[crps]";
	        $markup .= "<p>The table is sorted by highest points per game returned and then by name.</p>";
	        //================================================================================
	        $sql = "SELECT a.F_NAME AS N_NAME,
					SUM(CASE WHEN F_RESULT='W' THEN 1 ELSE 0 END) as W, SUM(CASE WHEN F_RESULT='D' THEN 1 ELSE 0 END) as D, SUM(CASE WHEN F_RESULT='L' THEN 1 ELSE 0 END) as L,
					ROUND((SUM(CASE WHEN F_RESULT='W' THEN 1 ELSE 0 END)/SUM(CASE WHEN F_RESULT<>'T' THEN 1 ELSE 0 END))*100,3) AS F_WINPER,
					ROUND((SUM(CASE WHEN F_RESULT='D' THEN 1 ELSE 0 END)/SUM(CASE WHEN F_RESULT<>'T' THEN 1 ELSE 0 END))*100,3) AS F_DRAWPER,
					ROUND((SUM(CASE WHEN F_RESULT='L' THEN 1 ELSE 0 END)/SUM(CASE WHEN F_RESULT<>'T' THEN 1 ELSE 0 END))*100,3) AS F_LOSSPER,
					((SUM(CASE WHEN F_RESULT='W' THEN 3 ELSE 0 END)+SUM(CASE WHEN F_RESULT='D' THEN 1 ELSE 0 END))/SUM(CASE WHEN F_RESULT<>'T' THEN 1 ELSE 0 END)) AS F_PPG,
					SUM(F_FOR) as F_FOR, SUM(F_AGAINST) AS F_AGAINST,
					ROUND((SUM(F_FOR)    /SUM(CASE WHEN F_RESULT<>'T' THEN 1 ELSE 0 END)),3) AS F_GFPG,
					ROUND((SUM(F_AGAINST)/SUM(CASE WHEN F_RESULT<>'T' THEN 1 ELSE 0 END)),3) AS F_GAPG
					FROM cfc_fixtures_players a, cfc_fixtures b
					WHERE a.F_GAMEID=b.F_ID AND a.F_DATE > (select F_DATE from 000_config WHERE F_LEAGUE='PL')
					AND b.F_COMPETITION='PREM' AND a.F_APPS='1'
					GROUP BY a.F_NAME ORDER BY F_PPG DESC, N_NAME DESC";
	        //================================================================================

	        $markup .= returnDataTable( $sql, 'winners' );

	        return $markup;
	    }

	    /**
	     * Creates a WordPress post
	     *
	     * @param  void
	     * @return string $markup
	     */
	    function get_SubPerf() {

	        $markup = "[subsperf]";
	        //================================================================================
	        $sql="select F_NAME, F_MINS, F_SHOTS, F_SHOTSON, F_GOALS, F_ASSISTS, PLD, round(F_MINS/PLD,0) as AvgMins from 0v_analysis_subs_this order by F_MINS DESC";
	        //================================================================================

	        $markup .= returnDataTable( $sql, 'subsperf' );

	        return $markup;
	    }

	    /**
	     * Creates a WordPress post
	     *
	     * @param  void
	     * @return string $markup
	     */
	    function get_StatsRoundup() {

	        $R = '';

	        $pdo = new pdodb();
	        $pdo->query( "SELECT F_HOME, F_HGOALS, F_AGOALS, F_AWAY, F_DATE FROM all_results WHERE (F_HOME='CHELSEA' OR F_AWAY='CHELSEA') ORDER BY F_DATE DESC LIMIT 0,1" );
	        $row = $pdo->row();
	        $H   = $row['F_HOME'];
	        $A   = $row['F_AWAY'];
	        $HG  = $row['F_HGOALS'];
	        $AG  = $row['F_AGOALS'];
	        if ( $HG > $AG && $H === 'CHELSEA' ) {
	            $R = 'won';
	        }
	        if ( $HG > $AG && $A === 'CHELSEA' ) {
	            $R = 'lost';
	        }
	        if ( $HG < $AG && $H === 'CHELSEA' ) {
	            $R = 'lost';
	        }
	        if ( $HG < $AG && $A === 'CHELSEA' ) {
	            $R = 'won';
	        }
	        if ( $HG === $AG ) {
	            $R = 'drew';
	        }
	        if ( $H === 'CHELSEA' ) {
	            $loc = 'at home';
	            $opp = $A;
	            $G1  = $HG;
	            $G2  = $AG;
	        } else {
	            $loc = 'away';
	            $opp = $H;
	            $G1  = $AG;
	            $G2  = $HG;
	        }

		    $publishable_opp = $this->_V($opp);

	        $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/roundup_master.gif" alt="Stats Roundup" />';
	        $markup .= "<h3>Chelsea $R $G1-$G2 $loc vs $publishable_opp in the Premier League.</h3>";
	        $markup .= "<ul>";

	        $pdo = new pdodb();
	        if ( $loc === 'at home' ) {
	            $pdo->query( "SELECT COUNT(*) as CNT FROM all_results WHERE F_HGOALS=:HG AND F_AGOALS=:AG AND F_HOME = 'CHELSEA' GROUP BY F_HGOALS, F_AGOALS" );
	            $pdo->bind( ':HG', $HG );
	            $pdo->bind( ':AG', $AG );
	            $row = $pdo->row();

	        } else {
	            $pdo->query( "SELECT COUNT(*) as CNT FROM all_results WHERE F_HGOALS=:HG AND F_AGOALS=:AG AND F_AWAY = 'CHELSEA' GROUP BY F_HGOALS, F_AGOALS" );
	            $pdo->bind( ':HG', $HG );
	            $pdo->bind( ':AG', $AG );
	            $row = $pdo->row();
	        }

	        $i = $this->numsuffix( $row['CNT'] );
	        $markup .= "<li>It is the <b>$i</b> time Chelsea $R $G1-$G2 $loc in the history of the Premier League.</li>";
	        /********************************************************************************************************************/
	        $pdo = new pdodb();
	        $pdo->query( "SELECT COUNT(*) as CNT FROM all_results WHERE F_HGOALS=:HG AND F_AGOALS=:AG GROUP BY F_HGOALS, F_AGOALS" );
	        $pdo->bind( ':HG', $HG );
	        $pdo->bind( ':AG', $AG );
	        $row = $pdo->row();
	        $CNT = $row['CNT'];
	        $i   = $this->numsuffix( $CNT );
	        $markup .= "<li>It is the <b>$i</b> time any team has $R $G1-$G2 $loc in the history of the Premier League.</li>";


	        /********************************************************************************************************************/
	        $pdo = new pdodb();
	        $pdo->query( "SELECT F_HGOALS, F_AGOALS, COUNT(*) as CNT FROM all_results WHERE F_HGOALS=:HG
						         AND F_AGOALS=:AG AND F_DATE > ( SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
						         GROUP BY F_HGOALS, F_AGOALS" );
	        $pdo->bind( ':HG', $HG );
	        $pdo->bind( ':AG', $AG );
	        $row = $pdo->row();
	        $CNT = $row['CNT'];
	        $i   = $this->numsuffix( $CNT );
	        $markup .= "<li>It is the <b>$i</b> time any team has $R $G1-$G2 $loc in the Premier League this season.</li>" . PHP_EOL;
	        $markup .= "</ul>" . PHP_EOL;

		    $markup .= "<h3>League Summary - results</h3>";
		    $markup .= "<ul>" . PHP_EOL;
		    $s = new summaries();
		        $messages = $s->plThisSeason();
		        foreach($messages as $message) {
		        	$markup .= "<li>{$message}</li>";
		        }
		    $markup .= "</ul>" . PHP_EOL;

		    $markup .= "<h3>League Summary - scoring first</h3>";
		    $markup .= "<ul>" . PHP_EOL;
		    $s = new summaries();
		    $messages = $s->plScoringFirst();
		    foreach($messages as $message) {
			    $markup .= "<li>{$message}</li>";
		    }
		    $markup .= "</ul>" . PHP_EOL;

		    $markup .= "<h3>League Summary - winning at half time</h3>";
		    $markup .= "<ul>" . PHP_EOL;
		    $s = new summaries();
		    $messages = $s->plWinningHalfTime();
		    foreach($messages as $message) {
			    $markup .= "<li>{$message}</li>";
		    }
		    $markup .= "</ul>" . PHP_EOL;

	        $markup .= "<h3>Current Form Overall</h3>" . PHP_EOL;
	        $markup .= "<ul>" . PHP_EOL;
	        /********************************************************************************************************************/
	        $pdo = new pdodb();
	        $pdo->query( "SELECT SUM(IF(F_RESULT='W'=1,1,0)) AS W, SUM(IF(F_RESULT='D'=1,1,0)) AS D, SUM(IF(F_RESULT='L'=1,1,0)) AS L,
			                    ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS WP,
			                    ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS DP,
			                    ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS LP
			                    FROM (SELECT F_RESULT FROM cfc_fixtures a WHERE F_COMPETITION='PREM' ORDER BY F_DATE DESC LIMIT 6) a" );
	        $row = $pdo->row();
	        $W   = $row["W"];
	        $WP  = $row["WP"];
	        $D   = $row["D"];
	        $DP  = $row["DP"];
	        $L   = $row["L"];
	        $LP  = $row["LP"];
	        $markup .= "<li>Chelsea are now <b>W$W</b> ($WP%), <b>D$D</b> ($DP%) and <b>L$L</b> ($LP%)  from the last 6 games in the Premier League.</li>" . PHP_EOL;


	        /********************************************************************************************************************/
	        $pdo = new pdodb();
	        $pdo->query( "SELECT SUM(IF(F_RESULT='W'=1,1,0)) AS W, SUM(IF(F_RESULT='D'=1,1,0)) AS D, SUM(IF(F_RESULT='L'=1,1,0)) AS L,
			                    ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS WP,
			                    ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS DP,
			                    ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS LP
			                    FROM (SELECT F_RESULT FROM cfc_fixtures a WHERE F_COMPETITION='PREM' ORDER BY F_DATE DESC LIMIT 10) a" );
	        $row = $pdo->row();
	        $W   = $row["W"];
	        $WP  = $row["WP"];
	        $D   = $row["D"];
	        $DP  = $row["DP"];
	        $L   = $row["L"];
	        $LP  = $row["LP"];
	        $markup .= "<li>Chelsea are now <b>W$W</b> ($WP%), <b>D$D</b> ($DP%) and <b>L$L</b> ($LP%) from the last 10 games in the Premier League.</li>" . PHP_EOL;


	        /********************************************************************************************************************/
	        $pdo = new pdodb();
	        $pdo->query( "SELECT SUM(IF(F_RESULT='W'=1,1,0)) AS W, SUM(IF(F_RESULT='D'=1,1,0)) AS D, SUM(IF(F_RESULT='L'=1,1,0)) AS L,
			             ROUND(SUM(IF(F_RESULT='W'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS WP,
						 ROUND(SUM(IF(F_RESULT='D'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS DP,
			             ROUND(SUM(IF(F_RESULT='L'=1,1,0))/SUM(IF(F_RESULT IS NOT NULL=1,1,0))*100,2) AS LP
			             FROM (SELECT F_RESULT FROM cfc_fixtures a WHERE F_COMPETITION='PREM' ORDER BY F_DATE DESC LIMIT 38) a" );
	        $row = $pdo->row();
	        $W   = $row["W"];
	        $WP  = $row["WP"];
	        $D   = $row["D"];
	        $DP  = $row["DP"];
	        $L   = $row["L"];
	        $LP  = $row["LP"];
	        $markup .= "<li>Chelsea are now <b>W$W</b> ($WP%), <b>D$D</b> ($DP%) and <b>L$L</b> ($LP%) from the last 38 games in the Premier League.</li>" . PHP_EOL;

	        $markup .= "</ul>" . PHP_EOL;
	        $markup .= "<h3>Last 10 Results in all competitions</h3>" . PHP_EOL;

	        $markup .= '<table class="tablesorter"><thead><tr><th>Team</th><th>Date</th><th>Competition</th><th>Loc</th>
						<th>Result</th><th>F</th><th>A</th><th>Att</th><th>Ref</th></tr></thead><tbody>' . PHP_EOL;

	        $pdo = new pdodb();
	        $pdo->query( "SELECT F_OPP as F_TEAM, F_DATE, F_COMPETITION, F_LOCATION, F_RESULT, F_FOR, F_AGAINST, F_ATT, F_REF FROM cfc_fixtures ORDER BY F_DATE DESC LIMIT 10" );
	        $rows = $pdo->rows();
	        foreach ( $rows as $row ) {
	            $res_1 = $this->_V( $row['F_TEAM'] );
	            $res_2 = $row['F_DATE'];
	            $res_3 = $row['F_COMPETITION'];
	            $res_4 = $row['F_LOCATION'];
	            $res_5 = $row['F_RESULT'];
	            $res_6 = $row['F_FOR'];
	            $res_7 = $row['F_AGAINST'];
	            $res_8 = $row['F_ATT'];
	            $res_9 = $row['F_REF'];


	            $markup .= '<tr><td>' . $res_1 . '</td><td>' . $res_2 . '</td><td>' . $res_3 . '</td><td>' . $res_4 . '</td><td>' . $res_5 . '</td>
								<td>' . $res_6 . '</td><td>' . $res_7 . '</td><td>' . $res_8 . '</td><td>' . $res_9 . '</td></tr>' . PHP_EOL;
	        }

	        $markup .= '</tbody></table>' . PHP_EOL;

	        $markup .= "<h3>Records vs Big 7 and Threatened 13 teams</h3>" . PHP_EOL;
	        $markup .= "<p>This season's record against the groups - for more information on these groupings see <a href='https://thechels.co.uk/the-big-seven-league/'>Big7</a> 
								and <a href='https://thechels.co.uk/threatened-13/'>T13</a></p>" . PHP_EOL;

	        $markup .= "<ul>" . PHP_EOL;
	        /********************************************************************************************************************/
	        $pdo = new pdodb();
	        $pdo->query( "SELECT SUM(W) AS W, SUM(D) AS D, SUM(L) AS L, ROUND((SUM(W)/SUM(PLD))*100,2) AS WP, ROUND((SUM(D)/SUM(PLD))*100,2) AS DP, ROUND((SUM(L)/SUM(PLD))*100,2) AS LP, count(*) as GP
			                     FROM 0V_base_BIG_this a WHERE TEAM='CHELSEA' " );
	        $row = $pdo->row();
	        $W   = $row["W"];
	        $WP  = $row["WP"];
	        $D   = $row["D"];
	        $DP  = $row["DP"];
	        $L   = $row["L"];
	        $LP  = $row["LP"];
		    $GP  = $row['GP'];
		    if($GP > 0) {
			    $markup .= "<li>Chelsea are <b>W$W</b> ($WP%), <b>D$D</b> ($DP%) and <b>L$L</b> ($LP%) against the <a href='https://thechels.co.uk/glossary'>Big 7</a> teams in the Premier League.</li>" . PHP_EOL;
		    } else {
			    $markup .= "<li>Chelsea are yet to play against a <a href='https://thechels.co.uk/glossary'>Big 7</a> teams in the Premier League this season..</li>" . PHP_EOL;
		    }

		    $pdo = new pdodb();
	        $pdo->query( "SELECT SUM(W) AS W, SUM(D) AS D, SUM(L) AS L, ROUND((SUM(W)/SUM(PLD))*100,2) AS WP, ROUND((SUM(D)/SUM(PLD))*100,2) AS DP, ROUND((SUM(L)/SUM(PLD))*100,2) AS LP, count(*) as GP
								 FROM 0V_base_PRJ_this WHERE TEAM='CHELSEA'" );
	        $row = $pdo->row();
	        $W   = $row["W"];
	        $WP  = $row["WP"];
	        $D   = $row["D"];
	        $DP  = $row["DP"];
	        $L   = $row["L"];
	        $LP  = $row["LP"];
		    $GP  = $row['GP'];
		    if($GP > 0) {
	            $markup .= "<li>Chelsea are <b>W$W</b> ($WP%), <b>D$D</b> ($DP%) and <b>L$L</b> ($LP%) against the <a href='https://thechels.co.uk/glossary'>T 13</a> teams in the Premier League.</li>" . PHP_EOL;
		    } else {
			    $markup .= "<li>Chelsea are yet to play against a <a href='https://thechels.co.uk/glossary'>T 13</a> teams in the Premier League this season..</li>" . PHP_EOL;
		    }

		    $markup .= "</ul>" . PHP_EOL;
	        /********************************************************************************************************************/
	        $markup .= "<h3>Attainable milestones</h3>" . PHP_EOL;
	        $markup .= "<p>Various milestones of 25,50,100 etc when available</p>" . PHP_EOL;
	        $markup .= "<ul>" . PHP_EOL;
	        /********************************************************************************************************************/
	        $pdo = new pdodb();
	        $pdo->query( "SELECT  N ,  C ,  L ,  D ,  V  FROM  0t_miles WHERE  N =  'chelsea'" );
	        $rows = $pdo->rows();
	        foreach ( $rows as $row ) {
	            $C = $row['C'];
	            $L = $row['L'];
	            $D = $row['D'];
	            $V = $row['V'];
	            $markup .= "<li>Chelsea $C $L $D $V</li>" . PHP_EOL;
	        } // endwhile
	        $markup .= "</ul>" . PHP_EOL;

	        /********************************************************************************************************************/
	        $markup .= "<h3>10 Recent Stats</h3>" . PHP_EOL;
	        $markup .= "<ul>" . PHP_EOL;
	        /********************************************************************************************************************/
	        $pdo = new pdodb();
	        $pdo->query( "SELECT F_DATE as C, F_TEXT as V, F_AUTHOR as S from o_appstats order by F_ID desc limit 10" );
	        $rows = $pdo->rows();
	        foreach ( $rows as $row ) {
	            $C = date( "Y-m-d", strtotime( $row['C'] ) );
	            $V = $row['V'];
	            $S = $row['S'];
	            $markup .= "<li>$V  <br/><small>[dated: $C  Source @$S]</small></li>" . PHP_EOL;
	        } // endwhile
	        $markup .= "</ul>" . PHP_EOL;
	        $markup .= "<h3>Last 10 Premier League Results</h3>" . PHP_EOL;

	        $markup .= '<table class="tablesorter"><thead><tr><th>Date</th><th>Home</th><th>Home Goals</th><th>Away Goals</th><th>Away</th></tr></thead><tbody>' . PHP_EOL;

	        $pdo = new pdodb();
	        $pdo->query( "SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results
							 WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL') ORDER BY F_ID DESC LIMIT 10" );
	        $rows = $pdo->rows();
	        foreach ( $rows as $row ) {
	            $res_date = $row['N_DATE'];
	            $res_h    = $this->_V( $row['H_TEAM'] );
	            $res_hg   = $row['HG'];
	            $res_ag   = $row['AG'];
	            $res_a    = $this->_V( $row['A_TEAM'] );

	            $markup .= '<tr><td>' . $res_date . '</td><td>' . $res_h . '</td><td>' . $res_hg . '</td><td>' . $res_ag . '</td><td>' . $res_a . '</td></tr>' . PHP_EOL;
	        }

	        $markup .= '</tbody></table>' . PHP_EOL;

	        return $markup;
	    }

	    /**
	     * creates draft WordPress league tables
	     * @param  string $table
	     * @return string $markup
	     */
	    function get_drafter_table( $table ) {

	        switch ( $table ) {
	            case 'pl' :
	                $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/pl_master.gif" alt="Premier League" />';
	                $markup .= '<h3>Premier League table - This Season</h3>';
	                $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	                        SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	                        FROM 0V_base_PL_this
	                        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team ASC";
	                $markup .= returnDataTable( $sql, 'pl' );
	                $markup .= '<h3>Last 10 results</h3>';
	                $sql = "SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results WHERE
	                        F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
	                        ORDER BY F_ID DESC LIMIT 10";
	                $markup .= returnDataTable( $sql, 'small' );
	                break;
		        case 'fouls' :
			        $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/fouls_master.gif" alt="Premier League Fouls and Cards" />';
			        $markup .= "<p>Making an assumption that all cards are even, come only from fouls and all fouls are equal, the following table looks at whether 
								teams are treated fairly by officials and if a team is fouled more often or are dirtier than others.</p>";
			        $markup .= '<h3>Premier League fouls and cards table - This Season</h3>';
			        $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, 
								SUM(F_FOULS) F,
								SUM(A_FOULS) A, 
								SUM(F_CARDS) Booked, 
								SUM(A_CARDS) OppoBooked, 
								round(sum(F_FOULS)/sum(PLD),3) CommPG, 
								round(sum(A_FOULS)/sum(PLD),3) suffPG,
								round(((sum(F_CARDS)/sum(F_FOULS))*100),3) CardsPerFor,
								round(((sum(A_CARDS)/sum(A_FOULS))*100),3) CardsPerAgg,
								round(((sum(F_CARDS)/sum(F_FOULS))*100),3) - round(((sum(A_CARDS)/sum(A_FOULS))*100),3) as FoulDiff
								FROM 0V_base_Fouls_this
	                            group by Team 
								union all
								SELECT 'League Avg' as N_NAME, SUM(PLD) PLD, 
								SUM(F_FOULS) F,
								SUM(A_FOULS) A, 
								SUM(F_CARDS) Booked, 
								SUM(A_CARDS) OppoBooked, 
								round(sum(F_FOULS)/sum(PLD),3) CommPG, 
								round(sum(A_FOULS)/sum(PLD),3) suffPG,
								round(((sum(F_CARDS)/sum(F_FOULS))*100),3) CardsPerFor,
								round(((sum(A_CARDS)/sum(A_FOULS))*100),3) CardsPerAgg,
	                            round(((sum(F_CARDS)/sum(F_FOULS))*100),3) - round(((sum(A_CARDS)/sum(A_FOULS))*100),3) as FoulDiff
								FROM 0V_base_Fouls_this
	                            ORDER BY  FoulDiff DESC, N_NAME ASC";
			        $markup .= returnDataTable( $sql, 'pl' );
			        $markup .= '<h3>Last 10 results</h3>';
			        $sql = "SELECT F_DATE as N_DATE, F_HOME H_TEAM, H_FOULS HG, A_FOULS AG, F_AWAY A_TEAM FROM o_tempFootballData201617 WHERE
	                        F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
	                        ORDER BY F_ID DESC LIMIT 10";
			        $markup .= returnDataTable( $sql, 'small' );
			        break;
		        case 'fancy' :
			        $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/fancy_master.gif" alt="Premier League Fancy Advanced Stats" />';
			        $markup .= '<h3>Advanced Stats - This Season</h3>';
			        $markup .= "[fancystats]";
			        $sql = "SELECT a.Team as N_NAME,
							round(SUM(b.F)/(SUM(b.F)+SUM(b.A)),3) AS TSR,
					        round(SUM(c.F)/(SUM(c.F)+SUM(c.A)),3) AS SOTR,
					        d.h_PDO AS PDO
	                        FROM 0V_base_PL_this a, 0V_base_Shots_this b, 0V_base_Shots_on_this c, 0V_base_pdo_this d
	                        WHERE a.Team = b.Team AND b.Team = c.Team AND c.Team = d.Team
	                        GROUP BY a.Team ORDER BY PDO DESC, SOTR DESC, TSR DESC";
			        $markup .= returnDataTable( $sql, 'small' );
			        $markup .= '<h3>Last 10 results</h3>';
			        $sql = "SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results WHERE
	                        F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
	                        ORDER BY F_ID DESC LIMIT 10";
			        $markup .= returnDataTable( $sql, 'small' );
			        break;
		        case 'shots' :
			        $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/shots_master.gif" alt="Premier League" />';
					$markup .= '[shotsleague]';
			        $markup .= '<h3>Premier League table - This Season</h3>';
			        $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	                        SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	                        FROM 0V_base_Shots_this
	                        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team ASC";
			        $markup .= returnDataTable( $sql, 'pl' );
			        $markup .= '<h3>Last 10 results</h3>';
			        $sql = "SELECT F_DATE as N_DATE, F_HOME H_TEAM, H_SHOTS HG, A_SHOTS AG, F_AWAY A_TEAM FROM o_tempFootballData201617 WHERE
	                        F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
	                        ORDER BY F_ID DESC LIMIT 10";
			        $markup .= returnDataTable( $sql, 'small' );
			        break;
		        case 'shotson' :
			        $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/shotson_master.gif" alt="Premier League" />';
			        $markup .= '[shotsonleague]';
			        $markup .= '<h3>Premier League table - This Season</h3>';
			        $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	                        SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	                        FROM 0V_base_Shots_on_this
	                        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team ASC";
			        $markup .= returnDataTable( $sql, 'pl' );
			        $markup .= '<h3>Last 10 results</h3>';
			        $sql = "SELECT F_DATE as N_DATE, F_HOME H_TEAM, H_SHOTS HG, A_SHOTS AG, F_AWAY A_TEAM FROM o_tempFootballData201617 WHERE
	                        F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='PL')
	                        ORDER BY F_ID DESC LIMIT 10";
			        $markup .= returnDataTable( $sql, 'small' );
			        break;
	            case 'ldn' :
	                $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/league_ldn_master.gif" alt="London League" />';
	                $markup .= '<h3>London Premier League - This Season</h3>';
	                $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
							SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM `0V_base_LDN_this`
	                        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team ASC";
	                $markup .= returnDataTable( $sql, 'ldn' );
	                $markup .= '<h3>All Time London Premier League</h3>';
	                $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A, SUM(GD) GD,
							round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_LDN
							GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team ASC";
	                $markup .= returnDataTable( $sql, 'ldn' );
	                break;
	            case 'last38' :
	                $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/league_last38_master.gif" alt="Last38 League" />';
	                $markup .= do_shortcode( '[last38]' );
	                $sql = "SELECT Team as N_NAME, PLD, W, D, L, FS, CS, BTTS, F, A, GD, PPG, PTS FROM 0V_base_last38_this
	                        ORDER BY PPG DESC, PTS DESC, GD DESC, Team ASC";
	                $markup .= returnDataTable( $sql, 'last38' );
	                break;
	            case 'big' :
	                $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/league_big7_master.gif" alt="Big Seven League" />';
	                $markup .= '<h3>Big 7 Premier League - This season</h3>';
	                $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	                    SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	                    FROM 0V_base_BIG_this
	                    GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team ASC";
	                $markup .= returnDataTable( $sql, 'big' );
	                $markup .= '<h3>All Time Big 7 Premier League</h3>';
	                $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	                    SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	                    FROM 0V_base_BIG
	                    GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team ASC";
	                $markup .= returnDataTable( $sql, 'big' );

	                break;
	            case 'ever' :
	                $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/league_ever6_master.gif" alt="Ever Six League" />';
	                $markup .= '<h3>Ever Present 6 Premier League - This Season</h3>';
	                $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	                        SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	                        FROM 0V_base_EVER_this
	                        GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team ASC";
	                $markup .= returnDataTable( $sql, 'ever' );
	                $markup .= '<h3>All Time Ever Present 6 Premier League</h3>';
	                $sql = "SELECT Team as N_NAME, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
	                        SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
	                        FROM 0V_base_EVER GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team ASC";
	                $markup .= returnDataTable( $sql, 'ever' );
	                break;
	            case 'pro' :
	                $markup = "[progress]";
	                $sql    = "select a.Team as N_NAME, a.PTS-b.PTS as PTS from 0V_base_ISG_totals a, 0V_base_ISG_totals b
								where a.Team = b.Team
								and a.Label = (select y.F_LABEL from meta_seasons y, 000_config z where y.F_SDATE = z.F_DATE and z.F_LEAGUE = 'PL')
								and b.Label = (select y.F_LABEL from meta_seasons y, 000_config z where y.F_SDATE = z.F_DATE and z.F_LEAGUE = 'PLm1')
								group by a.Team order by PTS desc";
	                $markup .= returnDataTable( $sql, 'Small' );
	                break;
		        case 'procfc' :
			        $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/league_profcfc_master.gif" alt="Comparable CFC Fixture League" />';
			        $markup .= "[procfc]";
			        $sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
						      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
						      FROM 0V_base_progress_cfc
						      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
			        $markup .= returnDataTable( $sql, 'full' );
			        break;
	            case 'cann' :
		            $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/league_cann_master.gif" alt="Cann Table" />';
	                $markup .= "[cann]";
	                $sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
						      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
						      FROM 0V_base_PL_this
						      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	                $dollar = returnDataTable( $sql, 'Small' );
	                $markup .= $this->CannNamStyle($dollar,'Points','12');
	                $markup .= "[cann-foot]";
	                break;
	            case 'goaldiff' :
		            $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/league_gdl_master.gif" alt="Goal Difference League" />';
	                $markup .= "[gdl]";
	                $sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
						      SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS
						      FROM 0V_base_PL_this
						      GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	                $dollar = returnDataTable( $sql, 'Small' );
	                $markup .= $this->CannNamStyle($dollar,'GD','10');
	                break;
	            case 'wsl' :
	                $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/wsl_master.gif" alt="WSL" />';
	                $markup .= '<h3>Women\'s Super League table - This Season</h3>';
	                $sql = "SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
			                    SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL1_this GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	                $markup .= returnDataTable( $sql, 'wsl' );
	                $markup .= '<h3>Last 10 results</h3>';
	                $sql = "SELECT F_DATE as N_DATE, F_HOME H_TEAM, F_HGOALS HG,F_AGOALS AG, F_AWAY A_TEAM FROM all_results_wsl_one
		                        WHERE F_DATE > (SELECT F_DATE FROM 000_config WHERE F_LEAGUE='WSL') ORDER BY F_ID DESC LIMIT 10";
	                $markup .= returnDataTable( $sql, 'small' );
	                break;
	            case 'wsl_cann' :
	                $markup = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/wsl_master.gif" alt="WSL" />';
	                $markup .= "[cann]";
	                $sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		                        SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL1_this GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	                $dollar = returnDataTable( $sql, 'Small' );
	                $markup .= $this->CannNamStyle($dollar,'Points','12');
	                $markup .= "[cann-foot]";
	                break;
	            case 'wsl_goaldiff' :
	                $markup  = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/wsl_master.gif" alt="WSL" />';
	                $markup .= "[gdl]";
	                $sql="SELECT Team, SUM(PLD) PLD, SUM(W) W, SUM(D) D, SUM(L) L, SUM(FS) FS, SUM(CS) CS, SUM(BTTS) BTTS, SUM(F) F, SUM(A) A,
		                        SUM(GD) GD, round(sum(PTS)/sum(PLD),3) PPG, SUM(PTS) PTS FROM 0V_base_WSL1_this GROUP BY Team ORDER BY PTS DESC, GD DESC, F DESC, Team DESC";
	                $dollar = returnDataTable( $sql, 'Small' );
	                $markup .= $this->CannNamStyle($dollar,'GD','10');
	                break;
	            case 'wslpro' :
		            $markup  = '<img class="aligncenter size-full wp-image-4685" src="'. site_url().'/media/uploads/wsl_master.gif" alt="WSL" />';
	                $markup .= "[progress_wsl]";
	                $sql    = "select a.Team as N_NAME, a.PTS-b.PTS as PTS from 0V_base_WSL_ISG_totals a, 0V_base_WSL_ISG_totals b
								where a.Team = b.Team
								and a.Label = (select year(F_DATE) from 000_config where F_LEAGUE = 'WSl')
								and b.Label = (select year(F_DATE) from 000_config where F_LEAGUE = 'WSlm1')
								group by a.Team order by PTS desc";
	                $markup .= returnDataTable( $sql, 'Small' );
	                break;
	            default:
	                $markup = '<h3>Error</h3>';
	                break;
	        }

	        return $markup;
	    }

		/**
		 * @return mixed
		 */
		function get_wsl_summary() {
			$wsl = new summaries();

			$arrays[] = "<h3>Results Summary</h3>";
			$arrays[] = $wsl->wslThisSeason();
			$arrays[] = "<h3>When Scoring First</h3>";
			$arrays[] = $wsl->wslScoringFirst();
			$arrays[] = "<h3>When Winning at Half Time</h3>";
			$arrays[] = $wsl->wslWinningHalfTime();
			$arrays[] = "<h3>When Losing at Half Time</h3>";
			$arrays[] = $wsl->wslLosingHalfTime();
			$arrays[] = "<h3>In History</h3>";
			$arrays[] = $wsl->wslHistory();

			$data = "<ul>";
			foreach($arrays as $messages) {
				foreach($messages as $message) {

					$data .= "<li>{$message}</li>";
				}

			}

			$data .= "</ul>";

			$data = str_replace('#FAWSL1','Fawsl One', $data);
			$data = str_replace('#FAWSL' ,'Fawsl One', $data);


			return $data;
	    }

		/**
		 * @param $ssn
		 * @param $gw
		 * @return string
		 */
		function get_shotsLocals($ssn, $gw) {

			$return = '[locals]'.PHP_EOL;
			$return .= '<img class="aligncenter size-full wp-image-4685" src="/media/uploads/gameShotLocals'.$ssn.'-gw'.$gw.'.png" alt="Game Shot Locations" />'.PHP_EOL;
			$return .= '<br/><br/>'.PHP_EOL;
			$return .= '<img class="aligncenter size-full wp-image-4685" src="/media/uploads/totalShotLocals'.$ssn.'-gw'.$gw.'.png" alt="Seasonal Shot Locations" />'.PHP_EOL;

			return $return;
		}

		/** Generate Shots Analysis post
		 * @param $oppo
		 * @param $gw
		 * @param $ssn
		 * @param $gameid
		 * @return string
		 */
		function get_shotsAnalysis($oppo, $gw, $ssn, $gameid) {

			$return = "[shotsanalysis]{$oppo}[/shotsanalysis]";

			$sql    = "SELECT '".$oppo."' as Team, F_A_ATTEMPTSOFF as F_SHOTS, F_A_ATTEMPTSON as F_SHOTSON, F_AGAINST as F_GOALS FROM cfc_fixtures where f_id = '".$gameid."'
					   UNION ALL
					   SELECT 'Chelsea' as Team, F_H_ATTEMPTSOFF as F_SHOTS, F_H_ATTEMPTSON as F_SHOTSON, F_FOR as F_GOALS FROM cfc_fixtures where f_id = '".$gameid."' ";

			$return .= returnDataTable( $sql, 'Small' );

			$return .= "<h3>Shot Locations</h3>".PHP_EOL;

			$return .= '<img class="aligncenter size-full wp-image-4685" src="/media/uploads/GameShotLocals'.$ssn.'-gw'.$gw.'.png" alt="Game Shot Locations" />'.PHP_EOL;

			$return .= "<h3>Shot Locations (Entire Premier League Season)</h3>".PHP_EOL;

			$return .= '<img class="aligncenter size-full wp-image-4685" src="/media/uploads/TotalShotLocals'.$ssn.'-gw'.$gw.'.png" alt="Seasonal Shot Locations" />'.PHP_EOL;

			$return .= "<h3>Shots Plus/Minus Flow</h3>";
			$return .= "<p>Mapping the games shots to a cumulative flow; Every Chelsea shot adds 1 to the running total, the opposition minus 1.</p>";

			$return .= "<img src='/media/uploads/Shotsflow2016-17-gw{$gw}.png' alt='shotsflow 2016-17 Gw{$gw}' />".PHP_EOL;

			$return .= "<h3>Cumulative shots by minute</h3>";

			$sql = "select (case f_club when 1 then 'Chelsea'
	                            else (select F_OPP from cfc_fixtures where F_ID = {$gameid} )
	                            END)
	                            as MIN_TEAM,
								0 							 as 'F00',
								sum(if(f_minute < 4 ,1,0)=1) as 'F05',
								sum(if(f_minute < 9 ,1,0)=1) as 'F10',
								sum(if(f_minute < 14,1,0)=1) as 'F15',
								sum(if(f_minute < 19,1,0)=1) as 'F20',
								sum(if(f_minute < 24,1,0)=1) as 'F25',
								sum(if(f_minute < 29,1,0)=1) as 'F30',
								sum(if(f_minute < 34,1,0)=1) as 'F35',
								sum(if(f_minute < 39,1,0)=1) as 'F40',
								sum(if(f_minute < 44,1,0)=1) as 'F45',
								sum(if(f_minute < 49,1,0)=1) as 'F50',
								sum(if(f_minute < 54,1,0)=1) as 'F55',
								sum(if(f_minute < 59,1,0)=1) as 'F60',
								sum(if(f_minute < 64,1,0)=1) as 'F65',
								sum(if(f_minute < 69,1,0)=1) as 'F70',
								sum(if(f_minute < 74,1,0)=1) as 'F75',
								sum(if(f_minute < 79,1,0)=1) as 'F80',
								sum(if(f_minute < 84,1,0)=1) as 'F85',
								sum(if(f_minute < 89,1,0)=1) as 'F90',
								sum(if(f_minute >  0,1,0)=1) as 'FFT'
								from cfc_fixtures_shots
								where F_GAMEID = '{$gameid}'
								group by f_club";
			$return .= returnDataTable( $sql, 'minutes' );


			$return .= "<h3>Cumulative shots by minute graph</h3>".PHP_EOL;
			$return .= "<p>The graph below shows our cumulative chances per minute per game compared to our opposition, this can be seen as a proxy for domination in the game and can help show how the game played out.".PHP_EOL;
			$return .= "<p>Dominance of course doesn't necessarily mean goals and points, see victory over Liverpool (0-2 away) and West Ham (0-0 home) in 2013-14 for two extremes.</p>".PHP_EOL;
			$return .= "<p>Chelsea are shown in blue and opponent, {$oppo}, in yellow.</p>".PHP_EOL;

			$return .= "<img src='/media/uploads/Ccbm2016-17-gw{$gw}.png' alt='cumulative chances by minute 2016-17 Gw{$gw}' />".PHP_EOL;

			return $return;
		}

		/** Generate Charts Analysis post
		 * @param $gw
		 * @param $ssn
		 * @return string
		 */
		function get_ChartAnalysis($gw, $ssn) {

			$return  = '<img class="aligncenter size-full wp-image-4685" src="/media/uploads/charts_master.gif" alt="Charts" />'.PHP_EOL;

			$return .= "[charts]";

			$return .= "<h3>Shots per game</h3>".PHP_EOL;
			$return .= "<p>Mapping team's shots per game, for vs against, in the Premier League this season</p>".PHP_EOL;
			$return .= '<img class="aligncenter size-full wp-image-4685" src="/media/uploads/analysisShots'.$ssn.'-gw'.$gw.'.png" alt="Shots per game" />'.PHP_EOL;

			$return .= "<h3>Shots on Target per game</h3>".PHP_EOL;
			$return .= "<p>Mapping team's shots on target per game, for vs against, in the Premier League this season</p>".PHP_EOL;
			$return .= '<img class="aligncenter size-full wp-image-4685" src="/media/uploads/analysisSOT'.$ssn.'-gw'.$gw.'.png" alt="Shots per game" />'.PHP_EOL;

			$return .= "<h3>Goals per game</h3>".PHP_EOL;
			$return .= "<p>Mapping team's goals per game, for vs against, in the Premier League this season</p>".PHP_EOL;
			$return .= '<img class="aligncenter size-full wp-image-4685" src="/media/uploads/analysisGPG'.$ssn.'-gw'.$gw.'.png" alt="Shots per game" />'.PHP_EOL;

			$return .= "<h3>Goal Ratio vs Shots On Target Ratio</h3>".PHP_EOL;
			$return .= "<ul><li>GR - goals for / (goals for + goals against)</li><li>SOTR - Shots on Target for / (Shots on Target For + Shots on Target Against)</li></ul>".PHP_EOL;
			$return .= '<img class="aligncenter size-full wp-image-4685" src="/media/uploads/analysisGRvSOTR'.$ssn.'-gw'.$gw.'.png" alt="Shots per game" />'.PHP_EOL;


			return $return;
		}

	    /**
	     * Creates a string for WordPress post
	     * @param  void
	     * @return string $return
	     */
	    function get_zone() {

	        $return = '<img src="'. site_url().'/media/uploads/tsz_master.gif" alt="The statszone - ChelseaStats" class="aligncenter size-full wp-image-4589" />';
	        $return .='[statsz]';

	        return $return;
	    }

	    /**
	     * Creates WordPress post linking articles published in last 7 days (25 limit)
	     * @param  string $date
	     * @return int $post_id
	     */
	    function cfc_create_weekly_post( $date ) {

	        $markup  = '<img src="'. site_url().'/media/uploads/weekly_master.gif" alt="The statszone - ChelseaStats" class="aligncenter size-full wp-image-4589" />';
	        $markup .= 'Here are all the things published this week. You can also stay up-to-date by following us on <a href="https://twitter.com/ChelseaStats/">Twitter</a> and a variety of <a href="'. site_url().'/rss-feeds/">RSS feeds</a>.';
	        $markup .= '<h3>Articles published in the last 7 days</h3>';
	        $markup .= '<ul>';

	        // query_posts('showposts=25');

	        $args = array(
	            'post_type' => array ( 'post', 'feeders','sponsors','fixes'),
	            'showposts' => 25,
	            'post_status' => array('publish', 'future')
	        );
	        query_posts($args);


	        while ( have_posts() ) : the_post();

	            $my_limit = 7 * 86400; // days * seconds per day
	            $post_age = date( 'U' ) - get_post_time( 'U' );
	            if ( $post_age < $my_limit ) {

	                $markup .= "<li><a href='".get_permalink()."' rel='bookmark'>".get_the_title()."</a></li>";
	            }
	        endwhile;

	        $markup .= '</ul>';
	        $markup .= '<p>If that is not enough for you, check out the <a href="https://thechels.co.uk/archive/">Archives</a> for all our historic articles.';


	        $post_array = array(
	            'post_title'		=> 'Weekly Roundup',
	            'post_name' 		=> 'Weekly-Roundup-'.$date,
	            'post_content'  	=> $markup,
	            'post_author'   	=> 1,
	            'post_category' 	=> array('1')
	        );
	        // Insert the post into the database
	        $post_id = wp_insert_post( $post_array );

	        return $post_id;

	    }

	    /**
	     * creates a WordPress post from some params
	     * @param  string $category
	     * @param  string $content
	     * @param  string $title
	     * @param  string $tags
	     * @return integer $post_id
	     */
	    function programmatically_create_post($category,$content,$title,$tags) {

	        // Initialize the page ID to -1. This indicates no action has been taken.
		    // $post_id = -1;

	        // If the page doesn't already exist, then create it
	        if( null == get_page_by_title( $title ) ) {

	            $content = str_replace('<div>','',$content);
	            $content = str_replace('</div>','',$content);


	            // Set the post ID so that we know the post was created successfully
	            $post_id = wp_insert_post(
	                array(
	                    'comment_status' => 'closed',
	                    'ping_status'	 => 'closed',
	                    'post_content'   => $content,
	                    'post_name'	     => $title,
	                    'post_title'	 => $title,
	                    'post_category'  => $category,
	                    'tags_input'	 => $tags,
	                    'post_type'	     => 'post'
	                    // 'post_author'	 =>	$author_id, defaults to current user (always only me)
	                    // 'post_status'	 =>	'draft', default is draft, which is cool
	                )
	            );

	            // Otherwise, we'll stop
	        } else {

	            // Arbitrarily use -2 to indicate that the page with the title already exists
	            $post_id = -2;

	        } // end if

	        return $post_id;
	    }

	    /**
	     * Validate an email address.
	     * @param  string $possible_email An email address to validate
	     * @return bool
	     */
	    public static function validate_email($possible_email) {
	        return (bool) filter_var($possible_email, FILTER_VALIDATE_EMAIL);
	    }

	    /**
	     * Return ordinal value of a number
	     * @param   integer $number
	     * @return  string
	     */
	    function ordinal($number) {
	        $test_c = abs($number) % 10;
	        $ext = ((abs($number) % 100 < 21 && abs($number) % 100 > 4) ? 'th' : (($test_c < 4) ? ($test_c < 3) ? ($test_c < 2) ? ($test_c < 1) ? 'th' : 'st' : 'nd' : 'rd' : 'th'));

	        return $number . $ext;
	    }

	    /**
	     * Returns friendly team names for horrible long ones
	     * @param  string $value
	     * @return string $value
	     */
	    function replaceTeamName($value)
	    {
	        $value=str_replace('_',' ',$value);
	        $value=strtolower($value);
	        $value=ucwords($value);
	        $value=str_replace('West Bromwich Albion','West Brom',$value);
	        $value=str_replace('Queens Park Rangers','QPR',$value);
	        $value=str_replace('Manchester','Man',$value);
	        $value=str_replace('Sheffield','Sheff',$value);
	        $value=str_replace('Tottenham Hotspur','Spurs',$value);
	        $value=str_replace('Tottenham','Spurs',$value);
		    $value=str_replace('United','Utd',$value);

	        return $value;
	    }

	    /**
	     * Returns even more wordy result from short competition value
	     * @param  string $i
	     * @return string $dollar
	     */
	    function comp($i)
	    {
	        if(isset($i) && $i!='') {
	            switch (strtoupper($i)) {
	                case 'FAC':
	                    $dollar =  "FA Cup";
	                    break;
	                case 'LC':
	                    $dollar =  "League Cup";
	                    break;
	                case 'UCL':
	                    $dollar =  "Champions League";
	                    break;
	                case 'CS':
	                    $dollar =  "Community Shield";
	                    break;
	                case 'PREM':
	                    $dollar =  "Premier League";
	                    break;
	                case 'ESC':
	                    $dollar =  "Super Cup";
	                    break;
	                case 'ALL':
	                    $dollar =  "in all competitions";
	                    break;
	                default:
	                    $dollar =  "game";
	            }
	        } else {
	            $dollar =  'unknown';
	        }

	        return $dollar;
	    }

	    /**
	     * Formats Referee name nicely (surname,first) -> First Surname
	     * @param  string $i
	     * @return string $i
	     */
	    function ref($i)
	    {
	        $i = preg_split("/[\s,]+/",$i);
	        $i = ucwords(strtolower($i[1]." ".$i[0]));
	        $i = ucwords($i);

	        return $i;
	    }

	    /**
	     * Returns even more wordy result from short location value
	     * @param  string $i
	     * @return string $dollar
	     */
	    function local($i)
	    {
	        if(isset($i) && $i!='') {
	            switch ($i) {
	                case 'N':
	                    $dollar = "On neutral soil";
	                    break;
	                case 'A':
	                    $dollar = "Away from home";
	                    break;
	                case 'H':
	                    $dollar = "At Stamford Bridge";
	                    break;
	                default :
	                    $dollar = "";
	            }
	        } else {

	            $dollar = 'unknown';
	        }

	        return $dollar;
	    }

	    /**
	     * Returns textual result from short location value
	     * @param  string $value
	     * @return string $loc
	     */
	    function getLoc($value) {

	        $loc = 'unknown';

	        if($value =='H') { $loc ='Home'; }
	        if($value =='A') { $loc ='Away'; }
	        if($value =='N') { $loc ='Neutral'; }

	        return $loc;
	    }

	    /**
	     * Formats Manager name nicely
	     * @param  string $i
	     * @return string $i
	     */
	    function mgr($i)
	    {
	        $i = ucwords(strtolower($i));
	        $i = str_replace('_', ' ',$i);
	        $i = ucwords($i);

		    if($i == 'Mourinho2'): $i = "Mourinho"; endif;

	        return $i;
	    }

	    /**
	     * Returns textual result from short value
	     * @param  string $i
	     * @return string $dollar
	     */
	    function res($i)
	    {
	        if(isset($i) && $i!='') {
	            switch ($i) {
	                case 'W':
	                    $dollar = "win";
	                    break;
	                case 'D':
	                    $dollar = "draw";
	                    break;
	                case 'L':
	                    $dollar = "loss";
	                    break;
	                default :
	                    $dollar = "unknown";
	            }
	        }
	        else {
	            $dollar = 'unknown';
	        }


	        return $dollar;
	    }

	    /**
	     * Appends plural string to penalty value.
	     * @param  string $i
	     * @return string $dollar
	     */
	    function pluralPens($i)
	    {
	        switch ($i) {
	            case 0:
	                $dollar = $i.' penalties';
	                break;
	            case 1:
	                $dollar = $i.' penalty';
	                break;
	            default :
	                $dollar = $i.' pens';
	        }

	        return $dollar;
	    }

	    /**
	     * Appends plural string to card value.
	     * @param  string $i
	     * @return string $dollar
	     */
	    function pluralCards($i)
	    {
	        switch ($i) {
	            case 0:
	                $dollar = $i.' cards';
	                break;
	            case 1:
	                $dollar = $i.' card';
	                break;
	            default :
	                $dollar =$i.' cards';
	        }

	        return $dollar;
	    }

	    /**
	     * Returns the super string ordinal version of a number (appends super-string th, st, nd, rd).
	     * @param  string $num
	     * @return string
	     */
	    function tcr_sub($num){
	        if($num < 11 || $num > 13){
	            switch($num % 10){
	                case 1: return $num.'<sup>st</sup>';
	                case 2: return $num.'<sup>nd</sup>';
	                case 3: return $num.'<sup>rd</sup>';
	            }
	        }
	        return $num.'<sup>th</sup>';
	    }

	    /**
	     * Returns the ordinal version of a number (appends th, st, nd, rd).
	     * @param  string $number The number to append an ordinal suffix to
	     * @return string
	     */
	    function numsuffix($number){
	        if($number < 11 || $number > 13){
	            switch($number % 10){
	                case 1: return $number.'st';
	                case 2: return $number.'nd';
	                case 3: return $number.'rd';
	            }
	        }
	        return $number.'th';
	    }

	    /**
	     * Returns some wordy replacements when numbers are small.
	     * @param  string $i
	     * @return string $dollar
	     */
	    function lowSide($i)
	    {
	        if(isset($i) && $i!='') {
	            switch ( $i ) {
	                case 0:
	                    $dollar = 'never';
	                    break;
	                case 1:
	                    $dollar = 'only once';
	                    break;
	                case ( $i > 2 && $i < 5 ):
	                    $dollar = 'just ' . $i . ' times';
	                    break;
	                default :
	                    $dollar = $i;
	            }
	        } else {
	            $dollar = 'unknown';
	        }

	        return $dollar;
	    }

	    /**
	     * Returns a key and tooltips to standard league tables
	     * @return string $dollar
	     */
	    function getTableKey() {

	        $dollar = '<p style="text-align:justify;">Common Key for tables:
					<abbr data-toggle="tooltip" data-placement="top" title="Games Played (all competitions unless otherwise stated)." class="initialism">PLD</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Games Won" class="initialism">W</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Games Drawn, includes games settled on penalties where applicable" class="initialism">D</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Games Lost." class="initialism">L</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Goal For." class="initialism">F</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Goal Against." class="initialism">A</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Goal Difference (Goals For minus Goals Against)." class="initialism">GD</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Clean Sheets." class="initialism">CS</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Failed to Score." class="initialism">FS</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Both teams to Score." class="initialism">BTTS</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Percentage of games undefeated (wins + draws)." class="initialism">U%</abbr>,
					<abbr data-toggle="tooltip" data-placement="top" title="Points, assuming 3 points for a win and 1 for a draw regardless of competition." class="initialism">PTS</abbr>
					and
					<abbr data-toggle="tooltip" data-placement="top" title="Points Per Game, rounded to 3 decimal places." class="initialism">Ppg</abbr>. Tables are sortable just click the column headers to sort; use shift
					key to sort on multiple columns.</p>';

	        return $dollar;
	    }

	    /**
	     * Returns a WSL league season date
	     * @return string $dollar
	     */
	    // get date for season if WSL
	    function _L_get_date()	{
	        // little m for month as 01-12
	        if (date('m')>01) {
	            $year=date('Y');

	            $dollar = '<p> Correct for the '.$year.' season.</p>';
	        }
	        else 	{
	            $year=date('Y')-1;

	            $dollar = '<p> Correct for the '.$year.' season.</p>';
	        }

	        return $dollar;
	    }

	    /**
	     * Returns a EPL league season date
	     * @return string $dollar
	     */
	    function _M_get_date() 	{
	        // little m for month as 01-12
	        if (date('m')>06) {
	            $year=date('Y');
	            $year2=date('Y')+1;

	            $dollar = '<p> Correct for the '.$year.'/'.$year2.' season.</p>';
	        }
	        else {
	            $year=date('Y')-1;
	            $year2=date('Y');

	            $dollar = '<p> Correct for the '.$year.'/'.$year2.' season.</p>';
	        }

	        return $dollar;
	    }

	    /**
	     * Simple compare bar chart using HTML and Bootstrap
	     * Example usage : _comparebars('title',$for,$against);
	     *
	     * @param string $title
	     * @param integer $for
	     * @param integer $against
	     * @return string $dollar
	     */
	    function _generateRatio($title,$for,$against) {

	        $total = ( $for + $against );
	        $dollar ='';

	        if ($total > 1) :
	            $for2 = round((( $for / ($for + $against)) * 100),2);
	            $against2 = round((( $against / ($for + $against)) * 100),2);
	            $markup='<h3>'.$title.' (F/A)</h3>';
	            $markup .= '<div class="progress">';
	            $markup .= '<div class="bar bar-info" 	  role="progressbar"
					aria-valuenow="'. $for2.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$for2.'%">'. $for2.'%</div>';
	            $markup .= '<div class="bar bar-warning"  role="progressbar"
					aria-valuenow="'.$against2.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$against2.'%">'.$against2.'%</div>';
	            $markup .= '</div>';

	            $dollar = $markup;
	        endif;

	        return $dollar;
	    }

	    /**
	     * Simple compare bar chart using HTML and Bootstrap
	     * Example usage : _comparebars('title',$wins,$draws,$losses);
	     *
	     * @param string $title
	     * @param integer $win
	     * @param integer $draw
	     * @param integer $loss
	     * @return string $dollar
	     */
	    function _comparebars3($title,$win,$draw,$loss) {

	        $total = ( $win + $draw + $loss );
	        $dollar ='';

	        if ($total > 1) :
	            $winPer   = round( (( $win  / $total ) * 100 ), 3 );
	            $drawPer  = round( (( $draw / $total ) * 100 ), 3 );
	            $lossPer  = round( (( $loss / $total ) * 100 ), 3 );

	            $markup  = "<h3>{$title} (W/D/L)</h3>";
	            $markup .= "<div class='progress'>";
	            $markup .= "<div class='bar bar-info' 	  role='progressbar' aria-valuenow='{$winPer}'  aria-valuemin='0' aria-valuemax='100' style='width: {$winPer}%;  '>{$winPer}%</div>";
	            $markup .= "<div class='bar bar-success'  role='progressbar' aria-valuenow='{$drawPer}' aria-valuemin='0' aria-valuemax='100' style='width: {$drawPer}%; '>{$drawPer}%</div>";
	            $markup .= "<div class='bar bar-warning'  role='progressbar' aria-valuenow='{$lossPer}' aria-valuemin='0' aria-valuemax='100' style='width: {$lossPer}%; '>{$lossPer}%</div>";
	            $markup .= "</div>";

	            $dollar = $markup;

	        endif;

	        return $dollar;
	    }

	    /**
	     * Simple compare bar chart using HTML and Bootstrap
	     * Example usage : _comparebars('Possession',$homeper,$awayper);
	     *
	     * @param string $title
	     * @param integer $home
	     * @param integer $away
	     * @return string $dollar
	     */
	    function _comparebars($title,$home,$away) {

	        $total  = ( $home + $away );
	        $dollar ='';

	        if ($total > 1) :
	            $homePer  = round( (( $home / $total ) * 100 ), 3 );
	            $awayPer  = round( (( $away / $total ) * 100 ), 3 );

	            $markup  = "<h3>{$title} (F/A)</h3>";
	            $markup .= "<div class='progress'>";
	            $markup .= "<div class='bar bar-info' 	  role='progressbar' aria-valuenow='{$homePer}' aria-valuemin='0' aria-valuemax='100' style='width: {$homePer}%;'>{$homePer}%</div>";
	            $markup .= "<div class='bar bar-warning'  role='progressbar' aria-valuenow='{$awayPer}' aria-valuemin='0' aria-valuemax='100' style='width: {$awayPer}%;'>{$awayPer}%</div>";
	            $markup .= "</div>";

	            $dollar = $markup;

	        endif;

	        return $dollar;
	    }

		/**
		 * Generate Cann table
		 * @param $content
		 * @param $table_key
		 * @param $column
		 * @return string
		 */
		function CannNamStyle($content,$table_key,$column) {

	        $column = (int) $column;

	        $newlines = array("\t","\n","\r","\x20\x20","\0","\x0B","<br/>","<p>","</p>","<br>");
	        $raw = str_replace($newlines, "", html_entity_decode($content));

	        $table = str_replace('class=','',$raw);
	        preg_match_all("|<tr(.*)</tr>|U",$table,$rows);

	        $rank=array();
	        foreach ($rows[0] as $row) {
	            if ((strpos($row,'<th')===false)) :
	                // pos, team, pld, gd, pts
	                preg_match_all("|<td(.*)</td>|U",$row,$cells);
	                $f0 = strip_tags($cells[0][0]); //team
	                $f1 = strip_tags($cells[0][1]); // played
	                $fx = strip_tags($cells[0][$column]);
	                if(isset($f1) && $f1 <>'') :
	                    array_push($rank,$fx,"$f0 ($f1)");
	                endif;
	            endif;
	        } // end foreach
	        #################################################################
	        $output = array();
	        foreach($rank as $key => $value) {
	            // we want value 1 as key, value 2 as value. modulus baby.
	            if($key % 2 > 0) { //every second item
	                $index = $rank[$key-1];
	                // we cannot have duplicate keys so we concatenate values to the key.
	                if(array_key_exists($index,$output)) {
	                    $output[$index] .= ', '.$value;
	                }
	                else {
	                    $output[$index] = $value;
	                }
	            }
	        }
	        @krsort($output);


	        $new=array();
	        reset($output);
	        $first = key($output);
	        reset($output);
	        $last = key( array_slice( $output, -1, 1, TRUE ) );
	        $i = $last;
	        while ($i < $first):
	            /** @noinspection PhpParamsInspection */
		        if (!@array_key_exists($output)):
	                $new[$i]=" ";
	            endif;
	            $i++;
	        endwhile;
	        reset($output);
	        $output= $output + $new;
	        @krsort($output);

	        #################################################################
	        // make sexy
	        $dollar  = "<div class='table-container-small'><table class='tablesorter'>";
	        $dollar .= "<thead><tr><th>{$table_key}</th><th>Team</th></tr></thead><tbody>";
	        foreach($output as $key => $value) {
	            $dollar .= "<tr><td>{$key}</td><td>{$output[$key]}</td></tr>";
	        }
	        $dollar .= "</tbody></table></div>";


	        return $dollar;
	    }

		/**
		 * Generate daily post
		 * @param $location
		 * @param $city
		 * @param $embed
		 * @param $date
		 * @return int|WP_Error
		 */
		function get_daily($location, $city, $embed, $date) {

			date_default_timezone_set('Europe/London');
			$content = '[daily]' . PHP_EOL;
			$content .= '[dyk]';
			$content .= $this->get_stat();
			$content .= '[/dyk]';
			$content .= $this->get_weather( $location, $city, $date);
			$content .= $this->get_tv_fix($date);
			$content .= $this->get_otd_summary($date);
			$content .= '<br/>';

			if ( isset( $embed ) && $embed != '' ) {
				$content .= '<h3>Video</h3>';
				$content .= $embed;
			}

		    $content .= '<p>KTBFFH</p>';


		    $post_array = array (
	            'post_title'    => 'Blue Day!',
	            'post_name'     => 'its-going-to-be-a-blue-day-'. $date,
	            'post_content'  => $content,
	            'post_author'   => 1,
	            'post_category' => array ( '1' )
	        );

	        // Insert the post into the database
	        $post_id = wp_insert_post( $post_array );
	        return $post_id;
	    }

		/**
		 * Get random App stat
		 * @return string
		 */
		function get_stat() {

			$pdo = new pdodb();
			$pdo->query("SELECT F_TEXT, F_DATE, F_AUTHOR FROM ( 
					SELECT F_TEXT, F_DATE, F_AUTHOR FROM o_appstats
					 WHERE F_DATE > (Select F_DATE from 000_config where F_LEAGUE='APP')
					 ORDER BY F_ID DESC LIMIT 10 ) AS DATA
					 ORDER BY RAND() LIMIT 1");
			$row    = $pdo->row();
			$stat   = $row['F_TEXT'];
			$byline = $row['F_AUTHOR'];
			$date   = $row['F_DATE'];

			return $data = $stat .' by @'. $byline .' (correct as of '. $date .')';
		}

		/**
		 * Get Weather report for Daily post
		 * @param $location
		 * @param $city
		 * @param $raw_date
		 * @return string
		 */
		function get_weather($location, $city, $raw_date) {
		    date_default_timezone_set('Europe/London');
	        $content	= '<h3>Weather Report</h3>';
	        $posty      = urlencode($location);
	        $city		= urlencode($city);
	        $url        = "https://query.yahooapis.com/v1/public/yql?q=SELECT%20item.forecast%2Clocation%20FROM%20weather.forecast%20WHERE%20woeid%20in%20(SELECT%20woeid%20FROM%20geo.places(1)%20WHERE%20text%20in%20('.$posty.'%2C'.$city.'))%20AND%20u%3D'c'%20LIMIT%203&format=json&callback=";
	        $ch = curl_init( $url );
	        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	        $json = curl_exec( $ch );
	        curl_close( $ch );
	        $raw  = json_decode( $json );
		    $strtotime = strtotime($raw_date);
	        $date = date( 'j M Y' , $strtotime);
	        foreach ( $raw->query->results->channel as $channel ) :
	            $weatherLoc  = $channel->location->city;
	            $weatherDate = $channel->item->forecast->date;
	            $weatherHigh = $channel->item->forecast->high;
	            $weatherLow  = $channel->item->forecast->low;
	            $weatherDesc = $channel->item->forecast->text;
	            $weatherDesc = strtolower( $weatherDesc );
	            if ( isset( $weatherDate ) && $date == $weatherDate ) :
	                if ( isset( $weatherLow ) && isset( $weatherLoc ) && isset( $weatherHigh ) && isset( $weatherDesc ) ) :
	                    $content .= "The forecast for {$weatherLoc} on {$weatherDate} is lows of {$weatherLow}°C with highs of {$weatherHigh}°C and {$weatherDesc}. Have a nice day!";

	                endif;
	            endif;
	        endforeach;

	        return $content;
	    }

		/**
		 * Get TV fixtures for Daily post
		 * @param $raw_date
		 * @return string
		 */
		function get_tv_fix($raw_date) {
		    date_default_timezone_set('Europe/London');
	        $fixtures   = "<h3>Today's TV fixtures</h3>".PHP_EOL;
	        $fixtures  .= "<ul>".PHP_EOL;
	        $url	    = "http://www.live-footballontv.com/";
	        $ch	    =   curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        $raw	    =   curl_exec($ch);
	        curl_close($ch);
		    $strtotime = strtotime($raw_date);
	        $s_date     =   date('d-m-Y', $strtotime);
	        $s_today    =   date('l jS F Y', $strtotime);
	        $s          =   strpos($raw, '<div class="span12 matchdate">'.$s_today.'</div>');
	        $e_date     =   date('l jS F Y', strtotime($s_date . ' +1 day'));
	        $e          =   strpos($raw, '<div class="span12 matchdate">'.$e_date.'</div>');
	        $table      =   substr($raw,$s,$e-$s);
	        $table      =   str_replace( $s_today , '', $table);
	        $table      =   '<table style="width:100%; margin:auto auto; padding:2em;">
								 <thead><th>Fix</th><th>Comp</th><th>KO</th><th>TV</th></thead>
								 <tbody>' . $table . '</tbody></table>';
	        $table      =   str_replace( '<div class="row-fluid">'           , '<tr>'      , $table);
	        $table      =   str_replace( '<hr>'                              , '</tr>'     , $table);
	        $table      =   str_replace( '<div class="span4 matchfixture">'  , '<td>'      , $table);
	        $table      =   str_replace( '<div class="span4 competition">'   , '<td>'      , $table);
	        $table      =   str_replace( '<div class="span1 kickofftime">'   , '<td>'      , $table);
	        $table      =   str_replace( '<div class="span3 channels">'      , '<td>'      , $table);
	        $table      =   str_replace( '</div>'                            , '</td>'     , $table);
	        $table      =   str_replace( 'Red Button'               	 , 'RB'        , $table);
	        $table      =   str_replace( 'BT Sport'                 	 , 'BT'        , $table);
	        $table      =   str_replace( 'Sky Sports'               	 , 'SkySports' , $table);
	        $table      =   str_replace( 'UEFA '                    	 , ''          , $table);
	        $table      =   str_replace( 'LFCTV'                    	 , 'LFC'        , $table);
	        $table      =   str_replace( 'Champions League '        	 , 'UCL'       , $table);
	        $table      =   str_replace( 'Group Stage'              	 , 'G'         , $table);
	        $table      =   str_replace( 'Last-16 1st Leg'          	 , 'L16 1'     , $table);
	        $table      =   str_replace( 'Last-16 2nd Leg'          	 , 'L16 2'     , $table);
	        $table      =   str_replace( 'Quarter-Final 1st Leg'    	 , 'QTR 1'     , $table);
	        $table      =   str_replace( 'Quarter-Final 2nd Leg'    	 , 'QTR 2'     , $table);
	        $table      =   str_replace( 'Semi-Final 1st Leg'       	 , 'SF 1'      , $table);
	        $table      =   str_replace( 'Semi-Final 2nd Leg'       	 , 'SF 2'      , $table);
	        $table      =   str_replace( 'Final'                    	 , 'Final'     , $table);
	        $table      =   str_replace( 'International'            	 , 'Int'       , $table);
	        $table      =   str_replace( 'United'                   	 , 'Utd'       , $table);
	        $table      =   str_replace( "Women&#39;s Super League"      , 'WSL'       , $table);
	        $table      =   str_replace( "&nbsp;"     			         , ' '         , $table);
	        $table      =   str_replace( '&nbsp;'     			         , ' '         , $table);
	        // important
	        $table      =   str_replace( 'TBC'  , ''  , $table);
	        preg_match_all( "|<tr(.*)</tr>|U", $table, $rows );

	        foreach ( $rows[0] as $row ) :
	            if ( ( strpos( $row, '<th' ) === FALSE ) ) :
	                preg_match_all( "|<td(.*)</td>|U", $row, $cells );
	                $fix  = trim( strip_tags ( $cells[0][0] ) );
	                /*
	                    if ( strpos( $fix, " v " ) ) {
	                        $teams  = explode( " v ", $fix );
	                        $h_team = $teams['0'];
	                        $a_team = $teams['1'];
	                    }
	                */
	                $comp = trim ( strip_tags ( $cells[0][1] ) );
	                $KO   = trim ( strip_tags ( $cells[0][2] ) );
	                $tv   = trim ( strip_tags ( $cells[0][3] ) );
	                if ( strpos( $tv, "/" ) ) {
	                    $tv = explode( "/", $tv );
	                    $tv = trim($tv['1']);
	                }
	                if ( $fix !='' && $comp !='' && $KO !='' && $tv != '') :
	                    if( $tv != 'MUTV HD' && $tv != 'LFC HD' && $tv != 'S4C' && $tv != 'Premier Sports HD' && $tv != 'BBC ALBA' ) :
	                        $fixtures .= "<li>{$fix} in {$comp} is on {$tv} at {$KO}.</li>".PHP_EOL;
	                    endif;
	                else:
		                    $fixtures .= "<li>Alas, no games</li>".PHP_EOL;
	                endif;
	            endif;
	        endforeach;

	        $fixtures .= "</ul>".PHP_EOL;

	        return $fixtures;
	    }

		/**
		 * Get OTD data for Daily post
		 * @param $raw_date
		 * @return string
		 */
		function get_otd_summary($raw_date) {

			date_default_timezone_set('Europe/London');
			$pdo = new pdodb();
		    $date = new DateTime($raw_date);
		    $month = $date->format('m');
		    $day = $date->format('d');
		    $content = "<h3>On This Day</h3>";
		    $content .= "<ul>";
	        $pdo->query("SELECT F_DATE,
							SUM(IF(F_RESULT='W'=1,1,0)) AS F_WIN,
							SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAW,
							SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSS,
							COUNT(*) AS F_TOTAL
	                FROM cfc_fixtures WHERE MONTH(F_DATE) ={$month} AND DAY(F_DATE)= {$day}");
	        $row = $pdo->row();
	        $W = $row['F_WIN'];
	        $D = $row['F_DRAW'];
	        $L = $row['F_LOSS'];
	        $T = $row['F_TOTAL'];
	        $I = $row['F_DATE'];
	        $I = explode('-',$I);
	        $I = $I[1].'-'.$I[2];
	        if  ( $T > 0 ) {
	            $content .= "<li>On This Day ({$I}) - Chelsea played {$T}, winning {$W}, drawing {$D} and losing {$L}.</li>";
	        }

	        $pdo->query("SELECT F_DATE,
								SUM(IF(F_RESULT='W'=1,1,0)) AS F_WIN,
								SUM(IF(F_RESULT='D'=1,1,0)) AS F_DRAW,
								SUM(IF(F_RESULT='L'=1,1,0)) AS F_LOSS,
								COUNT(*) AS F_TOTAL
	                FROM wsl_fixtures WHERE MONTH(F_DATE) = {$month} AND DAY(F_DATE)= {$day}");
	        $row = $pdo->row();
	        $W = $row['F_WIN'];
	        $D = $row['F_DRAW'];
	        $L = $row['F_LOSS'];
	        $T = $row['F_TOTAL'];
	        $I = $row['F_DATE'];
	        $I = explode('-',$I);
	        $I = $I[1].'-'.$I[2];
	        if  ( $T > 0 ) {
	            $content .= "<li>On This Day ({$I}) - Chelsea Ladies played {$T}, winning {$W}, drawing {$D} and losing {$L}.</li>";
	        }
		        $content .= "</ul>";
				$content .= "<p style='text-align:justify;'> <a href='https://thechels.co.uk/otd/' title='Chelsea FC On This Day by ChelseaStats'>For a detailed look at those results see our ever changing On This Day page</a>.</p>";

				$content .= "<h3>Key events on this day in history</h3>";
		        $content .="<ul>";

			$pdo->query("SELECT F_NAME, F_NOTES, F_DATE, YEAR(F_DATE) as F_YEAR FROM cfc_dates
						 WHERE MONTH(F_DATE) = {$month} AND DAY(F_DATE)= {$day}  ORDER BY F_DATE DESC limit 10");
			$rows = $pdo->rows();
			foreach($rows as $row) {
				$content .=  "<li>On This Day ({$row['F_YEAR']}) - {$this->_V($row['F_NAME'])} - {$row['F_NOTES']}</li>";
			}
	            $content .= "</ul><p><a href='https://thechels.co.uk/otd/'>See more On This Day events</a></p>";

	        return $content;

	    }

		/**
		 * just runs some sql
		 * @param $sql
		 * @return mixed
		 */
		function getLast100($sql) {
			$pdo = new pdodb();
			$pdo->query($sql);
			$row = $pdo->row();
			return $row;
		}

		/**
		 * Add people to anagram game
		 * @return string
		 */
		function anagram() {

			$sql = "";

			$sql .= "INSERT IGNORE INTO cfc_anagram (f_name)  select replace(replace(trim(F_NAME),' ','_'),'__','-') from cfc_dobs";

			$sql .= "INSERT IGNORE INTO cfc_anagram (f_name)  select replace(concat(trim(replace(replace(trim(F_FNAME),' ','_'),'__','-') )
						    ,'_',trim(replace(replace(trim(F_SNAME),' ','_'),'__','-'))),'__','_') from cfc_explayers";

			$sql .= "INSERT IGNORE INTO cfc_anagram (f_name)  select replace(concat(trim(replace(replace(trim(F_FNAME),' ','_'),'__','-') )
						    ,'_',trim(replace(replace(trim(F_SNAME),' ','_'),'__','-'))),'__','_') from cfc_managers";

			$sql .= "update cfc_anagram set f_name = replace(f_name,'-','_');";

			return $sql;
		}

		/**
		 * generate penalties data
		 * @param $team
		 * @param $type
		 * @return string
		 */
		function penalties($team, $type) {

			$sql = "SELECT a.F_NAME, a.F_MINUTE, b.F_DATE, b.F_COMPETITION, b.F_OPP, b.F_LOCATION, b.F_RESULT, b.F_FOR, b.F_AGAINST
							FROM  cfc_fixture_events  a, cfc_fixtures b
							WHERE a.F_EVENT = '$type' AND a.F_TEAM = '$team'
							AND a.F_GAMEID = b.F_ID ORDER BY a.F_DATE DESC";

			return $sql;
		}

		/**
		 * Chelsea hat tricks
		 * @return string
		 */
		function hatTricks() {

			$sql = "SELECT a.F_DATE, a.F_NAME, b.F_COMPETITION, b.F_OPP, COUNT(*) AS COUNTER  FROM cfc_fixture_events a, cfc_fixtures b
							WHERE a.F_GAMEID=b.F_ID AND F_EVENT IN ('GOAL','PKGOAL') GROUP BY a.F_DATE, a.F_NAME, b.F_COMPETITION, b.F_OPP HAVING COUNT(*) >= 3";

			return $sql;
		}

		/**
		 * Premier League Head-to-head comparison
		 * @param $team1
		 * @param $team2
		 * @return string
		 */
		function head2heads($team1, $team2) {

			$sql = "select a.F_HOME AS Team, count(a.F_HOME) AS PLD,
							sum((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1)) AS W,
							sum((if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)) AS D,
							sum((if((a.F_HGOALS < a.F_AGOALS),1,0) = 1)) AS L,
							sum((if((a.F_HGOALS = 0),1,0) = 1)) AS FS, sum((if((a.F_AGOALS = 0),1,0) = 1)) AS CS, sum((if((a.F_AGOALS > 0 AND a.F_HGOALS > 0),1,0) = 1)) AS BTTS,
							sum(a.F_HGOALS) AS F, sum(a.F_AGOALS) AS A, sum((a.F_HGOALS - a.F_AGOALS)) AS GD,
							round((sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1)))  / count(a.F_HOME)),3) AS PPG,
							sum((((if((a.F_HGOALS > a.F_AGOALS),1,0) = 1) * 3) + (if((a.F_HGOALS = a.F_AGOALS),1,0) = 1))) AS PTS
							from all_results a where ( a.F_HOME in ('$team1','$team2') and a.F_AWAY in ('$team1','$team2'))
							union all
							select b.F_AWAY AS Team, count(b.F_AWAY) AS PLD,
							sum((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1)) AS W,
							sum((if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)) AS D,
							sum((if((b.F_AGOALS < b.F_HGOALS),1,0) = 1)) AS L,
							sum((if((b.F_AGOALS = 0),1,0) = 1)) AS FS, sum((if((b.F_HGOALS = 0),1,0) = 1)) AS CS, sum((if((b.F_AGOALS > 0 AND b.F_HGOALS > 0),1,0) = 1)) AS BTTS,
							sum(b.F_AGOALS) AS F, sum(b.F_HGOALS) AS A, sum((b.F_AGOALS - b.F_HGOALS)) AS GD,
							round((sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1)))  / count(b.F_HOME)),3) AS PPG,
							sum((((if((b.F_AGOALS > b.F_HGOALS),1,0) = 1) * 3) + (if((b.F_AGOALS = b.F_HGOALS),1,0) = 1))) AS PTS
							from all_results b where ( b.F_HOME in ('$team1','$team2') and b.F_AWAY in ('$team1','$team2'))";

			return $sql;
		}

		/**
		 * results grouped by year and month
		 * @return string
		 */
		function resultsByMonth() {

			$sql ="SELECT F_RESULT, COUNT(*) FROM cfc_fixtures WHERE F_COMPETITION='PREM' AND F_DATE > '2004-06-01' GROUP BY YEAR(F_DATE), MONTH(F_DATE), F_RESULT";

			return $sql;
		}

		/**
		 * results by time span 'mmdd' to 'mmdd'
		 * @return string
		 */
		function resultsByTimespan() {

			$sql = "SELECT SUM(IF(F_RESULT='W'=1,1,0)) AS W, SUM(IF(F_RESULT='D'=1,1,0)) AS D, SUM(IF(F_RESULT='L'=1,1,0)) AS L,
							COUNT(*) FROM cfc_fixtures WHERE DATE_FORMAT(F_DATE, '%m%d') BETWEEN '1220' AND '1231' OR DATE_FORMAT(F_DATE, '%m%d') BETWEEN '0101' AND '0105'";

			return $sql;

		}

		/**
		 * @return string
		 */
		function streak_chelseaWinVsOpp() {

			$sql ="SELECT * FROM ( SELECT F_RESULT,  MIN(F_DATE) as StartDate,  MAX(F_DATE) as EndDate,  COUNT(*) as Games
						  FROM
								(SELECT F_DATE, F_RESULT,
								 (SELECT COUNT(*) FROM cfc_fixtures G
								  WHERE G.F_RESULT <> GR.F_RESULT
								  AND G.F_OPP='MANCHESTER_CITY'
								  AND G.F_DATE <= GR.F_DATE) as RunGroup
								  FROM cfc_fixtures GR
								  WHERE GR.F_OPP='MANCHESTER_CITY') A
								GROUP BY F_RESULT, RunGroup
								ORDER BY Min(F_DATE)
								) B
						  WHERE F_RESULT IN ('W','L') ORDER BY Games DESC LIMIT 10";

			return $sql;
		}

		/**
		 * @return string
		 */
		function streak_current() {

			$sql = "SELECT * FROM ( SELECT * FROM
								( SELECT F_RESULT,  MIN(F_DATE) as StartDate,  MAX(F_DATE) as EndDate, COUNT(*) as Games
								FROM (SELECT F_DATE, F_RESULT,
								 (SELECT COUNT(*) FROM cfc_fixtures G WHERE G.F_RESULT <> GR.F_RESULT AND G.F_DATE <= GR.F_DATE) as RunGroup
								   FROM cfc_fixtures GR) A
								GROUP BY F_RESULT, RunGroup ORDER BY Min(F_DATE) ) B
								WHERE F_RESULT IN ('W','L') ORDER BY Games DESC ) A
								WHERE EndDate = (SELECT Max(F_Date) FROM cfc_fixtures)";

			return $sql;
		}

		/**
		 * Streaks with type2
		 * @param $type
		 * @return string
		 */
		function streak_original($type) {

			$sub= "SELECT Result,
							 MIN(GameDate) as StartDate, MAX(GameDate) as EndDate, COUNT(*) as Games
							FROM
							(SELECT GameDate, Result,
							 (SELECT COUNT(*) FROM GameResults G WHERE G.Result <> GR.Result AND G.GameDate <= GR.GameDate) as RunGroup
							 FROM GameResults GR) A
							GROUP BY Result, RunGroup ORDER BY Min(GameDate)";

			switch($type) {

				case '1' :
					// What was the longest winning streak of the year?
					$sql = "SELECT TOP 1 * FROM ($sub) A ORDER BY Games DESC Where Result = 'W' ";
					break;
				case '2' :
					// What is the current streak as of the last game? (Very common in standings in the sports section)
					$sql = "	SELECT * FROM ($sub ) A WHERE EndDate = (SELECT Max(EndDate) FROM GameResults)";
					break;
				default  :
				case '3' :
					//	How many streaks, of 3 games or more, did we have?
					$sql = "SELECT Result, COUNT(*) as NumberOfStreaks FROM ($sub) A GROUP BY Result WHERE Games >= 3";
					break;
			}

			return $sql;

		}

		/**
		 * @param $opp
		 * @return string
		 */
		function streak_opponent($opp) {

			$sql ="SELECT * FROM
							( SELECT F_RESULT, MIN(F_DATE) as StartDate, MAX(F_DATE) as EndDate, COUNT(*) as Games FROM
							(SELECT F_DATE, F_RESULT,
							 (SELECT COUNT(*) FROM cfc_fixtures G
							  WHERE G.F_RESULT <> GR.F_RESULT AND G.F_OPP='$opp' AND G.F_DATE <= GR.F_DATE) as RunGroup
							  FROM cfc_fixtures GR  WHERE GR.F_OPP= '$opp') A
							GROUP BY F_RESULT, RunGroup ORDER BY Min(F_DATE) ) B
							WHERE F_RESULT IN ('W','L') ORDER BY Games DESC LIMIT 10";

			return $sql;
		}

		/**
		 * @param $rows
		 * @return string
		 */
		function returnFlotCoords($rows) {

			$output = "";
				foreach($rows as $row):
			            $output .="[ {$row['f_x']} , -{$row['f_y']} ],".PHP_EOL;
				endforeach;
			$output = rtrim($output,',');
			return $output;
		}

		/**
		 * @param $rows
		 * @return string
		 */
		function returnHorizontalHomeFlotCoords($rows) {

			$output = "";
			foreach($rows as $row):
				$output .="[ 920-{$row['f_x']} , 920-{$row['f_y']} ],".PHP_EOL;
			endforeach;
			$output = rtrim($output,',');
			return $output;
		}

		/**
		 * @param $rows
		 * @return string
		 */
		function returnHorizontalAwayFlotCoords($rows) {

			$output = "";
			foreach($rows as $row):
				$output .="[ -(900-{$row['f_x']}) , -(-160-{$row['f_y']}) ],".PHP_EOL;
			endforeach;
			$output = rtrim($output,',');
			return $output;
		}

		/**
		 * @param      $team
		 * @return string
		 */
		function get_HeadlineStats($team) {


			$queryTeam = $this->_Q($team);
			$displayTeam = $this->_V($team);

			$pdo = new pdodb();
			$pdo->query('SELECT "Games Won" 			as F_TEXT,  SUM(W)   AS F_VALUE FROM 0V_base_PL_this  where Team = :team
			         UNION ALL SELECT "Games Drawn" 	as F_TEXT,  SUM(D)   AS F_VALUE FROM 0V_base_PL_this  where Team = :team
					 UNION ALL SELECT "Games Lost" 	    as F_TEXT,  SUM(L)   AS F_VALUE FROM 0V_base_PL_this  where Team = :team
					 UNION ALL SELECT "Goals For" 	    as F_TEXT,  SUM(F)   AS F_VALUE FROM 0V_base_PL_this  where Team = :team
					 UNION ALL SELECT "Goals Against"   as F_TEXT,  SUM(A)   AS F_VALUE FROM 0V_base_PL_this  where Team = :team
					 UNION ALL SELECT "Clean Sheets"    as F_TEXT,  SUM(CS)  AS F_VALUE FROM 0V_base_PL_this  where Team = :team
					 UNION ALL SELECT "Points"    		as F_TEXT,  SUM(PTS) AS F_VALUE FROM 0V_base_PL_this  where Team = :team
					 group by Team');
			$pdo->bind('team', $queryTeam);
			$rows = $pdo->rows();
			$string = "<h3>Headline {$displayTeam} Stats</h3>".PHP_EOL;
			$string .= "<table class='tablesorter small'><thead><tr><th>Statistic</th><th>Value</th></tr></thead><tbody>";
			foreach($rows as $row){
				$string .= "<tr><td>{$row['F_TEXT']}</td><td>{$row['F_VALUE']}</td></tr>";
			}
			$string .="</tbody></table>";

			$pdo->query('SELECT "Points per Game" 				 	as F_TEXT, round(sum(PTS)/sum(PLD),3) AS F_VALUE FROM 0V_base_PL_this where Team = :team
						UNION ALL SELECT "Goals For per Game" 	 	as F_TEXT, round(sum(F)/sum(PLD),3) AS F_VALUE FROM 0V_base_PL_this where Team = :team
						UNION ALL SELECT "Goals Against per Game" 	as F_TEXT, round(sum(A)/sum(PLD),3) AS F_VALUE FROM 0V_base_PL_this where Team = :team
						UNION ALL SELECT "Goals Ratio" 				as F_TEXT, round(sum(F)/(sum(F)+SUM(A)),3) AS F_VALUE FROM 0V_base_PL_this where Team = :team
						UNION ALL SELECT "Total Shots Ratio" 	 	as F_TEXT, round(SUM(F)/(SUM(F)+SUM(A)),3) AS F_VALUE FROM 0V_base_Shots_this where Team= :team
					    UNION ALL SELECT "Shots on Target Ratio"    as F_TEXT, round(SUM(F)/(SUM(F)+SUM(A)),3) AS F_VALUE FROM 0V_base_Shots_on_this where Team= :team
					    UNION ALL SELECT "Scoring Percentage"	    as F_TEXT, round(100 * h_sh,3) AS F_VALUE from 0V_base_pdo_this where Team= :team
					    UNION ALL SELECT "Save Percentage"		    as F_TEXT, round(100 * h_sv,3) AS F_VALUE from 0V_base_pdo_this where Team= :team
					    UNION ALL SELECT "PDO"					    as F_TEXT, h_PDO AS F_VALUE from 0V_base_pdo_this where Team= :team
					    group by Team');
			$pdo->bind('team',  $queryTeam );
			$rows = $pdo->rows();
			$string .= "<h3>Advanced {$displayTeam} Stats</h3>".PHP_EOL;
			$string .= "<table class='tablesorter small'><thead><tr><th>Statistic</th><th>Value</th></tr></thead><tbody>";
				foreach($rows as $row){
					$string .= "<tr><td>{$row['F_TEXT']}</td><td>{$row['F_VALUE']}</td></tr>";
				}
			$string .="</tbody></table>";

			return $string;
		}
	
		/**
		 * Handles Multi-return query with 3 types.
		 * 
		 * @param $type
		 * @param $sql
		 * @return string
		 */
		public function processType($type, $sql) {
			$pdo = new pdodb();
			$message = '';
			$ns = '';
			$vs = '';

			switch ($type) {
				case '1' :
					$pdo->query($sql);
					$row = $pdo->row();
					$v0 = $this->_V($row['V']);

					if (isset($v0) && $v0 != '') {
						$message = $v0;
					}
					break;
				case '2' :
					$pdo->query($sql);
					$rows = $pdo->rows();
					foreach ($rows as $row) {
						$ns[] = $row['N'];
						$vs[] = $row['V'];
					}
					$n0 = $this->_V($ns[0]);
					$v0 = $this->_V($vs[0]);

					if (isset($n0) && $n0 != '') {
						$message = $n0 . ' (' . $v0 . ') ';
					}
					break;
				case '3' :
					$pdo->query($sql);
					$rows = $pdo->rows();
					foreach ($rows as $row) {
						$ns[] = $row['N'];
						$vs[] = $row['V'];
					}
					$n0 = $this->_V($ns[0]);
					$v0 = $this->_V($vs[0]);
					$n1 = $this->_V($ns[1]);
					$v1 = $this->_V($vs[1]);
					$n2 = $this->_V($ns[2]);
					$v2 = $this->_V($vs[2]);

					if(isset($n2) && $n2 != '' && $n0 == $n1 && $n1 == $n2) {
						// only one
						$message = "{$n0} ({$v0})";

					} else if(isset($n2) && $n2 != '' && $n0 != $n1 && $n1 == $n2) {
						// one and two, not three
						$message = "{$n0} ({$v0}), {$n1} ({$v1})";

					} else if(isset($n2) && $n2 != '' && $n0 != $n2 && $n0 == $n1 ) {
						// one and three, not two
						$message = "{$n0} ({$v0}), {$n2} ({$v2})";

					} else if (isset($n2) && $n2 != '' && $n0 != $n1 && $n1 != $n2) {
						// all three are different
						$message = "{$n0} ({$v0}), {$n1} ({$v1}), {$n2} ({$v2})";
					}

					break;
			}
			return $message;
		}

		/**
		 * @param $hash
		 * @return string
		 */
		public function getUrlOTD($hash)
		{
			// take a hash and return a bitly url
			$hash = $this->otd_hash($hash);
			$url = 'http://thechels.co.uk/otd?#' . $hash;

			return $url;
		}
	
		/**
		 * @param $url
		 */
		public function process($url) {

			$array = '';

			if (!file_exists($url)) {
				print "file not found: {$url}";
			}
			else if(!$fh = fopen($url, 'r')) {
				print "Cannot open file: {$url}";
			}

			$file = fopen($url, 'r');

			while (($line = fgetcsv($file)) !== FALSE) {
				$array[] = $line;
			}
			array_shift($array); // remove the CSV column headings
			foreach ($array as $tweet):
				$this->ucl($tweet['1'], 'M19');
				$this->sleeper((int)$tweet['0']);
			endforeach;
		}

		/**
		 * @param $message
		 * @param $user
		 */
		public function ucl( $message, $user ) {

			$user = strtoupper($user);
			switch($user) {
				case 'M19':
				default: // 19th May Bot
					$connection = new \Abraham\TwitterOAuth\TwitterOAuth(
						'******',
						'******',
						'******',
						'******'
					);
					break;
			}

			$connection->get( 'account/verify_credentials' );
			$connection->post( 'statuses/update', array ( 'status' => $message ) );
		}

		/**
		 * @param $offset
		 */
		public function sleeper($offset) {
			sleep($offset * 60);
		}

		/**
		 * @param $date
		 * @return string
		 */
		public function otd_hash($date) {
			//return a hash of the date
			$hash = hash('crc32', $date);
			return $hash;
		}

		/**
		 * @param $code
		 */
		public function goDebug($code) {
			print '<h5>' . gettype($code) . '</h5>';
			print '<pre>';
			print_r($code);
			print '</pre>';
			print '<hr/>';
		}

		/**
		 * @param $array
		 * @return mixed
		 */
		public function getValueFromKey($array) {
			$rand_key = array_rand($array);
			return $array[$rand_key];
		}

		/**
		 * @param $array
		 * @param $n
		 * @return mixed
		 */
		public function getValuesFromArray($array, $n) {
			return array_rand(array_flip($array), $n);
		}

		/**
		 * @param $array
		 * @return array
		 */
		function array_values_recursive($array) {
			$flat = array();
			foreach ($array as $value) {
				if (is_array($value)) $flat = array_merge($flat, $this->array_values_recursive($value));
				else $flat[] = $value;
			}
			return $flat;
		}

		/**
		 * @param $string
		 * @return string
		 */
		public function titleCase($string)
		{
			$word_splitters = array(' ', '-', "O'", "L'", "D'", 'St.', 'Mc', 'Mac', 'Macho');
			$lowercase_exceptions = array('the', 'van', 'den', 'von', 'und', 'der', 'de', 'di', 'da', 'of', 'and', "l'", "d'");
			$uppercase_exceptions = array('III', 'IV', 'VI', 'VII', 'VIII', 'IX');
			$string = strtolower($string);
			foreach ($word_splitters as $delimiter) {
				$words = explode($delimiter, $string);
				$newwords = array();
				foreach ($words as $word) {
					if (in_array(strtoupper($word), $uppercase_exceptions))
						$word = strtoupper($word);
					else
						if (!in_array($word, $lowercase_exceptions))
							$word = ucfirst($word);
					$newwords[] = $word;
				}
				if (in_array(strtolower($delimiter), $lowercase_exceptions))
					$delimiter = strtolower($delimiter);
				$string = join($delimiter, $newwords);
			}
			return $string;
		}

		/**
		 * @param $tweet
		 * @return string
		 */
		public function cleanTweet($tweet)
		{
			/* clean the tweet text before looking for a match */
			$pattern = '/@([a-zA-Z0-9_]+)/';
			$tweet = preg_replace($pattern, "", $tweet);
			return trim($tweet);
		}

		/**
		 * @param $string
		 * @return array
		 */
		public function splitTweets($string)  {
			return explode('//', $string);
		}

		/**
		 * @param $string
		 * @return int
		 */
		function countHashTags($string)
		{
			if (preg_match_all("/(#\w+)/", $string, $matches))
				return count($matches[0]);
			else
				return 0;
		}

		/** pass hashtag get team name
		 * @param $hash_tag
		 * @return mixed
		 */
		public function decodeHashtags($hash_tag) {
			// uppercase it
			$hash_tag = strtoupper($hash_tag);
			// PL only
			$hashes_array = [
				'#AFCB' => 'BOURNEMOUTH',
				'#ARS' => 'ARSENAL',
				'#AFC' => 'ARSENAL',
				'#AVFC' => 'ASTON_VILLA',
				'#VILLA' => 'ASTON_VILLA',
				'#CFC' => 'CHELSEA',
				'#CHE' => 'CHELSEA',
				'#COYS' => 'SPURS',
				'#SPURS' => 'SPURS',
				'#CPFC' => 'C_PALACE',
				'#EFC' => 'EVERTON',
				'#EVE' => 'EVERTON',
				'#HCFC' => 'HULL',
				'#HULL' => 'HULL',
				'#LCFC' => 'LEICESTER',
				'#LEI' => 'LEICESTER',
				'#LFC' => 'LIVERPOOL',
				'#LIV' => 'LIVERPOOL',
				'#MCFC' => 'MAN_CITY',
				'#MUFC' => 'MAN_UTD',
				'#NCFC' => 'NORWICH',
				'#NUFC' => 'NEWCASTLE',
				'#SAINTSFC' => 'SOUTHAMPTON',
				'#SAINTS' => 'SOUTHAMPTON',
				'#SOU' => 'SOUTHAMPTON',
				'#SCFC' => 'STOKE',
				'#STO' => 'STOKE',
				'#STOKE' => 'STOKE',
				'#SAFC' => 'SUNDERLAND',
				'#SUN' => 'SUNDERLAND',
				'#SWANS' => 'SWANSEA',
				'#WAT' => 'WATFORD',
				'#WATFORD' => 'WATFORD',
				'#WBA' => 'WEST_BROM',
				'#WHUFC' => 'WEST_HAM',
				'#WHU' => 'WEST_HAM'
			];
			return $hashes_array[$hash_tag];
		}

		/** if var is int return, else set to 6
		 * @param $limit
		 * @return string
		 */
		public function getInteger($limit) {
			$limit = (int)$limit;
			if (!is_integer($limit) || $limit == 0): $limit = '6'; endif;
			return $limit;
		}

		/**  check its with the 140 char limit
		 * @param $text
		 * @return string
		 */
		public function safeToTweet($text)
		{
			if (substr($text, 0, 140) != $text) {
				$text = substr($text, 0, 137) . "...";
			}
			return trim($text);
		}

		/**  check its with the 140 char limit
		 * @param $text
		 * @return string
		 */
		public function tocfcwsTweet($text)  {
			// tocfcws : - http://thechels.uk/1ZSp1ew = 38
			if (substr($text, 0, 100) != $text) {
				$text = substr($text, 0, 97) . "...";
			}
			return trim($text);
		}

		/**
		 * @param     $haystack
		 * @param     $needle
		 * @param int $offset
		 * @return bool
		 */
		function strposa($haystack, $needle, $offset=0) {
			if(!is_array($needle)) $needle = array($needle);
			foreach($needle as $query) {
				if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
			}
			return false;
		}

		/**
		 * void
		 */
		function DoAnagram() {

			$melinda = new melinda();
			$pdo = new pdodb();
			$pdo->query("SELECT F_ID, F_NAME FROM cfc_games WHERE F_GRAM = 0 ORDER BY RAND() LIMIT 1");
			$row = $pdo->row();
			$name = str_replace('_','',$row['F_NAME']);
			$anagram  = str_shuffle($name);
			$answer = $this->_V($row['F_NAME']);
			$id = $row['F_ID'];
			$melinda->goTweet("Anagram : {$anagram}.  #CFC #Chelsea #ChelseaFC", 'game');
			$pdo->query("UPDATE cfc_games SET F_GRAM='1' WHERE F_ID = :id ");
			$pdo->bind(':id',$id);
			$pdo->execute();
			sleep(1200);
			$melinda->goTweet("Anagram answer was : {$answer}. Congratulations if you got it. #CFC #Chelsea #ChelseaFC", 'game');
		}

		/**
		 * void
		 */
		function mssngVwls() {

			$pdo = new pdodb();
			$melinda = new melinda();
			$pdo->query("SELECT F_ID, F_NAME FROM cfc_games WHERE F_VWLS = 0 ORDER BY RAND() LIMIT 1");
			$row 		= $pdo->row();
			$vowels 	= array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", '_', " ");
			$name 		= strtoupper(str_replace($vowels, "", $row['F_NAME']));
			$length 	= strlen($name);
			$random 	= rand(1,$length);
			$mssngVwls 	= strrev(chunk_split (strrev($name), $random,' '));
			$answer 	= $this->_V($row['F_NAME']);
			$id 		= $row['F_ID'];
			$melinda->goTweet("Missing vowels game : {$mssngVwls}. #CFC #Chelsea #ChelseaFC", 'game');
			$pdo->query("UPDATE cfc_games SET F_VWLS='1' WHERE F_ID = :id ");
			$pdo->bind(':id',$id);
			$pdo->execute();
			sleep(1200);
			$melinda->goTweet("Answer was : {$answer}. Congratulations if you got it. #CFC #Chelsea #ChelseaFC ", 'game');
		}

		/**
		 * @param $code
		 * @return mixed
		 */
		function log($code) {

			// var_dump everything except arrays and objects
			if ( ! is_array( $code ) && ! is_object( $code ) ) :
				error_log( var_export( $code, TRUE ) );
			else :
				error_log( print_r( $code, TRUE ) );
			endif;
			return $code;
		}

		/**
		 * @param $code
		 * @return string
		 */
		function console($code) {

			return "<script>console.log('<?php print $code; ?>');</script>";
		}

		/**
		 * @param $code
		 * @return string
		 */
		function type($code) {

			$dollar = '<h5>'. gettype($code).'</h5>';
			$dollar .=  '<pre>';
			$dollar .=  print_r($code);
			$dollar .=  '</pre>';
			$dollar .=  '<hr/>';

			return $dollar;

		}

		/**
		 * @param $code
		 * @return mixed
		 */
		function screen($code) {

			?>
			<style>
				.tcr_debug { word-wrap: break-word; white-space: pre; text-align: left; position: relative;
					background-color: rgba(0, 0, 0, 0.8); font-size: 10px; color: #a1a1a1;
					padding: 10px; margin: 0 auto; width: 80%; overflow: auto;}
			</style>
			<br />
			<pre class="tcr_debug">
			<?php
			// var_dump everything except arrays and objects
			if ( ! is_array( $code ) && ! is_object( $code ) ) :
			{var_dump( $code );}
				{print_r( $code );}
			else:
			{print_r( $code, TRUE );}
			endif;
			echo '</pre><br />';

			return $code;
		}

		/**
		 * @param $code
		 */
		function end($code) {

			die( print_r( $code, TRUE ) );
		}

		/**
		 * Converts Referee into title displaying version
		 * @param $value
		 * @return string
		 */
		function displayRef($value) {

			$title_ref = explode(',',$value);
			$title_ref = $title_ref['1'] .' '.$title_ref['0'];
			return $this->_V($title_ref);
		}

		/**
		 * @param $status
		 * @param $message
		 * @param $type
		 * @param $data
		 * @return mixed|string|void
		 */
		function response($status,$message,$type,$data) {

			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Methods: *");
			header('Content-Type: application/json');
			header("HTTP/1.1 " . $status . " " . $this->responseMessage($status));
			header('Allow: GET');
			$return = array();
			$return['Status'] 	= $status;
			$return['Message'] 	= $message;
			$return['Type'] 	= $type;
			$return['Data'] 	= $data;

			if (phpversion('tidy') > 5.3) {
				return json_encode($return, JSON_PRETTY_PRINT);
			}
			else {
				return json_encode($return, 128);
			}
		}

		/**
		 * @param $code
		 *
		 * @return mixed
		 */
		function responseMessage($code) {

			$status = array(
				200 => 'OK',
				400 => 'Bad request',
				404 => 'Not Found',
				405 => 'Method Not Allowed',
				500 => 'Internal Server Error',
				501 => 'Not implemented',
			);

			return ($status[$code])?$status[$code]:$status[500];
		}

		/**
		 * @return int
		 */
		function getTimecomp () {

			return intval(time() - (10 * 60));
		}

		/**
		 * @param $value
		 *
		 * @return string
		 */
		function clean($value) {
			$value = addslashes($value);
			$value = strip_tags($value);
			$value = htmlspecialchars($value);

			return $value;
		}

		/**
		 * @param $table
		 * @param $field
		 * @return mixed
		 */
		function getPlayerDataFromField($table, $field) {

			$pdo = new pdodb();
			$sql = "SELECT F_NAME, SUM({$field}) AS F_VALUE FROM {$table} 
					where F_DATE > (SELECT F_DATE from 000_config where F_LEAGUE='PL')
					group by F_NAME order by SUM({$field}) Desc";
			$pdo->query($sql);
			$players = $pdo->rows();
			$string  = "<h3>{$field}</h3>";
			foreach($players as $row) {
				if($row['F_VALUE'] > 0) {
					$string .= "{$this->_V($row['F_NAME'])} ({$row['F_VALUE']}), ";
				}
			}

			$string = substr($string,0, -2);
			$search = ',';
			$replace = ', and';

			return strrev(implode(strrev($replace), explode(strrev($search), strrev($string), 2)));
		}

		/**
	 * @param $table
	 * @param $field
	 * @return mixed
	 */
		function getPlayerPer90DataFromField($table, $field) {

		$pdo = new pdodb();
			$sql = "SELECT F_NAME, (sum({$field}) / (sum(X_MINUTES) / 90)) AS F_VALUE FROM {$table} 
					where F_DATE > (SELECT F_DATE from 000_config where F_LEAGUE='PL')
					group by F_NAME order by F_VALUE Desc";
			$pdo->query($sql);
			$players = $pdo->rows();
			$string  = "<h3>{$field}</h3>";
			foreach($players as $row) {
				if($row['F_VALUE'] > 0) {
					$string .= "{$this->_V($row['F_NAME'])} ({$row['F_VALUE']}), ";
				}
			}

		$string = substr($string,0, -2);
		$search = ',';
		$replace = ', and';

		return strrev(implode(strrev($replace), explode(strrev($search), strrev($string), 2)));
	}

		/**
		 * @param $message
		 */
		function processMessage( $message) {

			$melinda = new melinda();

			if ( strlen( $message ) > 140 ) {
				$melinda->goSlack( "tweet limit in : {$message}.", 'WslStats Bot', 'soccer', 'bots' );
			} else {
				$melinda->goTweet( $message, 'wsl' );
			}
		}

		/**
		 * @param $today
		 * @return mixed
		 */
		function getSeasonalDate($today) {

				$pdo = new pdodb;
				$sql = "SELECT F_LABEL from meta_seasons where '$today' >= F_SDATE and '$today' <= F_EDATE";
				$pdo->query($sql);
				$label = $pdo->row();
				$string = $label['F_LABEL'];

				return $string;
		}

		/**
		 * @return string
		 */
		function getThisYearNextYearFromDate() {
			return date( 'Y' ) . '-' . date( 'Y', strtotime( '+1 year' ) );
		}

		/**
		 * @param $yearMarker
		 * @return string
		 */
		function getShortDateID( $yearMarker ) {
			return substr( $yearMarker, 2, 4 );
		}

		/**
		 * @param $startingValue
		 * @return mixed
		 */
		function getYearMarkerFromDate( $startingValue ) {
			return str_replace( '-', '', $startingValue );
		}

	} // close class and init
$go = new utility();
