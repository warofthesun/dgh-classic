<?php /**/ ?><?php
//
// This is the DEFAULT page used for all content when no other
// template is available, and to list out multiple posts on a single page
//
?>
<?php get_header(); ?>
<div id="primary">
		<?php
			if (is_category()) {

				$page_title = "Category: " . single_cat_title('', false); 
			}
			else if(is_author()) {
				global $wp_query;
				$curauth = $wp_query->get_queried_object();		
				$page_title = "Posts by: " . $curauth->nickname;
			}
			else {
				$page_title = "Archives: ";
				if (is_day()) {
					$page_title .= get_post_time('F') . " " . get_post_time('d') . ", " . get_post_time('Y');
				}
				else if(is_month()) {
					$page_title .= get_post_time('F') . ", " . get_post_time('Y');
				}
				else if(is_year()){
					$page_title .= get_post_time('Y');
				}
				else {}
			}			

		 if (have_posts()) { ?>
			<h2><?php echo $page_title; ?></h2>
			<ul id="news">
				<?php while (have_posts()) { ?>
					<?php the_post(); 
					$notNews = get_category_by_slug('not-news');
					$notNewsID = $notNews->term_id;
					if (in_category($notNewsID)) { continue; }												
					?>
					<li class="news-item" id="post-<?php the_ID(); ?>">								
						<h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
						<?php the_excerpt(); ?>
						<ul class="meta">
							<li><a href="<?php the_permalink() ?>" rel="bookmark" class="more">read more</a></li>
							<li>Posted: <?php echo date("M d, Y", strtotime($post->post_date)); ?></li>
							<li class="last"><?php comments_popup_link(__('Comments: 0'), __('Comments: 1'), __('Comments: %')); ?></li>
			    		</ul>
					</li>
			
					<?php //comments_template(); // Get wp-comments.php template ?>
				<?php } ?>
			</ul>
			<div class="blog_navigation">
				<div class="previous"><?php next_posts_link('&larr; Previous Entries') ?></div>
				<div class="next"><?php previous_posts_link('Next Entries &rarr;') ?></div>
			</div>				
		<?php } else { ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php } ?>
</div><!-- /#primary -->
<div id="secondary">
	<?php get_sidebar(); ?>
</div>	
<?php get_footer(); ?>