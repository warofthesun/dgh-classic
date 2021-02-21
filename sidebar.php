<?php /**/ ?><!-- begin sidebar -->
<?php
	// List out sub pages for the current category
	$KC_Navigation = new KC_Navigation();	
	if (is_page()) {
		$photo = new PostImage();
		$releases =	($KC_Navigation->isRoot('releases')) ? 'on' : 'off';
		$other = ($KC_Navigation->isRoot('other-releases')) ? 'on' : 'off';
		if ($releases == 'on' || $other == 'on') {
			echo "<h3>Discography</h3>";
			echo "<h5>DGH Albums</h5>";
			echo "<ul class=\"sidelist discography\">";
			//wp_list_pages('title_li=&depth=1&child_of=' . get_page_by_path($KC_Navigation->root(), true)->ID);
			//$parent = get_page_by_path($KC_Navigation->root());
			$parent = get_page_by_path('releases');
			//$parent = get_page_by_path
			$parentID = $parent->ID; // php4 solution 
			$children = $wpdb->get_results("SELECT * from $wpdb->posts WHERE post_type='page' AND post_parent=$parentID ORDER BY menu_order asc, post_title asc");
			for ($i = 0; $i < sizeof($children); $i++) {
				$thumbformat = '<img src="%s" alt="' . get_the_title($children[$i]->ID) .  '" title="' . get_the_title($children[$i]->ID) .  '" />';
				echo '<li><a href="' . get_permalink($children[$i]->ID) . '">';
				$photoreturn = $photo->get("small", $children[$i]->ID, $thumbformat);
				if (!$photoreturn) {
					echo "<img src=\"";
					bloginfo('template_url');
					echo "/_img/misc/no-image-small.jpg\" alt=\"" . get_the_title($children[$i]->ID) . "\" title=\"" . get_the_title($children[$i]->ID) . "\" />";
				}
				echo "</a></li>";	
			}
			echo "</ul>";
			echo "<h5>Other Projects</h5>";
			echo "<ul class=\"sidelist discography\">";
			//wp_list_pages('title_li=&depth=1&child_of=' . get_page_by_path($KC_Navigation->root(), true)->ID);
			//$parent = get_page_by_path($KC_Navigation->root());
			$parent = get_page_by_path('other-releases');
			//$parent = get_page_by_path
			$parentID = $parent->ID; // php4 solution 
			$children = $wpdb->get_results("SELECT * from $wpdb->posts WHERE post_type='page' AND post_parent=$parentID ORDER BY menu_order asc, post_title asc");
			for ($i = 0; $i < sizeof($children); $i++) {
				$thumbformat = '<img src="%s" alt="' . get_the_title($children[$i]->ID) .  '" title="' . get_the_title($children[$i]->ID) .  '" />';
				echo '<li><a href="' . get_permalink($children[$i]->ID) . '">';
				$photoreturn = $photo->get("small", $children[$i]->ID, $thumbformat);
				if (!$photoreturn) {
					echo "<img src=\"";
					bloginfo('template_url');
					echo "/_img/misc/no-image-small.jpg\" alt=\"" . get_the_title($children[$i]->ID) . "\" title=\"" . get_the_title($children[$i]->ID) . "\" />";
				}
				echo "</a></li>";	
			}
			echo "</ul>";									
		}
		
		$bio = ($KC_Navigation->isRoot('bio')) ? 'on' : 'off';
		if ($bio == 'on') {
					
			echo "<h3>Band Members</h3>";
			echo "<ul class=\"sidelist bio\">";
			$parent = get_page_by_path($KC_Navigation->root());
			$parentID = $parent->ID; // php4 solution 
			$children = $wpdb->get_results("SELECT * from $wpdb->posts WHERE post_type='page' AND post_parent=$parentID ORDER BY menu_order asc, post_title asc");
			for ($i = 0; $i < sizeof($children); $i++) {
				$thumbformat = '<img src="%s" alt="' . get_the_title($children[$i]->ID) .  '" title="' . get_the_title($children[$i]->ID) .  '" />';
				echo '<li><a href="' . get_permalink($children[$i]->ID) . '">';
				$photoreturn = $photo->get("small", $children[$i]->ID, $thumbformat);
				if (!$photoreturn) {
					echo "<img src=\"";
					bloginfo('template_url');
					echo "/_img/noimage_team_thumb.jpg\" alt=\"$alttext\" title=\"$alttext\" />";
				}
				echo "</a></li>";	
			}
			echo "</ul>";					
		}

		$press = ($KC_Navigation->isRoot('press')) ? 'on' : 'off';
		if ($press == 'on') {
			echo "<h3>Archive</h3>";
			echo "<ul class=\"sidelist filterlist\">";
			$output = "";
			$slugs = get_category_by_slug('press');
			
			$pressID = $slugs->term_id;
			// get all posts in the press categories
			$includes = query_posts("cat=$pressID&showposts=-1");
			$include = array();
			for ($i = 0; $i < count($includes); $i++) {
				$include[] = $includes[$i]->ID;
			}
			$includeList = implode(", ", $include);
			$where = "WHERE post_type = 'post' AND post_status = 'publish' AND ID IN ($includeList)";	
			$query = "SELECT DISTINCT YEAR(post_date) AS 'year', ID, count(ID) as posts FROM $wpdb->posts $where GROUP BY YEAR(post_date) ORDER BY post_date ASC";
			$results = $wpdb->get_results($query);
			$pressPath = get_bloginfo('url') . "/press/";
			foreach ((array) $results as $result) {
				$output .= sprintf("<li><a href=\"$pressPath?t=%d\">%d</a></li>", $result->year, $result->year);
			}
			$output .= "<li class=\"last\"><a href=\"$pressPath\">See all</a></li>";
			echo $output;
	
			echo "</ul>";
		}
		
		$links = ($KC_Navigation->isRoot('links')) ? 'on' : 'off';
		if ($links == 'on') {
			echo "<h3>RSS Feeds</h3>";
			echo "<ul class=\"sidelist\">";
			echo "<li><a href=\"";
			bloginfo('rss2_url');
			echo "\">News <abbr title=\"Really Simple Syndication\">RSS</abbr></a></li>";
			echo "<li><a href=\"";
			echo get_bloginfo('url') . "/feed/shows/";
			echo "\">Shows <abbr title=\"Really Simple Syndication\">RSS</abbr></a></li>";			
			echo "<li><a href=\"";
			bloginfo('comments_rss2_url');
			echo "\">Comments <abbr title=\"Really Simple Syndication\">RSS</abbr></a></li>";
			echo "<li><a href=\"http://api.flickr.com/services/feeds/photos_public.gne?id=33846123@N06&lang=en-us&format=rss_200\">Flickr <abbr title=\"Really Simple Syndication\">RSS</abbr></a></li>";			
			echo "</ul>";
			echo "<h5>What's RSS?</h5>";
			echo "<p>\"Really Simple Syndication (RSS) is a family of Web feed formats used to publish frequently updated works ... in a standardized format.\" <a href=\"http://en.wikipedia.org/wiki/RSS_(file_format)\" target=\"_blank\">Read more at Wikipedia</a></p>";
		}

		$contact = ($KC_Navigation->isRoot('contact')) ? 'on' : 'off';
		if ($contact == 'on') {
			echo "<h3>Related Links</h3>";
			echo "<ul class=\"sidelist\">";
			wp_list_bookmarks('category_name=Related&title_li=0&categorize=0&title_before=&title_after=&category_before=&category_after=');			
			echo "</ul>";
		}			
		
	}
	// only list categories / top stories if we're NOT on a page (but in the news / article area)
	else {
		
		$notNews = get_category_by_slug('not-news');
		$notNewsID = $notNews->term_id;
		$recent_stories = get_posts("numberposts=5&category=-$notNewsID");
		echo "<div class=\"news_items_alt\">";
		echo "<h3>Archive</h3>";
		echo "<h5>Latest</h5>";
		echo "<ul class=\"sidelist\">";
		foreach ($recent_stories as $post) { 
			?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
		<?php	
		}				
		echo "</ul>";				
		echo "</div>";
		
		echo "<h5>By Month:</h5>";
		echo "<ul class=\"sidelist\">";
		$output = "";
		$slugs = get_category_by_slug('not-news');
		
		$notNewsID = $slugs->term_id;
		// get all posts, minus the exluded categories
		$excludes = query_posts("cat=$notNewsID&showposts=-1");
		$exclude = array();
		for ($i = 0; $i < count($excludes); $i++) {
			$exclude[] = $excludes[$i]->ID;
		}
		$excludeList = implode(", ", $exclude);
		$where = "WHERE post_type = 'post' AND post_status = 'publish' AND ID NOT IN ($excludeList)";	
		$query = "SELECT DISTINCT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, ID, count(ID) as posts FROM $wpdb->posts $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
		$results = $wpdb->get_results($query);
		global $wp_locale;

		foreach ((array) $results as $result) {
			$url = get_month_link( $result->year, $result->month );
			$text = sprintf('%1$s %2$d', $wp_locale->get_month($result->month), $result->year);
			$output .= get_archives_link($url, $text);
		}
		echo $output;
		echo "</ul>";
		
		echo "<h5>By Category</h5>";
		echo "<ul class=\"sidelist\">";
			$notNews = get_category_by_slug('not-news');
			$notNewsID = $notNews->term_id;		
			wp_list_categories("&title_li=&exclude=$notNewsID");
		echo "</ul>";	
	}
?>
<!-- end sidebar -->