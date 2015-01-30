<?php
/**
 * This file contains all the botas functionality.
 *
 * @author Vita
 */

/**
 * ADD THE ACTIONS
 */
add_action('init', 'pexeto_register_botas_category');  
add_action('init', 'pexeto_register_botas_post_type');  
add_action('manage_posts_custom_column',  'botas_show_columns'); 
add_filter('manage_edit-botas_columns', 'botas_columns');

/**
 * Registers the botas category taxonomy.
 */
function pexeto_register_botas_category(){

	register_taxonomy("botas_category",
	array('botas'),
	array(	"hierarchical" => true,
			"label" => "Categorias", 
			"singular_label" => "Categorias", 
			"rewrite" => true,
			"query_var" => true
	));
}

/**
 * Registers the botas custom type.
 */
function pexeto_register_botas_post_type() {

	register_post_type('botas-2014', array(
		'labels' => array(
			'name' => 'Botas 2014',
			'singular_name' => 'Botas',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Botas',
			'edit_item' => 'Edit Botas',
			'new_item' => 'New Botas',
			'all_items' => 'All Botas',
			'view_item' => 'View Botas',
			'search_items' => 'Search Botas',
			'not_found' =>  'No Botas found',
			'not_found_in_trash' => 'No Botas found in Trash',
			'parent_item_colon' => '',
			'menu_name' => 'Botas'
		),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'botas-2014'),
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => true,
		'menu_position' => 5,
		'supports' => array('title', 'editor'),
		'taxonomies' => array('botas_category'),
	));
}


function botas_columns($columns) {
	$columns['category'] = 'Categorias';
	return $columns;
}

/**
 * Add category column to the botas items page
 * @param $name
 */
function botas_show_columns($name) {
	global $post;
	switch ($name) {
		case 'category':
			$cats = get_the_term_list( $post->ID, 'botas_category', '', ', ', '' );
			echo $cats;
	}
}


/**
 * Gets a list of custom taxomomies by slug
 * @param $term_id the slug
 */
function pexeto_get_taxonomy_slug($term_id){
	global $wpdb;

	$res = $wpdb->get_results($wpdb->prepare("SELECT slug FROM $wpdb->terms WHERE term_id=%s LIMIT 1;", $term_id));
	$res=$res[0];
	return $res->slug;
}
