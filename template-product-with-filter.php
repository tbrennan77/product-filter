<?php
/**
 * Template Name: Product - With Filter template
 *
 * A custom page template for a Product page with the search filter.
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
		    			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			    			<div class="span_6 product-group-image"><img src="<?php the_field('image'); ?>" alt="<?php the_field('image_alt_text'); ?>" class="aligncenter" /></div><?php the_content(); ?>
			    		<?php endwhile; ?>
			    	</div>
			    	<div class="divider"></div>
			    	<div id="product-filter-results-container">
			    	<div id="product-filter-mobile">
			    		<?php create_filter_dropdown(); ?>
			    	</div>
<!--------------------------------------------------------//PRODUCT FILTER RESULTS GO HERE//-------------------------------------------------------->
						<script>
			    		function add_product_to_briefcase(product_id) {
						    jQuery.ajaxSetup({ 
							    beforeSend: function() {
						        //jQuery("#ajax_working").fadeIn();
						        jQuery("a#b"+product_id).parent().fadeTo('fast', 0.3);
						        jQuery("a#bl"+product_id).parent().fadeOut();
						      },     
						      success: function(data, textStatus, XMLHttpRequest){
						      	//jQuery("#ajax_working").fadeOut();
						      	jQuery("a#b"+product_id).parent().html('<a href="#" id="b'+product_id+'" onclick="remove_product_from_briefcase(&quot;'+product_id+'&quot;); return false;"><span class="icon-span my-briefcase"><i class="icon-briefcase icon-large"></i></span>Remove from my briefcase</a>').fadeTo('slow', 1);
						      	jQuery("a#bl"+product_id).parent().html('<a href="#" id="bl'+product_id+'" onclick="remove_product_from_briefcase(&quot;'+product_id+'&quot;); return false;" class="button-link red">Remove</a>').fadeIn();
						      },
						      error: function(XMLHttpRequest, textStatus, errorThrown){
						        alert(errorThrown);
						      }           
						    });

						    var dataString = "action=set_briefcase_item&product_id="+product_id;
						    $.post('/wp-admin/admin-ajax.php', dataString);
						  }
						  function remove_product_from_briefcase(product_id) {
						    jQuery.ajaxSetup({ 
							    beforeSend: function() {
						        //jQuery("#ajax_working").fadeIn();
						        jQuery("a#b"+product_id).parent().fadeTo('fast', 0.3);
						        jQuery("a#bl"+product_id).parent().fadeOut();
						      },     
						      success: function(data, textStatus, XMLHttpRequest){
						      	//jQuery("#ajax_working").fadeOut();
						      	jQuery("a#b"+product_id).parent().html('<a href="#" id="b'+product_id+'" onclick="add_product_to_briefcase(&quot;'+product_id+'&quot;); return false;"><span class="icon-span my-briefcase"><i class="icon-briefcase icon-large"></i></span>Add to my briefcase</a>').fadeTo('slow', 1);
						      	jQuery("a#bl"+product_id).parent().html('<a href="#" id="bl'+product_id+'" onclick="add_product_to_briefcase(&quot;'+product_id+'&quot;); return false;" class="button-link yellow">Add</a>').fadeIn();
						      },
						      error: function(XMLHttpRequest, textStatus, errorThrown){
						        alert(errorThrown);
						      }           
						    });
						    			    
						    var dataString = "action=remove_briefcase_item&product_id="+product_id;
						    $.post('/wp-admin/admin-ajax.php', dataString);
						  }
			    		</script>
			    		<style>			    			
			    			div#ajax_working {
			    				display:none; 
			    				background: url(/wp-content/themes/viewportindustries-Starkers-689d7e6/_img/ajax-loader.gif); 
			    				height: 32px; 
			    				width: 32px; 
			    				position: fixed; 
			    				left: 50%; 
			    				top: 50%;
			    			}
			    		</style>
						<script src='<?php bloginfo('template_url'); ?>/_js/search_for_products.js'></script>
						<div id='ajax_working'></div>
						<script>
						function reset_my(obj) {
				      var stuff = "select[name=" + obj + "] option[value='']";      
				      jQuery(stuff).attr('selected', true);				      				      
				    }
				    </script>
						<script>
						function reset_my(obj) {
				      var stuff = "select[name=" + obj + "] option[value='']";      
				      jQuery(stuff).attr('selected', true);				      				      
				    }
				    </script>
						<?php 
				      $product_line_id = set_params_from($_SERVER["REQUEST_URI"]);
              
              echo "<div id=pTable>";              	
                search_for_products($_POST['productLineId'] = $product_line_id);
              echo "</div>";						 
						 ?>
						 
<!--------------------------------------------------------//PRODUCT FILTER RESULTS END HERE//-------------------------------------------------------->
			    	</div>
	    		</div>
	    	</div>
	    	<?php get_sidebar(); ?>
    	</div>
    	</div>
<?php get_footer(); ?>
