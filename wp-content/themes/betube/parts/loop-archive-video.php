<?php 
global $redux_demo;
$betubeFirstSecView = $redux_demo['landing-first-grid-selection'];
$myClass = "";
if($betubeFirstSecView == "gridsmall"){
	$myClass = "group-item-grid-default";
}elseif($betubeFirstSecView == "gridmedium"){
	$myClass = "grid-medium";
}elseif($betubeFirstSecView == "listmedium"){
	$myClass = "list";
}
?>
<div class="item large-4 medium-6 columns match-height end beetube__matchheight <?php echo $myClass; ?>" id="post-<?php the_ID(); ?>">
	<div class="post thumb-border">
	<?php if ( has_post_thumbnail()) {?>
		<div class="post-thumb">
			<?php 
				global $post;
				$post_id = $post->ID;
				$thumbURL = the_post_thumbnail();
				if(empty($thumbURL)){
					$thumbURL = betube_thumb_url($post_id);
				}
				//$thumbURL = betube_thumb_url($post_id);
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
					</div>
					<?php } ?>
					<?php
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
					if ( is_plugin_active( "betube-helper/index.php" )){	
					?>
					<div class="thumb-stats pull-left">
						<!--<i class="fa fa-heart"></i>-->
						<span><?php echo get_simple_likes_button( get_the_ID() ); ?></span>
					</div>
					<?php } ?>
					<?php 
					$beTubePostTime = get_post_meta($post->ID, 'post_time', true); 
					if(!empty($beTubePostTime)){	
					?>
					<div class="thumb-stats pull-right">
						<span><?php echo $beTubePostTime; ?></span>
					</div>
					<?php }?>
			</div><!--video-stats-->
		</div><!--post-thumb-->
	<?php } ?>
		<div class="post-des">
			<h6>
				<a href="<?php the_permalink(); ?>">
				<?php $theTitle = get_the_title(); echo $theTitle; ?>
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
					<?php $post_id = $post->ID;?>
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
</div><!--item-->