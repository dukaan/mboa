<?php
/**
 * Template name: Homepage V2
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

	$page = get_page($post->ID);
	$current_page_id = $page->ID;	
	global $redux_demo;
	$moviesOnOff = $redux_demo['betube-movies-section'];
	get_template_part( 'templates/homelayerslider' );
	get_template_part( 'templates/featuredvideos' );
	get_template_part( 'templates/homecategory' );
	get_template_part( 'templates/homesections/contentv2' );
	$betubeBlogSecOn = $redux_demo['betube_blog_section_on'];
	if($betubeBlogSecOn == 1){
		get_template_part( 'templates/blogsection' );
	}
	if($moviesOnOff == 1){
		get_template_part( 'templates/movies' );
	}
?>
<?php
get_footer(); ?>