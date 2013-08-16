<?php $t =& peTheme(); ?>
<?php $comments =& $t->comments; ?>
<?php if ($comments->open()): ?>
<div id="respond">
	<?php if ($comments->requireRegistered()) : ?>
	<p class="comment-notes must-log-in"><?php $comments->register(); ?></p>
	<?php else : ?>

	<h4><?php e__pe("Add a Comment"); ?> <?php cancel_comment_reply_link(" - ".__pe("Cancel Reply")); ?></h4>

	<form method="post" action="<?php $comments->action(); ?>" id="comments-form">
		<?php do_action( 'comment_form_top' ); ?>
		<?php if ($comments->logged()): ?>
		<p class="comment-notes logged-in-as"><?php $comments->logout(); ?></p>
		<?php else: ?>
		<input type="text" value="<?php e__pe("Name"); ?>" id="author" name="author" default-value="<?php e__pe("Name"); ?>" />
		<input type="text" value="<?php e__pe("Email"); ?>" id="email" name="email" default-value="<?php e__pe("Email"); ?>" />
		<?php endif; ?>
		<textarea cols="88" rows="6" id="comment" name="comment" default-value="<?php e__pe("Message"); ?>"><?php e__pe("Message"); ?></textarea>
		<input type="submit" value="<?php e__pe("Add Comment"); ?>" class="red" />
		<?php $comments->fields(); ?>
	</form>
	<?php endif; ?>
</div>
<?php $comments->end(); ?>
<?php else: ?>
<p><?php e__pe("The comments are now closed."); ?></p> 
<?php endif; ?>