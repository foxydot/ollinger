<?php

class PeThemeShortcodeBS_Blog extends PeThemeShortcode {

	public $instances = 0;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "blog";
		$this->group = __pe("CONTENT");
		$this->name = __pe("Blog");
		$this->description = __pe("Blog");
		$this->fields = PeGlobal::$const->blog->metabox["content"];
	}

	public function output($atts,$content=null,$code="") {
		global $post;

		extract($atts);
		$pager = (isset($pager) && $pager !== "no");
		$count = isset($count) ? intval($count) : 10;

		// prevents loops
		if (isset($post) && $post) {
			$custom = array("post__not_in" => array($post->ID));
		}

		$custom["ignore_sticky_posts"] = (isset($sticky) && $sticky === "no") ? 1 : 0;
		
		if (isset($category) && $category !== "") {
			$custom["category_name"] = $category;
		}
		
		if (isset($tag) && $tag !== "") {
			$custom["tag"] = $tag;
		}
		
		if (isset($format) && $format !== "") {
			$tax_query = array(
								array(
									  'taxonomy' => 'post_format',
									  'field' => 'slug',
									  'terms' => array("post-format-$format")
									  )
								);
			$custom["tax_query"] = $tax_query;
		}

		$media = isset($media) && $media != "no";

		$t =& peTheme();
		$t->content->customLoop("post",$count,null,$custom,$pager);
		ob_start();
		$t->template->get_part(compact("media"),"loop",isset($layout) ? $layout : "");
		$t->content->pager();
		$t->content->resetLoop();
		$content =& ob_get_contents();
		ob_end_clean();
		return $content;

	}


}

?>
