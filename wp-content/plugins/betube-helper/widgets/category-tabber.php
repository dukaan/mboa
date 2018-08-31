<?php
class TWcategoryTabber extends WP_Widget {
    function TWcategoryTabber() {		
			$widget_ops = array('classname' => 'TWcategoryTabber', 'description' => 'Betube Categories Accordion');
			parent::__construct(false, 'Betube Categories Accordion ', $widget_ops);		
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
		<div class="large-12 medium-7 medium-centered columns">
			<div class="widgetBox">
				<?php if (isset($before_widget))
				echo $before_widget;
				?>
				<?php
					if ($title != '')
					echo $args['before_title'] . $title . $args['after_title']; 
				?>
				<?php 
					if(is_category()){
						$cat_id = get_queried_object_id();
					}
				?>
				<div class="widgetContent">					
						<ul class="accordion" data-accordion> 
						<?php
						$categories = get_terms(
						'category', 
						array('parent' => 0,'order'=> 'DESC','number'=>$counter, 'hide_empty' => false)	
						);
						$current = 1;
						$beTubeActiveClass = '';
						foreach ($categories as $category) {							
							$tag = $category->term_id;							
							$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
							$catName = $category->term_id;
							if(is_category()){
								if($catName == $cat_id){
									$beTubeActiveClass = 'is-active';
								}else{
									$beTubeActiveClass = '';
								}
							}else{
								if($current == 1){
									$beTubeActiveClass = 'is-active';
								}else{
									$beTubeActiveClass = '';
								}
							}
							
							
						?>
						<li class="accordion-item <?php echo $beTubeActiveClass; ?>" data-accordion-item>	
							<a href="#" class="accordion-title">								
								<span onclick="window.location.href='<?php echo get_category_link( $category->term_id )?>'">
									<?php echo $category->name ?>
								</span>
							</a>
							
							<div class="accordion-content" data-tab-content>
								<?php 
									$currentCat = 0;
									$allPosts = 0;
									$args2 = array(
									'type' => 'post',
									'child_of' => $catName,
									'parent' => get_query_var(''),
									'orderby' => 'name',
									'order' => 'ASC',
									'hide_empty' => 0,
									'hierarchical' => 1,
									'exclude' => '',
									'include' => '',
									'number' => '',
									'taxonomy' => 'category',
									'pad_counts' => true );
									$categories2 = get_categories($args2);
									foreach($categories2 as $category2) { 
										$currentCat++;
									}
									$args = array(
									'type' => 'post',
									'child_of' => $catName,
									'parent' => get_query_var(''),
									'orderby' => 'name',
									'order' => 'ASC',
									'hide_empty' => 0,
									'hierarchical' => 1,
									'exclude' => '',
									'include' => '',
									'number' => '5',
									'taxonomy' => 'category',
									'pad_counts' => true );
									$categories = get_categories($args);
								?>
								<ul>								
								<?php foreach($categories as $category) {?>
									<li class="clearfix">
									   <i class="fa fa-play-circle-o"></i>
									   <a href="<?php echo get_category_link( $category->term_id )?>">
									   <?php $categoryTitle = $category->name; $categoryTitle = (strlen($categoryTitle) > 30) ? substr($categoryTitle,0,27).'...' : $categoryTitle; echo $categoryTitle; ?>
									   <span>(<?php echo $category->count ?>)</span></a>
								   </li>
								<?php }?>
								</ul>
							</div>
						</li>
						<?php
						$current++;
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
       ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e("Title:", "betube-helper");?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>"  />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('counter'); ?>"><?php esc_html_e("Counter:", "betube-helper");?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('counter'); ?>" name="<?php echo $this->get_field_name('counter'); ?>" value="<?php echo $instance['counter']; ?>"  />
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("TWcategoryTabber");'));
 ?>