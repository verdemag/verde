<?php
function cover_meta_box() {
  if ( !class_exists( 'RW_Meta_Box' ) )
  return;

  $meta_box = array(
    'id' => 'cover_meta_box',
    'title' => 'Display on Cover',
    'pages' => array('post'),
    'priority' => 'low',
    'autosave' => true,
    'fields' => array(
      array(
        'name' => 'Location',
        'id' => 'cover-pos',
        'type' => 'select',
        'options' => array(
          'n' => 'None',
          'ul' => 'Upper left (featured)',
          'ur' => 'Upper right',
          'mr' => 'Middle right',
          'll' => 'Lower left',
          'lm' => 'Lower middle',
          'lr' => 'Lower right'
        ),
        'std' => 'n'
      ),
      array(
        'name' => 'Image',
        'id' => 'cover-image',
        'type' => 'image_advanced'
      )
    )
  );
  new RW_Meta_Box( $meta_box );
}

function post_info_meta_box() {
  if ( !class_exists( 'RW_Meta_Box' ) )
  return;

  $meta_box = array(
    'id' => 'post_info_meta_box',
    'title' => 'Post Info',
    'pages' => array('post'),
    'context' => 'side',
    'autosave' => true,
    'fields' => array(
      array(
        'name' => 'Author',
        'id' => 'verde_author',
        'type' => 'text'
      ),
      array(
        'name' => 'Subtitle',
        'id' => 'subtitle',
        'type' => 'text'
      )
    )
  );
  new RW_Meta_Box( $meta_box );
}

function verde_hidden_meta_boxes($hidden, $screen) {
	if ( 'post' == $screen->base || 'page' == $screen->base )
		$hidden = array('revisionsdiv', 'trackbacksdiv', 'postcustom', 'commentstatusdiv', 'commentsdiv', 'slugdiv', 'authordiv', 'revisionsdiv');

	return $hidden;
}

add_filter('default_hidden_meta_boxes', 'verde_hidden_meta_boxes', 10, 2);
add_action('admin_init', 'post_info_meta_box');
add_action('admin_init', 'cover_meta_box');
?>
