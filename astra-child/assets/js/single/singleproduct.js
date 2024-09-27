/**
 * Highlights the price table based on selected print types, colors, and quantities.
 *
 * No parameters are passed.
 *
 * @return {void} - This function does not return any value.
 */
function pricetablehightlight() {
  var printTypes = jQuery(".addlogo_colum:first-child")
    .find("select.printtype")
    .val();
  var swatchColor = jQuery(".swatch_ar.active_swatch_ar").attr("attr-name");

  jQuery(".print_types_tables_ar")
    .find(".title_ar_table")
    .removeClass("bg-red");

  jQuery(".print_types_tables_ar")
    .find(".price_column_ar")
    .removeClass("bg-red");

  var quantityDetails = quantity_counter();
  var sizeWithQuantity = quantityDetails["sizewithquantity"];
  var totalQuantity = quantityDetails["totalquantity"];

  sizeWithQuantity.forEach(function (item) {
    var itemSize = item["size"];
    var itemQuantity = parseInt(item["quantity"]);

    if (itemQuantity > 0) {
      jQuery(`.grid_tem_ar8.${printTypes}`).each(function () {
        var currentSize = jQuery(this).attr("varsize");
        var currentColor = jQuery(this).attr("varcolor");

        if (currentColor == swatchColor && currentSize == itemSize) {
          jQuery(this).find(".title_ar_table").addClass("bg-red");

          jQuery(this)
            .find(".price_column_ar")
            .each(function () {
              var currentElement = parseInt(jQuery(this).attr("quantity-id"));
              var currenttag = jQuery(this);
              var nextElement = parseInt(
                jQuery(this).next(".price_column_ar").attr("quantity-id")
              );

              if (
                totalQuantity >= currentElement &&
                (totalQuantity < nextElement ||
                  nextElement == "" ||
                  nextElement == undefined ||
                  isNaN(nextElement))
              ) {
                currenttag.addClass("bg-red");
                return;
              } else if (
                nextElement == "" ||
                totalQuantity == currentElement ||
                (nextElement == undefined && totalQuantity >= currentElement)
              ) {
                currenttag.addClass("bg-red");
                return;
              }
            });
        }
      });
    }
  });
}

/**
 * Counts the total quantity and returns an array of size and quantity details.
 *
 * No parameters are passed.
 *
 * @return {Object} quantityInfo - An object containing size-quantity pairs and total quantity.
 * @return {Array} quantityInfo.sizewithquantity - An array of objects with size and quantity.
 * @return {number} quantityInfo.totalquantity - The total quantity of all selected items.
 */
function quantity_counter() {
  var sizeWithQuantity = [];
  var quantityInfo = [];
  var totalquantity = 0;

  jQuery(".quantity_and_info_ar")
    .find(".size_column_ar")
    .each(function () {
      var currentquantity = parseInt(
        jQuery(this).find("input[type='number']").val()
      );
      var currentSize = jQuery(this)
        .find("input[type='number']")
        .attr("cursize");
      totalquantity = totalquantity + currentquantity;
      sizeWithQuantity.push({ size: currentSize, quantity: currentquantity });
    });

  jQuery("#main_quantity_ar").find("b").text(totalquantity);
  quantityInfo["sizewithquantity"] = sizeWithQuantity;
  quantityInfo["totalquantity"] = totalquantity;
  sessionStorage.setItem("totalquantity", totalquantity);
  return quantityInfo;
}

/**
 * Updates color fields based on the selected print type.
 *
 * @param {string} $printType - The selected print type value.
 * @param {jQuery Object} $currentRow - The current jQuery row where the print type is selected.
 *
 * @return {void} - This function does not return any value.
 */
function updateColorFields($printType, $currentRow) {
  show_patch_fields($printType, $currentRow);
  embroideryUpdates();

  if ($printType == "digital-print") {
    $currentRow
      .closest(".addlogo_colum")
      .find(".printcolors")
      .siblings(".custom_options_ar")
      .find("h6:last-child")
      .show();
  } else if ($printType == "blank") {
    $currentRow
      .closest(".addlogo_colum")
      .find(".printcolors")
      .siblings(".custom_options_ar")
      .find("h6:last-child")
      .hide();
  } else if ($printType == "embroidery") {
    $currentRow
      .closest(".addlogo_colum")
      .find(".printcolors")
      .siblings(".custom_options_ar")
      .find("h6:last-child")
      .hide();
  }
}

/**
 * Displays or hides patch fields based on the selected patches option.
 *
 * @param {string} patches - The selected patch type (e.g., "leather-patch").
 * @param {jQuery Object} thisis - The current jQuery element where the patches are selected.
 *
 * @return {void} - This function does not return any value.
 */
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

/**
 * Displays or hides embroidery fields.
 *
 * @param {boolean} show - to show or hide the fields.
 *
 * @return {void} - This function does not return any value.
 */
function embroideryUpdates() {
  var firstValue = jQuery(".addlogo_colum:first-child")
    .find("select.printtype")
    .val();
  if (firstValue == "embroidery") {
    jQuery("#thread_colors_ar_ar_ar").show();
    jQuery("#d_puff_embroidery_wrapper").css("display", "flex");
  } else {
    jQuery("#thread_colors_ar_ar_ar").hide();
    jQuery("#d_puff_embroidery_wrapper").hide();
  }
}

/**
 * hightlight the fields in the price table
 *
 * @param {string} selector - which row to highlight.
 *
 * @return {void} - This function does not return any value.
 */
function extrafeeUpdate(selector) {
  const quantity = parseInt(sessionStorage.getItem("totalquantity"));
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
      $priceColumns.removeClass("bg-red");
      $currentElement.addClass("bg-red");
    } else if (quantity >= currentElementId || nextElementId === "") {
      $priceColumns.removeClass("bg-red");
      $currentElement.addClass("bg-red");
    }
  });

  // Reset title color if quantity is 0
  if (quantity === 0) {
    $selector.find(".title_ar_table").removeClass("bg-red");
  }
}
/**
 * remove the hightlights  in the price table
 *
 * @param {string} selector - which row to highlight.
 *
 * @return {void} - This function does not return any value.
 */
function resetExtraFeeRows(selector) {
  const $selector = jQuery(selector);
  // Reset background color for price columns
  $selector.find(".title_ar_table").removeClass("bg-red");
  $selector.find(".price_column_ar").removeClass("bg-red");
}

/**
 * updates the icon in the progress bar div
 */
function setIconsProgressbar(selector, corrected) {
  const $selector = jQuery(selector);
  if (corrected) {
    $selector.find(".tick_ar").removeClass("hide_it");
    $selector.find(".cross_ar").addClass("hide_it");
  } else {
    $selector.find(".tick_ar").addClass("hide_it");
    $selector.find(".cross_ar").removeClass("hide_it");
  }
}
/**
 * description : This function is used to update the setup fees progress bar based on quantity
 * @returns none
 */

function update_progressbar() {
  var quantity = parseInt(sessionStorage.getItem("totalquantity"));
  var totalnumbersrequired = 36;
  var progressbar = parseFloat((quantity / totalnumbersrequired) * 100).toFixed(
    2
  );
  var remainingquanityt = totalnumbersrequired - quantity;
  if (quantity < 36) {
    if (quantity < 12) {
      setIconsProgressbar("#freeitemsrequir_ar", false);
      setIconsProgressbar("#shippingitemsrequir_ar", false);
      setIconsProgressbar("#premiumitemsrequir_ar", false);
    } else if (quantity >= 12 && quantity < 24) {
      setIconsProgressbar("#freeitemsrequir_ar", true);
      setIconsProgressbar("#shippingitemsrequir_ar", false);
      setIconsProgressbar("#premiumitemsrequir_ar", false);
    } else if (quantity >= 24 && quantity < 36) {
      setIconsProgressbar("#freeitemsrequir_ar", true);
      setIconsProgressbar("#shippingitemsrequir_ar", true);
      setIconsProgressbar("#premiumitemsrequir_ar", false);
    }
    jQuery(".progressbar_quantity").css("width", progressbar + "%");
    jQuery("#quan_left_progress_ar").text(remainingquanityt);
    jQuery(".progressbar_quantity").css("background", "#aa1f22");
  } else if (quantity >= 36) {
    jQuery(".progressbar_quantity").css("background", "green");
    jQuery(".progressbar_quantity").css("width", "100%");
    jQuery("#quan_left_progress_ar").text(0);
    setIconsProgressbar("#freeitemsrequir_ar", true);
    setIconsProgressbar("#shippingitemsrequir_ar", true);
    setIconsProgressbar("#premiumitemsrequir_ar", true);
  }
}
/**
 * description : This function is used to get  array of all the print areas selected for the product
 *
 * @returns array of all the print areas
 */
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
  } else {
    resetExtraFeeRows("#extra_area_fee_ar");
  }

  return printareasall;
}

/**
 * description : This function is used to get the numbers of  extra colors
 *
 * @returns array of all the extra color areas
 */
function getExtraColorPrice() {
  var totalextracolors = 0;
  var extracolorsprice = 0;
  jQuery(".allprintareas .addlogo_colum").each(function () {
    var currentPrintTypes = jQuery(this).find("select.printtype").val();
    var currentColor = parseInt(jQuery(this).find("select.printcolors").val());
    if (currentColor > 3 && currentPrintTypes !== "leather-patch") {
      totalextracolors = totalextracolors + (currentColor - 3);
    }
  });
  if (totalextracolors > 0) {
    extrafeeUpdate("#extra_color_fee_ar");
  } else {
    resetExtraFeeRows("#extra_color_fee_ar");
  }
  return totalextracolors;
}

/**
 * description : This function is used to highlight the 3d puffing area in the price table
 *
 * @returns nine
 */
function getembroideryPuffPrice() {
  var firstPrintType = jQuery(".allprintareas .addlogo_colum")
    .eq(0)
    .find("select.printtype")
    .val();
  if (
    jQuery("#d_puff_embroidery").is(":checked") &&
    firstPrintType == "embroidery"
  ) {
    extrafeeUpdate("#d_3d_ar");
  } else {
    resetExtraFeeRows("#d_3d_ar");
  }
}

/**
 * description : This function is used to check if the user has selected premium artwork or not
 * @param  quantity : The quantity of the product
 * @returns none
 */
function check_premiumupdate() {
  var quantity = sessionStorage.getItem("totalquantity");
  var $premiumArtwork = jQuery("#premium_artwork_ar");
  var $premiumArtCheck = sessionStorage.getItem("premium_artwork")
    ? true
    : false;
  var shouldDisable = quantity >= 36;

  // If quantity is 36 or more, check and disable the checkbox
  if (shouldDisable) {
    $premiumArtwork.prop("checked", true).prop("disabled", true);
  }
  // If quantity is less than 36, keep it checked if it's already checked, or allow it to be unchecked
  else {
    $premiumArtwork.prop("disabled", false);
    console.log($premiumArtCheck);
    $premiumArtwork.prop("checked", $premiumArtCheck);
  }
}

/**
 * description : This function is used to remove the dollar sign from the price
 *
 * @returns return the price without the dollar sign
 */
function removeDollarSign(price) {
  if (price.includes("$")) {
    return parseFloat(price.replace(/\$/g, ""));
  } else {
    return parseFloat(price);
  }
}

/**
 * description : This function is used to check if the user has selected 3d puffing or not
 *
 * @returns price of the 3d puffing
 */
function check_embroidery() {
  var embroideryPrice = 0;
  if (jQuery("#d_3d_ar").find(".price_column_ar.bg-red").length > 0) {
    embroideryPrice = jQuery("#d_3d_ar")
      .find(".price_column_ar.bg-red")
      .find(".range_price_ar")
      .text();
    embroideryPrice = removeDollarSign(embroideryPrice);
  } else {
    embroideryPrice = 0;
  }
  return embroideryPrice;
}

/**
 * description : This function is used to check if the user has selected premium artwork or not
 *
 * @returns price of the premium artwork
 */
function check_Premium() {
  var premiumPrice = 0;
  var quantity = sessionStorage.getItem("totalquantity");
  if (jQuery("#premium_artwork_ar").is(":checked") && quantity < 36) {
    var value = jQuery("#premium_artwork_ar").val();
    premiumPrice = removeDollarSign(value);
  } else {
    premiumPrice = 0;
  }
  return premiumPrice;
}

/**
 * description : This function is used to update the setup fees progress along with the total price  based on quantity
 *
 * @returns none
 */
function updatePriceRowBeforeCart(totalprice, totalquantity, totalvariations) {
  jQuery("#heading_for_sub_total_ar .vairation_added_ar").text(totalvariations);
  jQuery("#heading_for_sub_total_ar .quantity_added_ar").text(totalquantity);
  var freesetupcharge = jQuery("#freesetup_charges_ar").attr("artsetup");
  jQuery("#span_ar_product").text(totalprice);
  if (parseInt(totalquantity) >= 12) {
    jQuery("#freesetup_charges_ar").text("0");
  } else {
    jQuery("#freesetup_charges_ar").text(freesetupcharge);
  }
}

/**
 * description : This function is used to calculate the total number of variations
 *
 * @returns total number of variations
 */
function calculateVariations(variationsWithQuanitity) {
  var TotalNonZeroQuantities = 0;
  variationsWithQuanitity.forEach(function (item) {
    if (parseInt(item["quantity"]) > 0) {
      TotalNonZeroQuantities++;
    }
  });
  return TotalNonZeroQuantities;
}

/**
 * description : This function is used to get the additional instructions
 *
 * @returns additional instructions
 */
function getAdditionalOptions() {
  if (jQuery("#add_instrution_ar").is(":checked")) {
    return jQuery("#add_instrution_ar_text").val();
  } else {
    return "";
  }
}

/**
 * description : This function is used to calculate the total price along with all the data user selected
 *
 * @returns data user selected
 */
function calculatePrice(cart = false) {
  var currentColor = jQuery(".active_swatch_ar").attr("attr-name");
  var totalprintarea = gettheprintareaarray();
  var totalprintcolors = getExtraColorPrice();
  var embroideryPrice = check_embroidery();
  var quantityDetails = quantity_counter();
  var pricePerProduct = 0;
  var totalPrice = 0;
  var sizeWithQuantity = quantityDetails["sizewithquantity"];
  var NonZeroVariations = calculateVariations(sizeWithQuantity);
  var numberOfVariations = sizeWithQuantity.length;
  var totalQuantity = quantityDetails["totalquantity"];
  var extraColorfeeUpdate = jQuery("#extra_color_fee_ar").find(
    ".price_column_ar.bg-red"
  );
  var extraColorPrice =
    extraColorfeeUpdate.length > 0
      ? removeDollarSign(extraColorfeeUpdate.find(".range_price_ar").text())
      : 0;
  if (parseInt(totalprintcolors) > 0) {
    console.log(extraColorPrice, totalprintcolors);
    extraColorPrice = parseFloat(
      parseFloat(extraColorPrice) * parseInt(totalprintcolors)
    ).toFixed(2);
    console.log(extraColorPrice);
  } else {
    extraColorPrice = 0;
  }
  var extraAreafeeUpdate = jQuery("#extra_area_fee_ar").find(
    ".price_column_ar.bg-red"
  );
  var extraAreaPrice =
    extraAreafeeUpdate.length > 0
      ? removeDollarSign(extraAreafeeUpdate.find(".range_price_ar").text())
      : 0;
  if (parseInt(totalprintarea.length) > 1) {
    var totalExtraArea = totalprintarea.length - 1;
    extraAreaPrice = parseFloat(
      parseFloat(extraAreaPrice) * parseInt(totalExtraArea)
    ).toFixed(2);
  } else {
    extraAreaPrice = 0;
  }
  var premium_artwork_price = check_Premium();

  var currentPrice = jQuery(".print_types_tables_ar")
    .find(".price_column_ar.bg-red")
    .find(".range_price_ar")
    .text();

  currentPrice = removeDollarSign(currentPrice);
  if (totalQuantity > 0) {
    pricePerProduct = parseFloat(
      currentPrice +
        parseFloat(extraColorPrice) +
        parseFloat(extraAreaPrice) +
        parseFloat(embroideryPrice) +
        parseFloat(premium_artwork_price)
    );
    totalPrice = parseFloat(totalQuantity * pricePerProduct).toFixed(2);
    jQuery("#single_add_to_cart_ar").removeClass("disabled_ar_product");
  } else {
    jQuery("#single_add_to_cart_ar").addClass("disabled_ar_product");
  }
  updatePriceRowBeforeCart(totalPrice, totalQuantity, NonZeroVariations);
  if (cart) {
    var productid = jQuery(".sizes_main_div_ar_ar > .size_column_ar")
      .find("input[type='number']")
      .attr("product-id");
    var productData = {};
    productData["productid"] = productid;
    productData["pricePerProduct"] = pricePerProduct;
    productData["totalPrice"] = totalPrice;
    productData["sizewithQuantity"] = sizeWithQuantity;
    productData["extraArea"] = totalprintarea;
    productData["embroideryEnabled"] = jQuery("#embroidery_ar").is(":checked");
    productData["premium_artwork_price"] = jQuery("#premium_artwork_ar").is(
      ":checked"
    );
    productData["color"] = currentColor;
    productData["additionalInstructions"] = getAdditionalOptions();
    productData["alreadyOrdered"] = jQuery("#orderedthislogo_ar").is(
      ":checked"
    );
    return productData;
  }
}

/**
 * description : This function is used to call all the functions
 *
 * @returns none
 */
function setCalcultor() {
  pricetablehightlight();
  update_progressbar();
  getembroideryPuffPrice();
  check_premiumupdate();
  calculatePrice();
}

/**
 * description : This function is used to add product to cart
 * @returns none
 */

function addProductToCart() {
  var productData = calculatePrice(true);
  jQuery.ajax({
    type: "POST",
    url: "/wp-admin/admin-ajax.php",
    data: {
      action: "cw_add_to_cart",
      productData: productData,
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
}
