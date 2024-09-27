jQuery(document).ready(function ($) {
  // setting patches shapes and colors
  jQuery(".allprintareas").on("click", ".custom_dropdown_ar_ar", function (e) {
    e.preventDefault();
    jQuery(".custom_options_ar").hide();
    jQuery(this).siblings(".custom_options_ar").toggle();
    jQuery(".custom_dropdown_wrapper_ar_ar").removeClass(
      "z_index_tooltip_cc_ar"
    );
    jQuery(this)
      .closest(".custom_dropdown_wrapper_ar_ar")
      .addClass("z_index_tooltip_cc_ar");
  });

  jQuery(".allprintareas").on("click", ".custom_options_ar h6", function (e) {
    e.preventDefault();
    var values = jQuery(this).attr("values");
    var text = jQuery(this).text();
    jQuery(this)
      .closest(".custom_dropdown_wrapper_ar_ar")
      .find(".custom_dropdown_ar_ar h6")
      .text(text);
    jQuery(this)
      .closest(".custom_dropdown_wrapper_ar_ar")
      .find("select")
      .val(values)
      .change();
    jQuery(this).closest(".custom_options_ar").hide();
  });
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

  sessionStorage.setItem("totalquantity", 0);
  sessionStorage.setItem("premium_artwork", "");
  sessionStorage.setItem("d_puff_embroidery", 0);
  jQuery(".sizes_ar").find("input[type='number']").val(0);
  if (jQuery("#price_calculator_ar_ar").length <= 0) {
    jQuery("#freeartworksetup_ar_ar").find("h2").text("0$");
  }
  if (jQuery(".first_print_types_ar").length > 0) {
    var defaultprtint = jQuery(".first_print_types_wrapper_ar").attr(
      "defaultval"
    );
    if (
      defaultprtint == "" ||
      defaultprtint == null ||
      defaultprtint == undefined
    ) {
      jQuery(".first_print_types_ar").find("h6:first-child").trigger("click");
      var firsttype = jQuery(".first_print_types_ar")
        .find("h6:first-child")
        .attr("values");
      localStorage.setItem("pptype", firsttype);
    } else {
      jQuery(".first_print_types_ar")
        .find(`h6[values='${defaultprtint}']`)
        .trigger("click");
      localStorage.setItem("pptype", defaultprtint);
    }
  }

  // default values for the print area
  if (jQuery(".first_print_areas_wrapper_ar").length > 0) {
    var defaultarea = jQuery(".first_print_areas_wrapper_ar")
      .find("select")
      .attr("current-cat");
    if (defaultarea == "" || defaultarea == null || defaultarea == undefined) {
      jQuery(".first_print_areas_wrapper_ar")
        .find(".custom_options_ar")
        .find("h6:first-child")
        .trigger("click");
    } else {
      if (
        jQuery(".first_print_areas_wrapper_ar").find(`h6[values='front']`)
          .length > 0
      ) {
        jQuery(".first_print_areas_wrapper_ar")
          .find(`h6[values='front']`)
          .trigger("click");
      }
    }
  }
});
