<?php /**/ ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<?php/*
		$KC_Navigation = new KC_Navigation();
		$home = 		(is_front_page()) ? 'on' : 'off';
		$shows =		($KC_Navigation->isRoot('shows')) ? 'on' : 'off';
		$bio =			($KC_Navigation->isRoot('bio')) ? 'on' : 'off';
		$releases =		($KC_Navigation->isRoot('releases') || $KC_Navigation->isRoot('other-releases')) ? 'on' : 'off';
		$contact =		($KC_Navigation->isRoot('contact')) ? 'on' : 'off';
		$photos =		($KC_Navigation->isRoot('photos')) ? 'on' : 'off';
		$links =		($KC_Navigation->isRoot('links')) ? 'on' : 'off';
		$press =		($KC_Navigation->isRoot('press')) ? 'on' : 'off';					
		$news =			($KC_Navigation->isRoot('news') ||
						 $KC_Navigation->isRoot('category') || // when in category view
						 is_numeric($KC_Navigation->root())	// when in post view
						) ? 'on' : 'off';										
		*/?>

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->
	<meta http-equiv="imagetoolbar" content="false" />
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta name="MSSmartTagsPreventParsing" content="true" />
	<meta name="description" content="Hello Tower: Website for Daniel G. Harmann and the Trouble Starts" />
	<meta name="keywords" content="Harmann, Daniel, Dan, Trouble, Starts, music, Seattle, burning building recordindgs, Seattle, hello, tower" />	
	<meta name="verify-v1" content="zGGMWyxTPE4jSrnwv+k/5IAqHwwSAA1KzUrnOlw+yIM=" />
	<title><?php bloginfo('name'); ?><?php wp_title("|"); ?></title>
	<script type="text/javascript">
	//<![CDATA[
    	rootVirtual = '<?php bloginfo('template_url'); ?>';
	//]]>
	</script>
	<script src="http://www.google.com/jsapi" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		google.load("prototype", "1.6");
		google.load("scriptaculous", "1.8.2");
		<?php if ($home == "on") { ?>
		google.load("swfobject", "2.1");		
		<?php } ?>						
	</script>
	<?php if ($releases == "on") { ?>
	<?php	
	/*
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/_inc/js/lib/soundmanager2.js"></script>
	<script type="text/javascript">
	soundManager.debugMode = false;
	soundManager.url = rootVirtual + '/_swf/'; 
	soundManager.onready(function(oStatus) {
	  // check if SM2 successfully loaded..
	  if (oStatus.success) {
	    // SM2 has loaded - now you can create and play sounds!
		var candy = $$('a[href$=".mp3"]');
		var playme = candy[0].readAttribute('href');
	    var mySound = soundManager.createSound({
	      id: 'aSound',
	      url: playme
	    });
	    //mySound.play();
	  }
	});

	</script>
	*/
	?>	
			
	<?php } ?>
	<link rel="shortcut icon" href="<?php bloginfo("template_url"); ?>/_img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/_inc/css/main.css" />
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/_inc/js/lib/sifr.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/_inc/js/sifr-config.js"></script>	
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/_inc/js/main.js"></script>
	<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/_inc/css/ie7.css" />
	<![endif]-->
	<!--[if lte IE 6]>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/_inc/css/ie6.css" />
	<![endif]-->
	<link rel="alternate" type="application/rss+xml" title="News RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="Shows RSS 2.0" href="<?php echo get_bloginfo('url') . "/feed/shows/"; ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php wp_head(); ?>
</head>
<body>
	<h1><?php bloginfo('name'); ?></h1>
	<!-- begin skip links -->
	<ul class="nav-sr">
	  <li><a id="top" title="Skip to content" href="#content">Skip to content</a></li>
	  <li><a title="Skip to navigation" href="#nav">Skip to navigation</a></li>
	  <li><a title="Skip to footer" href="#footer">Skip to footer</a></li>
	</ul>
	<!-- end skip links -->
	
	<!-- begin page -->
	<div id="page">		
		<div id="masthead">
			
			<p id="logo"><a href="<?php bloginfo('url')?>"><span><?php bloginfo('name'); ?> | Home</span></a></p>			
			
			<ul id="nav">
				<li id="li_home" class="<?php echo $home; ?>"><a href="<?php bloginfo('url')?>/"><span>Home</span></a></li>
				<li id="li_news" class="<?php echo $news; ?>"><a href="<?php bloginfo('url')?>/news/"><span>News</span></a></li>
				<li id="li_shows" class="<?php echo $shows; ?>"><a href="<?php bloginfo('url')?>/shows/"><span>Shows</span></a></li>	
				<li id="li_releases" class="<?php echo $releases; ?>"><a href="<?php bloginfo('url')?>/releases/"><span>Releases</span></a></li>
				<li id="li_bio" class="<?php echo $bio; ?>"><a href="<?php bloginfo('url')?>/bio/"><span>Bio</span></a></li>	
				<li id="li_photos" class="<?php echo $photos; ?>"><a href="<?php bloginfo('url')?>/photos/"><span>Photos</span></a></li>
				<li id="li_press" class="<?php echo $press; ?>"><a href="<?php bloginfo('url')?>/press/"><span>Press</span></a></li>	
				<li id="li_links" class="<?php echo $links; ?>"><a href="<?php bloginfo('url')?>/links/"><span>Links</span></a></li>
				<li id="li_contact" class="<?php echo $contact; ?>"><a href="<?php bloginfo('url')?>/contact/"><span>Contact</span></a></li>				
			</ul>
		</div>
		<div id="content" class="clearfix">