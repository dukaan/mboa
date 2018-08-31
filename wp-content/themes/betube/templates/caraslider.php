<?php 
	global $redux_demo;
	$betubeCaraCat = $redux_demo['betube-cara-slider-category'];
	$betubeCaraCount = $redux_demo['betube-cara-slider-count'];
?>
<!-- caroslider -->
<section id="carouselSlider">
	<div id="owl-demo-slider" class="owl-carousel carousel" data-right="<?php if(is_rtl()){ echo 'true';}else{ echo 'false';}?>" data-autoplay="true" data-autoplay-timeout="3000" data-autoplay-hover="true" data-right-to-left="false" data-car-length="3" data-items="4" data-dots="false" data-loop="true" data-merge="true" data-auto-height="true" data-auto-width="false" data-margin="0" data-responsive-small="1" data-responsive-medium="2">
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
			'category__in' => $betubeCaraCat,
			'posts_per_page' => $betubeCaraCount,
		);
		$wsp_query = new WP_Query($arags);		
		$current = 1;
	?>
	<?php while ($wsp_query->have_posts()) : $wsp_query->the_post(); $current++; ?>
		<?php 		
			if($current==2){
				echo '<div class="item" data-merge="1">';
			}
			if($current==4){
				echo '<div class="item" data-merge="2">';
			}
		?>
		<?php 
			if($current==2 || $current==3){
				echo '<div class="inner-item">';
			}
		?>
			
				<?php 
					if($current==4){
						echo '<div class="inner-item inner-item-big">';
					}
				?>
				<?php 
				$thumbURL = betube_thumb_url($post_id);
				$altTag = betube_thumb_alt($post_id);
				?>
				<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
				<a href="<?php the_permalink(); ?>" class="hover-posts">
					<span><i class="fa fa-play"></i></span>
				</a>
				<div class="item-title">
				<?php 
					$betubepostCatgory = get_the_category( $post->ID );
				?>
					<span><?php echo $betubepostCatgory[0]->name; ?></span>
					<h6><?php echo get_the_title(); ?></h6>
				</div>
				<?php 
					if($current==4){
						echo '</div>';
					}
				
			if($current==2 || $current==3){
				echo '</div>';
			}?>
				<?php
				if($current==3){
				echo '</div>';				
				}
				if($current==4){
				echo '</div>';
				$current = 1;
				}?>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div><!--owl-demo-slider-->
</section><!--end slider-->