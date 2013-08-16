<?php

class PeThemeProject {

	protected $master;

	public $custom = "project";
	public $taxonomy = "prj-category";
	public $emtpyMsg;

	public function __construct(&$master) {
		$this->master =& $master;
		$this->emptyMsg = __pe("No project defined, please create one");
	}

	public function option() {
		$posts = get_posts(
						   array(
								 "post_type"=>$this->custom,
								 "posts_per_page"=>-1
								 )
						   );
		if (count($posts) > 0) {
			$options = array();
			foreach($posts as $post) {
				$options[$post->post_title] = $post->ID;
			}
		} else {
			$options = array($this->emptyMsg=>-1);
		}
		return $options;
	}


	public function &get($id) {
		if (isset($this->cache[$id])) return $this->cache[$id];
		$post =& get_post($id);
		if (!$post) return false;
		$meta =& $this->master->meta->get($id,$post->post_type);
		$post->meta = $meta;
		return $post;
	}

	public function exists($id) {
		return $this->get($id) !== false;
		
	}

	public function filter($sep = "",$aclass="label") {
		$tags = false;
		$meta =& $this->master->content->meta();
		if (isset($meta->portfolio->tags) && ($tags = $meta->portfolio->tags) && is_array($tags) && count($tags) > 0) {
			$tags = array_flip($tags);
		}
		$terms = get_terms($this->taxonomy);
		$output = "";
		if (is_array($terms) && count($terms) > 0) {
			$output = apply_filters("pe_theme_project_filter_item",sprintf('<a class="%s active" data-category="" href="#">%s</a>%s',$aclass,__pe("All"),"$sep\n"),$aclass,"",__pe("All"));
			foreach ($terms as $term) {
				if ($tags && !isset($tags[$term->slug])) continue;
				$output .= apply_filters("pe_theme_project_filter_item",sprintf('<a class="%s" data-category="%s" href="#">%s</a>%s',$aclass,$term->slug,$term->name,"$sep\n"),$aclass,$term->slug,$term->name);
			}
			print $output;
		}
	}

	public function filterClasses() {
		global $post;
		$classes = wp_get_post_terms($post->ID,$this->taxonomy,array("fields" => "slugs"));
		if (is_array($classes) && ($count = count($classes)) > 0) {
			while($count--) {
				$classes[$count] = "filter-".$classes[$count];
			}
			echo join(" ",$classes);
		}
	}

	public function filterNames() {
		global $post;
		$names = wp_get_post_terms($post->ID,$this->taxonomy,array("fields" => "names"));
		if (is_array($names) && ($count = count($names)) > 0) {
			echo join(", ",$names);
		}
	}


	public function customLoop($count,$tags,$paged) {
		$custom = null;
		if (is_array($tags) && count($tags) > 0) {
			$custom[$this->taxonomy] = join(",",$tags);
		}
		return $this->master->content->customLoop($this->custom,$count,null,$custom,$paged);
	}

}

?>
