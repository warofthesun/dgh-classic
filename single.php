<?php /**/ ?><?php
//
// This file is used only when viewing SINGLE blog posts/news item
//
?>
<?php 
	get_header(); 
?>
<div id="primary">
	<?php if (have_posts()) { ?>
		<?php while (have_posts()) { ?>
			<?php the_post(); ?>
			<h2><?php the_title(); ?></h2>
			<div class="post" id="post-<?php the_ID(); ?>">
				<?php the_content(__('(more...)')); ?>						
				<ul class="meta clearfix">
					<li>Posted: <?php echo date("M d, Y", strtotime($post->post_date)); ?></li>
					<li>Under: <?php the_category(',') ?></li>
					<li><?php comments_number(__('No Comments'),__('1 Comment'),__('% Comments'));if ( comments_open() ) { ?>: <a href="#postcomment" class="post-comment" title="<?php _e("Leave a comment"); ?>">Leave a comment</a><?php } ?></li>
					<li class="last"><?php if (function_exists('sociable_html')) {
						  echo sociable_html();
						} ?>
					</li>	
				</ul>										
				<?php comments_template(); // Get wp-comments.php template ?>
			</div>			
		<?php } ?>
	<?php } 
		  else { ?>
			<p><?php _e('Sorry, no articles matched your criteria.'); ?></p>
	<?php } ?>
		<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>
</div>
<div id="secondary">
	<?php get_sidebar(); ?>
</div>		
<?php get_footer(); ?>