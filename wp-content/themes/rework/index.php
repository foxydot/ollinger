<?php $t =& peTheme(); ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<!-- Main Content -->
<?php $t->content->loop(is_search() || is_tax("prj-category") ? "search" : "") ?>
<!-- /Main Content -->

<?php get_sidebar() ?>
<?php get_footer(); ?>
