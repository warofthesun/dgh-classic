<?php /**/ ?><div id="comment-area">
	<h4 id="comment-header"><?php _e('Comments'); ?></h4>
	<?php if ( $comments ) { ?>
		<ol id="comment-list">
			<?php foreach ($comments as $comment) { 
				if ($comment->user_id == $post->post_author) {					
				?>
				<li id="comment-<?php comment_ID() ?>" class="author-comment clearfix">
				<?php } else { ?>
				<li id="comment-<?php comment_ID() ?>" class="clearfix">
					
					<?php
				 	} // end else  
					$defaultGravatar = get_bloginfo('template_url') . "/_img/misc/gravatar-default.jpg";
					?>
					<ul class="comment-meta">
						<li><?php echo get_avatar( $comment, $size = '75', $defaultGravatar ); ?></li>
						<li><?php comment_author_link(); ?></li>
						<li><?php comment_date('M d, Y'); ?></li>
						<li>at <?php comment_time(); ?></li>
						<li><?php edit_comment_link(__("Edit This")); ?></li>
					</ul>	
					<div class="comment-text"><?php comment_text(); ?></div>
				</li>
			<?php } ?>
		</ol>
	<?php } else { // If there are no comments yet ?>
		<p><?php _e('No comments yet.'); ?></p>
	<?php } ?>
	
	<?php if ( comments_open() ) { ?>

		<h4 id="postcomment"><?php _e('Comment on this post'); ?></h4>
		<?php if ( get_option('comment_registration') && !$user_ID ) { ?>
			<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
		<?php } else { ?>
				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">						
					<fieldset>			
		<?php if ( $user_ID ) { ?>
						<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>
						<ol id="comment-form">
					<?php } else { ?>
						<ol id="comment-form">
							<li>
								<input type="text" class="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
								<label for="author">Name <?php if ($req) _e('(required)'); ?></label>
							</li>
							<li>
								<input type="text" class="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
								<label for="email">E-Mail (will not be published) <?php if ($req) _e('(required)'); ?></label>
							</li>
							<li>
								<input type="text" class="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
								<label for="url">Website</label>
							</li>
					<?php } ?>
							<li>
								<label for="comment" class="hide">Comment</label>
								<textarea name="comment" id="comment" rows="10" cols="20" tabindex="4"></textarea>
							</li>
							<li>
								<button name="submit" class="submit" id="submit" tabindex="5" type="submit"><span>Comment</span></button>
								<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
							</li>	
						</ol>
					<?php do_action('comment_form', $post->ID); ?>
					</fieldset>
				</form>
			<?php } // If registration required and not logged in ?>

	<?php } else { // Comments are closed ?>
		<p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
	<?php } ?>

	<?php if ( !empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) { ?>
		<p><?php _e('Enter your password to view replies.'); ?></p>
		<?php return; ?>
	<?php } ?>
		<p class="extras">
		<a href="http://en.gravatar.com/" target="_blank">Get your own Gravatar.</a> 
		<?php comments_rss_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.')); ?>
		<?php if ( pings_open() ) { ?>
			<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Universal Resource Locator">URL</abbr>.'); ?></a>
		<?php } ?>
	</p>
</div>