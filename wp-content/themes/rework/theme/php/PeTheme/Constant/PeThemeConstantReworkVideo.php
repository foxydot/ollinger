<?php

class PeThemeConstantReworkVideo extends PeThemeConstantVideo {

	public function __construct() {
		parent::__construct();

		$this->type = 
			array(
				  __pe("Youtube")=>"youtube",
				  __pe("Vimeo")=>"vimeo",
				  );

		$this->fields->type["options"] = $this->type;

		$this->metabox["content"]["type"] = $this->fields->type;
		unset($this->metabox["content"]["fullscreen"]);

	}
	
}

?>