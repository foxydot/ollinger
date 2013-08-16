<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $t->content->meta(); ?>
<div class="team-member">
	<div class="member-photo">
		<div class="bw-wrapper">
			<img src="<?php echo $t->image->resizedImgUrl($content->get_origImage(),220,220); ?>"/>
		</div>
	</div>
	<div class="member-info">
		<h4><?php $content->title(); ?></h4>
		<span class="position"><?php echo $meta->info->position; ?></span>
		<?php $content->content(); ?>
		<ul class="member-social-links">
			<?php if ($link = $meta->info->twitter): ?>
			<li><a href="<?php echo $link ?>">Twitter</a></li>
			<?php endif; ?>
			<?php if ($link = $meta->info->linkedin): ?>
			<li><a href="<?php echo $link ?>">LinkedIn</a></li>
			<?php endif; ?>
			<?php if ($link = $meta->info->facebook): ?>
			<li><a href="<?php echo $link ?>">facebook</a></li>
			<?php endif; ?>
		</ul>
	</div>
</div>
