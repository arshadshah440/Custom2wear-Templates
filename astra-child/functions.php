<?php

/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define('CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0');

/**
 * Enqueue styles
 */
function child_enqueue_styles()
{

	wp_enqueue_style('astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all');
}

add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);


// Only show products in the front-end search results
add_filter('get_search_form', 'astra_get_search_form_callback');
function astra_get_search_form_callback($search_form)
{
	$search_form = str_replace('-1">', '-1"/><input type="hidden" name="post_type" value="product"/>', $search_form);
	return $search_form;
}
//CTX Feed Function so It doesnt Crashes
add_filter('woo_feed_should_apply_validate_feed_structure', '__return_true');

//Barn2 Plugins Function for Product Table to work Correctly.

// // Hook to add custom fields to product variations
// add_action('cmb2_admin_init', 'add_product_variation_custom_fields');
function add_product_variation_custom_fields()
{
	$prefix = 'c2wear_'; // Prefix for the custom fields

	$cmb = new_cmb2_box(array(
		'id'            => $prefix . 'product_variation_metabox',
		'title'         => __('Product Variation Custom Fields', 'cmb2'),
		'object_types'  => array('product_variation'), // Post type for product variations
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true,
	));

	$group_field_id = $cmb->add_field(array(
		'id' => $prefix . 'print_area_variation',
		'type' => 'group',
		'description' => __('Reusable Print Area', 'cmb2'),
		'repeatable' => true,
		'options' => array(
			'group_title' => __('Print Area {#}', 'cmb2'),
			'add_button' => __('Add Another Print Area', 'cmb2'),
			'remove_button' => __('Remove Print Area', 'cmb2'),
			'sortable' => true,
		)
	));
	// Add fields
	$cmb->add_group_field($group_field_id, array(
		'name' => __('Print Type', 'cmb2'),
		'id'   => $prefix . 'print_type',
		'description' => 'Select A Print Type',
		'type' => 'select',
		'options' => array(
			'' =>  __('Select Print Type', 'cmb2'),
			'leather_patch' => __('Leather Patch', 'cmb2'),
			'embroidery' =>  __('Embroidery', 'cmb2'),
			'digital_print' =>  __('Digital Print', 'cmb2'),
		),
	));

	$cmb->add_group_field($group_field_id, array(
		'name' => __('Print Area', 'cmb2'),
		'id'   => $prefix . 'print_area',
		'description' => 'Select A Print Area',
		'type' => 'select',
		'options' => array(
			'' =>  __('Select Print Area', 'cmb2'),
			'front' => __('Front', 'cmb2'),
			'back' =>  __('Back', 'cmb2'),
			'left' =>  __('Left', 'cmb2'),
			'right' =>  __('Right', 'cmb2'),
		),
	));
}
add_action('cmb2_admin_init', 'add_product_variation_custom_fields');

// Hook to display custom fields in the variation tab
function show_custom_fields_in_variation($loop, $variation_data, $variation)
{
	$prefix = 'c2wear_';

	$cmb = cmb2_get_metabox($prefix . 'product_variation_metabox', $variation->ID);

	if ($cmb) {
		$cmb->show_form();
	}
}
add_action('woocommerce_product_after_variable_attributes', 'show_custom_fields_in_variation', 10, 3);

// Hook to save custom fields for product variations
function save_custom_fields_in_variation($variation_id, $i)
{
	$prefix = 'c2wear_';
	$cmb = cmb2_get_metabox($prefix . 'product_variation_metabox', $variation_id);

	if ($cmb) {
		$cmb->save_fields($variation_id, 'product_variation');
	}
}
add_action('woocommerce_save_product_variation', 'save_custom_fields_in_variation', 10, 2);

// enque styles and scripts

function my_theme_enqueue_styles()
{
	$enqueufiles = array(
		array('handle' => 'GlobalCss', 'src' => '/assets/css/global.css', 'type' => 'style', 'dep' => array(), 'loc' => 'internal'),
		array('handle' => 'FontCss', 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', 'type' => 'style', 'dep' => array(), 'loc' => 'external'),
		array('handle' => 'HomeCss', 'src' => '/assets/css/home.css', 'type' => 'style', 'dep' => array(), 'loc' => 'internal'),
		array('handle' => 'woostylescss', 'src' => '/assets/css/woostyles.css', 'type' => 'style', 'dep' => array(), 'loc' => 'internal'),
		array('handle' => 'sliderjs', 'src' => '/assets/js/sliders.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'archivejs', 'src' => '/assets/js/archive.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'mainjs', 'src' => '/assets/js/main.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'owljs', 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'external'),
		array('handle' => 'owlcss', 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', 'type' => 'style', 'dep' => array(), 'loc' => 'external'),
	);

	foreach ($enqueufiles as $enfiles) {
		if ($enfiles['loc'] == 'internal') {
			$src = get_stylesheet_directory_uri() . $enfiles['src'];
			$ver = filemtime(get_stylesheet_directory() . $enfiles['src']);
		} else {
			$src = $enfiles['src'];
			$ver = '1.0.0';
		}
		$dep = $enfiles['dep'];
		error_log('Enqueuing ' . $enfiles['handle'] . ' from ' . $src);

		if ($enfiles['type'] == 'style') {
			wp_enqueue_style($enfiles['handle'], $src, $dep, $ver, 'all');
		} else {
			wp_enqueue_script($enfiles['handle'], $src, $dep, $ver, true);
		}
	}
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');




function filter_products()
{
	$colors = isset($_POST['color']) ? array_map('sanitize_text_field', (array) $_POST['color']) : [];
	$sizes = isset($_POST['size']) ? array_map('sanitize_text_field', (array) $_POST['size']) : [];
	$categories = isset($_POST['selectedcat']) ? array_map('sanitize_text_field', (array) $_POST['selectedcat']) : [];
	$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1; // Get the current page number
	$currentpage = isset($_POST['currentpage']) ? intval($_POST['currentpage']) : 1; // Get the current page number
	$minprice = isset($_POST['minprice']) ? intval($_POST['minprice']) : 1; // Get the current page number
	$maxprice = isset($_POST['maxprice']) ? intval($_POST['maxprice']) : 1; // Get the current page number
	$currentarch = isset($_POST['currentarch']) ? intval($_POST['currentarch']) : 1; // Get the current page number
	$sorting = isset($_POST['sorting']) ? ($_POST['sorting']) : ''; // Get the current page number


	$args = [
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $paged,
		'paged'          => $currentpage, // Set the current page
		'tax_query'      => [
			'relation' => 'AND',
		],
	];

	if (!empty($sorting) && $sorting == 'price') {
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = '_price';
		$args['order'] = 'ASV';
	} else if (!empty($sorting) && $sorting == 'oldfirst') {
		$args['orderby'] = 'date';
		$args['order'] = 'ASC';
	} else if (!empty($sorting) && $sorting == 'newfirst') {
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	}

	if ($minprice >= 0 && $maxprice > 0) {
		$args['meta_query'] =  [
			'relation' => 'AND',
			[
				'key'     => '_price',
				'value'   => [$minprice, $maxprice],
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC',
			],
		];
	}
	if (!empty($colors)) {
		$args['tax_query'][] = [
			'taxonomy' => 'pa_color',
			'field'    => 'id',
			'terms'    => $colors,
			'operator' => 'IN', // Allow multiple selections
		];
	}

	if (!empty($sizes)) {
		$args['tax_query'][] = [
			'taxonomy' => 'pa_size',
			'field'    => 'id',
			'terms'    => $sizes,
			'operator' => 'IN',
		];
	}

	if (!empty($categories)) {
		$args['tax_query'][] = [
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $categories,
			'operator' => 'IN',
		];
	} else {
		$args['tax_query'][] = [
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $currentarch,
			'operator' => 'IN',
		];
	}
	$query = new WP_Query($args);

	if ($query->have_posts()) {
		ob_start();

		while ($query->have_posts()) {
			$query->the_post();

			global $product;

			// Use get_template_part with the correct path
			include get_stylesheet_directory() . '/template-parts/product_loop_card_ar.php';
		}
		wp_reset_postdata();

		$products_html = ob_get_clean();



		// Return products and pagination HTML
		wp_send_json_success([
			'products'   => $products_html,
			'total_pages' => $query->max_num_pages,
			'total_posts' => $query->found_posts,
		]);
	} else {
		wp_send_json_error('No products found.');
	}

	wp_die();
}
add_action('wp_ajax_filter_products', 'filter_products');
add_action('wp_ajax_nopriv_filter_products', 'filter_products');



function get_the_attribute_type($attribute_name)
{
	// The attribute slug (e.g., "color")
	$attribute_slug = $attribute_name;

	// Get the taxonomy name for the attribute (e.g., "pa_color")
	$taxonomy = 'pa_' . $attribute_slug;

	// Fetch all attributes
	$attributes = wc_get_attribute_taxonomies();

	// Initialize variable to store the attribute ID
	$attribute_id = null;

	// Loop through all attributes to find the ID of the desired attribute
	foreach ($attributes as $attribute) {
		if ($attribute->attribute_name === $attribute_slug) {
			$attribute_id = $attribute->attribute_id;
			break;
		}
	}

	if ($attribute_id) {
		// Get the WooCommerce attribute object
		$attribute = wc_get_attribute($attribute_id);

		// Access the attribute's details
		$attribute_label = $attribute->name;
		$attribute_type = $attribute->type; // Could be 'select', 'text', etc.
		return $attribute_type;
	}
}
