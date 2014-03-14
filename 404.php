<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>



				<h1><?php _e( 'Uh oh! Did you lose your content? Let us try to help.', 'twentyten' ); ?></h1>
				<p><?php _e( 'If you came here from a Favorites link in your browser, then you saved a page from one of our old web sites that no longer exist. You will want to delete that Favorites link. Try clicking our logo to find newer information or use the Search. Hey! Even good packaging needs a facelift every now and then to stay sexy.', 'twentyten' ); ?></p>
				<?php get_search_form(); ?>

	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>