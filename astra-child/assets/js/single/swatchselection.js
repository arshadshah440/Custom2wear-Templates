jQuery(document).ready(function ($) {
  /****************************** singple product page color swatches selections ******************************/

  jQuery(".swatches_ar").on("click", ".swatch_ar", function (e) {
    e.preventDefault();
    jQuery(".swatch_ar").removeClass("active_swatch_ar");
    jQuery(this).addClass("active_swatch_ar");
    var value = jQuery(this).attr("attr-name");
    var colortext = jQuery(this).siblings("span").text();
    jQuery("#color_selector_wrap_ar").text(`(${colortext})`);
    var pid = jQuery(this).attr("pid");

    if (
      jQuery("#pr_image_vslider").find("div[color_attr=" + value + "]").length >
      0
    ) {
      jQuery("#pr_image_vslider")
        .find('div[color_attr="' + value + '"]:first')
        .trigger("click");
    }
  });
  jQuery("#pr_image_vslider").on("click", ".slick-slide", function (e) {
    var ccurl = jQuery(this).find("img").attr("src");
    var scrcurl = jQuery(this).find("img").attr("srcset");
    jQuery("#product_main_image_ae").find("img").attr("src", ccurl);
    jQuery("#product_main_image_ae").find("img").attr("srcset", scrcurl);
  });
});
