<?php

class PeThemeGallery {

	protected $master;
	protected $options;
	protected $cache;

	public function __construct(&$master) {
		$this->master =& $master;
	}

	public function instantiate() {
		if (is_admin() && defined('PE_MEDIA_TAG')) {
			$this->registerAssets();
			
			add_action("restrict_manage_posts",array(&$this,"restrict_manage_posts"));
			add_filter("parse_query",array(&$this,"parse_query_filter"));
			add_filter("parent_file",array(&$this,"parent_file_filter"));
			add_filter("manage_media_columns",array(&$this,"manage_media_columns_filter"));
			add_filter("media-tags_row_actions",array(&$this,"media_tags_row_actions_filter"));
			add_filter("manage_edit-media-tags_columns",array(&$this,"manage_edit_media_tags_columns_filter"));
			add_filter("manage_edit-media-tags_sortable_columns",array(&$this,"manage_edit_media_tags_columns_filter"));		
			add_filter("manage_media-tags_custom_column",array(&$this,"manage_media_tags_custom_column_filter"),10,3);
			add_action("manage_media_custom_column",array(&$this,"media_tag_content"),"media_tag", 10, 2 );
			add_action("admin_enqueue_scripts",array(&$this,"admin_enqueue_scripts"));
			add_action("load-upload.php",array(&$this,"load_upload"));
			
			$label = PeGlobal::$config["taxonomies"][PE_MEDIA_TAG][1]["labels"]["name"];
			// again escaping from theme check complaints here but we need this menu to go on media because it refers to attachments
			call_user_func("add_media_page",$label,$label,"upload_files","edit-tags.php?taxonomy=media-tags&post_type=attachment");
			//add_media_page($label,$label,"upload_files","edit-tags.php?taxonomy=media-tags&post_type=attachment");

			
			add_action('wp_ajax_pe_theme_gallery_fetch',array(&$this,'ajax_gallery_fetch'));
			add_action('wp_ajax_pe_theme_gallery_add',array(&$this,'ajax_gallery_add'));
			add_action('wp_ajax_pe_theme_multi_upload',array(&$this,'ajax_multi_upload'));
			add_filter('pe_theme_update_metadata',array(&$this,'pe_theme_update_metadata_filter'),10,3);

			add_action('add_meta_boxes_gallery',array(&$this,'add_meta_boxes_gallery'));

			if ($this->master->options->mediaQuick === "yes") {
				add_filter('media_upload_tabs',array(&$this,'media_upload_tabs_filter'));
				add_action('media_upload_pe_quick_media',array(&$this,'pe_quick_media'));
				if ($this->master->options->mediaQuickDefault === "yes") {
					add_filter('media_upload_default_tab',array(&$this,'media_upload_default_tab_filter'));
				}
			}

		}
	}

	public function registerAssets() {
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.mediaTags.js",array('jquery','jquery-ui-core','pe_theme_utils'),"pe_theme_mediaTags");
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.quickImage.js",array('utils','jquery','jquery-ui-core','pe_theme_utils'),"pe_theme_quickImage");
	}

	public function mediaTagsDropdown($selected) {
		wp_dropdown_categories(
							   array(
									 "show_option_all" => __pe("All"),
									 "show_option_none" => __pe("Not Tagged"),
									 "taxonomy"=>PE_MEDIA_TAG,
									 "name"=>PE_MEDIA_TAG,
									 "show_count"=>1,
									 "selected"=>$selected
									 )
							   );
	}


	public function restrict_manage_posts() {
		global $wp_query;
		$screenID = get_current_screen()->id;
		switch ($screenID) {
		case "upload":
			$selected = isset($wp_query->query[PE_MEDIA_TAG]) ? $wp_query->query[PE_MEDIA_TAG] : '';
			$this->mediaTagsDropdown($selected);
			break;
		}
	}

	public function parse_query_filter($query) {
		$qv = &$query->query_vars;
		//$qv["post_parent"] = 871;
		//print_r($qv);
		//	if (isset($qv[PE_MEDIA_TAG]) && is_numeric($qv[PE_MEDIA_TAG])) {
		if (isset($qv[PE_MEDIA_TAG])) {
			if ($qv[PE_MEDIA_TAG] == -1) {
				global $wpdb;

				$untagged = $wpdb->get_col($wpdb->prepare('SELECT wp_term_relationships.object_id FROM wp_term_taxonomy INNER JOIN wp_term_relationships ON (wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id) WHERE taxonomy="%s"',PE_MEDIA_TAG));
				
				$qv[PE_MEDIA_TAG] = "";
				$qv["post__not_in"] = $untagged;
			} else {
				$search = $qv[PE_MEDIA_TAG];
				$delim = false;
				if (strpos($search,"+") !== false) {
					$delim = "+";
				} else if (strpos($search,",") !== false) {
					$delim = ",";
				} 
				$terms = $delim ? explode($delim,$search) : array($search);
				$search = "";
				foreach($terms as $term) {
					if (is_numeric($term)) {
						$term = get_term_by('id',$term,PE_MEDIA_TAG);
						$term = $term ? $term->slug : '';
					}
					$search .= $search ? "$delim$term" : $term;
				}
				$qv[PE_MEDIA_TAG] = $search;
			}
		}
		
		return $query;
	}

	public function manage_media_columns_filter($cols) {
		$cols["pe_media_tags"] = PeGlobal::$config["taxonomies"][PE_MEDIA_TAG][1]["labels"]["name"];
		return $cols;
	}

	public function media_tag_content($column_name,$id) {

		if ($column_name === "pe_media_tags") {
			$tags = wp_get_post_terms($id,PE_MEDIA_TAG);
			if ( !empty( $tags ) ) {
				$out = array();
				foreach ( $tags as $c ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
									  esc_url(add_query_arg(array(PE_MEDIA_TAG => $c->term_id), 'upload.php' ) ),
									  esc_html(sanitize_term_field( 'name', $c->name, $c->term_id, 'tag', 'display' ) )
									  );
				}
				echo join( ', ', $out );
			} else {
				echo __pe("No Tags");
			}
		}
	}

	public function admin_enqueue_scripts() {
		//wp_enqueue_script('plupload-handlers');
		$screenID = get_current_screen()->id;
		switch ($screenID) {
		case "upload":
			wp_enqueue_script("pe_theme_mediaTags");
			break;
		case "media-upload":
			wp_enqueue_script("pe_theme_quickImage");
			wp_enqueue_style("pe_theme_admin");			
			break;
		}
	}

	public function load_upload() {
		$actions = array("bulk_pe_mediaTag_edit","bulk_pe_mediaTag_add","bulk_pe_mediaTag_clear");
		$action = isset($_REQUEST["action"]) && $_REQUEST["action"] != -1 ? $_REQUEST["action"] : (isset($_REQUEST["action2"]) ? $_REQUEST["action2"] : false);
		if (!in_array($action,$actions)) return;

		$media =& $_REQUEST["media"];

		if (!isset($media) || !is_array($media) || count($media) == 0) return;

		check_admin_referer("bulk-media");

		$tags = array();

		switch ($action) {
		case "bulk_pe_mediaTag_add":
		case "bulk_pe_mediaTag_edit":
			$tags =& $_REQUEST["edit-media-tags"];
		if (!isset($tags)) return;
		break;
		}

		$tags = explode(",",$tags);

		foreach ($media as $id) {
			$res = wp_set_post_terms($id,$tags,PE_MEDIA_TAG,($action == "bulk_pe_mediaTag_add"));
		}
	}

	public function option() {
		$posts = get_posts(
						   array(
								 "post_type"=>"gallery",
								 "posts_per_page"=>-1
								 )
						   );
		if (count($posts) > 0) {
			$options = array();
			foreach($posts as $post) {
				$options[$post->post_title] = $post->ID;
			}
		} else {
			$options = array(__pe("No galleries defined, please create one")=>-1);
		}
		return $options;
	}

	public function &getAttachmentsByTags($tags) {
		if ($tags !== false) {
			$wpq = new WP_Query();
			$posts =& $wpq->query(
								  array(
										"post_type"=>"attachment",
										"post_status" => "inherit",
										//"post_mime_type"=>"image",
										'orderby' => 'post_date',
										'order' => 'DESC',
										"media-tags"=>"$tags",
										'no_found_rows' => true,
										"posts_per_page"=>-1
										)
								  );
		} else {
			$posts = array();
		}

		return $posts;
	}

	public function &get($id) {
		if (isset($this->cache[$id])) return $this->cache[$id];
		$post =& get_post($id);
		if (!$post ) return $post;
		$null = null;
		if ($post->post_type != "gallery") return $null;

		$meta =& $this->master->meta->get($id,$post->post_type);
		$post->meta = $meta;


		$gallery = $meta->gallery;

		$tags = $gallery->tags;

		switch ($gallery->type) {
		case "any":
		case "all":
			$tags = (isset($tags) && is_array($tags)) ?  join($gallery->type == "any" ? "," : "+",$tags) : false;
		break;
		case "upload":
			$tags = "gallery-$id";
		}

		//$tags = $tags ? join($gallery->type == "any" ? "," : "+",$tags) : "gallery-$id";

		$order = ($gallery->sort === "custom") && (isset($gallery->order) && is_array($gallery->order)) ? $gallery->order : false;

		//$data = @$gallery->data ? $gallery->data : false;
		$data = isset($gallery->data) ? $gallery->data : false;

		$post->images = $this->getAttachments($tags,$order,$data);

		$i = count($post->images);
		$upd = wp_upload_dir();
		$baseDir = $upd["basedir"]."/";
		$baseUrl = $upd["baseurl"]."/";

		while($i--) {
			$image =& $post->images[$i]->meta;
			$file = $image["file"];
			$image["absfile"] = $baseDir.$file;
			$image["absurl"] = $baseUrl.$file;
		}
		
		$this->cache[$id] =& $post;
		return $post;
	}

	public function count($id) {
		$post =& $this->get($id);
		$count = 0;
		if ($post && @is_array($post->images)) {
			$count = count($post->images);
		}
		return $count;
	}

	public function getSliderData($id,$w,$h) {
		$post =& $this->get($id);
		if (!$post) return null;
		$slider = new StdClass();
		//$slider->count = count($post->images);
		$slider->width = $w;
		$slider->height = $h;
		$slider->id = $id;
		foreach($post->images as $image) {
			$slide =& new stdClass();
			$slider->loop[] =& $slide;
			$slide->id = $image->ID;
			$slide->title = $image->post_title;
			$slide->img = $image->meta["absurl"];
			if (isset($image->data) ) {
				// compatibily with old implementation
				if (is_array($image->data)) {
					foreach ($image->data as $key => $val) {
						//$slide->{$key} = $image->data[$key];
						$slide->{$key} = $val;
					}
				} else {
					foreach (get_object_vars($image->data) as $key => $val) {
						$slide->{$key} = $val;
					}
				}
			}
		};
		return $slider;
	}

	public function getSliderLoop($id,$w = 0,$h = 0,$cols = 4,$class = "span4",$merge = false) {
		$data =& $this->getSliderData($id,$w,$h);
		if ($data) {
			$data->cols = $cols;
			$data->class = $class;

			if (is_array($merge)) {
				foreach ($merge as $key=>$value) {
					$data->{$key} = $value;
				}
			}
		}

		return $this->master->data->create($data);
	}

	public function getSliderConf($conf = null) {
		$plugin = isset($conf->plugin) ? $conf->plugin : "peVolo";
		//$options[] = sprintf('data-plugin="%s"',$plugin);
		$options["plugin"] = $plugin;
		if (isset($conf)) {
			$conf = (array) $conf;
			foreach ($conf as $key => $val) {
				if ($key === "plugin" || $key === "delay" && absint($val) == 0) continue;
				if ($key !== "delay" && strpos($key,"slider_{$plugin}_") !== 0) continue;
				//$options[] = sprintf('data-%s="%s"',str_replace("slider_{$plugin}_","",$key),$val);
				$options[sprintf('%s',str_replace("slider_{$plugin}_","",$key))] = $val;
			}
		}
		return $options;
	}


	public function image($id,$idx = 0) {
		if (($max = $this->count($id)) > 0 && ($idx < $max)) {
			$post =& $this->get($id);
			return $post->images[$idx]->meta["absurl"];
		}
		return "";
	}

	public function images($id) {
		$post =& $this->get($id);
		if (!$post) return false;
		foreach ($post->images as $image) {
			$images[] = $image->meta["absurl"];
		}
		return $images;
		
	}


	public function title($id) {
		$post =& $this->get($id);
		return $post && @$post->post_title ? $post->post_title : "";
	}

	public function cover($id) {
		$img = wp_get_attachment_url(get_post_thumbnail_id($id));
		if (!$img) {
			$img = $this->image($id);
		}
		return $img;
	}


	public function getAttachments($tags,$order = false,$data = null) {
		$posts =& $this->getAttachmentsByTags($tags);

		$max = count($posts);
		$upd = wp_upload_dir();
		$baseUrl = $upd["baseurl"]."/";

		while ($max--) {
			$current =& $posts[$max];
			$current->meta = wp_get_attachment_metadata($current->ID);

			$current->meta["absurl"] = $baseUrl.$current->meta["file"];

			// set custom data
			if ($data && isset($data[$current->ID])) {
				$current->data = $data[$current->ID];
			}

			if ($order !== false) {
				$hash[$current->ID] =& $current;
			}
		}

		if (isset($hash)) {
			$ordered = array();
			
			// add elements following supplied order array
			foreach ($order as $key) {
				if (isset($hash[$key])) {
					$ordered[] =& $hash[$key];
					unset($hash[$key]);
				}
			}

			// check if we have extra items not present in custom order
			if (count($hash) > 0) {
				// shit, we have ....
				$max = count($posts);
				$search = count($hash);
				
				// scan all items and add only the missing ones in the correct order
				while ($search && ($max--)) {
					if (isset($hash[$posts[$max]->ID])) {
						array_unshift($ordered,$posts[$max]);
						$search--;
					}
				}
			} 
			$posts =& $ordered;
		}
		
		return $posts;
	}

	public function createPreviewThumbs($images) {
		$i = count($images);
		$upd = wp_upload_dir();
		$baseUrl = $upd["baseurl"]."/";

		// create thumbs for preview
		while($i--) {
			$image =& $images[$i]->meta;
			$file = $image["file"];
			$image["preview"] = $this->master->image->resize($baseUrl.$file,120,90);
		}
	}

	public function ajax_gallery_fetch() {
		$tags = $_REQUEST["tags"];
		$galleryID = @$_REQUEST["galleryID"];
		$sort = @$_REQUEST["sort"];
		$order = false;
		$data = null;

		//$meta = $this->master->meta->get($galleryID,"gallery");
		$meta = get_post_meta($galleryID,"pe_theme_".PE_THEME_NAME,true);

		if (@$meta->gallery->data) {
			$data =& $meta->gallery->data;
		}

		if ($sort == "custom" && $galleryID) {
			if (@$meta->gallery->order) {
				$order =& $meta->gallery->order;
			}
		}

		$images =& $this->getAttachments($tags,$order,$data);
		$this->createPreviewThumbs($images);

		header("Content-Type: application/json");
		echo json_encode(array("images" => $images,"upload"=>wp_upload_dir()));
		die();
	}

	public function ajax_multi_upload() {
		$postID = isset($_REQUEST["postID"]) ? intval($_REQUEST["postID"]) : 0;

		check_ajax_referer('pe_theme_multi_upload');
		
		$status = wp_handle_upload($_FILES['async-upload'], array('test_form'=>true, 'action' => 'pe_theme_multi_upload'));

		$filename = $status["file"];
		$type = $status["type"];

		//$wp_filetype = wp_check_filetype(basename($filename), null );
		$wp_upload_dir = wp_upload_dir();
		$attachment = array(
							'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path($filename), 
							'post_mime_type' => $type,
							'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
							'post_content' => '',
							'post_status' => 'inherit'
							);
		$attach_id = wp_insert_attachment($attachment,$filename,$postID);
		// you must first include the image.php file
		// for the function wp_generate_attachment_metadata() to work
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		//$post = wp_get_single_post($attach_id);
		$post = get_post($attach_id);
		$post->meta = $attach_data;
		
		$tags = "Gallery $postID";
		wp_set_post_terms($attach_id,$tags,PE_MEDIA_TAG,false);

		$images = array($post);
		$this->createPreviewThumbs($images);

		header("Content-Type: application/json");
		echo json_encode(array("images" => $images,"upload"=>wp_upload_dir()));

		die();
	}

	public function ajax_gallery_add() {
		$tags = $_REQUEST["tags"];
		$galleryID = @$_REQUEST["galleryID"];

		$data = isset($_REQUEST['data']) ? $_REQUEST['data'] : false;

		if ($data && $tags) {
			foreach ($data as $item) {
				wp_set_post_terms($item["id"],$tags,PE_MEDIA_TAG,true);
			}
		}

		$this->ajax_gallery_fetch();
	}

	public function pe_theme_update_metadata_filter($meta,$postID,$post) {
		if ($post->post_type != "gallery") return $meta;

		if (isset($meta->gallery->data) && is_array($meta->gallery->data)) {
			$data =& $meta->gallery->data;
			// unpack gallery image data;
			foreach ($data as $id=>$value) {
				$data[$id] = json_decode(stripslashes($value));
			}
		}

		if ($meta->gallery->type != "upload") return $meta;

		$term = get_term_by("slug","gallery-$postID",PE_MEDIA_TAG);

		if (@$meta->gallery->delete) {
			$delete =& $meta->gallery->delete;
			unset($meta->gallery->delete);
			foreach ($delete as $id) {
				$terms = wp_get_post_terms($id,PE_MEDIA_TAG,array("fields" => "ids"));
				// check if the term is still included 
				if (($pos = array_search($term->term_id,$terms)) !== false) {
					unset($terms[$pos]);
					// update terms
					$terms = array_map("absint",$terms);
					wp_set_object_terms($id,$terms,PE_MEDIA_TAG);
				};
			}
		}

		$term = get_term_by("slug","gallery-$postID",PE_MEDIA_TAG);
		if ($term) {
			wp_update_term($term->term_id,PE_MEDIA_TAG,array("name" => $post->post_title));
		}

		return $meta;
		
	}

	public function media_upload_tabs_filter($tabs) {
		$tabs["pe_quick_media"] = __pe("Quick Browse");
		return $tabs;
	}

	public function parent_file_filter($parent) {
		$screenID = get_current_screen()->id;

		if ($screenID == "edit-media-tags") {
			$parent = "upload.php";
		}
		return $parent;
	}

	public function manage_edit_media_tags_columns_filter($columns) {
		if (isset($columns["posts"])) {
			unset($columns["posts"]);
			$columns["images"] = __pe("Images");
		}
		return $columns;
	}

	public function manage_edit_media_tags_sortable_columns_filter($columns) {
		if (isset($columns["posts"])) {
			unset($columns["posts"]);
			$columns["images"] = "count";
		}
		return $columns;
	}

	public function manage_media_tags_custom_column_filter($ignored,$name,$id) {
		if ($name === "images") {
			$term = get_term_by('id',$id,PE_MEDIA_TAG);
			printf('<a href="%s">%s</a>',esc_url(add_query_arg(array("media-tags"=>$id),'upload.php')),$term->count);
		}
	}

	public function media_tags_row_actions_filter($actions) {
		if (isset($actions["view"])) {
			unset($actions["view"]);
		}
		return $actions;
	}


	public function media_upload_default_tab_filter($default) {
		return "pe_quick_media";
	}

	public function pe_quick_media() {
		return wp_iframe(array(&$this,'mediaQuickView'));
	}

	public function mediaQuickViewTemplate($nonce,$multi = false) {
		$multi = $multi ? 'data-multi="yes"' : '';
?>
<div class="pe_theme quickImage">
	<div class="pe_wrap">
        <div class="contents clearfix">
			<?php if ($multi): ?>
			<input type="button" class="ob_button" id="pe_add" value="Add" style="margin-right: 35px" />
			<input type="button" class="ob_button" id="pe_all" value="Select All" style="margin-right: 5px" />
			<?php endif; ?>
			<?php $this->mediaTagsDropdown(""); ?>
			<div class="pe_gallery">
				<div class="pe_output" id="thumbs" data-nonce="<?php echo $nonce ?>" <?php echo $multi ?>>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	}


	public function mediaQuickView() {
		$nonce = "";
		$featured = "";
		if (!isset($_GET["pe_hide"])) {	
			if (isset($_GET['type']) && $_GET['type'] === "image") {
				// featured image
				$featured = "yes";
				if (isset($_GET['post_id'])) {
					$postID = absint($_GET['post_id']);
					$nonce = wp_create_nonce("set_post_thumbnail-$postID");
				}
			}			
			media_upload_header();
		}

		$this->mediaQuickViewTemplate($nonce,isset($_GET['pe_multi']));
	}

	public function add_meta_boxes_gallery() {
		// create captions manager
		$this->master->captions->instantiate();
	}


}

?>
