<?php
function create_ad_type() {
	register_post_type( 'ad',
		array(
			'labels' => array(
				'name' => 'Ads',
				'singular_name' => 'Ad',
        'add_new_item' => 'Add New Ad',
        'edit_item' => 'Edit Ad',
        'view_item' => 'View Ad',
        'search_items' => 'Search Ads',
        'not_found' => 'No ads found',
        'not_found_in_trash' => 'No ads found in trash'
			),
		  'public' => true,
      'exclude_from_search' => true,
      'show_in_nav_menus' => false,
      'show_in_admin_bar' => false,
      'menu_position' => 5,
      'supports' => false,
		  'has_archive' => true
		)
	);
}

function ad_meta_box() {
  if ( !class_exists( 'RW_Meta_Box' ) )
  return;

  $meta_box = array(
    'id' => 'ad_meta_box',
    'title' => 'Ad Attributes',
    'pages' => array('ad'),
    'priority' => 'high',
    'autosave' => true,
    'fields' => array(
      array(
        'name' => 'Image',
        'id' => 'img',
        'type' => 'image_advanced'
      ),
      array(
        'name' => 'URL (if set, Post is ignored)',
        'id' => 'url',
        'type' => 'text',
        'std' => ''
      ),
    )
  );
  new RW_Meta_Box( $meta_box );
}

function default_custom_fields($post_id) {
  if ( $_GET['post_type'] == 'ad' ) {
    add_post_meta($post_id, 'url', '', true);
  }

  return true;
}

add_action('wp_insert_post', 'default_custom_fields');
add_action( 'init', 'create_ad_type' );
add_action('admin_init', 'ad_meta_box');
?>