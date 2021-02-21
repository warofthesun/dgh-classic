<?php /**/ ?><?php get_header();
	$search_excerpt = new String();
	$paginate = new Pagination();
	$trimurl = new String();	
//
// 
// Displays Empty Search form. For empty search page, see PAGE-search.php (see:
// http://codex.wordpress.org/FAQ_Advanced_Topics (Cruft free URIs)
// -- Kris H. 2/1/2008
//
?>
	<div id="interior_page">
		<ul id="nav_bread"><li class="first"><a href="<?php bloginfo('url'); ?>">Home</a></li><li class="last"><a href="<?php bloginfo('url'); ?>/search/">Search</a></li>
		</ul>
		<div id="fullpage">
			<h1 class="title">Search</h1>
			<div class="hr_dashed"></div>			
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			<?php 
				if (have_posts()) { ?>
					<h2>Search Results</h2>
						
					<?php $results_count = $wp_query->found_posts; ?>
					<p>Your search for <strong>'<?php the_search_query(); ?>'</strong> returned <?php if ($results_count == 1) { echo $results_count . ' result'; } else { echo $results_count . ' result'; } ?></p>
						
					<ol id="search_results">			
					<?php 
						$counter = 1;
						while (have_posts()){ 
							the_post(); ?>
							<li<?php if($counter % 2 != 0) echo " class=\"odd\""; ?>>
								<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
								<?php $the_text = get_the_content('');
									  $the_text = apply_filters('the_content', $the_text); ?>
								<p class="blurb"><?php echo $search_excerpt->excerpt($the_text,10); ?></p>
								<?php 
									$shortened_url = $trimurl->trimurl(get_permalink(), 50);
								?>
								<p class="uri"><a href="<?php the_permalink() ?>" rel="bookmark"><?php echo $shortened_url; ?></a></p>
							</li>
						<?php 
						$counter++;
						} // end while ?>
					</ol>
						<?php
							//$page =
							$url = parse_url($_SERVER['REQUEST_URI']);
							//print_r($url);
							list($search, $querystring) = explode("/search/", $url['path']);
							list($query, $page, $pageno) = explode("/", $querystring);
							$base_target = get_bloginfo('url'). "/search/" . $query;
  							//echo $base_target;
  							if ($pageno == ""){
  								$pageno = "1";
  							} 
  							if (is_numeric($pageno)){
  								$target = $base_target . "/page/";
								$pag = $paginate->displayPagination($pageno, $results_count, "10", "1", $target, "");
								echo $pag;
  							}
						?>					
				<?php 		
				} // end if
				else { ?>
					<div class="errors">										
						<p>Sorry, your search for <strong>'<?php the_search_query(); ?>'</strong> did not match any documents.</p>
						<p>Please check your spelling.</p>
					</div>
				<?php }
			?>
		</div>
	</div>	
<?php get_footer(); ?>