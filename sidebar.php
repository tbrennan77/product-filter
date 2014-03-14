<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */
?>

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
					
				<?php 
				
				if ( in_category( 'news' )) { ?>
					
					<div id="sidebar-container" class="span_4 col">
		    			<div class="column-image-header"></div>
			    		<div class="column-content">
			    			<?php if ( ! dynamic_sidebar( 'global-misc-widget-area' ) ) : ?><?php endif;?>
							<ul class="sidebar-news-list">
								<?php
								$IDOutsideLoop = $post->ID;
								while( have_posts() ) {
									the_post();
									foreach( ( get_the_category() ) as $category )
										$my_query = new WP_Query('category_name=' . $category->category_nicename . '&orderby=date&order=desc');
										if( $my_query ) {
											while ( $my_query->have_posts() ) {
												$my_query->the_post(); ?>
												
												<li<?php print ( is_single() && $IDOutsideLoop == $post->ID ) ? ' class="test"' : ''; ?>>
													<b><?php the_date(); ?></b><br />
													<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
												</li>
								<?php
										}
									}
								}
								?>
							</ul>
						</div>
					</div>
					
				<?php } elseif ( is_page_template('template-product-with-filter.php') ) { ?>
				
					<div id="sidebar-container" class="span_4 col">
		    			<div class="column-image-header"></div>
			    		<div class="column-content">
			 												
						<div id="product-filter-container"><?php create_filter_dropdown(); ?></div>
						<?php if ( ! dynamic_sidebar( 'global-misc-widget-area' ) ) : ?><?php endif;?>						
						<?php if ( ! dynamic_sidebar( 'products-widget-area' ) ) : ?><?php endif;?>
						
						</div>
					</div>
					
				<?php } else { ?> 
				
					<div id="sidebar-container" class="span_4 col">
		    			<div class="column-image-header"></div>
			    		<div class="column-content">
			    			
				    		<?php if ( ! dynamic_sidebar( 'global-misc-widget-area' ) ) : ?><?php endif;?>
				    		
				    		<?php if ( $class == 'products') :  ?>
				    			<?php if ( ! dynamic_sidebar( 'products-widget-area' ) ) : ?><?php endif;?>
				    		<?php endif;?>
				    		
				    		<?php if ( $class == 'services') :  ?>
				    			<?php if ( ! dynamic_sidebar( 'services-widget-area' ) ) : ?><?php endif;?>
				    		<?php endif;?>
				    		
				    		<?php if ( $class == 'resources') :  ?>
				    			<?php if ( ! dynamic_sidebar( 'resources-widget-area' ) ) : ?><?php endif;?>
				    		<?php endif;?>
				    		
				    		<?php if ( $class == 'industries') :  ?>
				    			<?php if ( ! dynamic_sidebar( 'industries-widget-area' ) ) : ?><?php endif;?>
				    		<?php endif;?>
				    		
				    		<?php if ( $class == 'who-we-are') :  ?>
				    			<?php if ( ! dynamic_sidebar( 'who-we-are-widget-area' ) ) : ?><?php endif;?>
				    		<?php endif;?>
				    		
				    		<?php if ( $class == 'success-stories') :  ?>
				    			<?php if ( ! dynamic_sidebar( 'success-stories-widget-area' ) ) : ?><?php endif;?>
				    		<?php endif;?>
				    		
				    		<?php if ( $class == 'get-in-touch') :  ?>
				    			<?php if ( ! dynamic_sidebar( 'get-in-touch-widget-area' ) ) : ?><?php endif;?>
				    		<?php endif;?>
				    		
						</div>
					</div>
				
				<?php } ?>
			