<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to reedable_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package reedable
 * @since reedable 1.0
 */
?>

<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if (post_password_required())
		return;
?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if (have_comments()): ?>
		<h2 class="comments-title">
			<?php
				printf(_nx('One comment', '%1$s comments', get_comments_number(), 'comments title', 'reedable'),
					number_format_i18n(get_comments_number()));
			?>
		</h2>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')): // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="navigation-comment" role="navigation">
			<h1 class="assistive-text"><?php _e('Comment navigation', 'reedable'); ?></h1>
			<div class="previous"><?php previous_comments_link(__('&larr; Older Comments', 'reedable')); ?></div>
			<div class="next"><?php next_comments_link(__('Newer Comments &rarr;', 'reedable')); ?></div>
		</nav><!-- #comment-nav-before -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use reedable_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define reedable_comment() and that will be used instead.
				 * See reedable_comment() in inc/template-tags.php for more.
				 */
				wp_list_comments(array('callback' => 'reedable_comment'));
			?>
		</ol><!-- .comment-list -->

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')): // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation-comment" role="navigation">
			<h1 class="assistive-text"><?php _e('Comment navigation', 'reedable'); ?></h1>
			<div class="previous"><?php previous_comments_link(__('&larr; Older Comments', 'reedable')); ?></div>
			<div class="next"><?php next_comments_link(__('Newer Comments &rarr;', 'reedable')); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if (!comments_open() && '0' != get_comments_number() && post_type_supports(get_post_type(), 'comments')):
	?>
		<p class="no-comments"><?php _e('Comments are closed.', 'reedable'); ?></p>
	<?php endif; ?>

	<?php comment_form(array(
		'label_submit' => __('Submit Comment', 'reedable'),
		'title_reply' => 'Leave a Comment',
		'cancel_reply_link' => '&#215; Cancel',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Your message"></textarea></p>',
		'fields' => apply_filters('comment_form_default_fields', array(
			'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" value="'.esc_attr($commenter['comment_author']).'" size="30"'.($req ? ' aria-required="true" placeholder="Author name (Required)"' : ' placeholder="Author name"').' /></p>',
			'email' => '<p class="comment-form-email"><input id="email" name="email" type="text" value="'.esc_attr($commenter['comment_author_email']).'" size="30"'.($req ? ' aria-required="true" placeholder="Your email (Required, not published)"' : ' placeholder="Your email"').' /></p>',
			'url' => '<p class="comment-form-url"><input id="url" name="url" type="text" value="'.esc_attr($commenter['comment_author_url']).'" size="30" placeholder="Your website" /></p>'
		))
	)); ?>

</div><!-- #comments -->
