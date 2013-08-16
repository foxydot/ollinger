<?php $t =& peTheme(); ?>
<div id="main">
<?php while ($t->content->looping() ) : ?>
<?php $media = isset($t->template->args["media"]) ? $t->template->args["media"] : true; ?>
<?php $link = get_permalink(); ?>
<?php $hasFeatImage = $t->content->hasFeatImage(); ?>

<!--post-->
<div class="post <?php echo (is_single() || is_page()) ? "single" : "" ?> clearfix">
	<a href="<?php echo $link; ?>"><h2><?php $t->content->title() ?></h2></a>
	<ul class="post-meta">
		<li class="author"><?php echo __pe("By "); ?> <a href="#"><?php $t->content->author(); ?></a></li>
		<li class="date"><?php $t->content->date(); ?></li>
		<?php the_tags('<li class="tags">',' · ','</li>'); ?>
		<li class="comments"><a href="<?php echo $link ?>"><?php $t->content->comments() ?> <?php echo __pe("Comments "); ?></a></li>
	</ul>
	<div class="post-entry">
		<?php if ($media) get_template_part("intro-post",$t->content->format()); ?>
		<?php $t->content->content() ?>
	</div>
</div>
<!--end post-->
<?php endwhile; ?>
<?php if (is_single()): ?>
<?php get_template_part("common-pager"); ?>
<?php comments_template(); ?>
<?php else: ?>
<?php $t->content->pager(); ?>
<?php endif; ?>
</div>