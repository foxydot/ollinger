<?php

class PeThemeWidgetReworkRecentPosts extends PeThemeWidgetRecentPosts {

	public function __construct() {
		parent::__construct();
		$this->name = __pe("Rework - Recent posts");

		unset($this->fields["link"]);
		unset($this->fields["url"]);
		unset($this->fields["chars"]);

	}
}
?>