<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) {
	_e('This post is password protected. Enter the password to view comments.', 'sceleton');
	return;
}

if ( have_comments() ) : ?>
	
	<h2 id="comments"><?php comments_number(__('No comments', 'sceleton'), __('One comment', 'sceleton'), __('% comments', 'sceleton') );?></h2>

	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link() ?></div>
		<div class="prev-posts"><?php next_comments_link() ?></div>
	</div>
	
<?php endif; ?>

<?php if ( comments_open() ) : ?>

	<div id="respond">
	
		<h2><?php comment_form_title( __('Leave a Reply', 'sceleton'), __('Leave a Reply to %s', 'sceleton') ); ?></h2>
	
		<div class="cancel-comment-reply">
			<?php cancel_comment_reply_link(); ?>
		</div>
	
		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		
			<p><?php echo __('You must be', 'sceleton') . '<a href="' . wp_login_url( get_permalink() ) . '">' . __('logged in', 'sceleton') . '</a> ' . __('to post a comment', 'sceleton') . '</p>'; ?>
			
		<?php else : ?>
	
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		
				<?php if ( is_user_logged_in() ) : ?>
		
					<p><?php _e('Logged in as', 'sceleton'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php echo __('Log out of this account', 'sceleton'); ?>"><?php _e('Log out', 'sceleton'); ?></a></p>
		
				<?php else : ?>
					<div class="commentform-item">
						<label for="author"><?php _e('Your Name', 'sceleton'); if ($req) echo "(required)"; ?></label>
						<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
					</div>
		
					<div class="commentform-item">
						<label for="email"><?php _e('Your email (will not be published)', 'sceleton'); if ($req) echo "(required)"; ?></label>
						<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
					</div>
					
				<?php endif; ?>
				
				<div>
					<label for="comment"><?php _e('Your comment', 'sceleton'); ?></label>
					<textarea name="comment" id="comment" cols="58" rows="10" tabindex="3"></textarea>
				</div>
		
				<div>
					<input name="submit" type="submit" id="submit" class="button" tabindex="4" value="<?php echo __('Submit Comment', 'sceleton'); ?>" />
					<?php comment_id_fields(); ?>
				</div>
				
				<?php do_action('comment_form', $post->ID); ?>
		
			</form>
	
		<?php endif; // If registration required and not logged in ?>
		
	</div>

<?php endif; ?>
