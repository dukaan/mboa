<?php 
defined('ABSPATH') or die("Not Allowed");

function byi_GET_Channel_Videos_IDS($channelID, $maxResults, $nextPageToken){
	$videoIds       = '';
	$pageToken      = $nextPageToken;
	$prevPageToken  = $_POST['prevPageToken'];
	$settings = get_option("byi_settings");
	$YouTubeAPIKey = $settings['byi_youtube_api_key'];	
	$YouTubeBaseURL = 'https://www.googleapis.com/youtube/v3/search?order=date';
	$channelID = $channelID;
	if(!empty($channelID)){
		$url = $YouTubeBaseURL.'&part=snippet&channelId='.$channelID.'&maxResults='.$maxResults.'&key='.$YouTubeAPIKey.'&type=video&pageToken='.$pageToken.'';
	}	
	$url = str_replace(' ', '', $url);
	if(!empty($url)){
		$json = file_get_contents($url);
	}	
	$video_list = json_decode($json, true);	
	//print_r($video_list);
	$totalVideo = $video_list['pageInfo']['totalResults'];
	$nextPageToken = $video_list['nextPageToken'];
	$prevPageToken = $video_list['prevPageToken'];
	if(!empty($video_list)){
		foreach ($video_list['items'] as $searchResult){
			$videoIds  .= $searchResult['id']['videoId'].',';
		}
	}
	$returnValue = array(
		'videoIDS' => $videoIds,
		'totalVideoFound' => $totalVideo,
		'nextPageToken' => $nextPageToken,
		'prevPageToken' => $prevPageToken,
	);
	
	return($returnValue);
}
function byi_GET_PlayList_Videos_IDS($playlistID, $maxResults, $nextPageToken){	
	$videoIds       = '';
	$pageToken      = $nextPageToken;
	$prevPageToken  = $_POST['prevPageToken'];
	$settings = get_option("byi_settings");
	$YouTubeAPIKey = $settings['byi_youtube_api_key'];	
	$YouTubeBaseURL = 'https://www.googleapis.com/youtube/v3/playlistItems?';	
	if(!empty($playlistID)){
		$url = $YouTubeBaseURL.'&part=snippet&playlistId='.$playlistID.'&maxResults='.$maxResults.'&key='.$YouTubeAPIKey.'&type=video&pageToken='.$pageToken.'';
	}	
	$url = str_replace(' ', '', $url);
	if(!empty($url)){
		$json = file_get_contents($url);
	}
	$video_list = json_decode($json, true);
	$totalVideo = $video_list['pageInfo']['totalResults'];
	$nextPageToken = $video_list['nextPageToken'];
	$prevPageToken = $video_list['prevPageToken'];
	if(!empty($video_list)){
		foreach ($video_list['items'] as $searchResult){
			//print_r($searchResult);
			$videoIds  .= $searchResult['snippet']['resourceId']['videoId'].',';
		}
	}
	$returnValue = array(
		'videoIDS' => $videoIds,
		'totalVideoFound' => $totalVideo,
		'nextPageToken' => $nextPageToken,
		'prevPageToken' => $prevPageToken,
	);
	return($returnValue);
	//print_r($video_list);
	//exit();
}
function byi_GET_Video_DATA($videoID){
	$settings = get_option("byi_settings");
	$YouTubeAPIKey = $settings['byi_youtube_api_key'];
	$YouTubeBaseURL = 'https://www.googleapis.com/youtube/v3/videos?id='.$videoID.'';	
	$url = $YouTubeBaseURL.'&part=snippet%2Cstatistics%2CcontentDetails&key='.$YouTubeAPIKey.'';
	$url = str_replace(' ', '', $url);
	$json = file_get_contents($url);
	$videoData = json_decode($json, true);
	foreach($videoData['items'] as $result){
		//print_r($result);
		$videoResults[$result['id']] = array(
                'title'        => $result['snippet']['title'],
                'channelId'    => $result['snippet']['channelId'],
                'categoryId'   => $result['snippet']['categoryId'],
                'channelTitle' => $result['snippet']['channelTitle'],
                'description'  => $result['snippet']['description'],
                'publishedAt'  => $result['snippet']['publishedAt'],
                'viewCount'    => $result['statistics']['viewCount'],
                'likeCount'    => $result['statistics']['likeCount'],
                'dislikeCount' => $result['statistics']['dislikeCount'],
                'duration'     => $result['contentDetails']['duration'],
                'thumbnailST'     => $result['snippet']['thumbnails']['high'],
                'thumbnailHD'     => $result['snippet']['thumbnails']['standard'],
        );
	}
	return $videoResults;	
}
?>