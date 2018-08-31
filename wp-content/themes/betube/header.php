<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0
 */

?>
<!doctype html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<?php 	
	global $redux_demo; 	
	$betubeFavicon = $redux_demo['betube-favicon']['url'];
	$betubeThemeColor = $redux_demo['betube-color-title'];
	$beTubeFacebookTags = $redux_demo['betube-facebook-meta-on'];
	$beTubeLoaderOn = $redux_demo['betube-loader-on'];
	$beTubeBoxedWide = $redux_demo['betube_boxed'];
?>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		
		<!-- Force IE to use the latest rendering engine available -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- Mobile Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">			
		
		<meta name="theme-color" content="<?php echo $betubeThemeColor; ?>">		
		
		<!-- If Site Icon isn't set in customizer -->
		<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
			<!-- Icons & Favicons -->			
			<?php if(empty($betubeFavicon)){?>
			<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
			<?php }else{?>			
			<link rel="icon" href="<?php echo esc_url($betubeFavicon); ?>">
			<?php }?>
			<link href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-touch.png" rel="apple-touch-icon" />
			<!--[if IE]>
				<link rel="shortcut icon" href="<?php echo esc_url($betubeFavicon); ?>">
			<![endif]-->
			<meta name="msapplication-TileColor" content="<?php echo $betubeThemeColor; ?>">
			<meta name="msapplication-TileImage" content="<?php echo esc_url($betubeFavicon); ?>">
	    	<meta name="theme-color" content="<?php echo $betubeThemeColor; ?>">
	    <?php } ?>

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<?php 
		if($beTubeFacebookTags == 1){
			echo betube_facebook_tags();
		}else{
			if(is_single()){
				$ID = $wp_query->post->ID;
				$feat_image = wp_get_attachment_url( get_post_thumbnail_id($ID) );
				?>
				<meta property="og:image" content="<?php echo esc_url( $feat_image ); ?>"/>
				<?php
			}
		}
		
		?>		
	<?php wp_head(); ?>
	
	</head>
	
	<?php 
	$page = get_page($post->ID);
	$pageID = $page->ID;
	if($pageID == 290){
		$beTubeBoxedWide = 'boxed';
	}
	?>
	<!-- Uncomment this line if using the Off-Canvas Menu --> 
	<body <?php body_class(); if($beTubeBoxedWide == 'boxed'){echo 'id="boxed"';}?> >
		<!--betubeLoader-->
		<?php if($beTubeLoaderOn == 1){?>
		<div id="betubeloader-container">
		  <div id="betubeloader-animation">&nbsp;</div>
		</div>
		<?php } ?>
		<!--betubeLoader-->
		<div class="off-canvas-wrapper">
			<div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
				
				<?php get_template_part( 'parts/content', 'offcanvas' ); ?>
				
				<div class="off-canvas-content" data-off-canvas-content>
					
					<header class="header" role="banner">
							
						 <!-- This navs will be applied to the topbar, above all content 
							  To see additional nav styles, visit the /parts directory -->
						 <?php get_template_part( 'parts/nav', 'offcanvas-topbar' ); ?>
		 	
					</header> <!-- end .header -->