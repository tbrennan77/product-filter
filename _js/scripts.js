function findProductId(input) {
  return $(input).val();
}

function updateProductLink() {
  var product_id = findProductId($(this));
  if (product_id.length) {
    $('.showProductLink').attr('href', '/products/show?id=' + product_id);
  }
}

function checkValue(event) {
  var product_id  = findProductId($(this).prev('input'));
  if (!product_id.length) {
    event.preventDefault();
    $('.wdz-modal').trigger('open.windoze');
  }
}

$(document).on('keyup', '#show_product_id', updateProductLink);
$(document).on('click', '.showProductLink', checkValue);

$(document).ready(function() {
	/********************************************************
		RETINA IMAGES
	*********************************************************/
	$('img').retina();
	
	/********************************************************
		REMOVE DEFAULT INPUT VAULES
	*********************************************************/
	$('input.text-input').focus(function() {
	    if (!$(this).data('originalValue')) {
	        $(this).data('originalValue', $(this).val());
	    }
	    if ($(this).val() == $(this).data('originalValue')) {
	        $(this).val('');
	    }
	}).blur(function(){
	    if ($(this).val() == '') {
	        $(this).val($(this).data('originalValue'));
	    }
	});
	
	$("a.search-submit-link[title=submit]").click( function(){
	    $(this).parents("form").submit();
    });
	
	/********************************************************
		Select dropdown fixes
	*********************************************************/
	  $('#mobile-nav select').on('change', function () {
	    if (this.value != '') {
	        window.location = this.value;
	    }
	  });

	  
	  $('#choose-service').on('change', function () {
	    if (this.value != '') {
	        window.location = this.value;
	    }
	  });
	  
	   $('#choose-product').on('change', function () {
	    if (this.value != '') {
	        window.location = this.value;
	    }
	  });
	  
	  $(".search-submit-link").hover(
	  function () {
	    $(this).addClass("hover");
	  },
	  function () {
	    $(this).removeClass("hover");
	  }
	);
	/********************************************************
		LEFT,MIDDLE,RIGHT CLASSES FOR CIRCLE IMAGE DIVS ON HOMEPAGE
	*********************************************************/
	
	$("#circle-image-container .circle-image:nth-child(4n+1)").addClass("left");
	$("#circle-image-container .circle-image:nth-child(4n+2)").addClass("middle");
	$("#circle-image-container .circle-image:nth-child(4n+3)").addClass("middle");
	$("#circle-image-container .circle-image:nth-child(4n+4)").addClass("right");
	
	/********************************************************
		Packaging Glossary query string appending
	*********************************************************/
 	$("#filter_1").change(function(e) {
   window.location.href = '?filter_1=' + $(this).val() + 
      querystring('filter_2', '&');
	});
	$("#filter_2").change(function(e) {
	   window.location.href = '?filter_2=' + $(this).val() + 
	      querystring('filter_1', '&');
	});
	
	function querystring(name, prefix)
	{
	  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	  var regexS = "[\\?&]" + name + "=([^&#]*)";
	  var regex = new RegExp(regexS);
	  var results = regex.exec(window.location.search);
	  if(results == null)
	    return '';
	  else
	    return (prefix||'')+name+'='+ decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	$('.reset-glossary').click(function(){
	  location.hash = '';
	});
	$(".reset-glossary").hover(
	  function () {
	    $(this).addClass("hover");
	  },
	  function () {
	    $(this).removeClass("hover");
	  }
	);
	$('.reset-glossary').bind('click', function (n) {
	     var _url = $(location).attr('href');
	     var _arr_url = _url.split('?');
	     if (_arr_url.length >= 2) {
	         window.location.replace(_arr_url[0]);
	         return false;
	     }
	});
	/********************************************************
		Homepage About links
	*********************************************************/
	  $(".list-grid li a").addClass("button-link blue");
	  
	/********************************************************
		INPUT BUTTON HOVER/ACTIVE STATES
	*********************************************************/
	$("input.button").hover(
	  function () {
	    $(this).addClass("hover");
	  },
	  function () {
	    $(this).removeClass("hover");
	  }
	);
	$(function() {                       //run when the DOM is ready
		$(".button").click(function() {  //use a class, since your ID gets mangled
		$(this).addClass("active");      //add the class to the clicked element
	  });
	});
	/********************************************************
		TOP LINKS
	*********************************************************/
	$(".my-briefcase").hover(
	  function () {
	    $(".my-briefcase span").addClass("hover");
	    $(".full-width.colorbar").addClass("my-briefcase-hover");
	  },
	  function () {
	    $(".my-briefcase span").removeClass("hover");
	    $(".full-width.colorbar").removeClass("my-briefcase-hover");
	  }
	);
	$(".contact-us").hover(
	  function () {
	    $(".contact-us span").addClass("hover");
	    $(".full-width.colorbar").addClass("contact-us-hover");
	  },
	  function () {
	    $(".contact-us span").removeClass("hover");
	    $(".full-width.colorbar").removeClass("contact-us-hover");
	  }
	);
	$(".about-us").hover(
	  function () {
	    $(".about-us span").addClass("hover");
	    $(".full-width.colorbar").addClass("about-us-hover");
	  },
	  function () {
	    $(".about-us span").removeClass("hover");
	    $(".full-width.colorbar").removeClass("about-us-hover");
	  }
	);
	$(".phone").hover(
	  function () {
	    $(".phone span").addClass("hover");
	    $(".full-width.colorbar").addClass("phone-hover");
	  },
	  function () {
	    $(".phone span").removeClass("hover");
	    $(".full-width.colorbar").removeClass("phone-hover");
	  }
	);
	$(".top-link.products").hover(
	  function () {
	    $(".top-link.products span").addClass("hover");
	    $(".full-width.colorbar").addClass("products-hover");
	  },
	  function () {
	    $(".top-link.products span").removeClass("hover");
	    $(".full-width.colorbar").removeClass("products-hover");
	  }
	);
	$(".search").hover(
	  function () {
	    $(".top-link.search span").addClass("hover");
	    $(".full-width.colorbar").addClass("search-hover");
	  },
	  function () {
	    $(".top-link.search span").removeClass("hover");
	    $(".full-width.colorbar").removeClass("search-hover");
	  }
	);
	$(".social-icon").hover(
          function () {
	    $(this).find('span').addClass('hover');
            //$(".top-link.search span").addClass("hover");
            $(".full-width.colorbar").addClass("social-hover");
          },
          function () {
	    $(this).find('span').removeClass('hover');
            //$(".top-link.search span").removeClass("hover");
            $(".full-width.colorbar").removeClass("social-hover");
          }
        );
	$("#top-links-container .search").hover(
	  function () {
	    $(this).addClass("hover");
	  },
	  function () {
	    $(this).removeClass("hover");
	  }
	);
	/********************************************************
		NAV MARGIN FIXES
	*********************************************************/	
	
	$(".ss-nav-menu-item-0").addClass("no-left-padding");
	$(".ss-nav-menu-item-0").addClass("no-right-padding");
	
	/********************************************************
		HOMEPAGE QUICK TABS
	*********************************************************/	
	$('#tab-container').easytabs({
		animate: false
	});
	/********************************************************
		HOMEPAGE CIRCLE IMAGES
	*********************************************************/
	$(".circle-image").hover(
	  function () {
	    $(this).addClass("hover");
	  },
	  function () {
	    $(this).removeClass("hover");
	  }
	);
	/********************************************************
		CALLOUT CONTENT HOVER
	*********************************************************/
    $('.location-container').hide();
    $('#choose-location').change(function() {
    	$('.location-container').hide();
    	$('#div-' + $(this).val()).show();
    });

	$("#callout1").hover(
	  function () {
	    $(".callout-header1").addClass("hover");
	  },
	  function () {
	    $(".callout-header1").removeClass("hover");
	  }
	);
	$("#callout2").hover(
	  function () {
	    $(".callout-header2").addClass("hover");
	  },
	  function () {
	    $(".callout-header2").removeClass("hover");
	  }
	);
	$("#callout3").hover(
	  function () {
	    $(".callout-header3").addClass("hover");
	  },
	  function () {
	    $(".callout-header3").removeClass("hover");
	  }
	);
	$("#callout1").hover(
	  function () {
	    $("#callout1 .callout-content").addClass("hover");
	  },
	  function () {
	    $("#callout1 .callout-content").removeClass("hover");
	  }
	);
	$("#callout2").hover(
	  function () {
	    $("#callout2 .callout-content").addClass("hover");
	  },
	  function () {
	    $("#callout2 .callout-content").removeClass("hover");
	  }
	);
	$("#callout3").hover(
	  function () {
	    $("#callout3 .callout-content").addClass("hover");
	  },
	  function () {
	    $("#callout3 .callout-content").removeClass("hover");
	  }
	);
	
	/********************************************************
		TOP MARGIN FOR NEWS AND CASE STUDIES LISTS
	*********************************************************/
	
	$(".content .news-list-item:first-child").css("margin-top","40px");
	
	/********************************************************
		PRODUCT IMAGE HOVER
	*********************************************************/
	$(".span_third").hover(
	  function () {
	    $(this).addClass("hover");
	  },
	  function () {
	    $(this).removeClass("hover");
	  }
	);
	$(".product-groups div.span_quarter:nth-child(4n+1)").addClass("left");
	$(".product-groups div.span_quarter:nth-child(4n+2)").addClass("middle");
	$(".product-groups div.span_quarter:nth-child(4n+3)").addClass("middle");
	$(".product-groups div.span_quarter:nth-child(4n+4)").addClass("right");
	
	$("#general-table td:first-child").css("font-weight","700");
	
	$("#menu-footer-navigation-column-1 li").children(":first").addClass("footer-nav-header");
	$("#menu-footer-navigation-column-2 li").children(":first").addClass("footer-nav-header");
	$("#menu-footer-navigation-column-3 li").children(":first").addClass("footer-nav-header");
	$("#menu-footer-navigation-column-4 li").children(":first").addClass("footer-nav-header");
	$("#menu-footer-navigation-column-5 li").children(":first").addClass("footer-nav-header");
	
	/********************************************************
		ADD MAIN NAV CLASSES
	*********************************************************/
		
	$("ul.menu > li").addClass("top");
	
	var topLevel = $("#nav-container ul > li").has("ul");
	topLevel.addClass("has-child");
	topLevel.find("li").has("ul").addClass("sub");
		
	$("li.top").hover(
	  function () {
	    $(this).addClass("hover");
	  },
	  function () {
	    $(this).removeClass("hover");
	  }
	);
	$("ul.menu li:last-child").addClass("last");
	$("ul.sub-menu li:last-child").addClass("last");
	
	/********************************************************
		RANDOM SIDEBAR BACKGROUND IMAGES
	*********************************************************/
	var images = [
				  'sidebar-header-images_1_pipeline_packaging.jpg', 	
				  'sidebar-header-images_2_pipeline_packaging.jpg', 	
				  'sidebar-header-images_3_pipeline_packaging.jpg', 
				  'sidebar-header-images_4_pipeline_packaging.jpg', 
				  'sidebar-header-images_5_pipeline_packaging.jpg',
				  'sidebar-header-images_6_pipeline_packaging.jpg',
				  'sidebar-header-images_7_pipeline_packaging.jpg',
				  'sidebar-header-images_8_pipeline_packaging.jpg',
				  'sidebar-header-images_9_pipeline_packaging.jpg',
				  'sidebar-header-images_10_pipeline_packaging.jpg',
				  'sidebar-header-images_11_pipeline_packaging.jpg',
				  'sidebar-header-images_12_pipeline_packaging.jpg',
				  'sidebar-header-images_13_pipeline_packaging.jpg',
				  'sidebar-header-images_14_pipeline_packaging.jpg',
				  'sidebar-header-images_15_pipeline_packaging.jpg',
				  'sidebar-header-images_16_pipeline_packaging.jpg', 
				  'sidebar-header-images_17_pipeline_packaging.jpg',
				  'sidebar-header-images_18_pipeline_packaging.jpg',
				  'sidebar-header-images_19_pipeline_packaging.jpg',
				  'sidebar-header-images_20_pipeline_packaging.jpg',
				  'sidebar-header-images_21_pipeline_packaging.jpg',
				  'sidebar-header-images_22_pipeline_packaging.jpg',
				  'sidebar-header-images_23_pipeline_packaging.jpg',
				  'sidebar-header-images_24_pipeline_packaging.jpg',
				  'sidebar-header-images_25_pipeline_packaging.jpg',
				  'sidebar-header-images_26_pipeline_packaging.jpg',
				  'sidebar-header-images_27_pipeline_packaging.jpg',
				  'sidebar-header-images_28_pipeline_packaging.jpg',
				  'sidebar-header-images_29_pipeline_packaging.jpg',
				  'sidebar-header-images_30_pipeline_packaging.jpg',
				  'sidebar-header-images_31_pipeline_packaging.jpg',
				  'sidebar-header-images_32_pipeline_packaging.jpg',
				  'sidebar-header-images_33_pipeline_packaging.jpg',
				  'sidebar-header-images_34_pipeline_packaging.jpg'
				  ];
				  
	var domain = document.domain;
	if (domain == 'pipeline.dev' || domain == 'pipelinepackaging.com') {
		$('.column-image-header').css({'background-image': 'url(/wp-content/themes/viewportindustries-Starkers-689d7e6/_img/' + images[Math.floor(Math.random() *      images.length)] + ')'});
	} else {
		$('.column-image-header').css({'background-image': 'url(/pipeline/wp-content/themes/viewportindustries-Starkers-689d7e6/_img/' + images[Math.floor(Math.random() * images.length)] + ')'});
	}
	
});