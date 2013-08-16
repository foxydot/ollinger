<?php

class PeThemeWidgetProject extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Project");
		$this->description = __pe("Show a project");
		$this->wclass = "widget_portfolio";

		$all = array_merge(
						   array(
								 __pe("Show Latest") => -1
								 ),
						   PeGlobal::$const->project->all
						   );

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=>"Project Widget"
									),
							  "project" => 
							  array(
									"label"=>__pe("Project"),
									"type"=>"Select",
									"description" => __pe("Select the project you wish to show"),
									"options" => $all,
									"default"=>""
									)
							 
							  );

		parent::__construct();
	}


	public function widget($args,$instance) {
		$instance = $this->clean($instance);
		extract($instance);

		if (!@$project) return;		
		$t =& peTheme();

		if ($project > 0) {
			$project = get_post($project);
		} else {
			$project = get_posts(array("post_type"=>"project","posts_per_page"=>1));
			if (is_array($project) && count($project) > 0) {
				$project = $project[0];
			} else {
				return;
			}
		}

		if (!@$project) return;
		
		echo $args["before_widget"];
		if (isset($title)) echo "<h3>$title</h3>";
		$t->data->postSetup($project);
		if (locate_template(array("project-gridcell.php"))) {
			$divClass = ""; 
			$t->template->get_part(compact("divClass"),"project","gridcell");
		} else {
			$content =& $t->content;
?>
<div>
	<a href="<?php $content->link(); ?>" class="peOver">
		<?php $t->content->img(480,396) ?>
		<span></span>
	</a>
	<div class="title">
		<span class="<?php echo $content->meta()->project->icon; ?> "></span>
		<a href="<?php $content->link(); ?>"><?php $content->title(); ?></a>
	</div>
	<p><?php echo $t->utils->truncateString(get_the_excerpt(),60); ?></p>
</div>
<?php
		}
		echo $args["after_widget"];
		$t->data->postReset();
	}


}
?>
