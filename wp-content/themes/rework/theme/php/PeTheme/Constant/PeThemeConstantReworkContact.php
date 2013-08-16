<?php

class PeThemeConstantReworkContact extends PeThemeConstantContact {

	public function __construct() {
		parent::__construct();

		$info = 
			array(
				  "title" => 
				  array(
						"label"=>__pe("Form Title"),
						"type"=>"Text",
						"default"=>"Let's keep in touch"
						),
				  "address" => 
				  array(
						"label"=>__pe("Address"),
						"type"=>"TextArea",
						"default"=>sprintf('3200 Sepulveda Blvd. <br />%sManhattan Beach, CA 90266, USA',"\n")
						),
				  "phone" => 
				  array(
						"label"=>__pe("Phone"),
						"type"=>"TextArea",
						"default"=>sprintf('Phone: (415) 124-5678 <br />%sFax: (415) 124-5678',"\n")
						),
				  "email" => 
				  array(
						"label"=>__pe("Email"),
						"type"=>"TextArea",
						"default"=>sprintf('support@reworkmedia.com')
						)							  
				  );
		
		$this->metabox["content"] = array_merge($info,$this->metabox["content"]);

	}
	
}

?>