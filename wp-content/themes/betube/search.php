<?php 
get_header(); 
betube_breadcrumbs();
global $redux_demo;
$betubeGridView = $redux_demo['betube-main-grid-selection'];
$betubeGoogleAdsAllVideos = $redux_demo['betube-google-ads-for-all-video-page'];
$myClass = "";
	if($betubeGridView == "gridsmall"){
		$myClass = "group-item-grid-default";
	}elseif($betubeGridView == "gridmedium"){
		$myClass = "grid-medium";
	}elseif($betubeGridView == "listmedium"){
		$myClass = "list";
	}
?>
<section class="category-content">
	<div class="row">
		<!-- left side content area -->
		<div class="large-8 columns">
			<section class="content content-with-sidebar">
				<div class="main-heading removeMargin">
					<div class="row secBg padding-14 removeBorderBottom">
						<div class="medium-8 small-12 columns">
							<div class="head-title">
								<i class="fa fa-search"></i>
								<h4><?php esc_html_e( 'Search Results for:', 'betube' ); ?> <?php echo esc_attr(get_search_query()); ?></h4>
							</div><!--head-title-->
						</div><!--medium-8-->
					</div><!--row-->
				</div><!--main-heading-->
				<div class="row secBg">
					<div class="large-12 columns">
						<div class="row column head-text clearfix">
						<?php 
							$allsearch = new WP_Query("s=$s&showposts=-1");
							$allResult = $allsearch ->found_posts;						
						?>
							<p class="pull-left"><?php esc_html_e( 'Search Results', 'betube' ); ?>&nbsp;:&nbsp;<span><?php echo $allResult; ?>&nbsp;&nbsp;<?php esc_html_e( 'Result Found!', 'betube' ); ?></span></p>
							<div class="grid-system pull-right show-for-large">
								<a class="secondary-button <?php if($betubeGridView == "gridsmall"){echo "current";} ?> grid-default" href="#"><i class="fa fa-th"></i></a>
								<a class="secondary-button <?php if($betubeGridView == "gridmedium"){echo "current";} ?> grid-medium" href="#"><i class="fa fa-th-large"></i></a>
								<a class="secondary-button <?php if($betubeGridView == "listmedium"){echo "current";} ?> list" href="#"><i class="fa fa-th-list"></i></a>
							</div><!--grid-system-->
						</div><!--row column-->
						<div class="tabs-content" data-tabs-content="newVideos">
							<div class="tabs-panel is-active" id="new-all">
								<div class="row list-group">
								<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
									<div class="item large-4 medium-6 columns end <?php echo $myClass; ?>">
										<div class="post thumb-border">
											<?php if( has_post_thumbnail()){?>
											<div class="post-thumb">
												<?php 
													if( has_post_thumbnail()){
														echo get_the_post_thumbnail();
													}else{
														?>
														<img src="<?php echo get_template_directory_uri() . '/assets/images/nothumb.jpg' ?>" alt="No Thumb"/>
														<?php
													}
												?>
												<a href="<?php the_permalink(); ?>" class="hover-posts">
													<span><i class="fa fa-play"></i><?php esc_html_e( 'Watch Video', 'betube' ); ?></span>
												</a>
												<div class="video-stats clearfix">
												<?php 
													$beTubePostHD = get_post_meta($post->ID, 'post_quality', true);
													if(!empty($beTubePostHD)){
												?>
													<div class="thumb-stats pull-left">
														<h6><?php echo $beTubePostHD; ?></h6>
													</div><!--Video HD-->
													<?php }?>
													<?php
													include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
													if(is_plugin_active("betube-helper/index.php")){	
													?>
													<div class="thumb-stats pull-left">		
														<span><?php echo get_simple_likes_button( get_the_ID() ); ?></span>
													</div><!--Video Likes-->
													<?php } ?>
													<?php 
													$beTubePostTime = get_post_meta($post->ID, 'post_time', true);
													if(!empty($beTubePostTime)){
													?>
													<div class="thumb-stats pull-right">
														<span><?php echo $beTubePostTime; ?></span>
													</div><!--Video Time-->
													<?php }?>
												</div><!--video-stats-->
											</div><!--post-thumb-->
											<?php } ?>
											<div class="post-des">
												<h6>
													<a href="<?php the_permalink(); ?>">
													<?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 25) ? substr($theTitle,0,25).'...' : $theTitle; echo $theTitle; ?>
													</a>
												</h6>
												<div class="post-stats clearfix">
													<p class="pull-left">
														<i class="fa fa-user"></i>
														<?php 
														$user_ID = $post->post_author;
														?>
														<span><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('display_name', $user_ID ); ?></a></span>
													</p>
													<p class="pull-left">
														<i class="fa fa-clock-o"></i>
														<?php $beTubedateFormat = get_option( 'date_format' );?>
														<?php
														global $post;														
														$post_id = $post->ID;
														?>
														<span><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
													</p>
													<p class="pull-left">
														<i class="fa fa-eye"></i>
														<span><?php echo betube_get_post_views(get_the_ID()); ?></span>
													</p>
												</div><!--post-stats-->
												<div class="post-summary">
													<p>
														<?php echo substr(get_the_excerpt(), 0,260); ?>
													</p>
												</div><!--post-summary-->
												<div class="post-button">
													<a href="<?php the_permalink(); ?>" class="secondary-button"><i class="fa fa-play-circle"></i><?php esc_html_e( 'Watch Video', 'betube' ); ?></a>
												</div><!--post-button-->
											</div><!--post-des-->
										</div><!--post thumb-border-->
									</div><!--item large-4-->
								<?php endwhile; ?>								
								<?php else : ?>
								<div class="searchMising">
								<?php get_template_part( 'parts/content', 'missing' ); ?>
								</div>
								<?php endif; ?>
								</div><!--row list-group-->
								<?php 
								global $redux_demo;
								$beTubeScroll = $redux_demo['infinite-scroll'];
									if($beTubeScroll == 1){
										echo infinite($wp_query);
									}else{
										get_template_part('pagination');
									}
								?>
							</div><!--tabs-panelt-->
						</div><!--tabs-content-->
					</div><!--large-12-->
				</div><!--row-->
			</section><!--content content-with-sidebar-->
			<div class="googleAdv">
				<?php echo $betubeGoogleAdsAllVideos; ?>
			</div><!-- End ad Section -->
		</div><!--large8-->
		<!-- left side content area -->
		<!--sidebar-->
		<div class="large-4 columns">
			<aside class="secBg sidebar">
				<div class="row">
				<?php get_sidebar('main'); ?>
				</div>
			</aside><!--secBg sidebar-->
		</div><!--large-4-->
	</div><!--row-->
</section><!--category-content-->
<?php get_footer(); ?>