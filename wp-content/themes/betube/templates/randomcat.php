<!-- random-media -->
<?php 
	global $redux_demo;
	global $post;
	$betubeRandomCatTitle = $redux_demo['randomcat-title-homev5'];
	$betubeRandomCatDescription = $redux_demo['randomcat-desc-homev5'];
	$betubeRandomCategories = $redux_demo['randomcat-list-homev5'];
	$betubeRandomCatView = $redux_demo['randomcat-grid-selection'];
	$betubeRandomCatpCount = $redux_demo['randomcat-section-pcount']; 
	
?>
<section id="randomMedia">
	<div class="row">
		<div class="large-8 large-centered columns">
			<div class="open-heading text-center">
				<h3><?php echo $betubeRandomCatTitle; ?></h3>
				<p>
				<?php echo $betubeRandomCatDescription; ?>				
				</p>
			</div>
		</div>
	</div><!--End Heading Row-->
	<div class="random-media-head text-center">
		<div class="row">
			<div class="large-12 columns">
				<ul class="tabs" data-tabs id="media">
					<li class="tabs-title is-active"><a href="#all"><?php esc_html_e( 'All Videos', 'betube' ); ?></a></li>
				<?php 
					foreach ($betubeRandomCategories as $id ) {
						$categoryName = get_cat_name( $id );
						//echo $categoryName;
						?>
						<li class="tabs-title"><a href="#<?php echo $id; ?>"><?php echo $categoryName; ?></a></li>
						<?php
					}
					?>
				</ul>
			</div>
		</div>
	</div><!--End Cat Tabber-->
	<section class="content">
		<div class="row">
			<div class="large-12 columns">
				<div class="row column head-text clearfix removeBorder removePad">					
					<div class="grid-system pull-right show-for-large">
						<a class="secondary-button <?php if($betubeRandomCatView == "gridsmall"){echo "current";} ?> grid-default" href="#"><i class="fa fa-th"></i></a>
						<a class="secondary-button <?php if($betubeRandomCatView == "gridmedium"){echo "current";} ?> grid-medium" href="#"><i class="fa fa-th-large"></i></a>
						<a class="secondary-button <?php if($betubeRandomCatView == "listmedium"){echo "current";} ?> list" href="#"><i class="fa fa-th-list"></i></a>
					</div>
				</div><!--End Row-->
				<div class="tabs-content" data-tabs-content="media">
					<div class="tabs-panel is-active" id="all">
						<div class="row list-group">
							<?php 
								$myClass = "";
								if($betubeRandomCatView == "gridsmall"){
									$myClass = "group-item-grid-default";
								}elseif($betubeRandomCatView == "gridmedium"){
									$myClass = "grid-medium";
								}elseif($betubeRandomCatView == "listmedium"){
									$myClass = "list";
								}
								global $paged, $wp_query, $wp;
								$args = wp_parse_args($wp->matched_query);
								if ( !empty ( $args['paged'] ) && 0 == $paged ) {
									$wp_query->set('paged', $args['paged']);
									$paged = $args['paged'];
								}
								$arags = array(
									'post_type' => 'post',									
									'paged' => $paged,
									'posts_per_page' => -1,
								);
								$wsp_query = new WP_Query($arags);
								$current = 1;
								while ($wsp_query->have_posts()) : $wsp_query->the_post(); $current++;
							if($current-1 <= $betubeRandomCatpCount){
							?>
							<div class="item large-3 medium-6 columns end <?php echo $myClass; ?>">
								<div class="post thumb-border">
									<div class="post-thumb">
										<?php 
											$thumbURL = betube_thumb_url($post_id);
											$altTag = betube_thumb_alt($post_id);
										?>
										<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
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
											</div><!--End HD-->	
												<?php
											}
											?>
											<?php
											include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
											if(is_plugin_active("betube-helper/index.php")){	
											?>
											<div class="thumb-stats pull-left">						
												<span><?php echo get_simple_likes_button( get_the_ID() ); ?></span>
											</div><!--End Likes-->
											<?php } ?>
											<?php 
											$beTubePostTime = get_post_meta($post->ID, 'post_time', true); 
											if(!empty($beTubePostTime)){
											?>
											<div class="thumb-stats pull-right">
												<span><?php echo $beTubePostTime; ?></span>
											</div><!--End Time-->
											<?php }?>
										</div><!--End video-stats-->
									</div><!--End post-thumb-->
									<div class="post-des">
										<h6>
											<a href="<?php the_permalink(); ?>">
											<?php $theTitle = get_the_title(); $theTitle = (strlen($theTitle) > 25) ? substr($theTitle,0,25).'...' : $theTitle; echo $theTitle; ?>
											</a>
										</h6>
										<div class="post-stats clearfix">
											<p class="pull-left">
												<i class="fa fa-user"></i>
												<?php $user_ID = $post->post_author; ?>
												<span>
													<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('display_name', $user_ID ); ?></a>
												</span>
											</p><!--End Author Name-->
											<p class="pull-left">
												<i class="fa fa-clock-o"></i>
												<?php $beTubedateFormat = get_option( 'date_format' );?>
												<span><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
											</p><!--End Date-->
											<p class="pull-left">
												<i class="fa fa-eye"></i>
												<span><?php echo betube_get_post_views(get_the_ID()); ?></span>
											</p><!--End Views-->
										</div><!--End post-stats-->
										<div class="post-summary">
											<p><?php echo substr(get_the_excerpt(), 0,260); ?></p>
										</div>
										<div class="post-button">
											<a href="<?php the_permalink(); ?>" class="secondary-button"><i class="fa fa-play-circle"></i><?php esc_html_e( 'Watch Video', 'betube' ); ?></a>
										</div>
									</div><!--End post-des-->
								</div><!--End post thumb-border-->
							</div><!--End item-->
							<?php } ?>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</div><!--End list-group-->
					</div><!--End tabs-panel-->
					<?php 
					/*Start Category Content Loop*/
					foreach ($betubeRandomCategories as $id ) {
						$categoryName = get_cat_name( $id );
						$betubeCatID = $id;						 
					?>
					<div class="tabs-panel" id="<?php echo $id;?>">
						<div class="row list-group">						
						<?php //echo $betubeCatID."Shabir"; ?>
							<?php beTubeSingleItem($betubeCatID); ?>
						</div><!--End row list-group-->
						<div class="text-center row-btn">
							<a class="button radius" href="<?php echo esc_url(get_category_link( $betubeCatID )); ?>"><?php esc_html_e( 'View All Video', 'betube' ); ?></a>
						</div>
					</div><!--End tabs-panel-->
					<?php 
					/*End Category Content Loop*/
					}
					?>
				</div><!--End tabs-content-->				
			</div><!--End large-12-->
		</div><!--End Row-->
	</section><!--End content section-->
</section>
<!-- random-media -->