jQuery(document).ready(function ($) {
  // setting patches shapes and colors

  jQuery(".active_swatch_ar").trigger("click");

  var imgsrc = jQuery(".patch-shape-colors-main")
    .find(".patch-shape-img-text:first-child")
    .find(".patch_shape_masking_ar_ar")
    .css("mask-image");
  var shapname = jQuery(".patch-shape-colors-main")
    .find(".patch-shape-img-text:first-child")
    .find("p")
    .text();
  var bgsrc = jQuery(".patch-shape-colors-main")
    .find(".patch_colors_selection_list_ar")
    .find(".swatch_ar:first-child")
    .attr("attr-name");
  var selectname = jQuery(".patch-shape-colors-main")
    .find(".patch_colors_selection_list_ar")
    .find(".swatch_ar:first-child")
    .attr("attr-name");
  jQuery(".patch_colors_selection_ar")
    .find(".selcted_shape_ar_ar")
    .text(shapname);
  jQuery(".patch_colors_selection_ar")
    .find(".selected_shaped_color_rect")
    .css("mask-image", imgsrc);
  jQuery(".patch_colors_selection_ar")
    .find(".selected_shaped_color_rect")
    .css("background-color", bgsrc);
  jQuery(".patch_colors_selection_ar")
    .find(".selcted_color_ar_ar")
    .text(selectname);
  jQuery(".patch-shape-colors-main")
    .find(".patch_colors_selection_list_ar")
    .find(".swatch_ar:first-child")
    .addClass("active_shapes_wraper");
  jQuery(".patch-shape-colors-main")
    .find(".patch-shape-img-text:first-child")
    .find("img")
    .addClass("active_shapes_wraper");

  if (
    jQuery(".allprintareas > .addlogo_colum")
      .find(".printarea")
      .find("option[value='front']").length > 0
  ) {
    jQuery(".allprintareas > .addlogo_colum").find(".printarea").val("front");
    jQuery(".allprintareas > .addlogo_colum")
      .find(".printarea")
      .attr("disabled", true);
    jQuery(".allprintareas > .addlogo_colum")
      .find(".printcolors")
      .attr("disabled", true);
  }

  localStorage.setItem("totalquantity", 0);
  localStorage.setItem("checked_premium", false);
  localStorage.setItem("d_puff_embroidery", 0);
  jQuery(".sizes_ar").find("input[type='number']").val(0);
  if (jQuery("#price_calculator_ar_ar").length <= 0) {
    jQuery("#freeartworksetup_ar_ar").find("h2").text("0$");
  }
});
