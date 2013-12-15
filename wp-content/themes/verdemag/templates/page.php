<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-blog-header.php');
query_posts(array(
	'name' => $_GET['page'],
	'post_type' => 'page',
	'posts_per_page' => 1
));
the_post();
?>
<article>
	<?php the_content(); ?>
</article>
<sidebar>
	<?php include(get_template_directory()."/sidebar.php"); ?>
</sidebar>
