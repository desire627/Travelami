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
                
                // Simple direct message implementation
                add_action('wp_footer', function() {
                    ?>
                    <style>
                    /* Ensure navbar stays on top */
                    .uk-navbar-container {
                        z-index: 1000 !important;
                    }
                    
                    /* Style cart message */
                    #cart-message {
                        position: fixed !important;
                        top: 120px !important;
                        left: 50% !important;
                        transform: translateX(-50%) !important;
                        z-index: 999999 !important;
                        width: 80% !important;
                        max-width: 600px !important;
                        background-color: #4CAF50 !important;
                        color: #ffffff !important;
                        padding: 1.5em 2em !important;
                        margin: 1em auto !important;
                        border-radius: 8px !important;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
                        font-size: 16px !important;
                        font-weight: 500 !important;
                        text-align: center !important;
                        display: none;
                    }

                    #cart-message a {
                        display: inline-block !important;
                        background: #ffffff !important;
                        color: #4CAF50 !important;
                        padding: 8px 16px !important;
                        border-radius: 4px !important;
                        margin-left: 10px !important;
                        text-decoration: none !important;
                        font-weight: 600 !important;
                    }

                    @media (max-width: 768px) {
                        #cart-message {
                            top: 100px !important;
                            width: 90% !important;
                            font-size: 14px !important;
                            padding: 1em 1.5em !important;
                        }
                    }
                    </style>

                    <div id="cart-message" style="display: none;">
                        Product successfully added to cart 
                        <a href="<?php echo esc_url(wc_get_cart_url()); ?>">View cart</a>
                    </div>

                    <script>
                    jQuery(document).ready(function($) {
                        // Remove any existing notices
                        $('.woocommerce-notices-wrapper').remove();
                        
                        function showCartMessage() {
                            $('#cart-message').fadeIn('fast').delay(3000).fadeOut('slow');
                        }

                        // Only trigger on actual add to cart events
                        $(document.body).on('added_to_cart', function() {
                            showCartMessage();
                        });
                    });
                    </script>
                    <?php
                }, 999);
                
                // Prevent redirect on shop pages
                add_filter('woocommerce_add_to_cart_redirect', function($url) {
                    if (!is_singular('product')) {
                        return false;
                    }
                    return wc_get_cart_url();
                }, 999);
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

            add_action('woocommerce_created_customer', 'set_display_name');

            function set_display_name($customer_id) {
                if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
                    $first_name = sanitize_text_field($_POST['first_name']);
                    $last_name = sanitize_text_field($_POST['last_name']);
                    $display_name = $first_name . ' ' . $last_name;

                    wp_update_user(array(
                        'ID' => $customer_id,
                        'display_name' => $display_name
                    ));
                }
            }

            add_action('wp_login', 'log_successful_login', 10, 2);

            function log_successful_login($user_login, $user) {
                error_log('User logged in: ' . $user_login);
            }

            add_action('wp_login_failed', 'custom_login_failed');

            function custom_login_failed($username) {
                error_log('Login failed for username: ' . $username);
            }
        }

        /**
         * Handle redirect after adding to cart
         */
        public function handle_add_to_cart_redirect($url) {
            if (is_singular('product')) {
                return wc_get_cart_url();
            }
            return $url;
        }

        /**
         * Setup cart fragments
         */
        public function setup_cart_fragments() {
            if (class_exists('WooCommerce')) {
                wp_enqueue_script('wc-cart-fragments');
                wp_localize_script('wc-cart-fragments', 'wc_cart_fragments_params', array(
                    'ajax_url' => WC()->ajax_url(),
                    'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
                    'cart_hash_key' => apply_filters('woocommerce_cart_hash_key', 'wc_cart_hash_' . md5(get_current_blog_id())),
                    'fragment_name' => apply_filters('woocommerce_cart_fragment_name', 'wc_fragments_' . md5(get_current_blog_id()))
                ));
            }
        }

        /**
         * Setup cart notices
         */
        public function setup_cart_notices() {
            if (class_exists('WooCommerce')) {
                ?>
                <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('body').on('added_to_cart', function(event, fragments, cart_hash, $button) {
                        if (typeof fragments.notices !== 'undefined') {
                            if ($('.woocommerce-notices-wrapper').length === 0) {
                                $('body').prepend('<div class="woocommerce-notices-wrapper"></div>');
                            }
                            $('.woocommerce-notices-wrapper').html(fragments.notices);
                        }
                    });
                });
                </script>
                <style>
                .woocommerce-notices-wrapper {
                    position: fixed !important;
                    top: 32px !important;
                    left: 50% !important;
                    transform: translateX(-50%) !important;
                    z-index: 9999 !important;
                    width: 80% !important;
                    max-width: 600px !important;
                }
                .woocommerce-message {
                    border: none !important;
                    background-color: #4CAF50 !important;
                    color: #ffffff !important;
                    padding: 1.5em 2em 1.5em 4em !important;
                    margin: 1em auto !important;
                    position: relative !important;
                    border-radius: 8px !important;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
                    font-size: 16px !important;
                    font-weight: 500 !important;
                    animation: slideDown 0.5s ease-out !important;
                }
                .woocommerce-message::before {
                    color: #ffffff !important;
                    font-size: 20px !important;
                }
                @keyframes slideDown {
                    from {
                        transform: translateY(-100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateY(0);
                        opacity: 1;
                    }
                }
                .woocommerce-message a {
                    color: #ffffff !important;
                    text-decoration: underline !important;
                    font-weight: bold !important;
                }
                .woocommerce-message a:hover {
                    color: #e8f5e9 !important;
                }
                @media (max-width: 768px) {
                    .woocommerce-notices-wrapper {
                        width: 90% !important;
                        top: 10px !important;
                    }
                    .woocommerce-message {
                        font-size: 14px !important;
                        padding: 1em 2em 1em 3em !important;
                    }
                }
                </style>
                <?php
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
            add_theme_support( 'woocommerce' );
            add_theme_support( 'wc-product-gallery-zoom' );
            add_theme_support( 'wc-product-gallery-lightbox' );
            add_theme_support( 'wc-product-gallery-slider' );
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
            // Enqueue navbar fixes first with highest priority
            wp_enqueue_style('travelami-navbar-fix', get_template_directory_uri() . '/assets/css/navbar-fix.css', array(), '1.0', 'all');
            
            if(!is_child_theme()){
                wp_enqueue_style('travelami-style', get_template_directory_uri() . '/style.css', array('travelami-navbar-fix') );
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

            // Add WooCommerce AJAX cart handling
            wp_enqueue_script('wc-cart-fragments');
            wp_enqueue_script('wc-add-to-cart');
            
            // Localize the script with cart data
            wp_localize_script('travelami-scripts', 'wc_cart_fragments_params', array(
                'ajax_url'    => WC()->ajax_url(),
                'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
            ));

            wp_register_script('tz-product-function', get_template_directory_uri() . '/booking/assets/js/tz-product-function.js', array('jquery'), '1.0', true);
            wp_enqueue_script('tz-product-function');
            wp_localize_script('tz-product-function', 'tzbooking_ajax', array('url' => admin_url('admin-ajax.php')));
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

        public function custom_add_to_cart_message($message, $products) {
            return '<div class="woocommerce-message">Product successfully added to cart <a href="' . esc_url(wc_get_cart_url()) . '" class="button wc-forward">View cart</a></div>';
        }

        public function add_cart_notice_styles() {
            ?>
            <style>
            .woocommerce-notices-wrapper {
                position: fixed !important;
                top: 32px !important;
                left: 50% !important;
                transform: translateX(-50%) !important;
                z-index: 999999 !important;
                width: 80% !important;
                max-width: 600px !important;
            }
            .woocommerce-message {
                background-color: #4CAF50 !important;
                color: #ffffff !important;
                padding: 1.5em 2em !important;
                margin: 1em auto !important;
                border-radius: 8px !important;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
                font-size: 16px !important;
                font-weight: 500 !important;
                border: none !important;
                text-align: center !important;
            }
            .woocommerce-message .button.wc-forward {
                display: inline-block !important;
                background: #ffffff !important;
                color: #4CAF50 !important;
                padding: 8px 16px !important;
                border-radius: 4px !important;
                margin-left: 10px !important;
                text-decoration: none !important;
                font-weight: bold !important;
            }
            .woocommerce-message .button.wc-forward:hover {
                background: #f1f1f1 !important;
            }
            @media (max-width: 768px) {
                .woocommerce-notices-wrapper {
                    width: 90% !important;
                    top: 10px !important;
                }
                .woocommerce-message {
                    font-size: 14px !important;
                    padding: 1em !important;
                }
            }
            </style>
            <?php
        }

        public function add_cart_notice_script() {
            ?>
            <script type="text/javascript">
            jQuery(document).ready(function($) {
                // Listen for the add to cart event
                $(document.body).on('added_to_cart', function() {
                    // Create message wrapper if it doesn't exist
                    if ($('.woocommerce-notices-wrapper').length === 0) {
                        $('body').prepend('<div class="woocommerce-notices-wrapper"></div>');
                    }
                    
                    // Add the message
                    var message = '<div class="woocommerce-message">Product successfully added to cart <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="button wc-forward">View cart</a></div>';
                    $('.woocommerce-notices-wrapper').html(message);
                    
                    // Auto hide after 3 seconds
                    setTimeout(function() {
                        $('.woocommerce-message').fadeOut('slow');
                    }, 3000);
                });
            });
            </script>
            <?php
        }
    }
    Travelami_Handler::get_instance();
}

// Enqueue WooCommerce scripts
function enqueue_woocommerce_scripts() {
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('wc-cart-fragments');
        wp_enqueue_script('wc-add-to-cart');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_woocommerce_scripts');

// Add Shop More button to cart page
function add_direct_shop_more_button() {
    if (!function_exists('is_cart') || !is_cart()) {
        return;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        var buttonHtml = '<div style="text-align: center; padding: 20px 0; clear: both;">' +
            '<a href="' + '<?php echo esc_url(get_permalink(wc_get_page_id("shop"))); ?>' + '" ' +
            'style="display: inline-block !important; ' +
            'background-color: #C6783E !important; ' +
            'color: #ffffff !important; ' +
            'padding: 12px 25px !important; ' +
            'font-size: 16px !important; ' +
            'font-weight: bold !important; ' +
            'text-decoration: none !important; ' +
            'border-radius: 4px !important; ' +
            'border: none !important; ' +
            'cursor: pointer !important;">' +
            'Shop More</a></div>';

        // Only remove shop more buttons from cart page
        $('.woocommerce-cart-form .shop-more-button, .woocommerce-cart-form .continue-shopping').remove();

        // Insert at the top of cart form
        $('.woocommerce-cart-form').before(buttonHtml);
    });
    </script>
    <?php
}
add_action('wp_footer', 'add_direct_shop_more_button');
// dashboard styling
function add_dashboard_styles() {
    if (is_account_page()) {
        ?>
        <style>
            /* Global Styles */
            body.woocommerce-account {
                font-family: 'Montserrat', sans-serif !important;
                background: #F5F5F5 !important;
                color: #333333 !important;
                line-height: 1.6 !important;
            }

            /* Main Layout */
            .woocommerce-account .woocommerce {
                max-width: 1200px !important;
                margin: 40px auto !important;
                padding: 0 20px !important;
            }

            /* Navigation Sidebar */
            .woocommerce-MyAccount-navigation {
                width: 25% !important;
                float: left !important;
                background: #FFFFFF !important;
                border-radius: 15px !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
                padding: 30px !important;
                margin-right: 30px !important;
            }

            .woocommerce-MyAccount-navigation ul {
                list-style: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .woocommerce-MyAccount-navigation ul li {
                margin-bottom: 15px !important;
            }

            .woocommerce-MyAccount-navigation ul li a {
                display: flex !important;
                align-items: center !important;
                padding: 15px 20px !important;
                color: #555555 !important;
                text-decoration: none !important;
                border-radius: 10px !important;
                transition: all 0.3s ease !important;
                font-weight: 500 !important;
                font-size: 15px !important;
                background: #F8F8F8 !important;
            }

            .woocommerce-MyAccount-navigation ul li.is-active a {
                background: #C6783E !important;
                color: #FFFFFF !important;
                font-weight: 600 !important;
                box-shadow: 0 4px 15px rgba(198, 120, 62, 0.2) !important;
            }

            .woocommerce-MyAccount-navigation ul li:not(.is-active) a:hover {
                background: #FFF1E7 !important;
                color: #C6783E !important;
                transform: translateX(5px) !important;
            }

            /* Content Area */
            .woocommerce-MyAccount-content {
                width: 70% !important;
                float: left !important;
            }

            /* Welcome Message */
            .woocommerce-MyAccount-content > p:first-child {
                background: linear-gradient(135deg, #C6783E 0%, #E39B6D 100%) !important;
                color: #FFFFFF !important;
                padding: 25px 30px !important;
                border-radius: 15px !important;
                font-size: 18px !important;
                font-weight: 500 !important;
                margin-bottom: 30px !important;
                box-shadow: 0 4px 20px rgba(198, 120, 62, 0.2) !important;
            }

            /* Dashboard Cards */
            .woocommerce-MyAccount-content .col2-set {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 25px !important;
                margin-bottom: 30px !important;
            }

            .woocommerce-MyAccount-content .col2-set > div {
                background: #FFFFFF !important;
                border-radius: 15px !important;
                padding: 25px !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
                transition: all 0.3s ease !important;
                border: 1px solid rgba(198, 120, 62, 0.1) !important;
            }

            .woocommerce-MyAccount-content .col2-set > div:hover {
                transform: translateY(-5px) !important;
                box-shadow: 0 8px 30px rgba(198, 120, 62, 0.15) !important;
            }

            .woocommerce-MyAccount-content .col2-set h2 {
                color: #333333 !important;
                font-size: 20px !important;
                font-weight: 600 !important;
                margin-bottom: 15px !important;
                padding-bottom: 10px !important;
                border-bottom: 2px solid rgba(198, 120, 62, 0.1) !important;
            }

            .woocommerce-MyAccount-content .col2-set p {
                color: #666666 !important;
                font-size: 14px !important;
                margin-bottom: 20px !important;
                line-height: 1.6 !important;
            }

            /* Dashboard Links */
            .woocommerce-MyAccount-content a:not(.button) {
                display: inline-flex !important;
                align-items: center !important;
                color: #C6783E !important;
                text-decoration: none !important;
                font-weight: 500 !important;
                font-size: 14px !important;
                padding: 8px 16px !important;
                background: #FFF1E7 !important;
                border-radius: 6px !important;
                transition: all 0.3s ease !important;
            }

            .woocommerce-MyAccount-content a:not(.button):hover {
                background: #C6783E !important;
                color: #FFFFFF !important;
                transform: translateX(5px) !important;
            }

            /* Icons */
            .woocommerce-MyAccount-content a i {
                margin-right: 8px !important;
                font-size: 16px !important;
            }

            /* Account Details Form */
            .woocommerce-MyAccount-content form {
                background: #FFFFFF !important;
                border-radius: 15px !important;
                padding: 30px !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
                max-width: 600px !important;
                margin: 0 auto !important;
            }

            .woocommerce-MyAccount-content form * {
                background: #FFFFFF !important;
            }

            .woocommerce-MyAccount-content form h3 {
                color: #333333 !important;
                font-size: 24px !important;
                font-weight: 600 !important;
                margin-bottom: 25px !important;
                padding-bottom: 15px !important;
                border-bottom: 2px solid rgba(198, 120, 62, 0.1) !important;
            }

            .woocommerce-MyAccount-content fieldset {
                border: none !important;
                padding: 0 !important;
                margin: 25px 0 !important;
            }

            .woocommerce-MyAccount-content fieldset legend {
                color: #C6783E !important;
                font-weight: 600 !important;
                font-size: 18px !important;
                margin-bottom: 15px !important;
            }

            /* Form Fields */
            .woocommerce-MyAccount-content form .form-row {
                margin-bottom: 20px !important;
                background: #FFFFFF !important;
            }

            .woocommerce-MyAccount-content form label {
                display: block !important;
                color: #555555 !important;
                font-weight: 500 !important;
                margin-bottom: 8px !important;
                font-size: 14px !important;
                background: #FFFFFF !important;
            }

            .woocommerce-MyAccount-content input:not(.button),
            .woocommerce-MyAccount-content select,
            .woocommerce-MyAccount-content textarea {
                width: 100% !important;
                padding: 12px 15px !important;
                border: 2px solid #E5E5E5 !important;
                border-radius: 8px !important;
                transition: all 0.3s ease !important;
                font-size: 14px !important;
                background: #FFFFFF !important;
            }

            .woocommerce-MyAccount-content input:focus,
            .woocommerce-MyAccount-content select:focus,
            .woocommerce-MyAccount-content textarea:focus {
                border-color: #C6783E !important;
                outline: none !important;
                box-shadow: 0 0 0 3px rgba(198, 120, 62, 0.1) !important;
            }

            /* Password Field Container */
            .woocommerce-MyAccount-content .password-input {
                position: relative !important;
                display: block !important;
                width: 100% !important;
                background: #FFFFFF !important;
            }

            /* Eye Icon */
            .woocommerce-MyAccount-content .show-password-input {
                position: absolute !important;
                right: 12px !important;
                top: 50% !important;
                transform: translateY(-50%) !important;
                cursor: pointer !important;
                color: #C6783E !important;
                background: transparent !important;
            }

            /* Buttons */
            .woocommerce-MyAccount-content .button {
                background: linear-gradient(135deg, #C6783E 0%, #E39B6D 100%) !important;
                color: #FFFFFF !important;
                padding: 12px 24px !important;
                border-radius: 8px !important;
                border: none !important;
                font-weight: 600 !important;
                font-size: 14px !important;
                transition: all 0.3s ease !important;
                text-transform: uppercase !important;
                letter-spacing: 0.5px !important;
                box-shadow: 0 4px 15px rgba(198, 120, 62, 0.2) !important;
                cursor: pointer !important;
            }

            .woocommerce-MyAccount-content .button:hover {
                transform: translateY(-2px) !important;
                box-shadow: 0 8px 25px rgba(198, 120, 62, 0.3) !important;
            }

            /* Responsive Design */
            @media (max-width: 991px) {
                .woocommerce-MyAccount-content .col2-set {
                    grid-template-columns: 1fr !important;
                }
            }

            @media (max-width: 768px) {
                .woocommerce-account .woocommerce {
                    margin: 20px auto !important;
                    padding: 0 15px !important;
                }

                .woocommerce-MyAccount-navigation,
                .woocommerce-MyAccount-content {
                    width: 100% !important;
                    float: none !important;
                    margin-right: 0 !important;
                }

                .woocommerce-MyAccount-navigation {
                    margin-bottom: 25px !important;
                }

                .woocommerce-MyAccount-content > p:first-child {
                    font-size: 16px !important;
                    padding: 20px !important;
                }

                .woocommerce-MyAccount-content .col2-set > div {
                    padding: 20px !important;
                }

                .woocommerce-MyAccount-content form {
                    padding: 20px !important;
                }

                .woocommerce-MyAccount-content form h3 {
                    font-size: 20px !important;
                }
            }

            /* System Messages */
            .woocommerce-message,
            .woocommerce-info,
            .woocommerce-error {
                background: #FFFFFF !important;
                border-radius: 10px !important;
                margin-bottom: 30px !important;
                padding: 20px 25px !important;
                border-left: 5px solid #C6783E !important;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05) !important;
                color: #333333 !important;
            }

            .woocommerce-error {
                border-left-color: #DC3545 !important;
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'add_dashboard_styles', 999);

// Add Shop More button next to Remove item button
function add_shop_more_button_to_cart() {
    if (is_cart()) {
        ?>
        <script>
            jQuery(document).ready(function($) {
                $('.wc-block-cart-item__remove-link').each(function() {
                    if (!$(this).next('.shop-more-button').length) {
                        $(this).after('<a href="<?php echo esc_url(wc_get_page_permalink("shop")); ?>" class="shop-more-button">Shop More</a>');
                    }
                });
            });
        </script>
        <style>
            .shop-more-button {
                display: inline-flex !important;
                align-items: center !important;
                margin-left: 15px !important;
                padding: 6px 12px !important;
                background-color: #C6783E !important;
                color: #ffffff !important;
                text-decoration: none !important;
                border-radius: 4px !important;
                font-size: 14px !important;
                line-height: 20px !important;
                height: 32px !important;
                border: none !important;
            }
            .shop-more-button:hover {
                background-color: #333333 !important;
                color: #ffffff !important;
            }
            .wc-block-cart-item__remove-link {
                display: inline-flex !important;
                align-items: center !important;
                margin-right: 5px !important;
                padding: 6px 12px !important;
                background-color: #C6783E !important;
                color: #ffffff !important;
                text-decoration: none !important;
                border-radius: 4px !important;
                font-size: 14px !important;
                line-height: 20px !important;
                height: 32px !important;
                border: none !important;
            }
            .wc-block-cart-item__remove-link:hover {
                background-color: #333333 !important;
                color: #ffffff !important;
            }
        </style>
        <?php
    }
}
add_action('wp_footer', 'add_shop_more_button_to_cart');

// Enable cart notices and fragments
function enable_cart_fragments() {
    if (class_exists('WooCommerce')) {
        // Enable notices
        add_action('wc_add_to_cart_message_html', 'wc_add_to_cart_message_html', 10, 2);
        
        // Enable cart fragments
        wp_enqueue_script('wc-cart-fragments');
        wp_localize_script('wc-cart-fragments', 'wc_cart_fragments_params', array(
            'ajax_url' => WC()->ajax_url(),
            'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
            'cart_hash_key' => apply_filters('woocommerce_cart_hash_key', 'wc_cart_hash_' . md5(get_current_blog_id())),
            'fragment_name' => apply_filters('woocommerce_cart_fragment_name', 'wc_fragments_' . md5(get_current_blog_id()))
        ));
    }
}
add_action('wp_enqueue_scripts', 'enable_cart_fragments', 100);

// Handle single product redirect
function custom_redirect_add_to_cart() {
    if (is_singular('product')) {
        add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_cart');
    }
}
add_action('template_redirect', 'custom_redirect_add_to_cart');

function redirect_to_cart($url) {
    if (is_singular('product')) {
        return wc_get_cart_url();
    }
    return $url;
}

// Show success message for shop page adds
function custom_add_to_cart_message($message, $products) {
    return '<div class="woocommerce-message">Product successfully added to cart <a href="' . esc_url(wc_get_cart_url()) . '" class="button wc-forward">View cart</a></div>';
}
add_filter('wc_add_to_cart_message_html', 'custom_add_to_cart_message', 10, 2);

// Add styles for the success message
function add_cart_message_styles() {
    ?>
    <style>
    .woocommerce-message {
        position: fixed !important;
        top: 32px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        z-index: 999999 !important;
        width: 80% !important;
        max-width: 600px !important;
        background-color: #4CAF50 !important;
        color: #ffffff !important;
        padding: 1.5em 2em 1.5em 4em !important;
        margin: 1em auto !important;
        border-radius: 8px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        font-size: 16px !important;
        font-weight: 500 !important;
        border: none !important;
        animation: slideInDown 0.5s ease-out !important;
    }
    .woocommerce-message::before {
        color: #ffffff !important;
        font-size: 20px !important;
    }
    .woocommerce-message .button.wc-forward {
        background: #ffffff !important;
        color: #4CAF50 !important;
        padding: 8px 16px !important;
        border-radius: 4px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        float: right !important;
        margin-left: 10px !important;
    }
    .woocommerce-message .button.wc-forward:hover {
        background: #f1f1f1 !important;
    }
    @keyframes slideInDown {
        from {
            transform: translate3d(-50%, -100%, 0);
            opacity: 0;
        }
        to {
            transform: translate3d(-50%, 0, 0);
            opacity: 1;
        }
    }
    @media (max-width: 768px) {
        .woocommerce-message {
            width: 90% !important;
            top: 10px !important;
            font-size: 14px !important;
            padding: 1em 2em 1em 3em !important;
        }
    }
    </style>
    <?php
}
add_action('wp_head', 'add_cart_message_styles', 999);

// Enable AJAX add to cart notices
function custom_script_to_show_notices() {
    if (is_singular('product')) {
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('body').on('added_to_cart', function(event, fragments, cart_hash, $button) {
                if (typeof fragments.notices !== 'undefined') {
                    if ($('.woocommerce-notices-wrapper').length === 0) {
                        $('body').prepend('<div class="woocommerce-notices-wrapper"></div>');
                    }
                    $('.woocommerce-notices-wrapper').html(fragments.notices);
                }
            });
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'custom_script_to_show_notices');

// Remove all old cart message functions and actions
remove_action('wp_head', 'add_cart_message_styles', 999);
remove_action('wp_footer', 'custom_script_to_show_notices');
remove_filter('wc_add_to_cart_message_html', 'custom_add_to_cart_message', 10);

// Single clean cart message implementation
function add_cart_notification() {
    if (class_exists('WooCommerce')) {
        ?>
        <style>
        #cart-notification {
            position: fixed !important;
            top: 120px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            z-index: 999999 !important;
            width: 80% !important;
            max-width: 600px !important;
            background-color: #4CAF50 !important;
            color: #ffffff !important;
            padding: 1.5em 2em !important;
            margin: 1em auto !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            text-align: center !important;
            display: none;
        }

        #cart-notification a {
            display: inline-block !important;
            background: #ffffff !important;
            color: #4CAF50 !important;
            padding: 8px 16px !important;
            border-radius: 4px !important;
            margin-left: 10px !important;
            text-decoration: none !important;
            font-weight: 600 !important;
        }

        @media (max-width: 768px) {
            #cart-notification {
                top: 100px !important;
                width: 90% !important;
                font-size: 14px !important;
                padding: 1em 1.5em !important;
            }
        }
        </style>

        <div id="cart-notification" style="display: none;">
            Product successfully added to cart 
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>">View cart</a>
        </div>

        <script>
        jQuery(document).ready(function($) {
            // Remove any existing notices
            $('.woocommerce-notices-wrapper').remove();
            
            // Function to show cart notification
            function showCartNotification() {
                $('#cart-notification').fadeIn('fast').delay(3000).fadeOut('slow');
            }

            // Handle AJAX add to cart
            $('body').on('added_to_cart', function() {
                showCartNotification();
            });

            // Handle non-AJAX add to cart
            $('.single_add_to_cart_button').on('click', function() {
                if (!$(this).hasClass('ajax_add_to_cart')) {
                    setTimeout(showCartNotification, 300);
                }
            });
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'add_cart_notification', 50);

// Ensure WooCommerce AJAX functionality is enabled
function enable_ajax_add_to_cart() {
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('wc-add-to-cart');
        wp_enqueue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'enable_ajax_add_to_cart', 99);

// Remove conflicting cart message functions
remove_action('wp_head', 'add_cart_message_styles', 999);
remove_action('wp_footer', 'custom_script_to_show_notices');
remove_action('wp_footer', 'add_cart_notification', 50);
remove_filter('wc_add_to_cart_message_html', 'custom_add_to_cart_message', 10);

function simple_cart_message() {
    if (!class_exists('WooCommerce')) return;
    ?>
    <div id="simple-cart-popup" style="display:none; position:fixed; top:80px; left:50%; transform:translateX(-50%); z-index:999999; background:#4CAF50; color:#fff; padding:10px 20px; border-radius:4px; box-shadow:0 2px 8px rgba(0,0,0,0.1); text-align:center; font-size:14px; max-width:300px; width:auto;">
        Added to cart! 
        <a href="<?php echo wc_get_cart_url(); ?>" style="display:inline-block; background:#fff; color:#4CAF50; padding:4px 12px; border-radius:3px; margin-left:8px; text-decoration:none; font-weight:500; font-size:13px;">View Cart</a>
    </div>
    <script>
    jQuery(function($) {
        // Function to show message
        function showMessage() {
            $('#simple-cart-popup').fadeIn().delay(2000).fadeOut();
        }

        // Handle AJAX add to cart
        $(document.body).on('added_to_cart', showMessage);
        
        // Handle direct button click
        $('.single_add_to_cart_button, .add_to_cart_button').on('click', function(e) {
            // Show message immediately on click
            showMessage();
            
            // If it's not an AJAX button, show message again after form submission
            if (!$(this).hasClass('ajax_add_to_cart')) {
                setTimeout(showMessage, 300);
            }
        });

        // Additional handler for dynamic buttons
        $(document).on('click', '.add_to_cart_button, .single_add_to_cart_button', function(e) {
            showMessage();
        });

        // Handle form submission
        $('form.cart').on('submit', function(e) {
            e.preventDefault();
            showMessage();
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'simple_cart_message', 999);

// Ensure WooCommerce scripts are loaded
function ensure_cart_scripts() {
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('wc-add-to-cart', false, array('jquery'));
        wp_enqueue_script('wc-cart-fragments', false, array('jquery', 'wc-add-to-cart'));
    }
}
add_action('wp_enqueue_scripts', 'ensure_cart_scripts', 99);

// Remove all previous cart message implementations
remove_action('wp_head', 'add_cart_message_styles', 999);
remove_action('wp_footer', 'custom_script_to_show_notices');
remove_action('wp_footer', 'add_cart_notification', 50);
remove_action('wp_footer', 'simple_cart_message', 999);
remove_filter('wc_add_to_cart_message_html', 'custom_add_to_cart_message', 10);

// Add new cart message
add_action('wp_footer', function() {
    if (!class_exists('WooCommerce')) return;
    ?>
    <div id="tz-cart-message" style="display:none; position:fixed; top:80px; left:50%; transform:translateX(-50%); z-index:999999; background:#4CAF50; color:#fff; padding:10px 20px; border-radius:4px; box-shadow:0 2px 8px rgba(0,0,0,0.1); text-align:center; font-size:14px; max-width:300px; width:auto;">
        Added to cart! 
        <a href="<?php echo esc_url(wc_get_cart_url()); ?>" style="display:inline-block; background:#fff; color:#4CAF50; padding:4px 12px; border-radius:3px; margin-left:8px; text-decoration:none; font-weight:500; font-size:13px;">View Cart</a>
    </div>
    <script>
    jQuery(function($) {
        // Show message function
        function showTzMessage() {
            $('#tz-cart-message').fadeIn().delay(2000).fadeOut();
        }

        // Handle add to cart button click
        $(document).on('click', '.single_add_to_cart_button, .add_to_cart_button', function(e) {
            showTzMessage();
        });

        // Handle AJAX add to cart success
        $(document.body).on('added_to_cart', function() {
            showTzMessage();
        });

        // Handle form submission
        $('form.cart').on('submit', function() {
            showTzMessage();
        });

        // Additional trigger for dynamic content
        $(document).ajaxComplete(function() {
            $('.add_to_cart_button, .single_add_to_cart_button').off('click').on('click', function() {
                showTzMessage();
            });
        });
    });
    </script>
    <?php
}, 999);

// Ensure WooCommerce scripts are loaded
add_action('wp_enqueue_scripts', function() {
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('wc-add-to-cart');
        wp_enqueue_script('wc-cart-fragments');
    }
}, 99);

// Remove Bookings from My Account menu
function remove_bookings_my_account_menu($menu_items) {
    unset($menu_items['bookings']);
    return $menu_items;
}
add_filter('woocommerce_account_menu_items', 'remove_bookings_my_account_menu');

function travelami_enqueue_google_fonts() {
    wp_enqueue_style('travelami-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap', false);
}
add_action('wp_enqueue_scripts', 'travelami_enqueue_google_fonts');

add_action('wp_logout', 'redirect_after_logout');

function redirect_after_logout() {
    wp_redirect(home_url());
    exit();
}

// 1. Add notification settings endpoint
function add_notification_settings_link( $items ) {
    $items['notification-settings'] = __( 'Notification Settings', 'travelami' );
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'add_notification_settings_link' );

// 2. Register endpoint
function add_notification_settings_endpoint() {
    add_rewrite_endpoint( 'notification-settings', EP_ROOT | EP_PAGES );
}
add_action( 'init', 'add_notification_settings_endpoint' );

// 3. Add content for the notification settings page
function notification_settings_content() {
    ?>
    <div class="dashboard-section">
        <h2><?php _e('Notification Settings', 'travelami'); ?></h2>
        <p><?php _e('Manage your notification preferences', 'travelami'); ?></p>
        
        <form method="post" action="">
            <div class="notification-options">
                <h3><?php _e('Email Notifications', 'travelami'); ?></h3>
                <label>
                    <input type="checkbox" name="order_updates" value="1" 
                        <?php checked( get_user_meta( get_current_user_id(), 'order_updates_notification', true ), '1' ); ?>>
                    <?php _e('Receive order update emails', 'travelami'); ?>
                </label>
                
                <label>
                    <input type="checkbox" name="promotional_emails" value="1"
                        <?php checked( get_user_meta( get_current_user_id(), 'promotional_emails_notification', true ), '1' ); ?>>
                    <?php _e('Receive promotional emails', 'travelami'); ?>
                </label>
            </div>
            
            <?php wp_nonce_field( 'save_notification_settings', 'notification_settings_nonce' ); ?>
            <button type="submit" name="save_notification_settings" class="button">
                <?php _e('Save Settings', 'travelami'); ?>
            </button>
        </form>
    </div>
    <?php
}
add_action( 'woocommerce_account_notification-settings_endpoint', 'notification_settings_content' );

// 4. Handle form submission
function save_notification_settings() {
    if ( isset( $_POST['save_notification_settings'] ) && 
         wp_verify_nonce( $_POST['notification_settings_nonce'], 'save_notification_settings' ) ) {
        
        $user_id = get_current_user_id();
        
        // Save order updates preference
        $order_updates = isset( $_POST['order_updates'] ) ? '1' : '0';
        update_user_meta( $user_id, 'order_updates_notification', $order_updates );
        
        // Save promotional emails preference
        $promotional_emails = isset( $_POST['promotional_emails'] ) ? '1' : '0';
        update_user_meta( $user_id, 'promotional_emails_notification', $promotional_emails );
        
        // Optional: Add a success message
        wc_add_notice( __( 'Notification settings updated successfully.', 'travelami' ), 'success' );
    }
}
add_action( 'template_redirect', 'save_notification_settings' );

// 5. For WordPress dashboard (admin area)
function add_notification_settings_dashboard_widget() {
    wp_add_dashboard_widget(
        'notification_settings_widget',
        __( 'Notification Settings', 'travelami' ),
        'render_notification_settings_widget'
    );
}
add_action( 'wp_dashboard_setup', 'add_notification_settings_dashboard_widget' );

function render_notification_settings_widget() {
    $user_id = get_current_user_id();
    ?>
    <div class="notification-dashboard-widget">
        <h3><?php _e('Manage Your Notifications', 'travelami'); ?></h3>
        <form method="post" action="">
            <label>
                <input type="checkbox" name="dashboard_order_updates" value="1"
                    <?php checked( get_user_meta( $user_id, 'order_updates_notification', true ), '1' ); ?>>
                <?php _e('Order Update Notifications', 'travelami'); ?>
            </label>
            
            <label>
                <input type="checkbox" name="dashboard_promotional_emails" value="1"
                    <?php checked( get_user_meta( $user_id, 'promotional_emails_notification', true ), '1' ); ?>>
                <?php _e('Promotional Email Notifications', 'travelami'); ?>
            </label>
            
            <?php wp_nonce_field( 'save_dashboard_notification_settings', 'dashboard_notification_settings_nonce' ); ?>
            <button type="submit" name="save_dashboard_notification_settings" class="button">
                <?php _e('Update Settings', 'travelami'); ?>
            </button>
        </form>
    </div>
    <?php
}

// 6. Handle dashboard widget form submission
function save_dashboard_notification_settings() {
    if ( isset( $_POST['save_dashboard_notification_settings'] ) && 
         wp_verify_nonce( $_POST['dashboard_notification_settings_nonce'], 'save_dashboard_notification_settings' ) ) {
        
        $user_id = get_current_user_id();
        
        // Save order updates preference
        $order_updates = isset( $_POST['dashboard_order_updates'] ) ? '1' : '0';
        update_user_meta( $user_id, 'order_updates_notification', $order_updates );
        
        // Save promotional emails preference
        $promotional_emails = isset( $_POST['dashboard_promotional_emails'] ) ? '1' : '0';
        update_user_meta( $user_id, 'promotional_emails_notification', $promotional_emails );
        
        // Optional: Add an admin notice
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-success is-dismissible"><p>' . 
                 __( 'Notification settings updated successfully.', 'travelami' ) . 
                 '</p></div>';
        });
    }
}
add_action( 'admin_init', 'save_dashboard_notification_settings' );

add_filter('woocommerce_registration_redirect', 'custom_registration_redirect');

function custom_registration_redirect($redirect) {
    $redirect = wc_get_page_permalink('myaccount'); // Redirect to the My Account page
    return $redirect;
}