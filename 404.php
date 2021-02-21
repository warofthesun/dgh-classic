<?php /**/ ?><?php header("HTTP/1.1 404 Not Found"); ?>
<?php header("Status: 404 Not Found"); ?>
<?php get_header(); ?>
<div id="primary">

	<h2>Error 404 - Not Found</h2>
	<p>Oh no! We can't seem to find that page. That bums us out.</p>
		
</div> <!-- /#primary -->
<!-- begin inline sidebar -->
<div id="secondary">
	<h3>Your Options</h3>
	<ul class="sidelist">
		<li><a href="<?php echo get_bloginfo('url'); ?>/contact/">Contact Us</a></li>
		<li><a href="<?php echo get_bloginfo('url'); ?>/">Return to the homepage</a></li>
		<li><a href="<?php echo get_bloginfo('url'); ?>/sitemap.xml">Use the sitemap</a></li>		
	</ul>
</div>
<!-- /#secondary -->						
<div class="clear"></div>
<?php get_footer(); ?>
