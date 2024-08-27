<?php

/**
 * footer files
 * 
 * 
 * */
?>

<?php
// section before footer
$features = get_field('our_features', 'option');
$footer_content = get_field('footer', 'options');

if (count($features) > 0) {
?>
    <section class="our_features_ar">
        <div class="container_mi_ar">
            <div class="d_grid_space_between_ar">
                <?php
                foreach ($features as $feature) {
                    $title = $feature['feature_title'];
                    $description = $feature['feature_description'];
                ?>
                    <div class="feature_ar">
                        <div class="feature_icon_ar">
                            <img src="<?php echo $feature['feature_icon']; ?>" alt="">
                        </div>
                        <div class="feature_content_ar">
                            <h3 class="font_14_800 text_white_ar"><?php echo $title; ?></h3>
                            <p class="font_12_400 text_white_60_ar mb_ar_0"><?php echo $description; ?></p>
                        </div>
                    </div>
                <?php } ?>
                <div class="feature_logo_ar">
                    <img src="<?php echo $footer_content['footer_logo']; ?>" alt="">

                </div>
            </div>
        </div>
    </section>
<?php
}
?>
<?php
// section before footer
$newsletter = get_field('newsletter_column', 'options');
$about_column = get_field('about_column', 'options');

?>

<section class="footer_wrapper_ar">
    <div class="container_mi_ar">
        <div class="d_flex_space_between_ar">
            <div class="newsletter_ar">
                <h2 class="font_24_800 text_white_ar text_transform_upper"><?php echo $newsletter['section_title']; ?></h2>
                <p class="font_14_400 text_white_60_ar max_width_ar_243"><?php echo $newsletter['section_description']; ?></p>
                <div class="sub_form_wraper" id="subscription_form_ar">
                    <?php echo do_shortcode($newsletter['subscription_form_shortcode']); ?>
                </div>
            </div>
            <?php footer_menu_acf('my_links_column'); ?>
            <?php footer_menu_acf('products_column'); ?>
            <?php footer_menu_acf('information_column'); ?>
            <div class="about_us_footer_ar">
                <div class="footer_accordian_ar">
                    <div class="footer_acc_head_ar">
                        <h2 class="font_12_700 text_white_ar mb_ar_21"><?php echo $about_column['column_title']; ?></h2>
                        <div class="footer_acc_icons_ar">
                            <i class="fa-solid fa-plus" id="footer_plus_ar"></i>
                            <i class="fa-solid fa-minus" id="footer_minus_ar"></i>
                        </div>
                    </div>
                    <div class="footer_acc_body_ar">
                        <div class="font_12_400 text_white_60_ar"><?php echo $about_column['column_description']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// footer content
$footer_content = get_field('footer', 'options');
$social = $footer_content['social_links'];
if ($footer_content) {
?>
    <footer class="footer_ar">
        <div class="container_mi_ar">
            <div class="d_flex_space_between_ar">
                <div class="footer_copyright_ar">
                    <p class="font_12_400 text_white_60_ar mb_ar_0">
                        <?php echo $footer_content['footer_copyright_text']; ?>
                    </p>
                </div>
                <div class="footer_logo_ar">
                    <img src="<?php echo $footer_content['footer_logo']; ?>" alt="">
                </div>
                <div class="social_ar">
                    <div class="facebook">
                        <a href="<?php echo $social['facebook_link']; ?>" target="_blank"><i class="fa-brands fa-facebook"></i></a>
                    </div>
                    <div class="facebook_link">
                        <a href="<?php echo $social['facebook_link']; ?>" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                    <div class="youtube_link">
                        <a href="<?php echo $social['youtube_link']; ?>" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                    <div class="pinterest_link">
                        <a href="<?php echo $social['pinterest_link']; ?>" target="_blank"><i class="fa-brands fa-pinterest"></i></a>
                    </div>
                    <div class="twitter_link">
                        <a href="<?php echo $social['twitter_link']; ?>" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                    <div class="tiktok_link">
                        <a href="<?php echo $social['tiktok_link']; ?>" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php
} ?>
<?php
// footer
wp_footer(); ?>