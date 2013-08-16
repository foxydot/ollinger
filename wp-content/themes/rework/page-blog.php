<?php
/*
Template Name: Blog
*/
?>
<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<!-- Main Content -->
<?php $content->blog($meta->blog); ?>
<!-- /Main Content -->

<?php if ($meta->blog->layout != "alternate") get_sidebar() ?>
<?php get_footer(); ?>
