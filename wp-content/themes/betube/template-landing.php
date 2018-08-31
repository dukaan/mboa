<?php
/**
 * Template name: Landing Page
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0
 */
get_header(); ?>

<?php 
	global $redux_demo;
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true);	
	$beTubeLandingPageLayout = $redux_demo['betube-landing-layout']['enabled'];
	
?>
<?php
if ($beTubeLandingPageLayout):
	foreach ($beTubeLandingPageLayout as $key=>$value) {
 
			switch($key) {
		 
					case 'layerslider': get_template_part( 'templates/homelayerslider' );
					break;
			 
					case 'verticalslider': get_template_part( 'templates/verticalslider' );
					break;	
			 
					case 'caraslider': get_template_part( 'templates/caraslider' );    
					break;  
					
					case 'featuredvideos': get_template_part( 'templates/featuredvideos' );
					break;
					
					case 'homecategory': get_template_part( 'templates/homecategory' );    
					break; 
					
					case 'maincontent': get_template_part( 'templates/homesections/contentv1' );    
					break; 
					
					case 'maincontent2': get_template_part( 'templates/homesections/contentv2' );    
					break;
					
					case 'maincontent3': get_template_part( 'templates/homesections/contentv3' );    
					break;
					
					case 'maincontent4': get_template_part( 'templates/homesections/contentv4' );    
					break;
					
					case 'randomcat': get_template_part( 'templates/randomcat' );    
					break;	
					
					case 'movies': get_template_part( 'templates/movies' );    
					break;
					
					case 'moviesv2': get_template_part( 'templates/moviesv2' );    
					break;
					
					case 'blogsection': get_template_part( 'templates/blogsection' );    
					break;
					
					case 'htmlsection': get_template_part( 'templates/contentsection' );    
					break;
				}			 
			}		 
	endif;
get_footer(); ?>