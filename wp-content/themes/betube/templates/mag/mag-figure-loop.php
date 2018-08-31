<?php 
$betubeIconColor = '';
$betubepostCatgory = get_the_category( $post->ID );
if ($betubepostCatgory[0]->category_parent == 0){
	$tag = $betubepostCatgory[0]->cat_ID;
	$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
	if (isset($tag_extra_fields[$tag])) {
		$betubeIconCode = $tag_extra_fields[$tag]['category_icon_code'];
		$betubeIconColor = $tag_extra_fields[$tag]['category_icon_color'];
		$betubeCatIMG = $tag_extra_fields[$tag]['category_image'];
	}
}elseif($betubepostCatgory[1]->category_parent == 0){
	$tag = $betubepostCatgory[0]->category_parent;
	$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
	if (isset($tag_extra_fields[$tag])) {
		$betubeIconCode = $tag_extra_fields[$tag]['category_icon_code'];
		$betubeIconColor = $tag_extra_fields[$tag]['category_icon_color'];
		$betubeCatIMG = $tag_extra_fields[$tag]['your_image_url'];
	}
}else{
	$tag = $betubepostCatgory[0]->category_parent;
	$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
	if (isset($tag_extra_fields[$tag])) {
		$betubeIconCode = $tag_extra_fields[$tag]['category_icon_code'];
		$betubeIconColor = $tag_extra_fields[$tag]['category_icon_color'];
		$betubeCatIMG = $tag_extra_fields[$tag]['your_image_url'];
	}
}
$user_ID = $post->post_author;
$authorName = get_the_author_meta('display_name', $user_ID );
$thumbURL = betube_thumb_url($post->ID);
$altTag = betube_thumb_alt($post->ID);
$post_ID = $post->ID;
?>
<figure class="betube_mag__item">
	<div class="betube_mag__item_img">
		<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
		<span class="betube_mag__item_cat" style="background:<?php echo $betubeIconColor; ?>;">
			<?php echo $betubepostCatgory[0]->name; ?>
		</span>
		<span class="betube_mag__item_icon"><i class="<?php echo betube_post_format_display($post_ID); ?>"></i></span>
		<a href="<?php the_permalink(); ?>" class="hover-posts"></a>
	</div>
	<figcaption>
		<span class="betube_mag__item_cat" style="background:<?php echo $betubeIconColor; ?>;">
			<?php echo $betubepostCatgory[0]->name; ?>
		</span>
		<h5><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
		<p>
			<?php esc_html_e( 'BY', 'betube' ); ?> : <?php the_author_posts_link(); ?> 
			<i class="fa fa-clock-o"></i>
			<?php $beTubedateFormat = get_option( 'date_format' );?>
			<?php echo get_the_date($beTubedateFormat, $post_ID); ?>
		</p>
		<p class="description_text">
			<?php echo get_the_excerpt(); ?>				
		</p>
	</figcaption>
</figure>