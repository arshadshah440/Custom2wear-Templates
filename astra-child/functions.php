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
define('WC_MAX_LINKED_VARIATIONS', 1500);

include get_stylesheet_directory() . '/admin/singleproduct/singleproductfunc.php';
include get_stylesheet_directory() . '/admin/automation/automationdata.php';
include get_stylesheet_directory() . '/admin/themeoptions/rendermenu.php';

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

// register custom menu
function register_custom_menu()
{
	register_nav_menu('header_menu', __('Header Menu', 'straight-curve'));
}
add_action('init', 'register_custom_menu');


// enque styles and scripts

function my_theme_enqueue_styles()
{
	$enqueufiles = array(
		array('handle' => 'GlobalCss', 'src' => '/assets/css/global.css', 'type' => 'style', 'dep' => array(), 'loc' => 'internal'),
		array('handle' => 'FontCss', 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css', 'type' => 'style', 'dep' => array(), 'loc' => 'external'),
		array('handle' => 'HomeCss', 'src' => '/assets/css/home.css', 'type' => 'style', 'dep' => array(), 'loc' => 'internal'),
		array('handle' => 'slickCss', 'src' => '/assets/css/slick.css', 'type' => 'style', 'dep' => array(), 'loc' => 'internal'),
		array('handle' => 'singlepcustomCss', 'src' => '/assets/css/singlepcustom.css', 'type' => 'style', 'dep' => array(), 'loc' => 'internal'),
		array('handle' => 'woostylescss', 'src' => '/assets/css/woostyles.css', 'type' => 'style', 'dep' => array(), 'loc' => 'internal'),
		array('handle' => 'globalsectionscss', 'src' => '/assets/css/globalsections.css', 'type' => 'style', 'dep' => array(), 'loc' => 'internal'),
		array('handle' => 'sliderjs', 'src' => '/assets/js/sliders.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		// array('handle' => 'singlemainjs', 'src' => '/assets/js/single/main.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'draganddropjs', 'src' => '/assets/js/single/draganddrop.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'wooscriptsjs', 'src' => '/assets/js/single/wooscripts.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'slickcarouseljs', 'src' => '/assets/js/single/slickcarousel.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'setdefaultvaluesjs', 'src' => '/assets/js/single/setdefaultvalues.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'singleproductjs', 'src' => '/assets/js/single/singleproduct.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'AddNewPrintAreasjs', 'src' => '/assets/js/single/AddNewPrintAreas.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'swatchselectionjs', 'src' => '/assets/js/single/swatchselection.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'CalculatorEventListenersjs', 'src' => '/assets/js/single/CalculatorEventListeners.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'Singleslickminjs', 'src' => '/assets/js/single/slick.min.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'archivejs', 'src' => '/assets/js/archive.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'mainjs', 'src' => '/assets/js/main.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'internal'),
		array('handle' => 'owljs', 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js', 'type' => 'script', 'dep' => array('jquery'), 'loc' => 'external'),
		array('handle' => 'owlcss', 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', 'type' => 'style', 'dep' => array(), 'loc' => 'external'),
		array('handle' => 'zoomjs', 'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.6.1/jquery.zoom.min.js', 'type' => 'script', 'dep' => array(), 'loc' => 'external'),
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


function my_custom_admin_styles()
{
	// Register the style like this:
	wp_register_style(
		'custom_admin_css', // Handle name for the style.
		get_stylesheet_directory_uri() . '/assets/css/admin/style.css', // Path to the CSS file.
		false, // Dependencies.
		'1.0.0' // Version number.
	);

	// Enqueue the style.
	wp_enqueue_style('custom_admin_css');
}
add_action('admin_enqueue_scripts', 'my_custom_admin_styles');
// chane the delimiter of woocommerce breadscrumnb
add_filter('woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumbs');
function custom_woocommerce_breadcrumbs($defaults)
{
	// Use a Font Awesome icon as the delimiter
	$defaults['delimiter'] = ' <i class="fas fa-chevron-right"></i> '; // Replace with the desired Font Awesome icon class
	return $defaults;
}

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
			'taxonomy' => 'pa_sizes',
			'field'    => 'id',
			'terms'    => $sizes,
			'operator' => 'IN',
		];
	}

	if (!empty($categories) && count($categories) > 0) {
		$args['tax_query'][] = [
			'taxonomy' => 'product_cat',
			'field'    => 'id',
			'terms'    => $categories,
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

add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init()
{

	// Check function exists.
	if (function_exists('acf_add_options_page')) {

		// Register options page.
		$option_page = acf_add_options_page(array(
			'page_title'    => __('Theme General Settings'),
			'menu_title'    => __('Theme Settings'),
			'menu_slug'     => 'theme-general-settings',
			'capability'    => 'edit_posts',
			'redirect'      => false
		));
		// Register options page.
		$option_page2 = acf_add_options_page(array(
			'page_title'    => __('Products Tab Content'),
			'menu_title'    => __('Products Tab Content'),
			'menu_slug'     => 'product-tab-contact',
			'capability'    => 'edit_posts',
			'redirect'      => false
		));
		// Register options page.
		$option_page3 = acf_add_options_page(array(
			'page_title'    => __('Global Options'),
			'menu_title'    => __('Global Options'),
			'menu_slug'     => 'global-options',
			'capability'    => 'edit_posts',
			'redirect'      => false
		));
		// Register options page.
		$option_page4 = acf_add_options_page(array(
			'page_title'    => __('Tool Tips Data'),
			'menu_title'    => __('Tool Tips Data'),
			'menu_slug'     => 'tool-tips-data',
			'capability'    => 'edit_posts',
			'redirect'      => false
		));
	}
}


function footer_menu_acf($acf)
{
	$content = get_field($acf, 'options');
	$links = $content['column_links'];
?>
	<div class="footer_menu_ar" id="<?php echo $acf; ?>_ar">
		<div class="footer_accordian_ar">
			<div class="footer_acc_head_ar">
				<h2 class="font_12_700 text_white_ar"><?php echo $content['column_title']; ?></h2>
				<div class="footer_acc_icons_ar">
					<i class="fa-solid fa-plus" id="footer_plus_ar"></i>
					<i class="fa-solid fa-minus" id="footer_minus_ar"></i>
				</div>
			</div>
			<div class="footer_acc_body_ar">
				<div class="menu_wraper_ar">
					<?php
					foreach ($links as $link) {
					?>
						<div class="menu_item_ar">
							<a href="<?php echo $link['link_url']; ?>" class="font_12_400 text_white_op60_ar">
								<?php echo $link['link_title']; ?>
							</a>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
<?php

}

function get_first_variation_image_by_color($product_id)
{
	// Get the product object
	$product = wc_get_product($product_id);

	// Ensure the product has variations
	if (! $product || ! $product->is_type('variable')) {
		return [];
	}

	// Get all available variations
	$available_variations = $product->get_available_variations();

	// Initialize an array to store the first variation image for each color
	$color_variation_images = [];

	// Loop through each variation
	foreach ($available_variations as $variation) {
		// Get variation attributes
		$attributes = $variation['attributes'];

		// Assuming 'pa_color' is the color attribute slug
		if (isset($attributes['attribute_pa_color'])) {
			$color = $attributes['attribute_pa_color'];

			// If we haven't already stored an image for this color
			if (! isset($color_variation_images[$color])) {
				// Get the image ID of the variation
				$image_id = $variation['image_id'];

				// Get the image URL using the image ID
				$image_url = wp_get_attachment_url($image_id);

				// Store the image URL with the color as the key
				$color_variation_images[$color] = $image_id;
			}
		}
	}

	return $color_variation_images;
}

add_action('woocommerce_cart_calculate_fees', 'add_extra_fee_for_minimum_quantity');
function add_extra_fee_for_minimum_quantity()
{
	$minimum_quantity = 12;
	$extra_fee_amount = intval(get_field('art_setup_fee', 'options')); // Set your extra fee amount here
	$premium_setup_fee = intval(get_field('premium_artwork_setup_fee', 'options')); // Set your extra fee amount here
	$premiumisenabled = false;

	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		// Check if premium artwork price is enabled
		if (!empty($cart_item['premium_artwork_price']) && $cart_item['premium_artwork_price'] === 'true') {
			$premiumisenabled = true;
			break; // Break the loop once we find a premium item
		}
	}

	// Get the total quantity of items in the cart
	$cart_quantity = WC()->cart->get_cart_contents_count();

	// Apply the standard setup fee if the cart quantity is less than the minimum
	if ($cart_quantity < $minimum_quantity) {
		WC()->cart->add_fee('Setup Fee', $extra_fee_amount, true);
	}

	// Apply the premium setup fee based on premium item being present in the cart
	if ($premiumisenabled && $cart_quantity < 24) {
		WC()->cart->add_fee('Premium Setup Fee', $premium_setup_fee, true);
	}
}


//  contact form validation 
function custom_text_and_textarea_validation_filter($result, $tag)
{
	$tag_name = $tag['name'];

	// Define a regex pattern that allows only text, digits, single and double quotes
	$allowed_pattern = '/^[a-zA-Z0-9\'"\s]+$/';

	// Check text and textarea fields by name
	if ($tag_name == 'your-name' || $tag_name == 'your-subject' || $tag_name == 'your-message') {
		$value = isset($_POST[$tag_name]) ? trim($_POST[$tag_name]) : '';

		// If the value doesn't match the allowed pattern, invalidate the field
		if (!preg_match($allowed_pattern, $value)) {
			$result->invalidate($tag, "Only letters, digits, and quotes (' and \") are allowed.");
		}
	}

	return $result;
}

// Apply the validation filter to text and textarea fields
add_filter('wpcf7_validate_text', 'custom_text_and_textarea_validation_filter', 10, 2);
add_filter('wpcf7_validate_text*', 'custom_text_and_textarea_validation_filter', 10, 2); // For required text fields
add_filter('wpcf7_validate_textarea', 'custom_text_and_textarea_validation_filter', 10, 2);
add_filter('wpcf7_validate_textarea*', 'custom_text_and_textarea_validation_filter', 10, 2); // For required textarea fields


function check_the_category_filter($categories, $archive)
{
	$is_in_child = false;
	if (is_array($categories)) {
		foreach ($categories as $child) {
			if ($child->term_id == $archive) {
				$is_in_child = true;
			}
		}
	}
	return $is_in_child;
}
