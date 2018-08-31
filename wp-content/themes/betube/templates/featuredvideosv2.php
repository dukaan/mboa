<?php
global $redux_demo;
$betubeFcatON = $redux_demo['featured-caton'];
$betubeFcat = $redux_demo['featured-cat'];
$betubeFcatCount = $redux_demo['featured-counter'];
?>
<section id="premium" class="premium-v4">	
	<div id="owl-demo" class="owl-carousel carousel" data-right="<?php if(is_rtl()){ echo 'true';}else{echo 'false';}?>" data-car-length="4" data-items="4" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-responsive-small="1" data-responsive-medium="2" data-responsive-xlarge="5">
	<?php 
		global $paged, $wp_query, $wp;
		$args = wp_parse_args($wp->matched_query);
		if($betubeFcatON == 1){
			$arags = array(
					'post_type' => 'post',
					'posts_per_page' => $betubeFcatCount,
					'category__in' => $betubeFcat,
				);
		}else{
			$arags = array(
					'post_type' => 'post',
					'posts_per_page' => $betubeFcatCount,
					'meta_query' => array(
					array(
						'key' => 'featured_post',
						'value' => '1',
						'compare' => '=='
						)
					),
				);
		}
		$wp_query = new WP_Query($arags);		
		while ($wp_query->have_posts()) : $wp_query->the_post();
			$beTubeFeaturedPost = get_post_meta( $post->ID, 'featured_post', true );			
			if($betubeFcatON == 0 && $beTubeFeaturedPost == 1){
	?>
			<div class="item">
				<figure class="premium-img">			
				<?php 
					global $post;
					$post_id = $post->ID;
					$thumbURL = betube_thumb_url($post_id);
					$altTag = betube_thumb_alt($post_id);
				?>
				<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
					<figcaption>
					<?php				
					$betubepostCatgory = get_the_category( $post->ID );
					?>
						<h5>
						<?php $betubePostTitle = get_the_title(); echo $betubePostTitle; ?>
						</h5>
						<p><?php echo $betubepostCatgory[0]->name; ?></p>
					</figcaption>
				</figure>
				<a href="<?php the_permalink(); ?>" class="hover-posts">
					<span><i class="fa fa-play"></i><?php esc_html_e( 'watch video', 'betube' ); ?></span>
				</a>
			</div> <!--End item-->
			<?php }elseif($betubeFcatON == 1){?>			
			<div class="item">
				<figure class="premium-img">			
				<?php 
					global $post;
					$post_id = $post->ID;
					$thumbURL = the_post_thumbnail();
					if(empty($thumbURL)){
						$thumbURL = betube_thumb_url($post_id);
					}
					//$thumbURL = betube_thumb_url($post_id);
					$altTag = betube_thumb_alt($post_id);
				?>
				<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
					<figcaption>
					<?php				
					$betubepostCatgory = get_the_category( $post->ID );
					?>
						<h5>
						<?php $betubePostTitle = get_the_title(); echo $betubePostTitle; ?>
						</h5>
						<p><?php echo $betubepostCatgory[0]->name; ?></p>
					</figcaption>
				</figure>
				<a href="<?php the_permalink(); ?>" class="hover-posts">
					<span><i class="fa fa-play"></i><?php esc_html_e( 'watch video', 'betube' ); ?></span>
				</a>
			</div> <!--End item-->
			<?php }?>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
		<?php wp_reset_query(); ?>
    </div><!--End owl-demo-->
</section><!--End Featured Section-->