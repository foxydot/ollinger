<?php
/**
 * Theme Header
 */

$t =& peTheme();
?><!DOCTYPE html>
<?php $skin = $t->options->get("skin"); ?>
<?php $class = "skin_$skin"; ?>
<html <?php language_attributes(); ?>>
   
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<title><?php $t->header->title(); ?></title>
		
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<!-- favicon -->
		<!--
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700" />
		-->
		<?php $t->font->load(); ?>

		<!-- scripts and wp_head() here -->
		<?php $t->header->wp_head(); ?>
		<!--[if (gte IE 6)&(lte IE 8)]><script type="text/javascript" src="<?php echo peTheme()->asset->getAssetLink("js/selectivizr-min.js"); ?>"></script><![endif]-->

		<?php $t->font->apply(); ?>
		<?php $t->color->apply(); ?>

		<?php if ($customCSS = $t->options->get("customCSS")): ?>
		<style type="text/css"><?php echo stripslashes($customCSS) ?></style>
		<?php endif; ?>
		<?php if ($customJS = $t->options->get("customJS")): ?>
		<script type="text/javascript"><?php echo stripslashes($customJS) ?></script>
		<?php endif; ?>
		

	</head>


	<body <?php $t->content->body_class(); ?>>

		<!-- Main Container -->
<div id="body-wrapper">

    <!-- Header -->
    <div id="header" class="container clearfix">

        <a href="<?php echo home_url(); ?>" id="logo"><img src="<?php echo $t->options->get("logo") ?>" alt="logo" /></a>
		<!--main nav-->
		<?php $t->menu->show("main"); ?>
		
		<!--wpml lang selection-->
		<?php do_action('icl_language_selector'); ?>

    </div>
    <!-- /Header -->


    <!-- Content -->
    <div id="content" class="container clearfix">
		
