<?php

class PeThemeShortcodeBS_Projects extends PeThemeShortcode {

	public $instances = 0;
	public $count;
	public $custom;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "projects";
		$this->group = __pe("CONTENT");
		$this->name = __pe("Projects");
		$this->description = __pe("Projects");
		$this->fields = array(
							  "count" =>
							  array(
									"label" => __pe("Max Projects"),
									"type" => "Text",
									"description" => __pe("Maximum number of projects to display."),
									"default" => 10,
									),
							  "category" =>
							  array(
									"label" => __pe("Category"),
									"type" => "Select",
									"description" => __pe("Only display projects from a specific category."),
									"options" => array_merge(array(__pe("All")=>""),peTheme()->data->getTaxOptions("prj-category")),
									"default" => ""
									)
							  );

	}

	public function pe_theme_related_projects_count_filter($count) {
		return $this->count;
	}

	public function pe_theme_related_projects_title_filter($title) {
		return "";
	}

	public function pe_theme_related_projects_custom_filter($custom) {
		return $this->custom;
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$this->count = isset($count) ? intval($count) : 10;

		if (isset($category) && $category !== "") {
			$this->custom["prj-category"] = $category;
		}

		ob_start();
		add_filter("pe_theme_related_projects_count",array(&$this,"pe_theme_related_projects_count_filter"));
		add_filter("pe_theme_related_projects_title",array(&$this,"pe_theme_related_projects_title_filter"));
		add_filter("pe_theme_related_projects_custom",array(&$this,"pe_theme_related_projects_custom_filter"));
		get_template_part("carousel");
		$content =& ob_get_contents();
		ob_end_clean();
		remove_filter("pe_theme_related_projects_count",array(&$this,"pe_theme_related_projects_count_filter"));
		remove_filter("pe_theme_related_projects_title",array(&$this,"pe_theme_related_projects_title_filter"));
		remove_filter("pe_theme_related_projects_custom",array(&$this,"pe_theme_related_projects_custom_filter"));
		return $content;

	}


}

?>
