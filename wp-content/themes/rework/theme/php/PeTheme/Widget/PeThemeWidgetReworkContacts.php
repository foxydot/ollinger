<?php

class PeThemeWidgetReworkContacts extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Rework - Contacts");
		$this->description = __pe("Contact details.");
		$this->wclass = "widget_contact";

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=>"Contact Details"
									),
							  "address_content" => 
							  array(
									"label"=>__pe("Address"),
									"type"=>"TextArea",
									"description" => __pe("Address box content."),
									"default"=>sprintf('3200 Sepulveda Blvd. <br />%sManhattan Beach, CA 90266, USA',"\n")
									),
							  "phone_content" => 
							  array(
									"label"=>__pe("Phone"),
									"type"=>"TextArea",
									"description" => __pe("Phone box content."),
									"default"=>sprintf('Phone: (415) 124-5678 <br />%sFax: (415) 124-5678',"\n")
									),
							  "email_content" => 
							  array(
									"label"=>__pe("Email"),
									"type"=>"TextArea",
									"description" => __pe("Email box content."),
									"default"=>sprintf('support@reworkmedia.com')
									)							  
							  );

		parent::__construct();
	}

	public function &getContent(&$instance) {
		extract($instance);

		$html = "";

		if (isset($title)) {
			$html .= "<h3>$title</h3>";
		}

		if (isset($address_content) && $address_content) {
			$html .= sprintf('<p class="address">%s</p>',$address_content);
		}

		if (isset($phone_content) && $phone_content) {
			$html .= sprintf('<p class="phone">%s</p>',$phone_content);
		}

		if (isset($email_content) && $email_content) {
			$html .= sprintf('<p class="email">%s</p>',$email_content);
		}

		return $html;
	}


}
?>