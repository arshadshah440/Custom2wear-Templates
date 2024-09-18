<?php
// Get the order items
foreach ($order->get_items() as $item_id => $item) {
    // Get the product ID
    $product_id = $item->get_product_id();

    // Get custom field data
    $custom_field = get_field("product_extra_details", $product_id);

    // Display product ID

    // Display custom field data
    if (!empty($custom_field)) {
        echo '<div class="product_ar_order_details"><p>' . esc_html($custom_field) . '</p></div>';
    }
}
