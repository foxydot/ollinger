<?php

class PeThemeReworkComments extends PeThemeComments {


	public function register() {
		printf(__pe('You must be <a href="%s">logged in</a> to post a comment.'),wp_login_url(apply_filters('the_permalink',get_permalink($this->post_id))));
		do_action("comment_form_must_log_in_after");
	}

	public function logout() {
		printf(__pe('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url("profile.php"), $this->user_identity, wp_logout_url(apply_filters('the_permalink',get_permalink($this->post_id))));
	}

	public function show() {
		global $post;

		if (post_password_required($post)) {
			return;
		}
		echo '<ol class="comments-list">';
		wp_list_comments(array("callback"=>array(&$this,"format")));
		echo '</ol>';
	}

	public function comment_reply_link_filter($link) {
		return str_replace("comment-reply-link","reply comment-reply-link",$link);
	}

	public function cancel_comment_reply_link_filter($link) {
		return str_replace("<a",'<a class="reply comment-reply-link"',$link);
	}

	public function format($comment, $args, $depth) {
		$GLOBALS["comment"] =& $comment;
		$id = $comment->comment_ID;
?>
		<li <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php echo $id ?>">
		
		<!--comment body-->
		<div id="div-comment-<?php echo $id ?>">
			<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, 45); ?>

			<div class="comment-meta">
				<h5 class="author">
			 <?php echo get_comment_author_link(); ?> <?php comment_reply_link(array_merge( $args, array('add_below' => "div-comment", 'depth' => $depth, 'max_depth' => $args['max_depth'], "before" => " - "))) ?>
				</h5>
				<p class="date"><?php printf( __pe('%1$s at %2$s'), get_comment_date(),  get_comment_time()); ?></p>
				<?php if ($comment->comment_approved == '0') : ?>
				<p class="date"><?php echo __pe('Your comment is awaiting moderation.') ?></p>
				<?php endif; ?>
			</div>
			<div class="comment-entry">
				<?php comment_text(); ?>
			</div>

		</div>
<?php
	}
}

?>