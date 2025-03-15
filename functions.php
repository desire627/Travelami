<?php
use TemPlazaFramework\Functions;
use Advanced_Product\Helper\AP_Helper;
if ( ! class_exists( 'Travelami_Handler' ) ) {
	/**
	 * Main theme class with configuration
	 */
	class Travelami_Handler {
		private static $instance;

		public function __construct() {
			require_once get_template_directory() . '/helpers/helper.php';
			require_once get_template_directory() . '/helpers/theme-functions.php';
			if(class_exists( 'woocommerce' )){
            require_once get_template_directory() . '/helpers/woocommerce/woocommerce-load.php';
            }
			require_once get_template_directory() . '/plugins/class-tgm-plugin-activation.php';
            require_once get_template_directory() . '/helpers/data-install.php';
            require_once get_template_directory() . '/helpers/theme-color.php';
            require get_template_directory() . '/booking/booking.php';
			add_action( 'after_setup_theme', array( $this, 'travelami_setup' ) );
			add_action( 'widgets_init', array( $this, 'travelami_sidebar_registration' ) );
			add_action( 'init', array( $this, 'travelami_register_theme_scripts' ) );
			add_filter( 'widget_title', 'do_shortcode' );
			add_filter( 'wp_nav_menu_items', 'do_shortcode' );
			add_action( 'comment_form_before', array( $this, 'travelami_enqueue_comments_reply' ) );
			add_filter( 'the_password_form', array( $this, 'travelami_password_form' ), 10, 2 );
			add_action( 'tgmpa_register', array ( $this, 'travelami_register_required_plugins' ) );
            add_filter( 'excerpt_more', array ( $this, 'travelami_continue_reading_link_excerpt' ) );
            add_filter( 'the_content_more_link', array( $this, 'travelami_continue_reading_link' ) );
            add_action( 'pre_get_posts', array($this,'travelami_set_posts_per_page_post_type') );

            add_filter('templaza-elements/settings-post-type', array($this, 'travelami_add_post_type'));
            add_filter('templaza-elements-builder/uipost-post-after-content', array($this, 'travelami_post_after_content'), 10, 2);
			get_template_part( 'inc/block-styles' );
			if ( class_exists( 'TemPlazaFramework\TemPlazaFramework' ) ) {
				if (is_admin()) {
					add_action('admin_enqueue_scripts', array($this,'travelami_register_back_end_scripts'));
				}
			}

			if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' ) && !class_exists( 'Redux_Framework_Plugin' ) ) {
				add_action( 'after_setup_theme', array( $this, 'travelami_basic_setup' ) );
				add_action( 'init', array( $this, 'travelami_basic_register_theme_scripts' ) );
			}
		}

		/**
		 * @return Travelami_Handler
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
		function travelami_register_back_end_scripts(){
            wp_enqueue_style(TEMPLAZA_FRAMEWORK_NAME.'__css');
        }

		function travelami_setup() {
			load_theme_textdomain('travelami', get_template_directory() . '/languages');
			add_theme_support( 'templaza-framework' );
            add_theme_support('templaza-post-type', array('our_team','service'));
			add_theme_support('post-formats', array('gallery', 'video', 'audio', 'link', 'quote'));
			add_theme_support('post-thumbnails');
			add_theme_support( 'title-tag' );
			add_theme_support( 'automatic-feed-links' );
			/* // Submit Themeforest
            add_theme_support( 'woocommerce' );
			*/
            add_image_size( 'travelami-500-500', 500, 500, array( 'center', 'center' ) );
			add_theme_support(
			    'html5',
                array(
				    'script',
	                'style',
	                'comment-list',
                )
            );

            add_theme_support(
                'editor-font-sizes',
                array(                    
                    array(
                        'name'      => esc_html__( 'Small', 'travelami' ),
                        'shortName' => esc_html_x( 'S', 'Font size', 'travelami' ),
                        'size'      => 14,
                        'slug'      => 'small',
                    ),
                    array(
                        'name'      => esc_html__( 'Normal', 'travelami' ),
                        'shortName' => esc_html_x( 'M', 'Font size', 'travelami' ),
                        'size'      => 16,
                        'slug'      => 'normal',
                    ),
                    array(
                        'name'      => esc_html__( 'Large', 'travelami' ),
                        'shortName' => esc_html_x( 'L', 'Font size', 'travelami' ),
                        'size'      => 24,
                        'slug'      => 'large',
                    ),
                    array(
                        'name'      => esc_html__( 'Extra large', 'travelami' ),
                        'shortName' => esc_html_x( 'XL', 'Font size', 'travelami' ),
                        'size'      => 40,
                        'slug'      => 'extra-large',
                    ),
                )
            );

            
			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
			// Add support for responsive embedded content.
			add_theme_support( 'responsive-embeds' );

			// Add support for custom line height controls.
			add_theme_support( 'custom-line-height' );

			// Add support for experimental link color control.
			add_theme_support( 'experimental-link-color' );

			// Add support for experimental cover block spacing.
			add_theme_support( 'custom-spacing' );
			add_theme_support( 'widgets-block-editor' );

			// Add support for custom units.
			// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
			add_theme_support( 'custom-units' );

			add_theme_support( 'wp-block-styles' );
			add_theme_support( 'editor-styles' );
			add_editor_style( array( 'assets/css/style-editor.css', travelami_basic_fonts_url()) );
		}
        function travelami_add_post_type( $post_type ) {
            return array_merge( $post_type, array(
                'our_team' => esc_html__('Our Team', 'travelami'),
                'service' => esc_html__('Services', 'travelami')
            ));
        }
        function travelami_post_after_content ($content, $item) {
            return $content.apply_filters('templaza_service_book',$item);
        }
		function travelami_sidebar_registration() {
			register_sidebar(
				array(
					'name'        => esc_html__( 'Main Sidebar', 'travelami' ),
					'id'          => 'sidebar-main',
					'description' => esc_html__( 'Widgets in this area will be displayed in the TemPlaza Framework layout builder sidebar only.', 'travelami' ),
				)
			);
			register_sidebar(
				array(
					'name'        => esc_html__( 'Shop Sidebar', 'travelami' ),
					'id'          => 'sidebar-shop',
					'description' => esc_html__( 'Widgets in this area will be displayed in the Shop page.', 'travelami' ),
				)
			);
			register_sidebar(
				array(
					'name'        => esc_html__( 'Top Sidebar', 'travelami' ),
					'id'          => 'sidebar-top',
					'description' => esc_html__( 'Widgets in this area will be displayed in the first column in the top sidebar.', 'travelami' ),
				)
			);
			register_sidebar(
				array(
					'name'        => esc_html__( 'Inventory Sidebar', 'travelami' ),
					'id'          => 'sidebar-inventory',
					'description' => esc_html__( 'Widgets in this area will be displayed in Inventory sidebar.', 'travelami' ),
				)
			);
			register_sidebar(
				array(
					'name'        => esc_html__( 'Inventory Top Sidebar', 'travelami' ),
					'id'          => 'sidebar-inventory-top',
					'description' => esc_html__( 'Widgets in this area will be displayed in Inventory sidebar.', 'travelami' ),
				)
			);
			register_sidebar(
				array(
					'name'        => esc_html__( 'Nearby Logo', 'travelami' ),
					'id'          => 'sidebar-nearby-logo',
					'description' => esc_html__( 'Widgets in this area will be displayed in logo section.', 'travelami' ),
				)
			);
			register_sidebar(
				array(
					'name'        => esc_html__( 'Nearby Menu', 'travelami' ),
					'id'          => 'sidebar-nearby-menu',
					'description' => esc_html__( 'Widgets in this area will be displayed in menu section.', 'travelami' ),
				)
			);
			register_sidebar(
				array(
					'name'        => esc_html__( 'Service Sidebar', 'travelami' ),
					'id'          => 'sidebar-service',
					'description' => esc_html__( 'Widgets in this area will be displayed in Service detail.', 'travelami' ),
				)
			);

			register_sidebar(
				array(
					'name'        => esc_html__( 'Header Sidebar Mode', 'travelami' ),
					'id'          => 'sidebar-mode',
					'description' => esc_html__( 'Widgets in this area will be displayed in the first column in the Sidebar - Header Mode of TemPlaza Framework only.', 'travelami' ),
				)
			);
		}

		function travelami_register_front_end_styles()
		{
			if(!is_child_theme()){
				wp_enqueue_style('travelami-style', get_template_directory_uri() . '/style.css', false );
			}
            wp_dequeue_style( 'wp-block-library-theme' );
            wp_register_style('travelami-tiny-slider-style', get_template_directory_uri() . '/assets/css/tiny-slider.css', false );
            wp_enqueue_style('travelami-linearicons', get_template_directory_uri() . '/assets/css/linearicons/style.css', false );
		}

		function travelami_register_front_end_scripts()
		{

			wp_register_script('travelami-progressbar', get_template_directory_uri() . '/assets/js/jQuery-plugin-progressbar.js', array(), false, $in_footer = true);
			wp_register_script('travelami-tiny-slider-script', get_template_directory_uri() . '/assets/js/tiny-slider.js', array(), false, $in_footer = true);
			wp_enqueue_script('travelami-progressbar');

            $admin_url = admin_url('admin-ajax.php');
            $travelami_ajax_url = array('url' => $admin_url);
			wp_register_script( 'travelami-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery') );
			wp_enqueue_script( 'travelami-scripts' );
            wp_localize_script('travelami-scripts', 'travelami_ajax_url', $travelami_ajax_url);


        }

        function travelami_register_theme_scripts()
        {
            if ($GLOBALS['pagenow'] != 'wp-login.php') {
                if ( !is_admin() ) {
                    add_action('wp_enqueue_scripts', array( $this, 'travelami_register_front_end_styles' ) );
                    add_action('wp_enqueue_scripts', array( $this, 'travelami_register_front_end_scripts') );
                }
            }
        }

        function travelami_enqueue_comments_reply() {
            if( get_option( 'thread_comments' ) ) {
                wp_enqueue_script( 'comment-reply' );
            }
        }

        function travelami_password_form( $output, $post = 0 ) {
            $post   = get_post( $post );
            $label  = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );
            $output = '<p class="post-password-message">' . esc_html__( 'This content is password protected. Please enter a password to view.', 'travelami' ) . '</p>
    <p class="pass_label"> <label class="post-password-form__label" for="' . esc_attr( $label ) . '">' . esc_html_x( 'Password', 'Post password form', 'travelami' ) . '</label></p>
    <form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">
    <input class="post-password-form__input" name="post_password" id="' . esc_attr( $label ) . '" type="password" size="20" />
    <input type="submit" class="post-password-form__submit" name="' . esc_attr_x( 'Submit', 'Post password form', 'travelami' ) . '" value="' . esc_attr_x( 'Enter', 'Post password form', 'travelami' ) . '" /></form>
    ';
            return $output;
        }

        function travelami_register_required_plugins()
        {
            /**
             * Array of plugin arrays. Required keys are name and slug.
             * If the source is NOT from the .org repo, then source is also required.
             */
			$travelami_plugins = array(

				// This is an example of how to include a plugin pre-packaged with a theme
                array(
                    'name' => esc_html__('TemPlaza Framework', 'travelami'), /* The plugin name */
                    'slug' => 'templaza-framework', /* The plugin slug (typically the folder name) */
                    'source' => 'https://github.com/templaza/templaza-framework/releases/latest/download/templaza-framework.zip', /* The plugin source */
                    'required' => true, /* If false, the plugin is only 'recommended' instead of required */
                    'version' => '1.2.8', /* E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented */
                    'force_activation' => false, /* If true, plugin is activated upon theme activation and cannot be deactivated until theme switch */
                    'force_deactivation' => false, /* If true, plugin is deactivated upon theme switch, useful for theme-specific plugins */
                    'external_url' => '', /* If set, overrides default API URL and points to an external URL */
                ),
                array(
                    'name' => esc_html__('UiPro', 'travelami'), /* The plugin name */
                    'slug' => 'uipro', /* The plugin slug (typically the folder name) */
                    'source' => 'https://github.com/templaza/uipro/releases/latest/download/uipro.zip', /* The plugin source */
                    'required' => true, /* If false, the plugin is only 'recommended' instead of required */
                    'version' => '1.1.1', /* E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented */
                    'force_activation' => false, /* If true, plugin is activated upon theme activation and cannot be deactivated until theme switch */
                    'force_deactivation' => false, /* If true, plugin is deactivated upon theme switch, useful for theme-specific plugins */
                    'external_url' => '', /* If set, overrides default API URL and points to an external URL */
                ),
                array(
                    'name' => esc_html__('Advanced Product', 'travelami'), /* The plugin name */
                    'slug' => 'advanced-product', /* The plugin slug (typically the folder name) */
                    'source' => 'https://github.com/templaza/advanced-product/releases/latest/download/advanced-product.zip', /* The plugin source */
                    'required' => true, /* If false, the plugin is only 'recommended' instead of required */
                    'version' => '1.1.7', /* E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented */
                    'force_activation' => false, /* If true, plugin is activated upon theme activation and cannot be deactivated until theme switch */
                    'force_deactivation' => false, /* If true, plugin is deactivated upon theme switch, useful for theme-specific plugins */
                    'external_url' => '', /* If set, overrides default API URL and points to an external URL */
                ),
                array(
                    'name'     				=> esc_html__('Slider Revolution','travelami'), // The plugin name
                    'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
                    'source'   				=> 'https://templaza.net/plugins/revslider.zip?t='.time(), // The plugin source
                    'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
                    'version' 				=> '6.7.28', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                    'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                    'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                    'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
                ),
                array(
                    'name' => esc_html__('Redux Framework', 'travelami'), /* The plugin name */
                    'slug' => 'redux-framework', /* The plugin slug (typically the folder name) */
                    'required' => true,
                ),
                array(
                    'name' => 'Shortcodes Ultimate',
                    'slug' => 'shortcodes-ultimate',
                    'required' => true,
                ),
                array(
                    'name' => 'Elementor Website Builder',
                    'slug' => 'elementor',
                    'required' => true,
                ),
                array(
                    'name' => 'WooCommerce',
                    'slug' => 'woocommerce',
                    'required' => true,
                ),
                array(
                    'name' => 'WCBoost – Variation Swatches',
                    'slug' => 'wcboost-variation-swatches',
                    'required' => true,
                ),
                array(
                    'name' => 'YITH WooCommerce Wishlist',
                    'slug' => 'yith-woocommerce-wishlist',
                    'required' => true,
                ),
                array(
                    'name' => 'Contact Form by WPForms',
                    'slug' => 'wpforms-lite',
                    'required' => true,
                ),
			);

			/**
			 * Array of configuration settings. Amend each line as needed.
			 * If you want the default strings to be available under your own theme domain,
			 * leave the strings uncommented.
			 * Some of the strings are added into a sprintf, so see the comments at the
			 * end of each line for what each argument will be.
			 */

			$travelami_config = array(
				'id' => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu' => 'tgmpa-install-plugins', // Menu slug.
				'parent_slug' => 'themes.php',            // Parent menu slug.
				'capability' => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices' => true,                    // Show admin notices or not.
				'dismissable' => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg' => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => true,                   // Automatically activate plugins after installation or not.
				'message' => '',                      // Message to output right before the plugins table.
			);

			tgmpa($travelami_plugins, $travelami_config);
		}

		function travelami_basic_setup(){
			register_nav_menus(
				array(
					'primary' => esc_html__( 'Primary menu', 'travelami' ),
				)
			);
			$logo_width  = 115;
			$logo_height = 45;
			add_theme_support(
				'custom-logo',
				array(
					'height'               => $logo_height,
					'width'                => $logo_width,
					'flex-width'           => true,
					'flex-height'          => true,
					'unlink-homepage-logo' => true,
				)
			);
		}


		function travelami_basic_register_front_end_styles()
		{
			wp_enqueue_style( 'travelami-basic-fonts', travelami_basic_fonts_url(), array(), null );
			wp_enqueue_style('travelami-basic-style-min', get_template_directory_uri() . '/assets/css/style.min.css', false );
			wp_enqueue_style('travelami-basic-fontawesome', get_template_directory_uri() . '/assets/css/fontawesome/css/all.min.css', false );
		}

		function travelami_basic_register_front_end_scripts()
		{
			wp_enqueue_script('travelami-basic-script-uikit', get_template_directory_uri() . '/assets/js/uikit.min.js', false );
			wp_enqueue_script('travelami-basic-script-uikit-icon', get_template_directory_uri() . '/assets/js/uikit-icons.min.js', false );
			wp_enqueue_script('travelami-basic-script-basic', get_template_directory_uri() . '/assets/js/basic.js', array('jquery') );
		}

		function travelami_basic_register_theme_scripts()
		{
			if ($GLOBALS['pagenow'] != 'wp-login.php') {
				if ( !is_admin() )  {
					add_action('wp_enqueue_scripts', array( $this, 'travelami_basic_register_front_end_styles' ) );
					add_action('wp_enqueue_scripts', array( $this, 'travelami_basic_register_front_end_scripts' ) );
				}
			}
		}

		function travelami_continue_reading_link_excerpt() {
			if ( ! is_admin() ) {
				return '&hellip; <a class="more-link" href="' . esc_url( get_permalink() ) . '">' . travelami_basic_continue_reading_text() . '</a>';
			}
			return '';
		}

		function travelami_continue_reading_link() {
			if ( ! is_admin() ) {
				return '<div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '#more-' . esc_attr( get_the_ID() ) . '">' . travelami_basic_continue_reading_text() . '</a></div>';
			}
			return '';
		}

        function travelami_set_posts_per_page_post_type( $query ) {
            if ( !is_admin() && $query->is_main_query() && class_exists( 'Advanced_Product\Advanced_Product' )) {
                if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
                    $templaza_options = array();
                }else{
                    $templaza_options = Functions::get_theme_options();
                }
                if(is_post_type_archive( 'ap_product' ) || is_tax( 'ap_category' ) || is_tax( 'ap_branch' ) || AP_Helper::is_inventory()){
                    if(isset($_GET['product_limit'])){
                        $ap_per_page = $_GET['product_limit'];
                    }else{
                        $ap_per_page       = isset($templaza_options['ap_product-products_per_page'])?$templaza_options['ap_product-products_per_page']:9;
                    }
                    $query->set( 'posts_per_page', ''.$ap_per_page.'' );
                    $ap_sold       = isset($templaza_options['ap_product-archive-product-sold'])?$templaza_options['ap_product-archive-product-sold']:false;
                    if($ap_sold == true) {
                        $meta_query_old = $query->get('meta_query');
                        $meta_query_new = array();
                        if (is_array($meta_query_old)) {
                            foreach ($meta_query_old as $meta_query) {
                                $meta_query_new = $meta_query;
                            }
                        }
                        $custom_query = array(
                            'relation' => 'AND',
                            array(
                                'relation' => 'OR',
                                array(
                                    'key' => 'ap_product_type',
                                    'value' => 'sold',
                                    'compare' => 'NOT LIKE',
                                ),
                                array(
                                    'key' => 'ap_product_type',
                                    'compare' => 'NOT EXISTS',
                                ),
                            ),
                            $meta_query_new
                        );

                        $query->set('meta_query', $custom_query);
                    }
                    return $query;
                }
                if(is_post_type_archive( 'our_team' ) || is_tax( 'our_team-category') || is_tax( 'our_team_tag' ) ){

                    $query->set( 'posts_per_page', 6 );

                }
            }
        }
	}
	Travelami_Handler::get_instance();
}