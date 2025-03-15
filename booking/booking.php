<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('wp_enqueue_scripts', 'tzbooking_front_end_scripts');
function tzbooking_front_end_scripts()
{
    global $post;
    $tzbooking_content = '';
    if( !is_null($post)){
        $tzbooking_content = $post->post_content;
    }
    wp_enqueue_script( 'jquery-ui-datepicker' );

    // You need styling for the datepicker. For simplicity I've linked to the jQuery UI CSS on a CDN.
    wp_register_style( 'jquery-ui', get_template_directory_uri() . '/booking/assets/css/jquery-ui.css', false );
    wp_enqueue_style( 'jquery-ui' );

    wp_enqueue_script('jquery-validate', get_template_directory_uri().'/booking/assets/js/jquery.validate.min.js',array(),false,true);
    if( is_singular('ap_product')) {
        wp_enqueue_script('tzbooking-product-function', get_template_directory_uri() . '/booking/assets/js/tz-product-function.js', array(), false, true);
        wp_enqueue_script('tzbooking-single-product', get_template_directory_uri() . '/booking/assets/js/single-product.js', array(), false, true);
    }
    if( has_shortcode( $tzbooking_content, 'tz_booking_cart') ){
        wp_enqueue_script('tzbooking-product-cart', get_template_directory_uri().'/booking/assets/js/product-cart.js',array(),false,true);
        wp_localize_script( 'tzbooking-product-cart', 'tzbooking_ajax', array('url' => admin_url( 'admin-ajax.php' )));
    }
    if( has_shortcode( $tzbooking_content, 'tz_booking_checkout') ){
        wp_enqueue_script('tzbooking-product-checkout', get_template_directory_uri().'/booking/assets/js/product-checkout.js',array(),false,true);
        wp_localize_script( 'tzbooking-product-checkout', 'tzbooking_ajax', array('url' => admin_url( 'admin-ajax.php' )));

    }

    wp_enqueue_style('tzbooking-booking', get_template_directory_uri() . '/booking/assets/css/booking.css', false );
}
if ( ! function_exists( 'tzbooking_redirect_home' ) ) {
    function tzbooking_redirect_home() {
        echo '<script> location.replace("'.esc_url( home_url("/") ).'"); </script>';
        exit;
    }
}
add_action( 'tzbooking_wrong_data', 'tzbooking_redirect_home' );
/*
 * Required: Creat Booking database
 */
require_once get_template_directory() . '/booking/db.php';

/*
 * Required: include booking functions
 */
require get_template_directory() . '/booking/functions_product.php';

include ( 'templates/shortcodes.php' );
/*
 * Required: include order booking admin
 */
require get_template_directory() . '/booking/order-product-admin.php';