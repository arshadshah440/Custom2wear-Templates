// global variable

localStorage.clear();

var artsetupfreeze = jQuery("#freeitemsrequir_ar").attr("valueprice");

if (artsetupfreeze) {
  jQuery("#freeitemsrequir_ar").attr("valueprice").replace(/\$/g, "");
}
var premiumartsetupe = jQuery("#premiumitemsrequir_ar").attr("valueprice");

if (premiumartsetupe) {
  jQuery("#premiumitemsrequir_ar").attr("valueprice").replace(/\$/g, "");
}

var greeniconsvg =
  '<svg aria-hidden="true" class="e-font-icon-svg e-far-check-circle" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z"></path></svg>';

var rediconsvg =
  '<svg aria-hidden="true" class="e-font-icon-svg e-far-times-circle" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm101.8-262.2L295.6 256l62.2 62.2c4.7 4.7 4.7 12.3 0 17l-22.6 22.6c-4.7 4.7-12.3 4.7-17 0L256 295.6l-62.2 62.2c-4.7 4.7-12.3 4.7-17 0l-22.6-22.6c-4.7-4.7-4.7-12.3 0-17l62.2-62.2-62.2-62.2c-4.7-4.7-4.7-12.3 0-17l22.6-22.6c4.7-4.7 12.3-4.7 17 0l62.2 62.2 62.2-62.2c4.7-4.7 12.3-4.7 17 0l22.6 22.6c4.7 4.7 4.7 12.3 0 17z"></path></svg>';
var ppcolorextras = jQuery(
  ".allprintareas .addlogo_colum:first-child .printcolors > option"
).attr("data-cost");
// main
jQuery(document).ready(function ($) {
  // zoom effect
  jQuery("#product_main_image_ae").zoom();
  // deffault values for print type

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

  /****************************** drage and drop zone sections ******************************/

  /****************************** drage and drop zone sections end ******************************/
  // file ajax end ------------------------------------------------
  /****************************** checkout page address sections wrapping in a div ******************************/

  /****************************** checkout page address sections wrapping in a div end ******************************/

  /****************************** singple product page image change on slides click ******************************/

  jQuery("#pr_image_vslider").on("click", ".slick-slide", function (e) {
    var ccurl = jQuery(this).find("img").attr("src");
    var scrcurl = jQuery(this).find("img").attr("srcset");
    jQuery("#product_main_image_ae").find("img").attr("src", ccurl);
    jQuery("#product_main_image_ae").find("img").attr("srcset", scrcurl);
  });

  /****************************** singple product page image change on slides click end ******************************/

  /****************************** singple product page quantity change ******************************/
  if ($(window).width() <= 768) {
    jQuery("#move_mobile").appendTo("#append_mobile");
  }

  jQuery(".sizes_ar").on("input", 'input[type="number"]', function (e) {
    e.preventDefault();
    var quantity = 0;
    $(".sizes_ar")
      .find('input[type="number"]')
      .each(function (index) {
        quantity = quantity + parseInt($(this).val());
      });
    if (quantity > 0) {
      jQuery(".warning_ar").remove();
    }
    localStorage.setItem("totalquantity", quantity);
    updatecolorsoffeatures(quantity);
    jQuery("#main_quantity_ar").text(quantity);
    var ptype = localStorage.getItem("pptype");

    if (ptype !== "" && ptype !== null) {
      uodatetable(`#${ptype}`);
    }
    gettotalprice();
  });

  /****************************** singple product page quantity change end ******************************/

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
    gettotalprice();
  });

  /****************************** function to update the visualize the current price in the price table end ******************************/

  /****************************** add a new print area list on click ******************************/

  jQuery(".addanotherone_ar").on("click", function (e) {
    let arrayval = [];
    let $addlogoColum = jQuery(".addlogo_colum");

    // Collect values from printarea selects
    $addlogoColum.each(function () {
      arrayval.push(jQuery(this).find("select.printarea").val());
    });

    let quantity = parseInt(localStorage.getItem("totalquantity"));
    let $firstColum = $addlogoColum.first();
    let firstValueCat = $firstColum
      .find("select.printtype")
      .attr("current-cat");
    let firstValue = $firstColum.find("select.printtype").val();
    let firstValueArea = $firstColum.find("select.printarea").val();

    // Validation: if conditions are met
    if (arrayval.length < 4 && firstValue && firstValueCat && firstValueArea) {
      let $newColum = $addlogoColum.last().clone();
      $newColum.appendTo(".allprintareas");

      // Disable areas for all but the last child
      $addlogoColum
        .not(":last-child")
        .find("select.printarea")
        .siblings(".custom_dropdown_ar_ar")
        .addClass("disabled_ar_options_ar");

      // Handle specific category conditions
      if (firstValueCat === "polos" || firstValueCat === "t-shirt") {
        if (firstValue !== "digital-print") {
          $newColum.find(".printcolors option[value='11']").hide();
        }
        $newColum.find("select.printtype").val(firstValue);
      } else {
        show_patch_fields(firstValueCat, $newColum.find(".printcolors"));

        if (firstValue === "digital-print") {
          $newColum.find(".printcolors option[value='11']").show();
          $newColum.find(".custom_options_ar h6[values='11']").show();
        } else {
          $newColum.find(".printcolors option[value='11']").hide();
          $newColum.find(".custom_options_ar h6[values='11']").hide();
        }

        resetSelectState($newColum);

        $newColum.find("select.printtype").val("embroidery");
        selectFirstValidOption($newColum, arrayval);
      }

      // Enable the colors select in the new column
      $newColum.find(".printcolors").prop("disabled", false);
      $newColum
        .find(".size_name_upload > img")
        .attr(
          "src",
          "https://custom2wear.mi6.global/wp-content/uploads/2024/05/Frame-1000005041.svg"
        );

      if (arrayval.length == 2) {
        jQuery(".addanotherone_ar").hide();
      }

      gettotalprice();
    } else {
      showWarning(arrayval.length, firstValue, firstValueCat, firstValueArea);
    }
  });

  // Helper function to reset select state
  function resetSelectState($colum) {
    $colum.find("select.printarea").prop("disabled", false);
    let $firstOption = $colum.find("select.printarea option").first();
    $colum.find("select.printarea").val($firstOption.val());
    $colum.find(".custom_dropdown_ar_ar").removeClass("disabled_ar_options_ar");
    $colum.find("h6[values='embroidery']").trigger("click");
    $colum.find("h6:first-child").trigger("click");
  }

  // Helper function to select the first valid option in the new column
  function selectFirstValidOption($colum, arrayval) {
    $colum.find("select.printarea option").each(function (index, element) {
      if (arrayval.includes(jQuery(this).val())) {
        jQuery(this).prop("disabled", true);
        $colum
          .find("h6[values='" + jQuery(this).val() + "']")
          .addClass("disabled_ar_options_ar");

        let $options = $colum.find("select.printarea option");
        if (index === $options.length - 1) {
          // Set the first valid option if this is the last option
          $options.each(function () {
            if (!jQuery(this).prop("disabled")) {
              $colum.find("select.printarea").val(jQuery(this).val());
              $colum
                .find("h6[values='" + jQuery(this).val() + "']")
                .trigger("click");
              return false; // break
            }
          });
        } else {
          // Set the next option if not the last
          $colum.find("select.printarea").val(jQuery(this).next().val());
          $colum
            .find("h6[values='" + jQuery(this).next().val() + "']")
            .trigger("click");
        }
      }
    });
  }

  // Helper function to show appropriate warnings
  function showWarning(arrayLength, firstValue, firstValueCat, firstValueArea) {
    let $sizesAr = jQuery(".sizes_ar");
    if (arrayLength == 3) {
      displayMessage($sizesAr, "You can't add more than 3 print areas");
    } else if (!firstValue || !firstValueCat || !firstValueArea) {
      displayMessage(
        $sizesAr,
        "Please select all the values in the first area."
      );
    }
  }

  // Function to display a message in the sizes area
  function displayMessage($target, message) {
    jQuery(".warning_ar").remove(); // Remove existing warning
    $target.append("<h6 class='warning_ar'>" + message + "</h6>");
  }

  /****************************** add a new print area list on click end ******************************/

  /****************************** listen to change in first row of the print logo area ******************************/

  // Helper function to handle print type specific logic
  // Helper function to handle print type specific logic
  function handlePrintTypeChange(printType, $colum, isFirstChild = false) {
    let isDisabled = false;
    let showOption11 = false;
    let showThreadColors = false;
    let show3D = false;
    let showPuffEmbroidery = false;

    // Display patch fields based on the print type
    show_patch_fields(printType, $colum);

    if (printType === "leather-patch") {
      if (isFirstChild) uodatetable("#leather-patch");
      isDisabled = true;
      localStorage.setItem("d_puff_embroidery", 0);
    } else if (printType === "embroidery") {
      if (isFirstChild) uodatetable("#embroidery");
      showThreadColors = true;
      show3D = true;
      showPuffEmbroidery = true;

      let valex = jQuery("#d_puff_embroidery_wrapper")
        .find("input[type='checkbox']")
        .val();
      localStorage.setItem(
        "d_puff_embroidery",
        jQuery("#d_puff_embroidery_wrapper")
          .find("input[type='checkbox']")
          .is(":checked")
          ? valex
          : 0
      );
    } else if (printType === "digital-print") {
      if (isFirstChild) uodatetable("#digital-print");
      showOption11 = true;
    } else if (printType === "blank") {
      if (isFirstChild) uodatetable("#blank");
    }

    // Update the UI based on the print type
    $colum
      .find(".printcolors")
      .attr("disabled", isDisabled)
      .find("option[value='11']")
      .toggle(showOption11);
    $colum
      .find(".custom_options_ar")
      .find("h6[values='11']")
      .toggle(showOption11);
    jQuery("#thread_colors_ar_ar_ar").toggle(showThreadColors);
    jQuery("#d_3d_ar").toggle(show3D);
    jQuery("#d_puff_embroidery_wrapper").css(
      "display",
      showPuffEmbroidery ? "flex" : "none"
    );

    localStorage.setItem("pptype", printType);
    gettotalprice();
  }

  // Event handler for first child column
  jQuery(".allprintareas .addlogo_colum:first-child").on(
    "change",
    "select.printtype",
    function (e) {
      e.preventDefault();
      let value = jQuery(this).val();
      handlePrintTypeChange(
        value,
        jQuery(this).closest(".addlogo_colum"),
        true
      );
    }
  );

  // Event handler for other columns
  jQuery(".allprintareas").on(
    "change",
    ".addlogo_colum:not(:first-child) select.printtype",
    function (e) {
      e.preventDefault();
      let value = jQuery(this).val();
      handlePrintTypeChange(value, jQuery(this).closest(".addlogo_colum"));
    }
  );

  /****************************** listen to change in first row of the print logo area  end******************************/

  /****************************** listen to change in print area input  of the print logo area ******************************/

  jQuery(".allprintareas").on("change", "select.printarea", function (e) {
    e.preventDefault();
    var value = jQuery(this).val();
    var prtype = jQuery(this)
      .closest(".addlogo_colum")
      .find("select.printtype")
      .val();
    var pids = parseInt(
      jQuery(this).find(`option[value='${value}']`).attr("product-id")
    );
    var quantity = localStorage.getItem("totalquantity");
    gettotalprice();
  });

  /****************************** function to add vertical slider ******************************/

  /****************************** function to add vertical slider end ******************************/

  /****************************** setting default values ******************************/
});

/****************************** function visualize the free features based on quantity ******************************/

function updatecolorsoffeatures(quantitys) {
  const quantity = parseInt(quantitys);
  check_premiumupdate(quantity);

  const $freeItems = jQuery("#freeitemsrequir_ar");
  const $shippingItems = jQuery("#shippingitemsrequir_ar");
  const $premiumItems = jQuery("#premiumitemsrequir_ar");

  // Common settings
  const setVisibility = (element, showTick) => {
    element.find(".tick_ar").toggleClass("hide_it", !showTick);
    element.find(".cross_ar").toggleClass("hide_it", showTick);
  };

  const setValuePrice = (element, value) => {
    element.attr("valueprice", value);
  };

  const handlePremiumArtwork = () => {
    if (jQuery("#premium_artwork_ar").is(":checked") && quantity < 36) {
      setValuePrice($premiumItems, `${premiumartsetupe}$`);
    } else {
      setValuePrice($premiumItems, "0$");
    }
  };

  // Reset prices and setup charges
  setValuePrice($freeItems, "0$");
  setValuePrice($shippingItems, "50$");
  setValuePrice($premiumItems, "0$");
  jQuery("#freesetup_charges_ar").text("0");

  if (quantity >= 12 && quantity < 24) {
    setVisibility($freeItems, true);
    setVisibility($shippingItems, false);
    setVisibility($premiumItems, false);
    handlePremiumArtwork();
  } else if (quantity >= 24 && quantity < 36) {
    setVisibility($freeItems, true);
    setVisibility($shippingItems, true);
    setVisibility($premiumItems, false);
    handlePremiumArtwork();
  } else if (quantity >= 36) {
    setVisibility($freeItems, true);
    setVisibility($shippingItems, true);
    setVisibility($premiumItems, true);
    setValuePrice($shippingItems, "0$");
  } else {
    // For quantities less than 12
    jQuery("#freesetup_charges_ar").text(`${artsetupfreeze}`);
    setVisibility($freeItems, false);
    setVisibility($shippingItems, false);
    setVisibility($premiumItems, false);

    setValuePrice($freeItems, `${artsetupfreeze}`);
    setValuePrice($shippingItems, "0$");

    if (jQuery("#orderedthislogo_ar").is(":checked")) {
      setValuePrice($freeItems, "0$");
    }
  }
}

/****************************** function visualize the free features based on quantity end******************************/
jQuery("#premium_artwork_ar").on("click", function () {
  var quantity = localStorage.getItem("totalquantity");
  if (jQuery(this).is(":checked")) {
    localStorage.setItem("checked_premium", true);
  } else {
    localStorage.setItem("checked_premium", false);
  }
  updatecolorsoffeatures(quantity);
  gettotalprice();
});
/****************************** function visualize the d_puff_embroidery end******************************/
jQuery("#d_puff_embroidery").on("click", function () {
  if (jQuery(this).is(":checked")) {
    localStorage.setItem("d_puff_embroidery", jQuery(this).val());
  } else {
    localStorage.setItem("d_puff_embroidery", 0);
  }
  gettotalprice();
});
/****************************** function visualize the orderedthislogo_ar end******************************/
jQuery("#orderedthislogo_ar").on("click", function () {
  var quantity = localStorage.getItem("totalquantity");
  if (jQuery(this).is(":checked")) {
    jQuery("#premium_artwork_ar").attr("checked", true);
    jQuery("#premium_artwork_ar").attr("disabled", true);
  } else {
    jQuery("#premium_artwork_ar").attr("checked", false);
    jQuery("#premium_artwork_ar").attr("disabled", false);
  }
  updatecolorsoffeatures(quantity);
  gettotalprice();
});
/****************************** function visualize the add_instrution_ar end******************************/
jQuery("#add_instrution_ar").on("click", function () {
  if (jQuery(this).is(":checked")) {
    jQuery("#add_instrution_ar_text").show();
  } else {
    jQuery("#add_instrution_ar_text").hide();
    jQuery("#add_instrution_ar_text").val("");
  }
  gettotalprice();
});
/****************************** function to do all the calculations ******************************/

function gettotalprice(nocart = true) {
  puffEmbroid("#d_3d_ar");
  if (nocart) {
    getpricelist(nocart);
  }
  const totalquant = parseInt(localStorage.getItem("totalquantity"));
  updatecolorsoffeatures(totalquant);

  let totalprice = 0;
  let quantity = 0;
  const sizesvar = []; // Array to store sizes and quantities
  const artsetupfree = parseFloat(
    jQuery("#freeitemsrequir_ar").attr("valueprice").replace(/\$/g, "") || 0
  );
  const premiumartsetup = parseFloat(
    jQuery("#premiumitemsrequir_ar").attr("valueprice").replace(/\$/g, "") || 0
  );
  const totalsetup = artsetupfree + premiumartsetup;

  // Collect size quantities
  jQuery(".sizes_ar")
    .find("input[type='number']")
    .each(function () {
      const value = parseInt(jQuery(this).val());
      if (value > 0) {
        const size = jQuery(this)
          .closest(".size_column_ar")
          .find(".size_name > h6")
          .text();
        sizesvar.push({ size, quantity: value });
        quantity += value;
      }
    });

  pa_additional_cost_ar(quantity);
  update_progressbar();

  // Get price per product
  const pricepp = jQuery(".price_column_ar.bg-red .range_price_ar")
    .text()
    .replace(/\$/g, "")
    .trim();
  const priceperproduct =
    parseFloat(pricepp) ||
    parseFloat(
      jQuery("bdi.bg-red").text().replace(/\$/g, "").replace(/\,/g, "")
    );

  // Additional charges
  const additional_fee = addextrachargesopt();
  const additional_charges = parseFloat(additional_fee.outputpricefee) || 0;

  // Calculate total price
  if (priceperproduct > 0 && quantity > 0) {
    totalprice = priceperproduct + additional_charges;
  }

  const d3_puff = parseFloat(localStorage.getItem("d_puff_embroidery")) || 0;
  totalprice += d3_puff * quantity;

  // Output sizes and quantities
  jQuery("#quanitiy_ar_ar")
    .find("h2")
    .html(sizesvar.map((s) => `${s.size} : ${s.quantity}`).join(", "));

  // Collect additional information
  const add_instructions = jQuery("#add_instrution_ar_text").val();
  const totaldata = {
    quantity,
    priceperproduct,
    totalprice: totalprice.toFixed(2),
    sizes: sizesvar,
    allareasdata: gettheprintareaarray(),
    d3_puff_embroidery: d3_puff,
    add_instructions,
    premiumartsetupfee: jQuery("#premium_artwork_ar").is(":checked"),
    orderedthislogo_ar: jQuery("#orderedthislogo_ar").is(":checked"),
    extraareafee:
      parseFloat(
        jQuery("#extra_area_fee_ar")
          .find(".price_column_ar.bg-red .range_price_ar")
          .text()
          .replace(/\$/g, "")
      ) || 0,
    extracolorsfee: additional_fee.colorsricefee,
    additional_charges: additional_fee.totalsetupfee,
  };

  // Disable buttons if conditions are not met
  const isDisabled =
    quantity <= 0 ||
    jQuery(".active_swatch_ar").length <= 0 ||
    totaldata.allareasdata.length <= 0 ||
    !totaldata.allareasdata[0].printtype;
  jQuery("#single_add_to_cart_ar, #sticky_add_to_cart_ar_ar").toggleClass(
    "disabled_ar_product",
    isDisabled
  );

  showerrormessaes(
    quantity,
    jQuery(".active_swatch_ar").length,
    totaldata.allareasdata
  );

  // Update UI for quantity and size variations
  const variationCount = sizesvar.length;
  jQuery(
    "#heading_for_sub_total_ar .vairation_added_ar, #sticky_vairations_sector_ar_ar .vairation_added_ar, #sticky_vairations_sector_ar_ar_mb .vairation_added_ar"
  ).text(variationCount);
  jQuery(
    "#heading_for_sub_total_ar .quantity_added_ar, #sticky_vairations_sector_ar_ar .quantity_added_ar, #sticky_vairations_sector_ar_ar_mb .quantity_added_ar"
  ).text(quantity);

  return totaldata;
}

/****************************** function to do all the calculations end******************************/

/****************************** listen to the change in the color input in print logo area ******************************/

jQuery(".allprintareas").on("change", ".printcolors", function () {
  var printtype = jQuery(this)
    .closest(".addlogo_colum")
    .find(".printtype")
    .val();
  var printarea = jQuery(this)
    .closest(".addlogo_colum")
    .find(".printarea")
    .val();
  var currentval = jQuery(this).val();

  if (printtype == "" || printarea == "") {
    if (jQuery(".warning_ar").length <= 0) {
      jQuery(".sizes_ar").append(
        "<h6 class='warning_ar'>Kindly Select the Print Type and Print Area</h6>"
      );
    } else {
      jQuery(".warning_ar").remove();
      jQuery(".sizes_ar").append(
        "<h6 class='warning_ar'>Kindly Select the Print Type and Print Area</h6>"
      );
    }
  } else {
    if (parseInt(currentval) > 3) {
      extrafeeUpdate("#extra_color_fee_ar");
    }
    gettotalprice();
  }
});

/****************************** listen to click on add to cart button ******************************/

jQuery("#single_add_to_cart_ar").on("click", function (e) {
  e.preventDefault();
  jQuery("#single_add_to_cart_ar").addClass("disabled_ar_product");
  var pcolor = jQuery(".active_swatch_ar").attr("attr-name");
  var productid = jQuery(".sizes_main_div_ar_ar > .size_column_ar")
    .find("input[type='number']")
    .attr("product-id");
  var enableddiscounts = false;
  if (jQuery("#price_calculator_ar_ar").length > 0) {
    enableddiscounts = true;
  }
  var alldata = gettotalprice(false);
  var totalprice = alldata.totalprice;
  var quantity = alldata.quantity;
  jQuery.ajax({
    type: "POST",
    url: "/wp-admin/admin-ajax.php",
    data: {
      action: "addtocartar",
      price: totalprice,
      quantity: quantity,
      product_id: productid,
      colors: pcolor,
      sizear: alldata.sizes, // Pass the sizees
      allareasdata: alldata.allareasdata,
      add_instructions: alldata.add_instructions,
      orderedthislogo_ar: alldata.orderedthislogo_ar,
      premiumartsetupfee: alldata.premiumartsetupfee,
      d3_puff_embroidery: alldata.d3_puff_embroidery,
      additional_charges: alldata.additional_charges,
      extracolorsfee: alldata.extracolorsfee,
      extraareafee: alldata.extraareafee,
      enableddiscounts: enableddiscounts,
    },
    success: function (response) {
      if (response.success) {
        // Redirect to cart page on success
        window.location.href = response.data.redirect_url;
      } else {
        alert(response.data.message);
      }
    },
    error: function (xhr, status, error) {
      // Handle error
      console.error("Error generating PDF");
    },
  });
});

/****************************** listen to click on add to cart button end ******************************/

/****************************** function to show extra charges based on print area selections ******************************/
function addextrachargesopt() {
  const artsetupfree = parseFloat(
    jQuery("#freeitemsrequir_ar").attr("valueprice").replace(/\$/g, "") || 0
  );
  const premiumartsetup = parseFloat(
    jQuery("#premiumitemsrequir_ar").attr("valueprice").replace(/\$/g, "") || 0
  );
  const totalsetup = premiumartsetup;
  const quantity = parseInt(localStorage.getItem("totalquantity")) || 0;

  let outputprice = 0;
  let colorsrice = 0.0;
  const ppcolorextras = parseFloat(
    jQuery("#extra_color_fee_ar .price_column_ar.bg-red .range_price_ar")
      .text()
      .replace(/\$/g, "") || 0
  );

  jQuery(".addlogo_colum").each(function (index) {
    const ppcolors =
      parseInt(jQuery(this).find("select.printcolors").val()) || 0;
    const pptypes = jQuery(this).find("select.printtype").val();

    if (ppcolors > 3 && pptypes !== "leather-patch") {
      const ppcolorextrases = ppcolors - 3;
      const pppricess = ppcolorextras * ppcolorextrases;

      colorsrice += Math.max(0, pppricess);
      outputprice += pppricess * quantity;

      // Only add area fee if it's not the first index
      if (index > 0) {
        const extra =
          parseFloat(
            jQuery("#extra_area_fee_ar .price_column_ar.bg-red .range_price_ar")
              .text()
              .replace(/\$/g, "") || 0
          ) * quantity;
        outputprice += extra;
      }
    }
  });

  outputprice += totalsetup;

  // Remove red background if colorsrice is less than or equal to 0
  if (colorsrice <= 0) {
    jQuery(
      "#extra_color_fee_ar .title_ar_table, #extra_color_fee_ar .price_column_ar"
    ).removeClass("bg-red");
  }

  return {
    totalsetupfee: totalsetup,
    outputpricefee: outputprice,
    colorsricefee: Math.max(0, colorsrice),
  };
}

/****************************** function to show extra charges based on print area selections end ******************************/

function pa_additional_cost_ar(quantity) {
  const $priceColumns = jQuery("#pa_additional_cost_ar .price_column_ar");
  const $printAreas = jQuery(
    ".allprintareas .addlogo_colum:not(:first-child) .printarea"
  );

  if ($printAreas.length > 0) {
    let highlightedColumn = null;

    $priceColumns.each(function () {
      const currentElement = parseInt(jQuery(this).attr("quantity-id"));
      const nextElement = parseInt(
        jQuery(this).next(".price_column_ar").attr("quantity-id") || Infinity
      );

      if (
        quantity === currentElement ||
        (quantity > currentElement && quantity < nextElement)
      ) {
        highlightedColumn = jQuery(this).next(".price_column_ar");
      }
    });

    // Remove previous highlights and add the new one
    $priceColumns.removeClass("pa_ar_bg_red");
    if (highlightedColumn) {
      highlightedColumn.addClass("pa_ar_bg_red");
    }

    $printAreas.each(function () {
      const value = jQuery(this).val();
      if (value) {
        const extraResponse = jQuery(".pa_ar_bg_red")
          .text()
          .replace(/\$/g, "")
          .trim();
        jQuery(this).find("option").attr("extra", "");
        jQuery(this)
          .find(`option[value='${value}']`)
          .attr("extra", extraResponse);
      }
    });
  }
}

function gettheprintareaarray() {
  const printareasall = [];

  jQuery(".allprintareas .addlogo_colum").each(function () {
    const $this = jQuery(this);

    const areavalue = $this.find("select.printarea").val();
    const areaText = $this
      .find(`select.printarea option[value='${areavalue}']`)
      .text();

    const printtype = $this.find("select.printtype").val();
    const printTypeText = $this
      .find(`select.printtype option[value='${printtype}']`)
      .text();

    let printcolors = $this.find("select.printcolors").val();
    if (printtype === "leather-patch") {
      printcolors = $this.find("input[name='patchshape']").val();
    }

    let artworkurl = $this.find(".size_name_upload > img").attr("src");
    if (artworkurl.includes("Frame-1000005041.svg")) {
      artworkurl = "";
    }

    if (printTypeText.toLowerCase() !== "choose") {
      printareasall.push({
        areavalue: areaText,
        printtype: printTypeText,
        printcolors: printcolors,
        artworkurl: artworkurl,
      });
    }
  });

  if (printareasall.length > 1) {
    extrafeeUpdate("#extra_area_fee_ar");
  }

  return printareasall;
}

jQuery(".allprintareas").on("click", ".removerlist_ar_area", function () {
  jQuery(this).closest(".addlogo_colum").remove();
  jQuery(".addanotherone_ar").show();

  addextrachargesopt();
  gettotalprice();
});

/****************************** singple product page color swatches selections end ******************************/

/****************************** function to update the visualize the current price in the price table ******************************/

function uodatetable(selector) {
  const quantity = parseInt(localStorage.getItem("totalquantity"));

  // Reset previous highlights
  jQuery(".grid_tem_ar8")
    .not("#d_3d_ar, #extra_area_fee_ar")
    .find(".title_ar_table")
    .removeClass("bg-red");

  // Highlight the selected title
  jQuery(selector).find(".title_ar_table").addClass("bg-red");

  // Iterate through each price column
  jQuery(`${selector} .price_column_ar`).each(function () {
    const $this = jQuery(this);
    const currentElement = parseInt($this.attr("quantity-id"));
    const nextElement = $this.next(".price_column_ar").attr("quantity-id");

    if (
      quantity >= currentElement &&
      (nextElement === undefined || quantity < nextElement)
    ) {
      // Reset and highlight current price
      jQuery(".grid_tem_ar8")
        .not("#d_3d_ar, #extra_area_fee_ar, #extra_color_fee_ar")
        .find(".price_column_ar")
        .removeClass("bg-red");

      $this.addClass("bg-red");
      jQuery(
        `${selector} .price_column_ar[quantity-id='${currentElement}']`
      ).addClass("bg-red");
      return;
    } else if (nextElement === "" || quantity === currentElement) {
      // Reset and highlight the current element
      jQuery(".grid_tem_ar8")
        .not("#d_3d_ar, #extra_area_fee_ar, #extra_color_fee_ar")
        .find(".price_column_ar")
        .removeClass("bg-red");

      $this.addClass("bg-red");
      return;
    } else if (quantity === 0) {
      // Clear highlights if quantity is 0
      jQuery(".price_column_ar, .title_ar_table").removeClass("bg-red");
    }
  });
}

function getpricelist(nocarts = true) {
  jQuery("#single_add_to_cart_ar").addClass("disabled_ar_product");

  const sizesvar = [];
  const allareasdata = gettheprintareaarray();

  // Gather size and quantity data
  jQuery(".sizes_ar input[type='number']").each(function () {
    const value = jQuery(this).val();
    if (value && value > 0) {
      const size = jQuery(this)
        .closest(".size_column_ar")
        .find(".size_name > h6")
        .text();
      sizesvar.push({ size, quantity: value });
    }
  });

  // Check if the necessary conditions are met
  if (
    sizesvar.length > 0 &&
    jQuery(".active_swatch_ar").length > 0 &&
    allareasdata.length > 0 &&
    allareasdata[0].printtype !== ""
  ) {
    const pcolor = jQuery(".active_swatch_ar").attr("attr-name");
    const productid = jQuery(
      ".sizes_main_div_ar_ar > .size_column_ar input[type='number']"
    ).attr("product-id");
    const enableddiscounts = jQuery("#price_calculator_ar_ar").length > 0;

    const additional_fee = addextrachargesopt();
    const additional_charges = parseFloat(additional_fee.totalsetupfee);
    const quantity = parseInt(localStorage.getItem("totalquantity"));

    // Get extra area fee if available
    const extraareafee =
      jQuery("#extra_area_fee_ar .price_column_ar.bg-red .range_price_ar")
        .length > 0
        ? parseFloat(
            jQuery("#extra_area_fee_ar .price_column_ar.bg-red .range_price_ar")
              .text()
              .replace(/\$/g, "")
          )
        : 0;

    jQuery("#totalprice_ar_product").hide();
    let pricewhole = 0;

    jQuery.ajax({
      type: "POST",
      url: "/wp-admin/admin-ajax.php",
      data: {
        action: "addtocartar",
        product_id: productid,
        allareasdata: allareasdata,
        colors: pcolor,
        sizear: sizesvar,
        notcart: nocarts,
        enableddiscounts: enableddiscounts,
        extracolorsfee: additional_fee.colorsricefee,
        extraareafee: extraareafee,
        additional_charges: additional_charges,
      },
      success: function (response) {
        if (response.success) {
          const id = enableddiscounts
            ? `#${response.data.list_id}`
            : "#span_ar_product";
          if (enableddiscounts) {
            jQuery(id).html(response.data.price_list);
            pricewhole = update_multi_price_table(id);
          } else {
            jQuery(id).text(response.data.current_price);
          }
          jQuery("#single_add_to_cart_ar").removeClass("disabled_ar_product");
        } else {
          alert(response.data.message);
        }
        jQuery("#totalprice_ar_product").show();
      },
      error: function (xhr, status, error) {
        console.error("Error generating PDF");
      },
    });
  }

  return pricewhole;
}

function check_premiumupdate(quantity) {
  var checked = localStorage.getItem("checked_premium");
  if (checked == "true") {
    if (quantity >= 36) {
      jQuery("#premium_artwork_ar").attr("checked", true);
      jQuery("#premium_artwork_ar").attr("disabled", true);
    } else {
      jQuery("#premium_artwork_ar").attr("checked", true);
      jQuery("#premium_artwork_ar").attr("disabled", false);
    }
  } else {
    if (quantity >= 36) {
      jQuery("#premium_artwork_ar").attr("checked", true);
      jQuery("#premium_artwork_ar").attr("disabled", true);
    } else {
      jQuery("#premium_artwork_ar").attr("checked", false);
      jQuery("#premium_artwork_ar").attr("disabled", false);
    }
  }
}

function puffEmbroid(selector) {
  const quantity = parseInt(localStorage.getItem("totalquantity"));
  const $selector = jQuery(selector);

  // Reset background colors
  $selector.find(".title_ar_table, .price_column_ar").removeClass("bg-red");

  const dispStatus = jQuery("#d_puff_embroidery_wrapper").css("display");
  const isChecked = jQuery("#d_puff_embroidery").is(":checked");

  if (isChecked && dispStatus !== "none") {
    $selector.find(".title_ar_table").addClass("bg-red");

    let puffPrices = 0; // Default to 0
    $selector.find(".price_column_ar").each(function () {
      const currentElement = parseInt(jQuery(this).attr("quantity-id"));
      const nextElement =
        parseInt(jQuery(this).next(".price_column_ar").attr("quantity-id")) ||
        Infinity; // Handle case where nextElement is undefined

      if (quantity >= currentElement && quantity < nextElement) {
        puffPrices = jQuery(this).text().replace(/\$/g, "").trim(); // Get the price for the selected quantity
        jQuery(this).addClass("bg-red");
      } else if (quantity === currentElement) {
        puffPrices = jQuery(this).text().replace(/\$/g, "").trim();
        jQuery(this).addClass("bg-red");
      }
    });

    localStorage.setItem("d_puff_embroidery", puffPrices || 0); // Store the price or 0 if none
  } else {
    localStorage.setItem("d_puff_embroidery", 0);
  }
}

/***************************   Extra fee based on print areas price table update start */
function extrafeeUpdate(selector) {
  const quantity = parseInt(localStorage.getItem("totalquantity"));
  const $selector = jQuery(selector);

  // Reset background color for price columns
  $selector.find(".title_ar_table").addClass("bg-red");
  const $priceColumns = $selector.find(".price_column_ar");

  // Remove previous red backgrounds
  $priceColumns.removeClass("bg-red");

  $priceColumns.each(function () {
    const $currentElement = jQuery(this);
    const currentElementId = parseInt($currentElement.attr("quantity-id"));
    const nextElementId =
      parseInt($currentElement.next(".price_column_ar").attr("quantity-id")) ||
      Infinity; // Handle undefined nextElement

    if (quantity >= currentElementId && quantity < nextElementId) {
      $currentElement.addClass("bg-red");
    } else if (quantity >= currentElementId || nextElementId === "") {
      $currentElement.addClass("bg-red");
    }
  });

  // Reset title color if quantity is 0
  if (quantity === 0) {
    $selector.find(".title_ar_table").removeClass("bg-red");
  }
}

function show_patch_fields(patches, thisis) {
  const $addLogoColumn = thisis.closest(".addlogo_colum");
  const $patchesColumn = $addLogoColumn.find(".patches_column_ar");
  const $sizeWithPatchShape = $addLogoColumn.find(
    ".size_column_ar:has(.patchshape)"
  );
  const $sizeWithPrintColors = $addLogoColumn.find(
    ".size_column_ar:has(.printcolors)"
  );

  if (patches === "leather-patch") {
    $patchesColumn.removeClass("hidethis_ar");
    $sizeWithPatchShape.removeClass("hidethis_ar");
    $sizeWithPrintColors.addClass("hidethis_ar");
    $addLogoColumn.addClass("restruct_the_columns_ar");
  } else {
    $patchesColumn.addClass("hidethis_ar");
    $sizeWithPatchShape.addClass("hidethis_ar");
    $sizeWithPrintColors.removeClass("hidethis_ar");
    $addLogoColumn.removeClass("restruct_the_columns_ar");
  }
}

/******************************** function to update free premium setup progress bar actions*/

function update_progressbar() {
  var quantity = parseInt(localStorage.getItem("totalquantity"));
  var totalnumbersrequired = 36;
  var progressbar = parseFloat((quantity / totalnumbersrequired) * 100).toFixed(
    2
  );
  var remainingquanityt = totalnumbersrequired - quantity;
  if (quantity < 36) {
    jQuery(".progressbar_quantity").css("width", progressbar + "%");
    jQuery("#quan_left_progress_ar").text(remainingquanityt);
    jQuery(".progressbar_quantity").css("background", "#aa1f22");
  } else if (quantity >= 36) {
    jQuery(".progressbar_quantity").css("background", "green");
    jQuery(".progressbar_quantity").css("width", "100%");
    jQuery("#quan_left_progress_ar").text(0);
  }
}

/*************************************** handling the tooltips */

jQuery("body").on("mouseenter mouseleave", ".tooltip_info_ar", function (e) {
  jQuery(this).find(".tooltip_data_ar").toggle();
  jQuery(this).toggleClass("z_index_tooltip_cc_ar");
});

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

/******************************* Handling the custom options  */

jQuery(".allprintareas").on("click", ".custom_dropdown_ar_ar", function (e) {
  e.preventDefault();
  jQuery(".custom_options_ar").hide();
  jQuery(this).siblings(".custom_options_ar").toggle();
  jQuery(".custom_dropdown_wrapper_ar_ar").removeClass("z_index_tooltip_cc_ar");
  jQuery(this)
    .closest(".custom_dropdown_wrapper_ar_ar")
    .addClass("z_index_tooltip_cc_ar");
});

jQuery(".allprintareas").on("click", ".custom_options_ar h6", function (e) {
  e.preventDefault();
  var values = jQuery(this).attr("values");
  var text = jQuery(this).text();
  // console.log(values, text);
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

// Cache selectors
var $window = jQuery(window);
var $addToCartWrapper = jQuery("#addtocarwrappere_ar");
var $showOnScroll = jQuery("#showmeonscroll_ar_ar");
var offsetDiv = $addToCartWrapper.offset().top;
var deviceHeight = $window.height();

// Debounce function
function debounce(func, wait) {
  var timeout;
  return function () {
    var context = this,
      args = arguments;
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      timeout = null;
      func.apply(context, args);
    }, wait);
  };
}

// Scroll event handler
var handleScroll = debounce(function () {
  var scrollFromTop = $window.scrollTop();
  var totalView = deviceHeight - 150 + scrollFromTop;

  // console.log(totalView, offsetDiv, deviceHeight, scrollFromTop);

  if (totalView > offsetDiv) {
    if (
      $showOnScroll.css("display") === "flex" &&
      $addToCartWrapper.hasClass("makeitstick_ar_ar")
    ) {
      $addToCartWrapper.removeClass("makeitstick_ar_ar");
      $showOnScroll.slideUp();
    }
  } else {
    if (
      $showOnScroll.css("display") === "none" &&
      !$addToCartWrapper.hasClass("makeitstick_ar_ar")
    ) {
      $addToCartWrapper.addClass("makeitstick_ar_ar");
      $showOnScroll.css("display", "flex");
    }
  }
}, 100); // Adjust the debounce wait time as needed

// Bind the scroll event
$window.scroll(handleScroll);
jQuery("body").on("click", "#sticky_add_to_cart_ar_ar", function (e) {
  e.preventDefault();
  jQuery("#single_add_to_cart_ar").trigger("click");
});

jQuery(".close_icon_floating").on("click", function (e) {
  jQuery("#showmeonscroll_ar_ar").slideUp();
});
jQuery(".floating_icons_viewer").on("click", function (e) {
  var display = jQuery("#showmeonscroll_ar_ar").css("display");
  if (display == "none") {
    jQuery("#showmeonscroll_ar_ar").css("display", "flex");
  } else {
    jQuery("#showmeonscroll_ar_ar").slideUp();
  }
});

function showerrormessaes(quantity, color, printtypes) {
  if (quantity == 0) {
    jQuery("#error_placer_ar")
      .find("span")
      .text(`Please Select The Quantity..`);
    jQuery("#error_placer_ar").show();
  } else if (Array.isArray(printtypes) && printtypes.length == 0) {
    jQuery("#error_placer_ar")
      .find("span")
      .text(`Please Select The Print Type..`);
    jQuery("#error_placer_ar").show();
  } else if (color <= 0) {
    jQuery("#error_placer_ar").find("span").text(`Please Select The Color..`);
    jQuery("#error_placer_ar").show();
  } else {
    jQuery("#error_placer_ar").hide();
  }
}

function update_multi_price_table(selector) {
  var sizes_quantity = {}; // Using an associative array (plain object)

  // Collect sizes and quantities
  jQuery(".quantity_and_info_ar")
    .find(".sizes_quantity input[type='number']")
    .each(function () {
      var label = jQuery(this).attr("cursize"); // Get the size label
      var value = jQuery(this).val(); // Get the value of the input
      sizes_quantity[label] = value; // Directly assign the label as the key and value
    });
  var totalquantity = localStorage.getItem("totalquantity");
  // Remove class 'bg-red' from the relevant elements
  jQuery(
    ".grid_tem_ar8:not('#d_3d_ar , #extra_area_fee_ar,#extra_color_fee_ar')"
  )
    .find(".title_ar_table")
    .removeClass("bg-red");
  // Add class 'bg-red' to the selected element
  jQuery(`${selector}`).find(".title_ar_table").addClass("bg-red");
  // Iterate over the associative array using jQuery.each
  jQuery(`${selector}`)
    .find(".price_column_ar")
    .each(function () {
      var cursie = jQuery(this).attr("cursize").trim();
      var currentElement = parseInt(jQuery(this).attr("quantity-id"));
      var currenttag = jQuery(this);
      var nextElement = parseInt(
        jQuery(this).next(".price_column_ar").attr("quantity-id")
      );
      jQuery.each(sizes_quantity, function (key, value) {
        var quantity = parseInt(value);
        var sizes = key.trim();

        if (cursie == sizes) {
          if (
            totalquantity >= currentElement &&
            (totalquantity < nextElement ||
              nextElement == "" ||
              nextElement == undefined ||
              isNaN(nextElement))
          ) {
            currenttag.addClass("bg-red");
            return;
          } else if (
            nextElement == "" ||
            totalquantity == currentElement ||
            (nextElement == undefined && totalquantity >= currentElement)
          ) {
            currenttag.addClass("bg-red");
            return;
          }
        }
      });
    });
  var pricewithout = getpricewithoutcharges();
  return pricewithout;
}

function getpricewithoutcharges() {
  // Collect sizes and quantities
  var artsetupfree = jQuery("#freeitemsrequir_ar").attr("valueprice");
  // shiipingcost = shiipingcost.replace(/\$/g, "");
  artsetupfree = artsetupfree.replace(/\$/g, "");
  var totalpricewithourcharges = 0.0;
  var additional_fee = addextrachargesopt();
  var additional_charges = parseFloat(additional_fee.totalsetupfee);
  var quantity = parseInt(localStorage.getItem("totalquantity"));
  var extraareafee = 0;
  var puff_3d = localStorage.getItem("d_puff_embroidery");
  // extrafeeUpdate("#extra_area_fee_ar");

  if (
    jQuery("#extra_area_fee_ar").find(".price_column_ar.bg-red .range_price_ar")
      .length > 0
  ) {
    extraareafee = jQuery("#extra_area_fee_ar")
      .find(".price_column_ar.bg-red .range_price_ar")
      .text();
    extraareafee = parseFloat(extraareafee.replace(/\$/g, ""));
  }
  var allareasdata = gettheprintareaarray();
  if (allareasdata.length > 1) {
    extraareafee = extraareafee * (allareasdata.length - 1);
  } else {
    extraareafee = 0;
    jQuery("#extra_area_fee_ar").find(".title_ar_table").removeClass("bg-red");
    jQuery("#extra_area_fee_ar").find(".price_column_ar").removeClass("bg-red");
  }
  jQuery(".quantity_and_info_ar")
    .find(".sizes_quantity input[type='number']")
    .each(function () {
      var label = jQuery(this).attr("cursize"); // Get the size label
      var value = parseInt(jQuery(this).val()); // Get the value of the input
      if (value !== 0) {
        var currentprice = "";
        if (jQuery(`.price_column_ar.bg-red[cursize='${label}']`).length > 0) {
          currentprice = jQuery(`.price_column_ar.bg-red[cursize='${label}']`)
            .find(".range_price_ar")
            .text();
        }
        currentprice = parseFloat(currentprice.replace(/\$/g, ""));
        currentprice =
          currentprice +
          parseFloat(puff_3d) +
          parseFloat(extraareafee) +
          parseFloat(additional_charges) +
          parseFloat(additional_fee.colorsricefee);

        totalpricewithourcharges = parseFloat(
          parseFloat(totalpricewithourcharges) + currentprice * value
        );
      }
      // Directly assign the label as the key and value
    });
  var quantity = parseInt(localStorage.getItem("quantity"));

  totalpricewithourcharges = totalpricewithourcharges.toFixed(2);
  if (!isNaN(totalpricewithourcharges)) {
    if (quantity > 12) {
      jQuery("#totalprice_ar_product")
        .find("#span_ar_product")
        .text(totalpricewithourcharges);
    } else {
      if (totalpricewithourcharges > 30) {
        jQuery("#totalprice_ar_product")
          .find("#span_ar_product")
          .text(totalpricewithourcharges);
      } else {
        jQuery("#totalprice_ar_product")
          .find("#span_ar_product")
          .text(totalpricewithourcharges);
      }
    }
  }
  return totalpricewithourcharges;
}
