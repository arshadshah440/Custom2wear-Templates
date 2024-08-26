<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;





// shortcode

function private_products_carousel_shortcode($atts)
{
    ob_start();

    // Shortcode attributes

    global $product;

    $attachment_ids = $product->get_gallery_image_ids();

    // Output carousel HTML
    if (count($attachment_ids) > 0) {
?>
        <div class="pr_image_vslider" id="pr_image_vslider">
            <?php
            foreach ($attachment_ids as $attachment_id) {
                $associatedimg = $attachment_id;
            ?>
                <div class="item_ar vendor_loop_item">
                    <img src="<?php echo wp_get_attachment_url($associatedimg); ?>" alt="" srcset="<?php echo wp_get_attachment_image_srcset($associatedimg); ?>">
                </div>
            <?php    }
            ?>
        </div>
        <div class="slick_carousel_nav">
            <div class="slick-next-btn">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/up.svg" class="img-fluid w-40">
            </div>
            <div class="slick-prev-btn">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/down.svg" class="img-fluid w-40">
            </div>
        </div>

    <?php

    }

    return ob_get_clean();
}
add_shortcode('private_products_carousel', 'private_products_carousel_shortcode');

add_action('woocommerce_cart_calculate_fees', 'remove_shipping_cost_for_large_quantity');

function remove_shipping_cost_for_large_quantity()
{
    global $woocommerce;

    // Check if cart is empty to prevent errors
    if (is_admin() && !defined('DOING_AJAX'))
        return;

    // Get the total quantity of items in the cart
    $total_quantity = $woocommerce->cart->get_cart_contents_count();

    // If the total quantity is more than 10, set shipping cost to zero
    if ($total_quantity > 24) {
        foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) {
            $cart_item['data']->set_shipping_class_id(0);
        }
        // Remove shipping cost
        $woocommerce->cart->add_fee('Free Shipping', -$woocommerce->cart->shipping_total);
    }
}

function cart_calculator_shortcode($atts)
{
    ob_start();

    // Shortcode attributes

    global $product;

    $id = $product->get_id();

    $enable = get_field("enable_customization");

    // color swatches
    get_swatches_ar('color');
    // Output carousel HTML
    //get sizes
    get_sizes_with_quantity();
    if ($enable) {

        getlogo_print();
    }
    // show_add_logo_print();

    return ob_get_clean();
}
add_shortcode('cart_calculator', 'cart_calculator_shortcode');

function cart_calculator_table_shortcode($atts)
{
    ob_start();

    // Shortcode attributes

    global $product;

    $id = $product->get_id();
    $enable = get_field("enable_customization");
    // Output carousel HTML
    if ($enable) {
        get_price_table_ar_all($id);
    }
    // show_add_logo_print();

    return ob_get_clean();
}
add_shortcode('cart_calculator_table', 'cart_calculator_table_shortcode');

function get_price_table_ar($repeaterfield, $displayset, $title)
{
    if (have_rows("$repeaterfield")) {
        $count = count(get_field("$repeaterfield"));
        $idofdiv = explode('_', $repeaterfield);
        $countofid = count($idofdiv);
    ?>
        <div class="normal_price_table_ar grid_tem_ar<?php echo $count + 1; ?> <?php echo $displayset; ?>" id="<?php echo $idofdiv[$countofid - 1] . '_ar'; ?>">
            <div class="title_ar_table">
                <h6><?php echo $title; ?></h6>
            </div>
            <?php
            while (have_rows("$repeaterfield")) {
                the_row();
                $range = get_sub_field('quantity_range');
                $price = get_sub_field('product_price_for_the_range');
            ?>

                <div class="price_column_ar" quantity-id="<?php echo $range; ?>">
                    <div class="range_ar"> <?php echo $range; ?> Item</div>
                    <div class="range_price_ar">$ <?php echo $price; ?></div>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
    }
}
function get_price_table_ar_all($product_id)
{
    $currentid = $product_id;
    $discount_type = get_field('select_the_discount_type', 'options');
    $percentage_discount = get_field('percentage_discount', 'options');
    $fixed_amount_discount = get_field('fixed_amount_discount', 'options');
    $discount_location = get_field('apply_this_discount_to_all_products', 'options');
    $select_your_product = get_field('select_your_product', 'options');
    $pricearray = array();
    if ($discount_location == 'yes') {
        $pricearray = get_pricing_listing();
    } else {
        if (in_array($currentid, $select_your_product)) {
            $pricearray = get_pricing_listing();
        }
    }

    if (count($pricearray) > 0) {
    ?>
        <h2 id="price_calculator_ar_ar">Price calculator</h2>
        <div class="normal_price_table_ar_all" id="normal_price_table_ar">

            <div class="grid_tem_ar8">
                <div class="title_ar_table">
                    <h6>Print Type</h6>
                </div>
                <div class="price_column_ar">
                    <div class="range_ar"> 1 Item</div>
                </div>
                <div class="price_column_ar">
                    <div class="range_ar"> 12 Item</div>
                </div>
                <div class="price_column_ar">
                    <div class="range_ar"> 48 Item</div>
                </div>
                <div class="price_column_ar">
                    <div class="range_ar"> 96 Item</div>
                </div>
                <div class="price_column_ar">
                    <div class="range_ar"> 144 Item</div>
                </div>
                <div class="price_column_ar">
                    <div class="range_ar"> 288 Item</div>
                </div>
                <div class="price_column_ar">
                    <div class="range_ar"> 432 Item</div>
                </div>
            </div>
            <?php
            foreach ($pricearray as $arrayskey => $value) {
                $title = $value['name'];
                $price = number_format($value['price']);
                $id = $value['slug'];
                $discounted_array = null;
                if (trim($discount_type) == 'percentage') {
                    $discounted_array = get_percentage_discount($price, $percentage_discount);
                } else {
                    $discounted_array = get_fixed_discount($price, $fixed_amount_discount);
                }
            ?>
                <div class="grid_tem_ar8" id="<?php echo $id; ?>">
                    <div class="title_ar_table">
                        <h6><?php echo $title; ?></h6>
                    </div>
                    <?php
                    foreach ($discounted_array as $key => $value) {
                        $numberindex = explode("_", $key)[1];

                    ?>
                        <div class="price_column_ar" quantity-id="<?php echo $numberindex; ?>">
                            <div class="range_price_ar"><?php echo (!empty($value) ? "$ " . $value : ""); ?></div>
                        </div>
                    <?php

                    }
                    ?>
                </div>

            <?php
            }
            ?>
        </div>
    <?php
    }
}

function get_percentage_discount($price, $percentages)
{
    $item1 = $percentages['enter_the_discount_percentage_for_1_item'];
    $item12 = $percentages['enter_the_discount_percentage_for_12_item'];
    $item48 = $percentages['enter_the_discount_percentage_for_48_item'];
    $item96 = $percentages['enter_the_discount_percentage_for_96_item'];
    $item144 = $percentages['enter_the_discount_percentage_for_144_item'];
    $item288 = $percentages['enter_the_discount_percentage_for_288_item'];
    $item432 = $percentages['enter_the_discount_percentage_for_432_item'];
    $percentage_discounts = [
        'item_1' => calculate_discount_percentage($price, $item1),
        'item_12' => calculate_discount_percentage($price, $item12),
        'item_48' => calculate_discount_percentage($price, $item48),
        'item_96' => calculate_discount_percentage($price, $item96),
        'item1_44' => calculate_discount_percentage($price, $item144),
        'item_288' => calculate_discount_percentage($price, $item288),
        'item_432' => calculate_discount_percentage($price, $item432),
    ];
    return $percentage_discounts;
}
function calculate_discount_percentage($price, $percentages)
{
    $newprice = $price * ($percentages / 100);
    $newprice = round($newprice, 2);
    $newprice = $price - $newprice;
    return $newprice;
}
function get_fixed_discount($price, $percentages)
{
    $item1 = $percentages['enter_the_fixed_amount_discount_for_1_item'];
    $item12 = $percentages['enter_the_fixed_amount_discount_for_12_item'];
    $item48 = $percentages['enter_the_fixed_amount_discount_for_48_item'];
    $item96 = $percentages['enter_the_fixed_amount_discount_for_96_item'];
    $item144 = $percentages['enter_the_fixed_amount_discount_for_144_item'];
    $item288 = $percentages['enter_the_fixed_amount_discount_for_288_item'];
    $item432 = $percentages['enter_the_fixed_amount_discount_for_432_item'];
    $fixed_discounts = [
        'item_1' => calculate_fixed_percentage($price, $item1),
        'item_12' => calculate_fixed_percentage($price, $item12),
        'item_48' => calculate_fixed_percentage($price, $item48),
        'item_96' => calculate_fixed_percentage($price, $item96),
        'item_144' => calculate_fixed_percentage($price, $item144),
        'item_288' => calculate_fixed_percentage($price, $item288),
        'item_432' => calculate_fixed_percentage($price, $item432),
    ];
    return $fixed_discounts;
}
function calculate_fixed_percentage($price, $fixamount)
{
    $newprice = $price - ($fixamount);
    return $newprice;
}
// get swatches 

function get_swatches_ar($color)
{
    global $product;
    $currentid = $product->get_id();

    $color_terms = $product->get_attribute("$color");
    if (!empty($color_terms)) {
        $output = "<div class='swatches_ar'> <h5>Color</h5><div class='innerwrap'>";

        $detailed_terms = array();
        $color_termsa_ar =  explode(",", $color_terms);
        $type = get_the_attribute_type("$color");

        foreach ($color_termsa_ar as $color_term) {
            $term = get_term_by('name', $color_term, 'pa_color'); // Use 'pa_' prefix for WooCommerce attributes
            $image = wp_get_attachment_image_url(get_term_meta($term->term_id)['attribute_image']);
            $backdound = "";
            $swatehcs = get_term_meta($term->term_id)['product_attribute_color'][0];
            if (!empty($image)) {
                $backdound = "background-image:url('$image')";
            } else {
                $backdound = "background-color:$swatehcs";
            }
            $name = $type == "color" ? '' : "<span>$term->name</span>";

            if ($term) {
                $output .= "<div class='swatch_ar' pid='" . $currentid . "' attr-name='" . $term->slug . "' style='" . $backdound . "'> $name</div>";
            }
        }

        $output .= "</div></div>";
        echo $output;
    }
}

function get_acf_swatches_ar()
{
    global $product;
    $proid = $product->get_id();
    $output = "<div class='swatches_ar'> <h5>Color</h5><div class='innerwrap'>";

    if (have_rows("color_attributes_with_image", $proid)) {
        while (have_rows("color_attributes_with_image", $proid)) {
            the_row();
            $colorswatch = get_sub_field("color_swatch");
            $colorname = strtolower(str_replace(" ", "", get_sub_field("color_name")));
            $output .= "<div class='swatch_ar' attr-name='" . $colorname . "' style='background-image:url(" . $colorswatch . ")'></div>";
        }
    }

    $output .= "</div></div>";
    echo $output;
}
function get_patch_swatches_ar()
{
    global $product;
    $proid = $product->get_id();
    $output = "<div class='innerwrap'>";

    if (have_rows("patch_colors", 'options')) {
        while (have_rows("patch_colors", 'options')) {
            the_row();
            $colorswatch = get_sub_field("color_swatch");
            $colorname = strtolower(str_replace(" ", "", get_sub_field("color_name")));
            $output .= "<div class='swatch_ar' attr-name='" . $colorname . "' style='background-image:url(" . $colorswatch . ")'></div>";
        }
    }

    $output .= "</div>";
    echo $output;
}

function get_sizes_with_quantity()
{
    global $product;
    $sizes = $product->get_attribute('sizes');
    // Check if the product is a variable product

    $infoicon = get_stylesheet_directory_uri() . '/assets/info.svg';
    $tooltipicon = get_stylesheet_directory_uri() . '/assets/arrowtip.svg';
    $premiumsetupfee = get_field('premium_artwork_setup_fee', 'options');
    if (!empty($sizes)) {

        $output = "<div class='sizes_ar'> <div class='d-flex-between-spac-ar sizes_ar_headings_ar'> <h5>Size and Quantity</h5> <h6>Quantity: <span id='main_quantity_ar'><b>0</b></span></h6> </div> <div class='quantity_and_info_ar'> <div class='innerwrap sizes_main_div_ar_ar'>";
        $sizes_ar =  explode(",", $sizes);
        if (count($sizes_ar) > 1) {

            foreach ($sizes_ar as $size) {
                $size_slug = sanitize_title(trim($size));
                $variation = has_a_variation($size_slug, 'attribute_pa_sizes');

                if ($variation) {
                    $output .= "<div class='size_column_ar'> <div class='size_name'> <h6>" . $size . "</h6></div> <div class='sizes_quantity'><input type='number' placeholder='0' min='0' value='0' name='input_sizes' product-id='" . $product->get_id() . "'></div></div>";
                }
            }
        } else {
            $size = trim($sizes_ar[0]);
            $size_slug = sanitize_title($size);
            $variation = has_a_variation($size_slug, 'attribute_pa_sizes');
            if ($variation) {
                $output .= "<div class='size_column_ar'> <div class='size_name'> <h6>" . $size . "</h6></div> <div class='sizes_quantity'><input type='number' placeholder='0' min='0' value='0' name='input_sizes' product-id='" . $product->get_id() . "'></div></div>";
            }
        }

        // freesetup
        $freeartss = "<div class='freeoptions_progress_wrap'> <div class='progressbarwrapper_head'><h3 id='addmore_headings_arprg'>Add more <span id='quan_left_progress_ar'>36</span> to avail offer</h3> <div class='tooltip_info_ar'><img src='$infoicon' alt='' id='infoicon_ar_premium_setup'> <div class='tooltip_data_ar' id='tooltip_data_ar_premium_setup'><img src='$tooltipicon' alt='' class='tooltip_arrow_ar'> <p id='premium_setup_tooltop_para_ar'>Premium Artwork Setup $30 (Digital Mockup, Unlimited Revisions, Photo of physical patch sent for approval)    </p></div></div>  </div> <div class='progressbarwrapper_quantity'> <div class='progressbar_quantity'></div></div> <div class='progress_footer_arr'><h2 id='heading_of_free_feature_ar'>Free Premium Artwork Setup <span>$$premiumsetupfee</span> </h2></div> </div>";
        $output .= "</div> $freeartss  </div></div>";
        echo $output;
    } else {
        // $output = "<div class='sizes_ar'> <div class='d-flex-between-spac-ar sizes_ar_headings_ar'> <h5>Size and Quantity</h5> <h6>Quantity: <span id='main_quantity_ar'><b>0</b></span></h6> </div> <div class='quantity_and_info_ar'> <div class='innerwrap sizes_main_div_ar_ar'>";
        // $output .= "<div class='size_column_ar'> <div class='size_name'> <h6>Quantity</h6></div> <div class='sizes_quantity'><input type='number' placeholder='0' min='0' value='0' name='input_sizes' product-id='" . $product->get_id() . "'></div></div>";
        // $output .= "</div> </div></div>";
        // echo $output;
        // Ensure WooCommerce functions are available
        if (function_exists('woocommerce_template_single_add_to_cart')) {
            // This function displays the default add-to-cart button
            woocommerce_template_single_add_to_cart();
        }
    }
}

function has_a_variation($attribute, $variation_type)
{
    global $product;

    // Check if the product is a variable product
    if ($product->is_type('variable')) {
        // Get variations
        $variations = $product->get_available_variations();

        foreach ($variations as $variates) {
            if ($variates['attributes'][$variation_type] == (strtolower($attribute))) {
                return true;
            }
        }
    } else {
        return false;
    }
}

function getlogo_print()
{
    global $product;

    $terms = get_the_terms($product->get_id(), 'product_cat');
    $delurl = get_stylesheet_directory_uri() . '/assets/img/delete.svg';
    $tooltipicon = get_stylesheet_directory_uri() . '/assets/img/arrowtip.svg';
    $infoicon = get_stylesheet_directory_uri() . '/assets/img/info.svg';

    if (have_rows("print_area")) {
        // $count = count(get_field("printer_type_options_available"));
        // $arease = get_field_object("field_664db377bdc5d");
    ?>
        <div class="addlogo_ar">
            <div class="d-flex-between-spac-ar heading_main_logo_ar">
                <h5>Add Print Area</h5>
                <h4 id="see_guide_ar"><a href="#quixk_guides_ar">Quick Guide</a></h4>
            </div>
            <div class="allprintareas">

                <div class="addlogo_colum">
                    <div class='size_column_ar'>
                        <div class='size_name first_with_tooltips'>
                            <h6> Print Type<span>*</span>
                                <div class='tooltip_info_ar'><img src='<?php echo $infoicon; ?>' alt='' id='infoicon_ar_premium_setup'>
                                    <div class='tooltip_data_ar' id='tooltip_data_ar_puff_embroid'><img src='<?php echo $tooltipicon; ?>' alt='' class='tooltip_arrow_ar'>
                                        <div class="custom-print-type-main">
                                            <?php
                                            if (have_rows("print_type_tooltip", 'options')) {
                                                while (have_rows("print_type_tooltip", 'options')) {
                                                    the_row();
                                                    $title = get_sub_field("tooltip_heading");
                                                    $desc = get_sub_field("tooltip_description");
                                                    $img = get_sub_field("tooltip_image");

                                            ?>
                                                    <div class="custom-print-type">
                                                        <div class="custom-print-type-input custom-flex-box">
                                                            <div class="custom-print-type-input-text">
                                                                <div class="custom-print-type-input-text-title">
                                                                    <h1 id="custom-print-type-input-text-title_ar"><?php echo $title; ?></h1>
                                                                </div>
                                                                <div class="custom-print-type-input-text-description">
                                                                    <p>
                                                                        <?php echo $desc; ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="custom-print-type-input-img">
                                                                <img src="<?php echo $img; ?>" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php  }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </h6>
                        </div>
                        <div class='sizes_quantity custom_dropdown_wrapper_ar_ar'><select name='print_type' class='printtype' current-cat='<?php echo $terms[0]->name; ?>'>
                                <?php get_print_type_attribute(); ?>
                            </select>
                            <div class="d_flex_justify_between_ar_ar custom_dropdown_ar_ar">
                                <h6>Choose</h6>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/dropdown.svg'; ?>" alt="">

                            </div>
                            <?php get_print_type_attribute_custom_options(); ?>
                        </div>
                    </div>
                    <div class='size_column_ar'>
                        <div class='size_name '>
                            <h6> Print Area<span>*</span></h6>
                        </div>
                        <div class='sizes_quantity custom_dropdown_wrapper_ar_ar'><select name='printarea' class='printarea' current-cat='<?php echo $terms[0]->name; ?>' extrafee='<?php echo get_field('extra_area_fee', 'options'); ?>'>
                                <?php acf_select_options('field_664db3ff9bd11', 'print_sides'); ?>
                            </select>
                            <div class="d_flex_justify_between_ar_ar custom_dropdown_ar_ar disabled_ar_options_ar">
                                <h6>Front</h6>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/dropdown.svg'; ?>" alt="">
                            </div>
                            <?php acf_select_options_custom('field_664db3ff9bd11', 'print_sides'); ?>
                        </div>
                    </div>
                    <div class='size_column_ar hidethis_ar'>
                        <div class='size_name'>
                            <h6> Patch Shape<span>*</span></h6>
                        </div>
                        <div class='sizes_quantity'>
                            <input type="text" name="patchshape" class="patchshape hidethisforever_ar" value="square | Yellow">
                            <div class='patch_colors_selection_ar'>
                                <div class="selections_names_ar">
                                    <div class="selected_color_shaped_ar">
                                        <div class="selected_shaped_color_wrapper">
                                            <div class="selected_shaped_color_rect">

                                            </div>
                                        </div>
                                        <p> <span class='selcted_shape_ar_ar'> Square</span> | <span class='selcted_color_ar_ar'> Yellow </span></p>
                                    </div>
                                    <div class="dropdown_icons_ar_shapes">
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/dropdown.svg'; ?>" alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- <select name='patchshape' class='patchshape' current-cat='<?php // echo $terms[0]->name; 
                                                                                            ?>'>
                                <?php //fetchpatchshapes(); 
                                ?>
                            </select> -->
                            <div class="patch-shape-colors-main">
                                <div class="patch-shape-colors">
                                    <div class="patch-shape-heading">
                                        <h1>Select Shape</h1>
                                    </div>
                                    <div class="patch-shape">
                                        <?php fetchpatchshapes(); ?>
                                    </div>
                                    <div class="patch-shape-heading patch-color">
                                        <h1>Select Color</h1>
                                    </div>
                                    <div class='patchesize_ar patch_colors_selection_list_ar'>
                                        <?php get_patch_swatches_ar(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='size_column_ar'>
                        <div class='size_name'>
                            <h6> No. of Colours<span>*</span></h6>
                        </div>
                        <div class='sizes_quantity custom_dropdown_wrapper_ar_ar'><select name='printcolors' class='printcolors' current-cat='<?php echo $terms[0]->name; ?>'>
                                <?php
                                $limit = 10;
                                for ($i = 1; $i <= $limit; $i++) {
                                ?>
                                    <option value="<?php echo $i; ?>" data-cost="<?php echo get_field("extra_color_fee", 'options'); ?>"><?php echo $i; ?></option>
                                <?php
                                }
                                ?>
                                <option value="11" data-cost="<?php echo get_field("extra_color_fee"); ?>">Full Color</option>
                            </select>
                            <div class="d_flex_justify_between_ar_ar custom_dropdown_ar_ar">
                                <h6>Choose</h6>
                                <img src="<?php echo get_stylesheet_directory_uri() . '/assets/dropdown.svg'; ?>" alt="">

                            </div>
                            <div class="custom_options_ar">

                                <?php
                                $limit = 10;
                                for ($i = 1; $i <= $limit; $i++) {
                                ?>
                                    <h6 values="<?php echo $i; ?>" data-cost="<?php echo get_field("extra_color_fee"); ?>"><?php echo $i; ?></h6>
                                <?php
                                }
                                ?>
                                <h6 values="11" data-cost="<?php echo get_field("extra_color_fee"); ?>">Full Color</h6>

                            </div>
                        </div>
                    </div>
                    <div class='size_column_ar dottedstylear'>
                        <div class='size_name_upload'>
                            <img src="https://custom2wear.mi6.global/wp-content/uploads/2024/05/Frame-1000005041.svg" alt="">
                            <input type="text" name="file_art" class="inputfile_ar">
                        </div>
                    </div>
                    <!-- <div class='patches_column_ar hidethis_ar'>
                        <div class='patchesize_ar'>
                            <h6> Patch Color<span>*</span></h6>
                        </div>
                        <div class='patchesize_ar '>
                            <?php //get_patch_swatches_ar(); 
                            ?>
                        </div>
                    </div> -->
                    <div class="removerlist_ar_area">
                        <img src="<?php echo $delurl ?>" alt="">
                    </div>
                </div>

            </div>
            <div class="drag_drop_zone_wrapper">

                <div id="drag-and-drop-zone">
                    <button id="closerdrop_ar">&times;</button>
                    <label for="file-input" class="file_input_ar_ar"> <img src="<?php echo get_stylesheet_directory_uri() . '/assets/cloud.svg' ?>" alt=""> <span class="heading_label_ar"> Drag and drop your files here </span><span class="subheading_label_ar">(Maximum file size is 5MB)</span> <span class="subheading_label_ar">(Please Check the checkbox below to enable the uploader)</span></label>
                    <input type="file" id="file-input" name="file-input" disabled>
                    <div class="copyrightcheck_ar">
                        <input type="checkbox" name="copyright_art_ar" id="copyright_art_ar"> <label for="copyright_art_ar"> I OWN THE RIGHTS TO THE ARTWORK BEING USED OR HAVE PERMISSION FROM THE OWNER TO USE IT
                        </label>
                    </div>
                </div>

            </div>

            <div class="addanotherone_ar">
                <div class="icons">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/Mask group.svg" class="img-fluid ?>" alt="">
                </div>
                <div class="texticons">
                    <h6>Add another print area</h6>
                </div>
            </div>
            <div class="premium_artwork_archeck">
                <input type="checkbox" name="premium_artwork_ar" id="premium_artwork_ar" value="<?php echo get_field('premium_artwork_setup_fee', 'options'); ?>">
                <label for="premium_artwork_ar">Premium Artwork Setup $<?php echo get_field('premium_artwork_setup_fee', 'options'); ?> (Digital Mockup, Unlimited Revisions, Photo of physical patch sent for approval)</label>
            </div>
            <div class="premium_artwork_archeck" id="orderedthislogo_ar_wrapper">
                <input type="checkbox" name="orderedthislogo_ar" id="orderedthislogo_ar">
                <label for="orderedthislogo_ar">I have ordered with this logo before.</label>
            </div>
            <div class="3d_puff_embroidery premium_artwork_archeck" id="d_puff_embroidery_wrapper">
                <input type="checkbox" name="d_puff_embroidery" id="d_puff_embroidery" value="<?php echo get_field('3d_puff_embroidery', 'options'); ?>">
                <label for="d_puff_embroidery">3D Puff Embroidery</label>
                <div class='tooltip_info_ar'><img src='<?php echo $infoicon; ?>' alt='' id='infoicon_ar_premium_setup'>
                    <div class='tooltip_data_ar' id='tooltip_data_ar_puff_embroid'><img src='<?php echo $tooltipicon; ?>' alt='' class='tooltip_arrow_ar'>
                        <div class="puff_emb_wrapper_arar">
                            <div class="custom-height-width">
                                <div class="custon-fnt-size-12">
                                    <h1 id="puff_heading_of_free_feature_ar"><?php echo get_field('puff_tooltip_heading', 'options'); ?></h1>
                                </div>
                                <div class="custon-fnt-size-12">
                                    <p>
                                        <?php echo get_field('puff_tooltip_descriptions', 'options'); ?>
                                    </p>
                                </div>
                                <?php
                                $images = get_field('puff_tooltip_gallery', 'options');
                                if ($images) :
                                ?>
                                    <div class="custom-flex-imges">
                                        <?php foreach ($images as $image) : ?>
                                            <div class="custom-img-size">
                                                <img src="<?php echo $image; ?>" alt="">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="add_instrution_ar_wrapper">
                <div class="add_instrution_ar premium_artwork_archeck">
                    <input type="checkbox" name="add_instrution_ar" id="add_instrution_ar">
                    <label for="add_instrution_ar">Add Additional Instructions? (Optional)</label>
                </div>
                <textarea name="add_instrution_ar_text" id="add_instrution_ar_text" cols="30" rows="4" placeholder="Need something a certain Way? Let us know here"></textarea>
            </div>
        </div>
    <?php
    }
}


function acf_select_options($fieldkey, $subfield)
{
    $currentid = get_the_ID();
    $arease = get_field_object("$fieldkey");

    if (have_rows("print_area")) {
        while (have_rows("print_area")) {
            the_row();
            $printtypes = get_sub_field("$subfield");
        }
    }

    if (count($arease) > 0) {
    ?>
        <option value="">Choose</option>
        <?php
        foreach ($arease['choices'] as $value => $label) {
            if (in_array($value, $printtypes)) {
        ?>
                <option value="<?php echo $value; ?>" product-id="<?php echo $currentid; ?>"><?php echo $label; ?></option>
    <?php
            }
        }
    }
}

function get_print_type_attribute()
{

    global $product;
    $currentid = get_the_ID();
    $print_types = $product->get_attribute('print-types');
    $sizes_ar =  explode(",", $print_types);
    ?>
    <option value="" product-id="<?php echo $currentid; ?>">Choose</option>
    <?php

    if (count($sizes_ar) > 1) {

        foreach ($sizes_ar as $size) {
            $size_slug = sanitize_title(trim($size));
            $variation = has_a_variation($size_slug, 'attribute_pa_print-types');

            if ($variation) {
    ?>
                <option value="<?php echo $size_slug; ?>" product-id="<?php echo $currentid; ?>"><?php echo $size; ?></option>
            <?php
            }
        }
    } else {
        $size = trim($sizes_ar[0]);
        $size_slug = sanitize_title($size);
        $variation = has_a_variation($size_slug, 'attribute_pa_print-types');
        if ($variation) {
            ?>
            <option value="<?php echo $size_slug; ?>" product-id="<?php echo $currentid; ?>"><?php echo $sizes_ar[0]; ?></option>
        <?php
        }
    }
}


function get_print_type_attribute_custom_options()
{
    global $product;
    $currentid = get_the_ID();
    $print_types = $product->get_attribute('print-types');
    $sizes_ar =  explode(",", $print_types);
    if (count($sizes_ar) > 1) {
        ?>
        <div class="custom_options_ar" value="">
            <?php

            foreach ($sizes_ar as $size) {
                $size_slug = sanitize_title(trim($size));
                $variation = has_a_variation($size_slug, 'attribute_pa_print-types');

                if ($variation) {
            ?>
                    <h6 values="<?php echo $size_slug; ?>" product-id="<?php echo $currentid; ?>"><?php echo $size; ?></h6>
            <?php
                }
            }
            ?>
        </div>
    <?php
    }
}

function acf_select_options_custom($fieldkey, $subfield)
{
    $currentid = get_the_ID();
    $arease = get_field_object("$fieldkey");

    if (have_rows("print_area")) {
        while (have_rows("print_area")) {
            the_row();
            $printtypes = get_sub_field("$subfield");
        }
    }

    if (count($arease) > 0) {
    ?>
        <div class="custom_options_ar" value="">
            <?php
            foreach ($arease['choices'] as $value => $label) {
                if (in_array($value, $printtypes)) {
            ?>
                    <h6 values="<?php echo $value; ?>" product-id="<?php echo $currentid; ?>"><?php echo $label; ?></h6>
            <?php
                }
            }
            ?>
        </div>
        <?php
    }
}

function fetchpatchshapes()
{
    $currentid = get_the_ID();

    if (have_rows('patch_shapes', 'options')) {
        while (have_rows('patch_shapes', 'options')) {
            the_row();
            $patch_shapes = get_sub_field('shape_sample');
            $patch_names = get_sub_field('shape_name');
        ?>
            <div class="patch-shape-img-text <?php echo ($patch_names == 'Circle') ? 'active_shapes_wraper' : ''; ?>">
                <div class="patch_shape_masking_wrapper_ar_ar">
                    <div class='patch_shape_masking_ar_ar' style="mask-image: url(<?php echo $patch_shapes; ?>);"></div>
                </div>
                <p> <?php echo $patch_names; ?></p>
            </div>
<?php
        }
    }
}

function changetheareas()
{
    if (isset($_POST['depid']) && !empty($_POST['depid'])) {
        $currenttype = $_POST['depid'];
        $pid = intval($_POST['pid']);
        $getfield = '';
        if (have_rows('print_area', $pid)) {
            while (have_rows('print_area', $pid)) {
                the_row();
                $printtypes = get_sub_field('print_types');
                $print_sides = get_sub_field('print_sides');
                $print_area_extra_charges = get_sub_field('print_area_extra_charges');

                if ($printtypes == $currenttype) {
                    $getfield = $print_area_extra_charges;
                }
            }
        }
    }

    echo $getfield;
    die();
}

add_action("wp_ajax_changetheareas", "changetheareas");
add_action("wp_ajax_nopriv_changetheareas", "changetheareas");

function addtocartar()
{
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        wp_send_json_error(array('message' => 'WooCommerce is not active.'));
    }

    // Retrieve data from the AJAX request
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $extracharges = isset($_POST['additional_charges']) ? intval($_POST['additional_charges']) : 0;
    $custom_price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
    $prod_color = isset($_POST['colors']) ? ($_POST['colors']) : '';
    $prod_var = isset($_POST['sizear']) ? ($_POST['sizear']) : '';
    $prod_allareasdata = isset($_POST['allareasdata']) ? ($_POST['allareasdata']) : '';
    $add_instructions = isset($_POST['add_instructions']) ? ($_POST['add_instructions']) : '';
    $d3_puff_embroidery = isset($_POST['d3_puff_embroidery']) ? ($_POST['d3_puff_embroidery']) : '';
    $notcart = isset($_POST['notcart']) ? ($_POST['notcart']) : false;

    // Validate product ID
    if (!$product_id) {
        wp_send_json_error(array('message' => 'Invalid product ID.'));
    }

    $product = wc_get_product($product_id);
    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error(array('message' => 'Product is not a variable product.'));
    }

    $variations = $product->get_available_variations();
    $added_to_cart = array();
    $output = '';
    foreach ($variations as $variation_data) {
        foreach ($prod_var as $prod) {
            $prod_size = sanitize_title(trim($prod['size']));
            $variation_id = $variation_data['variation_id'];
            $variation = new WC_Product_Variation($variation_id);
            $attributes = $variation->get_attributes();

            $print_type = sanitize_title(trim($prod_allareasdata[0]['printtype']));
            $added_to_cart[] = $print_type;
            $quantity = $prod['quantity'];
            // Check if this variation matches the specified color and size
            if ($attributes['pa_color'] === $prod_color && $attributes['pa_sizes'] === $prod_size && $attributes['pa_print-types'] === $print_type) {

                // get discounted prices array
                $discounted_array = null;
                $price = $variation->get_price();
                $discount_type = get_field('select_the_discount_type', 'options');
                $percentage_discount = get_field('percentage_discount', 'options');
                $fixed_amount_discount = get_field('fixed_amount_discount', 'options');
                $discount_location = get_field('apply_this_discount_to_all_products', 'options');
                $select_your_product = get_field('select_your_product', 'options');
                if (trim($discount_type) == 'percentage') {
                    $discounted_array = get_percentage_discount($price, $percentage_discount);
                } else {
                    $discounted_array = get_fixed_discount($price, $fixed_amount_discount);
                }

                if ($notcart) {
                    // Display the custom price per product
                    $title = str_replace("-", " ", $print_type);
                    $output .= "<div class='title_ar_table'><h6>" . $title . "</h6> </div>";
                    foreach ($discounted_array as $key => $value) {
                        $numberindex = explode("_", $key)[1];
                        $output .= "<div class='price_column_ar' quantity-id='" . $numberindex . "'> <div class='range_price_ar'> $ " . $value . "</div></div>";
                    }
                } else {
                    // Calculate the custom price per product
                    $custompriceperproduct = $custom_price / $quantity;

                    $currentprice = 0;
                    $currentindex = '';
                    $indexofarray = [];
                    
                    // Extract the indices from the array keys
                    foreach ($discounted_array as $key => $value) {
                        $numberindex = (int) explode("_", $key)[1];
                        $indexofarray[] = $numberindex;
                    }
                    
                    $size = count($indexofarray);
                    
                    foreach ($indexofarray as $index => $value) {
                        // Check if quantity is between current and next index value
                        if ($quantity > $value && ($index + 1 == $size || $quantity <= $indexofarray[$index + 1])) {
                            $currentprice = $discounted_array["item_{$indexofarray[$index + 1]}"];
                            $currentindex = "item_{$indexofarray[$index + 1]}";
                            break; // Exit loop once the correct range is found
                        }
                    }
                    
                    // If the quantity is less than the first index value, select the first index
                    if ($quantity <= $indexofarray[0]) {
                        $currentprice = $discounted_array["item_{$indexofarray[0]}"];
                        $currentindex = "item_{$indexofarray[0]}";
                    }


                    $currentprice= $currentprice + $extracharges;
                    // Store custom details in the session
                    WC()->session->set('custom_price_' . $variation_id, $currentprice);
                    WC()->session->set('custom_color_' . $variation_id, $prod_color);
                    WC()->session->set('custom_variates_' . $variation_id, $prod_var);
                    WC()->session->set('custom_areas_' . $variation_id, $prod_allareasdata);
                    WC()->session->set('custom_instructions_' . $variation_id, $add_instructions);
                    WC()->session->set('custom_d3_embroidery_' . $variation_id, $d3_puff_embroidery);

                    // Add the variation to the cart
                    // WC()->cart->empty_cart();

                    // Add the variation to the cart
                    $result = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, array(
                        'attribute_pa_color' => $prod_color,
                        'attribute_pa_sizes' => $prod_size,
                        'attribute_pa_print-types' => $print_type
                    ));

                    if ($result) {
                        $added_to_cart[] = array(
                            'product_id' => $product_id,
                            'quantity' => $quantity,
                            'variation_id' => $currentindex,
                            'custom_price_per_product' => $currentprice,
                            'price_list' => $discounted_array
                        );
                    }
                }
            }
        }
    }
    if (!$notcart) {

        if ($added_to_cart) {
            wp_send_json_success(array(
                'message' => 'Product(s) added to cart.',
                'redirect_url' =>  wc_get_cart_url(),
            ));
        } else {
            wp_send_json_error(array('message' => $prod_var));
        }
    } else {
        wp_send_json_success(array('nocaert' => $notcart, 'price_list' => $output, 'list_id' => sanitize_title(trim($prod_allareasdata[0]['printtype']))));
    }

    die();
}

add_action("wp_ajax_addtocartar", "addtocartar");
add_action("wp_ajax_nopriv_addtocartar", "addtocartar");



function set_custom_price_in_cart($cart_object)
{
    if (!WC()->session->__isset('reload_checkout')) {
        foreach ($cart_object->get_cart() as $key => $value) {
            if (WC()->session->__isset('custom_price_' . $value['product_id'])) {
                $custom_price = WC()->session->get('custom_price_' . $value['product_id']);
                $value['data']->set_price($custom_price);
            }
        }
    }
}
add_action('woocommerce_before_calculate_totals', 'set_custom_price_in_cart');



function handle_file_upload()
{
    $response = array(
        'uploaded' => [],
        'failed' => []
    );

    if (!empty($_FILES['files'])) {
        $files = $_FILES['files'];
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

        foreach ($files['name'] as $key => $name) {
            if ($files['error'][$key] === 0) {
                $temp = $files['tmp_name'][$key];
                $ext = pathinfo($name, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $upload = wp_upload_bits($name, null, file_get_contents($temp));

                    if ($upload['error'] == false) {
                        $response['uploaded'][$key] = $upload['url'];
                    } else {
                        $response['failed'][$key] = "$name failed to upload.";
                    }
                } else {
                    $response['failed'][$key] = "$name file type is not allowed.";
                }
            } else {
                $response['failed'][$key] = "$name errored with code " . $files['error'][$key];
            }
        }
    }

    echo json_encode($response);
    wp_die(); // this is required to terminate immediately and return a proper response
}
add_action('wp_ajax_file_upload', 'handle_file_upload');
add_action('wp_ajax_nopriv_file_upload', 'handle_file_upload');


// adding custom field to products
// Display custom field on the product page
function enqueue_admin_custom_css()
{
    wp_enqueue_style('admin-custom', get_stylesheet_directory_uri() . '/admin/css/style.css', array(), '1.0.0');
}
add_action('admin_enqueue_scripts', 'enqueue_admin_custom_css');


function add_custom_data_to_order_items($item, $cart_item_key, $values, $order)
{
    $product_id = $item->get_product_id();

    // Retrieve session data
    $custom_price = WC()->session->get('custom_price_' . $product_id);
    $custom_color = WC()->session->get('custom_color_' . $product_id);
    $custom_var = WC()->session->get('custom_variates_' . $product_id);
    $custom_areas = WC()->session->get('custom_areas_' . $product_id);
    $intruct =   WC()->session->get('custom_instructions_' . $product_id);
    $puff =  WC()->session->get('custom_d3_embroidery_' . $product_id);
    // Add session data to order item meta
    if (!empty($custom_color)) {
        $item->add_meta_data('_custom_color', $custom_color);
    }
    if (!empty($custom_var)) {
        $item->add_meta_data('_custom_variates', $custom_var);
    }
    if (!empty($custom_areas)) {
        $item->add_meta_data('_custom_areas', $custom_areas);
    }
    if (!empty($intruct)) {
        $item->add_meta_data('_custom_instruct', $intruct);
    }
    if (!empty($puff)) {
        $item->add_meta_data('_custom_puff', $puff);
    }
}

add_action('woocommerce_checkout_create_order_line_item', 'add_custom_data_to_order_items', 10, 4);

// order details
add_filter('woocommerce_defer_transactional_emails', '__return_true');


// Display custom data in the order admin
function display_custom_data_in_order_admin($item_id, $item, $product)
{

    if ($custom_color = wc_get_order_item_meta($item_id, '_custom_color', true)) {
        echo '<h6><strong>Color:</strong> ' . esc_html($custom_color) . '</h6>';
    }
    if ($custom_variates = wc_get_order_item_meta($item_id, '_custom_variates', true)) {
        $output = '<div class="sizes_ar"><h6><strong>Sizes:</strong> </h6></div>';
        if (is_array($custom_variates) > 0) {
            foreach ($custom_variates as $variates) {
                $output .= "<h6 class='variations_on_cart_ar'>" . $variates['size'] . " * " . $variates['quantity'] . "</h6>";
            }
        }
        echo $output;
    }
    $puffclass = "";
    if ($custom_puff = wc_get_order_item_meta($item_id, '_custom_puff', true)) {
        if ($custom_puff != 0) {
            $puffclass = "(3D Puff)";
        }
    }
    if ($custom_areas = wc_get_order_item_meta($item_id, '_custom_areas', true)) {
        if (is_array($custom_areas) > 0) {
            $output = "<div class='size_attr_ar_cart'><h6>Print Areas : </h6>";
            foreach ($custom_areas as $area) {
                $printtype = (!empty($area['printtype'])) ? "<span>" . $area['printtype'] . "$puffclass</span> + " : "";
                $printarea = (!empty($area['areavalue'])) ? "<span>" . $area['areavalue'] . "</span> + " : "";
                $printcolor = (!empty($area['printcolors'])) ? "<span>" . $area['printcolors'] . "colors </span>  " : "";
                $artwork = (!empty($area['artworkurl'])) ? " + <a href='" . $area['artworkurl'] . "' target='_blank'>View Artwork</a></h6>" : "";

                $output .= "<h6>" . $printtype . $printarea . $printcolor . $artwork . "</h6>";
            }
            $output .= "</div>";
            echo $output;
        }
    }

    if ($custom_intruts = wc_get_order_item_meta($item_id, '_custom_instruct', true)) {
        $output = '<div class="sizes_ar"><h6><strong>Additional Instructions:</strong> </h6>';
        $output .= "<p>$custom_intruts</p></div>";
        echo $output;
    }
}
add_action('woocommerce_admin_order_item_values', 'display_custom_data_in_order_admin', 10, 3);

// Display custom data in the customer order view
function display_custom_data_in_order_view($cart_item, $order_item, $order)
{

    if ($custom_color = wc_get_order_item_meta($order_item->get_id(), '_custom_color', true)) {
        echo '<h6><strong>Color:</strong> ' . esc_html($custom_color) . '</h6>';
    }
    if ($custom_variates = wc_get_order_item_meta($order_item->get_id(), '_custom_variates', true)) {
        $output = '<div class="sizes_ar"><h6><strong>Sizes :</strong> </h6></div>';
        if (is_array($custom_variates) > 0) {
            foreach ($custom_variates as $variates) {
                $output .= "<h5 class='variations_on_cart_ar'>" . $variates['size'] . " * " . $variates['quantity'] . "</h5>";
            }
        }
        echo $output;
    }

    $puffclass = "";
    if ($custom_puff = wc_get_order_item_meta($order_item->get_id(), '_custom_puff', true)) {
        if ($custom_puff != 0) {
            $puffclass = "(3D Puff)";
        }
    }
    if ($custom_areas = wc_get_order_item_meta($order_item->get_id(), '_custom_areas', true)) {
        if (is_array($custom_areas) > 0) {
            $output = "<div class='size_attr_ar_cart'><h6>Print Areas : </h6>";
            foreach ($custom_areas as $area) {
                $printtype = (!empty($area['printtype'])) ? "<span>" . $area['printtype'] . "$puffclass</span> + " : "";
                $printarea = (!empty($area['areavalue'])) ? "<span>" . $area['areavalue'] . "</span> + " : "";
                $printcolor = (!empty($area['printcolors'])) ? "<span>" . $area['printcolors'] . "colors </span>  " : "";
                $artwork = (!empty($area['artworkurl'])) ? " + <a href='" . $area['artworkurl'] . "' target='_blank'>View Artwork</a></h6>" : "";

                $output .= "<h6>" . $printtype . $printarea . $printcolor . $artwork . "</h6>";
            }
            $output .= "</div>";
            echo $output;
        }
    }
    if ($custom_intruts = wc_get_order_item_meta($order_item->get_id(), '_custom_instruct', true)) {
        $output = '<div class="sizes_ar"><h6><strong>Additional Instructions:</strong> </h6>';
        $output .= "<p>$custom_intruts</p></div>";
        echo $output;
    }
}
add_action('woocommerce_order_item_meta_end', 'display_custom_data_in_order_view', 10, 3);



function get_variations_price_image()
{
    if (isset($_POST['product_id']) && !empty($_POST['color'])) {
        // Define the attributes you are looking for
        $color = sanitize_text_field($_POST['color']);
        $size = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : null;

        // Get the product object
        $product_id = absint($_POST['product_id']);
        $product = wc_get_product($product_id);

        if ($product->is_type('variable')) {
            // Get all variations of the product
            $variations = $product->get_available_variations();
            $emptyerrp = array();
            foreach ($variations as $variation_data) {
                $variation_id = $variation_data['variation_id'];
                $variation = new WC_Product_Variation($variation_id);

                // Get variation attributes
                $attributes = $variation->get_attributes();
                $emptyerrp[] = $attributes;
                // Check if this variation matches the specified color and, if provided, the size
                if ($attributes['pa_color'] === $color) {
                    if ($size === null || $attributes['pa_sizes'] === $size) {
                        // Get the price
                        $price = $size === null ? 0 : $variation->get_price();

                        // Get the image URL
                        $image_id = $variation->get_image_id();
                        $image_url = wp_get_attachment_url($image_id);
                        $image_srcset = wp_get_attachment_image_srcset($image_id);

                        $results = array('price' => $color, 'image_url' => $image_url, 'image_srcset' => $image_srcset);
                        echo json_encode($results);
                        wp_die();
                    }
                }
            }

            // If no matching variation is found, return a default response
            echo json_encode(array('price' => $color, 'image_url' => ''));
            wp_die();
        } else {
            echo "The product is not a variable product.";
            wp_die();
        }
    }
}

add_action("wp_ajax_get_variations_price_image", "get_variations_price_image");
add_action("wp_ajax_nopriv_get_variations_price_image", "get_variations_price_image");


add_filter('woocommerce_cart_item_price', 'custom_cart_item_price', 10, 3);
function custom_cart_item_price($price, $cart_item, $cart_item_key)
{
    $variation_id = $cart_item['variation_id'];
    $custom_variations = WC()->session->get('custom_price_' . $variation_id);

    if (!empty($custom_variations)) {
        // Calculate the custom price based on your variation logic


        // Format the custom price
        $price = wc_price($custom_variations);
    }

    return $price;
}

add_action('woocommerce_before_calculate_totals', 'apply_custom_price_to_cart', 20, 1);
function apply_custom_price_to_cart($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item) {
        $variation_id = $cart_item['variation_id'];
        $custom_variations = WC()->session->get('custom_price_' . $variation_id);
        if (!empty($custom_variations)) {
            $cart_item['data']->set_price($custom_variations);
        }
    }
}


function get_pricing_listing()
{
    global $product;
    $product_id = get_the_ID();
    $print_types = $product->get_attribute('print-types');
    $print_types = explode(',', $print_types);
    $product = wc_get_product($product_id);
    if (!$product || !$product->is_type('variable')) {
        wp_send_json_error(array('message' => 'Product is not a variable product.'));
    }
    $variations = $product->get_available_variations();
    $added_to_cart = array();
    foreach ($print_types as $prod) {
        foreach ($variations as $variation_data) {
            $print_type = sanitize_title(trim($prod));
            $variation_id = $variation_data['variation_id'];
            $variation = new WC_Product_Variation($variation_id);
            $attributes = $variation->get_attributes();

            // Check if this variation matches the specified color and size
            if ($attributes['pa_print-types'] === $print_type) {
                // Calculate the custom price per product
                $varient_price = $variation->get_price();
                $varient_info = ['name' => $prod, 'price' => $varient_price, 'slug' => $print_type];
                array_push($added_to_cart, $varient_info);
                break;
            }
        }
    }
    return $added_to_cart;
}

function get_attribute_term_name_by_slug($attribute_slug, $term_slug)
{
    // Construct the taxonomy name
    $taxonomy = 'pa_' . $attribute_slug;

    // Get the term object
    $term = get_term_by('slug', $term_slug, $taxonomy);

    // Return the term name if it exists
    if ($term && !is_wp_error($term)) {
        return $term->name;
    }

    return null; // Term not found
}
