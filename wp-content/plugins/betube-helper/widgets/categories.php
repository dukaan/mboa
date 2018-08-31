<?php
class TWcategoryWidget extends WP_Widget {
    function TWcategoryWidget() {		
			$widget_ops = array('classname' => 'TWcategoryWidget', 'description' => 'betube Categories.');
			parent::__construct(false, 'betube Categories ', $widget_ops);		
    }
    function widget($args, $instance) {
        global $post;
		extract($instance);
		 $counter = $instance['counter'];
		 if(empty($counter)){
			 $counter = '';
		 }
		$title = apply_filters('widget_title', $instance['title']);
		
				?>
		<div class="large-12 medium-6 columns medium-centered">
			<div class="widgetBox">
				<?php if (isset($before_widget))
				echo $before_widget;
				?>
				<?php
					if ($title != '')
					echo $args['before_title'] . $title . $args['after_title']; 
				?>	
				<div class="widgetContent clearfix">					
						<ul> 
						<?php
						$categories = get_terms(
						'category', 
						array('parent' => 0,'order'=> 'DESC','number'=>$counter)	
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
						<li class="cat-item">
	
							<a href="<?php echo get_category_link( $category->term_id )?>" title="View posts in <?php echo $category->name?>">
								
							<?php echo $category->name ?>
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
								(<?php echo $allPosts ?>)
							</a>									
						  			

						</li>
								<?php
							}
						?>
						</ul>					
		    	</div><!-- End widgetContent -->

		    </div>
		</div>
				<?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['counter'] = strip_tags($new_instance['counter']);
       
        return $instance;
    }

    function form($instance) {
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
            <input class="widefat" id="<?php echo $this->get_field_id('counter'); ?>" name="<?php echo $this->get_field_name('counter'); ?>" value="<?php echo $counter; ?>"  />
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("TWcategoryWidget");'));
 ?>