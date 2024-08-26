<?php



$producttabs = get_field("product_tabs", "options");
?>

<div class="customization_guide_ar">
    <h2 class="font_32_700 text_dark_ar text_align_center_ar mb_ar_0"><?php echo get_field('product_tabs_section_title', 'options'); ?></h2>
    <p class="font_14_400 text_dark_op60_ar max_width_ar_483 text_align_center_ar"><?php echo get_field('product_tabs_section_description', 'options'); ?></p>
    <div class="tabs_ar">
        <?php
        foreach ($producttabs as $index => $value) {
            $title = trim($value['tab_title']);
            $titleid = str_replace(' ', '_', $title);
            $titleid = "tabs_" . $titleid . "_ar";
            $description = $value['tab_content'];
        ?>
            <h6 class="tab-link_ar <?php $index == 0 ? print 'active' : ''; ?>" onclick='openTab(event, "<?php echo $titleid; ?>")'><?php echo $title; ?></h6>

        <?php
        }
        ?>
    </div>
    <?php
    foreach ($producttabs as $index => $value) {
        $title = trim($value['tab_title']);
        $titleid = str_replace(' ', '_', $title);
        $titleid = "tabs_" . $titleid . "_ar";
        $description = $value['tab_content'];
    ?>
        <div id="<?php echo $titleid; ?>" class="tab-content_ar <?php $index == 0 ? print 'first_tab_ar' : ''; ?>">

            <?php echo $description; ?>
        </div>

    <?php
    }
    ?>
</div>