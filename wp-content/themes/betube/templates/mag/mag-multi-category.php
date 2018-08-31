<?php 
	global $redux_demo;
	$betubeMagMainCat = $redux_demo['betube_mag_main_cat'];
	$betubeMagMainCatDesc = $redux_demo['betube_mag_main_cat_des'];
	$betubeMagMultiCategories = $redux_demo['betube_mag_multi_categories'];
	$betubeIconColor = '';
	function betube_mag_tabber_content($catID){
		?>
		<div class="tabs-panel tab-content" data-content="<?php echo $catID; ?>">
			<div class="tech__grid">
			<?php
			global $paged, $wp_query, $wp, $post;
			$betubeIconColor = '';
			$arags = array(
				'post_type' => 'post',
				'posts_per_page' => 5,
				'cat' => $catID,
			);
			$count = 1;
			$itemClass = '';
			$wp_query = new WP_Query($arags);
			//print_r($wp_query);
			$totalPost = $wp_query->post_count;						
			while ($wp_query->have_posts()) : $wp_query->the_post();
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
				$beTubedateFormat = get_option( 'date_format' );		
				get_template_part( 'templates/mag/mag-figure-loop' );	
			?>
			<?php $count++; ?>						
			<?php endwhile; ?>
			<?php //wp_reset_postdata(); ?>
			<?php //wp_reset_query();?>
			</div>
		</div>		
	<?php }
?>
<section class="betube_mag content borderBottom betube__multicats">
	<div class="row">
		<div class="columns">
			<div class="Media Media--reverse borderBottom main_heading">
				<div class="betube_mag__heading_right Media-figure">
					<ul class="tabs menu icon-top" data-tabs id="example-tabs">
						<li class="tabs-title is-active">
							<a href="" data-tab="<?php echo $betubeMagMainCat; ?>" aria-selected="true">
								<?php esc_html_e( 'All', 'betube' ); ?>
							</a>
						</li>
					<?php if(!empty($betubeMagMultiCategories)){?>	
					<?php 
					$count = 1;
					$displayCat = array();
					foreach($betubeMagMultiCategories as $singleMagCat){
					?>
						<li class="tabs-title is-active">
							<a href="" data-tab="<?php echo $singleMagCat; ?>" aria-selected="false">
								<?php echo get_cat_name($singleMagCat) ?>
							</a>
						</li>
					<?php
					$count++;
					$displayCat[] .= $singleMagCat;
					if($count == 5){ break;}
					}					
					$betubeMagMoreCats = array_diff($betubeMagMultiCategories, $displayCat);
					if(!empty($betubeMagMoreCats)){
						$i = 0;
					?>
						<li class="tabs-title" data-toggle="example-dropdown-1">
							<a data-tab="6" href="" aria-selected="false">
								<?php esc_html_e( 'More', 'betube' ); ?>
							</a>
							<ul class="dropdown-pane" id="example-dropdown-1" data-dropdown data-hover="true" data-hover-pane="true">
								<?php foreach($betubeMagMoreCats as $singleMoreCat){?>
								<li class="tabs-title betube_float_none">
									<a data-tab="<?php echo $singleMoreCat; ?>" href="" aria-selected="false">
										<?php echo get_cat_name($singleMoreCat) ?>
									</a>
								</li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>
					<?php } ?>
					</ul>
				</div>				
				<!--betube_mag__heading_right-->
				<div class="Media-body">
					<div class="betube_mag__heading">
						<div class="betube_mag__heading_icon" style="background: #9c27b0;">
							<i class="fa fa-cubes"></i>
						</div>
						<div class="betube_mag__heading_head">
							<h3><?php echo get_cat_name($betubeMagMainCat) ?></h3>
							<p><?php echo $betubeMagMainCatDesc; ?></p>
						</div>
					</div>
				</div><!--Media-body-->
			</div><!--Media-->
		</div><!--columns-->
	</div><!--row-->
	<div class="tabs-content">
		<div class="tabs-panel tab-content active" data-content="<?php echo $betubeMagMainCat; ?>">
			<div class="tech__grid">
				<?php 
				global $paged, $wp_query, $wp;
				$arags = array(
					'post_type' => 'post',
					'posts_per_page' => 5,
					'cat' => $betubeMagMainCat,
				);
				$count = 1;
				$itemClass = '';
				$wp_query = new WP_Query($arags);				
				$totalPost = $wp_query->post_count;						
				while ($wp_query->have_posts()) : $wp_query->the_post();
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
					$beTubedateFormat = get_option( 'date_format' );
					get_template_part( 'templates/mag/mag-figure-loop' );
					?>
				<?php $count++; ?>						
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
				<?php wp_reset_query(); ?>
			</div>
		</div><!--Tabs-panel-->
		<?php 
		if($betubeMagMultiCategories):
		foreach($betubeMagMultiCategories as $catid){			
			betube_mag_tabber_content($catid);			
		}
		endif;
		?>
	</div><!--tabs-content-->	
</section><!--betube__multicats-->