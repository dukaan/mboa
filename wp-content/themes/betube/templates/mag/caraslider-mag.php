<?php 
	global $redux_demo;
	$betubeCaraCat = $redux_demo['betube-cara-slider-category'];
	$betubeCaraCount = $redux_demo['betube-cara-slider-count'];
	$betubeIconCode = '';
	$betubeIconColor = '';
	$betubeCatIMG = '';
?>
<section class="carouselSlider__magzine">
	<div id="owl-demo-slider" class="owl-carousel carousel" data-autoplay="true" data-autoplay-timeout="3000" data-autoplay-hover="true" data-car-length="4" data-items="4" data-dots="false" data-loop="true" data-merge="true" data-auto-height="true" data-auto-width="false" data-margin="0" data-responsive-small="1" data-responsive-medium="2" data-right="<?php if(is_rtl()){ echo 'true';}else{ echo 'false';}?>">
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
		?>
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
				$thumbURL = betube_thumb_url($post->ID);
				$altTag = betube_thumb_alt($post->ID);
				?>
				<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
				<div class="item-title">
					<?php $betubepostCatgory = get_the_category( $post->ID ); ?>
					<span class="maz__category" style="background:<?php echo $betubeIconColor; ?>;">
						<?php echo $betubepostCatgory[0]->name; ?>
					</span>
					<h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
					<span class="author"><?php esc_html_e('BY', 'betube') ?>&nbsp;:&nbsp;<?php echo $authorName; ?></span>
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
</section><!--carouselSlider__magzine-->