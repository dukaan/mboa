<?php 
defined('ABSPATH') or die("Not Allowed");
$message = '';
$channel_id = $_GET['cid'];
$channels = get_option("byi_channels");
$settings = get_option("byi_settings");
$channels = (!empty($channels)) ? unserialize($channels) : array();
$ch_videos = (!empty($channels[$channel_id]['posted'])) ? $channels[$channel_id]['posted'] : array();
$byiAuthor = $channels[$channel_id]['author'];
$byiCat = $channels[$channel_id]['cats'];
$previousPosted = $channels[$channel_id]['posted'];
$nextPageToken = $channels[$channel_id]['nextPageToken'];
$prevPageToken = $channels[$channel_id]['prevPageToken'];
$byiChannelPlayList = $channels[$channel_id]['byi_input_type_id'];
$status = $settings['byi_auto_publish'];
	if($status == 1){
		$poststatus = 'publish';
	}else{
		$poststatus = 'draft';
	}
if(array_key_exists($channel_id,  $channels)) : 
?>
<div class="wrap">	
	<h2><?php esc_html_e('Processing', 'classiera') ?> <?php echo $_GET['cid']; ?></h2>
	<br />
	<br/>
	<?php 
		$channelID = $_GET['cid'];
		$maxResults = $settings['byi_posts_total'];
		$count = 1;		
		if($byiChannelPlayList == 'byi_playlist'){
			$videoIDSreturn = byi_GET_PlayList_Videos_IDS($channelID, $maxResults, $nextPageToken);
		}elseif($byiChannelPlayList == 'byi_channel'){
			$videoIDSreturn = byi_GET_Channel_Videos_IDS($channelID, $maxResults, $nextPageToken);
		}
		//print_r($videoIDSreturn);
		//exit();		
		$videoIDS = $videoIDSreturn['videoIDS'];
		$totalVideoFound = $videoIDSreturn['totalVideoFound'];	
		$nextPageToken = $videoIDSreturn['nextPageToken'];
		$prevPageToken = $videoIDSreturn['prevPageToken'];		
		if(!empty($previousPosted)){
			$combineString = $videoIDS.$previousPosted;
			$str = implode(',',array_unique(explode(',', $combineString)));
			if($str == $previousPosted){
				$videoIDS = "";				
				$message =  esc_html__( 'No New Video Found Try again to fetch new videos.', 'byi' );
			}
		}
		$idCount = -1;
		$singleIDP = explode(",", $previousPosted);
		foreach($singleIDP as $IDCount){
			$idCount++;
		}
		if($idCount < $totalVideoFound){
			if(!empty($videoIDS)){
				$VideoDATA = byi_GET_Video_DATA($videoIDS);			
				$postData = byi_Prepare_Post_Data($VideoDATA, $byiAuthor, $byiCat, $poststatus);			
			}
			$posted = $previousPosted.$videoIDS;
			$channels[$channel_id]['posted'] = $posted;
			$channels[$channel_id]['nextPageToken'] = $nextPageToken;		
			$channels[$channel_id]['prevPageToken'] = $prevPageToken;		
			$channels[$channel_id]['totalVideoFound'] = $totalVideoFound;
			
		}
		update_option("byi_channels", serialize($channels));
		
?>
	<div class="wrap"><h3><?php echo $message; ?></h3></div>
</div>
<?php else : 
	
	$message =  esc_html__( 'Channel Not Found', 'byi' );
	?>
	<div class="wrap"><h3><?php echo $message; ?></h3></div>
	<?php
	endif;
?>