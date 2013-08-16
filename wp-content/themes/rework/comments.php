<?php $t =& peTheme(); ?>
<?php if ($t->comments->supported()): ?>
<!-- Comments -->
<div id="comments">

	<h4><?php e__pe("Comments"); ?> (<?php $t->content->comments(); ?>)</h4>

	<?php $t->comments->show(); ?>
	<?php $t->comments->pager(); ?>
	<?php $t->comments->form(); ?>

</div>
<!-- /Comments -->

<?php endif; ?>