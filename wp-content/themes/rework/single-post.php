<?php $t =& peTheme(); ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<!-- Main Content -->
<?php $t->content->loop(); ?>
<!-- /Main Content -->

<!-- Sidebar -->
<div id="sidebar">
<?php get_sidebar() ?>
</div>
<!-- /Sidebar -->

<?php get_footer(); ?>
