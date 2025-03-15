<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
Shortcode Cart
*/
function shortcode_product_cart( $atts, $content = null ) {
    ob_start();
    tzbooking_get_template( 'cart.php', '/booking/templates' );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode('tz_booking_cart','shortcode_product_cart');

/*
Shortcode Checkout
*/
function shortcode_product_checkout( $atts, $content = null ) {
    ob_start();
    tzbooking_get_template( 'checkout.php', '/booking/templates' );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode('tz_booking_checkout','shortcode_product_checkout');

/*
Shortcode Confirm
*/
function shortcode_product_confirm( $atts, $content = null ) {
    ob_start();
    tzbooking_get_template( 'confirm.php', '/booking/templates' );
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
add_shortcode('tz_booking_confirm','shortcode_product_confirm');