<?php 
global $redux_demo;
$betubeAllCatURL = $redux_demo['all-cat-page-link'];
$beeCatThumb = "";
?>
<section id="category" class="removeMargin whiteBg">
	<div class="row">
		<div class="large-12 columns">
			<div class="column row">
				<div class="heading category-heading clearfix">
					<div class="cat-head pull-left">
						<i class="fa fa-folder-open"></i>
						<h4><?php esc_html_e( 'Browse Videos By Category', 'betube' ); ?></h4>
					</div>
					<div>
						<div class="navText pull-right show-for-large">
							<a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
							<a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
						</div>
					</div>
				</div>
			</div>
			<!-- category carousel -->			
			<div id="owl-demo-cat" class="owl-carousel carousel" data-right="<?php if(is_rtl()){ echo 'true';}else{ echo 'false';}?>" data-car-length="6" data-items="6" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-auto-width="true" data-margin="10" data-dots="false" data-responsive-small="2" data-responsive-medium="4" data-responsive-xlarge="6">
			<?php 
			$argsmaino = array(	
				'order' => 'DESC',
				'hide_empty'               => 1,
				'number'                   => '8',
				'taxonomy'                 => 'category',
				'pad_counts'               => false
				);
			$categories = get_categories($argsmaino);
			$currentCat = 0;
			foreach ($categories as $category) {
				if ($category->category_parent == 0) {
					$currentCat++;
				}
			}
			$argsmain = array(
					'order'                    => 'DESC',
					'hide_empty'               => 1,						
					'number'                   => '8',
					'taxonomy'                 => 'category',
					'pad_counts'               => false 
				);
			$cat_counter = $redux_demo['home-cat-counter'];
			$categories = get_terms(
				'category', 
				array('hide_empty' => 0,'parent' => 0,'number' => $cat_counter,'order'=> 'ASC')	
					);
				$current = -1;
			foreach ($categories as $category) {
				$tag = $category->term_id;
				$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
				if (isset($tag_extra_fields[$tag])) {
					$beeCatThumb = $tag_extra_fields[$tag]['your_image_url'];					
				}
			$cat = $category->count;
			$catName = $category->term_id;
			$mainID = $catName;
			$current++;
			$allPosts = 0;
			$categories = get_categories('child_of='.$catName);
			foreach ($categories as $category) {
				$allPosts += $category->category_count;
			}
			?>
				<div class="item-cat item thumb-border">
					<figure class="premium-img">
						<?php if(!empty($beeCatThumb)){?>
						<img src="<?php echo esc_url($beeCatThumb); ?>" alt="<?php echo get_cat_name( $catName ); ?>">
						<?php } ?>
						<a href="<?php echo get_category_link( $catName ); ?>" class="hover-posts">
							<span><i class="fa fa-search"></i></span>
						</a>
					</figure>
					<h6><a href="<?php echo get_category_link( $catName ); ?>"><?php echo get_cat_name( $catName ); ?></a></h6>
				</div><!-- End Single Category Div -->
			<?php } /*End For Each */?>
			</div><!-- end carousel -->
			<div class="row collapse">
				<div class="large-12 columns text-center row-btn">
					
				</div>
			</div>
		</div>
	</div>
</section><!-- End Category -->