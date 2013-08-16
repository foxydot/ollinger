<?php

class PeThemeController {

	protected $runtime;
	protected $defaultOptions;

	public function boot() {
		add_filter('pre_get_posts',array(&$this,"pre_get_posts_filter"));

		PeGlobal::$config["content-width"] = 940;
		PeGlobal::$config["post-formats"] = array("image","video");
		PeGlobal::$config["nav-menus"]["main"] = __pe("Main menu");	

		PeGlobal::$config["shortcodes"] = 
			array(
				  "Clearfix",
				  "Testimonial",
				  "Button",
				  "Lightbox",
				  "Video",
				  "Download",
				  "Link",
				  "Warning",
				  "Info",
				  "Properties",
				  "Columns",
				  "Line"
				  );

		PeGlobal::$config["sliders"] = 
			apply_filters(
						  "pe_theme_available_sliders",
						  array(
								__pe("Pixelentity (slide, touchenabled)") => "peVolo"
								)
						  );

		$brandingSection = isset($_GET["branding"]) ? __pe("Branding") : "hidden";
		
		$options = array(
						 "import_demo" => 
						 array(
							   "label"=>__pe("Import Demo Content"),
							   "type"=>"ImportDemo",
							   "section"=>__pe("General"),
							   "description" => __pe("Will import all demo data, including menus, sidebars, widgets and configuration"),
							   "default"=>"default"
							   ),						 
						 "customCSS" =>
						 array(
							   "label"=>__pe("Custom CSS"),
							   "type"=>"TextArea",
							   "section"=>__pe("General"),
							   "description" => __pe("Here you can enter custom CSS selectors to add to or overwrite the theme's default CSS styles. See the help documentation for some code snippets which can be pasted here"),
							   "default"=>""
							   ),
						 "customJS" =>
						 array(
							   "label"=>__pe("Custom JS"),
							   "type"=>"TextArea",
							   "section"=>__pe("General"),
							   "description" => __pe("Here you can enter custom javascript code and it will be added to the theme's existing javascript code"),
							   "default"=>""
							   ),
						 "adminLogo" => 
						 array(
							   "label"=>__pe("Custom Admin Panel Logo"),
							   "type"=>"Upload",
							   "section"=>$brandingSection,
							   "description" => __pe("Enter the url of the logo you would like to be displayed in this theme's custom options panel. The image should be aprox. 170x50px .png file. This field is hidden to prevent further rebranding. See the help docs for more info."),
							   "default"=> PE_THEME_URL."/framework/images/framework_logo.png"
							   ),
						 "adminUrl" =>
						 array(
							   "label"=>__pe("Custom Admin Panel Url"),
							   "type"=>"Text",
							   "section"=>$brandingSection,
							   "description" => __pe("This is the link which will be added to the theme options panel's custom logo. This field is also hidden"),
							   "default"=>"http://pixelentity.com"
							   ),
						 "minifyJS" =>				
						 array(
							   "label"=>__pe("Enable Javascript Compression"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES", a single compressed javascript file will be loaded instead of multiple ones: site will load faster but any customization you made to theme javascript sources will be ignored'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"no"
							   ),
						 "minifyCSS" =>				
						 array(
							   "label"=>__pe("Enable CSS Compression"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES", a single compressed css file will be loaded instead of multiple ones: site will load faster but any customization you made to style.css or other theme stylesheet will be ignored'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"no"
							   ),
						 "adminThumbs" =>				
						 array(
							   "label"=>__pe("Show Thumbnails"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES", shows thumbnails (featured images) in admin post list view.'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"yes"
							   ),
						 "mediaQuick" =>				
						 array(
							   "label"=>__pe("Enable Quick Browse Mode"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES", a new tab will appear in the default WordPress media uploader. This tab, named "Quick Browse" will display a filterable thumbnail grid of all uploaded media content. Media may be selected from this grid and added to galleries, posts and pages. When disabled, some functions related Galleries managment won\'t be available.'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"yes"
							   ),
						 "mediaQuickDefault" =>				
						 array(
							   "label"=>__pe("Make Quick Browse the Default Tab"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES" the default WordPress Media Loader\'s dialog  will display this "Quick Browse" mode as its default tab.'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"no"
							   ),
						 "contactEmail" =>				
						 array(
							   "label"=>__pe("Email Address"),
							   "type"=>"Text",
							   "section" => __pe("Contact Form"),
							   "description"=>__pe('Enter the email address where the contact form emails will be sent. If this field is left blank, the Admin email address will be used. The Admin email address is that entered in General Settings > Email Address.'),
							   "default"=>""
							   ),
						 "contactSubject" =>				
						 array(
							   "label"=>__pe("Subject Line"),
							   "type"=>"Text",
							   "section" => __pe("Contact Form"),
							   "description"=>__pe('Enter a custom subject line which will appear on all email sent from the contact form. This is useful when setting up email filters.'),
							   "default"=>"Contact Form Message",
							   "wpml" => true
							   ),
						 "updateCheck" => 
						 array(
							   "label"=>__pe("Check for Theme Updates"),
							   "type"=>"RadioUI",
							   "section"=>__pe("Auto Update"),
							   "description" => __pe("Specify if theme should automatically check for updates."),
							   "options" => 
							   array(
									 __pe("Yes") => "yes",
									 __pe("No") => "0",
									 ),
							   "default"=>"0"
							   ),
						 "updateUsername" => 
						 array(
							   "label"=>__pe("Envato Username"),
							   "type"=>"EnvatoUsername",
							   "section"=>__pe("Auto Update"),
							   "description" => __pe("Insert your Envato Username (account used to purchase this theme)."),
							   "default"=>""
							   ),
						 "updateAPIKey" => 
						 array(
							   "label"=>__pe("API Key"),
							   "type"=>"EnvatoAPI",
							   "section"=>__pe("Auto Update"),
							   "description" => __pe("Insert your API Key %swhich can be obtained here%s. (Generate one if none available)"),
							   "default"=>""
							   )

						 );

		if ($this->is_ngg_active()) {
			$options["nggCustom"] = 
				array(
					  "label"=>__pe("Enable NextGen Plugin Integration"),
					  "type"=>"RadioUI",
					  "section"=>__pe("NextGen"),
					  "description" => __pe("If you have installed the NextGEN Gallery plugin, this option will enable it to be auto configured. See help docs for more info."),
					  "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
					  "default"=>"yes"
					  );
				
			$options["nggColumns"] = 
				array(
					  "label"=>__pe("Gallery columns"),
					  "type"=>"RadioUI",
					  "section"=>__pe("NextGen"),
					  "description" => __pe("Select the number of columns to be shown in the NextGen galleries"),
					  "single" => true,
					  "options" => range(1,3),
					  "default"=>3
					  );
		}

		$this->defaultOptions =& $options;
		PeGlobal::$config["options"] = $this->defaultOptions;

		// no common metaboxes
		PeGlobal::$config["metaboxes"] = array();

		if (!$this->is_mediatags_active()) {
			define('PE_MEDIA_TAG',"media-tags");


			PeGlobal::$config["taxonomies"] = 
				array(
					  PE_MEDIA_TAG =>
					  array(
							'attachment',
							array(
								  //'label' => __pe('Media Tag'),
								  "labels" => 
								  array(
										'name' 				=> __pe('Media-Tags'),
										'singular_name' 	=> __pe('Media-Tag'),
										'search_items' 		=> __pe('Search Media-Tags'),
										'popular_items' 	=> __pe('Popular Media-Tags'),		
										'all_items' 		=> __pe('All Media-Tags'),
										'parent_item' 		=> __pe('Parent Media-Tag'),
										'parent_item_colon' => __pe('Parent Media-Tag:'),
										'edit_item' 		=> __pe('Edit Media-Tag'), 
										'update_item' 		=> __pe('Update Media-Tag'),
										'add_new_item' 		=> __pe('Add New Media-Tag'),
										'new_item_name' 	=> __pe('New Media-Tag Name')
										),
								  'hierarchical' => false,
								  'sort' => true,
								  'show_ui' => false,
								  'show_in_nav_menus' => false,
								  "update_count_callback" => "_update_generic_term_count",
								  'args' => array('orderby' => 'term_order' ),
								  'rewrite' => array('slug' => PE_MEDIA_TAG )
								  )
							)
					  );
		}

		PeGlobal::$config["post_types"] =
			array(
				  "gallery"=>
				  array(
						'labels' => 
						array(
							  'name'              => __pe("Galleries"),
							  'singular_name'     => __pe("Gallery"),
							  'add_new_item'      => __pe("Add New Gallery"),
							  'search_items'      => __pe('Search Galleries'),
							  'popular_items' 	  => __pe('Popular Galleries'),		
							  'all_items' 		  => __pe('All Galleries'),
							  'parent_item' 	  => __pe('Parent Gallery'),
							  'parent_item_colon' => __pe('Parent Gallery:'),
							  'edit_item' 		  => __pe('Edit Gallery'), 
							  'update_item' 	  => __pe('Update Gallery'),
							  'add_new_item' 	  => __pe('Add New Gallery'),
							  'new_item_name' 	  => __pe('New Gallery Name')
							  ),
						'public' => true,
						'has_archive' => false,
						"supports" => array("title","thumbnail"),
						"taxonomies" => array("")
						),
				  "video" =>
				  array(
						'labels' => 
						array(
							  'name'              => __pe("Videos"),
							  'singular_name'     => __pe("Video"),
							  'add_new_item'      => __pe("Add New Video"),
							  'search_items'      => __pe('Search Videos'),
							  'popular_items' 	  => __pe('Popular Videos'),		
							  'all_items' 		  => __pe('All Videos'),
							  'parent_item' 	  => __pe('Parent Video'),
							  'parent_item_colon' => __pe('Parent Video:'),
							  'edit_item' 		  => __pe('Edit Video'), 
							  'update_item' 	  => __pe('Update Video'),
							  'add_new_item' 	  => __pe('Add New Video'),
							  'new_item_name' 	  => __pe('New Video Name')
							  ),
						'public' => true,
						'has_archive' => false,
						"supports" => array("title","thumbnail"),
						"taxonomies" => array("")
						)
				  );

		do_action("pe_theme_custom_post_type");

		PeGlobal::$config["metaboxes-gallery"] = 
			array(
				  "gallery" => PeGlobal::$const->gallery->metabox
				  );

		PeGlobal::$config["metaboxes-video"] = 
			array(
				  "video" => PeGlobal::$const->video->metabox
				  );

		/*
		PeGlobal::$config["taxonomies"] = 
			array(
				  // test tax 1
				  "custom" =>
				  array(
						'post',
						array(
							  'label' => __pe('Custom'),
							  'sort' => true,
							  'args' => array('orderby' => 'term_order' ),
							  'rewrite' => array('slug' => 'custom' )
							  )
						)
				  );
		
		PeGlobal::$config["post_types"] =
			array(
				  // test custom post type 1;
				  "product"=>
				  array(
						'labels' => 
						array(
							  'name' => __pe( 'Products' ),
							  'singular_name' => __pe( 'Product' )
							  ),
						'public' => true,
						'has_archive' => true,
						"supports" => array("title","editor","post-formats","thumbnail"),
						"taxonomies" => array("category","post-tag","custom")
						)
				  );
		*/

		/*
		PeGlobal::$config["options"] = 
			array(				  
				  "sidebars" => 
				  array(
						"label"=>__pe("Sidebars"),
						"type"=>"Sidebars",
						"section"=>__pe("General"),
						"description" => __pe("Sidebars"),
						"default"=>""
						),
				  "test1" => 
				  array(
						"label"=>__pe("Textfield"),
						"type"=>"Text",
						"section"=>__pe("General"),
						"description" => __pe("Description"),
						"default"=>"ok"
						),				  
				  "test2" => 
				  array(
						"label"=>__pe("Upload"),
						"type"=>"Upload",
						"section"=>__pe("General"),
						"description" => __pe("Description"),
						"default"=>PE_THEME_URL."/framework/images/framework_logo.png"
						),
					
				  "test3" => 
				  array(
						"label"=>__pe("Select"),
						"type"=>"Select",
						"section"=>__pe("General"),
						"description" => __pe("Description"),
						"options" => 
						array(
							  "--- Select ---" => "",
							  "First" => "one",
							  "Second" => "second"
							  ),
						"default"=>""
						),
					
				  "test4" => 
				  array(
						"label"=>__pe("Select (single)"),
						"type"=>"Select",
						"section"=>__pe("General"),
						"description" => __pe("Description"),
						// if single == true => key = value
						"single" => true,
						"options" => Array("One","Two","Three"),
						"default"=>""
						),
				  
				  "test5" => 
				  array(
						"label"=>__pe("Checkbox"),
						"type"=>"Checkbox",
						"section"=>__pe("General"),
						"description" => __pe("Description"),
						// if single == true => key = value
						//"single" => true,
						"options" => Array("One"=>100,"Two"=>200,"Three"=>300),
						"default"=>""
						),
				  
				  "test6" => 
				  array(
						"label"=>__pe("Checkbox UI"),
						"type"=>"CheckboxUI",
						"section"=>__pe("General"),
						"description" => __pe("Description"),
						// if single == true => key = value
						//"single" => true,
						"options" => Array("One"=>100,"Two"=>200,"Three"=>300),
						"default"=>200
						),
				  
				  "test7" => 
				  array(
						"label"=>__pe("Radio"),
						"type"=>"Radio",
						"section"=>__pe("General"),
						"description" => __pe("Description"),
						// if single == true => key = value
						//"single" => true,
						"options" => Array("One"=>100,"Two"=>200,"Three"=>300),
						"default"=>200
						),
				  
				  "test8" => 
				  array(
						"label"=>__pe("Radio UI"),
						"type"=>"RadioUI",
						"section"=>__pe("General"),
						"description" => __pe("Description"),
						// if single == true => key = value
						//"single" => true,
						"options" => Array("One"=>100,"Two"=>200,"Three"=>300),
						"default"=>200
						),
				  
				  "test9" => 
				  array(
						"label"=>__pe("Color Picker"),
						"type"=>"Color",
						"section"=>__pe("General"),
						"description" => __pe("Description"),
						"default"=>"#FFFFFF"
						),											 
				  
				  "test50" => 
				  array(
						"label"=>__pe("Test"),
						"type"=>"Text",
						"section"=>__pe("Advanced"),
						"description" => __pe("Description"),
						"default"=>"ok"
						),
				  
				  "test60" => 
				  array(
						"label"=>__pe("Test"),
						"type"=>"Text",
						"section"=>__pe("Advanced"),
						"description" => __pe("Description"),
						"default"=>"ok"
						)
								  );
		*/
		  
	}

	// after_theme_setup hook
	public function after_setup_theme() {
		$tp = get_template_directory();

		load_theme_textdomain(PE_THEME_NAME,"$tp/languages");
	
		$locale = get_locale();
		$locale_file = "$tp/languages/$locale.php";
	
		if (is_readable($locale_file)) {
			require_once($locale_file);
		}
		
		if (isset(PeGlobal::$config["post-formats"])) {
			add_theme_support("post-formats",PeGlobal::$config["post-formats"]);
		}
		
		add_theme_support("post-thumbnails");
		add_theme_support("automatic-feed-links");
	}

	// init hook
    public function init() {

		// menus
		$nav_menu =& PeGlobal::$config["nav-menus"];
		if (isset($nav_menu) && count($nav_menu) > 0) {
			foreach ($nav_menu as $name => $description ) {
				register_nav_menu($name,$description);				
			}
		}

		$image_sizes =& PeGlobal::$config["image-sizes"];
		if (isset($image_sizes) && count($image_sizes) > 0) {
			foreach ($image_sizes as $name => $params ) {
				add_image_size($name,$params[0],$params[1],$params[2]);
			}
		}

		// taxonomies
		$taxonomies =& PeGlobal::$config["taxonomies"];
		if (isset($taxonomies) && count($taxonomies) > 0) {
			foreach ($taxonomies as $name=>$params) {
				register_taxonomy($name,$params[0],$params[1]);
			}
		}
		// custom post types
		$post_types =& PeGlobal::$config["post_types"];
		if (isset($post_types) && count($post_types) > 0) {
			foreach ($post_types as $name=>$params) {
				register_post_type($name,$params);
			}
		}

		// sidebars
		$this->sidebar->register();

		// shortcodes
		$this->shortcode->add();

		// instantiate content module
		$this->content->instantiate();

		if ($this->options->get("nggCustom") && $this->is_ngg_active()) {
			$this->ngg->instantiate();
		}

	}

	public function widgets_init() {
		// WPML plugin support
		if (defined('ICL_LANGUAGE_CODE')) {
			$this->wpml->instantiate();
		}

		$this->widget->add();
	}


	public function is_ngg_active() {
		return ($this->is_plugin_active("nextgen-gallery/nggallery.php"));
	}

	public function is_mediatags_active() {
		return ($this->is_plugin_active("media-tags/media_tags.php"));
	}


	public function after_switch_theme($theme) {
		// update rewrite rules for custom post types
		flush_rewrite_rules();

		if (isset(PeGlobal::$config["image-sizes"]["thumbnail"])) {
			list($width,$height,$crop) = PeGlobal::$config["image-sizes"]["thumbnail"];
			update_option("thumbnail_size_w",$width);
			update_option("thumbnail_size_h",$height);
			update_option("thumbnail_crop",$crop);
		}

		if (isset(PeGlobal::$config["image-sizes"]["medium"])) {
			list($width,$height,$crop) = PeGlobal::$config["image-sizes"]["medium"];
			update_option("medium_size_w",$width);
			update_option("medium_size_h",$height);
		}

		if (isset(PeGlobal::$config["image-sizes"]["large"])) {
			list($width,$height,$crop) = PeGlobal::$config["image-sizes"]["large"];
			update_option("large_size_w",$width);
			update_option("large_size_h",$height);
		}

		wp_redirect(admin_url("themes.php?page=pe_theme_options"));

	}


	public function enqueueAssets() {
		$this->asset->enqueueAssets();
	}

	public function &__get($what) {
		$runtime =& $this->runtime[$what];
		
		if (!isset($runtime)) {
			$m = "init_$what";
			if (method_exists($this,$m)) {
				$runtime = $this->$m();
			} else {
				throw new Exception("Unknown theme object: $what");
			}
		} 
		return $runtime;
	}

	public function getMetaboxConfig($type) {
		$config =& PeGlobal::$config;
		$metaboxes = PeGlobal::$config["metaboxes"];

		if (@$custom =& $config["metaboxes-$type"]) {
			$keys = array_keys($custom);
			foreach ($keys as $key) {
				$metaboxes[$key] = $custom[$key];
				$where =& $metaboxes[$key]["where"];
				list($orig,$values) = each($where);
				if ($orig != $type) {
					unset($where[$orig]);
					$where[$type] = $values;
				}
			}
		}
		return $metaboxes;

	}

	
	protected function init_header() {
		return new PeThemeHeader();
	}

	protected function init_footer() {
		return new PeThemeFooter($this);
	}

	protected function init_menu() {
		return new PeThemeMenu();
	}

	protected function init_category() {
		return new PeThemeCategory();
	}

	protected function init_sidebar() {
		return new PeThemeSidebar($this);
	}

	protected function init_content() {
		return new PeThemeContent($this);
	}

	protected function init_shortcode() {
		return new PeThemeSCManager($this);
	}

	protected function init_captions() {
		return new PeThemeCaption($this);
	}

	protected function init_widget() {
		return new PeThemeWGManager($this);
	}

	protected function init_asset() {
		return new PeThemeAsset($this);
	}

	protected function init_image() {
		return new PeThemeImage();
	}

	protected function init_utils() {
		return new PeThemeUtils();
	}

	protected function init_browser() {
		return new PeThemeBrowser();
	}

	protected function init_admin() {
		return new PeThemeAdmin($this);
	}

	protected function init_metabox() {
		return new PeThemeMBox($this);
	}

	protected function init_options() {
		return new PeThemeOptions($this);
	}

	protected function init_comments() {
		return new PeThemeComments($this);
	}

	protected function init_data() {
		return new PeThemeData($this);
	}

	protected function init_ngg() {
		return new PeThemeNgg($this);
	}

	protected function init_gallery() {
		return new PeThemeGallery($this);
	}

	protected function init_ptable() {
		return new PeThemePricingTable($this);
	}

	protected function init_staff() {
		return new PeThemeStaff($this);
	}

	protected function init_service() {
		return new PeThemeService($this);
	}

	protected function init_editor() {
		return new PeThemeEditor($this);
	}

	protected function init_video() {
		return new PeThemeVideo($this);
	}

	protected function init_project() {
		return new PeThemeProject($this);
	}

	protected function init_background() {
		return new PeThemeBackground($this);
	}

	protected function init_export() {
		return new PeThemeExport($this);
	}
	
	protected function init_template() {
		return new PeThemeTemplate($this);
	}

	protected function init_meta() {
		return new PeThemeMeta($this);
	}

	protected function init_font() {
		return new PeThemeFont($this);
	}

	protected function init_color() {
		return new PeThemeColor($this);
	}

	protected function init_wpml() {
		return new PeThemeWPML($this);
	}

	public function add_meta_boxes($page,$object) {
		return $this->metabox->add_meta_boxes($page,$object);
	}

	public function save_post($id,$post) {
		return $this->metabox->save_post($id,$post);
	}

	public function admin_menu() {
		return $this->admin->admin_menu();
	}

	public function admin_init() {
		return $this->admin->admin_init();
	}

	public function export_wp() {
		return $this->export->export_wp();
	}

	public function rss2_head() {
		return $this->export->rss2_head();
	}

	public function dbx_post_advanced() {
		return $this->shortcode->admin();
	}

	public function sidebar_admin_setup() {
		return $this->widget->admin();
	}
	
	public function is_plugin_active( $plugin ) {
        return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || $this->is_plugin_active_for_network( $plugin );
	}

	public function is_plugin_active_for_network( $plugin ) {
        if ( !is_multisite() )
			return false;

        $plugins = get_site_option( 'active_sitewide_plugins');
        if ( isset($plugins[$plugin]) )
			return true;

        return false;
	}

	public function pre_get_posts_filter($query) {
		if ($query->is_search) {
			$query->set('post_type',array('post'));
		}
		return $query;
	}

	public function contactForm() {
		$data = array_map('stripslashes_deep',$_POST["data"]);
		$success = false;

		if (count($data) > 0) {
			$from = $to = (@$this->options->contactEmail) ? $this->options->contactEmail : get_bloginfo("admin_email");
			$email_text = "";

			foreach($data as $key => $value){
				if ($value != "") {
					if ($key == "email") {
						$from = $value;
					}
					$email_text.="<br><b>".ucfirst(str_replace("_", " ",$key))."</b> - ".nl2br($value);
				}
			}
			$subject = (@$this->options->contactSubject) ? @$this->options->contactSubject : "Contact from ".get_bloginfo('name');
			$from = "<$from>";

			if (isset($data["author"])) {
				$from = $data["author"]." $from";
			}

			$headers = "From: $from\n" . "MIME-Version: 1.0\n" . "Content-type: text/html; charset=utf-8\n";
			$success = wp_mail($to, $subject, $email_text, $headers);
		}

		$response = json_encode(array("success" => $success,"mail"=>$email_text));
		header( "Content-Type: application/json" );
		echo $response;
		die();
	}

	public function newsletter() {
		$data = array_map('stripslashes_deep',$_POST["data"]);
		$success = false;

		if (count($data) > 0 || !$data["email"] || !$data["instance"]) {

			// get newsletter address from widget conf
			list($instance,$id) = explode("-","widget_".$data["instance"]);
			$options = get_option($instance);
			
			if ($options && $options[$id] && $to=$options[$id]["subscribe"]) { 

				$from = "Subscriber <".$data["email"].">";
				$email_text = "subscribe";

				$subject = "Subscribe from ".get_bloginfo('name');
				$headers = "From: $from\n" . "MIME-Version: 1.0\n" . "Content-type: text/html; charset=utf-8\n";
				$success = wp_mail($to, $subject, $email_text, $headers);
			}
		}

		$response = json_encode(array("success" => $success,"mail"=>$email_text));
		header( "Content-Type: application/json" );
		echo $response;
		die();
	}

}

?>