<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $carousel =& $content->meta()->projects; ?>
<?php $project =& $t->project; ?>
<?php $home_simple = $t->content->pageTemplate() === "page-home_simple.php"; ?>
<?php if ($loop = $project->customLoop(empty($carousel->max) ? 8 : intval($carousel->max),null,false)): ?>
<!-- Project Carousel -->
<div id="<?php echo $home_simple ? "project-wrapper-alt" : "project-wrapper"; ?>" class="clearfix">

	<?php if (!$home_simple): ?>
	<div class="section-title one-fourth">
		<h4><?php echo __pe("Latest Work"); ?></h4>
		<?php if (!empty($carousel->content)): ?>
		<p><?php echo $carousel->content; ?></p>
		<?php endif; ?>
		<?php if (!empty($carousel->link)): ?>
		<p><a href="<?php echo get_page_link($carousel->link); ?>"><?php echo __pe("View more projects"); ?></a></p>
		<?php endif; ?>
		<div class="carousel-nav">
			<a id="project-prev" class="jcarousel-prev" href=""></a>
			<a id="project-next" class="jcarousel-next" href=""></a>
		</div>
	</div>
	<?php endif; ?>

	<ul class="project-carousel">
		<?php while ($content->looping()): ?>
		<li>
			<a href="<?php $content->link(); ?>" class="project-item">
				<img src="<?php echo $t->image->resizedImgUrl($content->get_origImage(),220,220); ?>"/>
				<div class="overlay">
					<h5><?php $content->title(); ?></h5>
					<p><?php $project->filterNames(); ?></p>
				</div>
			</a>
		</li>
		<?php endwhile; ?>
		<?php $content->resetLoop(); ?>
	</ul>
</div>
<!-- /Project Carousel -->

<?php if ($home_simple): ?>
<div class="clear"></div>

<!-- View More Work -->
<div class="work-more">
	<?php if (!empty($carousel->link)): ?>
	<a href="<?php echo get_page_link($carousel->link); ?>">
		<?php echo __pe("View more work"); ?>
		<span class="arrow"></span>
	</a>
	<?php endif; ?>
</div>
<!-- /View More Work -->
<?php endif; ?>

<?php endif; ?>
