<div class="meta">
	<p class="publish-date"><?php _e('Published', 'sceleton'); ?> <time datetime="<?php echo date(DATE_W3C); ?>" pubdate><?php the_time(); ?></time></p>
	<p class="categories"><?php echo get_the_category_list(', '); ?></p>
	<?php if(comments_open()): ?><p class="comment-links"><?php comments_popup_link('No Comments', '1 Comment', '% Comments', 'comments-link', ''); ?></p><?php endif; ?>
</div>