<?php
	/*
	Plugin Name: CFC Lister
	Description: Twitter List Feeder
	License: GPL
	Version: 1.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	class lister {

		/**
		 * publisher constructor.
		 */
		function __construct() {
		}

		/**
		 * @param $tweet
		 * @return mixed
		 */
		function writeLinks($tweet){

			//for http links
			$tweet = preg_replace('!http://([a-zA-Z0-9./-]+[a-zA-Z0-9/-])!i', ' <a href="\\0" target="_blank">\\0</a> ', $tweet);

			// for https links because my regex is lame.
			$tweet = preg_replace('!https://([a-zA-Z0-9./-]+[a-zA-Z0-9/-])!i', ' <a href="\\0" target="_blank">\\0</a> ', $tweet);

			//for hash tags
			$tweet = preg_replace("/#([a-z_0-9]+)/i", "<a href=\"http://twitter.com/search/$1\">$0</a>", $tweet);

			//for mentions
			$tweet = preg_replace("/\B[@]([a-zA-Z0-9_]{1,20})/i", ' <a target="_blank" class="twtr-atreply" href="http://twitter.com/$1">@$1</a> ',$tweet);


			// the order of the regexes is very important.
			return $tweet;

		}

		/**
		 * @param $filename
		 * @return string
		 */
		function fetchTweets($filename) {

			// twitteroauth should be in the global to be used here
			$consumerKey 		= '******';
			$consumerSecret 	= '******';
			$accessToken 		= '******';
			$accessTokenSecret  = '******';

			$connection = new \Abraham\TwitterOAuth\TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);

			$statuses = $connection->get('lists/statuses',
				array('count' => 50,
				      'slug'=> $filename,
				      'owner_screen_name'=>'******',
				      'include_rts' => false,
				      'include_entities'=>'false',
				      'exclude_replies' => true)
			);

			$tweet ='';

			foreach($statuses as $status):
				$date = date('Y-m-d H:i:s', strtotime($status->created_at));
				$tweet .= '<li><span class="stamp">'. $date .'</span> @'. $status->user->screen_name .' :- <p style="text-align:left;">'. $status->text .'</p></li>';
			endforeach;

			$file	= $filename.'.txt';
			$data = array ('tweet' => $tweet, 'timestamp' => time());
			file_put_contents($file, serialize($data));
			return $tweet;
		}

		/**
		 * @param $filename
		 */
		function getTweets($filename) {

			$file	=  $filename.'.txt';

			if (file_exists($file)) {

				$data = unserialize(file_get_contents($file));

				if ( ($data['timestamp'] - $this->getTimecomp()) > 0 ) {

					// there is a cached tweet
					$tweet = '(cached for upto 10 minutes)</p>'. $data['tweet']  .'</ul>';

				} else {
					// tweet has expired or is missing
					$tweet = '(cache expired, these are fresh)</p><ul>'. $this->fetchTweets($filename) .'</ul>';

				}
			}
			else {
				// file does not exist
				$tweet = '(cache missing, these are new)</p><ul>'. $this->fetchTweets($filename) .'</ul>';
			}


			// $tweet = fetchTweets();
			print $this->writeLinks($tweet);
		}

		/**
		 * @return int
		 */
		function getTimecomp () {

		return intval(time() - (10 * 60));

		}

	}
