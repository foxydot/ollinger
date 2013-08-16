<?php

class PeThemeShortcodeBS_Video extends PeThemeShortcode {

	public $instances = 0;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "video";
		$this->group = __pe("MEDIA");
		$this->name = __pe("Video");
		$this->description = __pe("Video");
		$this->fields = array(
							  "id" => PeGlobal::$const->video->fields->id
							  );

	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		if (!@$id) return "";
		return peTheme()->video->inline($id);
	}


}

?>
