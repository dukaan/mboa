<?php 
global $redux_demo;
$betubeGalleryCheck = '';
$betubeVideoCheck = '';
$betubeAudioCheck = '';
$betubeMoreNewsTitle = $redux_demo['betube_mag_more_news_title'];
$betubeMoreNewsDesc = $redux_demo['betube_mag_more_news_desc'];
$betubeMoreNewsIcon = $redux_demo['betube_mag_more_news_icon'];
$betubeMoreNewsColor = $redux_demo['betube_mag_more_news_color'];
$betubeMoreNewsCatList = $redux_demo['betube_mag_more_news_cat_list'];
$betubeMoreNewsPostType = $redux_demo['betube_mag_more_news_post_types'];
$betubeMoreNewsPostCount = $redux_demo['betube_mag_more_news_post_count'];
$betubeGalleryCheck = $betubeMoreNewsPostType['image'];
$betubeVideoCheck = $betubeMoreNewsPostType['video'];
$betubeAudioCheck = $betubeMoreNewsPostType['audio'];
?>

<section class="betube_mag content betube__morenews">
	<div class="row">
		<div class="columns">
			<div class="Media Media--reverse borderBottom main_heading">
				<div class="betube_mag__heading_right Media-figure">
					<ul class="tabs menu icon-top" data-tabs>
						<li class="tabs-title is-active">
							<a href="" data-tab="1" aria-selected="true">
								<i class="fa fa-align-left"></i><?php esc_html_e( 'All', 'betube' ); ?>
							</a>
						</li>
						<?php if($betubeAudioCheck == 1){?>
						<li class="tabs-title">
							<a data-tab="2" href="" aria-selected="false">
								<i class="fa fa-newspaper-o"></i><?php esc_html_e( 'Audio', 'betube' ); ?>
							</a>
						</li>
						<?php } ?>
						<?php if($betubeVideoCheck == 1){?>
						<li class="tabs-title">
							<a data-tab="3" href="" aria-selected="false">
								<i class="fa fa-video-camera"></i><?php esc_html_e( 'Videos', 'betube' ); ?>
							</a>
						</li>
						<?php } ?>
						<?php if($betubeGalleryCheck == 1){?>
						<li class="tabs-title">
							<a data-tab="4" href="" aria-selected="false">
								<i class="fa fa-camera-retro"></i><?php esc_html_e( 'gallery', 'betube' ); ?>
							</a>
						</li>
						<?php } ?>
					</ul>
				</div><!--betube_mag__heading_right-->
				<div class="Media-body">
					<div class="betube_mag__heading">
						<div class="betube_mag__heading_icon" style="background:<?php echo $betubeMoreNewsColor; ?>;">
							<i class="<?php echo $betubeMoreNewsIcon; ?>"></i>
						</div>
						<div class="betube_mag__heading_head">
							<h3><?php echo $betubeMoreNewsTitle; ?></h3>
							<p><?php echo $betubeMoreNewsDesc; ?></p>
						</div>
					</div>
				</div><!--Media-body-->
			</div>
		</div><!--columns-->
	</div><!--row-->
	<div class="row">
		<div class="large-12 columns">
			<div class="tabs-content">
				<!--AllNews-->
				<div class="tabs-panel tab-content active" data-content="1">
					<?php 
						global $paged, $wp_query, $wp;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $betubeMoreNewsPostCount,
						);
						$count = 1;
						$wp_query = new WP_Query($args);
						$totalPost = $wp_query->post_count;	
						while ($wp_query->have_posts()) : $wp_query->the_post();
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
					<div class="Media margin-bottom-30 media_list_large">
						<div class="Media-figure">
							<figure class="betube_mag__item margin-bottom-0">
								<div class="betube_mag__item_img margin-bottom-0 height height-250" style="width: 300px;">
									<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
									<span class="betube_mag__item_icon"><i class="<?php echo betube_post_format_display($post_ID); ?>"></i></span>
									<a href="<?php the_permalink(); ?>" class="hover-posts"></a>
								</div><!--betube_mag__item_img-->
							</figure>
						</div><!--Media-figure-->
						<div class="Media-body">							
							<span class="betube_mag__item_list_cat" style="background:<?php echo $betubeIconColor; ?>;">
								<?php echo $betubepostCatgory[0]->name; ?>
							</span>	
							<h5 class="betube_mag__item_list_heading betube_mag__item_list_heading__large">
								<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
							</h5>							
							<p class="betube_mag__item_list_description">
								<?php esc_html_e( 'BY', 'betube' ); ?> : <?php the_author_posts_link(); ?> 
								<i class="fa fa-clock-o"></i>
								<?php $beTubedateFormat = get_option( 'date_format' );?>
								<?php echo get_the_date($beTubedateFormat, $post->ID); ?>
							</p>
							<p class="description_text"><?php echo get_the_excerpt(); ?></p>
						</div><!--Media-body-->
					</div><!--Media-->
					<?php 
					endwhile;
					wp_reset_postdata();
					wp_reset_query();
					?>
				</div>
				<!--AllNews-->
				<!--AudioPosts-->
				<?php if($betubeAudioCheck == 1) :?>
				<div class="tabs-panel tab-content" data-content="2">
					<?php 
						global $paged, $wp_query, $wp;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $betubeMoreNewsPostCount,
							'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => 'post-format-audio'
								)
							)
						);
						$count = 1;
						$wp_query = new WP_Query($args);
						//print_r($wp_query);
						$totalPost = $wp_query->post_count;	
						while ($wp_query->have_posts()) : $wp_query->the_post();
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
					<div class="Media margin-bottom-30 media_list_large">
						<div class="Media-figure">
							<figure class="betube_mag__item margin-bottom-0">
								<div class="betube_mag__item_img margin-bottom-0 height height-250" style="width: 300px;">
									<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
									<span class="betube_mag__item_icon"><i class="<?php echo betube_post_format_display($post_ID); ?>"></i></span>
									<a href="<?php the_permalink(); ?>" class="hover-posts"></a>
								</div><!--betube_mag__item_img-->
							</figure>
						</div><!--Media-figure-->
						<div class="Media-body">							
							<span class="betube_mag__item_list_cat" style="background:<?php echo $betubeIconColor; ?>;">
								<?php echo $betubepostCatgory[0]->name; ?>
							</span>	
							<h5 class="betube_mag__item_list_heading betube_mag__item_list_heading__large">
								<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
							</h5>							
							<p class="betube_mag__item_list_description">
								<?php esc_html_e( 'BY', 'betube' ); ?> : <?php the_author_posts_link(); ?> 
								<i class="fa fa-clock-o"></i>
								<?php $beTubedateFormat = get_option( 'date_format' );?>
								<?php echo get_the_date($beTubedateFormat, $post->ID); ?>
							</p>
							<p class="description_text"><?php echo get_the_excerpt(); ?></p>
						</div><!--Media-body-->
					</div><!--Media-->
					<?php 
					endwhile;
					wp_reset_postdata();
					wp_reset_query();
					?>
				</div>
				<?php endif;?>
				<!--AudioPosts-->
				<!--All Video Posts-->
				<?php if($betubeVideoCheck == 1) :?>
				<div class="tabs-panel tab-content" data-content="3">
					<?php 
						global $paged, $wp_query, $wp;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $betubeMoreNewsPostCount,
							'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => 'post-format-video'
								)
							)
						);
						$count = 1;
						$wp_query = new WP_Query($args);
						$totalPost = $wp_query->post_count;	
						while ($wp_query->have_posts()) : $wp_query->the_post();
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
					<div class="Media margin-bottom-30 media_list_large">
						<div class="Media-figure">
							<figure class="betube_mag__item margin-bottom-0">
								<div class="betube_mag__item_img margin-bottom-0 height height-250" style="width: 300px;">
									<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
									<span class="betube_mag__item_icon"><i class="<?php echo betube_post_format_display($post_ID); ?>"></i></span>
									<a href="<?php the_permalink(); ?>" class="hover-posts"></a>
								</div><!--betube_mag__item_img-->
							</figure>
						</div><!--Media-figure-->
						<div class="Media-body">							
							<span class="betube_mag__item_list_cat" style="background:<?php echo $betubeIconColor; ?>;">
								<?php echo $betubepostCatgory[0]->name; ?>
							</span>	
							<h5 class="betube_mag__item_list_heading betube_mag__item_list_heading__large">
								<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
							</h5>							
							<p class="betube_mag__item_list_description">
								<?php esc_html_e( 'BY', 'betube' ); ?> : <?php the_author_posts_link(); ?> 
								<i class="fa fa-clock-o"></i>
								<?php $beTubedateFormat = get_option( 'date_format' );?>
								<?php echo get_the_date($beTubedateFormat, $post->ID); ?>
							</p>
							<p class="description_text"><?php echo get_the_excerpt(); ?></p>
						</div><!--Media-body-->
					</div><!--Media-->
					<?php 
					endwhile;
					wp_reset_postdata();
					wp_reset_query();
					?>
				</div>
				<?php endif;?>
				<!--All Video Posts-->
				<!--All Gallery Posts-->
				<?php if($betubeGalleryCheck == 1) :?>
				<div class="tabs-panel tab-content" data-content="4">
					<?php 
						global $paged, $wp_query, $wp;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $betubeMoreNewsPostCount,
							'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => 'post-format-image'
								)
							)
						);
						$count = 1;
						$wp_query = new WP_Query($args);
						$totalPost = $wp_query->post_count;	
						while ($wp_query->have_posts()) : $wp_query->the_post();
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
					<div class="Media margin-bottom-30 media_list_large">
						<div class="Media-figure">
							<figure class="betube_mag__item margin-bottom-0">
								<div class="betube_mag__item_img margin-bottom-0 height height-250" style="width: 300px;">
									<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
									<span class="betube_mag__item_icon"><i class="<?php echo betube_post_format_display($post_ID); ?>"></i></span>
									<a href="<?php the_permalink(); ?>" class="hover-posts"></a>
								</div><!--betube_mag__item_img-->
							</figure>
						</div><!--Media-figure-->
						<div class="Media-body">							
							<span class="betube_mag__item_list_cat" style="background:<?php echo $betubeIconColor; ?>;">
								<?php echo $betubepostCatgory[0]->name; ?>
							</span>	
							<h5 class="betube_mag__item_list_heading betube_mag__item_list_heading__large">
								<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
							</h5>							
							<p class="betube_mag__item_list_description">
								<?php esc_html_e( 'BY', 'betube' ); ?> : <?php the_author_posts_link(); ?> 
								<i class="fa fa-clock-o"></i>
								<?php $beTubedateFormat = get_option( 'date_format' );?>
								<?php echo get_the_date($beTubedateFormat, $post->ID); ?>
							</p>
							<p class="description_text"><?php echo get_the_excerpt(); ?></p>
						</div><!--Media-body-->
					</div><!--Media-->
					<?php 
					endwhile;
					wp_reset_postdata();
					wp_reset_query();
					?>
				</div>
				<?php endif;?>
				<!--All Gallery Posts-->
			</div><!--tabs-content-->
		</div><!--large-12-->
	</div><!--row-->
</section><!--betube__morenews-->