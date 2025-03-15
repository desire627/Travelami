<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.0.0
 */
use TemPlazaFramework\Functions;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $templaza_options = array();
}else{
    $templaza_options = Functions::get_theme_options();
}
$shop_meta       = isset($templaza_options['templaza-shop-single-meta'])?$templaza_options['templaza-shop-single-meta']:array('sku'=>'1','category'=>'1','tags'=>'1',);
global $product;

$product_meta = (array) get_option( 'product_meta' );
?>

<?php do_action( 'woocommerce_product_meta_start' ); ?>

<?php if ( $shop_meta['sku'] == 1 ) : ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

	<span class="sku_wrapper"><span class="label"><?php esc_html_e( 'SKU:', 'travelami' ); ?></span><span class="sku"><?php if ( $sku = $product->get_sku() ) { echo wp_kses( $sku,'post' ); } else { esc_html_e( 'N/A', 'travelami' ); } ?></span></span>

	<?php endif; ?>

<?php endif; ?>

<?php if ( $shop_meta['category']==1) : ?>

	<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in"><span class="label">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'travelami' ) . '</span>', '</span>' ); ?>

<?php endif; ?>

<?php if ( $shop_meta['tags']==1 ) : ?>

	<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as"><span class="label">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'travelami' ) . '</span>', '</span>' ); ?>

<?php endif; ?>

<?php do_action( 'woocommerce_product_meta_end' ); ?>
