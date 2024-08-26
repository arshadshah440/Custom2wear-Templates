function horizontalslider(
  $selector,
  $loop,
  $margin,
  $stagePadding,
  $dots,
  $mobile,
  $tab,
  $desktop
) {
  jQuery($selector).owlCarousel({
    items: 6,
    loop: $loop,
    stagePadding: $stagePadding,
    margin: $margin,
    responsiveClass: true,
    dots: $dots,
    responsive: {
      0: {
        items: $mobile,
        nav: false,
      },
      600: {
        items: $tab,
        nav: false,
      },
      1000: {
        items: $desktop,
        nav: false,
        loop: true,
      },
    },
  });
}
jQuery(document).ready(function () {
  horizontalslider("#best_seller_slider_ar", true, 20,0, true, 2, 6, 6);
  horizontalslider("#featured_slider_ar", true, 20,0, true, 2, 6, 6);
  jQuery(".prev_ar").on("click", function () {
      jQuery(this).closest("section").find(".owl-carousel").trigger("prev.owl.carousel");
  });
  jQuery(".next_ar").on("click", function () {
      jQuery(this).closest("section").find(".owl-carousel").trigger("next.owl.carousel");
  });
  if (window.matchMedia("(max-width: 850px)").matches) {
    horizontalslider("#testimonials_slider_ar", true, 20,0, true, 1, 3, 3);
  }else{
    horizontalslider("#testimonials_slider_ar", true, 20,120, true, 1, 3, 3);
  }
});