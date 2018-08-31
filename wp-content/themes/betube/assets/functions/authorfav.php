<?php
/*Start betube Favourite Function*/
function betube_authors_tbl_create() {

    global $wpdb;

    $sql2 = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_followers (

        id int(11) NOT NULL AUTO_INCREMENT,

        author_id int(11) NOT NULL,

        follower_id int(11) NOT NULL,

        PRIMARY KEY (id)

    ) ENGINE=InnoDB AUTO_INCREMENT=1;");

 $wpdb->query($sql2);

     $sql = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_favorite (

        id int(11) NOT NULL AUTO_INCREMENT,

        author_id int(11) NOT NULL,

        post_id int(11) NOT NULL,

        PRIMARY KEY (id)

    ) ENGINE=InnoDB AUTO_INCREMENT=1;");

 $wpdb->query($sql);

}

add_action( 'init', 'betube_authors_tbl_create', 1 );



function betube_authors_insert($author_id, $follower_id) {

    global $wpdb;	

	$author_insert = ("INSERT into {$wpdb->prefix}author_followers (author_id,follower_id)value('".$author_id."','".$follower_id."')");

  $wpdb->query($author_insert);

}



function betube_authors_unfollow($author_id, $follower_id) {

    global $wpdb;	

	$author_del = ("DELETE from {$wpdb->prefix}author_followers WHERE author_id = $author_id AND follower_id = $follower_id ");
	//print_r($author_del);

  $wpdb->query($author_del);

}



function betube_authors_follower_check($author_id, $follower_id) {

	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id = $follower_id AND author_id = $author_id", OBJECT );

    if(empty($results)){

		?>

		<form method="post">

			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>

			<input type="hidden" name="follower_id" value="<?php echo $follower_id; ?>"/>
			
			<button type="submit" name="follower" value="Follow"><?php esc_html_e("Subscribe", 'betube') ?></button>

		</form>

		<div class="clearfix"></div>

		<?php

	}else{

		?>

		<form method="post">

			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>

			<input type="hidden" name="follower_id" value="<?php echo $follower_id; ?>"/>
			
			<button type="submit" name="unfollow" value="Unfollow"><?php esc_html_e(" Un Subscribe", 'betube') ?></button>

		</form>

		<div class="clearfix"></div>

		<?php

	}

}
function betubeAllFollowers($author_id) {
	global $wpdb;	
	$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}author_followers WHERE author_id = $author_id", OBJECT );
	if(!empty($results)){				
		foreach ( $results as $ids ){			
			$avatar = $ids->follower_id;		
		?>
		<div class="large-2 small-6 medium-3 columns end">
			<div class="follower">
			<?php 
			$authorAvatarURL = get_user_meta($avatar, "betube_author_avatar_url", true);
			if(!empty($authorAvatarURL)){
				$authorAvatarURL = betube_get_image_url($authorAvatarURL);
				?>
				<div class="follower-img">
					<img src="<?php echo esc_url($authorAvatarURL); ?>" alt="author">
				</div>
				<?php
			}else{
				?>
				<div class="follower-img">
					<?php echo get_avatar($avatar, 70); ?>
				</div>
				<?php
			}
			?>
				<?php $user_name = get_userdata($avatar); ?>
				<?php $profileurl = get_author_posts_url($avatar);?>
				<span><a href="<?php echo $profileurl;?>"><?php echo $user_name->user_login; ?></a></span>				
				<?php $follower_id = $author_id; ?>
				<?php //betube_authors_follower_check($author_id, $follower_id); ?>
			</div>
		</div>
		<?php
		}
	}
}
function betubeAllFollowing($author_id) {
	global $wpdb;	
	$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id = $author_id", OBJECT );
	if(!empty($results)){
		foreach ( $results as $ids ){
			$avatar = $ids->author_id;
		?>
		<div class="large-2 small-6 medium-3 columns end">
			<div class="follower">
			<?php 
				$authorAvatarURL = get_user_meta($avatar, "betube_author_avatar_url", true);
				if(!empty($authorAvatarURL)){
					$authorAvatarURL = betube_get_image_url($authorAvatarURL);
					?>
					<div class="follower-img">
						<img src="<?php echo esc_url($authorAvatarURL); ?>" alt="author">
					</div>
					<?php
				}else{
					?>
					<div class="follower-img">
						<?php echo get_avatar($avatar, 70); ?>
					</div>
					<?php
				}
				?>				
				<?php $user_name = get_userdata($avatar); ?>
				<?php $profileurl = get_author_posts_url($avatar);?>
				<span><a href="<?php echo $profileurl;?>"><?php echo $user_name->user_login; ?></a></span>
				<?php $follower_id = $author_id; ?>
				<?php //betube_authors_follower_check($author_id, $follower_id); ?>
			</div>
		</div>
		<?php
		}
	}
}

function betube_favorite_insert($author_id, $post_id) {
    global $wpdb;	
	$author_insert = ("INSERT into {$wpdb->prefix}author_favorite (author_id,post_id)value('".$author_id."','".$post_id."')");
	//print_r($author_insert); exit();
	$wpdb->query($author_insert);
}



function betube_authors_unfavorite($author_id, $post_id) {
    global $wpdb;
	$author_del = ("DELETE from {$wpdb->prefix}author_favorite WHERE author_id = $author_id AND post_id = $post_id ");
	$wpdb->query($author_del);
}



function betube_authors_favorite_check($author_id, $post_id) {

	global $wpdb;	
	$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = $post_id AND author_id = $author_id", OBJECT );

    if(empty($results)){

		?>

		<form method="post" class="fav-form clearfix">

			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>

			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>		

			<input class="button" type="submit" name="favorite" value="Add to Favourite" />			

		</form>

		<?php

	}else{

		$all_fav = $wpdb->get_results("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` ='_wp_page_template' AND `meta_value` = 'template-favorite.php' ", ARRAY_A);

		$all_fav_permalink = get_permalink($all_fav[0]['post_id']);

		echo '<div class="browse-favourite"><a href="'.$all_fav_permalink.'"><i class="fa fa-heart unfavorite-i"></i> <span>Browse Favourites</span></a></div>';

	}

}

function betube_authors_favorite_remove($author_id, $post_id) {

	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = $post_id AND author_id = $author_id", OBJECT );
    if(!empty($results)){
		?>
		<form method="post" class="unfavorite">
			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>
			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
			<button type="submit" name="unfavorite" value="unfavorite"><i class="fa fa-heart-o"></i><?php esc_html_e("Unfavorite", 'betube') ?></button>			
		</form>
		<?php
	}

}

function betube_authors_all_favorite($author_id) {

	global $wpdb;	
	$prepared_statement = $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}author_favorite WHERE  author_id = $author_id", OBJECT );
	$postids = $wpdb->get_col( $prepared_statement );
	return $postids;
}
function betubeFollowerCount($author_id) {
	
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE author_id = $author_id", OBJECT );	
	$followcounter = count($results);
	return $followcounter;
}
function betubeFavoriteCount($author_id){
	
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_favorite WHERE author_id = $author_id", OBJECT );	
	$favoritecounter = count($results);
	return $favoritecounter;
}
/*End betube Favourite Function*/