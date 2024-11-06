<?php

/** single product template
 * astra
 * 
 * 
 * 
 * */

get_header();

// Get the global product object
global $product;
$featued_image = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));

$title = get_the_title();
$price = $product->get_price_html();
$shortdesc = $product->get_short_description();
// Get the review rating and count
$average = $product->get_average_rating();
$rating_count = $product->get_rating_count();
$terms = get_the_terms($product->get_id(), 'product_cat');
$has_size_variation = false;

// Check if the product is variable
if ( $product->is_type( 'variable' ) ) {
    // Get available variations
    $available_variations = $product->get_available_variations();
    
    // Check if 'size' is one of the attributes    
    foreach ( $available_variations as $variation ) {
       if ( isset( $variation['attributes']['attribute_pa_print-types'] ) && !empty( $variation['attributes']['attribute_pa_print-types'] ) &&  isset( $variation['attributes']['attribute_pa_color'] ) && !empty( $variation['attributes']['attribute_pa_color'] ) &&  isset( $variation['attributes']['attribute_pa_sizes'] ) && !empty( $variation['attributes']['attribute_pa_sizes'] ) ) {
            $has_size_variation = true;
            break;
        }
    }
} 
?>
<div class="breadcrumbs_ar">
    <div class="container_mi_ar">
        <?php
        // Display WooCommerce breadcrumbs
        if (function_exists('woocommerce_breadcrumb')) {
            woocommerce_breadcrumb();
        } ?>
    </div>

</div>
<section class="product_details_ar">
    <div class="container_mi_ar">
        <div class="d_flex_gap_50_ar">
            <div class="prod_left_mi_ar">
                <div class="slider_image_wraaper_ar">
                    <div class="vertical_slider_ar">
                        <?php echo do_shortcode('[private_products_carousel]'); ?>
                    </div>
                    <div class="featured_img_single_ar" id="product_main_image_ae">
                        <img src="<?php echo $featued_image; ?>" alt="Featured_image">
                    </div>
                </div>
                <div class="price_list_ar " id="move_mobile">
                    <?php echo do_shortcode('[cart_calculator_table]'); ?>
                </div>
            </div>
            <div class="prod_right_mi_ar">
                <div class="product_rating_ar">
                    <div class="star_rating_ar">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $average) {
                                echo '<i class="fa-solid fa-star"></i>';
                            } else {
                                echo '<i class="fa-regular fa-star"></i>';
                            }
                        }
                        ?>
                    </div>
                    <p class="font_14_400 text_dark_op60_ar mb_ar_0"><?php echo $rating_count; ?> reviews</p>
                </div>

                <h2 class="font_28_700 text_dark_ar"><?php echo $title; ?></h2>
                <div class="price_ar">
                    <p class="font_20_700 text_dark_ar"><?php echo $price; ?> <span class="font_16_400 text_dark_op60_ar">each item</span></p>
                </div>
                <p class="font_14_400 text_dark_op60_ar restricted_text_ar"><?php echo $shortdesc; ?></p>
                <?php
                $iscustomise = get_field("enable_customization");
                if ($product->get_type() === 'variable' && $iscustomise == true && $has_size_variation == true) {


                ?>
                    <div class="append_mobile" id="append_mobile">


                        <?php echo do_shortcode('[cart_calculator]'); ?>
                        <div class="thread_colors_ar">
                            <div class="color-thread-main">
                                <div class="color-thread" id="thread_colors_ar_ar_ar">
                                    <div class="color-thread-heading">
                                        <h2 class="margin-0 font_14_700 text_dark_ar"><?php echo get_field('thread_colors_section_title', 'options'); ?></h2>
                                        <!-- plus minus icons for accordian  -->
                                        <div class="color-thread-accord-icon">
                                            <i class="fa-solid fa-plus" style="display:none;"></i>
                                            <i class="fa-solid fa-minus"></i>
                                        </div>
                                    </div>
                                    <div class="color-thread-inner">
                                        <div class="color-thread-description">
                                            <p class="font_14_400 text_dark_op60_ar">
                                                <?php echo get_field('thread_colors_section_description', 'options'); ?>
                                            </p>
                                        </div>
                                        <!-- flex images and title  -->
                                        <?php
                                        if (have_rows('threads_colors', 'options')):
                                        ?>
                                            <div class="color-thread-images"><?php
                                                                                while (have_rows('threads_colors', 'options')): the_row();
                                                                                ?>
                                                    <div class="color-thread-img-text">
                                                        <img src="<?php echo get_sub_field('thread_image'); ?>" alt="">
                                                        <p class="font_12_400 text_dark_op60_ar"><?php echo get_sub_field('thread_title'); ?></p>
                                                    </div>
                                            <?php endwhile;
                                                                            endif;
                                            ?>

                                            </div>
                                    </div>
                                </div>
                                <div class='progressbarwrapper_quantity'>
                                    <div class='progressbar_quantity'></div>
                                </div>
                                <div class="color-thread-checks">
                                    <div class="color-checks-inner" id="freeitemsrequir_ar" valueprice="<?php echo get_field('art_setup_fee', 'options'); ?>">
                                        <div class="tick-cross-icons">
                                            <i class="fa-regular fa-circle-check tick_ar hide_it"></i>
                                            <i class="fa-regular fa-circle-xmark cross_ar"></i>
                                        </div>
                                        <p class="font_12_400 text_dark_op60_ar mb_ar_0"> <span class="font_12_700"> 12 + Items</span> Free Artwork Setup</p>
                                    </div>
                                    <div class="color-checks-inner" id="shippingitemsrequir_ar" valueprice="0">
                                        <div class="tick-cross-icons">
                                            <i class="fa-regular fa-circle-check tick_ar hide_it"></i>
                                            <i class="fa-regular fa-circle-xmark cross_ar"></i>
                                        </div>
                                        <p class="font_12_400 text_dark_op60_ar mb_ar_0"> <span class="font_12_700"> 24 + Items</span> Free Shipping </p>
                                    </div>
                                    <div class="color-checks-inner" id="premiumitemsrequir_ar" valueprice="<?php echo get_field('premium_artwork_setup_fee', 'options'); ?>">
                                        <div class="tick-cross-icons">
                                            <i class="fa-regular fa-circle-check tick_ar hide_it"></i>
                                            <i class="fa-regular fa-circle-xmark cross_ar"></i>
                                        </div>
                                        <p class="font_12_400 text_dark_op60_ar mb_ar_0"><span class="font_12_700"> 36 + Items </span>Free Premium Setup</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="addtocart_btn_wraper_ar" id="addtocarwrappere_ar">
                            <div class="subtotal_calc_ar">
                                <div class="wraper_ar" id="heading_for_sub_total_ar">
                                    <h2 class="font_20_600 text_dark_ar">Item subtotal <span class='smallerheadings_ar font_16_400 text_dark_op60_ar'> (<span class='vairation_added_ar'>0 </span> variations <span class='quantity_added_ar'>0</span> items) ($ <span id="freesetup_charges_ar" artsetup="<?php echo get_field('art_setup_fee', 'options'); ?>"><?php echo get_field('art_setup_fee', 'options'); ?></span> Artwork Setup)</span></h2>
                                </div>

                                <div class="wraper_ar" id="totalprice_ar_product">
                                    <h2 class="font_20_600 text_dark_ar" id="">$<span id="span_ar_product">0</span> </h2>
                                </div>
                            </div>
                            <div class="error_placer_ar" id="error_placer_ar">
                                <p><i class="fa-solid fa-circle-info"></i> <span id="erro_message_ar_list"></span></p>
                            </div>
                            <div class="actuall_btn_addtocart_ar disabled_ar_product" id="single_add_to_cart_ar">
                                <a href="#"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/Vector (29).svg'; ?>" alt=""> Add To Cart</a>
                            </div>
                        </div>
                    </div>

                <?php  } else
                    if (function_exists('woocommerce_template_single_add_to_cart')) {
                    // This function displays the default add-to-cart button
                    woocommerce_template_single_add_to_cart();
                }
                ?>
            </div>
        </div>
</section>

<section>
    <?php
    $prod_desc = $product->get_description();
    if (!empty($prod_desc)) {
    ?>
        <div class="container_mi_ar ">
            <div class="inner_wraaper_ar padding_80">
                <h2 class="font_28_700 text_dark_ar pd_desc_ar">Product Description</h2>
                <div class="divider_tp_ar"></div>
                <div class="product_desc_ar mb_t_20_ar">
                    <p><?php echo $prod_desc; ?></p>

                </div>
            </div>
        </div>
    <?php
    }

    ?>
</section>

<div class="customise_guide_ar" id="quixk_guides_ar">
    <div class="container_mi_ar">
        <?php include get_stylesheet_directory() . '/template-parts/single/producttabs.php'; ?>
    </div>
</div>

<!-- //need a hand -->
<?php include get_stylesheet_directory() . '/template-parts/single/needahand.php'; ?>
<?php
get_footer();
