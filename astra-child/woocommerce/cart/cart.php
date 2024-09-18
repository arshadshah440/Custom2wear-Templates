<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;
$delurl = get_stylesheet_directory_uri() . '/assets/img/delete.svg';
// Display WooCommerce breadcrumbs
if (function_exists('woocommerce_breadcrumb')) {
    woocommerce_breadcrumb();
}
do_action('woocommerce_before_cart'); ?>


<div class="d-flex-ar-no-align">

    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <?php do_action('woocommerce_before_cart_table'); ?>
        <h5 class="page_headings_titles">Cart Summary</h5>
        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0" id="cart_table_ar">
            <thead>
                <tr>
                    <th class="product-remove"><span class="screen-reader-text"><?php esc_html_e('Remove item', 'woocommerce'); ?></span></th>
                    <!-- <th class="product-thumbnail"><span class="screen-reader-text"><? php // esc_html_e('Thumbnail image', 'woocommerce'); 
                                                                                        ?></span></th> -->
                    <th class="product-name"><?php esc_html_e('Products', 'woocommerce'); ?></th>
                    <th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                    <th class="product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                    <th class="product-subtotal"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php do_action('woocommerce_before_cart_contents'); ?>

                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {

                    $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                    $variation_id = $cart_item['variation_id'];
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

                            <td class="product-remove">
                                <?php
                                echo apply_filters(
                                    'woocommerce_cart_item_remove_link',
                                    sprintf(
                                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"> <img src="' . esc_url($delurl) . '" alt="delete"/></a>',
                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                        esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                                        esc_attr($product_id),
                                        esc_attr($_product->get_sku())
                                    ),
                                    $cart_item_key
                                );
                                ?>
                            </td>

                            <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                <div class="d-flex-ar">
                                    <div class="thumbnail">
                                        <?php
                                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                        if (!$product_permalink) {
                                            echo $thumbnail; // PHPCS: XSS ok.
                                        } else {
                                            printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                                        }
                                        ?>
                                    </div>
                                    <div class="pdetails">
                                        <?php
                                        if (!$product_permalink) {
                                            echo wp_kses_post($product_name . '&nbsp;');
                                        } else {
                                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                        }

                                        do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                        // Meta data.
                                        ?>
                                        <div class="metaflex_ar">
                                            <?php
                                            $custom_color = WC()->session->get('custom_color_' . $variation_id);
                                            $custom_areas = WC()->session->get('custom_areas_' . $variation_id);
                                            $intruct = WC()->session->get('custom_instructions_' . $variation_id);
                                            $puff = WC()->session->get('custom_d3_embroidery_' . $variation_id);
                                            $puffclass = $puff ? "(3D Puff)" : "";

                                            if (!empty($custom_color)) {
                                                echo "<div class='color_attr_ar_cart'><h6>Color : <span>$custom_color</span></h6></div>";
                                            }
                                            ?>

                                            <div class="printareas_cart_ar">
                                                <?php
                                                $pdetails = get_field("product_extra_details", $product_id);
                                                echo $pdetails;
                                                // if (!empty($custom_areas) && is_array($custom_areas)) {
                                                //     $output = "<div class='size_attr_ar_cart'><h6>Print Areas : </h6>";
                                                //     foreach ($custom_areas as $area) {
                                                //         $printtype = !empty($area['printtype']) ? "<span>" . $area['printtype'] . "$puffclass</span> + " : "";
                                                //         $printarea = !empty($area['areavalue']) ? "<span>" . $area['areavalue'] . "</span> + " : "";
                                                //         $printcolor = !empty($area['printcolors']) ? "<span>" . $area['printcolors'] . " colors </span>  " : "";
                                                //         $artwork = !empty($area['artworkurl']) ? " + <a href='" . esc_url($area['artworkurl']) . "' target='_blank'>View Artwork</a></h6>" : "";

                                                //         $output .= "<h6>" . $printtype . $printarea . $printcolor . $artwork . "</h6>";
                                                //     }
                                                //     $output .= "</div>";
                                                //     echo $output;
                                                // }
                                                ?>
                                            </div>
                                            <!-- <?php //if (!empty($intruct)) { 
                                                    ?>
                                                <div class="instructionshere">
                                                    <h6>Additional Instructions:</h6>
                                                    <p><?php //echo esc_html($intruct); 
                                                        ?></p>
                                                </div>
                                            <?php // } 
                                            ?> -->
                                        </div>
                                    </div>
                                </div>
                                <?php
                                // Backorder notification.
                                if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                    echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                }
                                ?>
                            </td>

                            <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                <?php
                                // Get the current cart item
                                $cart_item = $cart_item ?? [];



                                // Retrieve the variation ID for the current cart item
                                $variation_size = $cart_item['variation']['attribute_pa_sizes'];

                                $variation_name = get_attribute_term_name_by_slug('sizes', $variation_size);

                                $variationquantity = $cart_item['quantity'];

                                // Get custom variations for the specific variation ID
                                $custom_variations = WC()->session->get('custom_variates_' . $variation_id);

                                echo "<h5 class='variations_on_cart_ar'>" . esc_html($variation_name) . " * " . esc_html($variationquantity) . "</h5>";


                                ?>
                            </td>


                            <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                <?php
                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                ?>
                                <p><?php echo $cart_item['extracharges'] ? "including setup fee($" . number_format($cart_item['extracharges'], 2) . ")" : ""; ?></p>
                            </td>
                            <td class="product-subtotal" data-title="<?php esc_attr_e('line_subtotal', 'woocommerce'); ?>">
                                <?php
                                echo "$" . number_format($cart_item['line_total'], 2);  // PHPCS: XSS ok.
                                ?>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>

                <?php do_action('woocommerce_cart_contents'); ?>
                <?php do_action('woocommerce_after_cart_contents'); ?>
            </tbody>

        </table>
        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

    <?php do_action('woocommerce_before_cart_collaterals'); ?>

    <div class="cart-collaterals w_43_ar" id="w_43_ar">
        <?php
        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action('woocommerce_cart_collaterals');
        ?>
    </div>
</div>
<?php do_action('woocommerce_after_cart'); ?>