<?php
/**
 * The header!
 */
function pageClasses($type, $name) {
  echo $type;
  if($_GET['page'] == $name) {
    echo ' select';
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
    <script> var template_dir = '<?php bloginfo("template_url"); ?>'; </script>

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
          <a class="navLink selected" id="homelink" data-target="home">Home</a>
          <?php $categories = get_categories(array('sort_column' => 'menu_order',
                                                   'hide_empty' => 0,
                                                   'number' => 6)); ?>
          <?php foreach ($categories as $category) : ?>
	        <a class="navLink"
             id="<?php echo $category->slug ?>link"
             data-target="<?php echo $category->slug ?>"
             rel="nofollow"
             href="?page=<?php echo $category->slug ?>">
            <?php echo $category->name ?></a>
          <?php endforeach; ?>
          <a class="navLink" id="aboutlink" data-target="about">About</a>
          <span></span>
        </nav>
        <div class="lineBreak"></div>
        <div class="ticker">
          <span>That, or the scrolling effect could be removed entirely, but it's nice (esp. how the entire verde is one page now)</span>
        </div>
      </div>
    </header>

    <div id="mask">
      <main>
