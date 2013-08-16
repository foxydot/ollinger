<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<div id="main">
	<?php echo do_shortcode($t->options->get("404content")); ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
