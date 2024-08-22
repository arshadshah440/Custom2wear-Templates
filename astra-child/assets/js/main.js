jQuery(document).ready(function () {
  jQuery("#accordian_wrapper_ar").on(
    "click",
    ".accordian_ar_mi_head",
    function () {
      jQuery(this).siblings(".accordian_ar_mi_desc").slideToggle();
      jQuery(this).find(".accord_icons_ar i").toggle();
    }
  );
  jQuery(".footer_wrapper_ar").on(
    "click",
    ".footer_acc_head_ar",
    function () {
      jQuery(this).siblings(".footer_acc_body_ar").slideToggle();
      jQuery(this).find(".footer_acc_icons_ar i").toggle();
    }
  );
  jQuery(".filter_accordian_item_ar").on(
    "click",
    ".filter_acc_head_ar",
    function () {
      jQuery(".filter_acc_head_ar")
        .not(this)
        .siblings(".filter_acc_body_ar")
        .removeClass("active_filter_ar");
      jQuery(".filter_acc_head_ar").not(this).addClass("closed_filter_head_ar");

      if (
        jQuery(this)
          .siblings(".filter_acc_body_ar")
          .hasClass("active_filter_ar")
      ) {
        jQuery(this)
          .siblings(".filter_acc_body_ar")
          .removeClass("active_filter_ar");
      } else {
        jQuery(this)
          .siblings(".filter_acc_body_ar")
          .addClass("active_filter_ar");
        jQuery(this).removeClass("closed_filter_head_ar");
      }
      jQuery(this).find(".filter_acc_icon_ar i").toggle();
    }
  );

  jQuery("#mobile_menu_toggler_ar").on("click",function(){
      jQuery("#mobile_nav_ar").slideToggle();
  });
  jQuery("#search_btn_ar").on("click",function(e){
      e.preventDefault();
      jQuery("#search_form_ar").css("display","flex");
  });
  jQuery("#close_btn_ar").on("click",function(){
      jQuery("#mobile_nav_ar").slideToggle();
  })
  jQuery("#searchclose_btn_ar").on("click",function(){
      jQuery("#search_form_ar").hide();
  })

  // const slider1_ar = document.getElementById("slider1_ar");
  // const slider2_ar = document.getElementById("slider2_ar");
  // const minValueLabel_ar = document.getElementById("min-value_ar");
  // const maxValueLabel_ar = document.getElementById("max-value_ar");
  // const sliderTrack_ar = document.getElementById("slider-track_ar");

  // function updateSliderTrack_ar() {
  //   const minVal_ar = parseInt(slider1_ar.value);
  //   const maxVal_ar = parseInt(slider2_ar.value);
  //   const percentageMin_ar = (minVal_ar / slider1_ar.max) * 100;
  //   const percentageMax_ar = (maxVal_ar / slider2_ar.max) * 100;

  //   sliderTrack_ar.style.left = percentageMin_ar + "%";
  //   sliderTrack_ar.style.width = percentageMax_ar - percentageMin_ar + "%";
  // }

  // slider1_ar.addEventListener("input", () => {
  //   const minValue_ar = Math.min(
  //     parseInt(slider1_ar.value),
  //     parseInt(slider2_ar.value)
  //   );
  //   minValueLabel_ar.textContent = `$${minValue_ar.toLocaleString()}`;
  //   updateSliderTrack_ar();
  // });

  // slider2_ar.addEventListener("input", () => {
  //   const maxValue_ar = Math.max(
  //     parseInt(slider1_ar.value),
  //     parseInt(slider2_ar.value)
  //   );
  //   maxValueLabel_ar.textContent = `$${maxValue_ar.toLocaleString()}`;
  //   updateSliderTrack_ar();
  // });

  // // Initialize the slider track
  // updateSliderTrack_ar();
});

document.addEventListener("DOMContentLoaded", function () {
  const minPrice = document.getElementById("min-price");
  const maxPrice = document.getElementById("max-price");
  const minPriceDisplay = document.getElementById("min-price-display");
  const maxPriceDisplay = document.getElementById("max-price-display");

  function updateSliderRange() {
    const min = parseInt(minPrice.value);
    const max = parseInt(maxPrice.value);

    if (min > max) {
      [minPrice.value, maxPrice.value] = [maxPrice.value, minPrice.value];
    }

    minPriceDisplay.textContent = `$${minPrice.value}`;
    maxPriceDisplay.textContent = `$${maxPrice.value}`;

    const sliderRange = document.querySelector(".slider-range");
    sliderRange.style.left = `${(minPrice.value / minPrice.max) * 100}%`;
    sliderRange.style.width = `${
      ((maxPrice.value - minPrice.value) / maxPrice.max) * 100
    }%`;
  }

  minPrice.addEventListener("input", updateSliderRange);
  maxPrice.addEventListener("input", updateSliderRange);

  // Initial range setup
  const sliderContainer = document.querySelector(".price-slider");
  const sliderRange = document.createElement("div");
  sliderRange.classList.add("slider-range");
  sliderContainer.appendChild(sliderRange);

  updateSliderRange();
});
