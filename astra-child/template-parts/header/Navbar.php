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
                        <?php render_custom_dropdown_menu('header_menu'); ?>
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