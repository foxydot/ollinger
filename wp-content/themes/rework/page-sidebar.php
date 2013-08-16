<?php
/*
Template Name: Sidebar
*/
?>
<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<div id="main">
	<?php while ($t->content->looping() ) : ?>
	<?php $content->content(); ?>
	<?php endwhile; ?>
</div>

<?php get_sidebar() ?>
<?php get_footer(); ?>
