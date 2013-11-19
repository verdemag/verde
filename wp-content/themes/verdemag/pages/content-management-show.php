<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
<?php
if (isset($_POST['frm_vticker_display']) && $_POST['frm_vticker_display'] == 'yes')
{
	$did = isset($_GET['did']) ? $_GET['did'] : '0';

	$vticker_success = '';
	$vticker_success_msg = FALSE;

	$sSql = $wpdb->prepare(
		"SELECT COUNT(*) AS `count` FROM ".vticker_table."
		WHERE `vticker_id` = %d",
		array($did)
	);
	$result = '0';
	$result = $wpdb->get_var($sSql);

	if ($result != '1')
	{
		?><div class="error fade"><p><strong>Oops, selected details doesn't exist (1).</strong></p></div><?php
	}
	else
	{
		if (isset($_GET['ac']) && $_GET['ac'] == 'del' && isset($_GET['did']) && $_GET['did'] != '')
		{
			check_admin_referer('vticker_form_show');

			$sSql = $wpdb->prepare("DELETE FROM `".vticker_table."`
					WHERE `vticker_id` = %d
					LIMIT 1", $did);
			$wpdb->query($sSql);

			$vticker_success_msg = TRUE;
			$vticker_success = __('Selected record was successfully deleted.', vticker_UNIQUE_NAME);
		}
	}

	if ($vticker_success_msg == TRUE)
	{
		?><div class="updated fade"><p><strong><?php echo $vticker_success; ?></strong></p></div><?php
	}
}
?>
<div class="wrap">
  <div id="icon-edit" class="icon32 icon32-posts-post"></div>
    <h2><?php echo vticker_TITLE; ?><a class="add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=verde-ticker&amp;ac=add">Add New</a></h2>
    <div class="tool-box">
	<?php
		$sSql = "SELECT * FROM `".vticker_table."` order by vticker_id desc";
		$myData = array();
		$myData = $wpdb->get_results($sSql, ARRAY_A);
		?>
		<script language="JavaScript" src="<?php echo get_template(); ?>/pages/setting.js"></script>
		<form name="frm_vticker_display" method="post">
      <table width="100%" class="widefat" id="straymanage">
        <thead>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="vticker_group_item[]" /></th>
			<th scope="col">News</th>
			<th scope="col">Display</th>
			<th scope="col">Expiration</th>
			<th scope="col">Order</th>
          </tr>
        </thead>
		<tfoot>
          <tr>
            <th class="check-column" scope="col"><input type="checkbox" name="vticker_group_item[]" /></th>
			<th scope="col">News</th>
			<th scope="col">Display</th>
			<th scope="col">Expiration</th>
			<th scope="col">Order</th>
          </tr>
        </tfoot>
		<tbody>
			<?php
			$i = 0;
			if(count($myData) > 0 )
			{
				foreach ($myData as $data)
				{
					?>
					<tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">
						<td align="left"><input type="checkbox" value="<?php echo $data['vticker_id']; ?>" name="vticker_group_item[]"></td>
						<td><?php echo stripslashes($data['vticker_text']); ?>
						<div class="row-actions">
							<span class="edit"><a title="Edit" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=verde-ticker&amp;ac=edit&amp;did=<?php echo $data['vticker_id']; ?>">Edit</a> | </span>
							<span class="trash"><a onClick="javascript:_vticker_delete('<?php echo $data['vticker_id']; ?>')" href="javascript:void(0);">Delete</a></span>
						</div>
						</td>
						<td><?php echo $data['vticker_status']; ?></td>
						<td><?php echo substr($data['vticker_dateend'],0,10); ?></td>
						<td><?php echo $data['vticker_order']; ?></td>
					</tr>
					<?php
					$i = $i+1;
				}
			}
			else
			{
				?><tr><td colspan="6" align="center">No records available.</td></tr><?php
			}
			?>
		</tbody>
        </table>
		<?php wp_nonce_field('vticker_form_show'); ?>
		<input type="hidden" name="frm_vticker_display" value="yes"/>
      </form>
	  <div class="tablenav">
	  <h2>
	  <a class="button add-new-h2" href="<?php echo get_option('siteurl'); ?>/wp-admin/options-general.php?page=verde-ticker&amp;ac=add">Add New</a>
	  </h2>
	  </div>
	  <div style="height:8px"></div>
	<h3>Plugin configuration option</h3>
	<ol>
		<li>Drag and drop the widget to your sidebar.</li>
		<li>Add the ticker in posts or pages using short code.</li>
		<li>Add directly in to the theme using PHP code.</li>
	</ol>
	</div>
</div>