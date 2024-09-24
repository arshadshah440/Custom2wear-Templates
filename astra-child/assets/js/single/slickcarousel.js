jQuery(document).ready(function ($) {
  function slickslideroptcl(selector) {
    jQuery(selector).slick({
      arrows: false,
      dots: false,
      speed: 300,
      slidesToShow: 5,
      slidesToScroll: 3,
      verticalSwiping: true,
      infinite: true,
      vertical: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 5,
            slidesToScroll: 3,
            dots: true,
          },
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
            vertical: true,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 4,
            vertical: false,
          },
        },
      ],
    });
    $(".slick-prev-btn").click(function () {
      $(selector).slick("slickPrev");
    });

    $(".slick-next-btn").click(function () {
      $(selector).slick("slickNext");
    });
    $(".slick-prev-btn").addClass("slick-disabled");
    $(selector).on("afterChange", function () {
      if ($(".slick-prev").hasClass("slick-disabled")) {
        $(".slick-prev-btn").addClass("slick-disabled");
      } else {
        $(".slick-prev-btn").removeClass("slick-disabled");
      }
      if ($(".slick-next").hasClass("slick-disabled")) {
        $(".slick-next-btn").addClass("slick-disabled");
      } else {
        $(".slick-next-btn").removeClass("slick-disabled");
      }
    });
    jQuery(selector).css("display", "block");
  }

  //   for example
  slickslideroptcl("#pr_image_vslider");
});
