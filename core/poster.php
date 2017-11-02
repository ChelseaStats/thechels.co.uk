<?php
/*
Plugin Name: CFC Auto Poster
Description: auto posts pending articles
Version: 4.0.0
Author: ChelseaStats
Plugin URI: https://thechels.co.uk
Author URI: https://thechels.co.uk
Copyright (c) 2016 ChelseaStats Limited
*/

	defined( 'ABSPATH' ) or die();

	register_activation_hook( __FILE__, 'aps_activation' );
	register_deactivation_hook( __FILE__, 'aps_deactivation' );

	add_action( 'aps_auto_post_hook'    , 'aps_auto_post');
	add_action( 'wp_head'               , 'aps_heartbeat');
	add_filter( 'cron_schedules'        , 'aps_set_next_schedule', 99);

	/**
	 * Activated and sets defaults.
	 */
	function aps_activation() {

    add_option('aps_enabled'		, TRUE);
    add_option('aps_pending'		, TRUE);
    add_option('aps_post_types'		, 'post');
    add_option('aps_hours_mon'		, '0800-1900');
    add_option('aps_hours_tue'		, '0800-1900');
    add_option('aps_hours_wed'		, '0800-1900');
    add_option('aps_hours_thu'		, '0800-1900');
    add_option('aps_hours_fri'		, '0800-1900');
    add_option('aps_hours_sat'		, '0800-1200');
    add_option('aps_hours_sun'		, '0800-1200');
    add_option('aps_next'			, '24');
    add_option('aps_next_time'		, __('hours', 'auto-poster' ) );
    add_option('aps_batch'			, 1);
    add_option('aps_max_per_day'	, '0');
    add_option('aps_num_day'		, '0,0');
    add_option('aps_restart'		, FALSE);

	}

	/**
	 * deactivates
	 */
	function aps_deactivation() {
    wp_clear_scheduled_hook('aps_auto_post_hook');
    update_option('aps_enabled', FALSE);

	}

	/**
	 * @param $msg
	 */
	function aps_write_log($msg) {
		$melinda = new melinda();
		$message = date( 'Y-m-d H:i:s', current_time( "timestamp" ) - ( current_time( "timestamp" ) % 3600 ) ) . "\t - " . $msg . "\n";
		$melinda->goSlack( $message, 'Auto Poster Bot', 'robot_face', 'bots' );
	}

	/**
	 * @return string|void
	 */
	function aps_schedule_event() {
		wp_clear_scheduled_hook( 'aps_auto_post_hook' );
		if ( wp_schedule_event( time() - ( time() % 3600 ), 'aps_schedule', 'aps_auto_post_hook' ) !== FALSE ) {
			$str = __( "Auto Poster Enabled!", 'auto-poster' );
		} else {
			$str = __( "Error with wp_schedule_event for aps_auto_post_hook!", 'auto-poster' );
		}

		return $str;
	}

	/**
	 * @param $num
	 * @param $timeperiod
	 *
	 * @return int
	 */
	function aps_time_seconds($num,$timeperiod) {
		if ( $timeperiod == 'days' ) {
			$timeval = 3600 * 24;
		} else if ( $timeperiod == 'hours' ) {
			$timeval = 3600;
		} else {
			$timeval = 1;
		}
		// is this a range? i.e 2-6? pick a random time between them
		if ( preg_match( "/(\d+)\s*\D+\s*(\d+)/", $num, $matches ) ) {
			$random = mt_rand( $matches[1] * $timeval, $matches[2] * $timeval );

			return $random;
		} else {
			return (int) ( $num * $timeval );
		}
	}

	/**
	 * Checkes auto post hook is set
	 */
	function aps_heartbeat() { // absolutely ensure our aps event is still scheduled!
		if ( FALSE == get_option( 'aps_enabled' ) ) {    // APS is not enabled - do nothing
			return;
		}
		if ( wp_next_scheduled( 'aps_auto_post_hook' ) ) { // event hook exists - do nothing
			return;
		}
		// some other code/plugin has stomped our event hook! reset
		aps_write_log( "Notice! APS enabled but 'aps_auto_post_hook' mysteriously removed. Resetting..." );
		aps_schedule_event();
	}

	/**
	 * @param $schedules
	 * @return mixed
	 */
	function aps_set_next_schedule($schedules) {    // add custom time when to check for next auto post
		if ( FALSE == get_option( 'aps_enabled' ) ) { // APS is not enabled - do nothing
			return $schedules;
		}

		$timesecs                  = aps_time_seconds( get_option( 'aps_next' ), get_option( 'aps_next_time' ) );
		$schedules['aps_schedule'] = array (
			'interval' => $timesecs,
			'display'  => 'Auto Poster Check'
		);

		return $schedules;
	}

	/**
	 * @return int
	 */
	function aps_time_check() {

		// check if there are day/hour limits
		$today     = strtolower( date( "D", current_time( "timestamp" ) ) );
		$aps_hours = get_option( 'aps_hours_' . $today );

		if ( $aps_hours == '0' ) { // 0 = no posts for this day
			return 0;
		}
		if ( ! empty( $aps_hours ) ) {
			$time   = date( "Hi", current_time( "timestamp" ) );
			$ranges = explode( ",", $aps_hours );
			foreach ( $ranges as $range ) {
				$hours = explode( "-", $range );
				if ( count( $hours ) != 2 ) {
					aps_write_log( sprintf( __( "Error: %s time range of %s not recognized.", 'auto-poster' ), $today, $range ) );
				}
				if ( $hours[0] <= $time && $time <= $hours[1] ) {
					return 1;
				}
			}

			return 0;
		}

		return 1;
	}

	/**
	 * Do the posting
	 */
	function aps_auto_post() {

		$aps_enabled = (bool) get_option( 'aps_enabled' );
		if ( $aps_enabled == FALSE ) {
			return;
		}

		$aps_pending    = (bool) get_option( 'aps_pending' );
		$aps_batch      = (int) get_option( 'aps_batch' );
		$aps_post_types = get_option( 'aps_post_types' );
		if ( ! aps_time_check() ) {
			return;
		}

		$aps_max_per_day = get_option( 'aps_max_per_day' );
		$aps_num_day     = explode( ",", get_option( 'aps_num_day' ) ); # example: 4,2 = today the 4th of the month, 2 posts already published today
		$today           = date( 'd', current_time( "timestamp", 1 ) );
		if ( $aps_num_day[0] && $aps_num_day[0] != $today ) # if new day, reset num
		{
			$day_num = 0;
		} else {
			$day_num = isset( $aps_num_day[1] ) ? $aps_num_day[1] : 0;
		}
		if ( $aps_max_per_day && $day_num >= $aps_max_per_day ) {
			return;
		}

		// set up the basic post query
		$post_types = explode( ',', $aps_post_types );

		$args = array (
			'posts_per_page'      => $aps_batch,
			'post_type'           => $post_types,
			'ignore_sticky_posts' => TRUE
		);

		$post_statuses = array ();
		if ( $aps_pending == TRUE ) {
			$post_statuses[] = 'pending';
		}

		$results = NULL;
		if ( ! empty( $post_statuses ) ) {
			$args['post_status'] = $post_statuses;
		}
		$args['order'] = "ASC";

		$args    = apply_filters( 'aps_eligible_query', $args );
		$results = new WP_Query( $args );

		if ( $results->have_posts() ) {
			// cycle through results and update
			$cnt = $min_age = 0;

			while ( $results->have_posts() && $cnt < $aps_batch ) {
				$results->the_post();
				$id     = get_the_ID();
				$status = get_post_status( $id );
				if ( $min_age && $status == "publish" ) { // our special case to check
					$now_date  = current_time( "timestamp" ) - ( current_time( "timestamp" ) % 3600 );
					$post_date = get_the_date( 'r' );
					$post_date = strtotime( $post_date ) - ( strtotime( $post_date ) % 3600 );
					$diff      = $now_date - $post_date;
					if ( $diff <= $min_age ) { // this post not aged enough to recycle
						continue;
					}
				}


				$update                  = array ();
				$update['ID']            = $id;
				$update['post_status']   = 'publish';
				$update['post_date_gmt'] = date( 'Y-m-d H:i:s', ( current_time( "timestamp", 1 ) - ( current_time( "timestamp", 1 ) % 3600 ) ) );
				$update['post_date']     = get_date_from_gmt( $update['post_date_gmt'] );
				if ( $status == "publish" ) {
					$update = apply_filters( 'aps_recycle_post', $update );
				} else {
					$update = apply_filters( 'aps_update_post', $update );
				}
				update_option( 'aps_updating', TRUE );
				kses_remove_filters();
				wp_update_post( $update );
				kses_init_filters();
				update_option( 'aps_updating', FALSE );
				$cnt ++;
				$day_num ++;

			}
			if ( $cnt < $aps_batch ) {
				// only happens for special case check
				//  aps_write_log( __("Unable to find eligible posts to publish.", 'auto-poster' ) );
				// nothing to publish, nothing to worry about
			} else { // update aps_num_day
				$aps_num_day = date( 'd' ) . "," . $day_num;
				update_option( 'aps_num_day', $aps_num_day );
			}
		} else {
			// aps_write_log( __("Unable to find eligible posts to publish.", 'auto-poster' ) );
			// nothing to publish, nothing to worry about
		}
	}
