<?php
class betube_mag_categories extends WP_Widget {
	
	public function __construct() {
        $widget_ops = array('classname' => 'betube_mag_categories', 'description' => esc_html__( "BeTube Magzine Categories.", 'betube-helper') );
        parent::__construct('betube-mag-categories', esc_html__('BeTube Magzine Categories', 'betube-helper'), $widget_ops);
        $this->alt_option_name = 'betube_mag_categories';       
    }
	public function widget($args, $instance) {
        global $post;
		extract($instance);
		 $counter = $instance['counter'];
		 if(empty($counter)){
			 $counter = '';
		 }
		$title = apply_filters('widget_title', $instance['title']);
		
		?>
		<div class="large-12 medium-6 columns medium-centered">
			<div class="widgetbox_bemag widgetbox_bemag__category widgetBox">
				<?php if (isset($before_widget))
				echo $before_widget;
				?>
				<?php if( $title ){
					?>
					<div class="widgetbox_bemag__title">
						<h3><?php echo $title; ?></h3>
					</div>
					<?php
				}?>	
				<div class="widgetbox_bemag__content">
						<?php
						$categories = get_terms(
						'category', 
						array('parent' => 0,'order'=> 'DESC','number'=>$counter, 'hide_empty' => false)	
						);
						$current = -1;
						//print_r($categories);
						$category_icon_code = "";
						$category_icon_color = "";
						$your_image_url = "";
						foreach ($categories as $category) {							
							$tag = $category->term_id;							
							$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
											
						?>
						<a href="<?php echo get_category_link( $category->term_id )?>"><?php echo $category->name; ?> 
							<?php 
							$q = new WP_Query( array(
								'nopaging' => true,
								'tax_query' => array(
									array(
										'taxonomy' => 'category',
										'field' => 'id',
										'terms' => $tag,
										'include_children' => true,
									),
								),
								'fields' => 'ids',
							) );
							$allPosts = $q->post_count;
							?>
							<span><?php echo $allPosts ?></span>
						</a>
					<?php } ?>
		    	</div>
		    </div>
		</div>
<?php
    }

    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['counter'] = strip_tags($new_instance['counter']);
       
        return $instance;
    }

    public function form($instance) {
	extract($instance);
	$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
	$counter = isset( $instance['counter'] ) ? esc_attr( $instance['counter'] ) : '';
       ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e("Title:", "betube-helper");?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>"  />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('counter'); ?>"><?php esc_html_e("Counter:", "betube-helper");?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('counter'); ?>" name="<?php echo $this->get_field_name('counter'); ?>" value="<?php echo $counter ?>"  />
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("betube_mag_categories");'));
 ?>