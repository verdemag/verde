<?php get_header(); ?>
<div id="loader">
  <div id="squaresWaveG"><div id="squaresWaveG_1" class="squaresWaveG"></div><div id="squaresWaveG_2" class="squaresWaveG"></div><div id="squaresWaveG_3" class="squaresWaveG"></div><div id="squaresWaveG_4" class="squaresWaveG"></div><div id="squaresWaveG_5" class="squaresWaveG"></div><div id="squaresWaveG_6" class="squaresWaveG"></div><div id="squaresWaveG_7" class="squaresWaveG"></div><div id="squaresWaveG_8" class="squaresWaveG"></div></div>
</div>

<section class="<?php pageClasses('page','home'); ?>" id="home">
  <?php echo getPage(get_page_by_title("Home")); ?>
</section>
<?php
$categories = get_categories(array('sort_column' => 'menu_order',
                                   'hide_empty' => 0,
                                   'number' => 6));
foreach ($categories as $category) : ?>
<section class="<?php pageClasses('category', $category->slug); ?>" id="<?php echo $category->slug ?>">
  <?php echo getPage($category) ?>
</section>
<?php endforeach; ?>

<section class="<?php pageClasses('page', 'about') ?>" id="about">
  <?php echo getPage(get_page_by_title("About")); ?>
</section>

<?php if($_GET['post']) : ?>
<section class="post select" id="<?php echo $_GET['post']; ?>">
  <?php echo getPage(get_posts(array( 'name' => $_GET['post']))[0]); ?>
</section>
<?php endif; ?>
<?php get_footer(); ?>
