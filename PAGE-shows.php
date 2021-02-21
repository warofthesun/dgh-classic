<?php /**/ ?><?php
/*
Template Name: PAGE: Shows
*/
//
// This file is used on pages that use a two column layout, with a right-aligned sidebar.
//
?>
<?php 
	get_header(); 
?>

<div id="primary">
	<?php if (have_posts()) { ?>
		<?php while (have_posts()) { ?>
			<?php the_post(); ?>
			<?php 
				$shows = new KCreate_Shows();					
				//global $wp_query;
				$showtime = $wp_query->query_vars['showtime'];
				
				if(is_numeric($showtime)) {
					echo "<h2>Show by year: " . $showtime . "</h2>";
					$shows->showFull("shows-table", "shows-table", $showtime, "all");
				}				
				else if ($showtime == "old") {
					echo "<h2>Old Shows</h2>";
					$shows->showFull("shows-table", "shows-table", "old", "all");
				}
				else {
					echo "<h2>Upcoming Shows</h2>";
					$shows->showFull("shows-table", "shows-table", "upcoming", "all");
				}			
			?>
	<?php } ?>
	<?php } else { ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php } ?>
</div> <!--  /#primary -->
<div id="secondary">
	<h3>Archive</h3>
	<?php 
		$shows->showYearArchive('shows-archive', 'sidelist filterlist');
	?>
</div>	
<?php get_footer(); ?>