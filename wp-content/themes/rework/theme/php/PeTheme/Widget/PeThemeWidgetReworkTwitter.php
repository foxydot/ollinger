<?php

class PeThemeWidgetReworkTwitter extends PeThemeWidgetTwitter {

	public function __construct() {
		parent::__construct();
		$this->name = __pe("Rework - Twitter");
	}

	public function getContent(&$instance) {
		extract($instance);
		$html = <<<EOL
<h3>$title</h3><div class="twitter twitter-feed" data-topdate="false" data-count="$count" data-username="$username" data-timeclass="tweet-time"></div>
EOL;


		return $html;
	}
}
?>