<?php /**/ ?><?php
/*
Template Name: PAGE: Photos
*/
//
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
				
				
				$flickr = new Flickr('9064ac7ccb394c87ced8b9a9871762b6', 'ff50fcaecdf1279e');
				$pagination = new Pagination();
				
				if ($_REQUEST['type'] == 'detail') {
					$id = $_REQUEST['id'];
					$detail = $flickr->call_method('flickr.photos.getInfo', array(
						'auth_token' => $auth_token,
						'photo_id' => $id
					));
					$title = $detail['photo']['title']['_content'];
					echo "<h2>$title</h2>";
					echo "<div class=\"post\">";
					$src = 'http://farm' . $detail['photo']['farm'] . '.static.flickr.com/' . $detail['photo']['server'] . '/'. $detail['photo']['id'] . '_' . $detail['photo']['secret'] . '.jpg';
					echo "<p><img src=\"$src\" alt=\"$title\" /></p>";
					
					$desc = $detail['photo']['description']['_content'];
					if($desc != '') {
						echo "<p>$desc</p>";
					}
					echo "<ul class=\"meta clearfix\">";
					echo "<li>Posted: " . date('F d, Y', $detail['photo']['dates']['posted']) . "</li>";
					
					$no_tags = sizeof($detail['photo']['tags']);
					echo "<li>Tags: ";
					for ($i = 0; $i < $no_tags; $i++) {
						echo $detail['photo']['tags']['tag'][$i]['_content'];
					}
					echo "</li>";
					echo "<li class=\"last\"><a href=\"";
					$flickrUrl = $detail['photo']['urls']['url'][0]['_content'];
					echo $flickrUrl;
					echo "\" class=\"flickr-lnk\">View on Flickr</a></li>";
					echo "</ul>";
					echo "<div id=\"comment-area\">";
					echo "<h4 id=\"comment-header\">Comments</h4>";
					$comments = $flickr->call_method('flickr.photos.comments.getList', array(
						'auth_token' => $auth_token,
						'photo_id' => $id
					));
					$no_comments = sizeof($comments['comments']['comment']);
					if ($no_comments > 0) {
						echo "<ol id=\"comment-list\">";
					
						for ($i = 0; $i < $no_comments; $i++) {
							echo "<li class=\"clearfix\">";
							echo "<ul class=\"comment-meta\">";
							
							$author = $comments['comments']['comment'][$i]['author'];
							$authorInfo = $flickr->call_method('flickr.people.getInfo', array(
								'auth_token' => $auth_token,
								'user_id' => $author
							));
							echo "<li>";
							$src = "http://farm" . $authorInfo['person']['iconfarm'] . ".static.flickr.com/" . $authorInfo['person']['iconserver'] . "/buddyicons/" . $authorInfo['person']['nsid'] . ".jpg";
							$authorName =  $authorInfo['person']['username']['_content'];
							echo "<img src=\"$src\" alt=\"$authorName\" class=\"avatar\" />";
							echo "</li>";
							echo "<li>";
							echo "<a href=\"" . $authorInfo['person']['photosurl']['_content'] . "\" rel=\"external\">";
							echo $authorName;
							echo "</a>";
							echo "</li>";							
							echo "<li>";
							echo date('M d, Y', $comments['comments']['comment'][$i]['datecreate']);
							echo "</li>";
							echo "<li>at ";
							echo date('g:i a', $comments['comments']['comment'][$i]['datecreate']);
							echo "</li>";							
							echo "</ul>";
							echo "<div class=\"comment-text\">";
							echo $comments['comments']['comment'][$i]['_content'];
							echo "</div>";
							echo "</li>";
						}
					
						echo "</ol>";
					}
					else {
						echo "<p>No comments yet.</p>";
					}
					echo "<h4 id=\"postcomment\">Comment on this photo</h4>";
					echo "<p><a href=\"$flickrUrl\">View this photo on Flickr to comment on it</a></p>";
					echo "<div class=\"clear\"></div>";
					echo "</div>";			
					echo "</div>";
				}
				
				else if ($_REQUEST['type'] == 'set') {
					$setid = $_REQUEST['setid'];
					$page = (is_numeric($_REQUEST['page'])) ? (int)$_REQUEST['page'] : 1;
					
					$setInfo = $flickr->call_method('flickr.photosets.getInfo', array(
		                'photoset_id' => $setid
	        		));
					
					$set = $flickr->call_method('flickr.photosets.getPhotos', array(
		                'photoset_id' => $setid,
						'per_page' => 10,
						'page' => $page
	        		));
	        		
	        		$total = $set['photoset']['total'];
	        		echo "<h2>" . $setInfo['photoset']['title']['_content'] . "</h2>";

	        		echo "<ul id=\"photostream\">";
	        		$counter = 0;
					foreach($set['photoset']['photo'] as $photo) {
						$src = 'http://farm' . $photo['farm'] . '.static.flickr.com/' . $photo['server'] . '/'. $photo['id'] . '_' . $photo['secret'] . '_m.jpg';
						$lnk = get_bloginfo('url').'/photos/?type=detail&amp;id='.$photo['id'];
						$title = $photo['title'];
						if($counter % 2 == 0) {
							echo "<li class=\"alternate-row\">";
						}
						else {
							echo "<li>";
						}
						echo "<h5><a href=\"$lnk\">$title</a></h5>";
						echo "<div class=\"photo\"><a href=\"$lnk\"><img src=\"$src\" alt=\"$title\" title=\"$title\" /></a></div>";
						$details = $flickr->call_method('flickr.photos.getInfo', array(
							'auth_token' => $auth_token,
							'photo_id' => $photo['id']
						));
						echo "<ul class=\"meta\"><li><a href=\"$lnk\" class=\"more\">details</a></li><li>Posted: " . date('F d, Y', $details['photo']['dates']['posted']) . "</li></ul>";
						echo "</li>";
						$counter++;
					}
	        		echo "</ul>";
	
	        		echo $pagination->displayPagination($page, $total, 10, 1, get_bloginfo('url'), "/photos/?type=set&setid=$setid&page=");
				}
				
				else {
				
					$page = (is_numeric($_REQUEST['page'])) ? (int)$_REQUEST['page'] : 1;
					$latest = $flickr->call_method('flickr.people.getPublicPhotos', array(
		                'auth_token' => $auth_token,
		                'user_id' => '33846123@N06',
						'per_page' => 10,
						'page' => $page
	        		));
	        		
	        		$total = $latest['photos']['total'];
	        		echo "<h2>Photos</h2>";
	        		echo "<ul id=\"photostream\">";
	        		$counter = 0;
					foreach($latest['photos']['photo'] as $photo) {
						$src = 'http://farm' . $photo['farm'] . '.static.flickr.com/' . $photo['server'] . '/'. $photo['id'] . '_' . $photo['secret'] . '_m.jpg';
						$lnk = get_bloginfo('url').'/photos/?type=detail&amp;id='.$photo['id'];
						$title = $photo['title'];
						if($counter % 2 == 0) {
							echo "<li class=\"alternate-row\">";
						}
						else {
							echo "<li>";
						}
						echo "<h5><a href=\"$lnk\">$title</a></h5>";
						echo "<div class=\"photo\"><a href=\"$lnk\"><img src=\"$src\" alt=\"$title\" title=\"$title\" /></a></div>";
						$details = $flickr->call_method('flickr.photos.getInfo', array(
							'auth_token' => $auth_token,
							'photo_id' => $photo['id']
						));
						echo "<ul class=\"meta\"><li><a href=\"$lnk\" class=\"more\">details</a></li><li class=\"last\">Posted: " . date('F d, Y', $details['photo']['dates']['posted']) . "</li></ul>";
						echo "</li>";
						$counter++;
					}
	        		echo "</ul>";
	
	        		echo $pagination->displayPagination($page, $total, 10, 1, get_bloginfo('url'), "/photos/?page=");
				}
					
			?>
	<?php } ?>
	<?php } else { ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php } ?>
</div> <!--  /#primary -->
<div id="secondary">
	<h3>Sets</h3>
	
	<?php
		$sets = $flickr->call_method('flickr.photosets.getList', array(
	                'auth_token' => $auth_token,
	                'user_id' => '33846123@N06'
        		));

		$no_sets = sizeof($sets['photosets']['photoset']);
		echo "<ul class=\"sidelist photo-sets\">";
        for ($i = 0; $i < $no_sets; $i++) {
        	$title = $sets['photosets']['photoset'][$i]['title']['_content'];
        	$set = $sets['photosets']['photoset'][$i];
        	$x = 'http://farm' . $set['farm'] . '.static.flickr.com/' . $set['server'] . '/'. $set['primary'] . '_' . $set['secret'] . '_s.jpg';
        	echo "<li><a href=\"" . get_bloginfo('url') . "/photos/?type=set&setid=" . $set['id'] . "\"><img src=\"$x\" alt=\"$title\" title=\"$title\" /></a></li>";
        }		
		echo "</ul>";
	?>
	
</div>	
<?php get_footer(); ?>