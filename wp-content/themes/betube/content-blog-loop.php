<?php 
/* 
 * used to display blog posts items in archives and listings 
 *
 * need to be called within the loop
 */
 ?>	
<div id="post-<?php the_ID(); ?>" class="blog-post">
	<div class="row secBg">
		<div class="large-12 columns">
			<div class="blog-post-heading">
				<h3>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<p>
					<?php $user_ID = $post->post_author; ?>
					<span>
						<i class="fa fa-user"></i>
						<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('display_name', $user_ID ); ?></a>
					</span>
					<?php $beTubedateFormat = get_option( 'date_format' );?>
					<span><i class="fa fa-clock-o"></i><?php echo get_the_date($beTubedateFormat, $post->ID); ?></span>
					<span><i class="fa fa-eye"></i><?php echo betube_get_post_views(get_the_ID()); ?></span>
					<span><i class="fa fa-commenting"></i><?php echo comments_number(); ?></span>
				</p>
			</div><!--blog-post-heading-->
			<div class="blog-post-content">
				<?php
				if ( has_post_thumbnail()) {
				$thumbURL = betube_thumb_url($post->ID);
				$altTag = betube_thumb_alt($post->ID);
					if(!empty($thumbURL)){
					?>
					<div class="blog-post-img">
						<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>				
					</div><!--blog-post-img-->
					<?php } ?>
				<?php } ?>				
				<p><?php echo the_excerpt(); ?></p>
				<div class="blogReadmore">
				<a class="blog-post-btn" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'betube' ); ?></a>
				</div>
			</div><!--blog-post-content-->
		</div><!--large-12-->
	</div><!--row-->
</div><!--blog-post -->