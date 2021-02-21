<?php /**/ ?><?php
//
// This is the HOME PAGE page of the blog.
//
?>
<?php 
	get_header(); 
?>
<div id="primary">
	<h2>News</h2>
	<?php
		//$posts = get_posts('numberposts=5&orderby=post_date');
	if (have_posts()) {
	?>
	<ul id="news">
		<?php
		while (have_posts()) { 
			the_post();
		
			$notNews = get_category_by_slug('not-news');
			$notNewsID = $notNews->term_id;
			if (in_category($notNewsID)) { continue; }
		?>
		    <li class="news-item" id="article-<?php the_ID(); ?>">						
				<h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
				<?php the_excerpt(); ?>
				<ul class="meta">
					<li><a href="<?php the_permalink() ?>" rel="bookmark" class="more">read more</a></li>
					<li>Posted: <?php echo date("M d, Y", strtotime($post->post_date)); ?></li>
					<li>Under: <?php the_category(',') ?></li>
					<li class="last"><?php comments_popup_link(__('Comments: 0'), __('Comments: 1'), __('Comments: %')); ?></li>
	    		</ul>
	    	</li>
		<?php } ?>
	</ul>
	<?php } ?>
</div>
<div id="secondary">
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>