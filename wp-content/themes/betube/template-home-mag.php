<?php
/**
 * Template name: Homepage Magazine
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
	$page_slider = get_post_meta($current_page_id, 'page_slider', true);
	global $redux_demo;
	get_template_part( 'templates/homelayerslider' );
	
	/* Caraousel Slider */
	$betubeCaraouselOff = $redux_demo['betube_carousel_slider_off'];
	if($betubeCaraouselOff == 1){
		get_template_part( 'templates/mag/caraslider-mag' );
	}
	
	/* Trendy Posts */
	$betubeTrendyPostOff = $redux_demo['betube_trendy_posts_off'];
	if($betubeTrendyPostOff == 1){
		get_template_part( 'templates/mag/betube-trendy-posts' );
	}
	get_template_part( 'templates/mag/magcontent' );	
?>
<?php get_footer(); ?>