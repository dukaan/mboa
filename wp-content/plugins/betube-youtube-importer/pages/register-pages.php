<?php
add_action( 'admin_menu', 'register_betubeYI_pages' );
function register_betubeYI_pages(){
	$icon_url= 'dashicons-video-alt3';
	$position = null;
	add_menu_page( "beTube YouTube Importer", "BYI Importer", "manage_options", "BYI_posting", "BYI_settings_view", $icon_url, $position );
	add_submenu_page( "BYI_posting", "YouTube Channels", "Channels/Playlist",  "manage_options", "byi_channels", "BYI_channels_view" );
	add_submenu_page( null, "YouTube Process", "Process",  "manage_options", "BYI_process", "BYI_process_view" ); 	
}
function BYI_settings_view(){
	include(BYI_ROOT . "/pages/settings.php");
}

function  BYI_channels_view(){
	include(BYI_ROOT . "/pages/channels.php");
}
function  BYI_process_view() {
	include(BYI_ROOT . "/pages/process.php");
}