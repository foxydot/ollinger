<?php $t =& peTheme(); ?>
<?php if ($t->content->hasFeatImage()): ?>
<a href="<?php $t->content->link(); ?>">
	<img class="image" src="<?php echo $t->image->resizedImgUrl($t->content->get_origImage(),680,224); ?>"/>
</a>
<?php endif; ?>
