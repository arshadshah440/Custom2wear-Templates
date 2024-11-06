<?php

$child_category = get_term($child_id, 'product_cat');
$child_link = get_term_link($child_category);
$thumbnail_id = get_term_meta($child_category->term_id, 'thumbnail_id', true);
$image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : wc_placeholder_img_src(); // Placeholder if no image
?>

<div class="product_loop_ar">
    <div class="card_ar_mi">
        <div class="featured_image_ar">
            <a href="<?php echo $child_link; ?>">
                <img src="<?php echo $image_url; ?>" alt="Featured Image">
            </a>
        </div>
        <div class="product_details_ar">
            <a href="<?php echo $child_link; ?>" class="product_name_ar">
                <h6 class="text_align_center_ar"> <?php echo esc_html($child_category->name); ?></h6>
            </a>
        </div>
    </div>
</div>