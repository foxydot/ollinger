<?php

class PeThemeShortcodeBS_Faq extends PeThemeShortcode {

	public $instances = 0;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "faq";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Faq");
		$this->description = __pe("Faq");
		$this->fields = array(
							  "title" =>
							  array(
									"label" => __pe("Question"),
									"type" => "Text",
									"description" => __pe("Title of the faq."),
									"default" => "Faq Title"
									),
							  "opened" =>
							  array(
									"label" => __pe("Open on Page Load"),
									"type" => "RadioUI",
									"description" => __pe("If the FAQ item should be open by default"),
									"options" => PeGlobal::$const->data->yesno,
									"default" => "yes"
									),
							  "content" =>
							  array(
									"label" => __pe("Answer"),
									"type" => "TextArea",
									"description" => __pe("Content of the faq."),
									"default" => "Content"
									)
							  );

	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$this->instances++;
		if (!@$title) return "";

		$content = $this->parseContent($content);
		
		$id = "faq".$this->instances."_";
		$class = $opened == "yes" ? "" : " collapse";
		$html = '<div class="faq">';
		$html .= sprintf('<div class="faq-heading"><div data-target="#%s" data-toggle="collapse">%s</div></div>',$id,$title);
		$html .= sprintf('<div class="faq-body%s" id="%s"><div class="faq-inner"><p>%s</p></div></div>',$class,$id,$content);
		$html .= '</div>';

		return $html;
	}


}

?>
