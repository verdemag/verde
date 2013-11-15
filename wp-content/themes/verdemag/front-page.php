<?php get_header(); ?>
<div id="loader">
  <div id="squaresWaveG"><div id="squaresWaveG_1" class="squaresWaveG"></div><div id="squaresWaveG_2" class="squaresWaveG"></div><div id="squaresWaveG_3" class="squaresWaveG"></div><div id="squaresWaveG_4" class="squaresWaveG"></div><div id="squaresWaveG_5" class="squaresWaveG"></div><div id="squaresWaveG_6" class="squaresWaveG"></div><div id="squaresWaveG_7" class="squaresWaveG"></div><div id="squaresWaveG_8" class="squaresWaveG"></div></div>
</div>

<?php $cover = get_cover_posts(); ?>
<section class="<?php pageClasses('page','home'); ?>" id="home">
  <div class="navGrid">
    <div class="navGridCol left">
      <div class="navGridCell double">
        <a class="navLink"
           data-target="<?php echo $cover['ul']->slug; ?>">
           <img src="<?php echo $cover['ul']->img; ?>">
        </a>
      </div>
      <div class="navGridCell double">
        <a class="navLink"
           data-target="<?php echo $cover['ll']->slug; ?>">
           <img src="<?php echo $cover['ll']->img; ?>">
        </a>
      </div>
    </div>
    <div class="navGridCol">
      <div class="navGridCell">
        <a class="navLink"
           data-target="<?php echo $cover['um']->slug; ?>">
           <img src="<?php echo $cover['um']->img; ?>">
        </a>
      </div>
      <div class="navGridCell">
        <a class="navLink"
           data-target="<?php echo $cover['mm']->slug; ?>">
           <img src="<?php echo $cover['mm']->img; ?>">
        </a>
      </div>
      <div class="navGridCell">
        <a class="navLink"
           data-target="<?php echo $cover['lm']->slug; ?>">
           <img src="<?php echo $cover['lm']->img; ?>">
        </a>
      </div>
    </div>
    <div class="navGridCol right">
      <div class="navGridCell">
        <a class="navLink"
           data-target="<?php echo $cover['ur']->slug; ?>">
           <img src="<?php echo $cover['ur']->img; ?>">
        </a>
      </div>
      <div class="navGridCell double">
        <a class="navLink"
           data-target="<?php echo $cover['lr']->slug; ?>">
           <img src="<?php echo $cover['lr']->img; ?>">
        </a>
      </div>
    </div>
  </div>
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

<?php if(isset($_GET['post'])) : ?>
<section class="post select" id="<?php echo $_GET['post']; ?>">
  <?php echo getPage(get_posts(array( 'name' => $_GET['post']))[0]); ?>
</section>
<?php endif; ?>
<?php get_footer(); ?>
