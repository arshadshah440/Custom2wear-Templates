<?php
// template name: Faqpage

get_header();
?>

<?php
/***********  Home Accoridan Section **********/
?>
<div class="practreason padd_65_100" id="homeaccordiana_ar">
    <div class="container_mi_ar">
        <h2 class="font_48_700 mb_ar_50 text_align_center_ar" id="mb_ar_50"><?php echo get_field('accordian_section_title'); ?></h2>
        <?php
        if (have_rows('faqpage_accordian')) {
        ?>
            <div class="accordian_wrapper_ar" id="accordian_wrapper_ar">

                <?php
                while (have_rows('faqpage_accordian')) {
                    the_row();
                    $question = get_sub_field('faqpage_accordian_heading');
                    $answer = get_sub_field('faqpage_accordian_description');
                ?>
                    <div class="accordian_ar_mi">
                        <div class="accordian_ar_mi_head">
                            <h5 class="font_16_600"><?php echo $question; ?></h5>
                            <div class="accord_icons_ar">
                                <i class="fa-solid fa-minus" id="minus_ar"></i>
                                <i class="fa-solid fa-plus" id="plus_ar"></i>
                            </div>
                        </div>
                        <div class="accordian_ar_mi_desc font_14_400 text_dark_op60_ar">
                            <?php echo $answer; ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }

        ?>
    </div>
</div>

<?php get_footer(); ?>