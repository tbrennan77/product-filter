<?php
/**
 * Template Name: General Content Full Width template
 *
 * A custom page template for the general content without the sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

		<div id="secondary-middle" class="container clearfix">
			<div id="content-container" class="span_16 col">
<!-- 				<div class="content-image-header"></div> -->
	    		<div class="container clearfix">
		    		<h1><?php the_title(); ?></h1>
	    			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		    			<?php the_content(); ?>
		    		<?php endwhile; ?>
			    	</div>
	    		</div>
	    	</div>
    	</div>

<?php get_footer(); ?>