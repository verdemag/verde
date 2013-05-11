<?php
function add_sidebar_box() {
  remove_meta_box(
    'pageparentdiv',
    'page',
    'side'
  );
  add_meta_box('attribs_box',
               __( 'Page Attributes' ),
               'verde_box_cb',
               'page',
               'side');
}

function verde_box_cb($post) {
  $post_type_object = get_post_type_object($post->post_type);
  if ( $post_type_object->hierarchical ) {
    $dropdown_args = array(
      'post_type'        => $post->post_type,
      'exclude_tree'     => $post->ID,
      'selected'         => $post->post_parent,
      'name'             => 'parent_id',
      'show_option_none' => __('(no parent)'),
      'sort_column'      => 'menu_order, post_title',
      'echo'             => 0,
    );

    $dropdown_args = apply_filters( 'page_attributes_dropdown_pages_args', $dropdown_args, $post );
    $pages = wp_dropdown_pages( $dropdown_args );
    if ( ! empty($pages) ) {
      echo '<p><strong>' . _e('Parent') . '</strong></p>';
      echo '<label class="screen-reader-text" for="parent_id">' . _e('Parent') . '</label>';
      echo $pages;
    }
  }
  if ( 'page' == $post->post_type && 0 != count( get_page_templates() ) ) {
    $template = !empty($post->page_template) ? $post->page_template : false;
    echo '<p><strong>Page Type</strong></p>';
    echo '<label class="screen-reader-text" for="page_template">Page Type</label><select name="page_template" id="page_template">';
    echo '<option value="/templates/page.php">Default Page</option>';
    page_template_dropdown($template);
    echo '</select>';
  }
  echo '<p><strong>' . _e('Order') . '</strong></p>';
  echo '<p><label class="screen-reader-text" for="menu_order">' . _e('Order') . '</label><input name="menu_order" type="text" size="4" id="menu_order" value="' . esc_attr($post->menu_order) . '" /></p>';

  if ( 'page' == $post->post_type ) {
    echo '<p>Need help? Use the Help tab in the upper right of your screen.</p>';
  }
}
?>