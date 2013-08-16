<?php

class PeThemeConstantReworkGallery extends PeThemeConstantGallery {

	public function __construct() {
		parent::__construct();

		$this->metaboxPost = 
			array(
				  "title" => __pe("Slider Options"),
				  "type" => "GalleryPost",
				  "priority" => "core",
				  "where" =>
				  array(
						"post" => "gallery"
						),
				  "content" =>
				  array(
						"id" => $this->id,
						"width" =>
						array(
							  "label"=>__pe("Width"),
							  "type"=>"Text",
							  "default"=> "680"
							  ),
						"height" =>
						array(
							  "label"=>__pe("Height"),
							  "type"=>"Text",
							  "description" => __pe("Leave empty to avoid image cropping. In this case, all your (original) images must have the same size for the slider to work correctly"),
							  "default"=> "224"
							  ),
						)
				  );

		unset($this->metaboxSlider["content"]["delay"]);

	}
	
}

?>