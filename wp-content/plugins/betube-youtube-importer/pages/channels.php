<?php 
defined('ABSPATH') or die("Not Allowed");

if(isset($_POST['byi_add_channel'])) {
	if(!empty($_POST['byi_channel_id']) && !empty($_POST['byi_channel_name'])){
		$channel_id = $_POST['byi_channel_id'];
		$channels = get_option("byi_channels");
		$channels = (!empty($channels)) ? unserialize($channels) : array();
		$channels[$channel_id] = array('name' => $_POST['byi_channel_name'],  'cats' => $_POST['categories'], 'author' => $_POST['author'], 'last_updated' => '', 'byi_input_type_id' => $_POST['byi_input_type_id'] );
		update_option("byi_channels", serialize($channels));
	}
}

if(isset($_GET['action']) && $_GET['action'] == "delete"){	
	if(!empty($_GET['cid'])){
		$channel_id = $_GET['cid'];		
		$channels = get_option("byi_channels");
		$channels = (!empty($channels)) ? unserialize($channels) : array();
		unset($channels[$channel_id]);
		update_option("byi_channels", serialize($channels));
	}
}
if(isset($_GET['action']) && $_GET['action'] == "reset"){
	if(!empty($_GET['cid'])){
		$channel_id = $_GET['cid'];
		$channels = get_option("byi_channels");
		$channels = (!empty($channels)) ? unserialize($channels) : array();
		$channels[$channel_id]['posted'] = '';
		$channels[$channel_id]['nextPageToken'] = '';		
		$channels[$channel_id]['prevPageToken'] = '';		
		$channels[$channel_id]['totalVideosFound'] = '';
		update_option("byi_channels", serialize($channels));
	}
}

if(isset($_GET['action']) && $_GET['action'] == "add") {
	include(BYI_ROOT . "/pages/add_channel.php");
}else{
	include(BYI_ROOT . "/pages/view_channels.php");
}
	

?>