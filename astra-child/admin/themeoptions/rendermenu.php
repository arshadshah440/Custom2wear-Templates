<?php

/**
 * Renders a custom dropdown menu based on the specified menu location.
 *
 * This function retrieves the menu items for the given location and renders 
 * them in a nested list structure. It supports parent-child relationships
 * for submenu items.
 *
 * @param string $menu_location The location of the menu to render.
 */
function render_custom_dropdown_menu($menu_location) {
    // Get the menu object by location
    $menu_object = get_nav_menu_locations();
    $menu_id = isset($menu_object[$menu_location]) ? $menu_object[$menu_location] : null;

    // Check if the menu ID exists
    if ($menu_id) {
        // Get menu items from the specified menu
        $menu_items = wp_get_nav_menu_items($menu_id);

        // Create an array to hold the hierarchy of menu items
        $menu_array = [];
        foreach ($menu_items as $menu_item) {
            // Add menu items to the array based on parent-child relationship
            $menu_array[$menu_item->menu_item_parent][] = $menu_item;
        }

        // Render the menu
        echo '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
        echo '<ul class="mainmenulist">';
        render_menu_items($menu_array, 0); // Start rendering from the top-level menu (parent ID 0)
        echo '</ul>';
        echo '</div>';
    }
}

/**
 * Recursive function to render menu items.
 *
 * This function takes a menu array and a parent ID to render 
 * the menu items as nested lists. It checks for child items 
 * and renders them accordingly.
 *
 * @param array $menu_array The hierarchical array of menu items.
 * @param int $parent_id The ID of the parent menu item.
 */
function render_menu_items($menu_array, $parent_id) {
    // Check if there are any items for the current parent ID
    if (isset($menu_array[$parent_id])) {
        foreach ($menu_array[$parent_id] as $menu_item) {
            $text = esc_html($menu_item->title); // Escape the menu item title
            $link = esc_url($menu_item->url); // Escape the menu item URL
            $has_children = isset($menu_array[$menu_item->ID]); // Check if this menu item has children

            echo '<li>';
            echo '<a class="font_14_400 text_dark_ar text_transform_upper" href="' . $link . '">' . $text;
            if ($has_children) {
                echo ' <i class="fa-solid fa-chevron-down"></i>'; // Add a chevron if it has sub-items
            }
            echo '</a>';

            // If the menu item has children, call the function recursively
            if ($has_children) {
                echo '<ul class="submenulist">';
                render_menu_items($menu_array, $menu_item->ID); // Call recursively to render child items
                echo '</ul>';
            }
            echo '</li>';
        }
    }
}