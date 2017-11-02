<?php
	/*
	Plugin Name: CFC Github Api Class
	Description: Allows the auto-creation of checklists (markdown).
	License: GPL
	Version: 1.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

	defined( 'ABSPATH' ) or die();

	require __DIR__ . '/Github/exceptions.php';
	require __DIR__ . '/Github/Sanity.php';
	require __DIR__ . '/Github/Helpers.php';

	require __DIR__ . '/Github/Storages/ICache.php';
	require __DIR__ . '/Github/Storages/ISessionStorage.php';
	require __DIR__ . '/Github/Http/IClient.php';

	require __DIR__ . '/Github/Storages/FileCache.php';
	require __DIR__ . '/Github/Storages/SessionStorage.php';

	require __DIR__ . '/Github/Http/Message.php';
	require __DIR__ . '/Github/Http/Request.php';
	require __DIR__ . '/Github/Http/Response.php';
	require __DIR__ . '/Github/Http/CachedClient.php';
	require __DIR__ . '/Github/Http/AbstractClient.php';
	require __DIR__ . '/Github/Http/CurlClient.php';
	require __DIR__ . '/Github/Http/StreamClient.php';

	require __DIR__ . '/Github/OAuth/Configuration.php';
	require __DIR__ . '/Github/OAuth/Token.php';
	require __DIR__ . '/Github/OAuth/Login.php';

	require __DIR__ . '/Github/Api.php';
	require __DIR__ . '/Github/Paginator.php';
