<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

get_header();
?>

<section class="archieve_hero_ar">
    <div class="container_mi_ar"></div>
        <div class="row_mi_ar">
            <div class="col_6_mi_ar">
                <h1 class="font_48_700 text_white_ar"><?php echo get_the_archive_title(); ?></h1>
                <p class="font_14_400 text_white_op60_ar"><?php echo get_the_archive_description(); ?></p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>