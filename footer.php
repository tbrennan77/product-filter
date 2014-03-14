<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?>
		<footer>
			<div class="full-width clearfix">
				<div id="footer-container" class="container clearfix">
					<nav>
						<?php wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'span_2 col', 'theme_location' => 'footer-column-1' ) ); ?>
						<?php wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'span_2 col', 'theme_location' => 'footer-column-2' ) ); ?>
						<?php wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'span_2 col', 'theme_location' => 'footer-column-3' ) ); ?>
						<?php wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'span_2 col', 'theme_location' => 'footer-column-4' ) ); ?>
						<?php wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'span_2 col', 'theme_location' => 'footer-column-5' ) ); ?>
		    		</nav>
		    		<div id="footer-address" class="span_6 col">
			    		<p><b>Pipeline</b> Packaging</p>
						<span class="footer-button-container clearfix"><a href="/who-we-are/territory-map/" class="button-link white">See our locations</a></span>
						<p><b><a onclick="goog_report_conversion('tel:1-877-242-1880')" href="tel:1-877-242-1880" >1.877.242.1880</a></b></p>
						<p><span id="copyright-legal">Copyright &copy; 2012 Pipeline Packaging | <a href="http://pipelinepackaging.com/pipeline-packaging-privacy-policy-terms-conditions/">Privacy &amp; Legal</a></span></p>
		    		</div>
	    		</div>
    		</div>
		</footer>
		<script src="<?php bloginfo( 'template_directory' ); ?>/_js/libs/jquery-1.7.2.min.js"></script>
		<script src="<?php bloginfo( 'template_directory' ); ?>/_js/libs/jquery.ui.core.min.js"></script>
		<script src="<?php bloginfo( 'template_directory' ); ?>/_js/libs/jquery.effects.core.min.js"></script>
		<script src="<?php bloginfo( 'template_directory' ); ?>/_js/plugins.js"></script>
  		<script src="<?php bloginfo( 'template_directory' ); ?>/_js/scripts.js"></script>
  		<?php if ( is_front_page() ) {?>
		<script src="<?php bloginfo( 'template_directory' ); ?>/_js/libs/camera.js"></script>
		<?php } ?>
  		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-33788820-1']);
		  _gaq.push(['_setDomainName', 'pipelinepackaging.com']);
		  _gaq.push(['_setAllowLinker', true]);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>
<?php wp_footer();?>
</body>
</html>