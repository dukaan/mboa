<?php 
global $redux_demo;
$betubeGalleryCheck = '';
$betubeVideoCheck = '';
$betubeAudioCheck = '';
$betubeAllPosts = $redux_demo['all-video-page-link'];
$betubeMagRecPostTitle = $redux_demo['betube_mag_recent_posts'];
$betubeMagRecPostDesc = $redux_demo['betube_mag_recent_posts_desc'];
$betubeMagRecPostIcon = $redux_demo['betube_mag_recent_posts_icon'];
$betubeMagRecPostCount = $redux_demo['betube_mag_recent_posts_count'];
$betubeMagRecPostColor = $redux_demo['betube_mag_recent_posts_color'];
$betubeMagRecPostCatsList = $redux_demo['betube_mag_recent_posts_cat_list'];
$betubeMagRecPostTypes = $redux_demo['betube_mag_recent_posts_type'];
$betubeGalleryCheck = $betubeMagRecPostTypes['image'];
$betubeVideoCheck = $betubeMagRecPostTypes['video'];
$betubeAudioCheck = $betubeMagRecPostTypes['audio'];
?>
<section class="betube_mag content betube__recent">
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
						<div class="betube_mag__heading_icon" style="background:<?php echo $betubeMagRecPostColor; ?>;">
							<i class="<?php echo $betubeMagRecPostIcon; ?>"></i>
						</div>
						<div class="betube_mag__heading_head">
							<h3><?php echo $betubeMagRecPostTitle; ?></h3>
							<p><?php echo $betubeMagRecPostDesc; ?></p>
						</div>
					</div><!--betube_mag__heading-->
				</div><!--Media-body-->
			</div><!--main_heading-->
		</div><!--columns-->
	</div><!--main row-->
	<div class="row">
		<div class="columns">
			<div class="tabs-content">
				<div class="tabs-panel tab-content active" data-content="1">
					<!--owl-carousel-->
					<div class="owl-carousel betube_mag__carousel_post_recent" data-autoplay="true" data-autoplay-timeout="4000" data-autoplay-hover="true" data-car-length="1" data-items="1" data-dots="false" data-loop="false" data-merge="true" data-auto-height="true" data-auto-width="false" data-margin="0" data-responsive-small="1" data-responsive-medium="1" data-rewind="true" data-right="<?php if(is_rtl()){ echo 'true';}else{echo 'false';}?>">
						<?php 
						global $paged, $wp_query, $wp;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $betubeMagRecPostCount,
							'cat' => $betubeMagRecPostCatsList,
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
							
							if($count == 1){
								echo '<div class="item grid">';							
							}							
							get_template_part( 'templates/mag/mag-figure-loop' );
							if($totalPost > 5 || $totalPost == 5){
								if($count == 5){
									echo '</div><!--endItem-->';
									$totalPost = $totalPost - $count;
									$count = 0;									
								}
							}elseif($totalPost < 5){
								if($totalPost == $count){
									echo '</div><!--endItem-->';								
									$count = -1;
								}
							}
						$count++;
						endwhile;
						wp_reset_postdata();
						wp_reset_query();
						?>
					</div>
					<!--owl-carousel end-->
					<!--carousel button-->
					<div class="custom__button_carousel text-right">
						<!--Pre btn-->
						<?php if(is_rtl()){?>
						<a href="#" class="custom__button_carousel_next">
							<i class="fa fa-chevron-right"></i>
						</a>
						<?php }else{ ?>
						<a href="#" class="custom__button_carousel_prev">
							<i class="fa fa-chevron-left"></i>
						</a>
						<?php } ?>
						<!--Pre btn-->
						<span class="num_carousel_post" data-sep="<?php esc_html_e( 'of', 'betube' ); ?>"></span>
						<!--Next btn-->
						<?php if(is_rtl()){?>
						<a href="#" class="custom__button_carousel_prev">
							<i class="fa fa-chevron-left"></i>
						</a>
						<?php }else{?>
						<a href="#" class="custom__button_carousel_next">
							<i class="fa fa-chevron-right"></i>
						</a>
						<?php } ?>
						<!--Next btn-->
						<a href="<?php echo $betubeAllPosts; ?>" class="betube_mag__view_all"><?php esc_html_e( 'View All', 'betube' ); ?></a>
					</div>
					<!--carousel button-->
				</div><!--tabs-panel 1 for recent posts-->
				<?php if($betubeAudioCheck == 1){?>
				<div class="tabs-panel tab-content" data-content="2">
					<!--owl-carousel-->
					<div class="owl-carousel betube_mag__carousel_post_recent" data-autoplay="true" data-autoplay-timeout="4000" data-autoplay-hover="true" data-car-length="1" data-items="1" data-dots="false" data-loop="false" data-merge="true" data-auto-height="true" data-auto-width="false" data-margin="0" data-responsive-small="1" data-responsive-medium="1" data-rewind="true" data-right="<?php if(is_rtl()){ echo 'true';}else{echo 'false';}?>">
						<?php 
						global $paged, $wp_query, $wp;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $betubeMagRecPostCount,
							'cat' => $betubeMagRecPostCatsList,
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
							
							if($count == 1){
								echo '<div class="item grid">';							
							}							
							get_template_part( 'templates/mag/mag-figure-loop' );
							if($totalPost > 5 || $totalPost == 5){
								if($count == 5){
									echo '</div><!--endItem-->';
									$totalPost = $totalPost - $count;
									$count = 0;									
								}
							}elseif($totalPost < 5){
								if($totalPost == $count){
									echo '</div><!--endItem-->';								
									$count = -1;
								}
							}
						$count++;
						endwhile;
						wp_reset_postdata();
						wp_reset_query();
						?>
					</div>
					<!--owl-carousel end-->
					<!--carousel button-->
					<div class="custom__button_carousel text-right">
						<!--Pre btn-->
						<?php if(is_rtl()){?>
						<a href="#" class="custom__button_carousel_next">
							<i class="fa fa-chevron-right"></i>
						</a>
						<?php }else{ ?>
						<a href="#" class="custom__button_carousel_prev">
							<i class="fa fa-chevron-left"></i>
						</a>
						<?php } ?>
						<!--Pre btn-->
						<span class="num_carousel_post" data-sep="<?php esc_html_e( 'of', 'betube' ); ?>"></span>
						<!--Next btn-->
						<?php if(is_rtl()){?>
						<a href="#" class="custom__button_carousel_prev">
							<i class="fa fa-chevron-left"></i>
						</a>
						<?php }else{?>
						<a href="#" class="custom__button_carousel_next">
							<i class="fa fa-chevron-right"></i>
						</a>
						<?php } ?>
						<!--Next btn-->
						<a href="<?php echo $betubeAllPosts; ?>" class="betube_mag__view_all"><?php esc_html_e( 'View All', 'betube' ); ?></a>
					</div>
					<!--carousel button-->
				</div><!--tabs-panel 2 for Audio recent posts-->
				<?php } ?>
				<?php if($betubeVideoCheck == 1){?>
				<div class="tabs-panel tab-content" data-content="3">
					<!--owl-carousel-->
					<div class="owl-carousel betube_mag__carousel_post_recent" data-autoplay="true" data-autoplay-timeout="4000" data-autoplay-hover="true" data-car-length="1" data-items="1" data-dots="false" data-loop="false" data-merge="true" data-auto-height="true" data-auto-width="false" data-margin="0" data-responsive-small="1" data-responsive-medium="1" data-rewind="true" data-right="<?php if(is_rtl()){ echo 'true';}else{echo 'false';}?>">
						<?php 
						global $paged, $wp_query, $wp;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $betubeMagRecPostCount,
							'cat' => $betubeMagRecPostCatsList,
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
							
							if($count == 1){
								echo '<div class="item grid">';							
							}							
							get_template_part( 'templates/mag/mag-figure-loop' );
							if($totalPost > 5 || $totalPost == 5){
								if($count == 5){
									echo '</div><!--endItem-->';
									$totalPost = $totalPost - $count;
									$count = 0;									
								}
							}elseif($totalPost < 5){
								if($totalPost == $count){
									echo '</div><!--endItem-->';								
									$count = -1;
								}
							}
						$count++;
						endwhile;
						wp_reset_postdata();
						wp_reset_query();
						?>
					</div>
					<!--owl-carousel end-->
					<!--carousel button-->
					<div class="custom__button_carousel text-right">
						<!--Pre btn-->
						<?php if(is_rtl()){?>
						<a href="#" class="custom__button_carousel_next">
							<i class="fa fa-chevron-right"></i>
						</a>
						<?php }else{ ?>
						<a href="#" class="custom__button_carousel_prev">
							<i class="fa fa-chevron-left"></i>
						</a>
						<?php } ?>
						<!--Pre btn-->
						<span class="num_carousel_post" data-sep="<?php esc_html_e( 'of', 'betube' ); ?>"></span>
						<!--Next btn-->
						<?php if(is_rtl()){?>
						<a href="#" class="custom__button_carousel_prev">
							<i class="fa fa-chevron-left"></i>
						</a>
						<?php }else{?>
						<a href="#" class="custom__button_carousel_next">
							<i class="fa fa-chevron-right"></i>
						</a>
						<?php } ?>
						<!--Next btn-->
						<a href="<?php echo $betubeAllPosts; ?>" class="betube_mag__view_all"><?php esc_html_e( 'View All', 'betube' ); ?></a>
					</div>
					<!--carousel button-->
				</div><!--tabs-panel 3 for Video recent posts-->
				<?php } ?>
				<?php if($betubeGalleryCheck == 1){ ?>
				<div class="tabs-panel tab-content" data-content="4">
					<!--owl-carousel-->
					<div class="owl-carousel betube_mag__carousel_post_recent" data-autoplay="true" data-autoplay-timeout="4000" data-autoplay-hover="true" data-car-length="1" data-items="1" data-dots="false" data-loop="false" data-merge="true" data-auto-height="true" data-auto-width="false" data-margin="0" data-responsive-small="1" data-responsive-medium="1" data-rewind="true" data-right="<?php if(is_rtl()){ echo 'true';}else{echo 'false';}?>">
						<?php 
						global $paged, $wp_query, $wp;
						$args = array(
							'post_type' => 'post',
							'posts_per_page' => $betubeMagRecPostCount,
							'cat' => $betubeMagRecPostCatsList,
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
							
							if($count == 1){
								echo '<div class="item grid">';							
							}							
							get_template_part( 'templates/mag/mag-figure-loop' );
							if($totalPost > 5 || $totalPost == 5){
								if($count == 5){
									echo '</div><!--endItem-->';
									$totalPost = $totalPost - $count;
									$count = 0;									
								}
							}elseif($totalPost < 5){
								if($totalPost == $count){
									echo '</div><!--endItem-->';								
									$count = -1;
								}
							}
						$count++;
						endwhile;
						wp_reset_postdata();
						wp_reset_query();
						?>
					</div>
					<!--owl-carousel end-->
					<!--carousel button-->
					<div class="custom__button_carousel text-right">
						<!--Pre btn-->
						<?php if(is_rtl()){?>
						<a href="#" class="custom__button_carousel_next">
							<i class="fa fa-chevron-right"></i>
						</a>
						<?php }else{ ?>
						<a href="#" class="custom__button_carousel_prev">
							<i class="fa fa-chevron-left"></i>
						</a>
						<?php } ?>
						<!--Pre btn-->
						<span class="num_carousel_post" data-sep="<?php esc_html_e( 'of', 'betube' ); ?>"></span>
						<!--Next btn-->
						<?php if(is_rtl()){?>
						<a href="#" class="custom__button_carousel_prev">
							<i class="fa fa-chevron-left"></i>
						</a>
						<?php }else{?>
						<a href="#" class="custom__button_carousel_next">
							<i class="fa fa-chevron-right"></i>
						</a>
						<?php } ?>
						<!--Next btn-->
						<a href="<?php echo $betubeAllPosts; ?>" class="betube_mag__view_all"><?php esc_html_e( 'View All', 'betube' ); ?></a>
					</div>
					<!--carousel button-->
				</div><!--tabs-panel 4 for gallery recent posts-->	
				<?php } ?>
			</div><!--tabs-content-->
		</div><!--columns-->
	</div><!--main row content-->
</section><!--betube__recent-->