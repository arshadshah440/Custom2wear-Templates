var city = jQuery("#billing_city_field");
var state = jQuery("#billing_state_field");
var postcode = jQuery("#billing_postcode_field");
var phone = jQuery("#billing_phone_field");

setTimeout(function () {
  jQuery(
    "<div class='checkout_grid_ar' id='checkout_grid_ar'></div>"
  ).insertBefore("#billing_city_field");
  jQuery("#checkout_grid_ar").append(city);
  jQuery("#checkout_grid_ar").append(state);
  jQuery("#checkout_grid_ar").append(postcode);
  jQuery("#checkout_grid_ar").append(phone);
}, 2000);

/*********************************** handle patch shape and colors input ***********/
jQuery(".allprintareas").on(
  "click",
  ".patch_colors_selection_ar",
  function (e) {
    jQuery(this).siblings(".patch-shape-colors-main").toggle();
  }
);

/******************************** handle the patch size and colors selections */

jQuery(".allprintareas").on(
  "click",
  ".patch-shape-colors-main .patch-shape-img-text",
  function () {
    var imgsrc = jQuery(this)
      .find(".patch_shape_masking_ar_ar")
      .css("mask-image");
    var shapename = jQuery(this).find("p").text();
    jQuery(this)
      .closest(".sizes_quantity")
      .find(".selcted_shape_ar_ar")
      .text(shapename);
    jQuery(this)
      .closest(".sizes_quantity")
      .find(".selected_shaped_color_rect")
      .css("mask-image", imgsrc);
    var bgsrc = jQuery(this)
      .closest(".sizes_quantity")
      .find(".patch_colors_selection_list_ar")
      .find(".active_shapes_wraper")
      .css("background-image");
    var colorname = jQuery(this)
      .closest(".sizes_quantity")
      .find(".patch_colors_selection_list_ar")
      .find(".active_shapes_wraper")
      .attr("attr-name");
    jQuery(this)
      .closest(".sizes_quantity")
      .find(".selected_shaped_color_rect")
      .css("background-image", bgsrc);
    jQuery(this)
      .closest(".sizes_quantity")
      .find(".selcted_color_ar_ar")
      .text(colorname);
    jQuery(".patch-shape-img-text").removeClass("active_shapes_wraper");
    jQuery(this).addClass("active_shapes_wraper");
    jQuery(this)
      .closest(".sizes_quantity")
      .find("input[type='text']")
      .val(`${colorname} | ${shapename}`);
  }
);

jQuery(".allprintareas").on(
  "click",
  ".patch_colors_selection_list_ar .swatch_ar",
  function () {
    var imgsrc = jQuery(this)
      .closest(".sizes_quantity")
      .find(".patch-shape-img-text.active_shapes_wraper")
      .find(".patch_shape_masking_ar_ar")
      .css("mask-image");
    var shapename = jQuery(this)
      .closest(".sizes_quantity")
      .find(".patch-shape-img-text.active_shapes_wraper")
      .find("p")
      .text();
    jQuery(this)
      .closest(".sizes_quantity")
      .find(".selcted_shape_ar_ar")
      .text(shapename);
    jQuery(this)
      .closest(".sizes_quantity")
      .find(".selected_shaped_color_rect")
      .css("mask-image", imgsrc);
    var bgsrc = jQuery(this).css("background-image");
    jQuery(this)
      .closest(".sizes_quantity")
      .find(".patch-shape-img-text")
      .find(".patch_shape_masking_ar_ar")
      .css("background-image", bgsrc);
    var coloname = jQuery(this).attr("attr-name");
    jQuery(this)
      .closest(".sizes_quantity")
      .find(".selected_shaped_color_rect")
      .css("background-image", bgsrc);
    jQuery(this)
      .closest(".sizes_quantity")
      .find(".selcted_color_ar_ar")
      .text(coloname);
    jQuery(".patch_colors_selection_list_ar")
      .find(".swatch_ar")
      .removeClass("active_shapes_wraper");
    jQuery(this).addClass("active_shapes_wraper");
    jQuery(this)
      .closest(".sizes_quantity")
      .find("input[type='text']")
      .val(`${coloname} | ${shapename}`);
  }
);

jQuery("body").on("click", function (e) {
  if (
    e.target.className !== "patch-shape-colors-main" &&
    e.target.className !== "patch_colors_selection_ar" &&
    e.target.closest(".patch_colors_selection_ar") == null &&
    e.target.closest(".patch-shape-colors-main") == null
  ) {
    jQuery(".patch-shape-colors-main").hide();
  }
  if (e.target.closest(".custom_dropdown_wrapper_ar_ar") == null) {
    jQuery(".custom_options_ar").hide();
  }
});
