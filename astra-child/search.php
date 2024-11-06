<?php
get_header(); // Include the header

if (have_posts()) : ?>
    <section class="search-results">
        <h1><?php printf(__('Search Results for: %s', 'astra-child'), get_search_query()); ?></h1>

        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>"><img src="<?php echo wc_placeholder_img_src('full'); ?>" alt=""></a>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

            </article>
        <?php endwhile; ?>

        <div class="pagination">
            <?php
            // Display pagination if there are multiple pages of results
            the_posts_pagination(array(
                'prev_text' => __('Previous', 'astra-child'),
                'next_text' => __('Next', 'astra-child'),
            ));
            ?>
        </div>
    </section>
<?php else : ?>
    <section class="no-results">
        <h1><?php _e('Nothing Found', 'astra-child'); ?></h1>
        <p><?php _e('Sorry, no posts matched your criteria.', 'astra-child'); ?></p>
        <?php get_search_form(); // Display the search form 
        ?>
    </section>
<?php endif;

get_footer(); // Include the footer
