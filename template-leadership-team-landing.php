<?php
/**
 * Template Name: Leadership Team Landing template
 *
 * A custom page template for the Leaderhip Team landing page.
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
		    			<?php if(get_field('leadership_team_members')): ?>
		    			
		    				<?php the_field('opening_paragraph'); ?>
								
							<div class="divider"></div>
							<div class="leadership-circles span_16 col">
							
							<?php while(the_repeater_field('leadership_team_members')): ?>
							
								<div class="span_third col">
									<span class="circle-image">
										<a href="<?php the_sub_field('link'); ?>"><img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('image_alt_text'); ?>" /></a>
									</span>
									<p><b><?php the_sub_field('name'); ?></b><br /><?php the_sub_field('job_title'); ?></p>
								</div>
							
							<?php endwhile; ?>
						
							</div>
							<div class="divider"></div>
							
						<?php endif; ?>

		    			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			    			<?php the_content(); ?>
			    		<?php endwhile; ?>
		    		</div>
	    		</div>
	    	</div>
	    	<?php get_sidebar(); ?>	
    	</div>

<?php get_footer(); ?>
