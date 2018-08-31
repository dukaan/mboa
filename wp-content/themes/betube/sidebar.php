<?php 
	if(is_front_page() && is_active_sidebar('main'))
			dynamic_sidebar('main');		
		elseif(function_exists('is_buddypress') && is_buddypress() && is_active_sidebar('buddypress'))
			dynamic_sidebar('buddypress');
		elseif(is_page_template('template-blog.php') && is_active_sidebar('blog'))
			dynamic_sidebar('blog');	
		elseif(function_exists('is_bbpress') && is_bbpress() && is_active_sidebar('bbpress'))
			dynamic_sidebar('bbpress');	
		elseif(is_single() && is_active_sidebar('single-video'))
			dynamic_sidebar('single-video');		
		elseif(is_category() && is_active_sidebar('category'))
			dynamic_sidebar('category');		
		else
			dynamic_sidebar('main');
?>