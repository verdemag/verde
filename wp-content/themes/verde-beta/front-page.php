<?php get_header(); ?>
<main class="container_12 page" id="home">
  <?php echo getPage(get_page_by_title("Home")); ?>
</main>
<?php
$categories = get_categories(array('sort_column' => 'menu_order',
                                   'hide_empty' => 0,
                                   'number' => 6));
foreach ($categories as $category) : ?>
<main class="container_16 page" id="<?php echo $category->slug ?>">
  <?php echo getPage($category) ?>
</main>
<?php endforeach; ?>

<main class="container_12 page" id="about">
  <?php echo getPage(get_page_by_title("About")); ?>
</main>

<?php if($_GET['post']) : ?>
<main class="container_12 page select" id="<?php echo $_GET['post']; ?>">
  <?php echo getPage(get_posts(array( 'name' => $_GET['post']))[0]); ?>
</main>
<?php endif; ?>
<?php get_footer(); ?>
