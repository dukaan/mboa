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
								<i class="fa fa-film"></i>
								<h4><?php the_archive_title();?></h4>
							</div><!--head-title-->
						</div><!--medium-8-->
					</div><!--row-->
				</div><!--main-heading-->
				<div class="row secBg">
					<div class="large-12 columns">
						<div class="row column head-text clearfix">
							<div class="grid-system pull-right show-for-large">
								<a class="secondary-button <?php if($betubeFirstSecView == "gridsmall"){echo "current";} ?> grid-default" href="#"><i class="fa fa-th"></i></a>
								<a class="secondary-button <?php if($betubeFirstSecView == "gridmedium"){echo "current";} ?> grid-medium" href="#"><i class="fa fa-th-large"></i></a>
								<a class="secondary-button <?php if($betubeFirstSecView == "listmedium"){echo "current";} ?> list" href="#"><i class="fa fa-th-list"></i></a>
							</div><!--grid-system-->
						</div>
						<div class="tabs-content" data-tabs-content="newVideos">
							<div class="tabs-panel is-active" id="new-all">
								<div class="row list-group">
									<?php if (have_posts()) : while (have_posts()) : the_post(); ?>						
									<?php get_template_part( 'parts/loop', 'archive-video' ); ?>
									<?php endwhile; ?>	
									<div class="row">
										<div class="large-12 medium-12 columns">
										<?php joints_page_navi(); ?>
										</div>
									</div>
									<?php else : ?>
									<?php get_template_part( 'parts/content', 'missing' ); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
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