<?php get_header(); ?>
<?php
$pages = get_pages(array('sort_column' => 'menu_order',
                         'number' => 8));
foreach ($pages as $page) : ?>
<div class="container_12 page" id="<?php echo $page->post_name ?>">
  <?php echo getPage($page); ?>
</div>
<?php endforeach; ?>
<?php get_footer(); ?>
