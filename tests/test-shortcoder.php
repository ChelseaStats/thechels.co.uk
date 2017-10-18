<?php
	if(!defined('ABSPATH')) { define( 'ABSPATH' , TRUE); }

	require_once (__DIR__ ."/index.php");
	require __DIR__ . "/../core/shortcoder.php";
	
	class ShortcoderTests extends PHPUnit_Framework_TestCase {

		public function testMethodsReturnStrings() {

			$sc = new shortcoder();
			$atts = array('href' => 'https://');

			$this->assertStringStartsWith('<div class="alert alert-success">', $sc->fan_func($atts));
			$this->assertStringStartsWith('<div class="bs-callout bs-statszone">', $sc->statsz_func());
			$this->assertStringStartsWith('<div class="bs-callout bs-cann">', $sc->cann_foot_func());

			$this->assertStringStartsWith('<p>&nbsp;</p>', $sc->bet_shortcode($atts));

			$this->assertStringStartsWith('<div class="bs-callout bs-chelsea">', $sc->chelseastat_shortcode($atts));
			$this->assertStringStartsWith('<div class="bs-callout bs-referee">', $sc->refereestat_shortcode($atts));
			$this->assertStringStartsWith('<div class="bs-callout bs-opposition">', $sc->oppositionstat_shortcode($atts));

			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->fancy_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->prod_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->charts_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->shotsleague_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->shotsonleague_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->progresscfc_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->progress_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->progress_wsl_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->last38_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->firstxgames_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->lastxgames_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->cann_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->gdl_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->sixes_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->pls_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->plcc_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->ccbm_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->shotsanalysis_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->locals_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->crps_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->subsperf_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->passdiff_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->passstats_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->hs_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->otd_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->daily_func());
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->dyk_shortcode($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->auth_shortcode());

			$this->assertStringStartsWith('<p style="text-align:justify;">', $sc->src_shortcode($href = 'https://thechels.co.uk'));


			$this->assertStringStartsWith('<p style="text-align: justify;" class="alert alert-success">', $sc->eci_func($atts));
			$this->assertStringStartsWith('<p style="text-align:justify;" class="alert alert-info">', $sc->ask_shortcode());
			$this->assertStringStartsWith('<p style="text-align:justify;" class="alert alert-success">', $sc->chad_func($atts));


		}


	}
	