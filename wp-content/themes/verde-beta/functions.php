<?php
wp_enqueue_script('jquery');
show_admin_bar(false);

add_action( 'add_meta_boxes', 'add_sidebar_box' );
add_action( 'admin_menu' , 'ticker_menu' );

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
?>
<p><strong><?php _e('Parent') ?></strong></p>
<label class="screen-reader-text" for="parent_id"><?php _e('Parent') ?></label>
<?php echo $pages; ?>
<?php
} // end empty pages check
} // end hierarchical check.
if ( 'page' == $post->post_type && 0 != count( get_page_templates() ) ) {
$template = !empty($post->page_template) ? $post->page_template : false;
?>
<p><strong><?php _e('Page Type') ?></strong></p>
<label class="screen-reader-text" for="page_template"><?php _e('Page Type') ?></label><select name="page_template" id="page_template">
  <option value='default'><?php _e('Default Page'); ?></option>
  <?php page_template_dropdown($template); ?>
</select>
<?php
} ?>
<p><strong><?php _e('Order') ?></strong></p>
<p><label class="screen-reader-text" for="menu_order"><?php _e('Order') ?></label><input name="menu_order" type="text" size="4" id="menu_order" value="<?php echo esc_attr($post->menu_order) ?>" /></p>
<p><?php if ( 'page' == $post->post_type ) _e( 'Need help? Use the Help tab in the upper right of your screen.' ); ?></p>
<?php
}

function ticker() {
  echo ( '<link rel="stylesheet" type="text/css" href="' . get_template_directory_uri() . '/css/text-ticker.css">' );
  echo ( '<script type="text/javascript" src="' . get_template_directory_uri() . '/js/text-ticker.js"></script>' );
  echo ( "<div class=\"ticker\"><div class=\"tickerText\" style=\"opacity: 1;\">That, or the scrolling effect could be removed entirely, but it's nice (esp. how the entire verde is one page now)</div></div>" );
}

function install_ticker() {
  add_taxonomy();
}

function add_taxonomy()  {
  $labels = array(
    'name'                       => 'Ticker Blurbs',
    'singular_name'              => 'Ticker Blurb',
    'menu_name'                  => 'Ticker Blurbs',
    'all_items'                  => 'All Tickers Blurbs',
    'new_item_name'              => 'New Ticker Blurb',
    'add_new_item'               => 'Add New Ticker Blurb',
    'edit_item'                  => 'Edit Ticker Blurb',
    'update_item'                => 'Update Ticker Blurb',
    'separate_items_with_commas' => 'Separate ticker blurbs with commas',
    'search_items'               => 'Search ticker blurbs',
    'add_or_remove_items'        => 'Add or remove ticker blurbs',
    'choose_from_most_used'      => 'Choose from the most used ticker blurbs',
  );

  $capabilities = array(
    'manage_terms'               => 'edit_posts',
    'edit_terms'                 => 'edit_posts',
    'delete_terms'               => 'edit_posts',
    'assign_terms'               => 'edit_posts',
  );

  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => false,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'capabilities'               => $capabilities,
    'rewrite'                    => array( 'slug' => 'ticker_blurbs' )
  );

  register_taxonomy( 'ticker_blurbs', 'post', $args );
}

function ticker_menu() {
  add_options_page( 'Text Ticker Options', 'Text Ticker', 'edit_posts', 'ticker_menu', 'ticker_options' );
}

function ticker_options() {
  if ( !current_user_can( 'edit_posts' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  echo '<div class="wrap">';
  echo '<p>Here is where the form would go if I actually had options.</p>';
  echo '</div>';
}

function getPage($obj) {
  if($obj->post_type == 'post') {
    $class = 'post';
    $c = $obj->post_content;
  } else if($obj->post_type == 'page') {
    $template = $obj->page_template;
    if($template == 'default') {
      $class='page';
    } else {
      $class = substr($template, 15, strlen($template) - 19);
    }
    $c = $obj->post_content;
  } else if($obj->cat_name != '') {
    $class = 'category';
    $c = $obj->cat_ID;
  } else {
    $class = $obj->post_type;
    $c = $obj->post_content;
  }

  if(!class_exists($class)) {
    if($class == 'page') {
      $file = 'templates/page.php';
    } else if($class == 'category') {
      $file = 'templates/category.php';
    } else {
      $file = $obj->page_template;
    }
    require_once $file;
    if(!class_exists($class)) {
      return $class;
    }
  }

  $loader = new $class($c);

  return $loader->getPageContents();
}

?>
