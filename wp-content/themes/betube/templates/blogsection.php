<?php 
	global $redux_demo;
	$betubeBlogSecOn = $redux_demo['betube_blog_section_on'];
	$betubeBlogSecTitle = $redux_demo['betube_blog_section_title'];
	$betubeBlogSecCount = $redux_demo['betube_blog_section_count'];
	$betubeBlogSecPOrder = $redux_demo['betube_blog_section_post_order'];
	$betubeBlogFullwidth = $redux_demo['betube_blog_section_fullwidth'];
?>
<section id="blog-section">
	<div class="row secBg <?php if($betubeBlogFullwidth == 1){echo "expanded" ;}?>">
		<div class="large-12 columns">
			<div class="column row">
				<div class="heading category-heading clearfix">
					<div class="cat-head pull-left">
						<i class="fa fa-bullhorn"></i>
						<h4><?php echo $betubeBlogSecTitle; ?></h4>
					</div><!--Heading-->
					<div>
						<div class="navText pull-right show-for-large">
							<a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
							<a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
						</div>
					</div><!--nav-->
				</div>
			</div><!--column row-->
			<!--Posts section-->
			<div id="owl-blog" class="owl-carousel carousel" data-autoplay="true" data-autoplay-timeout="4000" data-autoplay-hover="true" data-car-length="<?php if($betubeBlogFullwidth == 1){echo "4";}else{ echo "3";}?>" data-items="<?php if($betubeBlogFullwidth == 1){echo "4";}else{ echo "3";}?>" data-dots="false" data-loop="true" data-auto-width="false" data-margin="<?php if($betubeBlogFullwidth == 1){echo "15";}else{ echo "30";}?>" data-responsive-small="1" data-responsive-medium="2" data-responsive-large="<?php if($betubeBlogFullwidth == 1){echo "4";}else{ echo "3";}?>" data-responsive-xlarge="5" data-right="<?php if(is_rtl()){ echo 'true';}else{echo 'false';}?>">
				<?php 
					$args = array (
						'post_type' => 'blog',
						'post_status' => 'publish',
						'posts_per_page' => $betubeBlogSecCount,
						'order' => 'ASC',
						'orderby' => $betubeBlogSecPOrder,
					);
					$blogSecQuery = new WP_Query($args);
				?>
				<?php if ( $blogSecQuery->have_posts() ): ?>
				<?php while ( $blogSecQuery->have_posts() ) : $blogSecQuery->the_post(); ?>
				<!--SinglePostcolumn-->
				<div class="item-blog item thumb-border">
					<figure class="premium-img">
						<div class="blog-section-img">
							<?php 
							if( has_post_thumbnail()){
								echo get_the_post_thumbnail();
							}	
							?>							
							<a href="<?php the_permalink(); ?>" class="hover-posts">
								<span><i class="fa fa-eye"></i></span>
							</a>
						</div><!--blog-section-img-->
						<figcaption>
							<h4>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>
							<p>
							<?php $user_ID = $post->post_author; ?>
								<span>
									<i class="fa fa-user"></i>
									<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('display_name', $user_ID ); ?></a>
								</span>
								<?php $beTubedateFormat = get_option( 'date_format' );?>
								<span><i class="fa fa-clock-o"></i><?php echo get_the_date($beTubedateFormat, $post->ID); ?></span>
								<span><i class="fa fa-eye"></i><?php echo betube_get_post_views(get_the_ID()); ?></span>
							</p>
						</figcaption>
					</figure>
				</div>
				<!--SinglePostcolumn-->
				<?php endwhile; ?>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</div>
			<!--Posts section-->
		</div><!--large-12 columns-->
	</div><!--row secBg-->
</section>