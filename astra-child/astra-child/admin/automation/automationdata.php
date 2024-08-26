<?php


function my_theme_create_pages_on_activation()
{
    // Array of pages to create or update
    $pages = [
        [
            'title' => 'Home',
            'slug' => 'home-2',
            'template' => 'templates/homepage.php', // Relative path to the custom template
        ],
        [
            'title' => 'FAQ',
            'slug' => 'faq-2',
            'template' => 'templates/faqpage.php', // Relative path to the custom template
        ],
        [
            'title' => 'Contact',
            'slug' => 'contact-2',
            'template' => 'templates/contactustemplate.php', // Relative path to the custom template
        ],
    ];

    foreach ($pages as $page) {
        // Check if the page already exists
        $existing_page = get_page_by_path($page['slug']);
        if ($existing_page) {
            // If the page exists, assign the custom template
            update_post_meta($existing_page->ID, '_wp_page_template', $page['template']);
        } else {
            // Create the new page
            $page_id = wp_insert_post([
                'post_title' => $page['title'],
                'post_name' => $page['slug'],
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_content' => '', // Optional: add default content here
            ]);

            // Assign the custom template
            if ($page_id && !is_wp_error($page_id)) {
                update_post_meta($page_id, '_wp_page_template', $page['template']);
            }
        }
    }
    import_acf_fields_on_theme_activation();
    my_theme_import_pages();
}
add_action('after_switch_theme', 'my_theme_create_pages_on_activation');



function my_theme_import_pages()
{
    // Path to the XML file
    $import_file = get_stylesheet_directory() . '/assets/c2wear.xml';

    // Include WordPress Importer class
    require_once ABSPATH . 'wp-admin/includes/import.php';
    if (! class_exists('WP_Import')) {
        include_once ABSPATH . 'wp-content/plugins/wordpress-importer/wordpress-importer.php';
    }

    // Create a new importer instance
    if (class_exists('WP_Import')) {
        $importer = new WP_Import();

        // Set import options
        $importer->fetch_attachments = true; // Set this to true if you want to import attachments

        // Capture the import output
        ob_start();
        $importer->import($import_file);
        $import_status = ob_get_clean();

        // Log or display the result
        // For example, write status to a log file
        file_put_contents(get_template_directory() . '/import/import-log.txt', $import_status);

        // Or use WP's admin notices (uncomment to use)
        add_action('admin_notices', function () use ($import_status) {
            echo '<div class="notice notice-success is-dismissible">';
            echo '<p>' . esc_html('Import Status: ' . $import_status) . '</p>';
            echo '</div>';
        });
    } else {
        error_log('WordPress Importer class not found.');
    }
}


// Function to import ACF fields
function import_acf_fields_on_theme_activation()
{
    // Check if ACF plugin is active
    if (function_exists('acf_add_local_field_group')) {
        // Path to the ACF fields JSON file
        include get_stylesheet_directory() . '/admin/acf/acf-fields.php';

        add_action('admin_notices', function () {
            echo '<div class="notice notice-error is-dismissible"><p>Advanced Custom Fields (ACF) plugin is  active. Import Success.</p></div>';
        });
    } else {
        // Optionally add an error message to admin notices if ACF is not active
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error is-dismissible"><p>Advanced Custom Fields (ACF) plugin is not active. Import failed.</p></div>';
        });
    }
}
