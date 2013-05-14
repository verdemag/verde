<?php get_header(); ?>
<section class="container_12 page" id="home">
  <?php echo getPage(get_page_by_title("Home")); ?>
</section>
<?php
$categories = get_categories(array('sort_column' => 'menu_order',
                                   'hide_empty' => 0,
                                   'number' => 6));
foreach ($categories as $category) : ?>
<section class="container_16 category" id="<?php echo $category->slug ?>">
  <?php echo getPage($category) ?>
</section>
<?php endforeach; ?>

<section class="container_12 page" id="about">
  <?php echo getPage(get_page_by_title("About")); ?>
</section>

<?php if($_GET['post']) : ?>
<section class="container_12 post select" id="<?php echo $_GET['post']; ?>">
  <?php echo getPage(get_posts(array( 'name' => $_GET['post']))[0]); ?>
</section>
<?php endif; ?>
<?php get_footer(); ?>
