<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda            = new melinda();
	$go                 = new utility();
	$up                 = new updater();
	$temp_serialiser    = '';
	$base_url           = "https://chelseafc.com";
	$url	            = "http://www.chelseafc.com/news/latest-news.html";
	$fileStore	        = 'public_html/media/cron/cfcStore.txt';
	$today              = date('D j M Y');
	$serialised_store   = $up->getStoredValue($fileStore);
	$raw    = $up->getCurlResponse( $url );
	$raw    = $up->removeLines($raw);
	$table  = $up->subStringingByPosition('<h2 class="main-heading">Latest News</h2>','<form', $raw);

	$replace_array = array( '<header>', '</header>','class="img-responsive"','alt=""',
				'<h2 class="main-heading">','</h2>','<span class="article-type">',
				'<span class="article-time">','<div class="preview">',
				'<article class="article news-article item">','<a class="read-more"',
				'<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">','</span>','</div>',
			);
	$table 	= str_replace($replace_array, '', $table);

	$replace_for_breaks = array ('</h3>','<h3>');
	$table  = str_replace( $replace_for_breaks, '<br/>', $table);

	// remove tags but keep break
	$table  = strip_tags($table, '<br/>,<br>');

//	$url = preg_match('href="(.+)"', $table, $match);
//	print $found_url = $match[1];



	$table  = str_replace('href=','<br/>href=',$table);
	$table  = str_replace('">','<br/>',$table);
	$table  = str_replace( 'Next >', '', $table);
	$table  = str_replace('href="','',$table);
	$table  = explode('<br/>',$table); // make an array
	$table  = array_filter($table);
	$first  = array_shift($table);

	// once it is in a good format...
	$new_serialiser = '';
	$new_statement  = '';
	$arrays         = array_chunk($table, 4);

		foreach ($arrays as $array):
				$i1         = trim($array['0']); // url
				$i2         = strip_tags(trim($array['1'])); // date
				$i3         = str_replace(' - ',' ',strip_tags(trim($array['2']))); // title
				$i4         = strip_tags(trim($array['3'])); // body

				$area = ['News','news','Feature','feature','Column','column','  '];
				$i2 = str_replace($area,'',$i2);

				if($i2 == $today):
						$i1 = $go->goBitly($base_url.$i1);
					    $temp_serialiser[] = "{$i2} - {$i3} - {$i1}";
				endif;
		endforeach;

		// lets unserialize the data into an array and then diff it.
		// anything left should be actual news
		$old_array = unserialize($serialised_store);

		if(!is_array($old_array)) { $old_array = array(); }
		$messages = array_diff($temp_serialiser,$old_array);

		foreach ( $messages as $message ):
				if ( $message != '' ):
						$full_message = $message;
						$message = explode(' - ',$message);
						$date    = $message['0'];
						$title   = $message['1'];
						$bitly   = $message['2'];
						$tweet   = $go->tocfcwsTweet($title); // trims and adds space for link etc
						$melinda->goSlack( "*tocfcws:* {$tweet} - {$bitly}", 'tocfcws', 'cfc', 'bots' );
						$melinda->goTweet( "tocfcws: {$tweet} - {$bitly} #CFC", 'TOCFCWS');
						$melinda->goHooks("tocfcws:  {$tweet}", $bitly, '114');
						$melinda->goTelegram("<b>tocfcws:</b> {$tweet} - {$bitly} ");
				endif;
		endforeach;

	// Take the array, serialize it and then send it to the store.
	$new_serialised = serialize($temp_serialiser);
	$up->writeToFileStore($fileStore , $new_serialised );