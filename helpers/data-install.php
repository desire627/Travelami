<?php

add_filter( 'templaza-framework-importer', 'travelami_import_demos' );

function travelami_import_demos($value)
{
    $value = array(
        'envatoid'      => 52393556,
        'productname'   => 'Travelami - Tour & Travel Booking WordPress Theme',
        'demo-imports'  => array(
            'wp_travelami_pack' =>
                array(// Pack Info
                'slug' => 'wp_travelami', // Produce code created on server
                'title' => esc_html__('Travelami Demo','travelami'),
                'desc' => esc_html__('Travelami - Tour & Travel Booking WordPress Theme','travelami'),
                'front_page' => true,
                'front_page_title'  => 'Home Version 1',
                'menu_locations'    => array(
                    array(
                        'title'     => 'Main Menu',
                        'location'  => 'primary'
                    ),
                ),
// Pack Data
                'thumb' => ''.get_stylesheet_directory_uri() .'/assets/images/home.jpg',
                'category' => 'wordpress',
                'demo_url' => 'https://travelami.templaza.net',
                'doc_url' => 'https://docs.templaza.com/themes/travelami',
                'plugins' => array
                (

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
                ),

                'demo-datas' => array(
                    array(
                        'title' => esc_html__('Default Content', 'travelami'),
                        'desc' => esc_html__('This will import posts, pages, media and menu', 'travelami'),
                        'slug' => 'wp_travelami_fulldata',
                        'checked' => true,
                    ),
                    array(
                        'title' => esc_html__('Elementor Settings', 'travelami'),
                        'desc' => esc_html__('This will import  Elementor settings', 'travelami'),
                        'slug' => 'wp_travelami_elementor',
                        'demo_type' => 'elementor',
                        'checked' => true,
                    ),
                    array(
                        'title' => esc_html__('Widgets', 'travelami'),
                        'desc' => esc_html__('This will import default widgets presented in demo site of this content package.', 'travelami'),
                        'slug' => 'wp_travelami_widget',
                        'demo_type' => 'widget-importer',
                        'checked' => true,
                    ),
                    array(
                        'title' => esc_html__('WPForms', 'travelami'),
                        'desc' => esc_html__('This will import WPForms.', 'travelami'),
                        'slug' => 'wp_travelami_form',
                        'demo_type' => 'wpforms',
                        'checked' => true,
                    ),
                    array(
                        'title' => esc_html__('Slider', 'travelami'),
                        'desc' => esc_html__('This will import slider.', 'travelami'),
                        'slug' => 'wp_travelami_slider',
                        'demo_type' => 'revslider',
                        'checked' => true,
                    ),

                )
            ),

        )
    );
    return $value;
}