<?php
	/*
	Plugin Name: CFC Melinda
	Description: Messenger class
	Version: 2.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	class melinda {

		/**
		 * wraps var in debugging pre tags
		 *
		 * @param string $var
		 * @return void
		 *
		 */
		function goDebug( $var ) {
			print '<hr/>';
			print 'type: '. gettype($var);
			print '<pre>';
			print_r( $var );
			print '</pre>';
			print '<hr/>';
		}

		/**
		 * @param        $message
		 * @param        $name
		 * @param        $icon
		 * @param string $room
		 * @return mixed
		 */
		function goSlack($message, $name, $icon, $room = "bots") {

			$room = ($room) ? $room : "bots";
			$icon = ($icon) ? $icon : "cfc";
			$data = json_encode(array(
				"username"      =>  $name,
				"channel"       =>  "#{$room}",
				"text"          =>  $message,
				"icon_emoji"    =>  ":{$icon}:"
			));

			$ch = curl_init('https://hooks.slack.com/services/****/*****/***********');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('payload' => $data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);

			return $result;
		}

		/**
		 * @param $message
		 * @param $url
		 * @param $id
		 *
		 * @return mixed
		 */
		function goHooks($message, $url, $id){

			$key = '*******';
			$data =  json_encode(array( "message" => $message, "url" =>  $url ));
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_URL, "https://api.gethooksapp.com/v1/push/".$id);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Hooks-Authorization: '.$key));
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($ch);
			curl_close($ch);

			return $response;

		}

		/**
		 * @param        $message
		 * @param        $user
		 */
		function goTweet( $message, $user ) {

			$user = strtoupper($user);
			switch($user) {
				case 'TEST':
				default:
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
		 * @param mixed $message
		 * @param string $title
		 * @param mixed $email
		 * @return void
		 */
		function goEmail( $message, $title, $email ) {
			if ( !isset( $email ) ) {
				$email = '***';
			}
			wp_mail( $email, 'New: ' . $title, $message );
		}

		/**
		 * @param mixed $message the content (string)
		 * @param mixed $alert the display type (styles)
		 * @return string
		 */
		function goMessage( $message, $alert ) {
			return '<div class="alert alert-' . $alert . '">' . $message . '</div>';
		}

		/**
		 * @param $message
		 * @return mixed
		 */
		function goTelegram($message) {
			
			$bot_token = '***';
			$channel_name = '****';
			$content = urlencode("{$message}");
			$url = "https://api.telegram.org/bot{$bot_token}/sendMessage?chat_id={$channel_name}&parse_mode=html&disable_web_page_preview=false&text={$content}";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$response = curl_exec($ch);
			curl_close($ch);

			return $response;
		}


	}

	$melinda = new melinda();