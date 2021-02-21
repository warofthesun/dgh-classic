<?php /**/ ?><?php
//
// This file is used only when viewing PAGES
//
?>
<?php get_header(); 

?>
<div id="primary">
	
	<?php if (have_posts()) { ?>
		<?php while (have_posts()) { ?>
			<?php the_post(); ?>
			<h2><?php the_title(); ?></h2>
			<?php the_content(__('(more...)')); ?>
			<?php $KCreate_Static->content(0); ?>
			<?php $KCreate_Static->content(1); ?>
			<div class="clear"></div>
		<?php } ?>
	<?php } else { ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php } ?>
</div>
<div id="secondary">
	<?php get_sidebar(); ?>
</div>	
<?php get_footer(); ?>
	