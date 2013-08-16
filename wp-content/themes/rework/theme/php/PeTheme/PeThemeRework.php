<?php

class PeThemeRework extends PeThemeController {

	public $preview = array();

	public function __construct() {

		// custom post types
		add_action("pe_theme_custom_post_type",array(&$this,"pe_theme_custom_post_type"));

		// body classes
		add_filter("pe_theme_body_class",array(&$this,"pe_theme_body_class_filter"));

		// menu
		add_filter("pe_theme_menu_items_wrap_default",array(&$this,"pe_theme_menu_items_wrap_default_filter"));
		add_filter("pe_theme_menu_items_wrap_simple",array(&$this,"pe_theme_menu_items_wrap_simple_filter"));
		add_filter("pe_theme_menu_current_menu_item_class",array(&$this,"pe_theme_menu_current_menu_item_class_filter"),10,2);
		add_filter("pe_theme_menu_current_menu_ancestor_class",array(&$this,"pe_theme_menu_current_menu_ancestor_class_filter"),10,2);
		add_filter("pe_theme_menu_nth_level_icon",array(&$this,"pe_theme_menu_nth_level_icon_filter"));		
		add_filter("pe_theme_menu_top_level_icon",array(&$this,"pe_theme_menu_top_level_icon_filter"));		
		
		// social links
		add_filter("pe_theme_content_get_social_link",array(&$this,"pe_theme_content_get_social_link_filter"),10,4);
		
		// footer layout
		add_filter("pe_theme_footer_layouts",array(&$this,"pe_theme_footer_layouts_filter"));

		// content
		add_filter("pe_theme_content_img",array(&$this,"pe_theme_content_img_filter"));
		// use prio 30 so gets executed after standard theme filter
		add_filter("the_content_more_link",array(&$this,"the_content_more_link_filter"),30);

		// projects
		add_filter("pe_theme_project_filter_item",array(&$this,"pe_theme_project_filter_item_filter"),10,4);

		// portfolio
		add_filter("pe_theme_portfolio_layouts",array(&$this,"pe_theme_portfolio_layouts_filter"),10,4);

		// shortcode: columns
		add_filter("pe_theme_shortcode_columns_options",array(&$this,"pe_theme_shortcode_columns_options_filter"));
		add_filter("pe_theme_shortcode_columns_mapping",array(&$this,"pe_theme_shortcode_columns_mapping_filter"));
		add_filter("pe_theme_shortcode_columns_container",array(&$this,"pe_theme_shortcode_columns_container_filter"),10,2);

		// editor 
		add_filter("tiny_mce_before_init",array(&$this,"tiny_mce_before_init_filter"));
		add_filter("mce_buttons_2",array(&$this,"mce_buttons_2_filter"));  
		add_filter("pe_theme_editor_style",array(&$this,"pe_theme_editor_style_filter"));

		// google fonts
		add_filter("pe_theme_font_variants",array(&$this,"pe_theme_font_variants_filter"),10,2);

		// update
		add_filter("pe_theme_author",array(&$this,"pe_theme_author_filter"));
		
		add_filter('the_password_form', array(&$this,"the_password_form_filter"));
	}


	public function pe_theme_author_filter($author) {
		return "bitfade";
	}

	public function pe_theme_body_class_filter($classes) {
		return strtr($classes,array("search " => " "));
	}

	public function pe_theme_editor_style_filter($style) {
		return "css/editor.css";
	}

	public function mce_buttons_2_filter($buttons) {  
		array_unshift( $buttons, 'styleselect' );  
		return $buttons;  
	}

	public function tiny_mce_before_init_filter($settings) {
		$style_formats = array(  
							   array(  
									 'title' => __pe('BlockQuote - Person'),  
									 'inline' => 'span',  
									 'classes' => 'person'  
									   ),
							   array(  
									 'title' => __pe('BlockQuote - Accent'),  
									 'inline' => 'span',  
									 'classes' => 'accent'  
									   ),
							   array(  
									 'title' => __pe('Alert - Success'),  
									 'selector' => 'p',  
									 'classes' => 'success'  
									   ),
							   array(  
									 'title' => __pe('Alert - Notice'),  
									 'selector' => 'p',  
									 'classes' => 'notice'  
									   ),
							   array(  
									 'title' => __pe('Alert - Warning'),  
									 'selector' => 'p',  
									 'classes' => 'warning'  
									   ),
							   array(  
									 'title' => __pe('Alert - Error'),  
									 'selector' => 'p',  
									 'classes' => 'error'  
									   ),
							   array(  
									 'title' => __pe('List - Check'),  
									 'selector' => 'ul',  
									 'classes' => 'check'  
									   ),
							   array(  
									 'title' => __pe('List - Check Bold'),  
									 'selector' => 'ul',  
									 'classes' => 'check-bold'  
									   ),
							   array(  
									 'title' => __pe('List - Arrow'),  
									 'selector' => 'ul',  
									 'classes' => 'arrow'  
									   ),
							   array(  
									 'title' => __pe('List - Arrow Bold'),  
									 'selector' => 'ul',  
									 'classes' => 'arrow-bold'  
									   ),
							   array(  
									 'title' => __pe('List - Square'),  
									 'selector' => 'ul',  
									 'classes' => 'square'  
									   ),
							   array(  
									 'title' => __pe('List - Circle'),  
									 'selector' => 'ul',  
									 'classes' => 'circle'  
									   )
								 );  
		$settings['style_formats'] = json_encode( $style_formats );
		return $settings;
	}


	public function pe_theme_custom_post_type() {
		$this->ptable->cpt();
		$this->staff->cpt();
		$this->service->cpt();
	}


	public function pe_theme_menu_items_wrap_default_filter($wrap) {
		return '<ul id="navigation">%3$s</ul>';
	}

	public function pe_theme_menu_items_wrap_simple_filter($wrap) {
		return '%3$s';
	}

	public function pe_theme_menu_current_menu_item_class_filter($cl,$depth) {
		return "";
	}

	public function pe_theme_menu_current_menu_ancestor_class_filter($cl,$depth) {
		return $depth == 0 ? "current" : "";
	}

	public function pe_theme_menu_top_level_icon_filter($icon) {
		return '';
	}

	public function pe_theme_menu_nth_level_icon_filter($icon) {
		return '<i></i>';
	}

	public function pe_theme_content_get_social_link_filter($html,$link,$domain,$icon) {
		$icon = strtr($icon,array("linked_in"=>"linkedin"));
		return sprintf('<li class="%s"><a href="%s">%s</a></li>',$icon,$link,$domain);
	}

	public function pe_theme_footer_layouts_filter($layout) {
		return 
			array(
				  "default" => array("one-fourth","one-fourth","one-fourth","one-fourth last")
				  );
	}

	public function pe_theme_content_img_filter($img) {
		if (!$img) return $img;
		return str_replace("src=",'class="image" src=',$img);
		
	}

	public function the_content_more_link_filter($link) {
		$link = sprintf('&nbsp;<a href="%s#more-%s">%s</a>',get_permalink(),$GLOBALS["post"]->ID,__pe("Read more"));
		return $link;
	}

	public function pe_theme_project_filter_item_filter($html,$aclass,$slug,$name) {
		return sprintf('<li><a href="#" data-filter="%s" class="%s">%s</a></li>',$slug === "" ? "*" : ".filter-$slug",$slug === "" ? "current" : "",$name);
	}

	public function pe_theme_portfolio_layouts_filter($layouts) {
		return array(
					 __pe("2 Columns")=>2,
					 __pe("3 Columns")=>3,
					 __pe("4 Columns")=>4,
					 __pe("Alternate")=>5
					 );
	}

	public function pe_theme_shortcode_columns_options_filter($options) {

		$options = array();

		$options[__pe("2 Column layouts")] = 
			array(
				  __pe("1/2 1/2") => "1/2 1/2", 
				  __pe("1/3 2/3") => "1/3 2/3", 
				  __pe("2/3 1/3") => "2/3 1/3", 
				  __pe("1/4 3/4") => "1/4 3/4", 
				  __pe("3/4 1/4") => "3/4 1/4"
				  );

		$options[__pe("3 Column layouts")] = 
			array(
				  __pe("1/3 1/3 1/3") => "1/3 1/3 1/3",
				  __pe("1/4 1/4 2/4") => "1/4 1/4 2/4", 
				  __pe("1/4 2/4 1/4") => "1/4 2/4 1/4",
				  __pe("2/4 1/4 1/4") => "2/4 1/4 1/4" 
				  );

		$options[__pe("4 Column layouts")] = 
			array(
				  __pe("1/4 1/4 1/4 1/4") => "1/4 1/4 1/4 1/4"
				  );

		return $options;
	}

	public function pe_theme_shortcode_columns_mapping_filter($map) {
		return
			array(
				  "1/2" => "one-half",
				  "1/4" => "one-fourth",
				  "1/3" => "one-third",
				  "2/4" => "one-half",
				  "2/3" => "two-third",
				  "3/4" => "three-fourth"
				  );
		
	}

	public function pe_theme_shortcode_columns_container_filter($markup,$content) {
		return "$content<div class=\"clear\"></div>";
	}

	public function pe_theme_font_variants_filter($variants,$font) {
		if ($font === "Open Sans") {
			$variants = "Open Sans:400italic,400,300,700";
		}
		return $variants;
	}

	public function the_password_form_filter($html) {

		global $post;
        $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
        $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
        <p>' . __("This post is password protected. To view it please enter your password below:") . '</p>
        <p><input name="post_password" id="' . $label . '" type="password" size="20" /><input class="red" type="submit" name="Submit" value="' . esc_attr__("Submit") . '" /></p>
</form>';
		return $output;
	}

	public function boot() {
		parent::boot();

		PeGlobal::$config["content-width"] = 940;
		PeGlobal::$config["post-formats"] = array("video","gallery");
		PeGlobal::$config["post-formats-project"] = array("video","gallery");

		PeGlobal::$config["image-sizes"]["thumbnail"] = array(120,90,true);
		PeGlobal::$config["image-sizes"]["medium"] = array(480,396,true);
		PeGlobal::$config["image-sizes"]["large"] = array(680,224,true);
		PeGlobal::$config["image-sizes"]["post-thumbnail"] = PeGlobal::$config["image-sizes"]["medium"];
		

		PeGlobal::$config["nav-menus"]["footer"] = __pe("Footer menu");

		// blog layouts
		PeGlobal::$config["blog"] =
			array(
				  __pe("Default") => "",
				  __pe("Alternate") => "alternate"
				  );

		PeGlobal::$config["widgets"] = 
			array(
				  "ReworkInfo",
				  "ReworkHtml",
				  "ReworkTwitter",
				  "ReworkContacts",
				  "ReworkFlickr",
				  "ReworkRecentPosts"
				  );

		PeGlobal::$config["shortcodes"] = 
			array(
				  "BS_Accordion",
				  "BS_Tabs",
				  "BS_Columns",
				  "Staff",
				  "Service",
				  "ReworkButton",
				  "ReworkVSpace"
				  );

		PeGlobal::$config["sidebars"] =
			array(
				  "footer" => __pe("Footer Widgets"),
				  "default" => __pe("Default post/page")
				  );

		PeGlobal::$config["colors"] = 
			array(
				  "color1" => 
				  array(
						"label" => __pe("Primary Color"),
						"selectors" => 
						array(
							  "a:hover" => "color",
							  "a > *:hover" => "color",
							  "#navigation a:hover" => "color",
							  "#navigation .hover > a" => "color",
							  "#navigation .current > a" => "color",
							  "#navigation ul" => "background-color",
							  "#back-top a:hover" => "background-color",
							  ".page-title-inner .accent" => "color",
							  ".blog-carousel .comments:hover" => "color",
							  ".jcarousel-prev:hover" => "background-color",
							  ".jcarousel-prev:focus" => "background-color",
							  ".jcarousel-prev:active" => "background-color",
							  "#project-wrapper-alt .jcarousel-next:hover" => "background-color",
							  "#project-wrapper-alt .jcarousel-next:focus" => "background-color",
							  "#project-wrapper-alt .jcarousel-next:active" => "background-color",
							  ".work-more a:hover" => "color",
							  ".team-member:hover" => "border-bottom-color",
							  ".member-info h4" => "color",
							  ".member-social-links a:hover" => "color",
							  ".service-icon" => "background-color",
							  ".pricing-table-extended .level-max .header " => "background-color",
							  ".pricing-table-simple .level-max h2" => "color",
							  ".pricing-table-simple .level-max h2 span" => "color",
							  ".on a" => "color",
							  "#tabs li a:hover" => "border-top-color",
							  "#tabs li.active a" => "border-top-color",
							  "#tabs li.active a:hover" => "color",
							  ".error" => "background-color",
							  "blockquote .person .accent" => "color",
							  ".post-meta .author a" => "color",
							  ".post-meta .date a:hover" => "color",
							  ".post-meta .tags a:hover" => "color",
							  ".post-meta .comments a:hover" => "color",
							  ".post-entry a" => "color",
							  ".pagination .current" => "background-color",
							  ".pagination a:hover" => "color",
							  ".comment .author .reply:hover" => "color",
							  ".post-block" => "background-color",
							  ".post-more a:hover" => "color",
							  ".project-feed-filter a:hover" => "color",
							  ".project-feed-filter .current" => "color",
							  ".project-item .overlay" => "background-color:.75",
							  ".project-item:hover .project-title" => "background-color",
							  ".project-nav .prev:hover" => "background-color",
							  ".project-nav .next:hover" => "background-color",
							  ".project-nav .back:hover" => "background-color",
							  ".widget.widget_categories li a:hover" => "color",
							  "#footer .widget_categories li a:hover" => "color",
							  "#footer .widget_recent_entries a:hover" => "color",
							  ".twitter-feed a:hover" => "color",
							  "#sidebar .twitter-feed a" => "color",
							  ".photo-stream a:hover" => "outline-color",
							  "#footer a:hover"  => "color",
							  "#footer .twitter-feed a:hover" => "color",
							  ".flexslider:hover .flex-next:hover" => "background-color",
							  ".flexslider:hover .flex-prev:hover" => "background-color",
							  "#lang_sel ul ul li:hover a" => "background-color",
							  "#lang_sel_list a:hover span" => "color"
							  ),
						"default" => "#d73300"
						),
				  "color2" => 
				  array(
						"label" => __pe("Secondary Color"),
						"selectors" => 
						array(
							  "#navigation ul a" => "color",
							  ".post-block .post-entry h2:hover" => "color",
							  ".post-block .post-entry p" => "color",
							  ".post-block a:hover" => "color",
							  ".project-item .overlay p" => "color",
							  ),
						"default" => "#F0BFB8"
						),
				  "color3" => 
				  array(
						"label" => __pe("Primary Grey"),
						"selectors" => 
						array(
							  "a" => "color",
							  "a > *" => "color",
							  "h1" => "color",
							  "h2" => "color",
							  "h3" => "color",
							  "h4" => "color",
							  "h5" => "color",
							  "h6" => "color",
							  ".page-title .accent" => "color",
							  ".page-title-alt .accent" => "color",
							  ".page-title-inner" => "color",
							  ".about-intro" => "color",
							  ".services-intro" => "color",
							  ".pricing-table-simple h2" => "color",
							  ".pricing-table-simple h2 span" => "color",
							  "#tabs li.active a" => "color",
							  "blockquote .person" => "color",
							  ".contact-intro" => "color",
							  "#footer" => "background-color"
							  ),
						"default" => "#333333"
						),
				  "color4" => 
				  array(
						"label" => __pe("Secondary Grey"),
						"selectors" => 
						array(
							  ".page-title" => "color",
							  ".page-title-inner" => "color",
							  ".page-title-alt" => "color",
							  ".page-title-inner .section-title" => "color",
							  ".work-more a" => "color",
							  ".post-more a" => "color",
							  "#footer .widget_categories li a" => "color",
							  "#footer .widget_recent_entries a" => "color",
							  "#footer .twitter-feed a" => "color"
							  ),
						"default" => "#c2c2c2"
						)
				  );
		

			PeGlobal::$config["fonts"] = 
				array(
					  "fontBody" => 
					  array(
							"label" => __pe("Body, Paragraph Text"),
							"selectors" => 
							array(
								  "body",
								  "p",
								  'input[type="text"]',
								  "textarea",
								  'input[type="submit"]',
								  'input[type="reset"]',
								  'input[type="button"]',
								  "button",
								  ".button",
								  "#navigation a"
								  ),
							"default" => "Open Sans"
							),
					  "fontH1" => 
					  array(
							"label" => __pe("Page Titles, Heading 1"),
							"selectors" => 
							array(
								  "h1"
								  ),
							"default" => "Open Sans"
							),
					  "fontH2" => 
					  array(
							"label" => __pe("Post Titles, Heading 2"),
							"selectors" => 
							array(
								  "h2"
								  ),
							"default" => "Open Sans"
							),
					  "fontH3" => 
					  array(
							"label" => __pe("Widget Titles, Heading 3"),
							"selectors" => 
							array(
								  "h3"
								  ),
							"default" => "Open Sans"
							),
					  "fontH4" => 
					  array(
							"label" => __pe("Heading 4"),
							"selectors" => 
							array(
								  "h4"
								  ),
							"default" => "Open Sans"
							),
					  "fontH5" => 
					  array(
							"label" => __pe("Heading 5"),
							"selectors" => 
							array(
								  "h5"
								  ),
							"default" => "Open Sans"
							),
					  "fontH6" => 
					  array(
							"label" => __pe("Heading 6"),
							"selectors" => 
							array(
								  "h6"
								  ),
							"default" => "Open Sans"
							)
					  );

		PeGlobal::$config["post_types"]["project"] =
				  array(
						'labels' => 
						array(
							  'name'              => __pe("Projects"),
							  'singular_name'     => __pe("Project"),
							  'add_new_item'      => __pe("Add New Project"),
							  'search_items'      => __pe('Search Projects'),
							  'popular_items' 	  => __pe('Popular Projects'),		
							  'all_items' 		  => __pe('All Projects'),
							  'parent_item' 	  => __pe('Parent Project'),
							  'parent_item_colon' => __pe('Parent Project:'),
							  'edit_item' 		  => __pe('Edit Project'), 
							  'update_item' 	  => __pe('Update Project'),
							  'add_new_item' 	  => __pe('Add New Project'),
							  'new_item_name' 	  => __pe('New Project Name')
							  ),
						'public' => true,
						'has_archive' => false,
						"supports" => array("title","editor","thumbnail","post-formats"),
						"taxonomies" => array("post_format")
						);

		PeGlobal::$config["taxonomies"]["prj-category"] =
				  array(
						'project',
						array(
							  'label' => __pe('Project Tags'),
							  'sort' => true,
							  'args' => array('orderby' => 'term_order' ),
							  'show_in_nav_menus' => false,
							  'rewrite' => array('slug' => 'projects' )
							  )
						);

		$def404content = <<<EOL
<h4>The Page You Are Looking For Cannot Be Found</h4>
<br />
<p>You may want to check the following links:</p>
<br />
<a href="#" class="btn btn-danger">Home</a>
<a href="#" class="btn btn-danger">Contact</a>
EOL;



		$options = array();

		if (!defined('PE_HIDE_IMPORT_DEMO') || !PE_HIDE_IMPORT_DEMO) {
			$options["import_demo"] = $this->defaultOptions["import_demo"];
		}

		$options = array_merge($options,
			array(
				  "logo" => 
				  array(
						"label"=>__pe("Logo"),
						"type"=>"Upload",
						"section"=>__pe("General"),
						"description" => __pe("This is the main site logo image. The image should be a .png file."),
						"default"=> PE_THEME_URL."/images/logo.png"
						),
				  "customCSS" => $this->defaultOptions["customCSS"],
				  "customJS" => $this->defaultOptions["customJS"],
				  "googleFonts" => 
				  array(
						"label"=>__pe("Custom Fonts"),
						"type"=>"Help",
						"section"=>__pe("Fonts"),
						"description" => __pe("In this page you can set the typefaces to be used throughout the theme. For each elements listed below you can choose any front from the Google Web Font library. Once you have chosen a font from the list, you will see a preview of this font immediately beneath the list box. The icons on the right hand side of the font preview, indicate what weights are available for that typeface.<br/><br/><strong>R</strong> -- Regular,<br/><strong>B</strong> -- Bold,<br/><strong>I</strong> -- Italics,<br/><strong>BI</strong> -- Bold Italics<br/><br/>When decideing what font to use, ensure that the chosen font contains the font weight required by the element. For example, main headings are bold, so you need to select a new font for these elements which supports a bold font weight. If you select a font which does not have a bold icon, the font will not be applied. <br/><br/>Browse the online <a href='http://www.google.com/webfonts'>Google Font Library</a><br/><br/><b>Custom fonts</b> (Advanced Users):<br/> Other then those available from Google fonts, custom fonts may also be applied to the elements listed below. To do this an additional field is provided below the google fonts list. Here you may enter the details of a font family, size, line-height etc. for a custom font. This information is entered in the form of the shorthand 'font:' CSS declaration, for example:<br/><br/><b>bold italic small-caps 1em/1.5em arial,sans-serif</b><br/><br/>If a font is specified in this field then the font listed in the Google font drop menu above will not be applied to the element in question. If you wish to use the Google font specified in the drop down list and just specify a new font size or line height, you can do so in this field also, however the name of the Google font <b>MUST</b> also be entered into this field. You may need to visit the Google fonts web page to find the exact CSS name for the font you have chosen." ),
						)
				  ));

		$options = array_merge($options,$this->font->options());
		$options["customColors"] = 
			array(
				  "label"=>__pe("Custom Colors"),
				  "type"=>"Help",
				  "section"=>__pe("Colors"),
				  "description" => __pe("In this page you can set alternative colors for the main colored elements in this theme. Four color options have been provided. A primary color, a secondary or complimentary color, a primary or dark grey and a secondary or light grey. To change the colors used on these elements simply write a new hex color reference number into the fields below or use the color picker which appears when each field obtains focus. Once you have selected your desired colors make sure to save them by clicking the <b>Save All Changes</b> button at the bottom of the page. Then just refresh your page to see the changes.<br/><br/><b>Please Note:</b> Some of the elements in this theme are made from images (Eg. Icons) and these items may have a color. It is not possible to change these elements via this page, instead such elements will need to be changed manually by opening the images/icons in an image editing program and manually changing their colors to match your theme's custom color scheme. <br/><br/>To return all colors to their default values at any time just hit the <b>Restore Default</b> link beneath each field."),
				  );

		$options = array_merge($options,$this->color->options());

		$options = array_merge($options,
		    array(
				  "footerCopyright" => 
				  array(
						"label"=>__pe("Copyright"),
						"type"=>"Text",
						"section"=>__pe("Footer"),
						"description" => __pe("Copyright notice. Simple HTML tags are supported. "),
						"default"=> "&copy; 2012 REWORK MEDIA. All rights reserved",
						"wpml" => true
						),
				  "footerSocialLinks" => 
				  array(
						"label"=>__pe("Social Profile Links"),
						"type"=>"Links",
						"section"=>__pe("Footer"),
						"description" => __pe("Add the link to your common social media profiles. Paste links one at a time and click the 'Add New' button. The links will appear in a table below and an icons will be inserted automatically based on the domain in the url."),
						"sortable" => true,
						"default"=>""
						),
				  "sidebars" => 
				  array(
						"label"=>__pe("Widget Areas"),
						"type"=>"Sidebars",
						"section"=>__pe("Widget Areas"),
						"description" => __pe("Create new widget areas by entering the area name and clicking the add button. The new widget area will appear in the table below. Once a widget area has been created, widgets may be added via the widgets page."),
						"default"=>""
						),
				  "contactEmail" => $this->defaultOptions["contactEmail"],
				  "contactSubject" => $this->defaultOptions["contactSubject"],
				  "404title" => 
				  array(
						"label"=>__pe("Title"),
						"type"=>"Text",
						"section"=>__pe("Custom 404"),
						"description" => __pe("Title of 404 (not found) page"),
						"default"=> "404 Error - Page not found",
						"wpml" => true
						),
				  "404content" => 
				  array(
						"label"=>__pe("Content"),
						"type"=>"TextArea",
						"section"=>__pe("Custom 404"),
						"description" => __pe("Content of 404 (not found) page"),
						"default"=> $def404content,
						"wpml" => true
						)
				  ));

		$options["minifyJS"] =& $this->defaultOptions["minifyJS"];
		$options["minifyCSS"] =& $this->defaultOptions["minifyCSS"];

		$options["adminThumbs"] =& $this->defaultOptions["adminThumbs"];
		$options["mediaQuick"] =& $this->defaultOptions["mediaQuick"];
		$options["mediaQuickDefault"] =& $this->defaultOptions["mediaQuickDefault"];

		$options["updateCheck"] =& $this->defaultOptions["updateCheck"];
		$options["updateUsername"] =& $this->defaultOptions["updateUsername"];
		$options["updateAPIKey"] =& $this->defaultOptions["updateAPIKey"];

		$options["adminLogo"] =& $this->defaultOptions["adminLogo"];
		$options["adminUrl"] =& $this->defaultOptions["adminUrl"];
		
		$taglineMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Tagline"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "all",
						),
				  "content"=>
				  array(
						"content" =>    
						array(
							  "label"=>__pe("Content"),
							  "type"=>"Editor",
							  "description" => __pe("Tagline Area content."),
							  "default"=>sprintf('<span class="section-title">Blog</span> Amazing things that<br />%sbring <span class="accent">positive results</span>',"\n")
							  )
						)
				  );
		
		
		$projectCarouselMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Projects Carousel"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-home, page-home_simple",
						),
				  "content"=>
				  array(
						"max" => 	
						array(
							  "label"=>__pe("Max Projects"),
							  "description"=> __pe("Max number of project items to show."),
							  "type"=>"RadioUI",
							  "options" => 
							  array(
									"3" => 3,
									"4" => 4,
									"6" => 6,
									"8" => 8,
									"9" => 9,
									"10" => 10,
									"12" => 12,
									"15" => 15,
									"16" => 16,
									__pe("All") => -1
									),
							  "default" => 8
							  ),
						"content" => 	
						array(
							  "label"=>__pe("Text"),
							  "type"=>"Editor",
							  "description" => __pe("Content above prev/next buttons."),
							  "default"=>"Phasellus id augue ligula, nec ultrices augue. Aliquam erat volutpat."
							  ),
						"link" => 	
						array(
							  "label"=>__pe("Portfolio Link"),
							  "description"=> __pe('Portfolio page to show when clicking "view more" link.'),
							  "type"=>"Select",
							  "options" => $this->content->getPagesOptionsByTemplate("portfolio"),
							  "default"=>0
							  )
						)
				  );

		$blogCarouselMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Blog Carousel"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-home, page-home_simple",
						),
				  "content"=>
				  array(
						"max" => 	
						array(
							  "label"=>__pe("Max Posts"),
							  "description"=> __pe("Max number of posts to show."),
							  "type"=>"RadioUI",
							  "options" => 
							  array(
									"3" => 3,
									"4" => 4,
									"6" => 6,
									"8" => 8,
									"9" => 9,
									"10" => 10,
									"12" => 12,
									"15" => 15,
									"16" => 16,
									__pe("All") => -1
									),
							  "default" => 8
							  ),
						"content" => 	
						array(
							  "label"=>__pe("Text"),
							  "type"=>"Editor",
							  "description" => __pe("Content above prev/next buttons."),
							  "default"=>"Phasellus id augue ligula, nec ultrices augue. Aliquam erat volutpat."
							  ),
						"link" => 	
						array(
							  "label"=>__pe("Blog Link"),
							  "description"=> __pe('Blog page to show when clicking "Read the blog" link.'),
							  "type"=>"Select",
							  "options" => $this->content->getPagesOptionsByTemplate("blog"),
							  "default"=>0
							  )
						)
				  );

		$logosMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Logos"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-home, page-home_simple, page-about",
						),
				  "content"=>
				  array(
						"show" =>				
						array(
							  "label"=>__pe("Show Logos"),
							  "type"=>"RadioUI",
							  "description"=>__pe('If set to "NO", whole logo section will be hidden.'),
							  "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							  "default"=>"yes"
							  ),
						"logo1" => 
						array(
							  "label"=>__pe("Logo 1"),
							  "type"=>"Upload",
							  "default"=> PE_THEME_URL."/images/content/logo_list_01.png"
							  ),
						"link1" => 
						array(
							  "label"=>__pe("Link 1"),
							  "type"=>"Text",
							  "default"=> "#"
							  ),
						"logo2" => 
						array(
							  "label"=>__pe("Logo 2"),
							  "type"=>"Upload",
							  "default"=> PE_THEME_URL."/images/content/logo_list_02.png"
							  ),
						"link2" => 
						array(
							  "label"=>__pe("Link 2"),
							  "type"=>"Text",
							  "default"=> "#"
							  ),
						"logo3" => 
						array(
							  "label"=>__pe("Logo 3"),
							  "type"=>"Upload",
							  "default"=> PE_THEME_URL."/images/content/logo_list_03.png"
							  ),
						"link3" => 
						array(
							  "label"=>__pe("Link 3"),
							  "type"=>"Text",
							  "default"=> "#"
							  ),
						"logo4" => 
						array(
							  "label"=>__pe("Logo 4"),
							  "type"=>"Upload",
							  "default"=> PE_THEME_URL."/images/content/logo_list_04.png"
							  ),
						"link4" => 
						array(
							  "label"=>__pe("Link 4"),
							  "type"=>"Text",
							  "default"=> "#"
							  ),
						"logo5" => 
						array(
							  "label"=>__pe("Logo 5"),
							  "type"=>"Upload",
							  "default"=> PE_THEME_URL."/images/content/logo_list_05.png"
							  ),
						"link5" => 
						array(
							  "label"=>__pe("Link 5"),
							  "type"=>"Text",
							  "default"=> "#"
							  )
						)
				  );

		PeGlobal::$config["options"] =& apply_filters("pe_theme_options",$options);

		PeGlobal::$config["metaboxes-post"] = 
			array(
				  "tagline" => $taglineMbox,
				  "video" => PeGlobal::$const->video->metaboxPost,
				  "sidebar" => PeGlobal::$const->sidebar->metabox,
				  "footer" => PeGlobal::$const->sidebar->metaboxFooter,
				  "gallery" => PeGlobal::$const->reworkGallery->metaboxPost
				  );

		PeGlobal::$config["metaboxes-page"] = 
			array(
				  "tagline" => $taglineMbox,
				  "gallery" => array_merge(PeGlobal::$const->reworkGallery->metaboxSlider,array("where"=>array("post"=>"page-home"))),
				  "sidebar" => array_merge(PeGlobal::$const->sidebar->metabox,array("where"=>array("post"=>"page-sidebar, page-blog"))),
				  "tables" => PeGlobal::$const->pricingTable->metaboxGroup,
				  "projects" => $projectCarouselMbox,
				  "posts" => $blogCarouselMbox,
				  "blog" => array_merge(PeGlobal::$const->blog->metabox,array("where"=>array("post"=>"page-blog"))),
				  "footer" => PeGlobal::$const->sidebar->metaboxFooter,
				  "portfolio" => PeGlobal::$const->portfolio->metabox,
				  "contact" => PeGlobal::$const->reworkContact->metabox,
				  "gmap" => PeGlobal::$const->gmap->metabox,
				  "logos" => $logosMbox
				  );


		PeGlobal::$config["metaboxes-project"] = 
			array(
				  "tagline" => $taglineMbox,
				  "project" => PeGlobal::$const->reworkProject->metabox,
				  "footer" => PeGlobal::$const->sidebar->metaboxFooter,
				  "gallery" => PeGlobal::$const->reworkGallery->metaboxPost,
				  "video" => PeGlobal::$const->video->metaboxPost
				  );

		PeGlobal::$config["metaboxes-gallery"] = 
			array(
				  "gallery" => PeGlobal::$const->gallery->metabox
				  );

		PeGlobal::$config["metaboxes-video"] = 
			array(
				  "video" => PeGlobal::$const->reworkVideo->metabox
				  );

		
	}

	public function pre_get_posts_filter($query) {
		if ($query->is_search) {
			$query->set('post_type',array('post'));
		}

		return $query;
	}

	protected function init_asset() {
		return new PeThemeReworkAsset($this);
	}

	protected function init_comments() {
		return new PeThemeReworkComments($this);
	}

	protected function init_template() {
		return new PeThemeReworkTemplate($this);
	}

}

?>
