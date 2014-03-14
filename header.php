<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 * We filter the output of wp_title() a bit -- see
	 * twentyten_filter_wp_title() in functions.php.
	 */
	wp_title( '|', true, 'right' );

	?></title>
<link rel="shortcut icon" href="<?php bloginfo( 'template_directory' ); ?>/favicon.ico" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/_css/styles.css">
<!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_directory' ); ?>/_css/ie.css" />
	<script src="<?php bloginfo( 'template_directory' ); ?>/_js/libs/respond.min.js"></script>
<![endif]-->
<!--[if gt IE 8]>
	<link rel="stylesheet" media="all" type="text/css" href="<?php bloginfo( 'template_directory' ); ?>/_css/ie+.css" />
<![endif]-->
<script src="<?php bloginfo( 'template_directory' ); ?>/_js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script>

<!--TYPEKIT-->
<script type="text/javascript" src="http://use.typekit.com/jdf6wuh.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<?php
/* Get the Page Slug to Use as a Body Class, this will only return a value on pages! */
$class = '';
/* is it a page */
if( is_page() ) { 
	global $post;
        /* Get an array of Ancestors and Parents if they exist */
	$parents = get_post_ancestors( $post->ID );
        /* Get the top Level page->ID count base 1, array base 0 so -1 */ 
	$id = ($parents) ? $parents[count($parents)-1]: $post->ID;
	/* Get the parent and set the $class with the page slug (post_name) */
        $parent = get_page( $id );
	$class = $parent->post_name;
}
?>
<body <?php body_class( $class ); ?>>
<!-- Google Code for Phone Call Conversion Page -->
<script type="text/javascript">
 /* <![CDATA[ */
 goog_snippet_vars = function() {
   var w = window;
   w.google_conversion_id = 1064381838;
   w.google_conversion_label = "isxGCJaA_gMQjtvE-wM";
   w.google_conversion_value = 0;
 }
 // DO NOT CHANGE THE CODE BELOW.
 goog_report_conversion = function(url) {
   goog_snippet_vars();
   window.google_conversion_format = "3";
   window.google_is_call = true;
   var opt = new Object();
   opt.onload_callback = function() {
   if (typeof(url) != 'undefined') {
     window.location = url;
   }
 }
 var conv_handler = window['google_trackConversion'];
 if (typeof(conv_handler) == 'function') {
   conv_handler(opt);
 }
}
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion_async.js"></script>
	<header>
		<div class="full-width clearfix colorbar">
			<div id="header-container" class="container">
				<div id="mobile-header">
					<b>Contact Us</b> - <a onclick="goog_report_conversion('tel:1-877-242-1880')" href="tel:1-877-242-1880" >1.877.242.1880</a>
				</div>
	    		<div id="top-links-container">
	    			<ul>
	    				<li><a href="http://pipelinepackaging.com/products/my-briefcase/" class="top-link my-briefcase"><i class="icon-briefcase icon-large"></i><span>My Briefcase</span></a></li>
	    				<li><a href="http://pipelinepackaging.com/get-in-touch/" class="top-link contact-us"><i class="icon-envelope-alt icon-large"></i><span>Contact Us</span></a></li>
	    				<li><a href="http://pipelinepackaging.com/who-we-are/about-pipeline/" class="top-link about-us"><i class="icon-info-sign icon-large"></i><span>About Us</span></a></li>
	    				<li><a href="#" class="top-link phone"><i class="icon-phone icon-large"></i><span>877.242.1880</span></a></li>
	    				<li><form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
		    					<span class="top-link search">
		    						<i class="icon-search icon-large"></i>
									<span><?php get_search_form(); ?> <a href="#" class="search-submit-link" title="submit"></a> </span>
		    					</span>
	    					</form>
	    				</li>
	    			</ul>
	    		</div>
	    		<div id="logo-container" class="span_5">
    				<a href="<?php echo home_url(); ?>">
    					<img src="<?php bloginfo( 'template_directory' ); ?>/_img/logo.png" alt="Pipeline Packaging"  title="Pipeline Packaging" />
    				</a>
	    		</div>
	    		<div id="nav-container" class="span_11">
	    			<div id="mobile-nav">
						<form id="mobile-drop-down-form" action="" method="post">
							<select id="mobile-drop-down">
								<option value="" class="default-option">Select a menu item</option>
								<?php 
								
								$menu = wp_nav_menu(array('theme_location' => 'mobile', 'echo' => false));
								   if (preg_match_all('#(<a [^<]+</a>)#',$menu,$matches)) {
								      $hrefpat = '/(href *= *([\"\']?)([^\"\' ]+)\2)/';
								      foreach ($matches[0] as $link) {
								         // Do something with the link
								         if (preg_match($hrefpat,$link,$hrefs)) {
								            $href = $hrefs[3];
								         }
								         if (preg_match('#>([^<]+)<#',$link,$names)) {
								            $name = $names[1];
								         }
								         echo "<option value=\"$href\">$name</option>";
								      }
								   }				
								
								?>
							</select>
						</form>	    		
					</div>
	    			<nav>
		    			<?php wp_nav_menu( array( 'container'=>'false', 'theme_location' => 'primary' ) ); ?>
		    		</nav>
		    	</div>
    		</div>
		</div>
	</header>