<?php
/*
Template Name: About Us
*/
?><?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php get_header(); ?>
<?php get_template_part("common","tagline"); ?>

<?php while ($t->content->looping() ) : ?>
<?php $content->content(); ?>
<?php endwhile; ?>

<?php get_template_part("common","logos"); ?>

<?php get_footer(); ?>
