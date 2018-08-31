<?php
/**
 * Template name: All Categories
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0.8
 */


?>

<?php 
get_header();
betube_breadcrumbs();
$page = get_page($post->ID);
$current_page_id = $page->ID;
global $redux_demo;
$betubeFeaturedSlider = $redux_demo['featured-slider-on'];
?>
<?php 
	if($betubeFeaturedSlider == 1){	
		get_template_part( 'templates/featuredvideos' );
	}
?>
<section class="category-content">
	<div class="row">
		<!-- left side content area -->
		<div class="large-8 columns">
			<section class="content content-with-sidebar">
				<!--Title area-->
				<div class="main-heading removeMargin">
					<div class="row secBg padding-14 removeBorderBottom">
						<div class="medium-8 small-8 columns">
							<div class="head-title">
								<i class="fa fa-film"></i>
								<h4><?php esc_html_e('All Categories', 'betube') ?></h4>
							</div>
						</div>
					</div>
				</div>
				<!--Title area-->
				<div class="row main-cat secBg row small-up-1 medium-up-2 large-up-3" data-equalizer data-equalize-by-row="true">
					<?php 
						$argsmaino = array(	
							'order' => 'DESC',
							'hide_empty'               => 0,			
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
					?>
					<?php 						
						$categories = get_terms('category', array(
							'hide_empty' => 0,
							'parent' => 0,
							'order'=> 'ASC'
						));
						$current = -1;
					foreach ($categories as $category){ 
						$tag = $category->term_id;
						$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
						if (isset($tag_extra_fields[$tag])) {
							$beeCatThumb = $tag_extra_fields[$tag]['your_image_url'];
						}
						$categoryCount = $category->count;						
						$catName = $category->term_id;
						?>
						<!--CategoryBox-->
						<div class="column item-col">
							<div class="item-cat item thumb-border">
								<figure class="premium-img">
									<?php if(!empty($beeCatThumb)){?>
									<img src="<?php echo $beeCatThumb; ?>" alt="<?php echo get_cat_name($catName);?>">
									<?php }?>
									<a href="<?php echo get_category_link($catName);?>" class="hover-posts">
										<span><?php esc_html_e('View All Videos', 'betube') ?></span>
									</a>
								</figure>
								<h5>
									<a href="<?php echo get_category_link($catName);?>"><?php echo get_cat_name($catName);?></a>
								</h5>
								<p><?php echo $categoryCount; ?>&nbsp;<?php esc_html_e('Videos posted', 'betube') ?></p>
							</div>
						</div>
						<!--CategoryBox-->
						<?php
					}
					?>
				</div>
			</section>
			<!-- ad Section -->
			<?php 
				global $redux_demo;
				$beTubeCatAds = $redux_demo['betube-google-ads-for-category-page'];
			?>
			<div class="googleAdv">
				<?php echo $beTubeCatAds; ?>
			</div><!-- End ad Section -->
			<!-- ad Section -->
		</div>
		<!-- left side content area -->
		<!-- sidebar -->
		<div class="large-4 columns">
			<aside class="secBg sidebar">
				<div class="row">
					<?php get_sidebar('main'); ?>
				</div>
			<aside>
		</div>
		<!-- sidebar -->
	</div><!--row-->
</section><!--category-content-->
<?php get_footer(); ?>