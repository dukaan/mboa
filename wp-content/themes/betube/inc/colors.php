<?php 
function wpcrown_wpcss_loaded() {

	// Return the lowest priority number from all the functions that hook into wp_head
	global $wp_filter;
	$lowest_priority = max(array_keys($wp_filter['wp_head']));	
 
	add_action('wp_head', 'wpcrown_wpcss_head', $lowest_priority + 1);
 
	$arr = $wp_filter['wp_head'];

}
add_action('wp_head', "wpcrown_wpcss_head");

function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        return implode(",", $rgb); // returns the rgb values separated by commas
        //return $rgb; // returns an array with the rgb values
    }
 
// wp_head callback functions
function wpcrown_wpcss_head() {

	global $redux_demo; 
	global $BigSlidefMedia;
	$betubePrimaryColor = $redux_demo['betube-primary-color'];	
	$betubeSecondaryColor = $redux_demo['betube-secondary-color'];
	$betubeBreadcrumbBG = $redux_demo['betube-breadcrumb-bg'];
	$betubeBreadcrumbTXT = $redux_demo['betube-breadcrumb-txt-color'];
	$betubeSideBarColor = $redux_demo['betube-sidebar-color'];
	$betubeBodyColor = $redux_demo['betube_body_color'];
	
	$betubeVerticalSlider = $redux_demo['betube-vertical-slider-bg'];
	
	$betubeFooterBG = $redux_demo['betube-footer-bg-color'];
	$betubeFooterHeading = $redux_demo['betube-footer-heading-color'];
	$betubeFooterText = $redux_demo['betube-footer-text-color'];
	$betubeFooterTagBG = $redux_demo['betube-footer-tag-bg'];
	$betubeFooterBottomBG = $redux_demo['betube-footer-bottom-bg'];
	
	$body_color = $redux_demo['body-font']['color'];	
	$betubeMainLOGO = $redux_demo['betube-logo']['url'];
	$first_post_media = $BigSlidefMedia;
	/*LoaderImage and Background image*/
	$betubeLoaderIMG = $redux_demo['betube-loader-img']['url'];
	$betubeLoaderBG = $redux_demo['betube-loader-bg'];

	echo "<style type=\"text/css\">";
	
	?>
	<?php
	// Main Color
	if(!empty($betubePrimaryColor)) {
		echo ".top-button .menu li:nth-of-type(2) a.loginReg, .blog-post .blog-post-content a.blog-post-btn:hover, #navBar .top-bar .search-btn li.betubeSearch i:hover, .button:hover, .button:focus, .top-button .menu li a:hover, .topBar .socialLinks a:hover, .secondary-button:hover, .content .head-text .grid-system a.current, .content .main-heading .tabs li.tabs-title:last-of-type a:hover, footer #back-to-top:hover, .sidebar .widgetBox .tagcloud a:hover, footer .widgetBox .tagcloud a:hover, #carouselSlider .item .inner-item .item-title span, .inner-video .tabs .tabs-title > a:focus, .tabs-title > a[aria-selected='true'], .thumbs .thumbnails .ver-thumbnail .item-title span, .sidebar .widgetBox .widgetContent .profile-overview li a.active, .sidebar .widgetBox .widgetContent .profile-overview li a:hover, .profile-inner .profile-videos .profile-video .media-object .video-btns a.video-btn:hover, .singlePostDescription .description .inner-btn:hover, .followers .follower button:hover, .sidebar .widgetBox .widgetContent .accordion .accordion-item.is-active .accordion-title, .pagination span.current, .pagination a:hover, .topProfile .main-text h1, .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span, .singlePostDescription .description a[rel='tag']:hover, .topProfile .profile-stats .profile-author-img .btn-upload:hover span, .topProfile-inner .upload-bg label:hover span, .topProfile .profile-stats .profile-subscribe button:hover, #navBar .top-bar .search-btn li.upl-btn a:hover, .top-button .menu li a.active, .SinglePostStats .media-object .social-share .post-like-btn form button:hover, .SinglePostStats .media-object .author-des .subscribe button:hover, .tabs-title > a:hover, .light-off-menu .responsive-search .input-group-button button:hover, #back-to-top:hover, #navBar .navFull .topbar-light-dark .menu > li:not(.menu-text) > a:hover, #navBar .middleNav .search-btns li.upl-btn a:hover, #navBar .middleNav .search-btns li.login a:hover, #navBar .middleNav .search-btns li.betubeSearch i:hover, .light-off-menu .off-social a:hover, #navBar .navFull .topbar-light-dark li.active a, #navBar .navFull-v2 .top-bar-light .search-btn li.search-active i, .pagination > .page-numbers.current, .pagination > li.current{ background: ";
		echo $betubePrimaryColor;
		echo " !important; } ";
		
		echo ".blog-post .blog-post-heading p span a:hover, .blog-post .blog-post-heading h3 a:hover, .category-heading .cat-head i, .content .main-heading .head-title i, .profile-inner .heading i, .topProfile .profile-stats .profile-author-stats ul li div.li-text p.number-text, .content .head-text h4 i, input[type='radio']:checked + .customLabel::before, #navBar .top-bar li.active a i, #navBar .top-bar .menu > li:not(.menu-text) > a:hover i, #navBar .top-bar .dropdown.menu .submenu li a:hover i, #breadcrumb .breadcrumbs li i, #breadcrumb .breadcrumbs li a:hover, .sidebar .widgetBox .widgetContent .twitter-carousel .twitter-item i, .sidebar .widgetBox .widgetContent .twitter-carousel .twitter-item span a, .sidebar .widgetBox .widgetContent .accordion .accordion-content ul li i, #footer-bottom .btm-footer-text p a, .singlePostDescription .description ul li a, a.liked, .light-off-menu .menu .active > a i, .topBar .topBarMenu .menu li a:hover, .topBar .topBarMenu .menu li a:hover i, #navBar .navBlack .topbar-light-dark .dropdown.menu .submenu li a:hover i, #navBar .navFull .topbar-light-dark .topnews .newsTicker i, #navBar .navFull .topbar-light-dark .topnews .newsTicker #newsBar li a:hover, #navBar .topbar-full .topnews .newsTicker #newsBar li a:hover, #navBar .topbar-dark .topnews .newsTicker i{ color: ";
		echo $betubePrimaryColor;
		echo " !important; } ";
			
		echo ".profile-inner .profile-videos .profile-video .media-object .video-btns a.video-btn:hover, .pagination span.current, .pagination a:hover, #navBar .top-bar .search-btn li.upl-btn a:hover, .SinglePostStats .media-object .social-share .post-like-btn form button:hover, .SinglePostStats .media-object .author-des .subscribe button:hover, #navBar .middleNav .search-btns li.upl-btn a:hover, #navBar .middleNav .search-btns li.login a:hover, .pagination > .page-numbers.current{ border-color:";
		echo $betubePrimaryColor;
		echo " !important; } ";
		
		echo ".top-button .menu li.dropdown-login .login-form{ border-color:";
		echo $betubePrimaryColor. '#ececec #ececec';
		echo " !important; } ";
		
		echo "#navBar .navFull-v2 .top-bar-light .search-btn li.betubeSearch i:hover{ border-color:";
		echo $betubePrimaryColor;
		echo " !important; } ";
		
		/*Border bottom Color With Primary Color*/
		echo "#navBar .top-bar li.active a, #navBar .top-bar .menu > li:not(.menu-text) > a:hover, #randomMedia .random-media-head .tabs li.is-active a, #randomMedia .random-media-head .tabs li a:hover{ border-bottom: 2px solid ";
		echo $betubePrimaryColor;
		echo " !important; } ";
		
		/*Border bottom Color With Primary Color*/
		echo ".sidebar .widgetBox .widgetContent .profile-overview a.button:hover, .profile-settings .setting-form .setting-form-inner .button:hover, .submit-post button[type='submit']:hover{ border-bottom: 3px solid ";
		echo $betubePrimaryColor;
		echo " !important; } ";
		
		/*Border Top Color With Primary Color*/
		echo "#navBar .top-bar .dropdown.menu .submenu{ border-top: 2px solid ";
		echo $betubePrimaryColor;
		echo " !important; } ";
		
		/*Primary Color without Important*/
		echo "a:hover, a{ color: ";
		echo $betubePrimaryColor;
		echo "; } ";
		
		/*Primary Color for menu*/
		echo ".light-off-menu .off-menu-close{ background-color: ";
		echo $betubePrimaryColor;
		echo " !important; } ";
		
	
	}
	
	// Secondary Color
	if(!empty($betubeSecondaryColor)) {
		
		/*Background-color In Secondary Color*/
		echo ".button, .top-button .menu li a{ background-color: ";
		echo $betubeSecondaryColor;
		echo " !important; } ";
		
		/*Color In Secondary Color*/
		echo ".blog-post .blog-post-heading h3 a, h1, h2, h3, h4, h5, h6, .sidebar .widgetBox .widgetContent .video-box .video-box-content h6 a, .sidebar .widgetBox .widgetContent .media-object .media-object-section .media-content h6 a, .SinglePostStats .media-object .author-des .post-title h4, .SinglePostStats .media-object .author-img-sec p a, .profile-inner .profile-videos .profile-video .media-object .video-content h5 a{ color: ";
		echo $betubeSecondaryColor;
		echo "; } ";
	
	}
	// Breadcrumb BG Color
	if(!empty($betubeBreadcrumbBG)) {
		echo "#breadcrumb{ background: ";
		echo $betubeBreadcrumbBG;
		echo "; } ";
	
	}
	//Bodybackground//
	if(!empty($betubeBodyColor)) {
		echo ".off-canvas-content{ background: ";
		echo $betubeBodyColor;
		echo " !important; } ";
	}
	
	// Breadcrumb text Color
	if(!empty($betubeBreadcrumbTXT)) {
		echo "#breadcrumb .breadcrumbs li a, #breadcrumb .breadcrumbs li, ul.breadcrumbs{ color: ";
		echo $betubeBreadcrumbTXT;
		echo " !important; } ";
	
	}
	// Vertical Slider Background
	if(!empty($betubeVerticalSlider)) {
		echo "#verticalSlider{ background: ";
		echo $betubeVerticalSlider;
		echo " !important; } ";
	
	}
	
	// Sidebar BG Color
	if(!empty($betubeSideBarColor)) {
		echo ".sidebar .sidebarBg{ background: ";
		echo $betubeSideBarColor;
		echo " !important; } ";
	
	}
	
	// Footer Colors
	if(!empty($betubeFooterBG)) {
		echo "footer{ background: ";
		echo $betubeFooterBG;
		echo " !important; } ";
	
	}
	if(!empty($betubeFooterHeading)) {
		echo "footer .widgetBox .widgetTitle h5{ color: ";
		echo $betubeFooterHeading;
		echo " !important; } ";
	
	}
	if(!empty($betubeFooterText)) {
		echo "footer .widgetBox .textwidget, footer .widgetBox .tagcloud a, footer .widgetBox ul li a, footer .widgetBox .widgetContent .media-object .media-object-section .media-content h6 a, footer .widgetBox .widgetContent .media-object .media-object-section .media-content p span, #footer-bottom .btm-footer-text p, footer .widgetBox .item.twitter-item i, footer .widgetBox .item.twitter-item span, footer .widgetBox .textwidget p{ color: ";
		echo $betubeFooterText;
		echo " !important; } ";
	
	}
	if(!empty($betubeFooterTagBG)) {
		echo "footer .widgetBox .tagcloud a{ background: ";
		echo $betubeFooterTagBG;
		echo " !important; } ";
	
	}
	if(!empty($betubeFooterBottomBG)) {
		echo "#footer-bottom{ background: ";
		echo $betubeFooterBottomBG;
		echo " !important; } ";
	
	}
	// Footer Colors End
	
	if($first_post_media == 'video'){
		echo ".sliderMain .mainSide .thumb .iframe{height:595px !important}";
	}
	//Loader style
	if(!empty($betubeLoaderIMG)) {
		echo "#betubeloader-animation{ background-image:url($betubeLoaderIMG)";
		//echo $betubeLoaderIMG;
		echo " !important; } ";
	
	}
	if(!empty($betubeLoaderBG)) {
		echo "#betubeloader-container{ background-color: ";
		echo $betubeLoaderBG;
		echo " !important; } ";
	
	}
	//Loader style
	/*Boxed Layout*/
	?>
	body#boxed{
		<?php if($redux_demo['betube_boxed_bg_section']){ ?>
		background-color:<?php echo $redux_demo['betube_boxed_bg_section']['background-color']; ?> !important;
		background-image:url("<?php echo $redux_demo['betube_boxed_bg_section']['background-image']; ?>");
		background-repeat:<?php echo $redux_demo['betube_boxed_bg_section']['background-repeat']; ?>;
		background-position:<?php echo $redux_demo['betube_boxed_bg_section']['background-position']; ?>;
		background-size:<?php echo $redux_demo['betube_boxed_bg_section']['background-size']; ?>;
		background-attachment:<?php $redux_demo['betube_boxed_bg_section']['background-attachment']; ?>;
		<?php } ?>
	}
	<?php
	/*Boxed Layout*/

	echo "</style>";

}