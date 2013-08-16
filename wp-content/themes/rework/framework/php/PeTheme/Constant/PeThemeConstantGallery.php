<?php

class PeThemeConstantGallery {
	public $id;
	public $metabox;
	public $all;

	public function __construct() {
		$this->all =& peTheme()->gallery->option();
		$this->id =
			array(
				  "label"=>__pe("Use Gallery"),
				  "type"=>"Select",
				  "description" => __pe("Select which gallery to use as content. For a gallery to appear in this list it must first be created. See the help documentation section on 'Creating a Gallery Custom Post Type'"),
				  "options" => $this->all,
				  "default"=>""
				  );
		
		if (isset(PeGlobal::$config["sliders"]) && is_array($availableSliders =& PeGlobal::$config["sliders"])) {
			if (count($availableSliders) > 1) {
				$default = reset($availableSliders);
				$sliderOptions["plugin"] =
					array(
						  "label" => __pe("Slider Type"),
						  "type" => "SelectSlider",
						  "description" => __pe("Time in seconds before the slider rotates to next slide"),
						  "options" => PeGlobal::$config["sliders"],
						  "default" => $default
						  );
			}
			foreach ($availableSliders as $descr=>$slider) {
				foreach (PeGlobal::$const->{"_$slider"}->options as $name=>$option) {
					$sliderOptions["slider_{$slider}_{$name}"] =& $option;
				}
			}
		}


		$galleryTypes[__pe("Direct Upload")] = "upload";
		$galleryTypes[__pe("Media Tag (any)")] = "any";
		$galleryTypes[__pe("Media Tag (any)")] = "all";
							   
		$this->metabox = 
			array(
				  "title" => __pe("Gallery Options"),
				  "type" => "Gallery",
				  "priority" => "core",
				  "where" =>
				  array(
						"gallery" => "all"
						),
				  "content" =>
				  array(
						"type" => 
						array(
							  "label" => __pe("Images"),
							  "type" => "Select",
							  "description" => __pe("<strong>Direct upload</strong> lets you add images by dragging and dropping them directly from your computer.<br/><strong>Media Tag</strong> includes all the already uploaded images that match the selected media tags. See the help documentation for an explanation of Media Tags"),
							  "options" => $galleryTypes,
							  "default" => "upload"
							  ),
						"sort" =>
						array(
							  "label" => __pe("Sorting"),
							  "description" => __pe("Sorting"),
							  "type" => "RadioUI",
							  "options" => Array(__pe("Newest First")=>"auto",__pe("Manual")=>"custom"),
							  "default" => "auto"
							  ),
						"tags" =>
						array(
							  "label" => __pe("Media Tags"),
							  "type" => "Tags",
							  "taxonomy" => PE_MEDIA_TAG,
							  "description" => __pe("The list on the left shows all existing media tags. These tags are automatically added to uploaded content to allow for easy reuse and organisation of all media content. Select the tags from which you would like to include their related media, in this gallery. Once you have made your selection, click the \"Refresh\" button in the \"Gallery Content\" section below. See the help documentation for a detailed explanation of Media Tags"),
							  "default" => ""
							  ),
						"images" =>
						array(
							  "label" => __pe("Upload Gallery Images"),
							  "description" => __pe("Add one or more media tags"),
							  "type" => "DropUpload",
							  "default" => ""
							  )
						)
				  
				  );

		$this->metaboxPost = 
			array(
				  "title" => __pe("Gallery Options"),
				  "type" => "GalleryPost",
				  "priority" => "core",
				  "where" =>
				  array(
						"post" => "gallery"
						),
				  "content" =>
				  array(
						"id" => $this->id,
						"type" => 
						array(
							  "label" => __pe("Show Images As"),
							  "type" => "Select",
							  "description" => __pe("Specify how the gallery's content images will be displayed"),
							  "options" => 
							  array(
									__pe("Thumbnails grid")=>"thumbnails",
									__pe("Fullscreen lightbox")=>"fullscreen",
									__pe("Single images")=>"single",
									__pe("Slider")=>"slider"
									),
							  "default" => "thumbnails"
							  ),
						"maxThumbs" => 
						array(
							  "label"=>__pe("Thumbnails"),
							  "type"=>"Text",
							  "description" => __pe("Maximum number of thumbnails to show in the main page. Regardless this setting, all gallery images would still be shown inside the lightbox window."),
							  "default"=>"1000"
							  ),
						)
				  );

		$mbc =& $this->metaboxPost["content"];

		if (isset($sliderOptions)) {
			$this->metaboxPost["content"] =& array_merge($mbc,$sliderOptions);
		}

		$this->metaboxPost["content"] =& 
			array_merge(
						$this->metaboxPost["content"],
						array(
							  "title" => 
							  array(
									"label"=>__pe("Show Gallery Title"),
									"type"=>"RadioUI",
									"description" => __pe("Specify how the gallery's title will be shown. This mainly applies to the fullscreen lightbox gallery option. <strong>Gallery</strong> keeps the original gallery name as its title. <strong>Custom</strong> allows a custom gallery name to be used for just this instance. <strong>None</strong> hides the gallery title"),
									"options" => 
									array(
										  __pe("Gallery")=>"gallery",
										  __pe("Custom")=>"custom",
										  __pe("None")=>"none"
										  ),
									"default"=>"gallery"
									),
							  "custom" => 
							  array(
									"label"=>__pe("Custom Title"),
									"type"=>"Text",
									"description" => __pe("Optional gallery title"),
									"default"=>""
									),
							  "link" => 
							  array(
									"label"=>__pe("Custom Link"),
									"type"=>"Text",
									"description" => __pe("When set and gallery type = \"fullscreen\", cover click will load this page instead of the fullscreen lightbox gallery."),
									"default"=>""
									),
							  "lbType" => 
							  array(
									"label"=>__pe("Lightbox Gallery Transition"),
									"type"=>"Select",
									"description" => __pe("Choose image transition when viewed inside the lightbox: <strong>Slide</strong> Slides left/right. <strong>Shutter</strong> Black and white zoom effect. <strong>Default</strong> selects transition based on <i>Show Images As</i> value: Slide for Thumnails grid, Shutter for Fullscreen."),
									"options" => 
									array(
										  __pe("Default")=>"",
										  __pe("Slide")=>"default",
										  __pe("Shutter")=>"shutter",
										  ),
									"default"=>""
									),
							  "lbScale" =>
							  array(
									"label"=>__pe("Scale Mode"),
									"type"=>"Select",
									"section"=>__pe("General"),
									"description" => __pe("This setting determins how the images are scaled / cropped when displayed in the browser window.\"<strong>Fit</strong>\" fits the whole image into the browser ignoring surrounding space.\"<strong>Fill</strong>\" fills the whole browser area by cropping the image if necessary. The Max version will also upscale the image."),
									"options" => array(
													   __pe("Fit")=>"fit",
													   __pe("Fit (Max)")=>"fitmax",
													   __pe("Fill")=>"fill",
													   __pe("Fill (Max)")=>"fillmax"
													   ),
									"default"=>"fit"
									),
							  "delay" => 
							  array(
									"label" => __pe("Delay"),
									"type" => "Select",
									"description" => __pe("Time in seconds before the slider rotates to next slide"),
									"options" => PeGlobal::$const->data->delay,
									"default" => 0
									)
							  )
						);

		// clone
		$this->metaboxPostNoSingle = unserialize(serialize($this->metaboxPost));
		$this->metaboxPostNoSingle["content"]["type"]["options"] = 
			array(
				  __pe("Thumbnails grid")=>"thumbnails",
				  __pe("Fullscreen lightbox")=>"fullscreen",
				  __pe("Slider")=>"slider"
				  );


		$this->metaboxSlider = 
			array(
				  "title" => __pe("Slider Options"),
				  "priority" => "core",
				  "where" =>
				  array(
						"page" => "page-home"
						),
				  "content" =>
				  array(
						"id" => $this->id
						)
				  );

		$mbc =& $this->metaboxSlider["content"];

		if (isset($sliderOptions)) {
			$this->metaboxSlider["content"] =& array_merge($mbc,$sliderOptions);
			$mbc =& $this->metaboxSlider["content"];
		}

		$mbc["delay"] = 
				  array(
						"label" => __pe("Delay"),
						"type" => "Select",
						"description" => __pe("Time in seconds before the slider rotates to next slide"),
						"options" => PeGlobal::$const->data->delay,
						"default" => 0
						);


	}
	
}

?>