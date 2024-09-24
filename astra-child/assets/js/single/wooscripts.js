var city = jQuery("#billing_city_field");
var state = jQuery("#billing_state_field");
var postcode = jQuery("#billing_postcode_field");
var phone = jQuery("#billing_phone_field");

setTimeout(function () {
  jQuery(
    "<div class='checkout_grid_ar' id='checkout_grid_ar'></div>"
  ).insertBefore("#billing_city_field");
  jQuery("#checkout_grid_ar").append(city);
  jQuery("#checkout_grid_ar").append(state);
  jQuery("#checkout_grid_ar").append(postcode);
  jQuery("#checkout_grid_ar").append(phone);
}, 2000);
