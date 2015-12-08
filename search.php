<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

			<div id="secondary-middle" class="container clearfix">
				<div id="content-container" class="span_12 col">
		    		<div class="container clearfix">
	
		    			<?php if ( have_posts() ) : ?>
		    				<h1><?php printf( __( 'Search Results for: %s', 'twentyten' ), '' . get_search_query() . '' ); ?></h1>
		    				<?php get_template_part( 'loop', 'search' ); ?>
		    			<?php else : ?>
		    			
							<h2><?php _e( 'Nothing Found', 'twentyten' ); ?></h2>
							<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
							<?php get_search_form(); ?>
						<?php endif; ?>
	
		    		</div>
		    	</div>
		
			<div id="sidebar-container" class="span_4 col">
				<div class="column-content" style='padding-top:0'>
					<div class="textwidget">
						<img class="aligncenter size-full wp-image-888" src="http://pipelinepackaging.com/wp-content/uploads/2012/08/call-today-pipeline-packaging.gif" alt="Call: 1-877-242-1880" onclick="goog_report_conversion('tel:1-877-242-1880')">
					</div>
					<div class="divider"></div>				    		
				    	<h3 class="widget-title">Searching for Products?</h3>
					<div id="shailan-subpages-5">
						<ul class="subpages">
							<li class="page_item page-item-240"><a href="http://pipelinepackaging.com/products/my-briefcase/" title="My Briefcase" rel="">My Briefcase</a></li>
						
							<li class="page_item page-item-101 current_page_item"><a href="http://pipelinepackaging.com/products/product-overview/" title="Product Overview" rel="">Product Overview</a></li>
							<li class="page_item page-item-82"><a href="http://pipelinepackaging.com/products/bottles-cubitainers-and-jars/" title="Bottles, Cubitainers and Jars" rel="">Bottles, Cubitainers and Jars</a></li>
							<li class="page_item page-item-84"><a href="http://pipelinepackaging.com/products/cans/" title="Cans" rel="">Cans</a></li>
							<li class="page_item page-item-88"><a href="http://pipelinepackaging.com/products/closing-tools/" title="Closing Tools" rel="">Closing Tools</a></li>
							<li class="page_item page-item-90"><a href="http://pipelinepackaging.com/products/closures/" title="Closures" rel="">Closures</a></li>
							<li class="page_item page-item-92"><a href="http://pipelinepackaging.com/products/drums-and-totes/" title="Drums and Totes" rel="">Drums and Totes</a></li>
							<li class="page_item page-item-94"><a href="http://pipelinepackaging.com/products/liners/" title="Liners" rel="">Liners</a></li>
							<li class="page_item page-item-97"><a href="http://pipelinepackaging.com/products/pails-and-tubs/" title="Pails and Tubs" rel="">Pails and Tubs</a></li>
							<li class="page_item page-item-99"><a href="http://pipelinepackaging.com/products/tubes/" title="Tubes" rel="">Tubes</a></li>
						</ul>
					</div> 			
				
				  <div class="divider"></div>
				    						    		
				    						    		
				    						    		
				    						    		
				    						    		
				    						    		
						</div>
					</div>








	    	</div>

<?php get_footer(); ?>
