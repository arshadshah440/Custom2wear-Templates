<?php
$call_us_button_number = get_field('call_us_button_number', 'options');
$email_for_email_us_button = get_field('email_for_email_us_button', 'options');
?>

<div class="needahand_ar">
    <div class="container_mi_ar">
        <h2 class="font_32_700 text_white_ar text_align_center_ar mb_ar_0"><?php echo get_field('need_a_hand_section_title', 'options'); ?></h2>
        <p class="font_14_400 text_white_op60_ar max_width_ar_483 text_align_center_ar"><?php echo get_field('need_a_hand_section_description', 'options'); ?></p>
        <div class="cta_links_ar">
            <?php
            if (!empty($call_us_button_number)) {
            ?>
                <a href="tel:<?php echo get_field('call_us_button_number', 'options'); ?>"> <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/phone.svg'; ?>" alt=""> <?php echo get_field('call_us_button_text', 'options'); ?> </a>
            <?php } ?>
            <?php
            if (!empty($email_for_email_us_button)) {
            ?>
                <a href="mailto:<?php echo get_field('email_for_email_us_button', 'options'); ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/email.svg'; ?>" alt=""> <?php echo get_field('email_us_button_text', 'options'); ?></a>
            <?php } ?>
        </div>
    </div>
</div>