<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-blog-header.php');
$locs = ['ul', 'ur', 'mr', 'lr', 'll', 'lm', 'lr'];

function get_cover_post($location) {
  global $wpdb;
	$archive_ID = get_category_by_slug('archive')->cat_ID;
	$ver = isset($_GET['ver']) ? (
		get_category_by_slug($_GET['ver'])
	):(
		get_categories(array('parent' => $archive_ID,
												 'order' => 'desc',
												 'number' => 1))[0]);

	$querystr = "SELECT post_id
		FROM $wpdb->postmeta
		WHERE
			(meta_key = 'cover-pos' AND meta_value = '%s')
		GROUP BY post_id;
	";
	$postids = $wpdb->get_col($wpdb->prepare($querystr, $location));
	$postobj = (object) ["post_name" => "undefined", "post_title" => "Undefined"];
	$theid = -1;

	foreach ($postids as $postid) {
		if (in_category($ver->cat_ID, $postid)) {
			$theid = $postid;
			$postobj = get_post($postid);
			break;
		}
	}
	$post = (object)[];
  $post->slug = $postobj->post_name;
  $post->title = $postobj->post_title;
	if($theid != -1) {
		$post->img = wp_get_attachment_url( get_post_meta($postid, 'cover-image', true) );
	}

  if( $theid == -1 || !$post->img ) {
    if ($location == 'ul') {
      $post->img = 'http://placehold.it/620x340';
    } else {
      $post->img = 'http://placehold.it/300x160';
    }
  }

  return $post;
}

$cover = [];
foreach ($locs as $loc) {
  $cover[$loc] = get_cover_post($loc);
}
?>
<div class="navGrid">
  <div class="navGridCell featured navLink"
       data-target="<?php echo $cover['ul']->slug; ?>">
    <img src="<?php echo $cover['ul']->img; ?>">
		<h2><?php echo $cover['ul']->title ?></h2>
  </div>
	<div class="navGridCol">
		<div class="navGridCell navLink"
				 data-target="<?php echo $cover['ur']->slug; ?>">
			<img src="<?php echo $cover['ur']->img; ?>">
			<h2><?php echo $cover['ur']->title ?></h2>
		</div>
		<div class="navGridCell navLink"
				 data-target="<?php echo $cover['mr']->slug; ?>">
			<img src="<?php echo $cover['mr']->img; ?>">
			<h2><?php echo $cover['mr']->title ?></h2>
		</div>
	</div>
	<div class="navGridRow">
		<div class="navGridCell navLink"
				 data-target="<?php echo $cover['ll']->slug; ?>">
			<img src="<?php echo $cover['ll']->img; ?>">
			<h2><?php echo $cover['ll']->title ?></h2>
		</div>
		<div class="navGridCell navLink"
				 data-target="<?php echo $cover['lm']->slug; ?>">
			<img src="<?php echo $cover['lm']->img; ?>">
			<h2><?php echo $cover['lm']->title ?></h2>
		</div>
		<div class="navGridCell navLink">
			data-target="<?php echo $cover['lr']->slug; ?>">
			<img src="<?php echo $cover['lr']->img; ?>">
			<h2><?php echo $cover['lr']->title ?></h2>
		</div>
	</div>
</div>