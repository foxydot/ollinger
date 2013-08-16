<?php

class PeThemeCaption {

	protected $master;
	protected $fields;

	public function __construct(&$master) {
		$this->master =& $master;
	}

	public function registerAssets() {
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.captionManager.js",array("pe_theme_utils","json2"),"pe_theme_caption_manager");
		wp_enqueue_script("pe_theme_caption_manager");

		// prototype.js alters JSON2 behaviour, it shouldn't be loaded in our admin page anyway but
		// if other plugins are forcing it in all wordpress admin pages, we get rid of it here.
		wp_deregister_script("prototype");
	}

	public function instantiate() {
		// check if admin is needed
		if (!is_admin() || !(current_user_can('edit_posts') || current_user_can('edit_pages'))) {
			return;
		}
		
		$this->registerAssets();

		$fields = array(
						"link" => 
						array(
							  "label"=>__pe("Link"),
							  "type"=>"Text",
							  "section"=>"main",
							  "description" => __pe("Optional image links."),
							  "default"=> ""
							  ),
						"caption" => 
						array(
							  "label"=>__pe("Caption"),
							  "type"=>"TextArea",
							  "section"=>"main",
							  "description" => __pe("Optional Caption Text."),
							  "default"=> ""
							  ),
						/*
						"captions" => 
						array(
							  "label"=>__pe("Captions"),
							  "type"=>"Links",
							  "section"=>"main",
							  "description" => __pe("Set the title (internal use only) and click 'Add new' to create a new caption."),
							  "button_label" => __pe("Add New"),
							  "sortable" => true,
							  //"auto" => __pe("Caption "),
							  "editable" => true,
							  "default" => ""
							  ),
						*/
						"save" => 
						array(
							  "label"=>__pe("Accept changes and close the dialog"),
							  "type"=>"Button",
							  "section"=>"main",
							  "description" => __pe("Remember to publish -> update the Gallery post for changes to be saved."),
							  "default"=> ""
							  )
						/*
						"align" => 
						array(
							  "label"=>__pe("Alignment"),
							  "type"=>"Select",
							  "section"=>"edit",
							  "options"=> PeGlobal::$const->image->align,
							  "description" => __pe("Caption alignment."),
							  "default"=> "center,left"
							  ),
						"offset" => 
						array(
							  "label"=>__pe("Margins (Top, Left)"),
							  "type"=>"Text",
							  "section"=>"edit",
							  "description" => __pe("Once caption is aligned, you can set additional margins. The paramenter accepts values in the format 'top,left' where 'top' and 'left' are numbers (pixels) which can also be negative."),
							  "default"=> "0,0"
							  ),
						"transition" => 
						array(
							  "label"=>__pe("Transition Type"),
							  "type"=>"Select",
							  "section"=>"edit",
							  "options"=>
							  array(
									__pe("Fade") => "fade",
									__pe("Fly from left") => "flyLeft",
									__pe("Fly from right") => "flyRight",
									__pe("Fly from top") => "flyTop",
									__pe("Fly from bottom") => "flyBottom",
									),
							  "description" => __pe("Caption animation type."),
							  "default"=>"fade"
							  ),
						"delay" => 
						array(
							  "label"=>__pe("Initial Delay"),
							  "type"=>"Text",
							  "section"=>"edit",
							  "description" => __pe("Delay in seconds before the caption animations begins."),
							  "default"=> "0"
							  ),
						"backgroundColor" =>
						array(
							  "label"=>__pe("Background color"),
							  "type"=>"Color",
							  "section"=>"edit",
							  "description" => __pe("Caption background color"),
							  "default"=> "#000000"
							  ),
						"backgroundAlpha" =>
						array(
							  "label"=>__pe("Background opacity."),
							  "type"=>"Select",
							  "section"=>"edit",
							  "options"=>
							  array(
									__pe("No background") => "",
									__pe("10%") => "0.1",
									__pe("20%") => "0.2",
									__pe("30%") => "0.3",
									__pe("40%") => "0.4",
									__pe("50%") => "0.5",
									__pe("60%") => "0.6",
									__pe("70%") => "0.7",
									__pe("80%") => "0.8",
									__pe("90%") => "0.9",
									__pe("100%") => "1",
									),
							  "description" => __pe("Caption background opacity."),
							  "default"=> "0.5"
							  ),
						"visibility" => 
						array(
							  "label"=>__pe("Visible for"),
							  "type"=>"Select",
							  "section"=>"edit",
							  "options"=>
							  array(
									__pe("All devices") => "pe_visible_all",
									__pe("Phones in landscape mode, Tablets, Desktops") => "pe_visible_landscape",
									__pe("Tablets, Desktops") => "pe_visible_tablet",
									__pe("Desktops") => "pe_visible_desktop"
									),
							  "description" => __pe("Controls caption visibility according to device viewport width."),
							  "default"=>"pe_visible_tablet"
							  ),
						"content" => 
						array(
							  "label"=>__pe("Caption Content"),
							  "type"=>"Editor",
							  "section"=>"edit",
							  "description" => __pe("Caption content in HTML format."),
							  "default"=>sprintf('<h3>Caption Title</h3>%s<p>long descriptions goes here</p>',"\n")
							  ),
						"saveCaption" => 
						array(
							  "label"=>__pe("Save current caption"),
							  "type"=>"Button",
							  "section"=>"edit",
							  "description" => __pe("Save the current caption configuration."),
							  "default"=> ""
							  )
						*/
						);

		$this->form = new PeThemePlainForm($this,"peCaptionManager",$fields,$null);
		$this->form->build();

		add_action('admin_footer', array(&$this,'admin_footer'));

	}

	public function output($captions) {

		if ($captions and is_array($captions)) {
			foreach ($captions as $caption) {
				if (isset($caption->data)) {
					$name = $caption->name;
					$caption =& $caption->data;
					$style = "";
					if (isset($caption->backgroundAlpha) && floatval($caption->backgroundAlpha) > 0) {
						$c = isset($caption->backgroundColor) ? $caption->backgroundColor : "#000000" ;
						$style = sprintf("background-color: %s;",$c);
						if (floatval($caption->backgroundAlpha) < 1) {
							$style .= sprintf(
											  " background-color: rgba(%s,%s,%s,%s);",
											  hexdec(substr($c, 1, 2)),
											  hexdec(substr($c, 3, 2)),
											  hexdec(substr($c, 5, 2)),
											  $caption->backgroundAlpha
											  );
						}
						$style = "style=\"{$style}\"";
					}
					printf(
						   '<div class="%s %s %s" %s data-align="%s" data-transition="%s" data-delay="%s" data-offset="%s">%s</div>',
						   "peCaption",
						   isset($caption->visibility) ? $caption->visibility : "",
						   "peCaption_".sanitize_title_with_dashes($name),
						   $style,
						   isset($caption->align) ? $caption->align : "center,left",
						   isset($caption->transition) ? $caption->transition : "fade",
						   isset($caption->delay) ? $caption->delay : "0",
						   isset($caption->offset) ? $caption->offset : "0,0",
						   isset($caption->content) ? PeThemeShortcode::parseContent($caption->content) : ""
						   );					
				}
			}
		}
	}


	public function admin_footer() {

		echo $this->pre();
		$this->form->render();
		echo $this->post();
	}

	protected function pre() {
		$html = <<<HTML
<div class="pe_theme" style="display: none" id="pe_captions_manager">
	<div class="pe_theme_wrap">
		<!--info bar top-->
		<div class="contents clearfix">
			<div id="options_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all clearfix">
HTML;

		return $html;
	}

	protected function post() {
		$html = <<<EOT
</div>
</div>				
</div>
</div>
EOT;

		return $html;
	}
	
}

?>
