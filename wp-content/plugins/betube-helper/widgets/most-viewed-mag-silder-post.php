<?php
class Betube_MostViewed_MAG_Slider extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'Betube_MostViewed_MAG_Slider', 'description' => esc_html__( "Show Most Viewed Magzine Posts Slider.", 'betube-helper') );
        parent::__construct('betube-mostviewed-mag-slider', esc_html__('BeTube Most Viewed Magzine Posts Slider', 'betube-helper'), $widget_ops);
        $this->alt_option_name = 'Betube_MostViewed_MAG_Slider';       
    }

    public function widget($args, $instance) {
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'betube_widget_mag_mostviewed_posts_slider', 'widget' );
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

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Most Viewed Posts Slider', 'betube-helper' );

        /** This filter is documented in wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;


        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page' => $number,
            'no_found_rows' => true,
            'post_status' => 'publish',
			'meta_key' => 'wpb_post_views_count',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
            'post_type' => array('post',
            'ignore_sticky_posts' => true
        ) ) ) );
		global $post;
        if ($r->have_posts()) :		
?>
        <?php echo $args['before_widget']; ?>
        <?php if ( $title ) { ?>	
			<div class="widgetbox_bemag__title">
				<h3><?php echo $title; ?></h3>
			</div>
       <?php } ?>
		<div class="widgetbox_bemag__content">
			<div class="owl-carousel betube_mag__carousel_post" data-autoplay="true" data-autoplay-timeout="4000" data-autoplay-hover="true" data-car-length="1" data-items="1" data-dots="false" data-loop="false" data-merge="true" data-auto-height="true" data-auto-width="false" data-margin="0" data-responsive-small="1" data-responsive-medium="1" data-rewind="true" data-right="<?php if(is_rtl()){ echo 'true';}else{echo 'false';}?>">
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<?php 
				$betubepostCatgory = get_the_category( $post->ID );
				if ($betubepostCatgory[0]->category_parent == 0){
					$tag = $betubepostCatgory[0]->cat_ID;
					$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
					if (isset($tag_extra_fields[$tag])) {
						$betubeIconCode = $tag_extra_fields[$tag]['category_icon_code'];
						$betubeIconColor = $tag_extra_fields[$tag]['category_icon_color'];
						$betubeCatIMG = $tag_extra_fields[$tag]['category_image'];
					}
				}elseif($betubepostCatgory[1]->category_parent == 0){
					$tag = $betubepostCatgory[0]->category_parent;
					$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
					if (isset($tag_extra_fields[$tag])) {
						$betubeIconCode = $tag_extra_fields[$tag]['category_icon_code'];
						$betubeIconColor = $tag_extra_fields[$tag]['category_icon_color'];
						$betubeCatIMG = $tag_extra_fields[$tag]['your_image_url'];
					}
				}else{
					$tag = $betubepostCatgory[0]->category_parent;
					$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
					if (isset($tag_extra_fields[$tag])) {
						$betubeIconCode = $tag_extra_fields[$tag]['category_icon_code'];
						$betubeIconColor = $tag_extra_fields[$tag]['category_icon_color'];
						$betubeCatIMG = $tag_extra_fields[$tag]['your_image_url'];
					}
				}
				$user_ID = $post->post_author;
				$authorName = get_the_author_meta('display_name', $user_ID );
				$thumbURL = betube_thumb_url($post->ID);
				$altTag = betube_thumb_alt($post->ID);
				$post_id = $post->ID;
				?>
				<!--Singleloop-->
				<div class="item">
					<figure class="betube_mag__item">
						<div class="betube_mag__item_img height height-280">
							<img src="<?php echo $thumbURL; ?>" alt="<?php echo $altTag; ?>"/>
							<span class="betube_mag__item_icon">
								<i class="<?php echo betube_post_format_display($post_id); ?>"></i>
							</span>
						</div>
						<figcaption>
							<span class="betube_mag__item_cat" style="background:<?php echo $betubeIconColor; ?>;">
								<?php echo $betubepostCatgory[0]->name; ?>
							</span>
							<h5><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
						</figcaption>
					</figure>
				</div>
				<!--Singleloop-->
				<?php endwhile; ?>
			</div><!--betube_mag__carousel_post-->
			<div class="custom__button_carousel text-right">
				<!--custom__button_carousel_prev-->
				<?php if(is_rtl()){?>
				<a href="#" class="custom__button_carousel_next">
					<i class="fa fa-chevron-right"></i>
				</a>
				<?php }else{ ?>
				<a href="#" class="custom__button_carousel_prev">
					<i class="fa fa-chevron-left"></i>
				</a>
				<?php } ?>
				<!--custom__button_carousel_prev-->
				<span class="num_carousel_post" data-sep="<?php esc_html_e( 'of', 'betube-helper' ); ?>"></span>
				<!--custom__button_carousel_next-->
				<?php if(is_rtl()){?>
				<a href="#" class="custom__button_carousel_prev">
					<i class="fa fa-chevron-left"></i>
				</a>
				<?php }else{ ?>
				<a href="#" class="custom__button_carousel_next">
					<i class="fa fa-chevron-right"></i>
				</a>
				<?php } ?>
				<!--custom__button_carousel_next-->
			</div>
		</div><!--widgetbox_bemag__content-->
        <?php echo $args['after_widget']; ?>
<?php

        wp_reset_postdata();

        endif;

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'betube_widget_mag_mostviewed_posts_slider', $cache, 'widget' );
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
        if ( isset($alloptions['Betube_MostViewed_MAG_Slider']) )
            delete_option('Betube_MostViewed_MAG_Slider');

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
add_action('widgets_init', create_function('', 'return register_widget("Betube_MostViewed_MAG_Slider");'));