<?php /**/ ?><?php
/*
Template Name: PAGE: Releases: Detail
*/
//
// This file is used only on the RELEASES detail pages
//
?>
<?php get_header(); ?>
<div id="primary">
	<?php the_post(); ?>

	<h2>Releases</h2>
	<div id="release-photo">
		<?php	
		$photo = new PostImage();
		$imageformat = '<img src="%s" alt="'. get_the_title() . '" />';
		if ($photo->read("medium", $post->ID) != "") {
			$photo->get("medium", $post->ID, $imageformat);
		}
		else {
			echo "<img src=\"" . get_bloginfo('template_url') . "/_img/misc/no-image-medium.jpg\" alt=\"Apologetic image\" />";  
		}
		?>
	</div>
	<ul id="release-details">
		<li>
			<span class="legend">Title</span>
			<h5><?php the_title(); ?></h5>
			<div class="clear"></div>
		</li>
		<?php
		$release = get_post_meta($post->ID, "release-date", false);
		if ($release) {
			echo "<li><span class=\"legend\">Release Date</span>";
			echo "<ul class=\"release-date\">";
			for ($i = 0; $i < count($release); $i++) {
				echo "<li>" . $release[$i] . "</li>";	
			}
			echo "</ul>";
			echo "<div class=\"clear\"></div>";
			echo "</li>";
		}
		
		$buy = get_post_meta($post->ID, "buy-online", false);	
		if ($buy) {
			sort($buy);
			echo "<li class=\"last\">";
			echo "<span class=\"legend\">Buy Online</span>";
			echo "<ul class=\"release-buy\">";
			for ($i = 0; $i < count($buy); $i++) {
				list($store, $link) = explode("|", $buy[$i]);
				if ($i % 2 == 0) {
					echo "<li class=\"even\">";
				}
				else {
					echo "<li>";
				}
				$link = htmlentities($link);
				echo "<a href=\"$link\" target=\"_blank\">$store</a></li>";	
			}
			echo "</ul>";
			echo "<div class=\"clear\"></div>";
			echo "</li>";
		}
		?>
	</ul>
	<div class="clear"></div>
<?php
$tracks = get_post_meta($post->ID, "track", false);
if ($tracks) {
	sort($tracks);
	echo "<table class=\"release-table\" summary=\"information about " . get_the_title() .  "\">";
	echo "<tr>";
	echo "<th id=\"track\" scope=\"col\">Track</th>";
	echo "<th id=\"title\" scope=\"col\">Title</th>";
	echo "<th id=\"media\" scope=\"col\">Media</th>";
	echo "<th id=\"lyrics\" scope=\"col\">Lyrics</th>";
	echo "</tr>";
		
	for ($i = 0; $i < count($tracks); $i++) {
		list($no, $title, $lyrics, $media) = explode("|", $tracks[$i]);
		//$tr = ($i % 2 == 0) ? "<tr class=\"odd\">" : "<tr>";
		//echo $tr;
		echo "<tr>";
		echo "<td>$no</td>";
		echo "<td>" . stripslashes($title) . "</td>";
		$media = eregi_replace("media:", "",  $media);
		$mediaPath = pathinfo($media);
		if ($media != "") {
			echo "<td><a href=\"$media\">" .  $mediaPath['extension'] . "</a></td>";
		}
		else {
			echo "<td>$media</td>";
		}	
		$lyrics = eregi_replace("lyrics:", "",  $lyrics);
		/* test end test */
		if ($lyrics != "") {	
			echo "<td><span class=\"lyrics-available\"></span></td>";
			echo "</tr>";
			echo "<tr class=\"lyrics-row\">";
			echo "<td colspan=\"4\" class=\"lyrics\">";
			$ch = curl_init();
			$timeout = 5; // set to zero for no timeout
			curl_setopt ($ch, CURLOPT_URL, $lyrics);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);
			
			// display file
			echo "<div>";
			// for future reference
			/*		
			function br2p($string)
			{
			  return preg_replace('#<p>[\n\r\s]*?</p>#m', '', '<p>'.preg_replace('#(<br\s*?/?>){2,}#m', '</p><p>', $string).'</p>');
			}
			*/
			$file_contents = str_replace("\n\n", "</p><p>", $file_contents);
			echo "<p>" . $file_contents . "</p>";
			echo "</div>";
			echo "</td>";
		}
		else {
			echo "<td>&nbsp;</td>";
		}
	
		echo "</tr>";
	}
	
	echo "</table>";
	echo "<h5>About ";
	the_title();
	echo "</h5>";
}
?>	
	<?php the_content(__('(more...)')); ?>

</div>
<div id="secondary">
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>