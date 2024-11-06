<?php

$post_link = get_the_permalink();
$thumbnail_url = get_the_post_thumbnail_url();
$image_url = $thumbnail_url ? $thumbnail_url : wc_placeholder_img_src(); // Placeholder if no image
?>

<div class="product_loop_ar">
    <div class="card_ar_mi">
        <div class="featured_image_ar">
            <a href="<?php echo $post_link; ?>">
                <img src="<?php echo $image_url; ?>" alt="Featured Image">
            </a>
        </div>
        <div class="product_details_ar">
            <a href="<?php echo $post_link; ?>" class="product_name_ar">
                <h6 class="text_align_center_ar"> <?php the_title(); ?></h6>
            </a>
        </div>
    </div>
</div>