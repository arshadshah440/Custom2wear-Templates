jQuery(document).ready(function ($) {
  jQuery("#filters_wrapper_ar").on(
    "click",
    'input[type="checkbox"]',
    function () {
      filter_products(false);
    }
  );
  jQuery("#filters_wrapper_ar").on(
    "click",
    '#price_wrapper_ar input[type="range"]',
    function () {
      filter_products(false);
    }
  );
  jQuery("#sort_by_terms_ar").on("change", function () {
    filter_products(false);
  });
  jQuery("#rsults_controller_ar").on("change", function () {
    filter_products(false);
  });
  jQuery("#load_more_ar").on("click", function () {
    filter_products(true);
  });
  jQuery("#list_ar").on("click", function () {
    jQuery("#products_wrapper_ar")
      .find(".inner_pro_wraper_ar")
      .css("grid-template-columns", "repeat(1, 1fr)");
  });
  jQuery("#grid_ar").on("click", function () {
    jQuery("#products_wrapper_ar")
      .find(".inner_pro_wraper_ar")
      .css("grid-template-columns", "repeat(3, 1fr)");
  });
});

function selectedcategpries() {
  var $categarr = [];
  jQuery("#categories_wrapper_ar")
    .find("input[type='checkbox']:checked")
    .each(function () {
      $categarr.push(jQuery(this).val());
    });
  return $categarr;
}

function selectedcolors() {
  var $categarr = [];
  jQuery("#color_wrapper_ar")
    .find("input[type='checkbox']:checked")
    .each(function () {
      $categarr.push(jQuery(this).val());
    });
  return $categarr;
}

function selectedsizes() {
  var $categarr = [];
  jQuery("#size_wrapper_ar")
    .find("input[type='checkbox']:checked")
    .each(function () {
      $categarr.push(jQuery(this).val());
    });
  return $categarr;
}

function filter_products($loadmore) {
  var selectedcat = selectedcategpries();
  var color = selectedcolors();
  var size = selectedsizes();
  var pagination = jQuery("#rsults_controller_ar").val();
  var minprice = jQuery("#min-price").val();
  var maxprice = jQuery("#max-price").val();
  var sorting = jQuery("#sort_by_terms_ar").val();
  
  var selectedfilterlengh=selectedcat.length+color.length+size.length;
  if(selectedfilterlengh>0){
    jQuery("#selected_filter_numbers_ar").find("h6").text(selectedfilterlengh);
  }else{
    jQuery("#selected_filter_numbers_ar").find("h6").text("0");
  }
  
  var currentpage = $loadmore ? jQuery("#load_more_ar").attr("currentpage") : 2;

  var currentarch = jQuery("#products_wrapper_ar").attr("currentarc");
  jQuery.ajax({
    type: "POST",
    url: "/wp-admin/admin-ajax.php",
    data: {
      action: "filter_products",
      selectedcat: selectedcat,
      color: color,
      size: size,
      minprice: minprice,
      maxprice: maxprice,
      paged: pagination,
      sorting: sorting,
      currentpage: currentpage,
      currentarch: currentarch,
    },
    beforeSend: function () {
      // Optional: Show a loader or disable form inputs
      jQuery("#loader_ar").show();
      if ($loadmore) {
        jQuery("#products_wrapper_ar").find(".inner_pro_wraper_ar").show();
      } else {
        jQuery("#products_wrapper_ar").find(".inner_pro_wraper_ar").hide();
      }
    },
    success: function (response) {
      if (response.success) {
        if ($loadmore) {
          jQuery("#products_wrapper_ar")
            .find(".inner_pro_wraper_ar")
            .append(response.data.products);
        } else {
          jQuery("#products_wrapper_ar")
            .find(".inner_pro_wraper_ar")
            .html(response.data.products);
        }

        jQuery("#loader_ar").hide();
        jQuery("#products_wrapper_ar")
          .find(".inner_pro_wraper_ar")
          .css("display", "grid");

        if (response.data.total_pages > parseInt(currentpage)) {
          jQuery("#load_more_ar").show();
          if($loadmore){
            jQuery("#load_more_ar").attr(
                "currentpage",
                parseInt(currentpage) + 1
              );
          }
        } else {
          jQuery("#load_more_ar").hide();

          jQuery("#load_more_ar").attr("currentpage", 1);
        }
        jQuery("#show_counter_ar").text("" + pagination + " of " + response.data.total_posts);
      } else {
        jQuery("#products_wrapper_ar")
          .find(".inner_pro_wraper_ar")
          .html(
            "<p class='text_dark_ar font_14_400'>" + response.data + "</p>"
          );
        jQuery("#loader_ar").hide();
        jQuery("#load_more_ar").hide();
      }
    },
    error: function (data) {
      console.log(data);
    },
  });
}
