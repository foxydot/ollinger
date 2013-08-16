<?php

class PeThemeReworkAsset extends PeThemeAsset  {

	public function __construct(&$master) {
		$this->minifiedJS = "theme/compressed/theme.min.js";
		$this->minifiedCSS = "theme/compressed/theme.min.css";
		parent::__construct($master);
	}

	public function registerAssets() {
		add_filter("pe_theme_js_init_file",array(&$this,"pe_theme_js_init_file_filter"));
		add_filter("pe_theme_js_init_deps",array(&$this,"pe_theme_js_init_deps_filter"));
		
		parent::registerAssets();

		if ($this->minifyCSS) {
			$deps = 
				array(
					  "pe_theme_compressed"
					  );
		} else {

			// theme styles
			$this->addStyle("css/flexslider.css",array(),"pe_theme_rework_flexslider");
			$this->addStyle("css/style.css",array(),"pe_theme_rework_styles");


			$deps = 
				array(
					  "pe_theme_rework_flexslider",
					  "pe_theme_rework_styles",
					  );
		}

		$this->addStyle("style.css",$deps,"pe_theme_init");
		
		$this->addScript("js/jQuery.BlackAndWhite.min.js",array("jquery"),"pe_theme_rework_blackwhite");
		$this->addScript("js/jquery.easing-1.3.min.js",array("jquery"),"pe_theme_rework_easing");
		$this->addScript("js/jquery.flexslider-min.js",array("jquery"),"pe_theme_rework_flexslider");
		$this->addScript("js/jquery.isotope.min.js",array("jquery"),"pe_theme_rework_isotope");
		$this->addScript("js/jquery.jcarousel.min.js",array("jquery"),"pe_theme_rework_jcarousel");
		$this->addScript("js/jquery.fitvid.js",array("jquery"),"pe_theme_rework_fitvid");
		$this->addScript("js/respond.min.js",array("jquery"),"pe_theme_rework_respond");
		$this->addScript("js/selectnav.min.js",array("jquery"),"pe_theme_rework_selectnav");
		$this->addScript("js/init.js",array("jquery"),"pe_theme_rework_init");

	}

	public function pe_theme_js_init_file_filter($js) {
		return "js/custom.js";
	}

	public function pe_theme_js_init_deps_filter($deps) {
		return array(
					 "jquery",
					 "pe_theme_rework_blackwhite",
					 "pe_theme_rework_easing",
					 "pe_theme_rework_flexslider",
					 "pe_theme_rework_isotope",
					 "pe_theme_rework_jcarousel",
					 "pe_theme_rework_fitvid",
					 "pe_theme_rework_respond",
					 "pe_theme_rework_selectnav",
					 "pe_theme_widgets_contact",
					 "pe_theme_widgets_twitter",
					 "pe_theme_widgets_flickr",
					 "pe_theme_widgets_gmap",
					 "pe_theme_rework_init"
					 );
	}

	public function style() {
		bloginfo("stylesheet_url"); 
	}

	public function enqueueAssets() {
		$this->registerAssets();
		
		wp_enqueue_style("pe_theme_init");
		wp_enqueue_script("pe_theme_init");

	}


}

?>