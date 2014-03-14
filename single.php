<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>
		<div id="secondary-middle" class="container clearfix">
			<div id="content-container" class="span_12 col">
				<div class="content-image-header">
					<?php $category = get_the_category(); ?>
					<h4><?php echo $category[0]->cat_name; ?></h4>
				</div>
	    		<div class="container-col1 clearfix">
		    		<div class="content">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					
					<?php if ( in_category( 'news' )) { ?>
					<div class="divider"></div>
						<div class="span_16 clearfix">
							<div class="span_8 col previous-link">
								&nbsp;<?php previous_post_link('%link', '&larr; Previous', TRUE, '17 and 18'); ?>
							</div>
							<div class="span_8 col next-link">
								<?php next_post_link('%link', 'Next &rarr;', TRUE, '17 and 18'); ?>
							</div>
						</div>
					<div class="divider"></div>	
					<?php } else {} ?>
					<h1><?php the_title(); ?></h1>

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'twentyten' ), 'after' => '' ) ); ?>

								<?php if ( get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyten_author_bio_avatar_size', 60 ) ); ?>
							<h2><?php printf( esc_attr__( 'About %s', 'twentyten' ), get_the_author() ); ?></h2>
							<?php the_author_meta( 'description' ); ?>
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
								<?php printf( __( 'View all posts by %s &rarr;', 'twentyten' ), get_the_author() ); ?>
							</a>
<?php endif; ?>

						<?php edit_post_link( __( 'Edit', 'twentyten' ), '', '' ); ?>

					<?php if ( in_category( 'news' )) { ?>
					<div class="divider"></div>
						<div class="span_16 clearfix">
							<div class="span_8 col previous-link">
								&nbsp;<?php previous_post_link('%link', '&larr; Previous', TRUE, '17 and 18'); ?>
							</div>
							<div class="span_8 col next-link">
								<?php next_post_link('%link', 'Next &rarr;', TRUE, '17 and 18'); ?>
							</div>
						</div>
					<div class="divider"></div>	
					<?php } else {} ?>
<?php endwhile; // end of the loop. ?>

					</div>
	    		</div>
	    	</div>
	    	<?php get_sidebar(); ?>	
    	</div>

<?php get_footer(); ?>