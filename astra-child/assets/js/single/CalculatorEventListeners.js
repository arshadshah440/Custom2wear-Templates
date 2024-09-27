jQuery(document).ready(function ($) {
  /****************************** single product custom select fields selection ******************************/

  /**
   * Event listener for changes in the quantity input fields.
   * Calls pricetablehightlight() when a change occurs in the quantity.
   */
  jQuery(".quantity_and_info_ar").on(
    "change input",
    ".sizes_quantity input[type='number']",
    function (e) {
      e.preventDefault();
      if(jQuery(this).val() == "") {
        jQuery(this).val(0);
      }
      setCalcultor();
    }
  );

  /**
   * Event listener for changes in the print type selection.
   * Calls updateColorFields() and pricetablehightlight() when the print type is changed.
   */
  jQuery(".allprintareas").on(
    "change",
    ".addlogo_colum select.printtype",
    function (e) {
      e.preventDefault();
      updateColorFields(jQuery(this).val(), jQuery(this));
      setCalcultor();
    }
  );
  jQuery(".allprintareas").on(
    "change",
    ".addlogo_colum select.printcolors",
    function (e) {
      e.preventDefault();
      setCalcultor();
    }
  );

  /**
   * Event listener for new print area row.
   * Calls updateColorFields() and pricetablehightlight() when the print type is changed.
   */
  jQuery(".addanotherone_ar").on("click", function (e) {
    handleAddAnotherOneClick(e);
    setCalcultor();
  });

  jQuery(".allprintareas").on("click", ".removerlist_ar_area", function () {
    jQuery(this).closest(".addlogo_colum").remove();
    jQuery(".addanotherone_ar").show();
    setCalcultor();
  });

  /**
   * Event listener for additional instructions.
   * show the textarea for extar instructions.
   */
  jQuery("#add_instrution_ar").on("click", function () {
    if (jQuery(this).is(":checked")) {
      jQuery("#add_instrution_ar_text").show();
    } else {
      jQuery("#add_instrution_ar_text").hide();
    }
  });
  /**
   * Event listener for 3dPufficient
   */
  jQuery("#d_puff_embroidery").on("click", function () {
    setCalcultor();
  });

  /**
   * Event listener for 3dPufficient
   */
  jQuery("#premium_artwork_ar").on("click", function () {
    if (jQuery(this).is(":checked")) {
      sessionStorage.setItem("premium_artwork", "true");
    } else {
      sessionStorage.setItem("premium_artwork", "");
    }
    setCalcultor();
  });

  /*************************************** handling the tooltips */
  jQuery("body").on("mouseenter mouseleave", ".tooltip_info_ar", function (e) {
    jQuery(this).find(".tooltip_data_ar").toggle();
    jQuery(this).toggleClass("z_index_tooltip_cc_ar");
  });

  /*************************************** handling the tooltips */
  jQuery("#single_add_to_cart_ar").on("click", function (e) {
    e.preventDefault();
    addProductToCart();
  });
});
