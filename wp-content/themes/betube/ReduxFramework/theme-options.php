<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "redux_demo";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
	if ( file_exists( get_template_directory() . '/info-html.html' ) ) {    
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( get_template_directory() . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'beTube Options', 'betube' ),
        'page_title'           => __( 'beTube Options', 'betube' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-video-alt3',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => true,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    $args['admin_bar_links'][] = array(
        'id'    => 'betube-docs',
        'href'  => 'http://beetube.me/docs',
        'title' => __( 'Documentation', 'betube' ),
    );

    $args['admin_bar_links'][] = array(
        'id'    => 'betube-support',
        'href'  => 'https://joinwebs.com/support',
        'title' => __( 'Support', 'betube' ),
    );
    

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'http://themeforest.net/user/joinwebs',
        'title' => 'Visit us on Themeforest',
        'icon'  => 'el el-tumblr',
        //'img' => ReduxFramework::$_url . 'assets/img/envato.png'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/joinwebs',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/joinwebs',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/company/joinwebs',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( '<p>Thanks for purchase our theme, If you need help regarding theme options please contact on support.</p>', 'betube' ), $v );
    } else {
        $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'betube' );
    }

    // Add content after the form.
    $args['footer_text'] = __( '<p></p>', 'betube' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Video tutorial', 'betube' ),
            'content' => __( '<p>For Video tutorial please visit <a href="https://www.youtube.com/user/JoinWebs/playlists">https://www.youtube.com/user/JoinWebs/playlists</a></p>', 'betube' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Documentation', 'betube' ),
            'content' => __( '<p>For Documentation please visit <a href="http://beetube.me/docs/">betube docs</a></p>', 'betube' )
        )
    );
    //Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'betube' );
    //Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */
	 
	// -> General Settings
    Redux::setSection( $opt_name, array(
        'title'            => __( 'General Settings', 'betube' ),
        'id'               => 'generalsettings',
        'customizer_width' => '500px',
        'icon'             => 'el el-cogs',
		'fields'     => array(
			array(
				'id'=>'betube-logo',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Logo', 'betube'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.', 'betube'),
				'subtitle' => __('Upload your logo', 'betube'),
				'default'=>array('url'=>'http://demo.beetube.me/wp-content/uploads/2016/07/logo.png'),
			),
			array(
				'id'=>'betube-favicon',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Favicon', 'betube'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your favicon.', 'betube'),
				'subtitle' => __('Upload your favicon', 'betube'),
				'default'=>array('url'=>'http://demo.beetube.me/wp-content/themes/betube/favicon.png'),
			),
			array(
				'id'=>'betube-light-dark',
				'type' => 'radio',
				'title' => __('Select Color Scheme', 'betube'), 
				'subtitle' => __('Light or dark', 'betube'),
				'desc' => __('Select Theme color scheme light or dark', 'betube'),
				'options' => array('light' => 'Light', 'dark' => 'Dark'),//Must provide key => value pairs for radio options
				'default' => 'light'
			),
			array(
				'id'=>'betube_boxed',
				'type' => 'radio',
				'title' => __('Select Layout', 'betube'), 
				'subtitle' => __('Boxed or Wide', 'betube'),
				'desc' => __('Select theme layout which you want to use boxed or wide', 'betube'),
				'options' => array('wide' => 'Wide', 'boxed' => 'Boxed'),//Must provide key => value pairs for radio options
				'default' => 'wide'
			),
			array(
				'id'       => 'betube_boxed_bg_section',
				'type'     => 'background',
				'title'    => __('Boxed Background', 'betube'),
				'subtitle' => __('Select boxed background image, color, etc.', 'betube'),
				'desc'     => __('This option will work only on boxed layout.', 'betube'),
				'default'  => array(
					'background-color' => '#fff',
					'background-image' => '',
					'background-repeat' => 'no-repeat',
					'background-position' => 'center center',
					'background-size' => 'cover',
					'background-attachment' => 'fixed',
				),			 
			),
			array(
				'id' => 'nav-sticky',
				'type' => 'switch',
				'title' => __('Navbar Sticky', 'betube'),
				'subtitle' => __('Navbar Sticky', 'betube'),
				'default' => 1,
            ),			
			array(
				'id' => 'infinite-scroll',
				'type' => 'switch',
				'title' => __('Infinite Scroll On/OFF', 'betube'),
				'desc' => __('By default We are using Pagination if you want to use infinite-scroll then turn On This Option', 'betube'),
				'subtitle' => __('Infinite Scroll', 'betube'),
				'default' => 1,
            ),
			array(
				'id' => 'backtotop',
				'type' => 'switch',
				'title' => __('Back To Top Button', 'betube'),
				'desc' => __('If you dont want to use Back To Top Button Then Just Turn OFF This', 'betube'),
				'subtitle' => __('Turn On/OFF Back To Top', 'betube'),
				'default' => 1,
            ),
			array(
				'id' => 'newusernotification',
				'type' => 'switch',
				'title' => __('Email to Admin on Signup New User', 'betube'),
				'subtitle' => __('Would You like to receive email?', 'betube'),
				'desc' => __('If You want to receive Email on new user registration Please Turn On This option.', 'betube'),
				'default' => 2,
            ),
			array(
				'id' => 'betube-publish-post-notification',
				'type' => 'switch',
				'title' => __('Email user on Publish Post', 'betube'),
				'subtitle' => __('Would You like to send email?', 'betube'),
				'desc' => __('If You want to send email to user on Publish Post then Turn OFF this option.', 'betube'),
				'default' => 2,
            ),
			array(
				'id' => 'betube_categories_desc',
				'type' => 'switch',
				'title' => __('Category Description', 'betube'),
				'subtitle' => __('On/OFF', 'betube'),
				'desc' => __('If you want to shown category description on category page then Turn OFF This option', 'betube'),
				'default' => 0,
            ),
			array(
				'id'=>'tags_limit',
				'type' => 'text',
				'title' => __('Number of tags in tag Cloud widget', 'betube'),
				'subtitle' => __('Number of tags in tag Cloud widget', 'betube'),
				'desc' => __('Put here a number. Example "16"', 'betube'),
				'default' => '15'
			),
			array(
				'id'=>'author_limit_all',
				'type' => 'text',
				'title' => __('Number of Users', 'betube'),
				'subtitle' => __('All Author Page', 'betube'),
				'desc' => __('How many user you want to show per page on All Author Page?. Example 3, 6 , 9, 12', 'betube'),
				'default' => '9'
			),
			array(
				'id'=>'home-cat-counter',
				'type' => 'text',
				'title' => __('Number of Categories', 'betube'),
				'subtitle' => __('Number of Categories on HomePage', 'betube'),
				'desc' => __('How May categories you want to show on home page? Put here a number. Example "6"', 'betube'),
				'default' => '10'
			),
			array(
				'id'=>'all-videos-page-counter',
				'type' => 'text',
				'title' => __('Number of Videos', 'betube'),
				'subtitle' => __('Number of video on All Videos Page', 'betube'),
				'desc' => __('How May Videos you want to show on All Video Page? Put here a number. Example "6"', 'betube'),
				'default' => '9'
			),
			array(
				'id'=>'all-movies-page-counter',
				'type' => 'text',
				'title' => __('Number of Movies', 'betube'),
				'subtitle' => __('Number of Movies on All Movies Page', 'betube'),
				'desc' => __('How May Movies you want to show on All Movies Page? Put here a number. Example "8"', 'betube'),
				'default' => '8'
			),
			array(
				'id'=>'betube-main-grid-selection',
				'type' => 'radio',
				'title' => __('Auto Selection for Grid System', 'betube'), 
				'subtitle' => __('This will work on All Video Page and Categories', 'betube'),				
				'options' => array('gridsmall' => 'Grid View with Small Thumbnail', 'gridmedium' => 'Grid View with Medium Thumbnail','listmedium' => 'List View with Medium Thumbnail'),//Must provide key => value pairs for radio options
				'default' => 'gridsmall'
			),
			array(
				'id'=>'betube-header-style',
				'type' => 'radio',
				'title' => __('Select Header Style', 'betube'), 
				'subtitle' => __('Choose Header Style', 'betube'),
				'desc' => __('Select Your Header Style', 'betube'),
				'options' => array('v1' => 'Header 1', 'v2' => 'Header 2','v3' => 'Header 3','v4' => 'Header 4','v5' => 'Header 5','v6' => 'Header 6','v7' => 'Header 7','v8' => 'Header 8'),//Must provide key => value pairs for radio options
				'default' => 'v1'
			),
			array(
				'id'=>'betube_all_videos_style',
				'type' => 'radio',
				'title' => __('Select All Video Page Style', 'betube'), 
				'subtitle' => __('List / Multi', 'betube'),
				'desc' => __('Select which view you want to apply only list view or multi view which have list plus grid option', 'betube'),
				'options' => array('multi' => 'Multi List and Grid', 'list' => 'List View'),//Must provide key => value pairs for radio options
				'default' => 'multi'
			),
			array(
				'id' => 'betube-footer-on',
				'type' => 'switch',
				'title' => __('Footer Widget Area', 'betube'),
				'desc' => __('If you dont want to use Widget in footer then turn off this.', 'betube'),
				'subtitle' => __('Footer Widget On/OFF', 'betube'),
				'default' => 1,
            ),
			array(
				'id'=>'footer_copyright',
				'type' => 'text',
				'title' => __('Footer Copyright Text', 'betube'),
				'subtitle' => __('Footer Copyright Text', 'betube'),
				'desc' => __('You can add text here.', 'betube'),
				'default' => 'All copyrights reserved © 2017'
			),	
			array(
				'id'=>'betube_footer_fullwidth',
				'type' => 'radio',
				'title' => __('Select Footer Layout', 'betube'), 
				'subtitle' => __('Normal / FullWidth', 'betube'),
				'desc' => __('Select Footer Style , How you want to show footer in fullwidth or normal?', 'betube'),
				'options' => array('normal' => 'Normal', 'fullwidth' => 'FullWidth'),//Must provide key => value pairs for radio options
				'default' => 'normal'
			),
			array(
				'id'=>'footer-logo',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Logo', 'betube'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload logo for footer(Leave It Empty if you dont want to show logo in footer area) Best Size 100x30px.', 'betube'),
				'subtitle' => __('Upload logo for footer', 'betube'),
				'default'=>array('url'=>'http://demo.beetube.me/wp-content/uploads/2016/05/footerlogo.png'),
			),
			array(
				'id' => 'betube-loader-on',
				'type' => 'switch',
				'title' => __('Loader Image On/OFF', 'betube'),
				'desc' => __('If you want to use loader then please turn on this option.', 'betube'),
				'subtitle' => __('Loader On/OFF', 'betube'),
				'default' => 2,
            ),
			array(
				'id'=>'betube-loader-img',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Loader Image', 'betube'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your Loader image.', 'betube'),
				'subtitle' => __('Upload your Loader image.', 'betube'),
				'default'=>array('url'=>''),
			),
			array(
                'id'       => 'betube-loader-bg',
                'type'     => 'color',                
                'title'    => __( 'Loader Background', 'betube' ),
                'subtitle' => __( 'Pick color for loader (default: #fff).', 'betube' ),
				'desc'     => __( 'This color will be shown on the loader background screen.', 'betube' ),
                'default'  => '#fff',
				'validate' => 'color',
            ),
		)
    ) );
	// -> Home Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Home Section', 'betube' ),
        'id'               => 'homesections',
        'customizer_width' => '500px',
        'icon'             => 'el el-home',
		'fields'     => array(
			array(
            'id' => 'landing-first-section-on',
            'type' => 'switch',
            'title' => __('Turn ON/OFF First Section', 'betube'),
            'subtitle' => __('Turn ON/OFF First Section on Home Page', 'betube'),
            'default' => 1,
            ),
			array(
			'id'=>'landing-first-section-title',
			'type' => 'text',
			'title' => __('Landing Page First Section Title', 'betube'),			
			'desc' => __('Put Landing Page First Section Title, If you will leave empty then category name will be shown as a title.', 'betube'),
			'default' => 'Newest Videos'
			),
			array(
			'id'=>'landing-first-grid-selection',
			'type' => 'radio',
			'title' => __('Auto Selection for Grid System', 'betube'), 
			'subtitle' => __('Select any option to show your Auto Selection for Grid System', 'betube'),
			'options' => array('gridsmall' => 'Grid View with Small Thumbnail', 'gridmedium' => 'Grid View with Medium Thumbnail','listmedium' => 'List View with Medium Thumbnail'),//Must provide key => value pairs for radio options
			'default' => 'gridsmall'
			),
			array(
			'id'=>'landing-first-section-category',
			'type' => 'select',
			'data' => 'categories',
			'multi' => false,
			'title' => __('Landing Page First Section Category', 'betube'), 
			'subtitle' => __('Taxonomy Query Video Category', 'betube'),			
			'default' => 1,
			),
			array(
			'id'=>'landing-first-section-pcount',
			'type' => 'text',
			'title' => __('Number of Posts', 'betube'),			
			'desc' => __('How much Post You want to show in this section Put here a number. Example "5"', 'betube'),
			'default' => '1'
			),
			array(
			'id'=>'landing-first-section-order',
			'type' => 'radio',
			'title' => __('First Section Sort Order', 'betube'), 
			'subtitle' => __('Select Orderby', 'betube'),
			'desc' => __('Select First Section Sort Order', 'betube'),
			'options' => array('date' => 'Date', 'title' => 'Title', 'views' => 'Views', 'comment_count' => 'Comments', 'rand' => 'Random'),//Must provide key => value pairs for radio options			
			'default' => 'date'
			),
			array(
			'id'=>'landing-first-section-ad_code',
			'type' => 'textarea',
			'title' => __('Ads Code for First Section', 'betube'),
			'subtitle' => __('Ads Code', 'betube'),
			'desc' => __('Put your first section ads code', 'betube'),
			'default' => ''
			),
			//Second Section
			array(
            'id' => 'landing-second-section-on',
            'type' => 'switch',
            'title' => __('Turn ON/OFF Second Section', 'betube'),
            'subtitle' => __('Turn ON/OFF Second Section on Home Page', 'betube'),
            'default' => 1,
            ),
			array(
			'id'=>'landing-second-section-title',
			'type' => 'text',
			'title' => __('Landing Page Second Section Title', 'betube'),			
			'desc' => __('Put Landing Page Second Section Title, If you will leave empty then category name will be shown as a title.', 'betube'),
			'default' => 'Most Viewed'
			),
			array(
			'id'=>'landing-second-grid-selection',
			'type' => 'radio',
			'title' => __('Auto Selection for Grid System', 'betube'), 
			'subtitle' => __('Select any option to show your Auto Selection for Grid System', 'betube'),
			'options' => array('gridsmall' => 'Grid View with Small Thumbnail', 'gridmedium' => 'Grid View with Medium Thumbnail', 'listmedium' => 'List View with Medium Thumbnail'),//Must provide key => value pairs for radio options
			'default' => 'gridsmall'
			),
			array(
			'id'=>'landing-second-section-category',
			'type' => 'select',
			'data' => 'categories',
			'multi' => false,
			'title' => __('Landing Page second Section Category', 'betube'), 
			'subtitle' => __('Taxonomy Query Video Category', 'betube'),			
			'default' => 1,
			),
			array(
			'id'=>'landing-second-section-pcount',
			'type' => 'text',
			'title' => __('Number of Posts', 'betube'),			
			'desc' => __('How much Post You want to show in this section Put here a number. Example "5"', 'betube'),
			'default' => '9'
			),
			array(
			'id'=>'landing-second-section-order',
			'type' => 'radio',
			'title' => __('second Section Sort Order', 'betube'), 
			'subtitle' => __('Select Orderby', 'betube'),
			'desc' => __('Select second Section Sort Order', 'betube'),
			'options' => array('date' => 'Date', 'title' => 'Title', 'views' => 'Views', 'comment_count' => 'Comments', 'rand' => 'Random'),//Must provide key => value pairs for radio options			
			'default' => 'date'
			),
			array(
			'id'=>'landing-second-section-ad_code',
			'type' => 'textarea',
			'title' => __('Ads Code for Second Section', 'betube'),
			'subtitle' => __('Ads Code', 'betube'),
			'desc' => __('Put your Second section ads code', 'betube'),
			'default' => ''
			),
			//Section third
			array(
            'id' => 'landing-third-section-on',
            'type' => 'switch',
            'title' => __('Turn ON/OFF third Section', 'betube'),
            'subtitle' => __('Turn ON/OFF third Section on Home Page', 'betube'),
            'default' => 1,
            ),
			array(
			'id'=>'landing-third-section-title',
			'type' => 'text',
			'title' => __('Landing Page third Section Title', 'betube'),			
			'desc' => __('Put Landing Page third Section Title, If you will leave empty then category name will be shown as a title.', 'betube'),
			'default' => 'Most Liked'
			),
			array(
			'id'=>'landing-third-grid-selection',
			'type' => 'radio',
			'title' => __('Auto Selection for Grid System', 'betube'), 
			'subtitle' => __('Select any option to show your Auto Selection for Grid System', 'betube'),
			'options' => array('gridsmall' => 'Grid View with Small Thumbnail', 'gridmedium' => 'Grid View with Medium Thumbnail','listmedium' => 'List View with Medium Thumbnail'),//Must provide key => value pairs for radio options
			'default' => 'gridsmall'
			),
			array(
			'id'=>'landing-third-section-category',
			'type' => 'select',
			'data' => 'categories',
			'multi' => false,
			'title' => __('Landing Page third Section Category', 'betube'), 
			'subtitle' => __('Taxonomy Query Video Category', 'betube'),			
			'default' => 1,
			),
			array(
			'id'=>'landing-third-section-pcount',
			'type' => 'text',
			'title' => __('Number of Posts', 'betube'),			
			'desc' => __('How much Post You want to show in this section Put here a number. Example "5"', 'betube'),
			'default' => '12'
			),
			array(
			'id'=>'landing-third-section-order',
			'type' => 'radio',
			'title' => __('third Section Sort Order', 'betube'), 
			'subtitle' => __('Select Orderby', 'betube'),
			'desc' => __('Select third Section Sort Order', 'betube'),
			'options' => array('date' => 'Date', 'title' => 'Title', 'views' => 'Views', 'comment_count' => 'Comments', 'rand' => 'Random'),//Must provide key => value pairs for radio options			
			'default' => 'date'
			),
			array(
			'id'=>'landing-third-section-ad_code',
			'type' => 'textarea',
			'title' => __('Ads Code for Third Section', 'betube'),			
			'desc' => __('Put your Third section ads code', 'betube'),
			'default' => ''
			),
			//Section Fourth
			array(
            'id' => 'landing-fourth-section-on',
            'type' => 'switch',
            'title' => __('Turn ON/OFF fourth Section', 'betube'),
            'subtitle' => __('Turn ON/OFF fourth Section on Home Page', 'betube'),
            'default' => 1,
            ),
			array(
			'id'=>'landing-fourth-section-title',
			'type' => 'text',
			'title' => __('Landing Page fourth Section Title', 'betube'),			
			'desc' => __('Put Landing Page fourth Section Title, If you will leave empty then category name will be shown as a title.', 'betube'),
			'default' => 'Fourth Title'
			),
			array(
			'id'=>'landing-fourth-grid-selection',
			'type' => 'radio',
			'title' => __('Auto Selection for Grid System', 'betube'), 
			'subtitle' => __('Select any option to show your Auto Selection for Grid System', 'betube'),
			'options' => array('gridsmall' => 'Grid View with Small Thumbnail', 'gridmedium' => 'Grid View with Medium Thumbnail', 'listmedium' => 'List View with Medium Thumbnail'),//Must provide key => value pairs for radio options
			'default' => 'gridsmall'
			),
			array(
			'id'=>'landing-fourth-section-category',
			'type' => 'select',
			'data' => 'categories',
			'multi' => false,
			'title' => __('Landing Page fourth Section Category', 'betube'), 
			'subtitle' => __('Taxonomy Query Video Category', 'betube'),			
			'default' => 1,
			),
			array(
			'id'=>'landing-fourth-section-pcount',
			'type' => 'text',
			'title' => __('Number of Posts', 'betube'),			
			'desc' => __('How much Post You want to show in this section Put here a number. Example "5"', 'betube'),
			'default' => '4'
			),
			array(
			'id'=>'landing-fourth-section-order',
			'type' => 'radio',
			'title' => __('fourth Section Sort Order', 'betube'), 
			'subtitle' => __('Select Orderby', 'betube'),
			'desc' => __('Select fourth Section Sort Order', 'betube'),
			'options' => array('date' => 'Date', 'title' => 'Title', 'views' => 'Views', 'comment_count' => 'Comments', 'rand' => 'Random'),//Must provide key => value pairs for radio options			
			'default' => 'date'
			),
			array(
			'id'=>'landing-fourth-section-ad_code',
			'type' => 'textarea',
			'title' => __('Ads Code for fourth Section', 'betube'),			
			'desc' => __('Put your fourth section ads code', 'betube'),
			'default' => ''
			),
			///Five Section
			array(
            'id' => 'landing-five-section-on',
            'type' => 'switch',
            'title' => __('Turn ON/OFF five Section', 'betube'),
            'subtitle' => __('Turn ON/OFF five Section on Home Page', 'betube'),
            'default' => 1,
            ),
			array(
			'id'=>'landing-five-section-title',
			'type' => 'text',
			'title' => __('Landing Page five Section Title', 'betube'),			
			'desc' => __('Put Landing Page five Section Title, If you will leave empty then category name will be shown as a title.', 'betube'),
			'default' => 'five Title'
			),
			array(
			'id'=>'landing-five-grid-selection',
			'type' => 'radio',
			'title' => __('Auto Selection for Grid System', 'betube'), 
			'subtitle' => __('Select any option to show your Auto Selection for Grid System', 'betube'),
			'desc' => __('Select View', 'betube'),
			'options' => array('gridsmall' => 'Grid View with Small Thumbnail', 'gridmedium' => 'Grid View with Medium Thumbnail', 'listmedium' => 'List View with Medium Thumbnail'),//Must provide key => value pairs for radio options
			'default' => 'gridsmall'
			),
			array(
			'id'=>'landing-five-section-category',
			'type' => 'select',
			'data' => 'categories',
			'multi' => false,
			'title' => __('Landing Page five Section Category', 'betube'), 
			'subtitle' => __('Taxonomy Query Video Category', 'betube'),			
			'default' => 1,
			),
			array(
			'id'=>'landing-five-section-pcount',
			'type' => 'text',
			'title' => __('Number of Posts', 'betube'),
			'subtitle' => __('Post Count', 'betube'),
			'desc' => __('How much Post You want to show in this section Put here a number. Example "5"', 'betube'),
			'default' => '2'
			),
			array(
			'id'=>'landing-five-section-order',
			'type' => 'radio',
			'title' => __('five Section Sort Order', 'betube'), 
			'subtitle' => __('Select Orderby', 'betube'),
			'desc' => __('Select five Section Sort Order', 'betube'),
			'options' => array('date' => 'Date', 'title' => 'Title', 'views' => 'Views', 'comment_count' => 'Comments', 'rand' => 'Random'),//Must provide key => value pairs for radio options			
			'default' => 'date'
			),
			array(
			'id'=>'landing-five-section-ad_code',
			'type' => 'textarea',
			'title' => __('Ads Code for Five Section', 'betube'),			
			'desc' => __('Put your Five section ads code', 'betube'),
			'default' => ''
			),
		)
    ) );
	// -> START Blog Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Random Categories', 'betube' ),
        'id'               => 'homerandcat',
		'subsection'       => true,
		'desc'  => __( 'These settings will be work on random categories section on homepage', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-list-alt',
		'fields'     => array(
			array(
				'id'=>'randomcat-title-homev5',
				'type' => 'text',
				'title' => __('Random Category Section Title', 'betube'),
				'subtitle' => __('Random Category Section Title', 'betube'),
				'desc' => __('Put Title for Random Category Section on Homepage V5', 'betube'),
				'default' => 'Watch Videos from random Medias'
			),
			array(
				'id'=>'randomcat-desc-homev5',
				'type' => 'textarea',
				'title' => __('Random Category Section Description', 'betube'),
				'subtitle' => __('Put Description', 'betube'),
				'desc' => __('Put Description for Random Category Section', 'betube'),
				'default' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
			),
			array(
				'id'=>'randomcat-list-homev5',
				'type' => 'select',
				'data' => 'categories',
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'multi'    => true,				
				'title' => __('Select Categories for Random Cat Section', 'betube'), 
				'subtitle' => __('Random Category Section', 'betube'),
				'desc' => __('Please select categories which you want to shown on Random Categories section on homepage V5', 'betube'),
				'default' => 1,
			),
			array(
				'id'=>'randomcat-section-pcount',
				'type' => 'text',
				'title' => __('How Many Post?', 'betube'),
				'subtitle' => __('Post Count', 'betube'),
				'desc' => __('How Many Post you want to show on Random Categories Section. Example "6"', 'betube'),
				'default' => '6'
			),
			array(
				'id'=>'randomcat-grid-selection',
				'type' => 'radio',
				'title' => __('Auto Selection for Grid System', 'betube'), 
				'subtitle' => __('Select any option to show your Auto Selection for Grid System', 'betube'),
				'desc' => __('Select View from Random Categories Section Area', 'betube'),
				'options' => array('gridsmall' => 'Grid View with Small Thumbnail', 'gridmedium' => 'Grid View with Medium Thumbnail', 'listmedium' => 'List View with Medium Thumbnail'),//Must provide key => value pairs for radio options
				'default' => 'gridsmall'
			),
		)
    ) );
	// -> START Blog Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Categories Slider', 'betube' ),
        'id'               => 'homecatslider',
		'subsection'       => true,
		'desc'  => __( 'Categories Slider', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-list-alt',
		'fields'     => array(
			array(
				'id' => 'betube_cat_slider_fullwidth',
				'type' => 'switch',
				'title' => __('Turn On/OFF Categories section fullwidth', 'betube'),				
				'desc' => __('If you want to use categories section in fullwidth then turn on this option.', 'betube'),
				'default' => 0,
            ),
			array(
				'id'=>'betube_cat_slider',
				'type' => 'select',
				'data' => 'categories',
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'multi'    => true,				
				'title' => __('Select Categories', 'betube'), 
				'subtitle' => __('Categories Slider', 'betube'),
				'desc' => __('Please select categories which you want to shown on Categories Slider', 'betube'),
				'default' => 1,
			),
		)
    ) );
	// -> START Blog Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Movies Section', 'betube' ),
        'id'               => 'homemoviessection',
		'subsection'       => true,
		'desc'  => __( 'You can manage Movies section from here', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-film',
		'fields'     => array(
			array(
				'id' => 'betube-movies-section',
				'type' => 'switch',
				'title' => __('Movies Section', 'betube'),
				'desc' => __('If dont want to show movies section then just turn off this, It will not work for landing page template. Its only work on other homepages.', 'betube'),
				'subtitle' => __('Movies section On/OFF', 'betube'),
				'default' => 1,
            ),
			array(
				'id' => 'betube_movies_fullwidth',
				'type' => 'switch',
				'title' => __('Movies Section FullWidth', 'betube'),
				'desc' => __('If you want to use fullwidth then just turn on this option.', 'betube'),
				'subtitle' => __('Movies section On/OFF', 'betube'),
				'default' => 0,
            ),
			array(
				'id'=>'movies-section-pcount',
				'type' => 'text',
				'title' => __('How Many Movies?', 'betube'),
				'subtitle' => __('Movies Count', 'betube'),
				'desc' => __('How Many Movies you want to show on Homepage. Example "6"', 'betube'),
				'default' => '6'
			),
			array(
				'id'=>'movies-section-ad_code',
				'type' => 'textarea',
				'title' => __('Ads Code for Movies Section', 'betube'),
				'subtitle' => __('Ads Code', 'betube'),
				'desc' => __('Put your Movies section ads code', 'betube'),
				'default' => ''
			),
		)
    ) );
	// -> START Blog Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Blog Section', 'betube' ),
        'id'               => 'homeblogsection',
		'subsection'       => true,
		'desc'  => __( 'These settings will be only work when you are using blog section one homepage', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-book',
		'fields'     => array(
			array(
				'id' => 'betube_blog_section_on',
				'type' => 'switch',
				'title' => __('Turn On/OFF Blog Section', 'betube'),
				'subtitle' => __('Turn ON/OFF blog Section on Home Page', 'betube'),
				'desc' => __('This On/OFF option only will work for home pages templates, if you are using Landing Page then you can manage this section from landing page manager.', 'betube'),
				'default' => 1,
            ),
			array(
				'id' => 'betube_blog_section_fullwidth',
				'type' => 'switch',
				'title' => __('Turn On/OFF Blog Section FullWidth', 'betube'),				
				'desc' => __('If you want to use fullwidth blog section then turn on this option.', 'betube'),
				'default' => 0,
            ),
			array(
				'id'=>'betube_blog_section_title',
				'type' => 'text',
				'title' => __('Blog Section Title', 'betube'),
				'subtitle' => __('Replace text', 'betube'),
				'desc' => __('Change blog section title from homepage.', 'betube'),
				'default' => 'Latest From Blog'
			),
			array(
				'id'=>'betube_blog_section_count',
				'type' => 'text',
				'title' => __('How Many Post', 'betube'),
				'subtitle' => __('Post Count', 'betube'),
				'desc' => __('How many posts you want to shown in blog section on homepage?', 'betube'),
				'default' => '6'
			),
			array(
				'id'=>'betube_blog_section_post_order',
				'type' => 'radio',
				'title' => __('Blog Section Post Order', 'betube'), 
				'subtitle' => __('Select Order', 'betube'),				
				'options' => array('title' => 'Order by title','name' => 'Order by name','date' => 'Order by date','rand' => 'Order by random'),//Must provide key => value pairs for radio options
				'default' => 'title'
			),
		)
    ) );
	// -> START Editors
	Redux::setSection( $opt_name, array(
        'title'            => __( 'News Ticker', 'betube' ),
        'id'               => 'homenewstricker',
		'subsection'       => true,
		'desc'  => __( 'These settings will be only work when you are Header Version which have Headline', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-book',
		'fields'     => array(
			array(
				'id'=>'betube_news_categories',
				'type' => 'select',
				'data' => 'categories',
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'multi'    => true,				
				'title' => __('Select Categories for Headlines', 'betube'), 
				'subtitle' => __('Headlines Categories', 'betube'),
				'desc' => __('Please select categories from where you want to show post on headlines', 'betube'),
				'default' => 1,
			),
			array(
				'id'=>'betube_news_count',
				'type' => 'text',
				'title' => __('How Many Post', 'betube'),
				'subtitle' => __('Post Count in Headline', 'betube'),
				'desc' => __('How many posts you want to shown in Headlines minimum 3', 'betube'),
				'default' => '6'
			),
			array(
				'id'=>'betube_news_sort_order',
				'type' => 'radio',
				'title' => __('Headlines sort order', 'betube'), 
				'subtitle' => __('Select Order', 'betube'),				
				'options' => array('title' => 'Order by title','name' => 'Order by name','date' => 'Order by date','rand' => 'Order by random'),//Must provide key => value pairs for radio options
				'default' => 'title'
			),
		)
    ) );
	// -> Home Magazine
	Redux::setSection( $opt_name, array(
        'title'            => __( 'BeTube Magazine', 'betube' ),
        'id'               => 'betube_home_mag',
        'customizer_width' => '500px',
        'icon'             => 'el el-home',
		'fields'     => array(			
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Mag Trendy Posts', 'betube' ),
        'id'               => 'betube_mag_trendy',
		'subsection'       => true,
		'desc'  => __( 'Manage Trendy Posts', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-wrench-alt',
		'fields'     => array(
			array(
				'id' => 'betube_trendy_posts_off',
				'type' => 'switch',
				'title' => __('Trendy Posts', 'betube'),
				'subtitle' => __('Trendy Posts section on/off', 'betube'),
				'default' => 1,
            ),
			array(
				'id'=>'betube_trendy_posts_title',
				'type' => 'text',
				'title' => __('Trendy Posts Title', 'betube'),
				'subtitle' => __('Change Title from here', 'betube'),				
				'default' => 'TRENDY POSTS'
			),
			array(
				'id'=>'betube_trendy_posts_icon',
				'type' => 'text',
				'title' => __('Trendy Posts Icon', 'betube'),
				'subtitle' => __('Put font awesome icon code', 'betube'),				
				'default' => 'fa fa-bolt'
			),
			array(
                'id'       => 'betube_trendy_posts_icon_color',
                'type'     => 'color',
                'title'    => __( 'Trendy Posts Icon color', 'betube' ),
                'subtitle' => __( 'Pick a Trendy Posts Icon (default: #56a4ca).', 'betube' ),
                'default'  => '#56a4ca',
                'validate' => 'color',
            ),
			array(
				'id'=>'betube_trendy_posts_desc',
				'type' => 'textarea',
				'title' => __('Trendy Posts Description', 'betube'),
				'subtitle' => __('Change Description from here', 'betube'),				
				'default' => 'It is a long established fact that a reader'
			),
			array(
				'id' => 'betube_trendy_posts_categories',
				'type' => 'select',				
				'data' => 'categories',
				'multi' => true,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Select Categories', 'betube'),				
				'desc' => __('Select categories from where you want to show most viewed posts.', 'betube'),
				'default' => 1,
            ),
			array(
				'id'=>'betube_trendy_posts_count',
				'type' => 'text',
				'title' => __('How many post', 'betube'),
				'desc' => __('How many posts you want to shown on Trendy Posts slider', 'betube'),				
				'default' => '10'
			),
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Mag Featured Posts', 'betube' ),
        'id'               => 'betube_mag_featured',
		'subsection'       => true,
		'desc'  => __( 'Manage Featured Posts', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-star-empty',
		'fields'     => array(
			array(
				'id'=>'betube_featured_posts_title',
				'type' => 'text',
				'title' => __('Featured Heading', 'betube'),
				'desc' => __('replace text from here', 'betube'),				
				'default' => 'Featured Posts'
			),
			array(
				'id'=>'betube_featured_posts_desc',
				'type' => 'text',
				'title' => __('Featured Description', 'betube'),
				'desc' => __('replace text from here', 'betube'),				
				'default' => 'It is a long established fact that a reader'
			),
			array(
				'id'=>'betube_featured_posts_icon',
				'type' => 'text',
				'title' => __('Featured Posts Icon', 'betube'),
				'subtitle' => __('Put font awesome icon code', 'betube'),				
				'default' => 'fa fa-star'
			),
			array(
                'id'       => 'betube_featured_posts_icon_color',
                'type'     => 'color',
                'title'    => __( 'Featured Posts Icon color', 'betube' ),
                'subtitle' => __( 'Pick a Featured Posts Icon (default: #ffc107).', 'betube' ),
                'default'  => '#ffc107',
                'validate' => 'color',
            ),
			array(
				'id'=>'betube_featured_posts_type',
				'type' => 'checkbox',
				'title' => __('Select Post Type', 'betube'),
				'desc' => __('From which posts type you want to show featured posts on homepage section please select that.', 'betube'),				
				'options'  => array(
					'image' => 'Image',
					'video' => 'Video',
					'audio' => 'Audio'
				),
				'default' => array(
					'image' => '1', 
					'video' => '1', 
					'audio' => '1'
				)
			),
			array(
				'id'=>'betube_featured_posts_adv',
				'type' => 'textarea',
				'title' => __('Ads code for Featured Post', 'betube'),
				'desc' => __('Place Ad code here', 'betube'),				
				'default' => ''
			),
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Mag Multi Categories', 'betube' ),
        'id'               => 'betube_mag_multi_mag',
		'subsection'       => true,
		'desc'  => __( 'Manage Multi Categories Section', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-star-empty',
		'fields'     => array(
			array(
				'id'=>'betube_mag_main_cat',
				'type' => 'select',
				'data' => 'categories',
				'multi' => false,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Select Main Category', 'betube'), 
				'subtitle' => __('Main Category for Multi Categories section.', 'betube'),			
				'default' => 1,
			),
			array(
				'id'=>'betube_mag_main_cat_des',
				'type' => 'textarea',
				'title' => __('Description for main category', 'betube'),
				'desc' => __('Change category section description', 'betube'),
				'default' => 'It is a long established fact that a reader'
			),
			array(
				'id'=>'betube_mag_multi_categories',
				'type' => 'select',
				'data' => 'categories',
				'multi' => true,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Select sub categories', 'betube'), 
				'subtitle' => __('Select more categories which you want to show in tabber of multi categories', 'betube'),			
				'default' => 1,
			),
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Mag Watch News', 'betube' ),
        'id'               => 'betube_mag_watch_news',
		'subsection'       => true,
		'desc'  => __( 'Manage Watch News Section', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-bullhorn',
		'fields'     => array(
			array(
				'id'=>'betube_watch_news_title',
				'type' => 'text',
				'title' => __('Watch News Heading', 'betube'),
				'desc' => __('replace text from here', 'betube'),				
				'default' => 'Watch News'
			),
			array(
				'id'=>'betube_watch_news_description',
				'type' => 'textarea',
				'title' => __('Watch News Description', 'betube'),
				'desc' => __('replace text from here', 'betube'),				
				'default' => 'It is a long established fact that a reader'
			),
			array(
				'id'=>'betube_watch_news_icon',
				'type' => 'text',
				'title' => __('Watch News Icon', 'betube'),
				'subtitle' => __('Put font awesome icon code', 'betube'),				
				'default' => 'fa fa-bullhorn'
			),
			array(
                'id'       => 'betube_watch_news_icon_color',
                'type'     => 'color',
                'title'    => __( 'Watch News Icon color', 'betube' ),
                'subtitle' => __( 'Pick a Watch News Icon (default: #f44336).', 'betube' ),
                'default'  => '#f44336',
                'validate' => 'color',
            ),
			array(
				'id'=>'betube_watch_news_cats',
				'type' => 'select',
				'data' => 'categories',
				'multi' => true,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Select categories', 'betube'), 
				'subtitle' => __('Select categories from which you want to show posts in Watch News Section', 'betube'),			
				'default' => 1,
			),
			array(
				'id'=>'betube_watch_news_post_count',
				'type' => 'text',
				'title' => __('How Many Posts', 'betube'),
				'subtitle' => __('Put a number how many posts you want to show in this section.', 'betube'),				
				'default' => '10'
			),
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Mag Favorite Categories', 'betube' ),
        'id'               => 'betube_mag_favorite_cats',
		'subsection'       => true,
		'desc'  => __( 'Manage Mag Favorite Categories section', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-heart-empty',
		'fields'     => array(
			array(
				'id' => 'betube_mag_favorite_on',
				'type' => 'switch',
				'title' => __('Turn On/OFF Favorite Section', 'betube'),
				'subtitle' => __('Turn ON/OFF Favorite Section', 'betube'),
				'desc' => __('This On/OFF option only will work for Mag home page template.', 'betube'),
				'default' => 1,
            ),
			array(
				'id'=>'betube_mag_favorite_cats_list',
				'type' => 'select',
				'data' => 'categories',
				'multi' => true,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Select categories', 'betube'), 
				'subtitle' => __('Select categories from which you want to show posts in Favorite Categories Section.', 'betube'),			
				'default' => 1,
			),
			array(
				'id'=>'betube_mag_favorite_adv',
				'type' => 'textarea',
				'title' => __('Favorite section advertisements', 'betube'),
				'desc' => __('put code here', 'betube'),				
				'default' => ''
			),
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Mag Recent Posts', 'betube' ),
        'id'               => 'betube_mag_recent_post_section',
		'subsection'       => true,
		'desc'  => __( 'Manage Mag Recent Posts section', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-pencil-alt',
		'fields'     => array(
			array(
				'id'=>'betube_mag_recent_posts',
				'type' => 'text',
				'title' => __('Recent Posts Heading', 'betube'),
				'desc' => __('replace text from here', 'betube'),				
				'default' => 'Recent Posts'
			),
			array(
				'id'=>'betube_mag_recent_posts_desc',
				'type' => 'textarea',
				'title' => __('Recent Posts Description', 'betube'),
				'desc' => __('replace text from here', 'betube'),				
				'default' => 'It is a long established fact that a reader'
			),
			array(
				'id'=>'betube_mag_recent_posts_icon',
				'type' => 'text',
				'title' => __('Recent Posts Icon', 'betube'),
				'subtitle' => __('Put font awesome icon code', 'betube'),				
				'default' => 'fa fa-bullhorn'
			),
			array(
                'id'       => 'betube_mag_recent_posts_color',
                'type'     => 'color',
                'title'    => __( 'Recent Posts Icon color', 'betube' ),
                'subtitle' => __( 'Pick a Recent Posts Icon color (default: #40c4ff).', 'betube' ),
                'default'  => '#40c4ff',
                'validate' => 'color',
            ),
			array(
				'id'=>'betube_mag_recent_posts_cat_list',
				'type' => 'select',
				'data' => 'categories',
				'multi' => true,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Select categories', 'betube'), 
				'subtitle' => __('Select categories from which you want to show posts in Recent Posts Section', 'betube'),
				'default' => 1,
			),
			array(
				'id'=>'betube_mag_recent_posts_type',
				'type' => 'checkbox',
				'title' => __('Select Post Type', 'betube'),
				'desc' => __('From which posts type you want to show posts on homepage section please select that.', 'betube'),				
				'options'  => array(
					'image' => 'Image',
					'video' => 'Video',
					'audio' => 'Audio'
				),
				'default' => array(
					'image' => '1', 
					'video' => '1', 
					'audio' => '1'
				)
			),
			array(
				'id'=>'betube_mag_recent_posts_count',
				'type' => 'text',
				'title' => __('How many posts', 'betube'),
				'subtitle' => __('Put a number', 'betube'),	
				'desc' => __('How many posts you want to show in this section you must need to put 5x5 Like 5 or 10 or 15 or 20', 'betube'),	
				'default' => '10'
			),
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Mag More News', 'betube' ),
        'id'               => 'betube_mag_more_news_section',
		'subsection'       => true,
		'desc'  => __( 'Manage Mag More News section', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-bullhorn',
		'fields'     => array(
			array(
				'id'=>'betube_mag_more_news_title',
				'type' => 'text',
				'title' => __('More News Heading', 'betube'),
				'desc' => __('replace text from here', 'betube'),				
				'default' => 'More News'
			),
			array(
				'id'=>'betube_mag_more_news_desc',
				'type' => 'textarea',
				'title' => __('More News Description', 'betube'),
				'desc' => __('replace text from here', 'betube'),				
				'default' => 'It is a long established fact that a reader'
			),
			array(
				'id'=>'betube_mag_more_news_icon',
				'type' => 'text',
				'title' => __('More News Icon', 'betube'),
				'subtitle' => __('Put font awesome icon code', 'betube'),				
				'default' => 'fa fa-bullhorn'
			),
			array(
                'id'       => 'betube_mag_more_news_color',
                'type'     => 'color',
                'title'    => __( 'More News Icon color', 'betube' ),
                'subtitle' => __( 'Pick a Recent Posts Icon color (default: #3dbd5d).', 'betube' ),
                'default'  => '#3dbd5d',
                'validate' => 'color',
            ),
			array(
				'id'=>'betube_mag_more_news_cat_list',
				'type' => 'select',
				'data' => 'categories',
				'multi' => true,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Select categories', 'betube'), 
				'subtitle' => __('Select categories from which you want to show posts in More News Section', 'betube'),
				'default' => 1,
			),
			array(
				'id'=>'betube_mag_more_news_post_types',
				'type' => 'checkbox',
				'title' => __('Select Post Type', 'betube'),
				'desc' => __('From which posts type you want to show posts on homepage More News section please select that.', 'betube'),				
				'options'  => array(
					'image' => 'Image',
					'video' => 'Video',
					'audio' => 'Audio'
				),
				'default' => array(
					'image' => '1', 
					'video' => '1', 
					'audio' => '1'
				)
			),
			array(
				'id'=>'betube_mag_more_news_post_count',
				'type' => 'text',
				'title' => __('How many posts', 'betube'),
				'subtitle' => __('Put a number', 'betube'),						
				'default' => '4'
			),
		)
    ) );
	// -> Mag Layout Manager
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Mag Layout Manager', 'betube' ),
        'id'               => 'betube_mag_layout',
		'desc'  => __( 'These Settings will work only on Landing Page Template, If you want to disable any section just drap to Disable section.', 'betube' ),
        'customizer_width' => '500px',
		'subsection'       => true,
        'icon'             => 'el el-home-alt',
		'fields'     => array(
			array(
				'id' => 'betube_carousel_slider_off',
				'type' => 'switch',
				'title' => __('Carousel slider', 'betube'),
				'subtitle' => __('Carousel slider on/off from Mag template only', 'betube'),
				'default' => 1,
            ),
			array(
                'id'       => 'betube_mag_layout_manager',
                'type'     => 'sorter',
                'title'    => 'Mag Layout Manager',
                'desc'     => 'Organize how you want the layout to appear on the mag homepage',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(                       
                    ),
                    'enabled'  => array(
                        'featuredmag' => 'Featured Posts',
                        'multicatsmag'   => 'Multi Categories',                       
                        'watchnewsmag'   => 'Watch News',
                        'favoritecatsmag'   => 'Favorite Categories',
                        'recentmag'   => 'Recent Posts Section',                       
						'morenewsmag'   => 'More News',						
                    ),
                ),
            ),
		)
    ) );
	// -> START Editors
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Landing Page Manager', 'betube' ),
        'id'               => 'homelayoutmanager',
		'desc'  => __( 'These Settings will work only on Landing Page Template, If you want to disable any section just drap to Disable section.', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-home-alt',
		'fields'     => array(
			array(
                'id'       => 'betube-landing-layout',
                'type'     => 'sorter',
                'title'    => 'Homepage Layout Manager',
                'desc'     => 'Organize how you want the layout to appear on the homepage',
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(
                        'moviesv2'   => 'Movies Slider V2',
						'blogsection'   => 'Blogs Posts',
						'htmlsection'   => 'WP Editor Content',
                    ),
                    'enabled'  => array(
                        'layerslider' => 'LayerSlider',
                        'verticalslider'   => 'Vertical Slider',                       
                        'caraslider'   => 'Carousel Slider',
                        'featuredvideos'   => 'Featured Videos Slider',
                        'homecategory'   => 'Categories',
                        'maincontent'   => 'Video Content',
						'maincontent2'   => 'Videos With Sidebar',
						'maincontent3'   => 'Videos With Sidebar BG',
						'maincontent4'   => 'FullWidth Videos Section',
                        'randomcat'   => 'Random Categories',
                        'movies'   => 'Movies Slider',
                    ),
                ),
            ),
		)
    ) );
	// -> Vertical Slider Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Vertical Slider', 'betube' ),
        'id'               => 'verticalslider',
        'customizer_width' => '500px',
        'icon'             => 'el-icon-video',
		'fields'     => array(
			array(
                'id'       => 'betube-vertical-slider-thumb',
                'type'     => 'button_set',
                'title'    => __( 'First Post Media', 'betube' ),
                'subtitle' => __( 'Video Or Thumbnail', 'betube' ),
                'desc'     => __( 'First Post On Vertical Slider You want show thumbnail or Video', 'betube' ),
                //Must provide key => value pairs for radio options
                'options'  => array(
                    '1' => 'Thumbnail',
                    '2' => 'Video',                   
                ),
                'default'  => '1'
            ),
			array(
				'id' => 'betube-vertical-slider-cat',
				'type' => 'select',
				'data' => 'categories',
				'multi' => true,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Vertical Slider Category', 'betube'),
				'subtitle' => __('Vertical Slider Category', 'betube'), 
				'desc' => __('From Which Category you want to show Post on Vertical Slider', 'betube'),
				'default' => '1'
            ),
			array(
				'id'=>'betube-vertical-slider-count',
				'type' => 'text',
				'title' => __('Number of Posts in Vertical Slider', 'betube'),
				'subtitle' => __('Put a Number For Vertical Slider', 'betube'),
				'desc' => __('How much post you want to shown on Vertical Slider? Put here a number. Example "16"', 'betube'),
				'default' => '10'
			),
			
		)
    ) );
	// -> START Featured carousel Fields
    Redux::setSection( $opt_name, array(
        'title' => __( 'Featured carousel', 'betube' ),
        'id'    => 'featured-carousel',
        'desc'  => __( 'Its Featured carousel Slider Which Is Shown top of page', 'betube' ),
        'icon'  => 'el el-glasses',
		'fields' => array(
		
			array(
				'id' => 'featured-caton',
				'type' => 'switch',
				'title' => __('Featured Category On/OFF', 'betube'),
				'subtitle' => __('Video Shown from Featured Category.', 'betube'),
				'desc' => __('If You will Turn Off this Option then Latest videos from all category will be shown on Carousel Slider', 'betube'),
				'default' => 2,
            ),
			array(
				'id' => 'featured-slider-on',
				'type' => 'switch',
				'title' => __('Featured Video Slider', 'betube'),
				'subtitle' => __('Turn On/OFF Featured Slider', 'betube'),
				'desc' => __('If You dont want to use featured slider you can turn off from here, it will be hide from only category page, and All post page, For homepage template you need to follow Landing page settings.', 'betube'),
				'default' => 1,
            ),
			array(
				'id' => 'featured-cat',
				'type' => 'select',				
				'data' => 'categories',
				'multi' => true,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Featured Category', 'betube'),
				'subtitle' => __('Featured Category', 'betube'), 
				'desc' => __('Select A Category from Which Category you want to show Post on Featured Carousel', 'betube'),
				'default' => 1,
            ),
			array(
				'id'=>'featured-counter',
				'type' => 'select',
				'title' => __('Featured Video Count', 'betube'),
				'subtitle' => __('How many Featured Video You want to show?', 'betube'),
				'desc' => __('How Many Videos you want to shown on Carousel Slider?', 'betube'),
				'options' => array('3' => '3', '6' => '6', '9' => '9', '12' => '12', '15' => '15', '18' => '18'),
				'default' => '9'
			),
			array(
				'id' => 'betube-cara-slider-category',
				'type' => 'select',
				'data' => 'categories',
				'multi' => true,
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'title' => __('Home Big Carousel Slider', 'betube'),
				'subtitle' => __('Select Category for Carousel Slider', 'betube'), 
				'desc' => __('Please select a Category for Homepage Big Carousel Slider', 'betube'),
				'default' => 1,
            ),
			array(
				'id'=>'betube-cara-slider-count',
				'type' => 'text',
				'title' => __('Number of Posts in Carousel Slider', 'betube'),
				'subtitle' => __('Put a Number For Homepage Slider', 'betube'),
				'desc' => __('Put here a number. Example "16"', 'betube'),
				'default' => '10'
			),
			
			
		 )
    ) );
	// -> Home Section
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Single Video', 'betube' ),
        'id'               => 'submitvideo',
        'customizer_width' => '500px',
        'icon'             => 'el-icon-video',
		'fields'     => array(			
			array(
				'id' => 'betube-tags-on',
				'type' => 'switch',
				'title' => __('Tags Option On/OFF', 'betube'),
				'subtitle' => __('Turn On/OFF', 'betube'),
				'desc' => __('Turn On this Option Tags input while posting new video', 'betube'),
				'default' => 1,
            ),
			array(
				'id' => 'betube-floting-video',
				'type' => 'switch',
				'title' => __('Scrolling Video', 'betube'),
				'subtitle' => __('Turn On/OFF', 'betube'),
				'desc' => __('One Small Box shown when you scroll page on single video page, If you want to turn off that then please turn of this option', 'betube'),
				'default' => 1,
            ),
			array(
				'id' => 'betube-plugin-adv',
				'type' => 'switch',
				'title' => __('Video Plugin Ads', 'betube'),
				'subtitle' => __('Turn On/OFF', 'betube'),
				'desc' => __('If You dont want to run ads from plugin then just turn off this option.', 'betube'),
				'default' => 1,
            ),
			array(
				'id' => 'betube-post-moderation-on',
				'type' => 'switch',
				'title' => __('Post Moderation On/OFF', 'betube'),
				'subtitle' => __('Turn On/OFF', 'betube'),
				'desc' => __('If you will turn on Post moderation then all new post will be goes on pending status', 'betube'),
				'default' => 2,
            ),
			array(
				'id' => 'betube-multi-player',
				'type' => 'switch',
				'title' => __('Post Multi Player On/OFF', 'betube'),
				'subtitle' => __('Turn On/OFF', 'betube'),
				'desc' => __('If you want to show Multi Player on Sigle Post then Turn OFF this Option. If you will turn on then you can post 3 video, and it will be shown in tabber.', 'betube'),
				'default' => '2'
            ),
			array(
				'id' => 'betube-custom-uploading',
				'type' => 'switch',
				'title' => __('Allow User To Upload Video File', 'betube'),
				'subtitle' => __('Turn On/OFF', 'betube'),
				'desc' => __('If you will turn ON this option then user can upload mp4 video and also can upload images. If you dont want to allow m94 video then user can onlu post video link from YouTube, Vimeo etc.', 'betube'),
				'default' => '2'
            ),
			array(
				'id' => 'betube_social_share_btn',
				'type' => 'switch',
				'title' => __('Social Share Button', 'betube'),
				'subtitle' => __('Turn On/OFF', 'betube'),
				'desc' => __('If you dont want to use betube share button then turn off this and use share plugin.', 'betube'),
				'default' => 1,
            ),
			array(
				'id'=>'betube-default-player',
				'type' => 'radio',
				'title' => __('Select Default Player', 'betube'), 
				'subtitle' => __('flowplayer, MediaElement', 'betube'),
				'desc' => __('Select Default Player For Custom Upload Video', 'betube'),				
				'options'  => array(
                    '1' => 'WordPress Player',
                    '2' => 'Flowplayer',                    
                ),
				'default' => '2',
			),			
			array(
                'id'       => 'betube-single-video-layout',
                'type'     => 'radio',
                'title'    => __( 'Select Single Post Layout', 'betube' ),
                'subtitle' => __( 'FullWidth, Small Player, Color BG Sidebar', 'betube' ),
                'desc'     => __( 'Select Single Post Layout(FullWidth, Small Player, Small Player with Color Background Sidebar) ', 'betube' ),
                'multi'    => true,
                //Must provide key => value pairs for radio options
                'options'  => array(
                    '1' => 'FullWidth',
                    '2' => 'Small Player',
                    '3' => 'Small Player Color BG Sidebar'
                ),
                'default'  => '2',
            ),
			array(
				'id'=>'betube_related_video_count',
				'type' => 'text',
				'title' => __('How Many Related Videos', 'betube'),
				'subtitle' => __('Related Videos Count on single video Page', 'betube'),
				'desc' => __('How Many Related Videos you want to shown on single video page Put a number', 'betube'),
				'default' => '3'
			),
		)
    ) );
	// -> START Editors
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Pages', 'betube' ),
        'id'               => 'pages',
        'customizer_width' => '500px',
        'icon'             => 'el-icon-website',
		'fields'     => array(
			array(
			'id'=>'login',
			'type' => 'text',
			'title' => __('Login Page URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Login Page URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
			array(
			'id'=>'register',
			'type' => 'text',
			'title' => __('Register Page URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Register Page URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
		array(
			'id'=>'profile',
			'type' => 'text',
			'title' => __('Profile Page URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Profile Page URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),	

		array(
			'id'=>'edit-profile',
			'type' => 'text',
			'title' => __('Edit Profile Page URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Edit Profile Page URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),	


		array(
			'id'=>'new_post',
			'type' => 'text',
			'title' => __('Upload Video Page URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Upload Video Page URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),

		array(
			'id'=>'edit_post',
			'type' => 'text',
			'title' => __('Edit Video Page URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Edit Video Page URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
		array(
			'id'=>'all-cat-page-link',
			'type' => 'text',
			'title' => __('All Categories Page URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('All Categories Page URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
		array(
			'id'=>'all-video-page-link',
			'type' => 'text',
			'title' => __('All Videos URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('All Video On Website', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
		array(
			'id'=>'all-video-single-user',
			'type' => 'text',
			'title' => __('Single User All Ads', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Single User Account Page All Ads URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
		array(
			'id'=>'all-favourite',
			'type' => 'text',
			'title' => __('Single User All Favourite', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Single User Account Page All Favourite Ads URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
		array(
			'id'=>'all-followers',
			'type' => 'text',
			'title' => __('Single User All Followers', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Single User Account Page All Followers URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),	
		array(
			'id'=>'reset',
			'type' => 'text',
			'title' => __('Reset Password Page URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('Reset Password Page URL', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
			array(
			'id'=>'termsandcondition',
			'type' => 'text',
			'title' => __('Terms And Conditions URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('This Link will be shown at registration page', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
			array(
			'id'=>'all-favourite',
			'type' => 'text',
			'title' => __('Favourite URL', 'betube'),
			'subtitle' => __('This must be an URL.', 'betube'),
			'desc' => __('This Link will be shown all favourite posts', 'betube'),
			'validate' => 'url',
			'default' => ''
			),
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Advertisements', 'betube' ),
        'id'               => 'advertisements',        
        'customizer_width' => '500px',
        'desc'             => __('Please Paste your complete code.', 'betube'),
        'fields'           => array(
			array(
				'id'=>'betube-google-ads-for-blog',
				'type' => 'textarea',
				'title' => __('Ads Code for Blog page', 'betube'),
				'subtitle' => __('Put Ads Code here', 'betube'),
				'desc' => __('Put your Ads Code for Blog page', 'betube'),
				'default' => ''
			),
			array(
				'id'=>'betube-google-ads-for-category-page',
				'type' => 'textarea',
				'title' => __('Ads Code for Category page', 'betube'),
				'subtitle' => __('Put Ads Code here', 'betube'),
				'desc' => __('Put your Ads Code for Category page', 'betube'),
				'default' => ''
			),
			array(
				'id'=>'betube-google-ads-for-all-video-page',
				'type' => 'textarea',
				'title' => __('Ads Code for All Videos Page', 'betube'),
				'subtitle' => __('Put Ads Code here', 'betube'),
				'desc' => __('Put your Ads Code for All Videos Page', 'betube'),
				'default' => ''
			),
			array(
				'id'=>'betube-google-ads-header-v6',
				'type' => 'textarea',
				'title' => __('Ads Code for Header V6', 'betube'),
				'subtitle' => __('Put Ads Code here', 'betube'),
				'desc' => __('Put your Ads Code for Header V6', 'betube'),
				'default' => ''
			),
		)
    ) );
	// -> START Blog Section
    Redux::setSection( $opt_name, array(
        'title'            => __('Boxed Ads', 'betube'),
        'id'               => 'homepageboxedads',
		'subsection'       => true,
		'desc'  => __( 'These Ads will be work on boxed layout', 'betube' ),
        'customizer_width' => '500px',
        'icon'             => 'el el-list-alt',
		'fields'     => array(
			array(
				'id'=>'betube-google-adv-boxed-v1',
				'type' => 'textarea',
				'title' => __('Ads Code for boxed layout left', 'betube'),
				'subtitle' => __('Put Ads Code here', 'betube'),
				'desc' => __('Put your Ads Code for boxed layout left', 'betube'),
				'default' => ''
			),
			array(
				'id'=>'betube-google-adv-boxed-v2',
				'type' => 'textarea',
				'title' => __('Ads Code for boxed layout right', 'betube'),
				'subtitle' => __('Put Ads Code here', 'betube'),
				'desc' => __('Put your Ads Code for boxed layout right', 'betube'),
				'default' => ''
			),
		)
    ) );	
	// -> START Social Links
    Redux::setSection( $opt_name, array(
        'title' => __( 'Social Links', 'betube' ),
        'id'    => 'social-links',
        'desc'  => __( 'Put Social Links Here', 'betube' ),
        'icon'  => 'el el-glasses',
		'fields' => array(
			array(
				'id'=>'facebook-link',
				'type' => 'text',
				'title' => __('Facebook Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Facebook Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'twitter-link',
				'type' => 'text',
				'title' => __('Twitter Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Twitter Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'dribbble-link',
				'type' => 'text',
				'title' => __('Dribbble Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Dribbble Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'flickr-link',
				'type' => 'text',
				'title' => __('Flickr Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Flickr Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'github-link',
				'type' => 'text',
				'title' => __('Github Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Github Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'pinterest-link',
				'type' => 'text',
				'title' => __('Pinterest Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Pinterest Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'youtube-link',
				'type' => 'text',
				'title' => __('Youtube Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Youtube Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'google-plus-link',
				'type' => 'text',
				'title' => __('Google+ Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Google+ Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'linkedin-link',
				'type' => 'text',
				'title' => __('LinkedIn Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('LinkedIn Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'instagram-link',
				'type' => 'text',
				'title' => __('Instagram Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Instagram Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'vimeo-link',
				'type' => 'text',
				'title' => __('Vimeo Page URL', 'betube'),
				'subtitle' => __('This must be an URL.', 'betube'),
				'desc' => __('Vimeo Page URL', 'betube'),
				'validate' => 'url',
				'default' => ''
			),
		)
    ) );
	// -> START Twitter
    Redux::setSection( $opt_name, array(
        'title' => __( 'Twitter Api', 'betube' ),
        'id'    => 'twitterapi',
        'desc'  => __( 'Put Twitter Api info', 'betube' ),
        'icon'  => 'el-icon-twitter',
		'fields' => array(
			array(
			'id'=>'twitter_user_name',
			'type' => 'text',
			'title' => __('Twitter User', 'betube'),
			'subtitle' => __('Twitter User', 'betube'),
			'desc' => __('Put Your twitter Username', 'betube'),
			'default' => 'joinwebs'
			),			
			array(
			'id'=>'consumer_key',
			'type' => 'text',
			'title' => __('Consumer Key', 'betube'),
			'subtitle' => __('Consumer Key', 'betube'),
			'desc' => __('Consumer Key', 'betube'),
			'default' => ''
			),

		array(
			'id'=>'consumer_secret',
			'type' => 'text',
			'title' => __('Consumer Secret', 'betube'),
			'subtitle' => __('Consumer Secret', 'betube'),
			'desc' => __('Consumer Secret', 'betube'),
			'default' => ''
			),

		array(
			'id'=>'access_token',
			'type' => 'text',
			'title' => __('User Access Token', 'betube'),
			'subtitle' => __('User Access Token', 'betube'),
			'desc' => __('User Access Token', 'betube'),
			'default' => ''
			),

		array(
			'id'=>'access_token_secret',
			'type' => 'text',
			'title' => __('User Access Token Secret', 'betube'),
			'subtitle' => __('User Access Token Secret', 'betube'),
			'desc' => __('User Access Token Secret', 'betube'),
			'default' => ''
			),
		)
    ) );
	// -> START Twitter
	Redux::setSection( $opt_name, array(
        'title' => __( 'Facebook Settings', 'betube' ),
        'icon'  => 'el el-facebook',
        'id'    => 'facebook-section',
        'desc'  => __( 'Facebook Settings', 'betube' ),        
        'fields' => array(
			array(
				'id' => 'betube-facebook-meta-on',
				'type' => 'switch',
				'title' => __('Facebook Meta', 'betube'),
				'subtitle' => __('Turn Map On/OFF Facebook Meta', 'betube'),
				'default' => 1,
			),			
			array(
				'id'=>'betubefbappid',
				'type' => 'text',
				'title' => __('Facebook APP ID', 'betube'),
				'subtitle' => __('Facebook APP ID', 'betube'),
				'desc' => __('Facebook APP ID', 'betube'),
				'default' => ''
			),
			array(
				'id'=>'betube-play-on-facebook',
				'type' => 'switch',
				'title' => __('Play On Facebook', 'betube'),
				'subtitle' => __('Play On Facebook', 'betube'),
				'desc' => __('Would you like to play video on facebook?', 'betube'),
				'default' => 1,
			),
			array(
				'id'=>'betube-facebook-comment',
				'type' => 'switch',
				'title' => __('Facebook Comments', 'betube'),
				'subtitle' => __('Turn On/OFF Facebook Comments', 'betube'),
				'desc' => __('If you want to use Facebook Comments then you must need to Put Facebook APP ID in above field.', 'betube'),
				'default' => 2,
			),
		)
    ) );
	// -> START Contact Page
	Redux::setSection( $opt_name, array(
        'title' => __( 'Contact Page', 'betube' ),
        'icon'  => 'el el-envelope',
        'id'    => 'contact-page',
        'desc'  => __( 'Contact Page Settings', 'betube' ),        
        'fields' => array(
			array(
				'id' => 'contact-map',
				'type' => 'switch',
				'title' => __('Map On Contact Page', 'betube'),
				'subtitle' => __('Turn Map On/OFF from Contact Page', 'betube'),
				'default' => 1,
			),
			array(
			'id'=>'contact-email',
			'type' => 'text',
			'title' => __('Your email address', 'betube'),
			'subtitle' => __('This must be an email address.', 'betube'),
			'desc' => __('Your email address', 'betube'),
			'validate' => 'email',
			'default' => ''
			),

		array(
			'id'=>'contact-email-error',
			'type' => 'text',
			'title' => __('Email error message', 'betube'),
			'subtitle' => __('Email error message', 'betube'),
			'desc' => __('Email error message', 'betube'),
			'default' => 'You entered an invalid email.'
			),

		array(
			'id'=>'contact-name-error',
			'type' => 'text',
			'title' => __('Name error message', 'betube'),
			'subtitle' => __('Name error message', 'betube'),
			'desc' => __('Name error message', 'betube'),
			'default' => 'You forgot to enter your name.'
			),

		array(
			'id'=>'contact-message-error',
			'type' => 'text',
			'title' => __('Message error', 'betube'),
			'subtitle' => __('Message error', 'betube'),
			'desc' => __('Message error', 'betube'),
			'default' => 'You forgot to enter your message.'
			),

		array(
			'id'=>'contact-thankyou-message',
			'type' => 'text',
			'title' => __('Thank you message', 'betube'),
			'subtitle' => __('Thank you message', 'betube'),
			'desc' => __('Thank you message', 'betube'),
			'default' => 'Thank you! We will get back to you as soon as possible.'
			),
		array(
			'id'=>'betube_google_api',
			'type' => 'text',
			'title' => __('Google API Key', 'betube'),
			'subtitle' => __('Google API Key', 'betube'),
			'desc' => __('Put Google API Key here to run Google MAP. If you dont know how to get API key Please Visit  <a href="http://www.tthemes.com/get-google-api-key/" target="_blank">Google API Key</a>', 'betube'),
			'default' => ''
			),	

		array(
			'id'=>'contact-latitude',
			'type' => 'text',
			'title' => __('Latitude', 'betube'),
			'subtitle' => __('Latitude', 'betube'),
			'desc' => __('Latitude', 'betube'),
			'default' => '31.516370'
			),

		array(
			'id'=>'contact-longitude',
			'type' => 'text',
			'title' => __('Longitude', 'betube'),
			'subtitle' => __('Longitude', 'betube'),
			'desc' => __('Longitude', 'betube'),
			'default' => '74.258727'
			),

		array(
			'id'=>'contact-zoom',
			'type' => 'text',
			'title' => __('Zoom level', 'betube'),
			'subtitle' => __('Zoom level', 'betube'),
			'desc' => __('Zoom level', 'betube'),
			'default' => '16'
			),
		array(
			'id'=>'betube-contact-title',
			'type' => 'text',
			'title' => __('Map Title', 'betube'),
			'subtitle' => __('Put Map Title', 'betube'),
			'desc' => __('This will be shown on MAP Title', 'betube'),
			'default' => 'JoinWebs'
			),
		array(
			'id'=>'betube-contact-address',
			'type' => 'text',
			'title' => __('Map Address', 'betube'),
			'subtitle' => __('Put Map Address', 'betube'),
			'desc' => __('This will be shown on MAP (Like: Lahore Pakistan)', 'betube'),
			'default' => 'Lahore, Pakistan'
			),
		array(
			'id'=>'contact-description',
			'type' => 'textarea',
			'title' => __('Contact Page Small Description', 'betube'),
			'subtitle' => __('Small Description', 'betube'),
			'desc' => __('Small Description', 'betube'),
			'default' => 'Semper ac dolor vitae accumsan. Cras interdum hendrerit lacinia.Phasellusaccumsan urna vitae molestie interdum. Nam sed placerat libero, non eleifend dolor.'
			),	
		array(
			'id'=>'contact-address',
			'type' => 'text',
			'title' => __('Contact Page Address', 'betube'),
			'subtitle' => __('Contact Page Address', 'betube'),
			'desc' => __('Contact Page Address', 'betube'),
			'default' => 'Our business address is 1063 Freelon Street San Francisco, CA 95108'
			),	
		array(
			'id'=>'contact-phone',
			'type' => 'text',
			'title' => __('Contact Page Phone', 'betube'),
			'subtitle' => __('Contact Page Phone', 'betube'),
			'desc' => __('Contact Page Phone', 'betube'),
			'default' => '021.343.7575'
			),	
		array(
			'id'=>'contact-fax',
			'type' => 'text',
			'title' => __('Contact Page Fax No', 'betube'),
			'subtitle' => __('Contact Page Fax No', 'betube'),
			'desc' => __('Contact Page Fax No', 'betube'),
			'default' => '021.343.7576'
			),
		)
    ) );

    // -> START Color Selection
    Redux::setSection( $opt_name, array(
        'title' => __( 'Color Selection', 'betube' ),
        'id'    => 'color',
        'desc'  => __( 'Select Your Theme Color', 'betube' ),
        'icon'  => 'el el-brush',
		'fields'     => array(
            array(
                'id'       => 'betube-color-title',
                'type'     => 'color',                
                'title'    => __( 'Site Title Color', 'betube' ),
                'subtitle' => __( 'Pick a title color for the Browser bar for Mobile Only (default: #444).', 'betube' ),
				'desc'     => __( 'This Color will work for (meta tage: theme-color), its supported in Android Chrome', 'betube' ),
                'default'  => '#444',
				'validate' => 'color',
            ),
			array(
                'id'       => 'betube_body_color',
                'type'     => 'color',                
                'title'    => __( 'Body background', 'betube' ),
                'subtitle' => __( 'Pick a color for body background (default: #f0f0f0).', 'betube' ),
				'desc'     => __( 'This will work for body background', 'betube' ),
                'default'  => '#f0f0f0',
				'validate' => 'color',
            ),
            array(
                'id'       => 'betube-primary-color',
                'type'     => 'color',
                'title'    => __( 'Primary Color', 'betube' ),
                'subtitle' => __( 'Pick a Primary color (default: #e96969).', 'betube' ),
                'default'  => '#e96969',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-secondary-color',
                'type'     => 'color',
                'title'    => __( 'Secondary Color', 'betube' ),
                'subtitle' => __( 'Pick a Secondary color (default: #444).', 'betube' ),
                'default'  => '#444',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-breadcrumb-bg',
                'type'     => 'color',
                'title'    => __( 'Breadcrumb Background', 'betube' ),
                'subtitle' => __( 'Pick a Color for Breadcrumb Background (default: #444).', 'betube' ),
                'default'  => '#444',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-breadcrumb-txt-color',
                'type'     => 'color',
                'title'    => __( 'Breadcrumb Text Color', 'betube' ),
                'subtitle' => __( 'Pick a Color Breadcrumb Text Color (default: #aaaaaa).', 'betube' ),
                'default'  => '#aaaaaa',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-vertical-slider-bg',
                'type'     => 'color',
                'title'    => __( 'Vertical Slider BG', 'betube' ),
                'subtitle' => __( 'Pick a Color Vertical Slider Background (default: #303030).', 'betube' ),
                'default'  => '#303030',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-sidebar-color',
                'type'     => 'color',
                'title'    => __( 'Sidebar V2 BG', 'betube' ),
                'subtitle' => __( 'Pick a Color Sidebar V2 Background (default: #f6f6f6 ).', 'betube' ),
                'default'  => '#f6f6f6',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-footer-bg-color',
                'type'     => 'color',
                'title'    => __( 'Footer Background', 'betube' ),
                'subtitle' => __( 'Pick a Color for Footer Background (default: #444 ).', 'betube' ),
                'default'  => '#444',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-footer-heading-color',
                'type'     => 'color',
                'title'    => __( 'Footer Heading Color', 'betube' ),
                'subtitle' => __( 'Pick a Color for Footer Heading (default: #ececec ).', 'betube' ),
                'default'  => '#ececec',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-footer-text-color',
                'type'     => 'color',
                'title'    => __( 'Footer Text Color', 'betube' ),
                'subtitle' => __( 'Pick a Color for Footer Text (default: #aaaaaa ).', 'betube' ),
                'default'  => '#aaaaaa',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-footer-tag-bg',
                'type'     => 'color',
                'title'    => __( 'Footer Tag Background', 'betube' ),
                'subtitle' => __( 'Pick a Color for Footer Tag BG (default: #6c6c6c ).', 'betube' ),
				'desc'     => __( 'If you are using Tag Widget in Footer then you can select BG from here.', 'betube' ),
                'default'  => '#6c6c6c',
                'validate' => 'color',
            ),
			array(
                'id'       => 'betube-footer-bottom-bg',
                'type'     => 'color',
                'title'    => __( 'Footer Bottom Background', 'betube' ),
                'subtitle' => __( 'Pick a Color for Footer Bottom BG (default: #2e2e2e ).', 'betube' ),				
                'default'  => '#2e2e2e',
                'validate' => 'color',
            ),
        )
    ) );
    // -> START Typography
    Redux::setSection( $opt_name, array(
        'title'  => __( 'Typography', 'betube' ),
        'id'     => 'typography',
        'desc'   => __( 'For full documentation on this field, visit: ', 'betube' ) . '<a href="http://beetube.me/docs" target="_blank">BeTube Documentation</a>',
        'icon'   => 'el el-font',
        'fields' => array(
            array(
                'id'       => 'body-font',
                'type'     => 'typography',
                'title'    => __( 'Body Font', 'betube' ),
                'subtitle' => __( 'Specify the body font properties.', 'betube' ),
                'google'   => true,
				'output' => array('body'),
                'default'  => array(
                    'color'       => '#8e8e8e',
                    'font-size'   => '13px',
                    'font-family' => 'Open Sans',
                    'font-weight' => 'Normal',
					'line-height' => '24px'
                ),
            ), 
			array(
                'id'       => 'heding1-font',
                'type'     => 'typography',
                'title'    => __( 'Heading H1 Font', 'betube' ),
                'subtitle' => __( 'Specify the H1 font properties.', 'betube' ),
                'google'   => true,
				'output' => array('h1'),
                'default'  => array(
                    'color'       => '#444',
                    'font-size'   => '36px',
                    'font-family' => 'Open Sans',
                    'font-weight' => '700',
					'line-height' => '36px'
                ),
            ),
			array(
                'id'       => 'heding2-font',
                'type'     => 'typography',
                'title'    => __( 'Heading H2 Font', 'betube' ),
                'subtitle' => __( 'Specify the H2 font properties.', 'betube' ),
                'google'   => true,
				'output' => array('h2'),
                'default'  => array(
                    'color'       => '#444',
                    'font-size'   => '30px',
                    'font-family' => 'Open Sans',
                    'font-weight' => '700',
					'line-height' => '30px'
                ),
            ),
			array(
                'id'       => 'heding3-font',
                'type'     => 'typography',
                'title'    => __( 'Heading H3 Font', 'betube' ),
                'subtitle' => __( 'Specify the H3 font properties.', 'betube' ),
                'google'   => true,
				'output' => array('h3'),
                'default'  => array(
                    'color'       => '#444',
                    'font-size'   => '24px',
                    'font-family' => 'Open Sans',
                    'font-weight' => '700',
					'line-height' => '24px'
                ),
            ),
			array(
                'id'       => 'heding4-font',
                'type'     => 'typography',
                'title'    => __( 'Heading H4 Font', 'betube' ),
                'subtitle' => __( 'Specify the H4 font properties.', 'betube' ),
                'google'   => true,
				'output' => array('h4'),
                'default'  => array(
                    'color'       => '#444',
                    'font-size'   => '18px',
                    'font-family' => 'Open Sans',
                    'font-weight' => '700',
					'line-height' => '18px'
                ),
            ),
			array(
                'id'       => 'heding5-font',
                'type'     => 'typography',
                'title'    => __( 'Heading H5 Font', 'betube' ),
                'subtitle' => __( 'Specify the H5 font properties.', 'betube' ),
                'google'   => true,
				'output' => array('h5'),
                'default'  => array(
                    'color'       => '#444',
                    'font-size'   => '16px',
                    'font-family' => 'Open Sans',
                    'font-weight' => '700',
					'line-height' => '16px'
                ),
            ),
			array(
                'id'       => 'heding6-font',
                'type'     => 'typography',
                'title'    => __( 'Heading H6 Font', 'betube' ),
                'subtitle' => __( 'Specify the H6 font properties.', 'betube' ),
                'google'   => true,
				'output' => array('h6'),
                'default'  => array(
                    'color'       => '#444',
                    'font-size'   => '14px',
                    'font-family' => 'Open Sans',
                    'font-weight' => '700',
					'line-height' => '14px'
                ),
            ),
        )
    ) );
   
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'betube' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'betube' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

