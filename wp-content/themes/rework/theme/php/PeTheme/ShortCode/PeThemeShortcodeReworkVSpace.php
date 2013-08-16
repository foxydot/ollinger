<?php

class PeThemeShortcodeReworkVSpace extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "spacer";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Spacer");
		$this->description = __pe("Add an Vertical Spacer");
	}

	public function output($atts,$content=null,$code="") {
        return '<hr class="h80"/>';
	}


}

?>