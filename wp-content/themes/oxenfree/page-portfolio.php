<?php
/*
Template Name: Portfolio
*/
?><?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php $project =& $t->project; ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<?php while ($content->looping() ) : ?>

<?php if (!post_password_required()): ?>
<?php $cols = $meta->portfolio->columns; ?>
<?php $filterable = $meta->portfolio->filterable == "yes" && $cols > 1; ?>

<?php if ($filterable): ?>
<!-- Project Feed Filter -->
<ul class="project-feed-filter">
	<?php $project->filter('',"keyword"); ?>
</ul>
<!-- /Project Feed Filter -->
<?php endif; ?>

<?php if ($loop = $project->customLoop(-1,$meta->portfolio->tags,false)): ?>
<?php $mainClass = array("one-half","one-third","one-fourth","one-fourth"); ?>
<?php $size = array(array(460,345),array(300,300),array(220,200),array(220,175)); ?>
<?php $mainClass = $mainClass[$cols-2]; ?>
<?php $size = $size[$cols-2]; ?>
<!-- Project Feed -->
<div class="project-feed clearfix">

	<?php while ($content->looping()): ?>
	<?php $meta =& $content->meta(); ?>
	<?php $idx = $content->idx(); ?>
	<?php $last = $content->last(); ?>
	<div class="<?php echo $mainClass ?> <?php $project->filterClasses(); ?>">
		<a href="<?php echo get_permalink(); ?>" class="project-item">
			<?php if ($cols < 5): ?>
			<img src="<?php echo $t->image->resizedImgUrl($content->get_origImage(),$size[0],$size[1]); ?>"/>
			<div class="overlay">
				<h5><?php $content->title(); ?></h5>
				<p><?php $project->filterNames(); ?></p>
			</div>
			<?php else: ?>
			<div class="bw-wrapper"><img src="<?php echo $t->image->resizedImgUrl($content->get_origImage(),$size[0],$size[1]); ?>"/></div>
			<div class="project-title">
				<h5><?php $content->title(); ?></h5>
			</div>
			<?php endif; ?>
		</a>
	</div>
	<?php endwhile; ?>
	<?php $content->resetLoop(); ?>

</div>
<!-- /Project Feed -->
<?php endif; ?>
<?php else: ?>
<p><?php $content->content(); ?></p>
<?php endif; ?>
<?php endwhile; ?>

<?php get_footer(); ?>
