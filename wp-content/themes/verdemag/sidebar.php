<section>
  <a class="wepay-widget-button wepay-green" id="wepay_widget_anchor_50f8893bb9c9c" href="https://www.wepay.com/donations/11912">Help keep Verde running!</a>
</section>
<section>
<?php
require_once("../../../wp-blog-header.php");
$ad = get_posts(array('numberposts' => 1,
                      'orderby' => 'rand',
                      'post_type' => 'ad'))[0];

$imgs = get_post_meta($ad->ID, 'img');
$img = $imgs[array_rand($imgs)];
?>
<h6>AD<h6>
<a href="<?php echo get_post_meta($ad->ID, 'url', true); ?>">
 <img src="<?php echo wp_get_attachment_url($img); ?>">
</a>
</section>
<section>
  <h6>Verde on Social Media</h6>
  <iframe allowtransparency="true" frameborder="0" scrolling="no"
          src="//www.facebook.com/plugins/like.php?href=https://facebook.com/verdemagazine&layout=button_count"
          style="width:50px; height:20px;"></iframe>
  <iframe allowtransparency="true" frameborder="0" scrolling="no"
          src="//platform.twitter.com/widgets/follow_button.html?screen_name=verdemagazine&show_screen_name=false&show_count=false"
          style="width:60px; height:20px;"></iframe>
</section>
