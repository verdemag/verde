<?php get_header(); ?>
<?php
$pages = get_pages(array('sort_column' => 'menu_order',
                         'number' => 8));
foreach ($pages as $page) : ?>
<div class="container_12 page" id="<?php echo $page->post_name ?>">
  <?php if($page->page_template == 'default') : ?>
  <div class="grid_12">
    <?php echo $page->post_content; ?>
  </div>
  <?php elseif($page->page_template == 'psidebar.php') : ?>
  <div class="grid_9">
    <?php echo $page->post_content; ?>
  </div>
  <?php echo file_get_contents(get_template_directory_uri() . '/sidebar.php'); ?>
  <?php else : ?>
  <p><?php echo $page->page_template ?></p>
  <?php endif; ?>
</div>
<?php endforeach; ?>
<?php get_footer(); ?>
