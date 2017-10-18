<?php
	error_reporting(E_ERROR);

	define('DB_NAME'        , '*****');
	define('DB_USER'        , '*****');
	define('DB_PASSWORD'    , '*****');
	define('DB_HOST'        , 'localhost');
	date_default_timezone_set('Europe/London');
	if (!defined('ABSPATH')) { define('ABSPATH','cron')  or die(); }
	spl_autoload_register(function ($class_name) {

		// default
		$file = "public_html/media/core/{$class_name}.php";

		/** if localhost set other location */
				$whitelist = array(
					'127.0.0.1',
					'dev.io'
				);

				if(in_array($_SERVER['SERVER_ADDR'], $whitelist)){
					$file = "../core/{$class_name}.php";
					error_reporting(E_ALL);
					ini_set('display_errors',1);
				} 
		/** end this check */


		if (file_exists($file)) {
			/** @noinspection PhpIncludeInspection */
			require $file;
		} else {

			// project-specific namespace prefix
			$prefix = 'Abraham\\TwitterOAuth\\';

			// base directory for the namespace prefix
			$base_dir = 'public_html/media/core/twitteroauth/';

			// does the class use the namespace prefix?
			$len = strlen($prefix);
			if (strncmp($prefix, $class_name, $len) !== 0) {
				// no, move to the next registered autoloader
				return;
			}

			// get the relative class name
			$relative_class = substr($class_name, $len);

			// replace the namespace prefix with the base directory, replace namespace
			// separators with directory separators in the relative class name, append
			// with .php
			$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

			// if the file exists, require it
			if (file_exists($file)) {
				/** @noinspection PhpIncludeInspection */
				require $file;
			} else {
				print "file not found {$file}" . PHP_EOL;
			}
		}
	});

