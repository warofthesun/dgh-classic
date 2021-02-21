<?php /**/ ?><?php
/*
Template Name: PAGE: Press Home
*/
//
// This file is used only on the PRESS home page
//
?>
<?php get_header(); ?>
<div id="primary">
	<?php
	$press = get_category_by_slug('press');
	$pressID = $press->term_id;
	$year = (is_numeric($_REQUEST['t'])) ? $_REQUEST['t'] : "";
	if ($year != "") {
		$title = " By year: $year";
	}
	$releases = get_posts("year=$year&numberposts=-1&orderby=date&category=$pressID");
	if (count($releases) > 0) {
	?>
		<h2><?php the_title(); echo $title; ?></h2>
		<ul id="news">
			<?php
			foreach($releases as $post) {
				setup_postdata($post);
						
			?>
			    <li class="news-item" id="article-<?php the_ID(); ?>">						
					<h4><?php the_title(); ?></h4>
					<div class="press-release">
						<?php the_content(); ?>
					</div>	
					<ul class="meta">
						<li><a href="#" class="open-close more">[+] Read more</a></li>
						<li class="last">Posted: <?php echo date("M d, Y", strtotime($post->post_date)); ?></li>
		    		</ul>
		    	</li>
			<?php 
			}  
			?>
		</ul>
	<?php 
	}
	?>
</div>
<div id="secondary">
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>