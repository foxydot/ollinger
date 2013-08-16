<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php while ($t->content->looping() ) : ?>
<?php $media = isset($t->template->args["media"]) ? $t->template->args["media"] : true; ?>
<?php $link = get_permalink(); ?>
<?php $hasFeatImage = $t->content->hasFeatImage(); ?>
<?php $idx = $content->idx(); ?>
<?php $last = $content->last(); ?>

<!-- post -->
<div class="post-block one-third <?php echo ($idx % 3 === 2) ? "last" : ""; ?>">
	<div class="post-entry resize-height">
		<a href="<?php echo $link; ?>"><h2><?php $t->content->title() ?></h2></a>
		<?php $t->content->excerpt(); ?>
	</div>
	<?php if ($media && $hasFeatImage): ?>
	<a href="<?php echo $link; ?>">
		<div class="bw-wrapper">
			<img src="<?php echo $t->image->resizedImgUrl($content->get_origImage(),300,190); ?>"/>
		</div>
	</a>
	<?php endif; ?>
	<div class="post-meta">
		<a href="<?php echo $link ?>" class="link">Read More</a>
		<a href="<?php echo $link ?>" class="comments"><?php echo __pe("Comments "); ?> (<?php $t->content->comments() ?>)</a>
	</div>
</div>

<?php if ($idx == $last): ?>
<div class="clear"></div>
<?php endif; ?>

<!--end post-->

<?php endwhile; ?>