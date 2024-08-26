<?php


?>

<div class="product_loop_ar">
    <div class="card_ar_mi">
        <div class="featured_image_ar">
            <a href="<?php echo $product->get_permalink(); ?>">
                <?php echo $product->get_image('thumbnail'); ?>
            </a>
        </div>
        <div class="product_details_ar">
            <div class="ratings_loop_ar">
                <?php

                if ($product && wc_review_ratings_enabled()) {
                    // Get the average rating
                    $average = $product->get_average_rating();

                    // Get the total number of reviews
                    $review_count = $product->get_review_count();
                ?>
                    <div class="woocommerce-product-rating">
                        <?php if ($average) : ?>
                            <div class="star-rating" title="<?php echo esc_attr($average); ?>">
                                <span style="width:<?php echo esc_attr(($average / 5) * 100); ?>%">
                                    <?php printf(esc_html__('%s out of 5', 'woocommerce'), esc_html($average)); ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <?php if ($review_count) : ?>
                            <span class="review-count">(<?php printf(_n('%s review', '%s reviews', $review_count, 'woocommerce'), esc_html($review_count)); ?>)</span>
                        <?php endif; ?>
                    </div>
                <?php
                }
                ?>

            </div>
            <a href="<?php echo $product->get_permalink(); ?>" class="product_name_ar">
                <h6> <?php echo $product->get_title(); ?></h6>
            </a>
            <div class="d_flex_price_button_ar">
                <div class="price_ar">
                    <?php echo $product->get_price_html(); ?>
                </div>
                <div class="loop_card_btn_ar">
                    <a href="<?php echo $product->get_permalink(); ?>" class="cart_btn_ar"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/basket.svg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>