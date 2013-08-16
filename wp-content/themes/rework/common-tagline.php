<?php $t =& peTheme(); ?>
<?php $meta =& $t->content->meta(); ?>
<?php

$tagline = "";
$autoSection = true;

if ((is_single() || is_page()) && !empty($meta->tagline->content)) {
	$autoSection = false;
	$tagline = $meta->tagline->content;
} else if (is_404()) {
	$tagline = do_shortcode($t->options->get("404title"));
} else {
	$tagline = wp_title("",false);
}

?>

<?php if (is_page()): ?>
<?php switch ($t->content->pageTemplate()): case "page-home.php" ?>
<h1 class="page-title">
<?php break; case "page-home_simple.php": ?>
<h1 class="page-title-alt">
<?php break; case "page-contact.php": ?>
<h1 class="page-title-inner fixed">
<?php break; default: ?>
<h1 class="page-title-inner">
<?php endswitch; ?>
<?php else: ?>
<h1 class="page-title-inner">
<?php endif; ?>
<?php if ($autoSection): ?>
     <span class="section-title"><?php echo $tagline ?></span>
<?php else: ?>
	 <?php echo $tagline ?>
<?php endif; ?>
</h1>
