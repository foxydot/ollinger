<?php $t =& peTheme(); ?>
<?php $gallery = $t->content->meta()->gallery ?>
<?php $slider = $t->gallery->getSliderLoop($gallery->id); ?>
<?php if ($slider): ?>
<?php $w = isset($gallery->width) ? intval($gallery->width) : 680; ?> 
<?php $h = isset($gallery->height) ? intval($gallery->height) : 224; ?> 
<div class="flexslider image-slider">
	<ul class="slides">
		<?php while ($slide =& $slider->next()): ?>
		<?php $img = $t->image->resizedImgUrl($slide->img,$w,$h); ?>
		<li><div class="flex-caption">
                <?php echo do_shortcode($slide->caption); ?>
            </div>
			<?php if (!empty($slide->link)): ?>
			<a href="<?php echo $slide->link; ?>">
				<img src="<?php echo $img; ?>"/>
			</a>
			<?php else: ?>
			<img src="<?php echo $img; ?>"/>
			<?php endif; ?>
		</li>
		<?php endwhile; ?>
	</ul>
</div>
<?php endif; ?>


