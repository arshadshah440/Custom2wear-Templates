jQuery(document).ready(function () {
  jQuery("#mobile_nav_ar").on("click",'li a',function(event){
  var currentelement=jQuery(this);
  if(event.target.tagName === 'I' || event.target.tagName == 'i') {
      event.preventDefault(); // Prevent redirection

    currentelement.closest("li").find("ul").toggleClass('active_mobile_class_ar');
    }	  
  })
  jQuery("#accordian_wrapper_ar").on(
    "click",
    ".accordian_ar_mi_head",
    function () {
      jQuery(this).siblings(".accordian_ar_mi_desc").slideToggle();
      jQuery(this).find(".accord_icons_ar i").toggleClass("active_mobile_class_ar");
    }
  );
  jQuery(".footer_wrapper_ar").on("click", ".footer_acc_head_ar", function () {
    jQuery(this).siblings(".footer_acc_body_ar").slideToggle();
    jQuery(this).find(".footer_acc_icons_ar i").toggle();
  });
  jQuery(".color-thread-heading").on("click", function () {
    jQuery(this).siblings(".color-thread-inner").slideToggle();
    jQuery(this).find(".color-thread-accord-icon i").toggle();
  });
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

  jQuery("#mobile_menu_toggler_ar").on("click", function () {
    jQuery("#mobile_nav_ar").slideToggle();
  });
  jQuery("#search_btn_ar").on("click", function (e) {
    e.preventDefault();
    jQuery("#search_form_ar").css("display", "flex");
  });
  jQuery("#close_btn_ar").on("click", function () {
    jQuery("#mobile_nav_ar").slideToggle();
  });
  jQuery("#searchclose_btn_ar").on("click", function () {
    jQuery("#search_form_ar").hide();
  });
});
function openTab(evt, tabName) {
  // Hide all tab content
  const tabContent = document.getElementsByClassName("tab-content_ar");
  for (let i = 0; i < tabContent.length; i++) {
    tabContent[i].style.display = "none";
  }

  // Remove the active class from all tab links
  const tabLinks = document.getElementsByClassName("tab-link_ar");
  for (let i = 0; i < tabLinks.length; i++) {
    tabLinks[i].className = tabLinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Set the default tab to be open
// document.addEventListener("DOMContentLoaded", () => {
//   document.getElementsByClassName(".first_tab_ar").style.display = "block";
// });

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
