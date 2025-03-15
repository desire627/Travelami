<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.5.0
 */

use TemPlaza_Woo\Templaza_Woo_Helper;
defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$attachment_ids = apply_filters('templaza_single_product_gallery_image_ids',$product->get_gallery_image_ids());
$video_index    = get_post_meta( $product->get_id(), 'video_position', true );
$index = 2;
if ( $attachment_ids && $product->get_image_id() ) {
	foreach ( $attachment_ids as $attachment_id ) {
		if ( $index == $video_index && is_singular( 'product' )) {
			echo TemPlaza_Woo\Templaza_Woo_Helper::templaza_get_product_video();
		}

		echo wp_kses(apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id ),'post');

		$index++;
	}

	if ( $video_index > count($attachment_ids) && is_singular( 'product' )) { 
		echo wp_kses(TemPlaza_Woo\Templaza_Woo_Helper::templaza_get_product_video(),'post');
	}
}