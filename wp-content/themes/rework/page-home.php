<?php
/*
Template Name: Home
*/
?><?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>
<?php get_template_part("slider","home"); ?>
<?php get_template_part("carousel","project"); ?>
<?php get_template_part("carousel","blog"); ?>

<?php get_template_part("common","logos"); ?>

<?php get_footer(); ?>
