<?php
/**
 * Template Name: Home page template
 *
 * A custom page template for the home page.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Starkers
 * @since Starkers 3.0
 */

get_header(); ?>

<!-- //BEGIN GALLERY// -->

		<div id="gallery-container" class="full-width">
	    	<div id="hero-gallery" class="full-width">
	    	
				<?php if(get_field('gallery')): ?>
				
					<?php while(the_repeater_field('gallery')): ?>
	
						<div data-src="<?php the_sub_field('image'); ?>">
							<div class="gallery-text clearfix">
								<div class="span_6 col">
									<h1><?php the_sub_field('heading'); ?></h1>
									<p><?php the_sub_field('content'); ?></p>
									<a href="<?php the_sub_field('button_link'); ?>" class="gallery-button">Read More</a> 
								</div>
							</div>
						</div>
					
					<?php endwhile; ?>
						
				<?php endif; ?>
	    	
	    	</div>
	    </div>
	    
<!-- //END GALLERY// -->

<!-- //BEGIN MIDDLE - includes Welcome text, quick tabs and circle images // -->

		<div id="homepage-middle" class="full-width clearfix">
			<div id="middle-container" class="container clearfix">
	    		<div class="span_8 col">
	    			<h2><i>People at the Core.</i></h2>
					<?php the_field('welcome_text'); ?>	    		
				</div>
	    		<div id="quick-tabs" class="span_8 col">
	    			<h2>I'm looking for...</h2>
					<div id="tab-container" class="tab-container">
						<ul class='etabs'>
							<li id="tab1" class="tab"><a href="#tabs1">Products</a></li>
							<li id="tab2" class="tab"><a href="#tabs2">Services</a></li>
							<li id="tab3" class="tab"><a href="#tabs3">Contact Information</a></li>
							<li id="tab4" class="tab"><a href="#tabs4">More about Pipeline</a></li>
						</ul>
						<div id="tabs1" class="tabs-content clearfix">
							<?php wp_nav_menu( array( 
								'container'      =>'false',
								'theme_location' => 'hp-product-links',
								'menu_class' => 'list-grid'
								) ); ?>
							<!--
<select id="choose-product-line" class="span_3">
								<option selected="selected" class="span_4">Product Line</option>
								<option>Option 1</option>
								<option>Option 2</option>
								<option>Option 3</option>
							</select>
							<select id="choose-material" class="span_3">
								<option selected="selected">Material</option>
								<option>Option 1</option>
								<option>Option 2</option>
								<option>Option 3</option>
							</select>
							<select id="choose-size" class="span_3">
								<option selected="selected">Size</option>
								<option>Option 1</option>
								<option>Option 2</option>
								<option>Option 3</option>
							</select>
							<input type="submit" value="Submit" class="button" />
-->
						</div>
						<div id="tabs2" class="tabs-content clearfix">
		    				<!--
<form id="hp-services-drop-down" action="" method="post">
								<select id="choose-service">
								<option value="" class="default-option">Select a Service</option>
								<?php 
								
								$menu = wp_nav_menu(array('theme_location' => 'hp-services-drop-down', 'echo' => false));
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
-->
							<?php wp_nav_menu( array( 
								'container'      =>'false',
								'theme_location' => 'hp-services-drop-down',
								'menu_class' => 'list-grid'
							) ); ?>
						</div>
						<div id="tabs3" class="tabs-content clearfix">
							<p>Select an office near your location:</p>
							<select id="choose-location" name="choose-location">
								<option value="0">Choose a Location</option>
								<option value="loc1">Atlanta, GA</option>
								<option value="loc2">Charlotte, NC</option>
								<option value="loc3">Cincinnati, OH</option>
								<option value="loc4">Cleveland, OH</option>
								<option value="loc5">Dallas, TX</option>
								<option value="loc6">Des Moines, IA</option>
								<option value="loc7">Detroit, MI</option>
								<option value="loc8">Greenville, SC</option>
								<option value="loc9">Houston, TX - North</option>
								<option value="loc10">Houston, TX - South</option>
								<option value="loc11">Kansas City, KS</option>
								<option value="loc12">Nashville, TN</option>
								<option value="loc13">Oyster Creek, TX</option>
							</select>
							<div id="div-loc1" class="location-container span_8">
								<p><b>Atlanta, GA</b><br />
								4175 Royal Drive, Suite 700<br />
								Kennesaw, GA 30144<br />
								Toll Free: 800.351.9856<br />
								Fax: 770.420.7002<br />
								Local: 770.420.8181
								</p>
							</div>
							<div id="div-loc2" class="location-container span_8">
								<p>
								<b>Charlotte, NC</b><br />
								1430 West Pointe Drive, Suite G<br />
								Charlotte, NC 28214<br />
								Toll Free: 855.596.9909<br />
								Fax: 704.392.9063<br />
								Local: 704.392.9023
								</p>
							</div>
							<div id="div-loc3" class="location-container span_8">
								<p>
									<b>Cincinnati, OH</b><br />
									7390 Union Centre Blvd.<br />
									Fairfield, Ohio 45014<br />
									Toll Free: 866.677.7245<br />
									Fax: 513.874.0966<br />
									Local: 513.874.6555
								</p>
							</div>
							<div id="div-loc4" class="location-container span_8">
								<p>
									<b>Cleveland, OH</b><br />
									30310 Emerald Valley Pkwy, Suite 500<br />
									Glenwillow, OH  44139<br />
									Toll Free: 800.446.0351<br />
									Fax: 440.349.2900<br />
									Local: 440.349.3200
								</p>
							</div>
							<div id="div-loc5" class="location-container span_8">
								<p>
									<b>Dallas, TX</b><br />
									3221 East Arkansas Lane, Suite 150<br />
									Arlington, TX 76010<br />
									Toll Free: 866.715.7245<br />
									Fax: 817.385.5885<br />
									Local: 817.385.5354
								</p>
							</div>
							<div id="div-loc6" class="location-container span_8">
								<p>
									<b>Des Moines, IA</b><br />
									1300 S.E. Gateway Drive, Suite 107<br />
									Grimes, IA 50111<br />
									Toll Free: 800.321.0850<br />
									Fax: 515.986.9017<br />
									Local: 515.986.2226
								</p>
							</div>
							<div id="div-loc7" class="location-container span_8">
								<p>
									<b>Detroit, MI</b><br />
									1421 Piedmont Drive<br />
									Troy, MI  48083<br />
									Toll Free: 888.983.0248<br />
									Fax: 248.743.0259<br />
									Local: 248.743.0248
								</p>
							</div>
							<div id="div-loc8" class="location-container span_8">
								<p>
									<b>Greenville, SC</b><br />
									1010 East North Street, Suite D3<br />
									Greenville, SC 29601<br />
									Toll Free: 855.277.0566<br />
									Fax: 864.277.0957<br />
									Local: 864.277.0900
								</p>
							</div>
							<div id="div-loc9" class="location-container span_8">
								<p>
									<b>Houston, TX - North</b><br />
									12777 Jones Road, Suite 105<br />
									Houston, TX 77070<br />
									TF: 877.462.1669<br />
									Fax: 281.477.7524<br />
									Local: 281.477.7500
								</p>
							</div>
							<div id="div-loc10" class="location-container span_8">
								<p>
									<b>Houston, TX - South</b><br />
									7449 E. Orem Drive<br />
									Houston, TX 77075<br />
									TF: 844.961.0611<br />
									Fax: 713.991.0612<br />
									Local: 713.991.0611
								</p>
							</div>
							<div id="div-loc11" class="location-container span_8">
								<p>
									<b>Kansas City, KS</b><br />
									8230 Marshall Drive<br />
									Lenexa, KS 66214<br />
									TF: 800.446.4080<br />
									Fax: 913.888.6363<br />
									Local: 913.888.6100
								</p>
							</div>
							<div id="div-loc12" class="location-container span_8">
								<p>
									<b>Nashville, TN</b><br />
									1435-A Heil Quaker Blvd<br />
									La Vergne, TN 37086<br />
									TF: 866.518.3800<br />
									Fax: 615.213.0873<br />
									Local: 615.213.0870
								</p>
							</div>
							<div id="div-loc13" class="location-container span_8">
								<p>
									<b>Oyster Creek, TX</b><br />
									1824 FM 523<br />
									Oyster Creek, TX 77541<br />
									TF: 844.437.6248<br />
									Fax: 979.266.8779<br />
									Local: 979.239.3786
								</p>
							</div>
							<div id="social-container" class="span_16">
								<div class="divider"></div>
								<ul id="social-media-list">
									<li class="span_4"><img src="<?php bloginfo( 'template_directory' ); ?>/_img/icon-facebook.png" alt="icon-facebook" width="24" height="24"><a href="http://www.facebook.com/PipelinePackaging" target="_blank">Facebook</a></li>
									<li class="span_4"><img src="<?php bloginfo( 'template_directory' ); ?>/_img/icon-linkedin.png" alt="icon-linkedin" width="24" height="24"><a href="http://www.linkedin.com/company/pipeline-packaging" target="_blank">LinkedIn</a></li>
									<li class="span_4"><img src="<?php bloginfo( 'template_directory' ); ?>/_img/icon-twitter.png" alt="icon-twitter" width="24" height="24"><a href="http://twitter.com/PipelinePkg" target="_blank">Twitter</a></li>
									<li class="span_4"><img src="<?php bloginfo( 'template_directory' ); ?>/_img/icon-youtube.png" alt="icon-youtube" width="24" height="24"><a href="http://www.youtube.com/user/PipelinePkg" target="_blank">YouTube</a></li>
								</ul>	
							</div>
						</div>
						<div id="tabs4" class="tabs-content clearfix">
							<?php wp_nav_menu( array( 
								'container'      =>'false',
								'theme_location' => 'hp-about-links',
								'menu_class' => 'list-grid'
								) ); ?>
						</div>
					</div>
	    		</div>
			</div>
			<div id="circle-image-container" class="full-width col">
				<span class="circle-image bg1"></span>
				<span class="circle-image bg2"></span>
				<span class="circle-image bg3"></span>
				<span class="circle-image bg4"></span>
			</div>
		</div>

<!-- //END MIDDLE// -->

<!-- //BEGIN CALLOUTS// -->

		<div id="callouts-container" class="full-width">
			<div class="container clearfix">
			
				<?php if(get_field('callouts')): ?>
				
					<?php $i=1; while(the_repeater_field('callouts')): ?>
					
							<div class="span_5 col">
								<div id="callout<?php echo $i;?>" class="callout">
									<h3>
										<?php if(get_sub_field('category') == "case-study"): ?>
											<span class="callout-header-icon blue callout-header1"><i class="icon-book icon-large"></i></span>Case Study
										<?php endif; ?>
										<?php if(get_sub_field('category') == "product-spotlight"): ?>
											<span class="callout-header-icon orange callout-header2"><i class="icon-bolt icon-large"></i></span>Product Spotlight
										<?php endif; ?>
										<?php if(get_sub_field('category') == "people-at-the-core"): ?>
											<span class="callout-header-icon red callout-header3"><i class="icon-group icon-large"></i></span>People at the Core
										<?php endif; ?>
									</h3>
									<div class="callout-image">
										<img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('image_alt_text'); ?>" />
									</div>
									<div class="callout-content clearfix">
										<?php the_sub_field('content'); ?>
										<p><a href="<?php the_sub_field('button_link'); ?>" class="button-link callout-button">Learn More</a></p>
									</div>
								</div>
							</div>
							<?php $i++; ?>
							
					<?php endwhile; ?>
					
				<?php endif; ?>
			
			</div>
		</div>

<!-- //ENDCALLOUTS// -->



<?php get_footer(); ?>