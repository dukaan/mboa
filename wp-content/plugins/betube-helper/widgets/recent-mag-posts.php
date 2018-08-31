<?php

class Betube_Recent_MAG extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'Betube_Recent_MAG', 'description' => esc_html__( "Show Latest Magzine Posts.", 'betube-helper') );
        parent::__construct('betube-recent-mag', esc_html__('BeTube Recent Magzine Posts', 'betube-helper'), $widget_ops);
        $this->alt_option_name = 'Betube_Recent_MAG';       
    }

    public function widget($args, $instance) {
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'betube_widget_mag_posts', 'widget' );
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

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'betube-helper' );

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
            'post_type'           => array('post',
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
            <?php
			echo '<div class="widgetbox_bemag__content">';
        } ?>
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
		$post_ID = $post->ID;
		?>
		<!--Singleloop-->
		<div class="Media margin-bottom-10">
			<div class="Media-figure">
				<figure class="betube_mag__item margin-bottom-0">
					<div class="betube_mag__item_img margin-bottom-0 height height-100" style="width: 100px;">
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
						<span class="betube_mag__item_icon">
							<i class="<?php echo betube_post_format_display($post_id); ?>"></i>
						</span>
						<a href="<?php the_permalink(); ?>" class="hover-posts"></a>
					</div><!--betube_mag__item_img-->
				</figure>
			</div><!--Media-figure-->
			<div class="Media-body">				
				<span class="betube_mag__item_list_cat" style="background:<?php echo $betubeIconColor; ?>;">
					<?php echo $betubepostCatgory[0]->name; ?>
				</span>
				<h5 class="betube_mag__item_list_heading">
					<a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
				</h5>				
				<p class="betube_mag__item_list_description">
					<?php esc_html_e( 'BY', 'betube' ); ?> : <?php the_author_posts_link(); ?> 
					<i class="fa fa-clock-o"></i>
					<?php $beTubedateFormat = get_option( 'date_format' );?>
					<?php echo get_the_date($beTubedateFormat, $post_ID); ?>
				</p>
			</div><!--Media-body-->
		</div>
		<!--Singleloop-->
		<?php endwhile; ?>
		<?php echo '</div>'; ?>
        <?php echo $args['after_widget']; ?>
<?php

        wp_reset_postdata();

        endif;

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'betube_widget_mag_posts', $cache, 'widget' );
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
        if ( isset($alloptions['Betube_Recent_MAG']) )
            delete_option('Betube_Recent_MAG');

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
add_action('widgets_init', create_function('', 'return register_widget("Betube_Recent_MAG");'));