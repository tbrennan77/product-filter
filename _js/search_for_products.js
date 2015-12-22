jQuery(document).ready(function() {
  function findProducts(dataString) {
    jQuery.ajaxSetup({
      beforeSend: function() {
        jQuery("#ajax_working").fadeIn();
        jQuery("#pTable tbody").fadeOut("fast");
      },
      complete: function(){
        jQuery("#pTable tbody").fadeIn("slow");
        jQuery("#ajax_working").delay(300).fadeOut();
      },
      success: function(data, textStatus, XMLHttpRequest){
        var orig = jQuery("#pTable")
        var cont = orig.parent();
        orig.remove();
        cont.append(data.slice(0, -1));
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        alert(errorThrown);
      }
    });

    jQuery.post('/wp-admin/admin-ajax.php', dataString)
  }

   function create_filter_dropdowns(dataString) {
    jQuery.ajaxSetup({      
      success: function(data, textStatus, XMLHttpRequest){
        jQuery("#product-filter-container").html('');
        jQuery("#product-filter-mobile").html('');
        jQuery("#product-filter-container").append(data.slice(0, -1));
        jQuery("#product-filter-mobile").append(data.slice(0, -1));
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
        alert(errorThrown);
      }           
    });

    jQuery.post('/wp-admin/admin-ajax.php', dataString)              
  }

  jQuery.fn.clearForm = function() {
    return this.each(function() {
    var type = this.type, tag = this.tagName.toLowerCase();
    if (tag == 'form')
      return jQuery(':input',this).clearForm();
    if (type == 'text' || type == 'password' || tag == 'textarea')
      this.value = '';
    else if (type == 'checkbox' || type == 'radio')
      this.checked = false;
    else if (tag == 'select')
      this.selectedIndex = -1;
    });
  };

  jQuery("select").live("change", function(){  
    findProducts("action=search_for_products&"+jQuery(this).closest('form.customSearch').serialize());
    //create_filter_dropdowns("action=create_filter_dropdown&"+jQuery(this).closest('form.customSearch').serialize());
  });

  jQuery("a.resetLinker").live("click", function() {
    findProducts("action=search_for_products&"+jQuery(this).closest('form.customSearch').serialize());
    create_filter_dropdowns("action=create_filter_dropdown&"+jQuery(this).closest('form.customSearch').serialize());
  });
});
