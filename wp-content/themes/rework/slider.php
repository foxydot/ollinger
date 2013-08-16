<?php $t =& peTheme(); ?>
<?php $gallery = $t->content->meta()->gallery ?>
<?php $slider = $t->gallery->getSliderLoop($gallery->id); ?>
<?php if ($slider): ?>
<!-- Slider -->
<div id="main-slider" class="flexslider">
	<ul class="slides">
		<?php while ($slide =& $slider->next()): ?>
		<?php $img = $t->image->resizedImgUrl($slide->img,940,360); ?>
		<li>
			<?php if (!empty($slide->link)): ?>
			<a href="<?php echo $slide->link; ?>">
				<img src="<?php echo $img; ?>"/>
			</a>
			<?php else: ?>
			<img src="<?php echo $img; ?>"/>
			<?php endif; ?>
			<?php if (!empty($slide->caption)): ?>
			<div class="flex-caption">
				<?php echo do_shortcode($slide->caption); ?>
			</div>
			<?php endif; ?>
		</li>
		<?php endwhile; ?>
	</ul>
</div>
<!-- /Slider -->
<?php endif; ?>