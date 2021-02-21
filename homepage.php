<?php /**/ ?><?php
/*
Template Name: HOME
*/
?>
<?php 
	get_header();
	$photo = new PostImage();
	$pageID = $post->ID; 
?>
		<div id="primary" class="home">
			<div id="billboard">
				<div id="fpo">
					<img src="<?php bloginfo("url"); ?>/wp-content/uploads/kcreate-viewer/img/sirs.jpg" alt="" title="" />
				</div>
				<script type="text/javascript">
				 		// <![CDATA[
				 		var settings = {
							path: window.rootVirtual + "/_swf/viewer.swf",
							width: "530",
							height: "250",
							version: "9.0.0",
							id: "fpo", // flash replace id
							expressInstall: false
						};
						var flashvars = {
							xmlPath: window.rootVirtual + "/_xml/data.xml"
						};
						var params = {
						};
						var attributes = {
						};
						// swfobject.embedSWF(swfUrl, id, width, height, version, expressInstallSwfurl, flashvars, params, attributes)
						// swfobject.embedSWF(settings.path, settings.id, settings.width, settings.height, settings.version, settings.expressInstall, flashvars, params, attributes);
						// ]]>
				</script>				
			</div>
			<h2>News</h2>
				<?php
				$notNews = get_category_by_slug('not-news');
				$notNewsID = $notNews->term_id;				
				$latest = get_posts("numberposts=3&orderby=date&category=-$notNewsID");
				if (count($latest) > 0) {
				?>
					<ul id="news">
						<?php
						foreach($latest as $post) {
							setup_postdata($post);							
						?>
						    <li class="news-item" id="article-<?php the_ID(); ?>">						
								<h4><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>
								<?php the_excerpt(); ?>
								<ul class="meta">
									<li><a href="<?php the_permalink() ?>" rel="bookmark" class="more">read more</a></li>
									<li>Posted: <?php echo date("M d, Y", strtotime($post->post_date)); ?></li>
									<li class="last">Under: <?php the_category(',') ?></li>
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
		<div id="secondary" class="home">
			<?php 
				// get cta
				$caption = $photo->read_caption("medium", $pageID);
				$img = $photo->read("medium", $pageID);
				$link = $photo->read_link("medium", $pageID);
				$display = ($link == "") ? sprintf("<img src=\"%s\" alt=\"%s\" title=\"\" />", $img, $caption) : sprintf("<a href=\"%s\"><img src=\"%s\" alt=\"%s\" /></a>", $link, $img, $caption);
			?>
			<h3><?php echo $caption; ?></h3>
			
			<div id="home-cta">
				<?php
					//$photo->get("medium", $pageID);
					echo $display;
				?>
			</div>
			
			<h3>Shows</h3>
			<?php
				
				$shows = new KCreate_Shows();
				$shows->showMini("shows", "", "upcoming", 5);
												
			?>
		</div>
<?php get_footer(); ?>