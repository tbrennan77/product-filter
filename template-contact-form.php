<?php
/**
 * Template Name: Contact Form template
 *
 * A custom page template for the contact form.
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
			<div id="content-container" class="span_12 col">
				<div class="content-image-header">
					<?php $parent_title = get_the_title($post->post_parent); ?>
					<h4><?php echo $parent_title; ?></h4>
				</div>
	    		<div class="container-col1 clearfix">
		    		<h1><?php the_title(); ?></h1>
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		    			<?php the_content(); ?>
		    		<?php endwhile; ?>	
					<div id="map-container" class="span_8 col">
						<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps/ms?t=m&amp;msa=0&amp;msid=214266414379450954764.0004c623810e9603a9082&amp;source=embed&amp;ie=UTF8&amp;z=5&amp;output=embed"></iframe>	
						<span class="view-map-link clearfix"><a class="button-link blue" href="https://maps.google.com/maps/ms?ll=36.031332,-86.572266&amp;spn=14.603582,33.815918&amp;t=m&amp;z=6&amp;msa=0&amp;msid=214266414379450954764.0004c623810e9603a9082&amp;source=embed">Get Directions</a></span>					 
					</div>    		
	    		</div>
	    	</div>
    		<?php get_sidebar(); ?>
    	</div>

<?php get_footer(); ?>