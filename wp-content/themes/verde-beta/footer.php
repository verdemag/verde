<?php
/**
 * The footer!
 */
?>
</main>
</div>
<footer class="container_12">
	<div class="grid_6" style="text-align:right">
		<div class="row">&#169; Verde Magazine</div>
    <div class="row">
		  <a class="navLink" id="aboutlink">About</a> -
		  <a href="">Contact</a> -
      <a id="zoombutton">Zoom</a>
    </div>
    <div class="row">
      <?php if (is_user_logged_in()) : ?>
      <a href="wp-admin">Dashboard</a> -
      <a href="wp-admin/post-new.php">Write</a>
      <?php else : ?>
      <a href="wp-login.php">Login</a>
      <?php endif; ?>
    </div>
	</div>
	<div class="grid_6" style="text-align:left">
		Palo Alto High School</br>
		50 Embarcadero Rd</br>
		Palo Alto, California 94301</br>
	</div>
</footer><!--Closes footer div-->
<?php wp_footer(); ?>
</body>
</html>

