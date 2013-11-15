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
          'ul' => 'Upper left',
          'll' => 'Lower left',
          'um' => 'Upper middle',
          'mm' => 'Center',
          'lm' => 'Lower middle',
          'ur' => 'Upper right',
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

add_action('admin_init', 'cover_meta_box');
?>
