<?php 
defined('ABSPATH') or die("Not Allowed");

if(isset($_POST['save_byi_settings'])) {
	$settings = array();
	$settings['byi_auto_publish'] = $_POST['byi_auto_publish'];
	$settings['byi_cron_interval'] = $_POST['byi_cron_interval'];
	$settings['byi_posts_total'] = $_POST['byi_posts_total'];
	$settings['byi_w_width'] = $_POST['byi_w_width'];
	$settings['byi_w_height'] = $_POST['byi_w_height'];	
	$settings['byi_youtube_api_key'] = $_POST['byi_youtube_api_key'];	
	update_option("byi_settings", $settings);
}
$settings = get_option("byi_settings");
?>

<div class="wrap">
<h2><?php esc_html_e('beTube YouTube Importer General Settings', 'byi') ?></h2>

<form action="" method="post">
<table class="form-table">
<tbody>
	<tr>
		<th scope="row">
			<label><?php esc_html_e('Post Status', 'byi') ?></label>
		</th>
		<td>
			<input type="radio" value="1" name="byi_auto_publish" <?php if($settings['byi_auto_publish'] == 1) echo 'checked="checked"'; ?>> <?php esc_html_e('Publish', 'byi') ?>
			<input type="radio" value="0" name="byi_auto_publish" <?php if($settings['byi_auto_publish'] == 0) echo 'checked="checked"'; ?>> <?php esc_html_e('Draft', 'byi') ?><br>
			<span class="setting-description"><?php esc_html_e('Please select Post Status, IF you will select Publish then All Posts will be goes to Public/Live', 'byi') ?></span>
		</td>
	</tr>
    <tr>
		<th scope="row">
			<label><?php esc_html_e('Number of Posts in Single Cron', 'byi') ?></label>
		</th>
		<td>
			<select name="byi_posts_total">
				<?php $options = array(5,10,15,20,25,30,35,40);
					foreach($options as $opt) {
						$selected = ($settings['byi_posts_total'] == $opt) ? ' selected="selected"': '';
						echo '<option value="'.$opt.'"'.$selected.'>'.$opt.'</option>"';
					}
				?>
			</select>&nbsp;<?php esc_html_e('Videos', 'byi') ?><br>
		</td>
	</tr>
    <tr>
		<th scope="row">
			<label><?php esc_html_e('Video Size Width x Height', 'byi') ?></label>
		</th>
		<td>
			<input type="text" value="<?php echo $settings['byi_w_width']; ?>" name="byi_w_width" placeholder="750" size="6"/> x <input type="text" value="<?php echo $settings['byi_w_height']; ?>" name="byi_w_height" placeholder="500" size="6"/>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label><?php esc_html_e('Import the latest videos every:', 'byi') ?></label>
		</th>
		<td>
			<select name="byi_cron_interval">
				<?php $byiInterval = $settings['byi_cron_interval'];?>
				<option value="daily" <?php if($byiInterval == 'daily'){echo "selected";}?>>
					<?php esc_html_e('Every Day', 'byi') ?>
				</option>
				<option value="hourly" <?php if($byiInterval == 'hourly'){echo "selected";}?>>
					<?php esc_html_e('Every Hour', 'byi') ?>
				</option>
				<option value="30min" <?php if($byiInterval == '30min'){echo "selected";}?>>
					<?php esc_html_e('Every 30 Min', 'byi') ?>
				</option>
				<option value="5min" <?php if($byiInterval == '5min'){echo "selected";}?>>
					<?php esc_html_e('Every 5 Min', 'byi') ?>
				</option>
			</select> <?php esc_html_e('hours', 'byi') ?><br>
			<p><?php esc_html_e('Set this to determine how many hours to wait between imports.', 'byi') ?></p>			
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label><?php esc_html_e('YouTube API Key', 'byi') ?></label>
		</th>
		<td>
			<input type="text" value="<?php echo $settings['byi_youtube_api_key']; ?>" name="byi_youtube_api_key" placeholder="Put your API Key here...!" size="60"/>
			<p>
				<?php esc_html_e('To get your YouTube API key, visit this address:', 'byi') ?> <a href="https://code.google.com/apis/console" target="_blank">https://code.google.com/apis/console</a></p>
			<p>
			<?php esc_html_e('After signing in, visit', 'byi') ?><strong><?php esc_html_e('Create a new project', 'byi') ?></strong>  <?php esc_html_e('and enable', 'byi') ?><strong><?php esc_html_e('YouTube Data API', 'byi') ?></strong>
			</p>
			<p>
			<?php esc_html_e('To get your API key visit', 'byi') ?><strong><?php esc_html_e('APIs', 'byi') ?> &amp; <?php esc_html_e('auth', 'byi') ?></strong> <?php esc_html_e('and under', 'byi') ?> <strong><?php esc_html_e('Public API access', 'byi') ?></strong> <?php esc_html_e('create a new', 'byi') ?><strong><?php esc_html_e('Server Key', 'byi') ?></strong>.
			</p>
		</td>
	</tr>
</tbody>
</table>


<p class="submit"><input type="submit" value="Save Changes" class="button button-primary" id="submit" name="save_byi_settings"></p></form>

</div>