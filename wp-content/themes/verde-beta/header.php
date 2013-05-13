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
    <script> var template_dir = '<?php bloginfo("template_url"); ?>'; </script>
    <?php
    wp_enqueue_script('jquery');
    wp_enqueue_script('other', get_template_directory_uri() . '/js/other.js');
    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js',
                      array('jquery'));
    ?>

    <?php wp_head(); ?>
  </head>

  <body>
    <header>
      <div class="container_16">
        <div id="logo">
	        <div class="title"><?php bloginfo('name'); ?></div>
	        <div class="sub"><?php bloginfo('description'); ?></div>
        </div>
        <div class="grid_16 navBar">
          <a class="navLink selected" id="homelink">Home</a>
          <?php $categories = get_categories(array('sort_column' => 'menu_order',
                                                   'hide_empty' => 0,
                                                   'number' => 6)); ?>
          <?php foreach ($categories as $category) : ?>
	        <a class="navLink"
             id="<?php echo $category->slug ?>link"><?php echo $category->name ?></a>
          <?php endforeach; ?>
          <a class="navLink" id="aboutlink">About</a>
          <span></span>
        </div>
        <?php if(function_exists('ticker')) : ?>
        <div class="lineBreak"></div>
        <div class="grid_16"><?php ticker(); ?></div>
        <?php endif; ?>
      </div>
    </header>

    <div id="mask">
      <div id="wrapper">
