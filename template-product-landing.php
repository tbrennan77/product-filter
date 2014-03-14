<?php
/**
 * Template Name: Product Landing template
 *
 * A custom page template for the Product Landing page.
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
	    		<div class="container-col1 clearfix product-groups">
		    		<h1><?php the_title(); ?></h1>
		    		<div id="product-overview-nav">
						<form id="product-overview-nav-form" action="" method="post">
							<select id="choose-product">
								<option value="" class="default-option">Select a Product</option>
								
								<?php $menu = wp_nav_menu(array('theme_location' => 'product-overview-nav', 'echo' => false));
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
					<div class="content">
					
						<?php the_field('content_area_1'); ?>
						
					</div>
					<?php if(get_field('product_listing')): ?>
						
					 	<div class="full-width clearfix product-listing">
					 	
					 	<?php while(the_repeater_field('product_listing')): ?>
						 	
						 		<div class="span_quarter">
									<a href="<?php the_sub_field('link'); ?>"><img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('image_alt_text'); ?>"></a>
									<h2><?php the_sub_field('product_name'); ?></h2>
								</div>
							
					 	<?php endwhile; ?>
					 	
						</div>
						
					 <?php endif; ?>
					
		    		<div class="content">
		    		
		    			 <?php the_field('content_area_2'); ?>
		    			 
		    		</div>
	    		</div>
	    	</div>
	    	<?php get_sidebar(); ?>	
    	</div>

<?php get_footer(); ?>