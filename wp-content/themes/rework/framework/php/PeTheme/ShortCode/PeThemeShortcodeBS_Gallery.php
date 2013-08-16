<?php

class PeThemeShortcodeBS_Gallery extends PeThemeShortcode {

	public $instances = 0;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "pegallery";
		$this->group = __pe("CONTENT");
		$this->name = __pe("Gallery / Slider");
		$this->description = __pe("Gallery");

		$this->fields = array(
							  "size" => 
							  array(
									"label"=>__pe("Size"),
									"type"=>"Text",
									"description" => __pe("The size of the gallery/slider in pixels. Only used in Slider and Fullscreen modes, written in the form widthxheight"),
									"default"=>"680x350"
									),
							  );
		$this->fields = array_merge($this->fields,PeGlobal::$const->gallery->metaboxPostNoSingle["content"]);

	}

	public function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.metabox.galleryPost.js",array('jquery'),"pe_theme_metabox_galleryPost");
		wp_enqueue_script("pe_theme_metabox_galleryPost");
	}

	protected function script() {
		$html = <<<EOT
<script type="text/javascript">
jQuery("#{$this->trigger}").peMetaboxGalleryPost({tag:"{$this->trigger}",id:"{$this->trigger}"});
</script>
EOT;
                echo $html;
        }

	public function render() {
		parent::render();
		$this->script();
	}


	public function output($atts,$content=null,$code="") {
		global $post;

		// damn shortcode_parse_atts is forcing lowercase parameters ..... so we fix here
		$ps = array("maxThumbs","lbType","lbScale");
		foreach ($ps as $p) {
			$lc = strtolower($p);
			if (isset($atts[$lc])) {
				$atts[$p] = $atts[$lc];
				unset($atts[$lc]);
			}
		}

		$gallery = (object) $atts;

		list($w,$h) = explode("x",$gallery->size);

		$t =& peTheme();
		ob_start();
		$t->template->get_part(compact("gallery","w","h"),"intro-post","gallery");
		$content =& ob_get_contents();
		ob_end_clean();
		return $content;

	}


}

?>
