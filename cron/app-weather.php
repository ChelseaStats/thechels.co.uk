<?php
	require_once( dirname(__DIR__).'/autoload.php');

	$m      = new melinda();
	$up     = new updater();
	$date   = date( 'j M Y' );
	$postcodes = ['SW6 1HS'];

	foreach($postcodes as $postcode) :

		$posty      = urlencode($postcode);
		$url        = "https://query.yahooapis.com/v1/public/yql?q=SELECT%20item.forecast%2Clocation%20FROM%20weather.forecast%20WHERE%20woeid%20in%20(SELECT%20woeid%20FROM%20geo.places(1)%20WHERE%20text%20in%20('.$posty.'%2C'England'))%20AND%20u%3D'c'%20LIMIT%203&format=json&callback=";

		$raw  = $up->getJsonFromCurl($url);

		foreach ( $raw->query->results->channel as $channel ) :

			$weatherLoc  = $channel->location->city;
			$weatherDate = $channel->item->forecast->date;
			$weatherHigh = $channel->item->forecast->high;
			$weatherLow  = $channel->item->forecast->low;
			$weatherDesc = $channel->item->forecast->text;
			$weatherDesc = strtolower( $weatherDesc );

			if ( isset( $weatherDate ) && $date == $weatherDate ) :
				if ( isset( $weatherLow ) && isset( $weatherLoc ) && isset( $weatherHigh ) && isset( $weatherDesc ) ) :
					$m->goSlack( "The forecast for {$weatherLoc} on {$weatherDate} is lows of {$weatherLow}°C with highs of {$weatherHigh}°C and {$weatherDesc}. Have a nice day!", 'WeatherBot','cloud', 'bots');
				endif;
			endif;

		endforeach;
	
	endforeach;