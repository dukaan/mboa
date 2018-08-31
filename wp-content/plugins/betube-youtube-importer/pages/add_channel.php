<?php defined('ABSPATH') or die("Not Allowed"); ?>

<div class="wrap">
<h2><?php esc_html_e('Add Channel', 'byi') ?></h2>

<form action="./admin.php?page=byi_channels" method="post">
<table class="form-table">
<tbody>
	<tr>
		<th scope="row">
			<label><?php esc_html_e('Name', 'byi') ?></label>
		</th>
		<td>
			<input type="text" class="regular-text" name="byi_channel_name" placeholder="<?php esc_html_e('Type channel name', 'byi') ?>">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label><?php esc_html_e('Select Channel/PlayList', 'byi') ?></label>
		</th>
		<td>
			<select id="byi_input_type_id" name="byi_input_type_id">
				<option value="byi_channel"><?php esc_html_e('YouTube Channel', 'byi') ?></option>
				<option value="byi_playlist"><?php esc_html_e('YouTube PlayList', 'byi') ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label><?php esc_html_e('Put Channel ID or PlayList', 'byi') ?></label>
		</th>
		<td>
			<input type="text" class="regular-text" name="byi_channel_id" placeholder="<?php esc_html_e('Your Channel ID or Playlist ID', 'byi') ?>">
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label><?php esc_html_e('Select Video Categories', 'byi') ?></label>
		</th>
		<td>
			<?php  $categories = get_categories(array('hide_empty' => 0)); 
  foreach ($categories as $category) { ?>
					<input type="checkbox" value="<?php echo $category->cat_ID; ?>" class="chk" name="categories[]"><?php echo $category->name; ?><br/>
					<?php } ?>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label><?php esc_html_e('Select Author', 'byi') ?></label>
		</th>
		<td>
			<select class="" id="author" name="author">
			<?php echo $blogusers = get_users( array( 'fields' => array( 'user_nicename', 'ID' ) ) );
			foreach ( $blogusers as $user ) { ?>
				<option value="<?php echo $user->ID; ?>"><?php echo $user->user_nicename; ?></option>
			<?php } ?>
			</select>
		</td>
	</tr>
	
</tbody>
</table>


<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="byi_add_channel"></p></form>

</div>