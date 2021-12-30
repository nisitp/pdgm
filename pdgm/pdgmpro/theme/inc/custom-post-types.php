<?php
/**
 * Register resource post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function excel_health_register_resource_post_type() {
	$labels = array(
		'name'               => 'Resources',
		'singular_name'      => 'Resource',
		'menu_name'          => 'Resources',
		'name_admin_bar'     => 'Resources',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Resource',
		'new_item'           => 'New Resource',
		'edit_item'          => 'Edit Resource',
		'view_item'          => 'View Resource',
		'all_items'          => 'All Resources',
		'search_items'       => 'Search Resources',
		'parent_item_colon'  => 'Parent Resources:',
		'not_found'          => 'No Resources found.',
		'not_found_in_trash' => 'No Resources found in Trash.',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'resources', 'with_front' => false),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
        'supports'           => array('title', 'thumbnail'),
        'taxonomies'         => array('eh_resource_type'),
	);

    register_post_type('eh_resource', $args);
    
	$labels = array(
		'name'                       => 'Types',
		'singular_name'              => 'Type',
		'search_items'               => 'Search Types',
		'popular_items'              => 'Popular Types',
		'all_items'                  => 'All Types',
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => 'Edit Type',
		'update_item'                => 'Update Type',
		'add_new_item'               => 'Add New Type',
		'new_item_name'              => 'New Type Name',
		'separate_items_with_commas' => 'Separate Types with Commas',
		'add_or_remove_items'        => 'Add or remove Types',
		'choose_from_most_used'      => 'Choose from the most used Types',
		'not_found'                  => 'No Types found.',
		'menu_name'                  => 'Types',
	);

	$args = array(
		'hierarchical'          => true,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true
	);

    register_taxonomy('eh_resource_type', 'eh_resource', $args);

    $labels = array(
		'name'                       => 'Audiences/Categories',
		'singular_name'              => 'Audience/Category',
		'search_items'               => 'Search Audience/Category',
		'popular_items'              => 'Popular Audiences/Categories',
		'all_items'                  => 'All Audiences/Categories',
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => 'Edit Audience/Category',
		'update_item'                => 'Update Audience/Category',
		'add_new_item'               => 'Add New Audience/Category',
		'new_item_name'              => 'New Audience/Category Name',
		'separate_items_with_commas' => 'Separate Audiences/Categories with Commas',
		'add_or_remove_items'        => 'Add or remove Audiences/Categories',
		'choose_from_most_used'      => 'Choose from the most used Audiences/Categories',
		'not_found'                  => 'No Audiences/Categories found.',
		'menu_name'                  => 'Audiences & Categories',
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true
	);

	register_taxonomy('eh_resource_category', 'eh_resource', $args);
  register_taxonomy('eh_resource_category', 'post', $args);	
}
add_action('init', 'excel_health_register_resource_post_type');

/**
 * Register testimonial post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function excel_health_register_testimonial_post_type() {
	$labels = array(
		'name'               => 'Testimonials',
		'singular_name'      => 'Testimonial',
		'menu_name'          => 'Testimonials',
		'name_admin_bar'     => 'Testimonials',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Testimonial',
		'new_item'           => 'New Testimonial',
		'edit_item'          => 'Edit Testimonial',
		'view_item'          => 'View Testimonial',
		'all_items'          => 'All Testimonials',
		'search_items'       => 'Search Testimonials',
		'parent_item_colon'  => 'Parent Testimonials:',
		'not_found'          => 'No Testimonials found.',
		'not_found_in_trash' => 'No Testimonials found in Trash.',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'testimonials'),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-testimonial',
        'supports'           => array('title', 'editor'),
	);

    register_post_type('eh_testimonial', $args);

    remove_post_type_support('eh_testimonial', 'title');
    remove_post_type_support('eh_testimonial', 'editor');
}
add_action('init', 'excel_health_register_testimonial_post_type');


/***
* Register alert bar post type
****/
/*
function custom_register_alert_post_type() {
	$labels = array(
		'name'               => 'Alerts',
		'singular_name'      => 'Alert',
		'menu_name'          => 'Alert',
		'name_admin_bar'     => 'Alert',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Alert',
		'new_item'           => 'New Alert',
		'edit_item'          => 'Edit Alert',
		'view_item'          => 'View Alert',
		'all_items'          => 'All Alerts',
		'search_items'       => 'Search Alerts',
		'parent_item_colon'  => 'Parent Alerts:',
		'not_found'          => 'No Alerts found.',
		'not_found_in_trash' => 'No Alerts found in Trash.',
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'alerts'),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-warning',
        'supports'           => array('title', 'editor'),
	);

    register_post_type('custom_alert', $args);

    remove_post_type_support('custom_alert', 'title');
    remove_post_type_support('custom_alert', 'editor');
}
add_action('init', 'custom_register_alert_post_type');
*/

function eh_testimonial_title_updater($post_id) {
    $post = array();
    $post['ID'] = $post_id;

    if(get_post_type($post['ID']) == "eh_testimonial") {
        $post['post_title'] = get_field('name').', '.get_field('company');
        wp_update_post($post);
    }
}
add_action('acf/save_post', 'eh_testimonial_title_updater', 20);

// same for alerts
function eh_alert_title_updater($post_id) {
    $post = array();
    $post['ID'] = $post_id;

    if(get_post_type($post['ID']) == "eh_alert") {
        $post['post_title'] = get_field('title') . " [" . get_field('alert_id') . "]";
        wp_update_post($post);
    }
}
add_action('acf/save_post', 'eh_alert_title_updater', 20);

add_action('init', 'custom_rewrite_basic');
function custom_rewrite_basic() {
    global $wp_post_types;
    foreach ($wp_post_types as $wp_post_type) {
        if ($wp_post_type->_builtin) continue;
        if (!$wp_post_type->has_archive && isset($wp_post_type->rewrite) && isset($wp_post_type->rewrite['with_front']) && !$wp_post_type->rewrite['with_front']) {
            $slug = (isset($wp_post_type->rewrite['slug']) ? $wp_post_type->rewrite['slug'] : $wp_post_type->name);
            $page = get_page_by_slug($slug);
            if ($page) add_rewrite_rule('^' .$slug .'/page/([0-9]+)/?', 'index.php?page_id=' .$page->ID .'&paged=$matches[1]', 'top');
        }
    }
}

function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
    global $wpdb;

    $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'", $page_slug, $post_type ) );

    return ($page ? get_post($page, $output) : NULL);
}
