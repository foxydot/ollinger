<?php

class PeThemeWidgetReworkFlickr extends PeThemeWidgetFlickr {

	public function __construct() {
		parent::__construct();
		$this->name = __pe("Rework - Flickr");

		$this->fields["count"]["default"] = 8;

		
	}

	public function getContent(&$instance) {
		extract($instance);

		$cols = 3;
		$html = <<<EOL
<h3>$title</h3>
		<ul class="flickr photo-stream" data-userID="$username" data-count="$count" data-cols="$cols"></ul>
EOL;


		return $html;
	}
}
?>