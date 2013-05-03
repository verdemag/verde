<?php
/**
 * The header!
 */
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
    <link href=<?php bloginfo('stylesheet_url'); ?> rel="stylesheet" type="text/css" />
    <?php
    wp_enqueue_script('jquery');
	  wp_enqueue_script('scroll-to', get_template_directory_uri() . '/js/jquery.scrollTo-min.js', array('jquery'));
    wp_enqueue_script('lettering', get_template_directory_uri() . '/js/jquery.lettering-0.6.1.min.js', array('jquery'));
    wp_enqueue_script('other', get_template_directory_uri() . '/js/other.js');
    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js',
                      array('jquery', 'scroll-to', 'lettering'));
    ?>

    <?php wp_head(); ?>
  </head>
	
  <body>
    <div id="fb-root"></div>
    <div class="container_16">
      <div id="logo">
				<div class="title"><?php bloginfo('name'); ?></div>
				<div class="sub"><?php bloginfo('description'); ?></div>
      </div>
      <div class="grid_16 navBar">
        <?php $pages = get_pages(array('sort_column' => 'menu_order',
                                       'number' => 8)); ?>
        <?php foreach ($pages as $page) : ?>
				<div class="grid_2 navLink"
             id="<?php echo $page->post_name ?>link"><?php echo $page->post_title ?></div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="container_12 tickerWrapper">
      <div class="lineBreak"></div>
      <div class="grid_12"><?php if(function_exists('ticker')) ticker(); ?></div>
    </div>

    <div id="mask">
      <div id="wrapper">
