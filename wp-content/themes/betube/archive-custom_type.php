<?php get_header(); ?>
<?php betube_breadcrumbs();?>
<section class="category-content">
	<div class="row">
		<!-- left side content area -->
		<div class="large-8 columns">
			<section class="content content-with-sidebar">
				<div class="main-heading removeMargin">
					<div class="row secBg padding-14 removeBorderBottom">
						<div class="medium-8 small-8 columns">
							<div class="head-title">
								<i class="fa fa-user"></i>
								<h4><?php the_archive_title();?></h4>
							</div><!--head-title-->
						</div><!--medium-8-->
					</div><!--row-->
				</div><!--main-heading-->
				<div class="row secBg">
					<div class="large-12 columns">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>						
						<?php get_template_part( 'parts/loop', 'archive' ); ?>
						<?php endwhile; ?>	
						<?php joints_page_navi(); ?>
						<?php else : ?>
						<?php get_template_part( 'parts/content', 'missing' ); ?>
						<?php endif; ?>
					</div><!--large-12 columns-->
				</div><!--row secBg-->
			</section><!--content-->
			<!-- ad Section -->
			<?php 
			$betubeGoogleAds = $redux_demo['betube-google-ads-for-all-video-page'];
			if(!empty($betubeGoogleAds)){
			?>
			<div class="googleAdv">
				<?php echo $betubeGoogleAds; ?>
			</div>
			<!-- End ad Section -->
			<?php } ?>
		</div>
		<!-- left side content area -->
		<div class="large-4 columns">
			<aside class="secBg sidebar">
				<div class="row">
				<?php get_sidebar(); ?>
				</div>
			</aside>
		</div><!--large-4-->
	</div><!--row-->
</section><!--category-content-->			
<?php get_footer(); ?>