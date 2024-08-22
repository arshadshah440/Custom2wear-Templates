<?php
$cart_count = WC()->cart->get_cart_contents_count();

?>

<header class=" desktop-header" id="header">
    <div class="topheader_wrapper">
        <div class="top_header_ar_mi">
            <div class="container_mi_ar">
                <div class="topheaderbtn_ar">
                    <div class="login_btn">
                        <a class="font_12_400 text_white_ar" href="mailto:<?php echo get_field('top_header_email', 'option'); ?>"><?php echo get_field('top_header_email', 'option'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container_mi_ar" id="container_ar_mi_navheader">
            <nav>
                <div class="straight_logo_header_ar">
                    <a href="<?php echo home_url(); ?>"> <img src="<?php echo get_field('header_logo', 'option'); ?>" alt="Custom2wear"></a>
                </div>
                <div class="header_menu_ar hide_mobile_ar" id="mobile_nav_ar">
                    <div class="close_btn_ar" id="close_btn_ar">
                        &times;
                    </div>
                    <div class="dropdown">
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <ul class="mainmenulist">
                                <?php
                                // Specify the menu location
                                $menu_location = 'header_menu';
                                $svg_path = get_template_directory() . '/assets/img/chevronbottom.svg';
                                $chevronlink = '<i class="fa-solid fa-chevron-down"></i>';
                                // Get the menu object by location
                                $menu_object = get_nav_menu_locations();
                                $menu_id = isset($menu_object[$menu_location]) ? $menu_object[$menu_location] : null;

                                // Check if the menu ID exists
                                if ($menu_id) {
                                    // Get menu items from the specified menu
                                    $menu_items = wp_get_nav_menu_items($menu_id);

                                    // Check if there are menu items
                                    if ($menu_items) {

                                        $subitems = [];
                                        foreach ($menu_items as $menu_item) {
                                            if ($menu_item->menu_item_parent !== '0') {
                                                $subitemarray = array("id" => $menu_item->menu_item_parent, "item" => $menu_item);
                                                array_push($subitems, $subitemarray);
                                            }
                                        }

                                        $currentitemid = '';
                                        foreach ($menu_items as $index => $menu_item) {
                                            // Get the text and link (URL) of the menu item
                                            $text = $menu_item->title;
                                            $link = $menu_item->url;
                                            // Output or use the text and link as needed
                                            if ($menu_item->menu_item_parent == '0') {
                                                if ($menu_items[$index + 1]->menu_item_parent == '0') {
                                                    echo '<li><a class="font_14_400 text_dark_ar text_transform_upper" href="' . esc_html($link) . '">' . esc_html($text) . '</a> </li>';
                                                } else {
                                                    echo '<li><a class="font_14_400 text_dark_ar text_transform_upper" href="' . esc_html($link) . '">' . esc_html($text) . ' <span>' . $chevronlink . '</span></a>';
                                                }
                                            } else {

                                                if ($menu_item->menu_item_parent === $currentitemid) {
                                                    continue;
                                                } else {
                                                    echo "<ul class='submenulist'>";
                                                    foreach ($subitems as $subitem) {
                                                        if ($subitem["id"] == $menu_item->menu_item_parent) {
                                                            echo '<li> <a class="font_14_400 text_dark_ar text_transform_upper" href="' . esc_html($subitem['item']->url) . '">' . esc_html($subitem['item']->title) . '</a> </li>';
                                                        }
                                                    }
                                                }
                                                echo "</ul> </li>";
                                                $currentitemid = $menu_item->menu_item_parent;
                                            }
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="cta_header_ar show_mobile_ar">
                    <a href="#" id="search_btn_ar">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/search.svg'; ?>" alt="">
                    </a>
                    <a href="<?php echo get_field('user_icon_link', 'option'); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/user.svg'; ?>" alt="">
                    </a>
                    <a href="<?php echo get_field('basket_icon_link', 'option'); ?>">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/handbag.svg'; ?>" alt=""> <span id="cart_count_ar"><?php echo $cart_count; ?></span>
                    </a>
                    <div class="mobile_menu_toggler_ar" id="mobile_menu_toggler_ar">
                        <i class="fa-solid fa-bars"></i>
                    </div>
                    <div class="search-form-container" id="search_form_ar">
                        <div class="close_btn_ar" id="searchclose_btn_ar">
                            &times;
                        </div>
                        <?php get_search_form(); ?>
                    </div>
                </div>
            </nav>
        </div>
</header>