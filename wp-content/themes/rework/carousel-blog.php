<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $carousel =& $content->meta()->posts; ?>
<?php if ($loop = $content->customLoop("post",empty($carousel->max) ? 8 : intval($carousel->max))): ?>
<!-- Project Carousel -->
<div id="blog-wrapper" class="clearfix">

	<div class="section-title one-fourth">
		<h4><?php echo __pe("From the blog"); ?></h4>
		<?php if (!empty($carousel->content)): ?>
		<p><?php echo $carousel->content; ?></p>
		<?php endif; ?>
		<?php if (!empty($carousel->link)): ?>
		<p><a href="<?php echo get_page_link($carousel->link); ?>"><?php echo __pe("Read the blog"); ?></a></p>
		<?php endif; ?>
		<div class="carousel-nav">
			<a id="blog-prev" class="jcarousel-prev" href=""></a>
			<a id="blog-next" class="jcarousel-next" href=""></a>
		</div>
	</div>

	<ul class="blog-carousel">
		<?php while ($content->looping()): ?>
		<li>
			<a href="<?php $content->link(); ?>">
				<h4><?php $content->title(); ?></h4>
			</a>
			<span class="date"><?php $content->date(); ?> · <?php $content->comments(); ?> Comments</span>
			<?php $content->excerpt(); ?>
		</li>
		<?php endwhile; ?>
		<?php $content->resetLoop(); ?>
	</ul>
</div>
<!-- /Project Carousel -->
<?php endif; ?>
