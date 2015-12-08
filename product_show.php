<?php
session_start();

function product_image($product_line_id, $image_name) {
	if ($image_name != NULL && $image_name != "image-coming-soon.jpg") {
	 switch ($product_line_id) {
		    case 1:
					  $product_image = '/product-images/Bottles-Jars-Cubetainers/'.$image_name;        
		        break;
		    case 2:
					  $product_image = '/product-images/Cans/'.$image_name;        
		        break;		    
				case 3:
					  $product_image = '/product-images/Closing-tools/'.$image_name;        
		        break;
				case 4:
					  $product_image = '/product-images/Closures/'.$image_name;        
		        break;
				case 5:
					  $product_image = '/product-images/Drums/'.$image_name;        
		        break;
				case 6:
					  $product_image = '/product-images/Liners/'.$image_name;        
		        break;
				case 7:
					  $product_image = '/product-images/Pails/'.$image_name;        						
		        break;				
				case 8:
					  $product_image = '/product-images/Tubes/'.$image_name;        						
		        break;
				default:
					  $product_image = '/product-images/image-coming-soon.jpg';        
			}   
	} else {
	  $product_image = '/product-images/image-coming-soon.jpg';
	}	

	return $product_image;   
}

function briefcase_link($product_id) {
	$briefcase_ids = $_SESSION['briefcase'];
	$icon = $function = $link_text = "";
	
	if (in_array($product_id, $briefcase_ids)) {		
		$function  = "remove_product_from_briefcase(\"$product_id\"); return false;";
		$link_text = "Remove from my briefcase";
		$icon      = "trash";
	} else {		
		$function  = "add_product_to_briefcase(\"$product_id\"); return false;";		
		$link_text = "Add to my briefcase";
		$icon      = "briefcase";
	}

	$briefcase_link = <<<LINK
	  <a href='#' id='b$product_id' onclick='$function'>
      <span class='icon-span my-briefcase'>
	      <i class='icon-$icon icon-large'></i>
		  </span>
		  $link_text
	  </a>
LINK;

	return $briefcase_link;
}

function pretty_attribute_label($attribute) {
	$pretty_word = str_replace('product_type', 'type', $attribute);
	$pretty_word = str_replace('anti_state', 'anti_static', $pretty_word);
	$pretty_word = str_replace('_', '-', $pretty_word);
	$pretty_word = ucwords($pretty_word);
	$pretty_word = str_replace('Un', 'UN', $pretty_word);
        $pretty_word = str_replace('Product-attributes', 'Attributes', $pretty_word);
	return $pretty_word;
}

function closure_text($product) {

	$default_text = "Due to the large variety available, this package does <b>not</b> come with a closure. 
			Please add this product to your Briefcase and then visit 
			<a href='/products/closures'>Closures</a> to find an appropriate choice.";

	return ($product->closures == 'NULL' || $product->closures == '') ? $default_text : $product->closures;
}

$product_id = (int)$_GET['id'];
$attributes = array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'product_type', 'fittings', 'gauge', 'comments', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length', 'product_attributes');

global $wpdb;
$product_results = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT products.*, product_lines.name FROM products INNER JOIN product_lines ON product_lines.id=products.product_line_id WHERE products.id = %s",
		$product_id
	));

$product = $product_results[0];
?>

<?php if (empty($product)) { ?>
	<h1>There is no product with that Id</h1>
<?php } else { ?>

<table class='span_16 col detail-actions-list-container'>
	<tr>
		<td><?= briefcase_link($product->id) ?></td>
		<td>
			<a href='/who-we-are/territory-map/'>
				<span class='icon-span see-locations'><i class='icon-map-marker icon-large'></i></span>
				Find a customer service representative
			</a>
		</td>
		<td colspan="2">
			<span class='icon-span phone'><i class='icon-phone icon-large'></i></span>
			<span class='text-span'>Call for availability - 1.877.242.1880</span>
		</td>
	</tr>
</table>

<span class='span_6 col detail-img'>
	<img src='<?= product_image($product->product_line_id, $product->image_name); ?>' / >
	<p class="wp-caption-text">
	<strong>Disclaimer:</strong> Product photos are general in nature due to the large number of packaging variables. Specific details (<i>i.e.</i> color, fittings, etc.) may not be represented. Please ask us about sending samples.
	</p>
</span>

<span class='span_10 col detail-product'>
	<table class='moreInfo product-filter-table'>
		<tr>    
			<td class='span_4'><b>Product ID:</b></td>
			<td class='span_12'><?= $product->id ?></td>
		</tr>
		<tr>
			<td class='span_4'><b>Product Line:</b></td>
			<td class='span_12'><?= $product->name ?></td>
		</tr>
<?php foreach ($attributes as $attribute) { ?>
	<?php if ($product->$attribute != '') { ?>
		<tr>
			<td><b><?= pretty_attribute_label($attribute) ?>:</b></td>
			<td><?= $product->$attribute ?></td>
		</tr>
	<?php }; ?>
<?php }; ?>
		<tr>
	    <td><b>Closures:</b></td>
	    <td><?= closure_text($product) ?></td>
		</tr>
	</table>
	<p class='view-your-briefcase'>
		<a href='/products/my-briefcase' class='button-link yellow'>View Your Briefcase</a>
		<a href='javascript:window.print();' class='button-link orange' style='margin-right: 1rem;'>Print</a>
	</p>
</span>
<?php }; ?>

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
@media print { 
	header, footer, div.content, #sidebar-container, #product-filter-mobile, .view-your-briefcase, .content-image-header, #sthoverbuttons, .container-col1 > h1, .product-filter-table > thead, table:not(.product-filter), .span_16.col.content > p {display:none;} .span_16.col.content {display:block;} .span_16.col.content span.col, .moreInfo.product-filter-table, .moreInfo tr {display:table !important;width: 100%} .moreInfo tr td {width: 50% !important;} div#content-container {width: 100%} img {max-width: 30% !important} 
	.print_logo { margin-bottom: 100px;}
}
</style>