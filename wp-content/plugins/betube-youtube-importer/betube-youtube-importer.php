<?php 
/*
Plugin Name: BeTube YouTube Importer
Plugin URI: http://www.joinwebs.com
Description: BeTube YouTube Importer Plugin will automatically imports YouTube videos from any YouTube channel, creates posts for them and publishes them or creates a post draft according to your settings.
Version: 1.0.2
Author: JoinWebs
Author URI: http://www.joinwebs.com
*/
?>
<?php 
define ('BYI_URI',plugins_url('',__FILE__));
define ('BYI_ROOT',__DIR__);

include(BYI_ROOT . "/includes/functions.php");
include(BYI_ROOT . "/pages/register-pages.php");
//Auto Import Functions//
function byi_textdomain(){ 
	load_plugin_textdomain( 'byi', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'byi_textdomain' );

function byi_cron_schedules($schedules){
    
	if(!isset($schedules["5min"])){
        $schedules["30min"] = array(
            'interval' => 5*60,
            'display' => __('Once every 5 minutes'));
    }
    if(!isset($schedules["30min"])){
        $schedules["30min"] = array(
            'interval' => 30*60,
            'display' => __('Once every 30 minutes'));
    }	
	if(!isset($schedules["hourly"])){
        $schedules["hourly"] = array(
            'interval' => 60*60,
            'display' => __('Once every 60 minutes'));
    }
	if(!isset($schedules["daily"])){
        $schedules["daily"] = array(
            'interval' => 1440*60,
            'display' => __('Once every day'));
    }
    return $schedules;
}
add_filter('cron_schedules','byi_cron_schedules');
//Cron Functions from Youtube Importer.
register_activation_hook( __FILE__, 'byi_activation' );
function byi_activation(){
	$settings = get_option("byi_settings");
	$byiInterval = $settings['byi_cron_interval'];	
	if (! wp_next_scheduled ( 'byi_hourly_event_hook' )) {
		wp_schedule_event( time(), $byiInterval, 'byi_hourly_event_hook' );	
    }		
}
add_action( 'byi_hourly_event_hook', 'byi_hourly_schedule' );

function byi_hourly_schedule(){	
	ini_set('max_execution_time', 10000000);
	set_time_limit (-1);
	$settings = get_option("byi_settings");	
	$byiInterval = $settings['byi_cron_interval'];
	if($byiInterval == '5min'){
		$myInterval = '5';
	}elseif($byiInterval == '30min'){
		$myInterval = '30';
	}elseif($byiInterval == 'hourly'){
		$myInterval = '60';
	}elseif($byiInterval == 'daily'){
		$myInterval = '1440';
	}	
	$last_cron = get_option('byi_last_cron');	
	$maxResults = $settings['byi_posts_total'];
	$status = $settings['byi_auto_publish'];
	if($status == 1){
		$poststatus = 'publish';
	}else{
		$poststatus = 'draft';
	}
	if((intval($last_cron)+(intval($myInterval)*60)) > time())
		return;
	update_option('byi_last_cron',time());
	$channels = get_option("byi_channels");
	$channels = (!empty($channels)) ? unserialize($channels) : array();
	//print_r($channels);
	if(!empty($channels)){
		foreach($channels as $channel_id => $channel){			
			//print_r($channel);
			$ch_videos = (!empty($channel['posted'])) ? $channel['posted'] : array();
			$byiAuthor = $channel['author'];
			$byiCat = $channel['cats'];
			$previousPosted = $channel['posted'];
			$nextPageToken = $channel['nextPageToken'];
			$prevPageToken = $channel['prevPageToken'];
			$perPostTotalCount = $channel['totalVideoFound'];			
			$channelID = $channel_id;
			$byiChannelPlayList = $channels[$channel_id]['byi_input_type_id'];
			if($byiChannelPlayList == 'byi_playlist'){
				$videoIDSreturn = byi_GET_PlayList_Videos_IDS($channelID, $maxResults, $nextPageToken);
			}elseif($byiChannelPlayList == 'byi_channel'){
				$videoIDSreturn = byi_GET_Channel_Videos_IDS($channelID, $maxResults, $nextPageToken);
			}			
			$videoIDS = $videoIDSreturn['videoIDS'];
			$totalVideoFound = $videoIDSreturn['totalVideoFound'];
			$nextPageToken = $videoIDSreturn['nextPageToken'];
			$prevPageToken = $videoIDSreturn['prevPageToken'];
			if(!empty($previousPosted)){
				$combineString = $videoIDS.$previousPosted;				
				$str = implode(',',array_unique(explode(',', $combineString)));
				if($str == $previousPosted){
					$videoIDS = "";
					//return;
				}else{
					$videoIDS = $videoIDS;
				}				
			}
			$idCount = -1;
			$singleIDP = explode(",", $previousPosted);
			foreach($singleIDP as $IDCount){
				$idCount++;
			}
			if($idCount < $totalVideoFound){				
				if(empty($videoIDS)){
					//return;
				}elseif(!empty($videoIDS)){					
					$VideoDATA = byi_GET_Video_DATA($videoIDS);										
					$postData = byi_Prepare_Post_Data_Shedule($VideoDATA, $byiAuthor, $byiCat, $poststatus);
				}
				$posted = $previousPosted.$videoIDS;
				$channels[$channel_id]['nextPageToken'] = $nextPageToken;			
				$channels[$channel_id]['prevPageToken'] = $prevPageToken;			
				$channels[$channel_id]['totalVideoFound'] = $totalVideoFound;			
				$channels[$channel_id]['posted'] = $posted;
			}
		
		}
		update_option("byi_channels", serialize($channels));
	}
	
}
function byi_init_hook(){
	byi_hourly_schedule();
}
add_action('init', 'byi_init_hook');
register_deactivation_hook( __FILE__, 'byi_deactivation' );
function byi_deactivation(){
	wp_clear_scheduled_hook( 'byi_hourly_event_hook' );
}
?>