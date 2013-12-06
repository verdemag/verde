<?php get_header(); ?>

<?php if (!is_user_logged_in()) : ?>
	<section class="page">
		<h1>Site under construction!</h1>
		<p>Hello, this site is currently under construction! If you want to view the site, please <a href="http://verdemagazine.com/wp-login.php?redirect_to=http%3A%2F%2Fverdemagazine.com%2F&reauth=1">login</a>.</p>
	</section>
	<script>
	 jQuery(document).ready(function() {
		 window.setTimeout(function() {jQuery('.navLink').click(null);}, 200)
	 });
	</script>
	<?php get_footer(); ?>

	<?php die(); ?>
<?php endif; ?>

<div id="loader">
  <div id="squaresWaveG"><div id="squaresWaveG_1" class="squaresWaveG"></div><div id="squaresWaveG_2" class="squaresWaveG"></div><div id="squaresWaveG_3" class="squaresWaveG"></div><div id="squaresWaveG_4" class="squaresWaveG"></div><div id="squaresWaveG_5" class="squaresWaveG"></div><div id="squaresWaveG_6" class="squaresWaveG"></div><div id="squaresWaveG_7" class="squaresWaveG"></div><div id="squaresWaveG_8" class="squaresWaveG"></div></div>
</div>

<?php $cover = get_cover_posts(); ?>
<section class="page" id="home" style="display:none;">
  <div class="navGrid">
    <div class="navGridCol left">
      <div class="navGridCell double">
        <a class="navLink"
           data-target="<?php echo $cover['ul']->slug; ?>">
           <img src="<?php echo $cover['ul']->img; ?>">
        </a>
				<h2><?php echo $cover['ul']->title ?></h2>
      </div>
      <div class="navGridCell double">
        <a class="navLink"
           data-target="<?php echo $cover['ll']->slug; ?>">
           <img src="<?php echo $cover['ll']->img; ?>">
        </a>
				<h2><?php echo $cover['ll']->title ?></h2>
      </div>
    </div>
    <div class="navGridCol">
      <div class="navGridCell">
        <a class="navLink"
           data-target="<?php echo $cover['um']->slug; ?>">
           <img src="<?php echo $cover['um']->img; ?>">
        </a>
				<h2><?php echo $cover['um']->title ?></h2>
      </div>
      <div class="navGridCell">
        <a class="navLink"
           data-target="<?php echo $cover['mm']->slug; ?>">
           <img src="<?php echo $cover['mm']->img; ?>">
        </a>
				<h2><?php echo $cover['mm']->title ?></h2>
      </div>
      <div class="navGridCell">
        <a class="navLink"
           data-target="<?php echo $cover['lm']->slug; ?>">
           <img src="<?php echo $cover['lm']->img; ?>">
        </a>
				<h2><?php echo $cover['lm']->title ?></h2>
      </div>
    </div>
    <div class="navGridCol right">
      <div class="navGridCell">
        <a class="navLink"
           data-target="<?php echo $cover['ur']->slug; ?>">
           <img src="<?php echo $cover['ur']->img; ?>">
        </a>
				<h2><?php echo $cover['ur']->title ?></h2>
      </div>
      <div class="navGridCell double">
        <a class="navLink"
           data-target="<?php echo $cover['lr']->slug; ?>">
           <img src="<?php echo $cover['lr']->img; ?>">
        </a>
				<h2><?php echo $cover['lr']->title ?></h2>
      </div>
    </div>
  </div>
</section>
<?php
$locations = get_nav_menu_locations();

if (isset($locations['primary'])) {
  $menu_id = $locations['primary'];
}
$navitems = wp_get_nav_menu_items($menu_id);
$pages = array();
global $archive_ID;
foreach ($navitems as $navitem) {
  switch ($navitem->object) {
    case "category":
    $cat = get_category($navitem->object_id);
    if($cat->parent != $archive_ID)
    $pages[] = $cat;
    break;
    case "page":
    $pages[] = get_post($navitem->object_id);
    break;
    default: break;
  }
}
foreach ($pages as $page) : ?>
<section class="<?php pageClasses($page); ?>" id="<?php echo $page->slug ? $page->slug : $page->post_name; ?>" style="display:none;">
  <?php echo getPage($page) ?>
</section>
<?php endforeach; ?>

<?php if(isset($_GET['post'])) : ?>
<section class="post select" id="<?php echo $_GET['post']; ?>" style="display:none;">
  <?php echo getPage(get_posts(array( 'name' => $_GET['post']))[0]); ?>
</section>
<?php endif; ?>
<?php get_footer(); ?>
