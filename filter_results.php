<?php
session_start();

function in_briefcase($product_id) {
	$briefcase_ids = $_SESSION['briefcase'];
	if (in_array($product_id, $briefcase_ids)) {
		return true;
  } else {
    return false;
  }
}

function product_line_id($name) {
	switch ($name) {   
    case "bottles":
      return 1;   
    case "cans":
      return 2;
    case "closing-tools":
      return 3;
    case "closures":
      return 4;
    case "drums-and-totes":
      return 5;
    case "liners":
      return 6;
    case "pails-and-tubs":
      return 7;
    case "tubes":
      return 8;
		default:
			return 1; 
	}
}

function product_table_header($product_line_id) {	
	switch ($product_line_id) {
		case 1:
		  return "<th>Capacity</th><th>Material</th><th colspan='2'>Style</th><th>Color</th><th>Finish</th><th>Shape</th><th>Type</th>";
		case 2:
			return "<th>Capacity</th><th>Material</th><th colspan='2'>Style</th><th>Shape</th><th>Finish</th><th>Lining</th>";
		case 3:
			return "<th colspan='4'>Material</th><th>Fittings</th>";
		case 4:
			return "<th>Material</th><th>Style</th><th>Color</th><th>Lining</th><th>Finish</th><th>Type</th>";
		case 5:
			return "<th>Capacity</th><th>Material</th><th colspan='2'>Style</th><th>Color</th><th>Linings</th><th>Fittings</th>";
		case 6:
			return "<th colspan='2'>Capacity</th><th colspan='2'>Material</th><th>Type</th><th>Thickness</th><th>Pleated</th><th>Anti-static</th>";
		case 7:
			return "<th>Capacity</th><th>Gauge</th><th>UN</th><th colspan='2'>Lining</th>";
		case 8:
			return "<th colspan='2'>Material</th><th colspan='3'>Finish</th><th>Diameter</th><th>Min-length</th><th>Max-length</th>";
		default:
			return "";
	}
}

function product_detail_rows($product_row) {		
	switch ($product_row['product_line_id']) {
		case 1:
		  return "<td>".$product_row['capacity']."</td><td>".$product_row['material']."</td><td colspan='2'>".$product_row['style']."</td><td>".$product_row['color']."</td><td>".$product_row['finish']."</td><td>".$product_row['shape']."</td><td>".$product_row['product_type']."</td>";
		case 2:
			return "<td>".$product_row['capacity']."</td><td>".$product_row['material']."</td><td colspan='2'>".$product_row['style']."</td><td>".$product_row['shape']."</td><td>".$product_row['finish']."</td><td>".$product_row['lining']."</td>";
		case 3:
			return "<td colspan='4'>".$product_row['material']."</td><td>".$product_row['fittings']."</td>";
		case 4:
			return "<td>".$product_row['material']."</td><td>".$product_row['style']."</td><td>".$product_row['color']."</td><td>".$product_row['lining']."</td><td>".$product_row['finish']."</td><td>".$product_row['product_type']."</td>";
		case 5:
			return "<td>".$product_row['capacity']."</td><td>".$product_row['material']."</td><td colspan='2'>".$product_row['style']."</td><td>".$product_row['color']."</td><td>".$product_row['lining']."</td><td>".$product_row['fittings']."</td>";
		case 6:
			return "<td colspan='2'>".$product_row['capacity']."</td><td colspan='2'>".$product_row['material']."</td><td>".$product_row['product_type']."</td><td>".$product_row['thickness']."</td><td>".$product_row['pleated']."</td><td>".$product_row['anti_state']."</td>";
		case 7:
			return "<td>".$product_row['capacity']."</td><td>".$product_row['gauge']."</td><td>".$product_row['un']."</td><td colspan='2'>".$product_row['lining']."</td>";
		case 8:
			return "<td colspan='2'>".$product_row['material']."</td><td colspan='3'>".$product_row['finish']."</td><td>".$product_row['diameter']."</td><td>".$product_row['min_length']."</td><td>".$product_row['max_length']."</td>";
		default:
			return "";
	}
}

function product_attributes() {
	return array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'product_type', 'fittings', 'gauge', 'comments', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length', 'product_attributes');
}

function product_image_url($product_line_id, $image_name) {
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

function formatted_attribute($attribute) {
	$pretty_word = str_replace('product_type', 'type', $attribute);
	$pretty_word = str_replace('anti_state', 'anti_static', $pretty_word);
	$pretty_word = str_replace('_', '-', $pretty_word);
	$pretty_word = ucwords($pretty_word);
	$pretty_word = str_replace('Un', 'UN', $pretty_word);
	$pretty_word = str_replace('Product-attributes', 'Attributes', $pretty_word);
	return $pretty_word;
}

function closure_text($product_row) {
	$default_text = "Due to the large variety available, this package does <b>not</b> come with a closure."
			. "Please add this product to your Briefcase and then visit "
			. "<a href='/products/closures'>Closures</a> to find an appropriate choice.";

	return ($product_row['closures'] == 'NULL' || $product_row['closures'] == '') ? $default_text : $product_row['closures'];
}

function product_filter_contraints() {
  $filter_attributes = array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'product_type', 'fittings', 'gauge', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length'); 
	$filter = "";
	foreach ($filter_attributes as &$attribute) {
		if (isset($_POST[$attribute]) && $_POST[$attribute] != '') {
	    $filter .= sprintf("AND $attribute LIKE '%s' ", mysql_real_escape_string($_POST[$attribute]));
	  }
	}
  return $filter;
}

$productLineId  = isset($atts['line']) ? product_line_id($atts['line']) : $_POST['productLineId'];
$product_filter = product_filter_contraints();
$results_total  = mysql_num_rows(mysql_query(sprintf("SELECT 1 FROM products where product_line_id = %s ", $productLineId).$product_filter));
$display_total  = ($results_total >= 50) ? 50 : $results_total;
$product_query  = mysql_query(sprintf("SELECT *, products.id AS product_id FROM products JOIN product_lines ON product_lines.id=products.product_line_id WHERE product_line_id = %s ", $productLineId).$product_filter." LIMIT 50");
?>

<div id='pTable'>
	<div class='divider'></div>
	<h3 class='product_count' style='text-align:center;'>Showing <?= $display_total ?> of <?= $results_total ?> products. Use the filter to see additional products.</h3>
	<table class='product-filter-table span_16'>
		<thead>
			<tr>
				<th class='thumbnail-cell'>Thumbnail</th>
				<?= product_table_header($productLineId) ?>
				<th class='more-info-cell'>Details</th>
				<th class='add-to-briefcase-cell'>Add to Briefcase</th>
			</tr>
		</thead>
		<tbody>
		<?php if ($display_total == 0) { ?> 
	    <tr>
	    	<td colspan='8' align='center'><h2>There were no results.</h2></td>
	    </tr>
		<?php } ?>
	  <?php if ($display_total > 0) {
			while($product_row = mysql_fetch_array($product_query)) {
	  		$pid = $product_row['product_id'];
	  		$image_url = product_image_url($product_row['product_line_id'], $product_row['image_name']);
		?>
			<tr>
				<td class='thumbnail-cell'><img src='<?= $image_url ?>' /></td>
				<?= product_detail_rows($product_row) ?>
				<td class='more-info-cell'>
					<a href='#' class='button-link orange' onclick='jQuery(this).parent().parent().next("tr").fadeIn();return false;'>Details</a>
				</td>
				<td class='add-to-briefcase-cell'>
					<?php if (in_briefcase($pid)) { ?>
						<a href='#' id='bl<?= $pid ?>' onclick='remove_product_from_briefcase(<?= $pid ?>); return false;' class='button-link red'>Remove</a>
					<?php } else { ?>
						<a href='#' id='bl<?= $pid ?>' onclick='add_product_to_briefcase(<?= $pid ?>); return false;' class='button-link yellow'>Add</a>
					<?php } ?>
				</td>
			</tr>
			<tr class='modalShow' style='display: none;'>
				<td colspan='11' class='product-filter-item-detail'>
					<table class='span_16 col detail-actions-list-container'>
						<tr>
							<?php if (in_briefcase($pid)) { ?>
								<td>
									<a href='#' id='b<?= $pid ?>' onclick='remove_product_from_briefcase(<?= $pid ?>); return false;'>
										<span class='icon-span my-briefcase'>
											<i class='icon-trash icon-large'></i>
										</span>
										Remove from my briefcase
									</a>
								</td>
							<?php } else { ?>
								<td>
									<a href='#' id='b<?= $pid ?>' onclick='add_product_to_briefcase(<?= $pid ?>); return false;'>
										<span class='icon-span my-briefcase'>
											<i class='icon-briefcase icon-large'></i>
										</span>
										Add to my briefcase
									</a>
								</td>
							<?php } ?>
							<td><a href='/who-we-are/territory-map/'><span class='icon-span see-locations'><i class='icon-map-marker icon-large'></i></span>Find a customer service representative</a></td>
							<td><span class='icon-span phone'><i class='icon-phone icon-large'></i></span><span class='text-span'>Call for availability - 1.877.242.1880</span></td>
							<td valign='middle' class='close-cell'><a href='#' class='close-link' onclick='jQuery(this).parent().parent().parent().parent().parent().parent().fadeOut(); return false;'><span class='icon-span close'><i class='icon-remove'></i></span>Close</a></td>
						</tr>
					</table>
					<span class='span_6 col detail-img'><img src='<?= $image_url ?>' />
					<p class="wp-caption-text"><strong>Disclaimer:</strong> Product photos are general in nature due to the large number of packaging variables. Specific details (i.e. color, fittings, etc.) may not be represented. Please ask us about sending samples.</p>
					</span>
					<span class='span_10 col detail-product'>
						<table class='moreInfo'>
							<tr>
								<td class='span_4'><b>Product ID:</b></td>
								<td class='span_12'><?= $pid ?></td>
							</tr>
							<tr>
								<td class='span_4'><b>Product Line:</b></td>
								<td class='span_12'><?= $product_row['name'] ?></td>
							</tr>
							<?php 
							$attributes = product_attributes();
							foreach ($attributes as &$attribute) { 
								if ($product_row[$attribute] != '') {
							?>							
							<tr>
								<td><b><?= formatted_attribute($attribute) ?>:</b></td>
								<td><?= $product_row[$attribute] ?></td>
							</tr>
							<? } } ?>
							<?php if (!in_array($productLineId, array(3,4,6))) { ?>
	            <tr>
	              <td><b>Closures:</b></td>
	              <td class='closure_text'><?= closure_text($product_row) ?></td>
	            </tr>
	            <? } ?>      
						</table>
						<p class='view-your-briefcase'>
		          <a href='/products/my-briefcase' class='button-link yellow'>View Your Briefcase</a>
	            <a href='javascript:window.print();' class='button-link orange' style='margin-right: 1rem;'>Print</a>
	          </p>
					</span>
				</td>
			</tr>
		<?php } } ?> 
		</tbody>
	</table>
</div>
<style>
	@media print {		
		.closure_text a:link:after, .closure_text a:visited:after { content:''; }
		
		header, footer, div.content *:not(#myBriefcase):not(#pTable):not(#emailBriefcase):not(.product-filter-table):not(tbody):not(.modalShow):not(.product-filter-item-detail), #sidebar-container, #product-filter-mobile, .view-your-briefcase, .content-image-header, #sthoverbuttons, .container-col1 > h1, .product-filter-table > thead, .product-filter-table tbody > tr:not(.modalShow), .view-your-briefcase {			
			display: none;
		} 
		.moreInfo tbody tr {
			display:table !important;
			width: 100%;
		} 
		.moreInfo tbody tr td {
			width: 50% !important;
		}
		div#content-container {
			width: 100%
		}
		.print_logo img {
			max-width: 30% !important
		}
		img {
			max-width: 100% !important;
		}
		.moreInfo tbody tr, .product-filter-item-detail span, .product-filter-item-detail span *:not(.view-your-briefcase) {
			display:table !important;
		}		
		.product-filter-item-detail span .moreInfo tbody tr td {
			display: table-cell !important;
		}
		.container-col1.clearfix {
			margin-top: 0px;
		}
		.moreInfo tbody {
			width:100%;
		}  
	}	
</style>
