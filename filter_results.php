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

  /* Client wants specific attribute ordering for product lines */
  function filter_attributes($product_line_id) {
    switch($product_line_id) {
      case 1:
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
      case 2:
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
      case 3:
        $attrs = array(
                  'material',
                  'fittings'
               );
        break;
      case 4:
        $attrs = array(
                  'product_type',
                  'style',
                  'material',
                  'color',
                  'finish',
                  'lining'
               );
        break;
      case 5:
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
      case 6:
        $attrs = array(
                  'style',
                  'capacity',
                  'material',
                  'thickness',
                  'pleated',
                  'anti_state'
               );
        break;
      case 7:
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
      case 8:
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

  function fetch($array, $key, $default) {
    if (trim($array->$key) !== '') {
      return $array->$key;
    } else {
      return $default;
    }
  }

  function product_row($product) {
    $id       = $product->product_line_id;
    $attrs    = filter_attributes($id);
    $row_html = "";

    foreach ($attrs as &$attribute) {
      $row_html .= "<td>";
      $row_html .= fetch($product, $attribute, '-');
      $row_html .= "</td>";
    }
    return $row_html;
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

    return ($product_row->closures == 'NULL' || $product_row->closures == '') ? $default_text : $product_row->closures;
  }

  function product_filter_constraints() {
    $filter_attributes = array('finish', 'shape', 'color', 'capacity', 'material', 'style', 'un', 'lining', 'product_type', 'fittings', 'gauge', 'thickness', 'pleated', 'anti_state', 'diameter', 'min_length', 'max_length'); 
    $filter = array();
    foreach ($filter_attributes as &$attribute) {
      if (isset($_POST[$attribute]) && $_POST[$attribute] != '') {
        $filter[$attribute] = array(" AND $attribute like '%s'", $_POST[$attribute]);
      }
    }
    return $filter;
  }

  function is_selected($value, $attribute) {
    if($value == stripslashes($_POST[$attribute])) {
      return "selected='selected'";
    }
  }

  function attribute_query($product_line_id, $attribute) {
    global $wpdb;
    $filters = product_filter_constraints();

    $product_query = "
      select distinct($attribute)
      from products
      where product_line_id = %d
      and $attribute != %s";
    foreach($filters as $filter) {
      $product_query .= $filter[0];
    }
    $product_query .= " order by $attribute";

    $args = array($product_line_id, 'NULL');
    foreach($filters as $filter) {
      array_push($args, $filter[1]);
    }

    $prepared = $wpdb->prepare($product_query, $args);
    return $wpdb->get_results($prepared);
  }

  function products($product_line_id) {
    global $wpdb;
    $filters = product_filter_constraints();

    $product_query = "
      select *, products.id as product_id
      from products
      join product_lines on product_lines.id=products.product_line_id
      where product_line_id = %d";
    foreach($filters as $filter) {
      $product_query .= $filter[0];
    }
    $product_query .= " limit 50";

    $args = array($product_line_id);
    foreach($filters as $filter) {
      array_push($args, $filter[1]);
    }

    $prepared = $wpdb->prepare($product_query, $args);
    return $wpdb->get_results($prepared);
  }

  function product_count($product_line_id) {
    global $wpdb;
    $filters = product_filter_constraints();

    $product_query = "
      select count(*) as total
      from products
      where product_line_id = %d";
    foreach($filters as $filter) {
      $product_query .= $filter[0];
    }

    $args = array($product_line_id);
    foreach($filters as $filter) {
      array_push($args, $filter[1]);
    }

    $prepared = $wpdb->prepare($product_query, $args);
    return $wpdb->get_var($prepared);
  }

  function display_total($productLineId) {
    $total          = product_count($productLineId);
    $display_total  = ($total >= 50) ? 50 : $total;
    return $display_total." of ".$total;
  }

  $productLineId  = isset($atts['line']) ? product_line_id($atts['line']) : $_POST['productLineId'];
  $attrs          = filter_attributes($productLineId);
  $products       = products($productLineId);
  $display_total  = display_total($productLineId);
?>

<div id='pTable'>
  <?php ajax_filter_dropdown(); ?>
  <h3 class='product_count' style='text-align:center;'>
    Showing <?= $display_total ?> products. Use the filter to see additional products.
  </h3>
  <form class='customSearch' action='create_filter_dropdown' method='post'>
  <input type='hidden' id='productLine' name='productLineId' value='<?= $productLineId ?>' />
	<table class='product-filter-table span_16'>
		<thead>
			<tr>
				<th class='thumbnail-cell'>Thumbnail</th>
        <?php foreach ($attrs as &$attribute) { ?>
          <th>
            <?= dropdown_formatted_attribute($attribute) ?>
            <select class='filter-select' style='width:100%' name='<?= $attribute ?>'>
              <option value=''></option>
              <?php
                $attr_query = attribute_query($productLineId, $attribute);
                foreach($attr_query as $attr) {
                  $selected = is_selected($attr->$attribute, $attribute);
                  $value    = $attr->$attribute;
              ?>
              <option <?= $selected ?> value='<?= $value ?>'><?= $value ?></option>
              <?php } ?>
            </select>
          </th>
        <?php } ?>
          <th colspan='2'><a class='reset'>RESET ALL</a></th>
			</tr>
		</thead>
		<tbody>
		<?php if ($display_total == " of ") { ?> 
	    <tr>
      <td colspan='<?= count($attrs) + 3 ?>' align='center'><h2>There were no results.</h2></td>
	    </tr>
		<?php } ?>
	  <?php if ($display_total > 0) {
			foreach($products as $product) {
	  		$pid = $product->product_id;
	  		$image_url = product_image_url($product->product_line_id, $product->image_name);
		?>
			<tr>
				<td class='thumbnail-cell'><img src='<?= $image_url ?>' /></td>
				<?= product_row($product) ?>
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
								<td class='span_12'><?= $product->name ?></td>
							</tr>
							<?php 
							$attributes = product_attributes();
							foreach ($attributes as &$attribute) { 
								if ($product->$attribute != '') {
							?>							
							<tr>
								<td><b><?= formatted_attribute($attribute) ?>:</b></td>
								<td><?= $product->$attribute ?></td>
							</tr>
							<? } } ?>
							<?php if (!in_array($productLineId, array(3,4,6))) { ?>
	            <tr>
	              <td><b>Closures:</b></td>
	              <td class='closure_text'><?= closure_text($product) ?></td>
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
  </form>

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
</div>
