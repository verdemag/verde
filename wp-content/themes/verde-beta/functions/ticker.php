<?php
function ticker() {
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

?>
