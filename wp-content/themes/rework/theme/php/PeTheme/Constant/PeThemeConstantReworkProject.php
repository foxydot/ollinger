<?php

class PeThemeConstantReworkProject extends PeThemeConstantProject {
	
	public function __construct() {
		parent::__construct();
		

		$this->metabox["content"] =
				  array(
						"portfolio" => 	
						array(
							  "label"=>__pe("Portfolio Link"),
							  "type"=>"Select",
							  "options" => peTheme()->content->getPagesOptionsByTemplate("portfolio"),
							  "description" => __pe("Link for the back to porfolio icon."),
							  "default"=>0
							  ),
						"list_title" => 	
						array(
							  "label"=>__pe("Feature List Title"),
							  "type"=>"Text",
							  "description" => __pe("Specify a title for project features. "),
							  "default"=>__pe("Job Description")
							  ),
						"features" => 
						array(
							  "label"=>__pe("Features"),
							  "type"=>"Links",
							  "description" => __pe("Add one or more project features."),
							  "sortable" => true,
							  "default"=>""
							  ),
						"button_label" => 	
						array(
							  "label"=>__pe("Button Label"),
							  "type"=>"Text",
							  "default"=>__pe("Launch")
							  ),
						"button_link" => 	
						array(
							  "label"=>__pe("Button Link"),
							  "type"=>"Text",
							  "default"=>"#"
							  ),
						);

	}
	
}

?>