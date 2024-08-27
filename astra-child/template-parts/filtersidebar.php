<?php

/**
 * The template for displaying filter sidebar.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

?>
<div class="filter_wrapper_ar">
    <div class="filter_accordian_ar">
        <div class="filter_accordian_item_ar">
            <div class="filter_acc_head_ar">
                <h6 class="font_14_400 text_dark_ar">Categories</h6>
                <div class="filter_acc_icon_ar">
                    <i class="fa-solid fa-plus" id="filter_close_ar"></i>
                    <i class="fa-solid fa-minus" id="filter_open_ar"></i>
                </div>
            </div>
            <div class="filter_acc_body_ar">
                <div id="categories_wrapper_ar">
                    <?php
                    $terms = get_terms('product_cat', array(
                        'hide_empty' => false,
                    ));
                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                    ?>
                            <div class="filter_acc_body_item_ar">
                                <input type="checkbox" name="filter_cat" id="filter_cat<?php echo $term->term_id; ?>" class="filter_cat" value="<?php echo $term->term_id; ?>" <?php echo $term->term_id == $term_id ? 'checked' : ''; ?>>
                                <label for="filter_cat<?php echo $term->term_id; ?>" class="font_14_400 text_dark_ar"><?php echo $term->name; ?></label>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="filter_accordian_item_ar">
            <div class="filter_acc_head_ar">
                <h6 class="font_14_400 text_dark_ar">Color</h6>
                <div class="filter_acc_icon_ar">
                    <i class="fa-solid fa-plus" id="filter_close_ar"></i>
                    <i class="fa-solid fa-minus" id="filter_open_ar"></i>
                </div>
            </div>
            <div class="filter_acc_body_ar">
                <?php
                $type = get_the_attribute_type('color');
                ?>
                <div id="color_wrapper_ar" class="<?php echo $type == "color" ? 'swatch_color_wrapper_ar' : ''; ?>">

                    <?php
                    $terms = get_terms('pa_color', array(
                        'hide_empty' => false,
                    ));
                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                            $backdound = "";
                            if ($type == "color") {
                                $swatehcs = get_term_meta($term->term_id)['cfvsw_color'][0];
                                $backdound = "background-color:$swatehcs";
                            } else if ($type == "image") {
                                $image = wp_get_attachment_image_url(get_term_meta($term->term_id)['attribute_image']);
                                $backdound = "background-image:url('$image')";
                            }
                    ?>
                            <div class="filter_acc_body_item_ar <?php echo $type == "color" ? 'swatch_color_ar' : ''; ?>">
                                <input type="checkbox" name="filter_cat" id="filter_cat<?php echo $term->term_id; ?>" class="filter_cat" value="<?php echo $term->term_id; ?> ">
                                <label for="filter_cat<?php echo $term->term_id; ?>" class="font_14_400 text_dark_ar" style=<?php echo $backdound; ?>><?php echo $type == "color" ? '' : $term->name; ?></label>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="filter_accordian_item_ar">
            <div class="filter_acc_head_ar">
                <h6 class="font_14_400 text_dark_ar">Size</h6>
                <div class="filter_acc_icon_ar">
                    <i class="fa-solid fa-plus" id="filter_close_ar"></i>
                    <i class="fa-solid fa-minus" id="filter_open_ar"></i>
                </div>
            </div>
            <div class="filter_acc_body_ar">
                <?php
                $type = get_the_attribute_type('color');
                ?>
                <div id="size_wrapper_ar">

                    <?php
                    $terms = get_terms('pa_sizes', array(
                        'hide_empty' => false,
                    ));
                    if (!empty($terms)) {
                        foreach ($terms as $term) {
                            $image = wp_get_attachment_image_url(get_term_meta($term->term_id)['attribute_image']);
                            $backdound = "";
                            $swatehcs = get_term_meta($term->term_id)['cfvsw_color'][0];
                            if (!empty($image)) {
                                $backdound = "background-image:url('$image')";
                            } else {
                                $backdound = "background-color:$swatehcs";
                            }
                    ?>
                            <div class="filter_acc_body_item_ar <?php echo $type == "color" ? 'swatch_size_ar' : ''; ?>">
                                <input type="checkbox" name="filter_cat" id="filter_cat<?php echo $term->term_id; ?>" class="filter_cat" value="<?php echo $term->term_id; ?> " style=<?php echo $backdound; ?>>
                                <label for="filter_cat<?php echo $term->term_id; ?>" class="font_14_400 text_dark_ar"><?php echo $term->name; ?></label>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="filter_accordian_item_ar">
            <div class="filter_acc_head_ar">
                <h6 class="font_14_400 text_dark_ar">Price</h6>
                <div class="filter_acc_icon_ar">
                    <i class="fa-solid fa-plus" id="filter_close_ar"></i>
                    <i class="fa-solid fa-minus" id="filter_open_ar"></i>
                </div>
            </div>
            <div class="filter_acc_body_ar" id="price_wrapper_ar">
                <div class="price-slider">
                    <input type="range" min="0" max="5000" value="0" class="slider" id="min-price">
                    <input type="range" min="0" max="5000" value="5000" class="slider" id="max-price">
                    <div class="price-display">
                        <span id="min-price-display" class="font_14_400">$0</span> -
                        <span id="max-price-display" class="font_14_400">$5000</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>