<?php $t =& peTheme(); ?>
<?php $first = true; ?>
<?php foreach ($t->template->args->items as $item): ?>
<div class="accordion-button <?php echo $first ? "first" : ""; ?>" id="open"><a href="#"><?php echo $item->title; ?></a></div>
<div class="accordion-content">
	<?php echo $item->body; ?>
</div>
<?php $first = false; ?>
<?php endforeach; ?>