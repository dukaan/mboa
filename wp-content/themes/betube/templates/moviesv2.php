<?php 
	global $redux_demo;
	$betubeMoviesCount = $redux_demo['movies-section-pcount'];
	$betubeMoviesAdsCode = $redux_demo['movies-section-ad_code'];
?>
<!-- movies -->
<section id="movies" class="whiteBg pad-bottom-30 removeMargin">
	<div class="row">
		<div class="large-12 columns">
			<div class="column row">
				<div class="heading category-heading clearfix">
					<div class="cat-head pull-left">
						<i class="fa fa-video-camera"></i>
						<h4><?php esc_html_e( 'Watch Movies', 'betube' ); ?></h4>
					</div>
					<div class="large-1 columns">
						<div class="navText pull-right show-for-large">
							<a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
							<a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
						</div>
					</div>
				</div>
			</div>
			<!-- movie carousel -->
			<div id="owl-demo-movie" class="owl-carousel carousel" data-right="<?php if(is_rtl()){ echo 'true';}else{ echo 'false';}?>" data-autoplay="true" data-autoplay-timeout="3000" data-autoplay-hover="true" data-car-length="5" data-items="6" data-dots="false" data-loop="true" data-auto-width="true" data-margin="10">
			<?php 
				global $paged, $wp_query, $wp;
				$args = wp_parse_args($wp->matched_query);
				if ( !empty ( $args['paged'] ) && 0 == $paged ) {
						$wp_query->set('paged', $args['paged']);
						$paged = $args['paged'];
					}
				$arags = array(
					'post_type' => 'movies',					
					'paged' => $paged,					
				);
				$wp_query = new WP_Query($arags);
				$current = 1;				
			?>
			<?php while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; ?>
			<?php //if($current-1 <= $betubeMoviesCount){?>
				<div class="item-movie item thumb-border">
					<figure class="premium-img">
						<?php 
						if( has_post_thumbnail()){
							$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'beetube-movies');
							$thumb_id = get_post_thumbnail_id($post->id);
							$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
						?>
						<img src="<?php echo esc_url($imageurl[0]); ?>" alt="<?php if(empty($alt)){echo "Image";}else{ echo $alt; } ; ?>"/>
						
						<?php }else{ ?>
						
						<img src="<?php echo get_template_directory_uri() . '/assets/images/watchmovies.png' ?>" alt="No Thumb"/>
						
						<?php }?>
						<a href="<?php the_permalink(); ?>" class="hover-posts">
							<span><i class="fa fa-search"></i></span>
						</a>
					</figure>
				</div><!--End Single Movie-->
			<?php //}?>	
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div><!-- end carousel -->
		</div>
		<div class="large-12 columns">
			<div class="googleAdv text-center">
				<?php echo $betubeMoviesAdsCode; ?>
			</div><!-- End ad Section -->
		</div>
	</div>
</section><!-- End movie -->