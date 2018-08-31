<?php
include(BYI_ROOT . "/includes/youtube-api.php"); 
function covtime($youtube_time){
    $start = new DateTime('@0'); // Unix epoch
    $start->add(new DateInterval($youtube_time));
    return $start->format('H:i:s');
}
function replaceAll($string){
    $string = str_replace(array('[\', \']'), '', $string);
    $string = preg_replace('/\[.*\]/U', '', $string);
    $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
    $string = htmlentities($string, ENT_COMPAT, 'utf-8');
    $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
    return strtolower(trim($string, '-'));
}
function Generate_Featured_Image($image_url, $post_id, $imageName){
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $imagePath = basename($image_url);	
	$filename = $post_id.$imageName.$imagePath;
	
    if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2= set_post_thumbnail( $post_id, $attach_id );
}
function byi_Insert_Post($post, $postmeta, $thumb){	
	$postTitle = $post['post_title'];
	$imageName = replaceAll($postTitle); 
	$post_id = wp_insert_post($post);	
	Generate_Featured_Image($thumb, $post_id, $imageName);
	if(!empty($postmeta)) {
		foreach($postmeta as $k => $v){
			update_post_meta($post_id, $k , $v );
		}
	}
	return $post_id;
}
function byi_Prepare_Post_Data($VideoDATA, $byiAuthor, $byiCat, $poststatus){	
	foreach($VideoDATA as $videoID=>$video){		
		$thumb = $video['thumbnailHD']['url'];
		if(empty($thumb)){
			$thumb = $video['thumbnailST']['url'];
			$hdTag = 0;
		}else{
			$hdTag = 1;
		}
		//print_r($video); exit();
		$postTime = $video['duration'];
		$postDate = $video['publishedAt'];
		$duration = covtime($postTime);	
		$videoID = $videoID;
		$ch_videos[] = $videoID;
		$VideoURL = 'https://www.youtube.com/watch?v='.$videoID.'';		
		$post = array(
		  'post_title'    => $video['title'],
		  'post_content'  => $video['description'],
		  'post_status'   => $poststatus,
		  'post_author'   => $byiAuthor,
		  'post_category' => $byiCat,
		  'post_date' => $postDate,
		);
		$postmeta = array(			
			'jtheme_video_url' => $VideoURL,			
			'post_time' => $duration,
			'wpb_post_views_count' =>$video['viewCount'],
			'_post_like_count' =>$video['likeCount'],
			'hd_post' => $hdTag,
		);
		$postID = byi_Insert_Post($post, $postmeta, $thumb);
		if(!empty($postID)){
			echo $video['title']."&nbsp;Added<br />";
		}
		
	}
	return($ch_videos);
}
function byi_Prepare_Post_Data_Shedule($VideoDATA, $byiAuthor, $byiCat, $poststatus){
		
	foreach($VideoDATA as $videoID=>$video){		
		$thumb = $video['thumbnailHD']['url'];
		if(empty($thumb)){
			$thumb = $video['thumbnailST']['url'];
			$hdTag = 0;
		}else{
			$hdTag = 1;
		}
		$postTime = $video['duration'];
		$postDate = $video['publishedAt'];
		$duration = covtime($postTime);	
		$videoID = $videoID;
		$VideoURL = 'https://www.youtube.com/watch?v='.$videoID.'';		
		$post = array(
		  'post_title'    => $video['title'],
		  'post_content'  => $video['description'],
		  'post_status'   => $poststatus,
		  'post_author'   => $byiAuthor,
		  'post_category' => $byiCat,
		  'post_date' => $postDate,
		);
		$postmeta = array(			
			'jtheme_video_url' => $VideoURL,			
			'post_time' => $duration,
			'wpb_post_views_count' =>$video['viewCount'],
			'_post_like_count' =>$video['likeCount'],
			'hd_post' => $hdTag,
		);
		$postID = byi_Insert_Post($post, $postmeta, $thumb);		
	}
}

?>