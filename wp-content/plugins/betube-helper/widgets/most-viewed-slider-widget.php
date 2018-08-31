<?php

class Betube_Mostviewed_Videos_Slider extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'Betube_Mostviewed_Videos_Slider', 'description' => __( "Show Most Viewed Video Posts Slider.", 'betube-helper') );
        parent::__construct('betube-mostviewed-videos-slider', __('Most Viewed Videos Slider', 'betube-helper'), $widget_ops);
        $this->alt_option_name = 'Betube_Mostviewed_Videos_Slider';       
    }

    public function widget($args, $instance) {
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'betube_widget_mostviewed_videos_slider', 'widget' );
        }

        if ( ! is_array( $cache ) ) {
            $cache = array();
        }

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Most Viewed Videos Slider', 'betube-helper' );

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;


        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
			'meta_key' => 'wpb_post_views_count',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
            'post_type'           => array('post',
            'ignore_sticky_posts' => true
        ) ) ) );

        if ($r->have_posts()) :
?>		
        <?php echo $args['before_widget']; ?>
		<div class="row">
			<div class="large-12 columns">
				<div class="column row">
					<div class="heading category-heading clearfix">
						<div class="cat-head pull-left">
							<h4><?php echo $title; ?></h4>
						</div><!--cat-head-->
						<div class="sidebar-video-nav">
							<div class="navText pull-right">
								<a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
								<a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
							</div>
						</div><!--sidebar-video-nav-->
					</div><!--heading-->
				</div><!--column row-->
			<!-- slide Videos-->
				<div id="owl-demo-video" class="owl-carousel carousel" data-car-length="1" data-items="1" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-right="<?php if(is_rtl()){ echo 'true';}else{echo 'false';}?>">
					<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					<div class="item item-video thumb-border">
						<figure class="premium-img">
							<?php 
							global $post;
							$post_id = $post->ID;
							$thumbURL = get_the_post_thumbnail();
							$altTag = betube_thumb_alt($post_id);
							if(empty($thumbURL)){
								$thumbURL2 = betube_thumb_url($post_id);
							?>
							<img src="<?php echo $thumbURL2; ?>" alt="<?php echo $altTag; ?>"/>
								<?php
							}else{ ?>
							<?php echo the_post_thumbnail(); ?>
							<?php } ?>
							<a href="<?php the_permalink(); ?>" class="hover-posts">
								<span><i class="fa fa-play"></i><?php esc_html_e( 'Watch Video', 'betube-helper' ); ?></span>
							</a>
						</figure>
						<div class="video-des">
							<h6><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h6>
							<div class="post-stats clearfix">
								<p class="pull-left">
									<i class="fa fa-user"></i>
									<span>
										<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('display_name'); ?></a>
									</span>
								</p>
								
								<?php if ( $show_date ) : ?>
								<p class="pull-left">
								<?php $beTubedateFormat = get_option( 'date_format' );?>
									<i class="fa fa-clock-o"></i>
									<span><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
								</p>
								<?php endif; ?>
								
								<p class="pull-left">
									<i class="fa fa-eye"></i>
									<span><?php echo betube_get_post_views(get_the_ID()); ?></span>
								</p>
							</div><!--post-stats-->
						</div><!--video-des-->
					</div><!--item item-video-->
					<?php endwhile; ?>
				</div><!-- owl-demo-video-->
			<!-- slide Videos-->			
			<?php echo '</div>'; ?>
			</div><!--EndRow-->
		<!--</div><!--EndRow-->
        <?php echo $args['after_widget']; ?>
		
<?php

        wp_reset_postdata();

        endif;

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'betube_widget_recent_videos_slider', $cache, 'widget' );
        } else {
            ob_end_flush();
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;        

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['Betube_Mostviewed_Videos_Slider']) )
            delete_option('Betube_Mostviewed_Videos_Slider');

        return $instance;
    }   

    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'betube-helper' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show:', 'betube-helper'); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php esc_html_e( 'Display post date?', 'betube-helper' ); ?></label></p>
<?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("Betube_Mostviewed_Videos_Slider");'));