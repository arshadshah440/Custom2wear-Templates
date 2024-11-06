<?php

/**
 * The template for displaying product archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

get_header();
$queried_object = get_queried_object();
$term_id = $queried_object->term_id;
$isparentcategory = false;
$childcategoriescount = 0;
$defaultnumberofproducts = get_field("set_default_number_of_products", 'options');
if (!is_search()) {
    if (is_product_category()) {

        // Get child categories for the current category
        $child_categories = get_term_children($term_id, 'product_cat');

        // Check if child categories exist
        if (!empty($child_categories)) {
            // Current archive is a product category with child categories
            $isparentcategory = true;
            $childcategoriescount = count($child_categories);
        } else {
            // Current archive is a product category but has no child categories
            $isparentcategory = false;
            $childcategoriescount = 0;
        }
    }
    $resultscount = 0;
    $loadmorestyles = '';
    $total_products = wc_get_loop_prop('total');
    if ((intval($total_products) > intval($defaultnumberofproducts) && intval($defaultnumberofproducts) > 0)) {

        $resultscount = intval($defaultnumberofproducts);
        if ($isparentcategory) {
            $resultscount = $childcategoriescount;
            $total_products = $childcategoriescount;
            $loadmorestyles = "display:none;";
        }
    } else {
        $resultscount = intval($total_products);
        $loadmorestyles = "display:none;";
        if ($isparentcategory) {
            $resultscount = $childcategoriescount;
            $total_products = $childcategoriescount;
            $loadmorestyles = "display:none;";
        }
    }

?>

    <section class="archieve_hero_ar" id="archieve_hero_ar">
        <div class="container_mi_ar">
            <div class="row_mi_nar">
                <div class="col_6_mi_ar">
                    <?php
                    // Display WooCommerce breadcrumbs
                    if (function_exists('woocommerce_breadcrumb')) {
                        woocommerce_breadcrumb();
                    } ?>
                    <h2 class="font_48_700 text_white_ar text_align_center_ar"><?php echo get_the_archive_title(); ?></h2>
                    <div class="font_14_400 text_white_op60_ar text_align_center_ar max_width_ar_550x"><?php echo get_the_archive_description(); ?></div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // sorting sections
    ?>
    <section class="sorting_section_ar">
        <div class="container_mi_ar">
            <div class="d_flex_no_gap_arch_ar">
                <div class="selected_filters_ar">
                    <div class="selected_filter_numbers" id="selected_filter_numbers_ar">
                        <h6 class="font_14_400 text_dark_ar"><?php echo is_shop() ? "0" : "1"; ?></h6>
                    </div>
                    <div class="selected_filter_text">
                        <p class="font_14_500 text_dark_ar mb_ar_0">Filters selected</p>
                    </div>
                </div>
                <div class="sorting_tabs_ar">
                    <div class="resulting_counter_ar">
                        <p class="font_14_400 text_dark_ar mb_ar_0">Showing <span id="show_counter_ar"> <?php echo $resultscount; ?> of <?php echo $total_products; ?> </span> results</p>
                        <div class="resulted_number_controller_ar">
                            <select name="rsults_controller_ar" id="rsults_controller_ar">
                                <option value="6" <?php echo (intval($defaultnumberofproducts) == 6 && $isparentcategory == false) ? 'selected' : ''; ?>>Show 6</option>
                                <option value="12" <?php echo (intval($defaultnumberofproducts) == 12 && $isparentcategory == false) ? 'selected' : ''; ?>>Show 12</option>
                                <option value="18" <?php echo (intval($defaultnumberofproducts) == 18 && $isparentcategory == false) ? 'selected' : ''; ?>>Show 18</option>
                                <option value="24" <?php echo (intval($defaultnumberofproducts) == 24 && $isparentcategory == false) ? 'selected' : ''; ?>>Show 24</option>
                                <option value="-1" <?php echo (intval($defaultnumberofproducts) == -1 || $isparentcategory == true) ? 'selected' : ''; ?>>Show All</option>
                            </select>
                            <p class="font_14_400 text_dark_ar mb_ar_0">Products Per Page</p>
                        </div>
                    </div>
                    <div class="sort_by_terms_wrapper_ar">
                        <div class="sorter_term_wrap_ar">
                            <p class="font_14_400 text_dark_ar mb_ar_0">Sort by: </p>
                            <select name="sort_by_terms_ar" id="sort_by_terms_ar">
                                <option value="recommended">Recommended</option>
                                <option value="oldfirst">Old First</option>
                                <option value="newfirst">New First</option>
                                <option value="price">Price</option>
                            </select>
                        </div>
                        <div class="grid_or_list_wrapper">
                            <div class="list_ar" id="list_ar">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/list.svg" alt="">
                            </div>
                            <div class="grid_ar" id="grid_ar">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/grid.svg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php

    // products_layouts
    ?>
    <section class="products_section_ar">
        <div class="container_mi_ar">
            <div class="d_flex_no_gap_arch_ar">
                <div class="selected_filters_ar" id="filters_wrapper_ar">
                    <?php include get_stylesheet_directory() . '/template-parts/filtersidebar.php'; ?>
                </div>
                <div class="sorting_tabs_ar" id="products_wrapper_ar" currentarc="<?php echo $term_id; ?>">
                    <div class="inner_pro_wraper_ar <?php echo $isparentcategory ? 'show_sub_cats_ar' : ''; ?>">
                        <?php include get_stylesheet_directory() . '/template-parts/productlist.php'; ?>
                    </div>
                    <div class="loader_ar" id="loader_ar">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/Spinner.gif" alt="">
                    </div>
                    <button id="load_more_ar" currentpage="2" style="<?php echo $loadmorestyles; ?>">Load More</button>
                </div>
            </div>
        </div>
    </section>
<?php } else {
?>
    <section class="archieve_hero_ar" id="archieve_hero_ar">
        <div class="container_mi_ar">
            <div class="row_mi_nar search_toper_ar">
                <div class="col_6_mi_ar">
                    <?php
                    // Display WooCommerce breadcrumbs
                    if (function_exists('woocommerce_breadcrumb')) {
                        woocommerce_breadcrumb();
                    } ?>
                    <h2 class="font_48_700 text_white_ar text_align_center_ar"><?php echo get_search_query(); ?></h2>
                </div>
            </div>
        </div>
    </section>
    <?php
    if (have_posts()) : ?>
        <section class="search_results_ar container_mi_ar">
            <h2>Search Results</h2>
            <div class="search_results_wrapper">

                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php include get_stylesheet_directory() . '/template-parts/search_loop_card.php'; ?>

                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php
                // Display pagination if there are multiple pages of results
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'textdomain'),
                    'next_text' => __('Next', 'textdomain'),
                ));
                ?>
            </div>

        </section>
    <?php else : ?>
        <section class="no-results">
            <h1><?php _e('Nothing Found', 'textdomain'); ?></h1>
            <p><?php _e('Sorry, no posts matched your criteria.', 'textdomain'); ?></p>
            <?php get_search_form(); // Display the search form 
            ?>
        </section>
<?php endif;
}
?>
<?php get_footer(); ?>