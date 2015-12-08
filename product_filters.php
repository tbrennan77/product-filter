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

function dropdown_product_filter_contraints() {
  $filter_attributes = array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'product_type', 'fittings', 'gauge', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length'); 
	$filter = "";
	foreach ($filter_attributes as &$attribute) {
		if (isset($_POST[$attribute]) && $_POST[$attribute] != '') {
	    $filter .= sprintf("AND $attribute LIKE '%s' ", mysql_real_escape_string($_POST[$attribute]));
	  }
	}
  return $filter;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $uri = parse_url($_SERVER['HTTP_REFERER']);
  $filter_attributes = filter_attributes_from($uri['path']);
} else {
  $filter_attributes = filter_attributes_from($_SERVER["REQUEST_URI"]);  
}

$productLineId = isset($_POST['productLineId']) ? $_POST['productLineId'] : product_line_id_from($_SERVER["REQUEST_URI"]);
$query         = dropdown_product_filter_contraints();
?>

<h3 class='widget-title'>Refine Product Search</h3>
<div>
	<b><label for='show_product_id'>Product ID</label></b>
	<span class='clearfix'>
		<input type='text' style='width:90%' name='show_product' id='show_product_id' placeholder='e.g. 1346' />
		<a class='showProductLink'>Find Product</a>
	</span>
</div>

<hr />

<form class='customSearch' action='create_filter_dropdown' method='post'>
	<input type='hidden' id='productLine' name='productLineId' value='<?= $productLineId ?>' />
	<div id='prod_collection' style='display: block;'>
	<?php 
		foreach ($filter_attributes as &$attribute) { 
			$attr_query = mysql_query(sprintf("SELECT DISTINCT($attribute) FROM products WHERE product_line_id = %s AND $attribute != 'NULL' $query ORDER BY $attribute", mysql_real_escape_string($productLineId)));
			if (mysql_num_rows($attr_query) > 0) {
	?>
		<div class='select-filter-container'>
			<label><?= dropdown_formatted_attribute($attribute) ?></label>
			<span class='clearfix'>
				<select class='filter-select' name='<?= $attribute ?>'>
					<option value=''></option>
					<?php while($row_stock = mysql_fetch_array($attr_query)) { ?>						
						<option <?php if($row_stock[$attribute] == stripslashes($_POST[$attribute])) { echo "selected='selected'"; } ?>
							value='<?= $row_stock[$attribute] ?>'>
							<?= $row_stock[$attribute] ?>
						</option>
					<?php } ?>
				</select>
				<a href='#' class='resetLinker' onclick="reset_my('<?= $attribute ?>'); return false;">Reset</a>
			</span>
		</div>
	<?php } } ?>
		<a href='#' onclick='jQuery("form.customSearch").clearForm(); jQuery("form.customSearch select").trigger("change");return false;'>START OVER</a>
	</div>
	<div class='divider'></div>
</form>
