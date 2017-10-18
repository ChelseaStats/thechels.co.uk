<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$melinda = new melinda();
	/* best of */
	$melinda->goTweet("1/ #FF Favourite accounts: @ChelseaFC @ChelseaLFC @ChelseaYouth @RickGlanvill @ChelseaChadder @10thmar1905", 'app');
	/* stats */
	$melinda->goTweet("2/ #FF #Stats @OptaJoe @StatsZone @InfostradaLive @EuroClubIndex @ChelseaChadder & @Stamford_bridge", 'app');
	/* supporting */
	$melinda->goTweet("3/ #FF We support the @ChelseaSTrust, @RightToPlay_Uk and @PlanUK #CFC", 'app');
	/* Ladies */
	$melinda->goTweet("4/ #FF #CFC #Chelsea @ChelseaLFC @CLFCFans @fyfawsl @WoSoZone for all your #CLFC needs.", 'app');
	/* Bots */
	$melinda->goTweet("5/ #FF Bots: @FawslStats @CountDownNoBot @ChelseaPuzzles @19thMayBot @HoroFootball.", 'app');
	/* ends */
	$melinda->goTweet("6/ #FF #CFC #Chelsea Thank you to all who follow, interact, and make this worthwhile #KTBFFH! & Up The Chels!", 'app');
	exit();
