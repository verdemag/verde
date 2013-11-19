<?php
/**
 * The header!
 */

function pageClasses($type, $name) {
  echo $type;
  if(isset($_GET['page']) && $_GET['page'] == $name) {
    echo ' select';
  }
}

$ver = isset($_GET['ver']) ? "\"{$_GET['ver']}\"" : 'false';
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
    <script>
    var template_dir = '<?php bloginfo("template_url"); ?>';
    var ver = <?php echo $ver; ?>;
    </script>
    <script>
    <?php vticker_js(); ?>
    </script>

    <?php wp_head(); ?>
  </head>

  <body>
    <header>
      <div class="container_16">
        <div id="logo">
	        <div class="title"><?php bloginfo('name'); ?></div>
	        <div class="sub"><?php bloginfo('description'); ?></div>
        </div>
        <nav class="navBar">
        <?php
        wp_nav_menu(array('theme-location' => 'primary',
                          'container' => false,
                          'depth' => 2,
                          'walker' => new verde_walker_nav_menu
                          ));
        ?>
        <span></span>
        </nav>

        <div class="lineBreak"></div>
        <div class="ticker">
          <span>That, or the scrolling effect could be removed entirely, but it's nice (esp how the entire verde is one page now)</span>
        </div>
      </div>
    </header>

    <div id="mask">
      <main>
