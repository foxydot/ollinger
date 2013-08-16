<?php $t =& peTheme(); ?>
<?php $count = 1; ?>
<ul id="tabs">
<?php foreach ($t->template->args->items as $item): ?>
<li class="<?php echo ($count === 1) ? "active" : ""; ?>"><a href="#tab<?php echo $count; ?>"><?php echo $item->title; ?></a></li>
<?php $count++; ?>
<?php endforeach; ?>
</ul>
<div id="tabs_content_container">
<?php $count = 1; ?>
<?php foreach ($t->template->args->items as $item): ?>
<div id="tab<?php echo $count; ?>" class="tab-content">
	<?php echo $item->body; ?>
</div>
<?php $count++; ?>
<?php endforeach; ?>
</div>
