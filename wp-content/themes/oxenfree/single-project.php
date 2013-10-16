<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $t->content->meta(); 

    $tagline = $meta->tagline->content;?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<?php while ($t->content->looping() ) : ?>
<?php $project =& $content->meta()->project; ?>

<!-- Main Content -->
<div id="main">

	<h1 class="capitalize"><?php $content->title(); ?></h1>
	<h3 class="subtitle"><?php echo $tagline ?></h3>
	<div class="single-project-wrapper <?php echo $content->format(); ?>">
		<?php switch ($content->format()): case "video": ?>
		<?php get_template_part("intro-post","video"); ?>
		<?php break; case "gallery": ?>
		<?php get_template_part("intro-post","gallery"); ?>
		<?php break; default: ?>
		<?php if ($content->hasFeatImage()): ?>
		<img src="<?php echo $t->image->resizedImgUrl($t->content->get_origImage(),680,null); ?>"/>
		<?php endif; ?>
		<?php endswitch; ?>
	</div>
</div>
<!-- /Main Content -->

<!-- Sidebar -->
<div id="sidebar" class="project-description">

	<!-- Project Navigation -->
	<ul class="project-nav">
		<li><a href="<?php echo (($prev = $content->prevPostLink()) ? $prev : "#");  ?>" class="prev<?php echo ($prev ? "": " disabled"); ?>"><?php e__pe("Next"); ?></a></li>
		<?php if (!empty($project->portfolio)): ?>
		<li><a href="<?php echo get_page_link($project->portfolio); ?>" class="back"><?php e__pe("Back to Portfolio"); ?></a></li>
		<?php endif; ?>
		<li><a href="<?php echo (($next = $content->nextPostLink()) ? $next : "#");  ?>" class="next<?php echo ($next ? "": " disabled"); ?>"><?php e__pe("Previous"); ?></a></li>
	</ul>
	<!-- /Project Navigation -->

	<div class="clear"></div>

	<div class="widget short">
		<h5><?php e__pe("Overview"); ?></h5>
		<?php $content->content(); ?>
	</div>

	<?php if (($features = $project->features) && count($features) > 0): ?>
	<div class="widget short">
	 <?php if ($project->list_title) echo "<h5>{$project->list_title}</h5>"; ?>
		<ul class="check-bold compressed">
			<?php foreach ($features as $feature): ?>
			<li><?php echo $feature; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ($project->button_label): ?>
	<a href="<?php echo $project->button_link; ?>"><input type="button" value="<?php echo $project->button_label; ?>" class="red" /></a>
	<?php endif; ?>

</div>
<!-- /Sidebar -->
<?php endwhile; ?>

<?php get_footer(); ?>
