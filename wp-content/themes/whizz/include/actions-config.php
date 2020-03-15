<?php
/**
 * The template for requried actions hooks.
 *
 * @package whizz
 * @since 1.0
 */

add_action( 'wp_enqueue_scripts', 'whizz_enqueue_scripts' );
add_action( 'widgets_init', 'whizz_register_widgets' );
add_action( 'tgmpa_register', 'whizz_include_required_plugins' );
add_action( 'admin_enqueue_scripts', 'whizz_custom_wp_admin_scripts' );

define( 'CS_ACTIVE_FRAMEWORK', true );
define( 'CS_ACTIVE_METABOX', true );
define( 'CS_ACTIVE_TAXONOMY', true );
define( 'CS_ACTIVE_SHORTCODE', false );
define( 'CS_ACTIVE_CUSTOMIZE', false );

/*
 * Register sidebar.
 */
if ( ! function_exists( 'whizz_register_widgets' ) ) {
	function whizz_register_widgets() {
		// register sidebars
		register_sidebar(
			array(
				'id'            => 'sidebar',
				'name'          => esc_attr__( 'Sidebar', 'whizz' ),
				'before_widget' => '<div id="%1$s" class="sidebar-item %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5>',
				'after_title'   => '</h5>',
				'description'   => esc_attr__( 'Drag the widgets for sidebars.', 'whizz' )
			)
		);

		register_sidebar(
			array(
				'id'            => 'shop_sidebar',
				'name'          => esc_attr__( 'Shop Sidebar', 'whizz' ),
				'before_widget' => '<div id="%1$s" class="sidebar-item %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5>',
				'after_title'   => '</h5>',
				'description'   => esc_attr__( 'Drag the widgets for sidebars.', 'whizz' )
			)
		);

		register_sidebar(
			array(
				'id'            => 'footer_sidebar',
				'name'          => esc_attr__( 'Footer Sidebar', 'whizz' ),
				'before_widget' => '<div id="%1$s" class="sidebar-item col-md-4 %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5>',
				'after_title'   => '</h5>',
				'description'   => esc_attr__( 'Drag the widgets for sidebars.', 'whizz' )
			)
		);

		register_sidebar(
			array(
				'id'            => 'modern_sidebar',
				'name'          => esc_attr__( 'Modern Page Sidebar', 'whizz' ),
				'before_widget' => '<div id="%1$s" class="sidebar-item %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5>',
				'after_title'   => '</h5>',
				'description'   => esc_attr__( 'Drag the widgets for sidebars.', 'whizz' )
			)
		);

	}
}

/**
 * @ return null
 * @ param none
 * @ loads all the js and css script to frontend
 **/
if ( ! function_exists( 'whizz_enqueue_scripts' ) ) {
	function whizz_enqueue_scripts() {
		global $post;

		$post_id = !empty($post->ID) ? $post->ID : '';
		// whizz options

		// general settings
		if ( ( is_admin() ) ) {
			return;
		}


        wp_enqueue_script( 'modernizr', WHIZZ_T_URI . '/assets/js/lib/modernizr-2.6.2.min.js', array( 'jquery' ), '', false );
		wp_enqueue_script( 'whizz_scripts', WHIZZ_T_URI . '/assets/js/lib/scripts.js', array( 'jquery' ), '',false );
		wp_enqueue_script( 'anime', WHIZZ_T_URI . '/assets/js/anime.min.js', array( 'jquery' ), '',false );
		wp_enqueue_script( 'countdown', WHIZZ_T_URI . '/assets/js/jquery.countdown.min.js', '', '', true );
		wp_enqueue_script( 'swiper', WHIZZ_T_URI . '/assets/js/lib/idangerous.swiper.min_.js', array( 'jquery' ),'', true );
		wp_enqueue_script( 'flipster', WHIZZ_T_URI . '/assets/js/jquery.flipster.min.js', array( 'jquery' ),'', true );
		wp_enqueue_script( 'whizz_foxlazy', WHIZZ_T_URI . '/assets/js/foxlazy.min.js', array( 'jquery' ),'', true );
		wp_enqueue_script( 'easings', WHIZZ_T_URI . '/assets/js/jquery.easings.min.js','','', true );
		wp_enqueue_script( 'multiscroll', WHIZZ_T_URI . '/assets/js/jquery.multiscroll.min.js','','', true );

		wp_enqueue_script( 'cloudflare', '//cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js','',  '',  true );
		wp_enqueue_script( 'kenburning', WHIZZ_T_URI . '/assets/js/kenburning.min.js', array( 'jquery' ), '',  true );
		wp_enqueue_script( 'equalHeightsPlugin', WHIZZ_T_URI . '/assets/js/equalHeightsPlugin.min.js', array( 'jquery' ), '',  true );
		wp_enqueue_script( 'fancybox', WHIZZ_T_URI . '/assets/js/jquery.fancybox.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'fitvids', WHIZZ_T_URI . '/assets/js/jquery.fitvids.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'zepto', WHIZZ_T_URI . '/assets/js/zepto.min.js', array( 'jquery' ), '',true );
		wp_enqueue_script( 'swiper3', WHIZZ_T_URI . '/assets/js/swiper3.min.js', array( 'jquery' ),'', true );
		wp_enqueue_script( 'imagesloaded', WHIZZ_T_URI . '/assets/js/imagesloaded.pkgd.min.js', array( 'jquery' ),'', true );
		wp_enqueue_script( 'fragment', WHIZZ_T_URI . '/assets/js/fragment.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'scrollMonitor', WHIZZ_T_URI . '/assets/js/scrollMonitor.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'whizz_slider_transition_init', WHIZZ_T_URI . '/assets/js/slider-transition.min.js', array( 'jquery' ), '', true );

		wp_enqueue_script( 'whizz_youtube', '//www.youtube.com/iframe_api', array(), false, true );


        if( is_page() || is_home()) {
            $post_id = get_queried_object_id();
        } else {
            $post_id = get_the_ID();
        }

        $meta_data = get_post_meta( $post_id, '_custom_page_options', true );
        $menu_main_style = cs_get_option( 'menu_style' );

        if(isset($meta_data['change_menu']) && $meta_data['change_menu'] && isset($meta_data['menu_style'])){
            $menu_main_style = $meta_data['menu_style'];
        }

		if( $menu_main_style == 'static_aside') {
			wp_enqueue_script( 'customScrollbar-js', WHIZZ_T_URI . '/assets/js/jquery.mCustomScrollbar.js', array( 'jquery' ), '', true);
		}

		if( ! function_exists( 'cs_framework_init' )){
			wp_enqueue_script( 'mousewheel', WHIZZ_T_URI . '/assets/lib/js/jquery.mousewheel.min.js', array( 'jquery' ), '', true);
			wp_enqueue_script( 'lightgallery', WHIZZ_T_URI . '/assets/lib/js/lightgallery.min.js', array( 'jquery' ), '', true );
			wp_enqueue_script( 'justified_gallery', WHIZZ_T_URI . '/assets/lib/js/jquery.justifiedGallery.min.js', array( 'jquery' ), '', true );
		}


		wp_enqueue_script( 'sliphover', WHIZZ_T_URI . '/assets/js/jquery.sliphover.min.js', array( 'jquery' ),'', true );
		wp_enqueue_script( 'thumbnails_popup', WHIZZ_T_URI . '/assets/js/lib/thumbnails-popup.min.js', array( 'jquery', 'dgwt-jg-lightgallery' ),'', true );
		wp_enqueue_script( 'whizz-pixi', WHIZZ_T_URI . '/assets/js/pixi.min.js', array( 'jquery' ),'', true );
		wp_enqueue_script( 'whizz_main-js', WHIZZ_T_URI . '/assets/js/script.js', array( 'jquery', 'whizz_youtube' ), '',  true );

		// add TinyMCE style
		add_editor_style();

		// including jQuery plugins
		wp_localize_script( 'jquery', 'get',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'siteurl' => get_template_directory_uri(),
			)
		);

		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// register style
		wp_enqueue_style( 'whizz_base_css', WHIZZ_T_URI . '/style.css' );

		wp_enqueue_style( 'animsition', WHIZZ_T_URI . '/assets/css/animsition.min.css' );
		wp_enqueue_style( 'flipster', WHIZZ_T_URI . '/assets/css/jquery.flipster.min.css' );
		wp_enqueue_style( 'bootstrap', WHIZZ_T_URI . '/assets/css/bootstrap.min.css' );
		wp_enqueue_style( 'magnific_popup', WHIZZ_T_URI . '/assets/css/magnific-popup.min.css' );
		wp_enqueue_style( 'animate_css', WHIZZ_T_URI . '/assets/css/animate.min.css' );
		wp_enqueue_style( 'kenburning', WHIZZ_T_URI . '/assets/css/kenburning.min.css' );
		wp_enqueue_style( 'font-awesome-css', WHIZZ_T_URI . '/assets/css/font-awesome.min.css' );
		wp_enqueue_style( 'pe-icon-7-stroke', WHIZZ_T_URI . '/assets/css/pe-icon-7-stroke.css' );
		wp_enqueue_style( 'fancybox', WHIZZ_T_URI . '/assets/css/jquery.fancybox.min.css' );
		wp_enqueue_style( 'swiper3', WHIZZ_T_URI . '/assets/css/swiper3.min.css' );

		if( $menu_main_style == 'static_aside' ) {
			wp_enqueue_style( 'customScrollbar', WHIZZ_T_URI . '/assets/css/mCustomScrollbar.min.css' );
		}
		if( ! function_exists( 'cs_framework_init' )){
			wp_enqueue_style( 'admin_style', WHIZZ_T_URI . '/assets/lib/css/admin-style.css' );
			wp_enqueue_style( 'lightgallery', WHIZZ_T_URI . '/assets/lib/css/lightgallery.min.css' );
			wp_enqueue_style( 'libs_style', WHIZZ_T_URI . '/assets/lib/css/style.min.css' );
		}

		wp_enqueue_style( 'whizz_style-css', WHIZZ_T_URI . '/assets/css/style.min.css' );
		wp_enqueue_style( 'whizz_style-1-part2-css', WHIZZ_T_URI . '/assets/css/style-1-part2.min.css' );
		wp_enqueue_style( 'whizz_style-2-css', WHIZZ_T_URI . '/assets/css/style-2.min.css' );

		wp_enqueue_style( 'whizz_dynamic-css', admin_url( 'admin-ajax.php' ) . '?action=whizz_dynamic_css&post=' . $post_id );

		if ( cs_get_option('enable_style_black') ) {
			wp_enqueue_style( 'whizz_black_css', WHIZZ_T_URI . '/assets/css/black.min.css', '', false );
		}

		/* Add Custom JS */
		$custom_js = cs_get_option( 'custom_js_scripts' );
		if ( $custom_js ) {
			wp_add_inline_script( 'whizz_main-js', wp_specialchars_decode($custom_js, ENT_QUOTES) );
		}

		if ( cs_get_option( 'enable_lazy_load' ) ) {
			wp_localize_script( 'whizz_main-js', 'enable_foxlazy', 'enable' );
		}

		if ( cs_get_option('heading') ) {
			foreach (cs_get_option('heading') as $key => $title) {
				if ( empty( $title['heading_family'] )) continue;
				$font_family = $title['heading_family'];
				if(! empty($font_family['family']) ) { 
					wp_enqueue_style( sanitize_title_with_dashes($font_family['family']), '//fonts.googleapis.com/css?family=' . $font_family['family'] . ':' . $title['heading_family']['variant'].'' );
				}
			}
		}

		// include font family
		if ( function_exists('whizz_include_fonts') ) {
			whizz_include_fonts(
				array(
					'menu_item_family',
					'submenu_item_family',
					'gallery_font_family',
					'all_button_font_family',
					'all_button_font_family',
					'footer_font_family',
					'item_gallery_font_family',
					) // all options name 
			);
		}

	}
}

/**
 * Filter the page title.
 */
if ( ! function_exists( 'whizz_wp_title' ) ) {
	function whizz_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() ) {
			return $title;
		}

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}

		// Add a page number if necessary.
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'whizz' ), max( $paged, $page ) );
		}

		return $title;
	}
}
add_filter( 'wp_title', 'whizz_wp_title', 10, 2 );

/**
 * Include plugins
 **/
if ( ! function_exists( 'whizz_include_required_plugins' ) ) {
	function whizz_include_required_plugins() {

		$plugins = array(
			array(
				'name'               => esc_html__( 'Whizz Plugins', 'whizz' ),
				// The plugin name
				'slug'               => 'whizz-plugins',
				// The plugin slug (typically the folder name)
				'source'             => esc_url( 'http://download-plugins.viewdemo.co/whizz/whizz-plugins.zip' ),
				// The plugin source
				'required'           => true,
				// If false, the plugin is only 'recommended' instead of required
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'version'            => '',
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Whizzy', 'whizz' ),
				// The plugin name
				'slug'               => 'whizzy',
				// The plugin slug (typically the folder name)
				'required'           => true,
				// If false, the plugin is only 'recommended' instead of required
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'version'            => '',
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Visual Composer', 'whizz' ),
				// The plugin name
				'slug'               => 'js_composer',
				// The plugin slug (typically the folder name)
				'source'             => esc_url( 'http://download-plugins.viewdemo.co/premium-plugins/js_composer.zip' ),
				// The plugin source
				'required'           => true,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
            array(
				'name'               => esc_html__( 'Kaswara', 'whizz' ),
				// The plugin name
				'slug'               => 'kaswara',
				// The plugin slug (typically the folder name)
				'source'             => esc_url( 'http://download-plugins.viewdemo.co/premium-plugins/kaswara2.1.zip' ),
				// The plugin source
				'required'           => true,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Booked Appointments', 'whizz' ),
				// The plugin name
				'slug'               => 'booked',
				// The plugin slug (typically the folder name)
				'source'             => esc_url( 'http://download-plugins.viewdemo.co/premium-plugins/booked.zip' ),
				// The plugin source
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Contact Form 7', 'whizz' ),
				// The plugin name
				'slug'               => 'contact-form-7',
				// The plugin slug (typically the folder name)
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__('Gutenberg Blocks Collection', 'whizz'),
				// The plugin name
				'slug'               => 'qodeblock',
				// The plugin slug (typically the folder name)
				'required'           => true,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'WP/LR Sync', 'whizz' ),
				// The plugin name
				'slug'               => 'wplr-sync',
				// The plugin slug (typically the folder name)
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'UpQode Google Maps', 'whizz' ),
				// The plugin name
				'slug'               => 'upqode-google-maps',
				// The plugin slug (typically the folder name)
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
			array(
				'name'               => esc_html__( 'Woocommerce', 'whizz' ),
				// The plugin name
				'slug'               => 'woocommerce',
				// The plugin slug (typically the folder name)
				'required'           => false,
				// If false, the plugin is only 'recommended' instead of required
				'version'            => '',
				// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation'   => false,
				// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false,
				// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url'       => '',
				// If set, overrides default API URL and points to an external URL
			),
		);

		// Change this to your theme text domain, used for internationalising strings

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       => 'whizz',                    // Text domain - likely want to be the same as your theme.
			'default_path' => '',                            // Default absolute path to pre-packaged plugins
			'menu'         => 'tgmpa-install-plugins',    // Menu slug
			'has_notices'  => true,                        // Show admin notices or not
			'is_automatic' => true,                        // Automatically activate plugins after installation or not
			'message'      => '',                            // Message to output right before the plugins table
			'strings'      => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'whizz' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'whizz' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'whizz' ),
				// %1$s = plugin name
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'whizz' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'whizz' ),
				// %1$s = plugin name(s)
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'whizz' ),
				// %1$s = plugin name(s)
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'whizz' ),
				// %1$s = plugin name(s)
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'whizz' ),
				// %1$s = plugin name(s)
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'whizz' ),
				// %1$s = plugin name(s)
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'whizz' ),
				// %1$s = plugin name(s)
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'whizz' ),
				// %1$s = plugin name(s)
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'whizz' ),
				// %1$s = plugin name(s)
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'whizz' ),
				'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'whizz' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'whizz' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'whizz' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'whizz' ),
				// %1$s = dashboard link
				'nag_type'                        => 'updated'
				// Determines admin notice type - can only be 'updated' or 'error'
			)
		);

		tgmpa( $plugins, $config );
	}
}

if ( ! function_exists( 'whizz_password_form' ) ) {
	function whizz_password_form() {
		global $post;
		$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
		$o     = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
  ' . esc_html__( 'ENTER PASSWORD BELOW:', 'whizz' ) . '
  <label for="' . esc_attr( $label ) . '"></label><input placeholder="' . esc_attr__( "Password:", 'whizz' ) . '" name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" maxlength="20" /><input type="submit" name="' . esc_attr__( 'Submit', 'whizz' ) . '" value="' . esc_attr__( 'ACCEPT', 'whizz' ) . '" />
  </form>
  ';

		return $o;
	}
}
add_filter( 'the_password_form', 'whizz_password_form' );

// for woocommerce
add_filter('loop_shop_columns', 'whizz_loop_columns');
if (!function_exists('whizz_loop_columns')) {
	function whizz_loop_columns() {
		if (cs_get_option('products_per_row')) {
			return cs_get_option('products_per_row');
		} else {
			return 4; // 4 products per row
		}
	}
}

/* For Woocommerce */
if (!function_exists('whizz_add_to_cart_fragment')) {
	function whizz_add_to_cart_fragment( $fragments ) {
	
		ob_start();
		$count = WC()->cart->cart_contents_count;
		?> 
		<a class="whizz-shop-icon fa fa-shopping-bag" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart','whizz' ); ?>">
		   <?php  if ( $count > 0 ) { ?>
		        <div class="cart-contents">
		        	<span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
		        </div>
		   <?php } ?>
		</a>
		<?php $fragments['a.whizz-shop-icon'] = ob_get_clean();

		$fragments['div.whizz_mini_cart'] = whizz_mini_cart();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'whizz_add_to_cart_fragment' );

if (!function_exists('whizz_redirect_coming_soon')) {
	function whizz_redirect_coming_soon() {
		if ( cs_get_option('whizz_enable_coming_soon') && cs_get_option('whizz_page_coming_soon') && !is_admin_bar_showing() ) {

			$redirect_permalink = get_permalink( cs_get_option('whizz_page_coming_soon') );
			if ( get_permalink() != $redirect_permalink ){
				wp_redirect( get_permalink( cs_get_option('whizz_page_coming_soon') ) );
				exit();
			}
		}
	}
}
add_action( 'template_redirect', 'whizz_redirect_coming_soon' );


/*
 * Check need minimal requirements (PHP and WordPress version)
 */
if ( version_compare( $GLOBALS['wp_version'], '4.3', '<' ) || version_compare( PHP_VERSION, '5.3', '<' ) ) {
	if ( ! function_exists( 'whizz_requirements_notice' ) ) {
		function whizz_requirements_notice() {
			$message = sprintf( esc_html__( 'Whizz theme needs minimal WordPress version 4.3 and PHP 5.3<br>You are running version WordPress - %s, PHP - %s.<br>Please upgrade need module and try again.', 'whizz' ), $GLOBALS['wp_version'], PHP_VERSION );
			printf( '<div class="notice-warning notice"><p><strong>%s</strong></p></div>', $message );
		}
	}
	add_action( 'admin_notices', 'whizz_requirements_notice' );
}


/*
 * Check need minimal requirements (PHP and WordPress version)
 */
if ( ! function_exists( 'whizz_coming_soon_notice' ) ) {
	function whizz_coming_soon_notice() {
		if ( cs_get_option('whizz_enable_coming_soon') ) {
			?>
			<div class="notice-warning notice">
				<p><strong>
				<?php echo esc_html__( 'Your "Coming Soon" option is enabled now.', 'whizz' );
				?></strong></p></div>
			<?php
		}
	}
}
add_action( 'admin_notices', 'whizz_coming_soon_notice' );


/* Scripts for Modern Page template */
if ( ! function_exists( 'whizz_custom_wp_admin_scripts' ) ) {
	function whizz_custom_wp_admin_scripts() {
		wp_enqueue_script( 'whizz-admin-js', WHIZZ_T_URI . '/assets/js/admin.js', array( 'jquery' ), false, true );
	}
}


// Add backend styles for Gutenberg.
add_action( 'enqueue_block_editor_assets', 'whizz_add_gutenberg_assets' );
if ( ! function_exists( 'whizz_add_gutenberg_assets' ) ) {
	function whizz_add_gutenberg_assets() {
		// Load the theme styles within Gutenberg.
		$blog_type          = cs_get_option( 'blog_single_type' ) ? cs_get_option( 'blog_single_type' ) : 'modern';
        if(! function_exists( 'cs_framework_init' ) || ( function_exists( 'cs_framework_init' ) && $blog_type == 'modern' )){
	        wp_enqueue_style( 'whizz-gutenberg', get_theme_file_uri( '/assets/css/gutenberg-editor-style.min.css' ), false );
        }else{
	        wp_enqueue_style( 'whizz-gutenberg-2', get_theme_file_uri( '/assets/css/gutenberg-editor-style-2.min.css' ), false );
        }


	}
}
