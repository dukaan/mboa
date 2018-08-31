<?php defined('ABSPATH') or die("Not Allowed"); ?>
<div class="wrap">
	<div class="icon32" id="icon-options-general"><br></div>
	<h2><?php esc_html_e('Channels / Playlists', 'byi') ?> <a class="button" href="./admin.php?page=byi_channels&action=add"><?php esc_html_e('Add New', 'byi') ?></a></h2>
	
	<form action="" method="post">
		
		<table cellspacing="0" class="widefat fixed">
			<thead>
			<tr class="thead">
				<th style="width:150px;" class="manage-column column-name" id="channel" scope="col">
					<?php esc_html_e('Name', 'byi') ?>
				</th>
				<th style="width:150px;" class="manage-column column-channel" id="channel" scope="col">
					<?php esc_html_e('Channel/Playlist', 'byi') ?>
				</th>
				<th style="width:20%;" class="manage-column column-cat" id="cat" scope="col">
					<?php esc_html_e('Catgories', 'byi') ?>
				</th>
				<th class="manage-column column-author" id="author" scope="col">
					<?php esc_html_e('Author', 'byi') ?>
				</th>
				<th class="manage-column column-byi-type" id="byi-type" scope="col">
					<?php esc_html_e('Type', 'byi') ?>
				</th>
				<th class="manage-column column-byi-total" scope="col">
					<?php esc_html_e('Total Videos', 'byi') ?>
				</th>
				<th class="manage-column column-byi-posted" scope="col">
					<?php esc_html_e('Total Posted', 'byi') ?>
				</th>
				<th class="manage-column " scope="col">
					<?php esc_html_e('Actions', 'byi') ?>
				</th>
			</tr>
			</thead>
			<tfoot>
			<tr class="thead">
				<th class="manage-column column-name" scope="col">
					<?php esc_html_e('Name', 'byi') ?>
				</th>
				<th class="manage-column column-channel" scope="col">
					<?php esc_html_e('Channel/Playlist', 'byi') ?>
				</th>
				<th class="manage-column column-cat" scope="col">
					<?php esc_html_e('Catgories', 'byi') ?>
				</th>
				<th class="manage-column column-author" scope="col">
					<?php esc_html_e('Author', 'byi') ?>
				</th>
				<th class="manage-column column-byi-type" scope="col">
					<?php esc_html_e('Type', 'byi') ?>
				</th>
				<th class="manage-column column-byi-total" scope="col">
					<?php esc_html_e('Total Videos', 'byi') ?>
				</th>
				<th class="manage-column column-byi-posted" scope="col">
					<?php esc_html_e('Total Posted', 'byi') ?>
				</th>
				<th class="manage-column " scope="col">
					<?php esc_html_e('Actions', 'byi') ?>
				</th>
			</tr>
			</tfoot>
			<tbody class="list:fields field-list" id="fields">
			<?php 
				$channels = get_option("byi_channels");				
				$channels = (!empty($channels)) ? unserialize($channels) : array();
				//print_r($channels);
				if(!empty($channels )) : 
					foreach($channels as $c_id => $channel) :?>					
				<tr>
					<td class="manage-column column-name" scope="col"><?php echo $channel['name']; ?></td>
					<td class="manage-column column-channel" scope="col"><?php echo $c_id; ?></td>
					<td class="manage-column column-cat" scope="col"><?php 
					if(!empty($channel['cats'])) : 
						foreach($channel['cats'] as $cat) :
							echo get_cat_name( $cat ) . ",";
						endforeach;
					endif;
					?></td>					
					<td class="manage-column column-author" scope="col"><?php $user_info = get_userdata($channel['author']); echo $user_info->user_nicename; ?></td>
					<?php 
					$byiChallenType = $channel['byi_input_type_id'];
					$totalVideosFound = $channel['totalVideoFound'];
					//echo $byiChallenType;
					if($byiChallenType == 'byi_channel'){						
						$byiType =  esc_html__( 'YouTube Channel', 'byi' );
					}elseif($byiChallenType == 'byi_playlist'){						
						$byiType =  esc_html__( 'YouTube Playlist', 'byi' );
					}
					$postedVideo = $channel['posted'];
					$idCount = -1;
					$singleIDP = explode(",", $postedVideo);
					foreach( $singleIDP as $IDCount ){
						$idCount++;
					}
					?>
					<td class="manage-column column-byi-type" scope="col"><?php echo $byiType; ?></td>
					<td class="manage-column column-byi-total" scope="col"><?php echo $totalVideosFound; ?></td>
					<td class="manage-column column-byi-posted" scope="col"><?php echo $idCount; ?></td>
					<td class="manage-column column-actions" scope="col">
						<input type="button" class="button-secondary action" value="Process Now" onclick="window.location= './admin.php?page=BYI_process&cid=<?php echo $c_id; ?>'; this.disabled=true;"> 
						<input type="button" class="button-secondary action" value="Delete" onclick="window.location= './admin.php?page=byi_channels&action=delete&cid=<?php echo $c_id; ?>'">
						<input type="button" class="button-secondary action" value="Reset" onclick="window.location= './admin.php?page=byi_channels&action=reset&cid=<?php echo $c_id; ?>'">
					</td>
				</tr><?php endforeach; endif; ?>
			</tbody>
		</table>		
		<input type="hidden" value="ayvpp-channels" name="page" id="page">
	</form>
	<div class="byi_extra">
		<h1><?php esc_html_e('Please read these points', 'byi') ?></h1>
		<p><strong><?php esc_html_e('Process Now', 'byi') ?> : </strong> <?php esc_html_e('As you know we have auto import for all channels, But if you dont want to wait then click on', 'byi') ?> <strong><?php esc_html_e('Process Now', 'byi') ?></strong> <?php esc_html_e('button and then importing will be start right away.', 'byi') ?></p>
		<p><strong><?php esc_html_e('Delete', 'byi') ?>  : </strong> <?php esc_html_e('If you want to delete channel then you can click this button.', 'byi') ?></p>
		<p><strong><?php esc_html_e('Reset', 'byi') ?> : </strong><?php esc_html_e('If you want to import videos from start then click this button then it will start importing from zero. Make Sure you have deleted all posts before to reset otherwise posts will be duplicate', 'byi') ?></p>
	</div>
</div>