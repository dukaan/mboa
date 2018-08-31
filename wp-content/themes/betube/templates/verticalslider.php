<?php
	global $redux_demo;
	$betubeFirstpostMedia = $redux_demo['betube-vertical-slider-thumb'];
	$betubeVerticalCat = $redux_demo['betube-vertical-slider-cat'];
	$betubeVerticalCount = $redux_demo['betube-vertical-slider-count'];
?>
<!-- verticle thumb slider -->
<section id="verticalSlider">
	<div class="row">
		<div class="large-12 columns">
			<div class="thumb-slider">
			<?php 
				global $paged, $wp_query, $wp;
				$args = wp_parse_args($wp->matched_query);
				if ( !empty ( $args['paged'] ) && 0 == $paged ) {
					$wp_query->set('paged', $args['paged']);
					$paged = $args['paged'];
				}
				$arags = array(
					'post_type' => 'post',			
					'paged' => $paged,
					'category__in' => $betubeVerticalCat,			
				);
				$wsp_query = new WP_Query($arags);
				$current = 1;
			?>
				<div class="main-image">
				<?php while ($wsp_query->have_posts()) : $wsp_query->the_post(); $current++; ?>
					<div class="image <?php echo $current; ?>">
					<?php if($betubeFirstpostMedia == 1){?>
						<?php 
							$thumbURL = betube_thumb_url($post_id);
							$altTag = betube_thumb_alt($post_id);
						?>
						<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
						<a href="<?php the_permalink(); ?>" class="hover-posts">
							<span><i class="fa fa-play"></i><?php esc_html_e( 'Watch Video', 'betube' ); ?></span>
						</a>
					<?php }else{
					$post_id = $post->ID;
					$betubeVideoURL = trim(get_post_meta($post_id, 'jtheme_video_url', true));
					$betubeVideoEmbed = trim(get_post_meta($post_id, 'jtheme_video_code', true));
					$betubeCustomVideo = trim(get_post_meta($post_id, 'jtheme_video_file', true));
					if(!empty($betubeVideoURL)){
						$betubePlayer = "link";
						$betubesource = $betubeVideoURL;
						betubeVideoFunction($betubePlayer, $betubesource, $post_id);
					}elseif(!empty($betubeVideoEmbed)){
						$betubePlayer = "embed";
						$betubesource = $betubeVideoEmbed;
						betubeVideoFunction($betubePlayer, $betubesource, $post_id);
					}elseif(!empty($betubeCustomVideo)){
						$betubePlayer = "customlink";
						$betubesource = $betubeCustomVideo;
						betubeVideoFunction($betubePlayer, $betubesource, $post_id);
					}
					?>
					<?php }?>
					</div><!--End image-->
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				</div><!--End main-image-->
				<div class="thumbs">
				<?php 
					global $paged, $wp_query, $wp;
					$args = wp_parse_args($wp->matched_query);
					if ( !empty ( $args['paged'] ) && 0 == $paged ) {
						$wp_query->set('paged', $args['paged']);
						$paged = $args['paged'];
					}
					$arags = array(
						'post_type' => 'post',			
						'paged' => $paged,
						'cat' => $betubeVerticalCat,			
					);
					$wsp_query = new WP_Query($arags);
					$current = 1;
				?>
					<div class="thumbnails">
					<?php while ($wsp_query->have_posts()) : $wsp_query->the_post(); $current++; ?>
						<div class="ver-thumbnail" id="<?php echo $current; ?>">
						<?php 
							$post_id = $post->ID;
							$thumbURL = betube_thumb_url($post_id);
							$altTag = betube_thumb_alt($post_id);
						?>
						<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
						<div class="item-title">
						<?php $betubepostCatgory = get_the_category( $post->ID ); ?>
							<span><?php echo $betubepostCatgory[0]->name; ?></span>
							<h6>
								<?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 25) ? substr($theTitle,0,25).'...' : $theTitle; echo $theTitle; ?>
							</h6>
						</div>
						</div><!--End item-title-->
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div><!--End thumbnails-->
					<a class="up" href="javascript:void(0)"><i class="fa fa-angle-up"></i></a>
                                <a class="down" href="javascript:void(0)"><i class="fa fa-angle-down"></i></a>
				</div><!--End thumbs-->
				<div class="clearfix"></div>
			</div><!--End large-12-->
		</div><!--End large-12-->
	</div><!--End Row-->
</section>
<!-- verticle thumb slider -->