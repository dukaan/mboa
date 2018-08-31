<?php
// Register menus
register_nav_menus(
	array(
		'main-nav' => esc_html__( 'The Main Menu', 'betube' ),   // Main nav in header
		'header' => esc_html__( 'Top Bar Menu For Header V7 V8', 'betube' ), // Secondary nav in footer
		'mobile-nav' => esc_html__( 'Mobile Menu', 'betube' ) // Secondary nav in footer
	)
);
$item="";
// The Top Menu
function betube_top_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
        'menu_class' => 'vertical medium-horizontal menu',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
        'theme_location' => 'main-nav',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new betube_Topbar_Menu_Walker()
    ));
} 

// Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
class betube_Topbar_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
		//$item_output .= '<br /><span class="sub">' . $item->description . '</span>';
        $output .= "\n$indent<ul class=\"menu\">\n";
    }
}

// The Off Canvas Menu
function betube_off_canvas_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
        'menu_class' => 'vertical menu',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s vertical menu off-menu" data-responsive-menu="drilldown">%3$s</ul>',
        'theme_location' => 'mobile-nav',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new betube_Off_Canvas_Menu_Walker()
    ));
} 

class betube_Off_Canvas_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"vertical menu\">\n";
    }
}
/*Top Menu New */
function betube_header_top_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
        'menu_class' => 'menu',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s menu">%3$s</ul>',
        'theme_location' => 'header',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new betube_Top_Menu_Walker()
    ));
} 

class betube_Top_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"vertical menu\">\n";
    }
}
/*Top Menu New */
// The Top Menu
function betube_joints_footer_links() {
    wp_nav_menu(array(
    	'container' => 'false',                         // Remove nav container
    	'menu' => esc_html__( 'Top Menu', 'betube' ),   	// Nav name
		'items_wrap' => '<ul id="%1$s" class="menu">%3$s</ul>',
    	'menu_class' => 'menu',      					// Adding custom nav class
    	'theme_location' => 'header',             // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
    	'fallback_cb' => ''  							// Fallback function
	));
} /* End Footer Menu */

// Header Fallback Menu
function betube_joints_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => '',      						// Adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                           // Before each link
        'link_after' => ''                             // After each link
	) );
}

// Footer Fallback Menu
function betube_joints_footer_links_fallback() {
	/* You can put a default here if you like */
}

// Add Foundation active class to menu
function betube_required_active_nav_class( $classes, $item ) {
    if ( $item->current == 1 || $item->current_item_ancestor == true ) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'betube_required_active_nav_class', 10, 2 );