<?php

class PeThemeConstantPortfolio {
	public $metabox;

	public function __construct() {
		$this->metabox = 
			array(
				  "title" =>__pe("Portfolio"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-portfolio",
						),
				  "content"=>
				  array(
						"columns" =>
						array(
							  "label"=>__pe("Columns"),
							  "type"=>"Select",
							  "description" => __pe("Specify the layout arrangement of columns for the project items. "),
							  "options" => apply_filters("pe_theme_portfolio_layouts",
							  array(
									__pe("Single column (no grid)")=>1,
									__pe("2 Columns")=>2,
									__pe("3 Columns")=>3,
									__pe("4 Columns")=>4,
									__pe("6 Columns")=>6
									)),
							  "default"=>3
							  ),
						"filterable" => 
						array(
							  "label"=>__pe("Allow Filtering"),
							  "type"=>"RadioUI",
							  "description" => __pe("Specify if the project filter keywords are shown in this page. "),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"yes"
							  ),
						"tags" =>
						array(
							  "label" => __pe("Only Include Projects With The Following Tags"),
							  "type" => "Tags",
							  "taxonomy" => "prj-category",
							  "description" => __pe("Only include projects in this page based on specific keywords/tags. "),
							  "default" => ""
							  ),
						)
				  );
	}
	
}

?>