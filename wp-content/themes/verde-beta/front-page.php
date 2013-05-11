<?php get_header(); ?>
<div class="container_12 page" id="home">
  <?php echo getPage(get_page_by_title("Home")); ?>
</div>
<?php
$categories = get_categories(array('sort_column' => 'menu_order',
                                   'hide_empty' => 0,
                                   'number' => 6));
foreach ($categories as $category) : ?>
<div class="container_16 page" id="<?php echo $category->slug ?>">
  <?php echo getPage($category) ?>
</div>
<?php endforeach; ?>

<div class="container_12 page" id="about">
  <?php echo getPage(get_page_by_title("About")); ?>
</div>
<?php get_footer(); ?>
