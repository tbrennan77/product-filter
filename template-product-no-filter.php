<?php
/**
 * Template Name: Product - With No Filter template
 *
 * A custom page template for a Product page without the search filter.
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
		    		<div class="span_16 col content"> 
		    			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			    			<!-- <div class="span_6 industry-image"><img src="<?php the_field('image'); ?>" alt="<?php the_field('image_alt_text'); ?>" class="aligncenter" /></div> --> <?php the_content(); ?>
			    		<?php endwhile; ?>
			    	</div>
	    		</div>
	    	</div>
	    	<?php get_sidebar(); ?>
    	</div>

<?php get_footer(); ?>