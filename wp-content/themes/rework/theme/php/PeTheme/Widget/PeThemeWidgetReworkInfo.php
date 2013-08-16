<?php

class PeThemeWidgetReworkInfo extends PeThemeWidgetStats {

	public function __construct() {
		parent::__construct();
		$this->name = __pe("Rework - Info");
		$this->description = __pe("Logo and informations");

		$this->fields["logo"]["default"] = PE_THEME_URL."/images/logo_footer.png";
		$this->fields["stats"] = 
			array(
				  "label"=>__pe("Text"),
				  "type"=>"Editor",
				  "description" => "",
				  "default"=>'<p>Proin fermentum sollicitudin ante, sed tempor eros molestie id. Donec volutpat odio eu mi imperdiet nec laoreet diam venenatis. Nunc ac purus aliquet mauris interdum accumsan.</p>'
				  );

		unset($this->fields["links"]);
	}

	public function &getContent(&$instance) {
		extract($instance);
		$html = '<a href="'.home_url().'" class="logo" title="Home"><img src="'.$logo.'" alt="logo" /></a>';

		if (isset($stats)) {
			$html .= do_shortcode($stats);
		}

		return $html;
	}
}
?>