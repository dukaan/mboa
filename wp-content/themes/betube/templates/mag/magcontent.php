<?php 
global $redux_demo;
$beTubeMagLayout = $redux_demo['betube_mag_layout_manager']['enabled'];
?>
<main>
	<div class="row">
		<div class="large-8 columns">
		<?php 
		if ($beTubeMagLayout):
			foreach ($beTubeMagLayout as $key=>$value) {		 
				switch($key) {
					
					case 'featuredmag': get_template_part( 'templates/mag/mag-featured' );
					break;
			 
					case 'multicatsmag': get_template_part( 'templates/mag/mag-multi-category' );
					break;				 
					
					case 'watchnewsmag': get_template_part( 'templates/mag/mag-watch-news' );    
					break;  
					
					case 'favoritecatsmag': get_template_part( 'templates/mag/mag-favorite-cats' );
					break;
					
					case 'recentmag': get_template_part( 'templates/mag/mag-recent-posts' );    
					break; 
					
					case 'morenewsmag': get_template_part( 'templates/mag/mag-more-news' );    
					break; 
				}			 
			}		 
		endif;
		?>			
		</div><!--large-8-->
		<div class="large-4 columns">
			<aside class="sidebar betube_mag_sidebar">
				<div class="row">
					<?php dynamic_sidebar('betube_magzine'); ?>
				</div>
			</aside>
		</div>
	</div><!--row-->
</main>