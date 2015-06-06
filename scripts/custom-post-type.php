<?php

add_action( 'init', 'zone_map_init' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function zone_map_init() {
	$labels = array(
		'name'               => _x( 'Zone Maps', 'Zones' ),
		'singular_name'      => _x( 'Zone Map', 'Zone' ),
		'menu_name'          => _x( 'Zone Maps', 'admin menu' ),
		'name_admin_bar'     => _x( 'Zone Maps', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New', 'zone' ),
		'add_new_item'       => __( 'Add New Zone Map' ),
		'new_item'           => __( 'New Zone Map' ),
		'edit_item'          => __( 'Edit Zone Map' ),
		'view_item'          => __( 'View Zone Map' ),
		'all_items'          => __( 'All Zone Maps' ),
		'search_items'       => __( 'Search Zone Maps' ),
		'parent_item_colon'  => __( 'Parent Zone Map:' ),
		'not_found'          => __( 'No Zone Maps found.' ),
		'not_found_in_trash' => __( 'No Zone Maps found in Trash.' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => false,
		'exclude_from_search'=> true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 10,
		'supports'           => array( 'title', 'editor' )
	);

	register_post_type( 'zone-map', $args );
}