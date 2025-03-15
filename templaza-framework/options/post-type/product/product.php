<?php

defined('TEMPLAZA_FRAMEWORK') or exit();
// -> START Shop Section
Templaza_API::set_section('settings', array(
        'title' => esc_html__( 'Woocommerce Options', 'travelami'),
        'id'    => 'Woocommerce-options',
        'icon'  => 'el el-shopping-cart'
    )
);
Templaza_API::set_section('settings',
    array(
        'title'      => esc_html__( 'Product Catalog', 'travelami' ),
        'id'         => 'shop-page',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-layout',
                'type'     => 'select',
                'title'    => esc_html__('Shop Layout', 'travelami'),
                'subtitle' => esc_html__('Default style list or grid for Shop page.', 'travelami'),
                'options'  => array(
                    'grid' => esc_html__('Grid', 'travelami'),
                    'masonry' => esc_html__('Masonry', 'travelami'),
                ),
                'default'  => 'grid',
            ),
            array(
                'id'       => 'templaza-shop-column-large',
                'type'     => 'select',
                'title'    => esc_html__('Large Desktop Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row large desktop (1600px and larger)', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Column', 'travelami'),
                    '3' => esc_html__('3 Column', 'travelami'),
                    '4' => esc_html__('4 Column', 'travelami'),
                    '5' => esc_html__('5 Column', 'travelami'),
                    '6' => esc_html__('6 Column', 'travelami'),
                ),
                'default'  => '3',
                'required' => array('templaza-shop-layout', '=' , 'grid')
            ),
            array(
                'id'       => 'templaza-shop-column',
                'type'     => 'select',
                'title'    => esc_html__('Desktop Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row (1200px and larger)', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Column', 'travelami'),
                    '3' => esc_html__('3 Column', 'travelami'),
                    '4' => esc_html__('4 Column', 'travelami'),
                    '5' => esc_html__('5 Column', 'travelami'),
                    '6' => esc_html__('6 Column', 'travelami'),
                ),
                'default'  => '3',
                'required' => array('templaza-shop-layout', '=' , 'grid')
            ),
            array(
                'id'       => 'templaza-shop-column-laptop',
                'type'     => 'select',
                'title'    => esc_html__('Laptop Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row (960px and larger)', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Column', 'travelami'),
                    '3' => esc_html__('3 Column', 'travelami'),
                    '4' => esc_html__('4 Column', 'travelami'),
                    '5' => esc_html__('5 Column', 'travelami'),
                    '6' => esc_html__('6 Column', 'travelami'),
                ),
                'default'  => '3',
                'required' => array('templaza-shop-layout', '=' , 'grid')
            ),
            array(
                'id'       => 'templaza-shop-column-tablet',
                'type'     => 'select',
                'title'    => esc_html__('Tablet Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row (640px and larger)', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Column', 'travelami'),
                    '3' => esc_html__('3 Column', 'travelami'),
                    '4' => esc_html__('4 Column', 'travelami'),
                    '5' => esc_html__('5 Column', 'travelami'),
                    '6' => esc_html__('6 Column', 'travelami'),
                ),
                'default'  => '2',
                'required' => array('templaza-shop-layout', '=' , 'grid')
            ),
            array(
                'id'       => 'templaza-shop-column-mobile',
                'type'     => 'select',
                'title'    => esc_html__('Mobile Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row mobile', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Column', 'travelami'),
                    '3' => esc_html__('3 Column', 'travelami'),
                    '4' => esc_html__('4 Column', 'travelami'),
                    '5' => esc_html__('5 Column', 'travelami'),
                    '6' => esc_html__('6 Column', 'travelami'),
                ),
                'default'  => '1',
                'required' => array('templaza-shop-layout', '=' , 'grid')
            ),
            array(
                'id'       => 'templaza-shop-column-gap',
                'type'     => 'select',
                'title'    => esc_html__('Column Gap', 'travelami'),
                'subtitle' => esc_html__('Column Gap grid.', 'travelami'),
                'options'  => array(
                    'default' => esc_html__('Default','travelami'),
                    'small' => esc_html__('Small','travelami'),
                    'medium' => esc_html__('Medium','travelami'),
                    'large' => esc_html__('Large','travelami'),
                    'collapse' => esc_html__('Collapse','travelami'),
                ),
                'default'  => 'default',
                'required' => array('templaza-shop-layout', '=' , 'grid')
            ),
            array(
                'id'       => 'templaza-shop-products_per_page',
                'type'     => 'spinner',
                'title'    => esc_html__('Products per page.', 'travelami'),
                'subtitle' => esc_html__('Products per page.', 'travelami'),
                'default'  => '9',
                'min'      => '1',
                'step'     => '1',
                'max'      => '500',
            ),
            array(
                'id'     => 'templaza-shop-padding',
                'type'   => 'spacing',
                'mode'   => 'padding',
                'all'    => false,
                'allow_responsive'    => true,
                'units'  => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
                'title'  => esc_html__('Item Padding', 'travelami'),
                'select2'   => array('allowClear' => true),
            ),
            array(
                'id'     => 'templaza-shop-margin',
                'type'   => 'spacing',
                'mode'   => 'margin',
                'all'    => false,
                'allow_responsive'    => true,
                'units'  => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
                'title'  => esc_html__('Item Margin', 'travelami'),
                'select2'   => array('allowClear' => true),
            ),

            array(
                'id'       => 'templaza-shop-pagination',
                'type'     => 'select',
                'title'    => esc_html__('Shop Pagination', 'travelami'),
                'subtitle' => esc_html__('Pagination Type.', 'travelami'),
                'options'  => array(
                    'number' => esc_html__('Number','travelami'),
                    'loadmore' => esc_html__('Button Load more','travelami'),
                    'scroll' => esc_html__('Infinite Scroll','travelami'),
                ),
                'default'  => 'number',
            ),
            array(
                'id'       => 'templaza_shop_show_title',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Title', 'travelami' ),
                'subtitle' => esc_html__( 'Show/hide Title.', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza_shop_show_rating',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Rating', 'travelami' ),
                'subtitle' => esc_html__( 'Show/hide Rating.', 'travelami' ),
                'default'  => true,
            ),
        )
    )
);

// Product Loop Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Product Loop', 'travelami' ),
        'id'         => 'shop-product-loop',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-loop-layout',
                'type'     => 'select',
                'title'    => esc_html__('Product Loop Layout', 'travelami'),
                'options'  => array(
                    'layout-1' => esc_html__( 'Icons over thumbnail on hover', 'travelami' ),
                    'layout-2' => esc_html__( 'Icons & Quick view button', 'travelami' ),
                    'layout-3' => esc_html__( 'Icons & Add to cart button', 'travelami' ),
                    'layout-4' => esc_html__( 'Icons on the bottom', 'travelami' ),
                    'layout-5' => esc_html__( 'Simple', 'travelami' ),
                    'layout-6' => esc_html__( 'Standard button', 'travelami' ),
                    'layout-7' => esc_html__( 'Info on hover', 'travelami' ),
                    'layout-8' => esc_html__( 'Icons & Add to cart text', 'travelami' ),
                    'layout-9' => esc_html__( 'Quick Shop button', 'travelami' ),
                ),
                'default'  => 'layout-1',
            ),
            array(
                'id'       => 'templaza-shop-loop-hover',
                'type'     => 'select',
                'title'    => esc_html__('Product Loop Hover', 'travelami'),
                'options'  => array(
                    'classic' => esc_html__( 'Default', 'travelami' ),
                    'slider'  => esc_html__( 'Slider', 'travelami' ),
                    'fadein'  => esc_html__( 'Fadein', 'travelami' ),
                    'zoom'    => esc_html__( 'Zoom', 'travelami' ),
                ),
                'default'  => 'classic',
                'required' => array('templaza-shop-loop-layout', '!=' , 'layout-7'),
            ),
            array(
                'id'       => 'templaza-shop-loop-featured-icons',
                'type'     => 'checkbox',
                'title'    => esc_html__('Featured Icons', 'travelami'),

                //Must provide key => value pairs for multi checkbox options
                'options'  => array(
                    'cart'  => esc_html__( 'Cart', 'travelami' ),
                    'quickview' => esc_html__( 'Quick View', 'travelami' ),
                    'wishlist' => esc_html__( 'Wishlist', 'travelami' ),
                ),
                //See how default has changed? you also don't need to specify opts that are 0.
                'default' => array(
                    'cart' => '1',
                    'quickview' => '1',
                    'wishlist' => '1'
                ),
                'required' => array('templaza-shop-loop-layout', '!=' , 'layout-5'),
            ),
            array(
                'id'       => 'templaza-shop-loop-wishlist',
                'type'     => 'switch',
                'title'    => esc_html__( 'Always Display Wishlist', 'travelami' ),
                'default'  => true,
                'required' => array('templaza-shop-loop-layout', '=' , array('layout-2','layout-3','layout-9')),
            ),
            array(
                'id'       => 'templaza-shop-loop-attributes',
                'type'     => 'checkbox',
                'title'    => esc_html__('Attributes', 'travelami'),

                //Must provide key => value pairs for multi checkbox options
                'options'  => array(
                    'taxonomy' => esc_html__( 'Taxonomy', 'travelami' ),
                    'rating'   => esc_html__( 'Rating', 'travelami' ),
                ),
                //See how default has changed? you also don't need to specify opts that are 0.
                'default' => array(
                    'taxonomy' => '1',
                    'rating' => '0',
                ),
            ),
            array(
                'id'       => 'templaza-shop-loop-taxonomy',
                'type'     => 'select',
                'title'    => esc_html__('Product Loop Taxonomy', 'travelami'),
                'options'  => array(
                    'product_cat'   => esc_html__( 'Category', 'travelami' ),
                    'product_brand' => esc_html__( 'Brand', 'travelami' ),
                ),
                'default'  => 'product_cat',
                'required' => array(
                    array( 'templaza-shop-loop-attributes', '=', 'taxonomy' ),
                    array( 'templaza-shop-loop-attributes', '=', '1' )
                ),
            ),
            array(
                'id'       => 'templaza-shop-loop-variation',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Variations', 'travelami' ),
                'default'  => true,
                'required' => array('templaza-shop-loop-layout', '=' , array('layout-8','layout-9')),
            ),
            array(
                'id'       => 'templaza-shop-loop-variation-ajax',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Variations With AJAX', 'travelami' ),
                'default'  => true,
                'required' => array(
                    array( 'templaza-shop-loop-variation', '=', true ),
                    array( 'templaza-shop-loop-layout', '=', 'layout-9' )
                ),
            ),
            array(
                'id'       => 'templaza-shop-loop-description',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Description', 'travelami' ),
                'default'  => true,
                'required' => array('templaza-shop-loop-layout', '=' , 'layout-6'),
            ),
            array(
                'id'       => 'templaza-shop-loop-description-length',
                'type'     => 'spinner',
                'title'    => esc_html__('Description Length', 'travelami'),
                'default'  => '10',
                'min'      => '1',
                'step'     => '1',
                'max'      => '500',
                'required' => array('templaza-shop-loop-layout', '=' , 'layout-6'),
            ),
        )
    )
);
//  Product Notifications Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Product Notifications', 'travelami' ),
        'id'         => 'shop-notify',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-notify',
                'type'     => 'select',
                'title'    => esc_html__('Added to Cart Notice', 'travelami'),
                'subtitle' => esc_html__('Show notice when click add to cart button.', 'travelami'),
                'options'  => array(
                    'panel'  => esc_html__( 'Open mini cart panel', 'travelami' ),
                    'popup'  => esc_html__( 'Open cart popup', 'travelami' ),
                    'simple' => esc_html__( 'Simple', 'travelami' ),
                    'none'   => esc_html__( 'None', 'travelami' ),
                ),
                'default'  => 'panel',
            ),
            array(
                'id'       => 'templaza-shop-notify-popup',
                'type'     => 'select',
                'title'    => esc_html__('Recommended Products', 'travelami'),
                'subtitle' => esc_html__('Display Recommend product in popup.', 'travelami'),
                'options'  => array(
                    'none'                  => esc_html__( 'None', 'travelami' ),
                    'best_selling_products' => esc_html__( 'Best selling products', 'travelami' ),
                    'featured_products'     => esc_html__( 'Featured products', 'travelami' ),
                    'recent_products'       => esc_html__( 'Recent products', 'travelami' ),
                    'sale_products'         => esc_html__( 'Sale products', 'travelami' ),
                    'top_rated_products'    => esc_html__( 'Top rated products', 'travelami' ),
                    'related_products'      => esc_html__( 'Related products', 'travelami' ),
                    'upsells_products'      => esc_html__( 'Upsells products', 'travelami' ),
                ),
                'default'  => 'related_products',
                'required' => array('templaza-shop-notify', '=' , 'popup'),
            ),
            array(
                'id'       => 'templaza-shop-notify-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Recommend Title', 'travelami' ),
                'default'  => esc_html__( 'You may also like', 'travelami' ),
                'required' => array('templaza-shop-notify', '=' , 'popup'),
            ),
            array(
                'id'       => 'templaza-shop-notify-product-number',
                'type'     => 'spinner',
                'title'    => esc_html__('Number of products', 'travelami'),
                'default'  => '6',
                'min'      => '1',
                'step'     => '1',
                'max'      => '20',
                'required' => array('templaza-shop-notify', '=' , 'popup'),
            ),
            array(
                'id'       => 'templaza-shop-notify-autohide',
                'type'     => 'spinner',
                'title'    => esc_html__('Cart Notification Auto Hide', 'travelami'),
                'subtitle' => esc_html__('Number seconds you want to hide the notification.', 'travelami'),
                'default'  => '3',
                'min'      => '1',
                'step'     => '1',
                'max'      => '500',
                'required' => array('templaza-shop-notify', '=' , 'simple'),
            ),
            array(
                'id'       => 'templaza-shop-notify-wishlist',
                'type'     => 'switch',
                'title'    => esc_html__( 'Added to Wishlist Notification', 'travelami' ),
                'default'  => false,
            ),
            array(
                'id'       => 'templaza-shop-notify-wishlist-autohide',
                'type'     => 'spinner',
                'title'    => esc_html__('Wishlist Notification Auto Hide', 'travelami'),
                'subtitle' => esc_html__('Number seconds you want to hide the notification.', 'travelami'),
                'default'  => '3',
                'min'      => '1',
                'step'     => '1',
                'max'      => '500',
                'required' => array('templaza-shop-notify-wishlist', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-single-image-lightbox',
                'type'     => 'switch',
                'title'    => esc_html__( 'Image Light box', 'travelami' ),
                'default'  => false,
            ),
        )
    )
);
// Single Product Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Single Product', 'travelami' ),
        'id'         => 'shop-single',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-single-layout',
                'type'     => 'select',
                'title'    => esc_html__('Single Product Layout', 'travelami'),
                'options'  => array(
                    'layout-1' => esc_html__( 'Layout 1', 'travelami' ),
                    'layout-2' => esc_html__( 'Layout 2', 'travelami' ),
                    'layout-3' => esc_html__( 'Layout 3', 'travelami' ),
                    'layout-4' => esc_html__( 'Layout 4', 'travelami' ),
                    'layout-5' => esc_html__( 'Layout 5', 'travelami' ),
                ),
                'default'  => 'layout-1',
            ),
            array(
                'id'       => 'templaza-shop-single-cart-ajax',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add to cart with AJAX ', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-single-cart-sticky',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sticky Add To Cart', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-single-cart-sticky-pos',
                'type'     => 'select',
                'title'    => esc_html__('Cart sticky position', 'travelami'),
                'options'  => array(
                    'top'   => esc_html__( 'Top', 'travelami' ),
                    'bottom' => esc_html__( 'Bottom', 'travelami' ),

                ),
                'default'  => 'top',
                'required' => array('templaza-shop-single-cart-sticky', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-single-cart-sticky-atc-variable',
                'type'     => 'select',
                'title'    => esc_html__('Product Variable Style', 'travelami'),
                'options'  => array(
                    'button'   => esc_html__( 'Button', 'travelami' ),
                    'form' => esc_html__( 'Add to cart form', 'travelami' ),

                ),
                'default'  => 'button',
                'required' => array('templaza-shop-single-cart-sticky', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-single-taxonomy',
                'type'     => 'select',
                'title'    => esc_html__('Product Taxonomy', 'travelami'),
                'subtitle' => esc_html__( 'Show taxonomy above product title.', 'travelami' ),
                'options'  => array(
                    'product_cat'   => esc_html__( 'Category', 'travelami' ),
                    'product_brand' => esc_html__( 'Brand', 'travelami' ),
                    ''              => esc_html__( 'None', 'travelami' ),

                ),
                'default'  => '',
            ),
            array(
                'id'       => 'templaza-shop-single-brand-type',
                'type'     => 'select',
                'title'    => esc_html__('Product Brand type', 'travelami'),
                'options'  => array(
                    'title'   => esc_html__( 'Title', 'travelami' ),
                    'logo' => esc_html__( 'Logo', 'travelami' ),
                ),
                'default'  => 'title',
                'required' => array('templaza-shop-single-taxonomy', '=' , 'product_brand'),
            ),
            array(
                'id'       => 'templaza-shop-single-wishlist',
                'type'     => 'select',
                'title'    => esc_html__('Wishlist button', 'travelami'),
                'options'  => array(
                    'icon' => esc_html__('Icon','travelami'),
                    'title' => esc_html__('Icon & Title','travelami'),
                ),
                'default'  => 'icon',
            ),
            array(
                'id'       => 'templaza-shop-single-image-zoom',
                'type'     => 'switch',
                'title'    => esc_html__( 'Image Zoom', 'travelami' ),
                'subtitle' => esc_html__( 'Zoom image when hover', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-single-image-lightbox',
                'type'     => 'switch',
                'title'    => esc_html__( 'Image Light box', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-single-thumb-number',
                'type'     => 'spinner',
                'title'    => esc_html__('Thumbnail Slider Numbers', 'travelami'),
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '20',
            ),
            array(
                'id'       => 'templaza-shop-single-meta',
                'type'     => 'checkbox',
                'title'    => esc_html__('Product Meta', 'travelami'),
                //Must provide key => value pairs for multi checkbox options
                'options'  => array(
                    'sku'      => esc_html__( 'Sku', 'travelami' ),
                    'tags'     => esc_html__( 'Tags', 'travelami' ),
                    'category' => esc_html__( 'Category', 'travelami' ),
                ),
                //See how default has changed? you also don't need to specify opts that are 0.
                'default' => array(
                    'sku' => '1',
                    'tags' => '1',
                    'category' => '1'
                ),
            ),
            array(
                'id'       => 'templaza-shop-single-content-tabs',
                'type'     => 'select',
                'title'    => esc_html__('Content Tabs Position', 'travelami'),
                'options'  => array(
                    'default' => esc_html__('Under Slider','travelami'),
                    'under_summary' => esc_html__('Under Product meta','travelami'),
                ),
                'default'  => 'default',
            ),

        )
    )
);
// Related Product Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Related Products', 'travelami' ),
        'id'         => 'shop-related',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-related',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Related Products', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-related-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Related Title', 'travelami' ),
                'default'  => esc_html__( 'Related Products', 'travelami' ),
                'required' => array('templaza-shop-related', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-related-category',
                'type'     => 'switch',
                'title'    => esc_html__( 'Related Products by categories', 'travelami' ),
                'default'  => true,
                'required' => array('templaza-shop-related', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-related-parent-category',
                'type'     => 'switch',
                'title'    => esc_html__( 'Related Products by parent category', 'travelami' ),
                'default'  => false,
                'required' => array('templaza-shop-related', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-related-tag',
                'type'     => 'switch',
                'title'    => esc_html__( 'Related Products by tags', 'travelami' ),
                'default'  => true,
                'required' => array('templaza-shop-related', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-related-number',
                'type'     => 'spinner',
                'title'    => esc_html__('Related Products Numbers', 'travelami'),
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array('templaza-shop-related', '=' , true),
            ),

        )
    )
);
// Upsells Product Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Upsells Products ', 'travelami' ),
        'id'         => 'shop-upsells',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-upsells',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Upsells Products', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-upsells-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Upsells Title', 'travelami' ),
                'default'  => esc_html__( 'You may also like', 'travelami' ),
                'required' => array('templaza-shop-upsells', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-upsells-number',
                'type'     => 'spinner',
                'title'    => esc_html__('Upsells Products Numbers', 'travelami'),
                'default'  => '6',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array('templaza-shop-upsells', '=' , true),
            ),

        )
    )
);
// Recent Viewed Product Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Recent Viewed Products ', 'travelami' ),
        'id'         => 'shop-recent-viewed',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-recent-viewed',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Recent Viewed Products', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-recent-viewed-ajax',
                'type'     => 'switch',
                'title'    => esc_html__( 'Load With Ajax', 'travelami' ),
                'default'  => true,
                'required' => array('templaza-shop-recent-viewed', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-recent-viewed-empty',
                'type'     => 'switch',
                'title'    => esc_html__('Hide Empty Products', 'travelami' ),
                'subtitle'    => esc_html__('Check this option to hide the recently viewed products when empty.', 'travelami' ),
                'default'  => true,
                'required' => array('templaza-shop-recent-viewed', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-recent-viewed-page',
                'type'     => 'checkbox',
                'title'    => esc_html__('Display on page', 'travelami'),
                //Must provide key => value pairs for multi checkbox options
                'options'  => array(
                    'single'   => esc_html__('Single Product', 'travelami'),
                    'catalog'  => esc_html__('Catalog Page', 'travelami'),
                    'cart'     => esc_html__('Cart Page', 'travelami'),
                    'checkout' => esc_html__('Checkout Page', 'travelami'),
                ),
                //See how default has changed? you also don't need to specify opts that are 0.
                'default' => array(
                    'single' => '1',
                    'catalog' => '0',
                    'cart' => '0',
                    'checkout' => '0'
                ),
                'required' => array('templaza-shop-recent-viewed', '=' , true),
            ),

            array(
                'id'       => 'templaza-shop-recent-viewed-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Recently Viewed Title', 'travelami' ),
                'default'  => esc_html__( 'Recently Viewed', 'travelami' ),
                'required' => array('templaza-shop-recent-viewed', '=' , true),
            ),
            array(
                'id'    => 'templaza-shop-recent-viewed-readmore-text',
                'type'  => 'text',
                'title' => esc_html__( 'Read more text', 'travelami' ),
                'required' => array('templaza-shop-recent-viewed', '=' , true),
            ),
            array(
                'id'    => 'templaza-shop-recent-viewed-readmore-url',
                'type'  => 'text',
                'title' => esc_html__( 'Read more url', 'travelami' ),
                'required' => array('templaza-shop-recent-viewed', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-recent-viewed-columns',
                'type'     => 'spinner',
                'title'    => esc_html__('Recent viewed columns', 'travelami'),
                'default'  => '4',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array('templaza-shop-recent-viewed', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-recent-viewed-number',
                'type'     => 'spinner',
                'title'    => esc_html__('Recent viewed numbers', 'travelami'),
                'default'  => '6',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array('templaza-shop-recent-viewed', '=' , true),
            ),

        )
    )
);
// Badge Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Product Badges', 'travelami' ),
        'id'         => 'shop-badge',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-catalog-badges',
                'type'     => 'switch',
                'title'    => esc_html__( 'Catalog Badges', 'travelami' ),
                'subtitle' => esc_html__( 'Display the badges in the catalog page', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-catalog-badges-layout',
                'type'     => 'select',
                'title'    => esc_html__('Badges Layout', 'travelami'),
                'subtitle' => esc_html__('Badges Layout.', 'travelami'),
                'options'  => array(
                    'layout-1' => esc_html__('Layout 1','travelami'),
                    'layout-2' => esc_html__('Layout 2','travelami'),
                ),
                'required' => array('templaza-shop-catalog-badges', '=' , true),
                'default'  => 'layout-1',
            ),
            array(
                'id'       => 'templaza-shop-single-badges',
                'type'     => 'switch',
                'title'    => esc_html__( 'Product Badges', 'travelami' ),
                'subtitle' => esc_html__( 'Display the badges in the single page', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-badge-sale',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Sale Badge', 'travelami' ),
                'subtitle' => esc_html__( 'Display a badge for sale products', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-badge-sale-type',
                'type'     => 'select',
                'title'    => esc_html__('Badges Sale type', 'travelami'),
                'options'  => array(
                    'percent' => esc_html__('Percent','travelami'),
                    'text' => esc_html__('Text','travelami'),
                    'both' => esc_html__('Both','travelami'),
                ),
                'required' => array('templaza-shop-badge-sale', '=' , true),
                'default'  => 'text',
            ),
            array(
                'id'       => 'templaza-shop-badge-sale-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Badge Sale text', 'travelami' ),
                'desc'     => esc_html__( 'Use {%} to display discount percent, {$} to display discount amount.', 'travelami' ),
                'default'  => esc_html__( 'Sale', 'travelami' ),
            ),
            array(
                'id'       => 'templaza-shop-badge-new',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable New Badge', 'travelami' ),
                'subtitle' => esc_html__( 'Display a badge for new products', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-badge-new-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Badge New text', 'travelami' ),
                'default'  => esc_html__( 'New', 'travelami' ),
                'required' => array('templaza-shop-badge-new', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-new-day',
                'type'     => 'spinner',
                'title'    => esc_html__('Product Newness', 'travelami'),
                'desc'     => esc_html__('Display the "New" badge for how many days?', 'travelami'),
                'default'  => '5',
                'min'      => '1',
                'step'     => '1',
                'max'      => '500',
                'required' => array('templaza-shop-badge-new', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-badge-featured',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Featured Badge', 'travelami' ),
                'subtitle' => esc_html__( 'Display a badge for featured products', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-badge-featured-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Badge Featured text', 'travelami' ),
                'default'  => esc_html__( 'Hot', 'travelami' ),
                'required' => array('templaza-shop-badge-featured', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-badge-soldout',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Sold Out Badge', 'travelami' ),
                'subtitle' => esc_html__( 'Display a badge for out of stock products', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-badge-soldout-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Badge Sold out text', 'travelami' ),
                'default'  => esc_html__( 'Sold Out', 'travelami' ),
                'required' => array('templaza-shop-badge-soldout', '=' , true),
            ),


        )
    )
);

// Cart Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Cart Page', 'travelami' ),
        'id'         => 'shop-cart',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-cart-auto',
                'type'     => 'switch',
                'title'    => esc_html__( 'Update Cart Automatically', 'travelami' ),
                'subtitle' => esc_html__( 'Automatically update cart when change product', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-cart-cross',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Cross-Sells Products ', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'templaza-shop-cart-cross-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Cross-Sells Products Title', 'travelami' ),
                'default'  => esc_html__( 'You may also like', 'travelami' ),
                'required' => array('templaza-shop-cart-cross', '=' , true),
            ),
            array(
                'id'       => 'templaza-shop-cart-cross-number',
                'type'     => 'spinner',
                'title'    => esc_html__('Cross-Sells Products Numbers', 'travelami'),
                'default'  => '6',
                'min'      => '1',
                'step'     => '1',
                'max'      => '500',
                'required' => array('templaza-shop-cart-cross', '=' , true),
            ),
        )
    )
);
// Login Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Mini cart', 'travelami' ),
        'id'         => 'mini-cart',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-mini-cart',
                'type'     => 'select',
                'title'    => esc_html__('Login type', 'travelami'),
                'options'  => array(
                    'modal' => esc_html__('Modal','travelami'),
                    'link' => esc_html__('Link','travelami'),
                ),
                'default'  => 'modal',
            ),
        )
    )
);
// Login Setting
Templaza_API::set_subsection('settings', 'shop-page',
    array(
        'title'      => esc_html__( 'Account Login', 'travelami' ),
        'id'         => 'account-login',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'templaza-shop-account-login',
                'type'     => 'select',
                'title'    => esc_html__('Login type', 'travelami'),
                'options'  => array(
                    'modal' => esc_html__('Modal','travelami'),
                    'link' => esc_html__('Link','travelami'),
                ),
                'default'  => 'modal',
            ),
            array(
                'id'       => 'templaza-shop-account-text',
                'type'     => 'text',
                'title'    => esc_html__( 'Login text', 'travelami' ),
            ),
            array(
                'id'          => 'templaza-shop-account-icon',
                'type'        => 'select',
                'title'       => esc_html__( 'Login icon', 'travelami' ),
                'data'        => 'fontawesome',
            ),

        )
    )
);