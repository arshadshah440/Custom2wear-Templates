/**
 * Main function that handles the click event for adding another print area.
 * @param {Object} e - The event object from the click handler.
 */
function handleAddAnotherOneClick(e) {
  let arrayval = collectPrintAreaValues();
  let $firstColum = jQuery(".addlogo_colum").first();
  let firstValue = $firstColum.find("select.printtype").val();
  let firstValueCat = $firstColum.find("select.printtype").attr("current-cat");
  let firstValueArea = $firstColum.find("select.printarea").val();

  if (isValidToAdd(arrayval, firstValue, firstValueCat, firstValueArea)) {
    addNewPrintArea(arrayval, firstValue, firstValueCat);
    hideAddButtonIfLimitReached(arrayval);
  } else {
    showWarning(arrayval.length, firstValue, firstValueCat, firstValueArea);
  }
}

/**
 * Collects selected values from all print area dropdowns.
 * @returns {Array} - An array containing the selected print area values.
 */
function collectPrintAreaValues() {
  let arrayval = [];
  jQuery(".addlogo_colum").each(function () {
    arrayval.push(jQuery(this).find("select.printarea").val());
  });
  return arrayval;
}

/**
 * Validates whether a new print area can be added.
 * @param {Array} arrayval - The current list of selected print area values.
 * @param {string} firstValue - The value of the first print type.
 * @param {string} firstValueCat - The category of the first print type.
 * @param {string} firstValueArea - The value of the first print area.
 * @returns {boolean} - Returns true if a new area can be added, false otherwise.
 */
function isValidToAdd(arrayval, firstValue, firstValueCat, firstValueArea) {
  return arrayval.length < 4 && firstValue && firstValueCat && firstValueArea;
}

/**
 * Adds a new print area by cloning the last existing area and adjusting its properties.
 * @param {Array} arrayval - The current list of selected print area values.
 * @param {string} firstValue - The value of the first print type.
 * @param {string} firstValueCat - The category of the first print type.
 */
function addNewPrintArea(arrayval, firstValue, firstValueCat) {
  let $newColum = jQuery(".addlogo_colum").last().clone();
  $newColum.appendTo(".allprintareas");

  // Disable areas for all but the last child
  jQuery(".addlogo_colum")
    .not(":last-child")
    .find("select.printarea")
    .siblings(".custom_dropdown_ar_ar")
    .addClass("disabled_ar_options_ar");

  handlePrintType(firstValueCat, firstValue, $newColum, arrayval);

  // Enable colors select and update the new column's image
  $newColum.find(".printcolors").prop("disabled", false);
  $newColum
    .find(".size_name_upload > img")
    .attr(
      "src",
      "https://custom2wear.mi6.global/wp-content/uploads/2024/05/Frame-1000005041.svg"
    );
}

/**
 * Hides the "Add Another" button if more than 2 print areas are added.
 * @param {Array} arrayval - The current list of selected print area values.
 */
function hideAddButtonIfLimitReached(arrayval) {
  if (arrayval.length == 2) {
    jQuery(".addanotherone_ar").hide();
  }
}

/**
 * Handles logic related to the print type for different product categories.
 * @param {string} firstValueCat - The category of the first print type.
 * @param {string} firstValue - The value of the first print type.
 * @param {Object} $newColum - The new cloned print area column.
 * @param {Array} arrayval - The current list of selected print area values.
 */
function handlePrintType(firstValueCat, firstValue, $newColum, arrayval) {
  if (firstValueCat === "polos" || firstValueCat === "t-shirt") {
    handleClothingPrintType(firstValue, $newColum);
  } else {
    handleOtherPrintType(firstValueCat, firstValue, $newColum, arrayval);
  }
}

/**
 * Handles print type and color options for clothing categories (polos, t-shirts).
 * @param {string} firstValue - The value of the first print type.
 * @param {Object} $newColum - The new cloned print area column.
 */
function handleClothingPrintType(firstValue, $newColum) {
  if (firstValue !== "digital-print") {
    $newColum.find(".printcolors option[value='11']").hide();
  }
  $newColum.find("select.printtype").val(firstValue);
}

/**
 * Handles print type and color options for non-clothing categories.
 * @param {string} firstValueCat - The category of the first print type.
 * @param {string} firstValue - The value of the first print type.
 * @param {Object} $newColum - The new cloned print area column.
 * @param {Array} arrayval - The current list of selected print area values.
 */
function handleOtherPrintType(firstValueCat, firstValue, $newColum, arrayval) {
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

/**
 * Resets the select state for the print area dropdown in a column.
 * @param {Object} $colum - The column for which the select state will be reset.
 */
function resetSelectState($colum) {
  $colum.find("select.printarea").prop("disabled", false);
  let $firstOption = $colum.find("select.printarea option").first();
  $colum.find("select.printarea").val($firstOption.val());
  $colum.find(".custom_dropdown_ar_ar").removeClass("disabled_ar_options_ar");
  $colum.find("h6[values='embroidery']").trigger("click");
  $colum.find("h6:first-child").trigger("click");
}

/**
 * Selects the first valid (enabled) print area option in the new column.
 * @param {Object} $colum - The new cloned print area column.
 * @param {Array} arrayval - The current list of selected print area values.
 */
function selectFirstValidOption($colum, arrayval) {
  let $options = $colum.find("select.printarea option");

  $options.each(function (index) {
    if (arrayval.includes(jQuery(this).val())) {
      disableOption($colum, jQuery(this));

      if (index === $options.length - 1) {
        selectFirstEnabledOption($colum, $options);
      } else {
        selectNextOption($colum, jQuery(this));
      }
    }
  });
}

/**
 * Disables a print area option and its corresponding UI element.
 * @param {Object} $colum - The new cloned print area column.
 * @param {Object} $option - The option to disable.
 */
function disableOption($colum, $option) {
  $option.prop("disabled", true);
  $colum
    .find("h6[values='" + $option.val() + "']")
    .addClass("disabled_ar_options_ar");
}

/**
 * Selects the next valid (enabled) print area option.
 * @param {Object} $colum - The new cloned print area column.
 * @param {Object} $currentOption - The current option being processed.
 */
function selectNextOption($colum, $currentOption) {
  let nextOption = $currentOption.next().val();
  $colum.find("select.printarea").val(nextOption);
  $colum.find("h6[values='" + nextOption + "']").trigger("click");
}

/**
 * Selects the first enabled print area option in the list.
 * @param {Object} $colum - The new cloned print area column.
 * @param {Object} $options - The list of print area options.
 */
function selectFirstEnabledOption($colum, $options) {
  $options.each(function () {
    if (!jQuery(this).prop("disabled")) {
      let value = jQuery(this).val();
      if (value != "") {
        $colum.find("select.printarea").val(value);
        $colum.find("h6[values='" + value + "']").trigger("click");
        return false; // Break loop
      }
    }
  });
}

/**
 * Shows appropriate warning messages based on user input.
 * @param {number} arrayLength - The number of print areas added.
 * @param {string} firstValue - The value of the first print type.
 * @param {string} firstValueCat - The category of the first print type.
 * @param {string} firstValueArea - The value of the first print area.
 */
function showWarning(arrayLength, firstValue, firstValueCat, firstValueArea) {
  if (arrayLength >= 4) {
    jQuery(".error_message")
      .text("You cannot add more than 3 print areas.")
      .fadeIn(400)
      .delay(3000)
      .fadeOut(400);
  } else if (!firstValue || !firstValueCat || !firstValueArea) {
    jQuery(".error_message")
      .text(
        "Please fill in the first print area details before adding another."
      )
      .fadeIn(400)
      .delay(3000)
      .fadeOut(400);
  }
}
