<?php
/*
Template Name: Pricing Table
*/
?><?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $pt = $t->ptable; ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<?php while ($content->looping() ) : ?>

<?php if ($pt->getLoop()): ?>

<div class="<?php $pt->columnClasses(); ?> clearfix">

	<?php while ($pt->looping()): ?>
	<?php $table =& $pt->current; ?>
	
	<div class="column <?php $pt->tableClasses(); ?>">
		<div class="header">
			<?php if (!$pt->labels()): ?>
			<h1><?php echo $table->title ?></h1>
			<?php echo $table->price ?>
			<?php endif; ?>
		</div>
		<ul>
			<?php foreach ($table->features as $feature): ?>
			<li><?php echo $feature; ?></li>
			<?php endforeach; ?>
		</ul>
		<div class="footer">
			<?php if (!$pt->labels()): ?>
			<input type="button" value="<?php echo $table->button_label; ?>" class="black" onclick="location.href = '<?php echo $table->button_link; ?>'; return true;"  />
			<?php endif; ?>
		</div>
	</div>

	<?php endwhile; ?>
	<?php $content->resetLoop(); ?>	

</div>
<?php endif; ?>
<?php $content->content(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>







