<?php
function product_line_id_from($url) {
  switch($url) {    
  	case "/products/bottles-cubitainers-and-jars/":
  	  $product_line_id = 1;
      break;
  	case "/products/cans/":
  	  $product_line_id = 2;
      break;
  	case "/products/closing-tools/":
  	  $product_line_id = 3;
      break;
  	case "/products/closures/":
  	  $product_line_id = 4;
      break;
  	case "/products/drums-and-totes/":
  	  $product_line_id = 5;
      break;
  	case "/products/liners/":
  	  $product_line_id = 6;
      break;
  	case "/products/pails-and-tubs/":
  	  $product_line_id = 7;
      break;
  	case "/products/tubes/":
      $product_line_id = 8;
      break;
    default:
  	  $product_line_id = 1;
  }
	return $product_line_id;
}

/* Client wants specific attribute ordering for product lines */
function filter_attributes_from($url) {
  switch($url) {
    case "/products/bottles-cubitainers-and-jars/":
      $attrs = array(
                'product_type',
                'style',
                'capacity',
                'material',
                'shape',
                'color',
                'un',
                'finish',
                'lining'
             );
      break;
    case "/products/cans/":
      $attrs = array(
                'product_type',
				'style',
                'capacity',
                'material',
                'shape',
                'un',
                'finish',
                'lining'              
             );
      break;
    case "/products/closing-tools/":
      $attrs = array(
                'material',
                'fittings'
             );
      break;
    case "/products/closures/":
      $attrs = array(
                'product_type',
                'style',
                'material',
                'color',
                'finish',
                'lining'
             );
      break;
    case "/products/drums-and-totes/":
      $attrs = array(
                'product_type',
                'style',
                'capacity',
                'material',
                'color',
                'un',
                'lining',
                'fittings'
             );
      break;
    case "/products/liners/":
      $attrs = array(
                'style',
                'capacity',
                'material',
                'thickness',
                'pleated',
                'anti_state'
             );
      break;
    case "/products/pails-and-tubs/":
      $attrs = array(
                'product_type',
                'style',
                'capacity',
                'material',
                'gauge',
                'shape',
                'color',
                'un',
                'finish',
                'lining',
                'fittings'
             );
      break;
    case "/products/tubes/":
      $attrs = array(
                'material',
                'diameter', 
                'min_length',
                'max_length',
                'finish'              
             );
      break;
    default:
      $attrs = array(
        'finish',
        'shape',
        'color',
        'capacity',
        'material',
        'style',
        'un',
        'lining',
        'product_type',
        'fittings',
        'gauge',
        'thickness',
        'pleated',
        'anti_state',    
        'diameter', 
        'min_length',
        'max_length'
      ); 
  }
  return $attrs;
}

function dropdown_formatted_attribute($attribute) {
	$pretty_word = str_replace('product_type', 'type', $attribute);
	$pretty_word = str_replace('anti_state', 'anti_static', $pretty_word);
	$pretty_word = str_replace('_', '-', $pretty_word);
	$pretty_word = ucwords($pretty_word);
	$pretty_word = str_replace('Un', 'UN', $pretty_word);
	$pretty_word = str_replace('Product-attributes', 'Attributes', $pretty_word);
	return $pretty_word;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $uri = parse_url($_SERVER['HTTP_REFERER']);
  $filter_attributes = filter_attributes_from($uri['path']);
} else {
  $filter_attributes = filter_attributes_from($_SERVER["REQUEST_URI"]);  
}

$productLineId = isset($_POST['productLineId']) ? $_POST['productLineId'] : product_line_id_from($_SERVER["REQUEST_URI"]);
?>

<h3 class='widget-title'>Refine Product Search</h3>
<div>
	<b><label for='show_product_id'>Product ID</label></b>
	<span class='clearfix'>
		<input type='text' style='width:50%' name='show_product' id='show_product_id' placeholder='e.g. 1346' />
		<a class='showProductLink'>Find Product</a>
	</span>
</div>

<hr />

