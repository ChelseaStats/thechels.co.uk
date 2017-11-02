<?php
	/*
	Plugin Name: CFC TwitteroAuth Library
	Description: Adds Abraham's famous twitter lib
	Version: 1.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	spl_autoload_register(function ($class) {

		// project-specific namespace prefix
		$prefix = 'Abraham\\TwitterOAuth\\';

		// base directory for the namespace prefix
		$base_dir = __DIR__ . '/twitteroauth/';

		// does the class use the namespace prefix?
		$len = strlen($prefix);
		if (strncmp($prefix, $class, $len) !== 0) {
			// no, move to the next registered autoloader
			return;
		}

		// get the relative class name
		$relative_class = substr($class, $len);

		// replace the namespace prefix with the base directory, replace namespace
		// separators with directory separators in the relative class name, append
		// with .php
		$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

		// if the file exists, require it
		if (file_exists($file)) {
			/** @noinspection PhpIncludeInspection */
			require $file;
		}
	});
