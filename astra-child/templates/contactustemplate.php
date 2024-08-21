<?php
// Template Name: Contact Us Template

?>

<?php get_header(); ?>

<?php
// get in touch section
$sectioncontent = get_field('get_in_touch_section');
?>
<section class="get_in_touch_ar padding_104_40">
    <div class="container_mi_ar">
        <div class="row_mi_ar">
            <div class="col_6_mi_ar max_width_ar_536_px">
                <h2 class="font_48_700 "><?php echo $sectioncontent['section_title']; ?></h2>
                <p class="font_14_400 text_dark_op60_ar mb_ar_0"><?php echo $sectioncontent['section_description']; ?></p>
                <div class="email_icon_ar">
                    <div class="email_ar">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/email.svg" alt="">
                    </div>
                    <div class="email_link">
                        <a href="mailto:<?php echo $sectioncontent['section_email']; ?>" class="font_16_400 text_dark_ar"><?php echo $sectioncontent['section_email']; ?></a>
                    </div>
                </div>
                <p class="font_14_400 text_dark_op60_ar"><?php echo $sectioncontent['section_description_after_email']; ?></p>
            </div>
            <div class="col_6_mi_ar width_ar_610_px form_ar_wraper">
                <h3 class="font_48_700"><?php echo $sectioncontent['form_section_title']; ?></h3>
                <p class="text_black_80 font_16_400"><?php echo $sectioncontent['form_section_tagline']; ?></p>
                <div class="form_wrapper_ar">
                    <?php echo do_shortcode($sectioncontent['form_shortcode']); ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
// resons to contact us section
$sectioncontent = get_field('reason_to_contact_us_section');
?>
<section class="reason_to_contact_ar">
    <div class="container_mi_ar">
        <div class="row_mi_ars">
            <div class="col_6_mi_ar">
                <h2 class="font_24_700 max_width_ar_461 text_dark_ar"><?php echo $sectioncontent['section_title']; ?></h2>
            </div>
            <?php
            if (count($sectioncontent['contact_reasons']) > 0) {
            ?>
                <div class="d_flex_reasons_ar mar_top_ar_40">
                    <?php
                    foreach ($sectioncontent['contact_reasons'] as $contact_reason) {
                    ?>
                        <div class="reason_ar">
                            <div class="reason_title_ar">
                                <h4 class="font_14_700 text_dark_ar"><?php echo $contact_reason['reason_title']; ?></h4>
                            </div>
                            <div class="reason_desc_ar">
                                <p class="font_14_400 text_dark_op60_ar"><?php echo $contact_reason['reason_description']; ?></p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            <div class="sect_desc_end_ar">
                <p class="font_14_400 text_dark_op60_ar"><?php echo $sectioncontent['section_description']; ?></p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>