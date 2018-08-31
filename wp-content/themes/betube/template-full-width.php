<?php
/*
Template Name: Full Width (No Sidebar)
*/
?>

<?php 
get_header(); 
betube_breadcrumbs();
?>
			
	<div id="content" class="pad-bottom-30">
	
		<div id="inner-content" class="row secBg">
	
		    <main id="main" class="large-12 medium-12 columns" role="main">
				
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<?php get_template_part( 'parts/loop', 'page' ); ?>
					
				<?php endwhile; endif; ?>							

			</main> <!-- end #main -->
		    
		</div> <!-- end #inner-content -->
	
	</div> <!-- end #content -->

<?php get_footer(); ?>
