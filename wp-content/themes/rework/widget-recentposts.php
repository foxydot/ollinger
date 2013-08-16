<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $conf = $t->template->args; ?>
<?php if (!empty($conf->title)): ?>
<h5><?php echo $conf->title; ?></h5>
<?php endif; ?>
<ul class="posts">
<?php while ($content->looping()): ?>
<li>
	<a href="<?php $content->link(); ?>">
		<img class="image" src="<?php echo $t->image->resizedImgUrl($content->get_origImage(),50,50); ?>"/>
	</a>
	<div class="entry">
		<a href="<?php $content->link(); ?>"><?php echo $t->utils->truncateString(get_the_excerpt(),50) ?></a>
		<span class="date"><?php $content->date(); ?></span>
	</div>
</li>
<?php endwhile; ?>
</ul>
