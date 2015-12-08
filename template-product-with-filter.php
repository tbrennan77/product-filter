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
			    			<!-- Begin product filter results -->
			    		<?php endwhile; ?>
			    	</div>			    	
			    	<div id="product-filter-results-container">
			    	<div id="product-filter-mobile">
			    		<?php create_filter_dropdown(); ?>
			    	</div>			
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
			    			@media print { .closure_text a:link:after, .closure_text a:visited:after { content:''; } {} header, footer, div.content, #sidebar-container, #product-filter-mobile, .view-your-briefcase, .content-image-header, #sthoverbuttons, .container-col1 > h1, .product-filter-table > thead, .product-filter-table tbody > tr:not(.modalShow) {display:none} .moreInfo tbody tr {display:table !important;width: 100%} .moreInfo tbody tr td {width: 50% !important;} div#content-container {width: 100%} .print_logo img {max-width: 30% !important} img {max-width: 100% !important} }
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
						<?php $product_line_id = set_params_from($_SERVER["REQUEST_URI"]); ?>
			    	</div>
	    		</div>
	    	</div>
	    	<?php get_sidebar(); ?>
    	</div>
    	</div>
<?php get_footer(); ?>

<link rel="stylesheet" href="/wp-content/themes/viewportindustries-Starkers-689d7e6/_css/jquery.windoze.plain.css">
<script src="/wp-content/themes/viewportindustries-Starkers-689d7e6/_js/jquery.windoze.plain.js"></script>

<div class="wdz-modal">
      <article style="width: 20%;text-align: center;padding: 3rem;">
        <h1 style="color:#0B79BF">Oops...</h1>
        <p>You must enter a product ID.</p>
      </article>
    </div>

<script>$('.wdz-modal').windoze({animation: 'slide-top'});</script>
