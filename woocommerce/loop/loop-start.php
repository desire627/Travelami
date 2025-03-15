<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $templaza_options = array();
}else{
    $templaza_options = Functions::get_theme_options();
}
$shop_layout           = isset($templaza_options['templaza-shop-layout'])?$templaza_options['templaza-shop-layout']:'grid';
$shop_col_large        = isset($templaza_options['templaza-shop-column-large'])?$templaza_options['templaza-shop-column-large']:4;
$shop_col              = isset($templaza_options['templaza-shop-column'])?$templaza_options['templaza-shop-column']:4;
$shop_col_laptop       = isset($templaza_options['templaza-shop-column-laptop'])?$templaza_options['templaza-shop-column-laptop']:3;
$shop_col_tablet       = isset($templaza_options['templaza-shop-column-tablet'])?$templaza_options['templaza-shop-column-tablet']:2;
$shop_col_mobile       = isset($templaza_options['templaza-shop-column-mobile'])?$templaza_options['templaza-shop-column-mobile']:1;
$shop_col_gap          = isset($templaza_options['templaza-shop-column-gap'])?$templaza_options['templaza-shop-column-gap']:'';
if(is_product()){
    $shop_col = $shop_col_large =4;
}
?>
<ul class="products
  uk-child-width-1-<?php echo esc_attr($shop_col);?>@l
  uk-child-width-1-<?php echo esc_attr($shop_col_large);?>@xl
  uk-child-width-1-<?php echo esc_attr($shop_col_laptop);?>@m
  uk-child-width-1-<?php echo esc_attr($shop_col_tablet);?>@s
  uk-child-width-1-<?php echo esc_attr($shop_col_mobile);?>
  columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?> uk-grid-<?php echo esc_attr($shop_col_gap);?>" data-uk-grid>
