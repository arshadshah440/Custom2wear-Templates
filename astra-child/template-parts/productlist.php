<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// Get the current queried object
$queried_object = get_queried_object();



// Check if we are on a product category archive page
if (is_product_category()) {
    $child_categories = get_term_children($term_id, 'product_cat');

    if (!empty($child_categories)) {
        foreach ($child_categories as $child_id) {

?>
            <div class="product-item">
                <?php include get_stylesheet_directory() . '/template-parts/archive_loop_cards.php'; ?>
            </div>
            <?php
        }
    } else {
        if (!Is_shop()) {


            $taxonomy = 'product_cat'; // Taxonomy for product categories
            $term_id = $queried_object->term_id;
            $args = array(
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => $defaultnumberofproducts, // Retrieve all products
                'paged'          => $paged,
                'tax_query'      => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'term_id',
                        'terms'    => $term_id,
                    ),
                ),
            );
        } else {
            // If not a product category archive, get all products
            $args = array(
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => $defaultnumberofproducts, // Retrieve all products
                'paged'          => $paged,
            );
        }


        $loop = new WP_Query($args);

        if ($loop->have_posts()) :
            while ($loop->have_posts()) : $loop->the_post();
                global $product;
            ?>
                <div class="product-item">
                    <?php include get_stylesheet_directory() . '/template-parts/product_loop_card_ar.php'; ?>
                </div>
            <?php
            endwhile;
            ?>
            <!-- Pagination -->
            <!-- <div class="pagination_ar">
        <?php
            echo paginate_links(array(
                'total' => $loop->max_num_pages
            ));
        ?>
    </div> -->
<?php
        else :
            echo __('No products found');
        endif;

        wp_reset_postdata();
    }
} ?>