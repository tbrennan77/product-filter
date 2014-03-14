<?php
/**
 * Template Name: Case Studies Listing template
 *
 * A custom page template for listing case studies.
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
		    		<div class="content">						
						<?php $custom_query = new WP_Query('cat=17');
							while($custom_query->have_posts()) : $custom_query->the_post(); ?>
								<div class="news-list-item span_16 clearfix">
									<div class="news-list-date span_4 col clearfix">
										<p><b><?php the_date(); ?></b></p>
									</div>
									<div class="news-list-title span_12 col clearfix" id="post-<?php the_ID(); ?>">
										<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
									</div>
								</div>
								<div class="divider"></div>
							<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>
						<?php endwhile; endif; ?>
		    		</div>
	    		</div>
	    	</div>
	    	<?php get_sidebar(); ?>	
    	</div>

<?php get_footer(); ?>