<?php

class PeThemeShortcodeReworkButton extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "button";
		$this->group = __pe("UI");
		$this->name = __pe("Button");
		$this->description = __pe("Add a button");
		$this->fields = array(
							  "type"=> 
							  array(
									"label" => __pe("Button Type"),
									"type" => "Select",
									"description" => __pe("Select the type of button required. The button type determines the boton's color"),
									"options" => 
									array(
										  __pe("Red") => "red",
										  __pe("Yellow") => "yellow",
										  __pe("Black") => "black",
										  __pe("Gray") => "gray"
										  ),
									"default" => "default"
									),
							  "content" =>
							  array(
									"label" => __pe("Label"),
									"type" => "Text",
									"description" => __pe("Enter the button label here."),
									"default" => __pe("Button")
									),
							  "url" =>
							  array(
									"label" => __pe("Url"),
									"type" => "Text",
									"description" => __pe("Enter the destination url of the button"),
									"default" => "#"
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$type = $atts["type"];
		if (!isset($url)) $url = "#";
		$content = esc_attr($content ? $this->parseContent($content) : '');
		$html = <<< EOT
<a href="$url"><input type="button" value="$content" class="$type" /></a>
EOT;
        return trim($html);
	}


}

?>
