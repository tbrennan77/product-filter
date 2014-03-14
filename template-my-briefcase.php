<?php
/**
 * Template Name: My Briefcase template
 *
 * A custom page template for My Briefcase.
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
						<script>
		    			function toggleCheckBoxes() {
		    				if (jQuery('input#toggleCheckBoxes').is(':checked')) {
			    				jQuery('input.product_id').each(function() {
							       jQuery(this).attr('checked', true);
							     });		    					
		    				} else {
									jQuery('input.product_id').each(function() {
						       jQuery(this).attr('checked', false);
						     });		    					
		    				}
		    			}		    		
		    			function get_product_ids() {         
						     var product_ids = [];
						     jQuery('input.product_id:checked').each(function() {
						       product_ids.push(jQuery(this).val());
						     });
						     jQuery('#product_ids').val(product_ids);						     
						  }
			    		function remove_product_from_briefcase(product_id) {
						    jQuery.ajaxSetup({ 
							    beforeSend: function() {							    	
						        //jQuery("#ajax_working").fadeIn();
						        jQuery("#removeLink"+product_id).parent().parent().fadeOut('slow');
						      },     
						      success: function(data, textStatus, XMLHttpRequest){
						      	//jQuery("#ajax_working").fadeOut();
						      	jQuery("#myBriefcase").html('');
						      	jQuery("#myBriefcase").append(data.slice(0, -1));						      	
						      },
						      error: function(XMLHttpRequest, textStatus, errorThrown){
						        alert(errorThrown);
						      }           
						    });
						    			    
						    var dataString = "action=remove_briefcase_item&product_id="+product_id;
						    $.post('/wp-admin/admin-ajax.php', dataString);
						  }

						  function empty_briefcase() {
						    jQuery.ajaxSetup({ 
							    beforeSend: function() {
						        jQuery("#myBriefcase").slideUp('fast');
						      },     
						      success: function(data, textStatus, XMLHttpRequest){
						      	jQuery("#myBriefcase").html('');
						      	jQuery("#myBriefcase").append(data.slice(0, -1));
						      	jQuery("#myBriefcase").fadeIn();
						      },
						      error: function(XMLHttpRequest, textStatus, errorThrown){
						        alert(errorThrown);
						      }           
						    });
						    
						    $.post('/wp-admin/admin-ajax.php', "action=clear_briefcase");
						  }		

						  function send_briefcase_email(dataString) {
						  	jQuery.ajaxSetup({ 
							    beforeSend: function() {
						      },     
						      success: function(data, textStatus, XMLHttpRequest){
						      	alert(data);
						      },
						      error: function(XMLHttpRequest, textStatus, errorThrown){
						        alert(errorThrown);
						      }           
						    });

						  	$.post('/wp-admin/admin-ajax.php', dataString);
						  }
						  jQuery('input#toggleCheckBoxes').live('click', function() {
						  	toggleCheckBoxes();
						  });
			    		</script>
			    		<style>
				    		textarea {padding: 16px;}
			    			div.error_messages ul li{margin-left: 20px;}
			    			div.error_messages ul {
			    				background: #bc0101;
			    				color: white;
			    				padding: 8px;
			    				width: 50%;
			    				border-radius: 6px;
			    				text-shadow: 0 -1px 1px #AAA;
			    			}  		
			    			div.notice h3 {
			    				color: white;
			    				text-shadow: 0 -1px 1px #AAA;
			    				padding: 8px;
			    				background: green;
			    				border-radius: 6px;
			    				width: 100%;
			    			}	
			    		</style>
			    		<div id='myBriefcase'>
			    			<?php display_briefcase(); ?>
			    		</div>
		    			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			    			<?php the_content(); ?>
			    		<?php endwhile; ?>
		    		</div>
	    		</div>
	    	</div>
	    	<?php get_sidebar(); ?>	
    	</div>

<?php get_footer(); ?>