<?php

defined('TEMPLAZA_FRAMEWORK') or exit();
// -> START Advanced Product Section
Templaza_API::set_section('settings', array(
        'title' => esc_html__( 'Advanced Product Options', 'travelami'),
        'id'    => 'advanced-products-options',
        'icon'  => 'el eicon-product-stock'
    )
);
$all_thumbnails = get_intermediate_image_sizes();
$arr_thumbnails = array();
foreach ($all_thumbnails as $thumbnail){
    $arr_thumbnails[$thumbnail] = $thumbnail;
}
$arr_thumbnails['full'] = 'full';
$arr_wpform = array();
if(function_exists('wpforms')){
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'wpforms'
    );

    $wpforms = get_posts( $args );
    if ( $wpforms ) {
        foreach ( $wpforms as $post ){
            $arr_wpform[$post->ID] = $post->post_title;
        }
    }
}
$arr_wpform['custom'] = esc_html__('Custom','travelami');
Templaza_API::set_section('settings',
    array(
        'title'      => esc_html__( 'Advanced Product Archive', 'travelami' ),
        'id'         => 'ap_product-page',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'ap_product-layout',
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
                'id'       => 'ap_product-column-large',
                'type'     => 'select',
                'title'    => esc_html__('Large Desktop Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row large desktop (1600px and larger)', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Columns', 'travelami'),
                    '3' => esc_html__('3 Columns', 'travelami'),
                    '4' => esc_html__('4 Columns', 'travelami'),
                    '5' => esc_html__('5 Columns', 'travelami'),
                    '6' => esc_html__('6 Columns', 'travelami'),
                ),
                'default'  => '3',
                'required' => array('ap_product-layout', '=' , array('grid','masonry'))
            ),
            array(
                'id'       => 'ap_product-column',
                'type'     => 'select',
                'title'    => esc_html__('Desktop Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row (1200px and larger)', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Columns', 'travelami'),
                    '3' => esc_html__('3 Columns', 'travelami'),
                    '4' => esc_html__('4 Columns', 'travelami'),
                    '5' => esc_html__('5 Columns', 'travelami'),
                    '6' => esc_html__('6 Columns', 'travelami'),
                ),
                'default'  => '3',
                'required' => array('ap_product-layout', '=' , array('grid','masonry'))
            ),
            array(
                'id'       => 'ap_product-column-laptop',
                'type'     => 'select',
                'title'    => esc_html__('Laptop Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row (960px and larger)', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Columns', 'travelami'),
                    '3' => esc_html__('3 Columns', 'travelami'),
                    '4' => esc_html__('4 Columns', 'travelami'),
                    '5' => esc_html__('5 Columns', 'travelami'),
                    '6' => esc_html__('6 Columns', 'travelami'),
                ),
                'default'  => '3',
                'required' => array('ap_product-layout', '=' , array('grid','masonry'))
            ),
            array(
                'id'       => 'ap_product-column-tablet',
                'type'     => 'select',
                'title'    => esc_html__('Tablet Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row (640px and larger)', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Columns', 'travelami'),
                    '3' => esc_html__('3 Columns', 'travelami'),
                    '4' => esc_html__('4 Columns', 'travelami'),
                    '5' => esc_html__('5 Columns', 'travelami'),
                    '6' => esc_html__('6 Columns', 'travelami'),
                ),
                'default'  => '2',
                'required' => array('ap_product-layout', '=' , array('grid','masonry'))
            ),
            array(
                'id'       => 'ap_product-column-mobile',
                'type'     => 'select',
                'title'    => esc_html__('Mobile Columns', 'travelami'),
                'subtitle' => esc_html__('Number products per row mobile', 'travelami'),
                'options'  => array(
                    '1' => esc_html__('1 Column', 'travelami'),
                    '2' => esc_html__('2 Columns', 'travelami'),
                    '3' => esc_html__('3 Columns', 'travelami'),
                    '4' => esc_html__('4 Columns', 'travelami'),
                    '5' => esc_html__('5 Columns', 'travelami'),
                    '6' => esc_html__('6 Columns', 'travelami'),
                ),
                'default'  => '1',
                'required' => array('ap_product-layout', '=' , array('grid','masonry'))
            ),
            array(
                'id'       => 'ap_product-column-gap',
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
                'required' => array('ap_product-layout', '=' , array('grid','masonry'))
            ),
            array(
                'id'       => 'ap_product-products_per_page',
                'type'     => 'spinner',
                'title'    => esc_html__('Products per page.', 'travelami'),
                'subtitle' => esc_html__('Products per page.', 'travelami'),
                'default'  => '9',
                'min'      => '1',
                'step'     => '1',
                'max'      => '500',
            ),
            array(
                'id'       => 'ap_product-thumbnail-size',
                'type'     => 'select',
                'title'    => esc_html__('Thumbnail size', 'travelami'),
                'subtitle' => esc_html__('choose image size.', 'travelami'),
                'options'  => $arr_thumbnails,
            )
        )
    )
);
Templaza_API::set_subsection('settings','ap_product-page',
    array(
        'title'      => esc_html__( 'Advanced Product Single', 'travelami' ),
        'id'         => 'ap_product-single',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'ap_product-office-price',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Office Price', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'ap_product-office-price-label',
                'type'     => 'text',
                'title'    => esc_html__( 'Office Price Label', 'travelami' ),
                'default'  => esc_html__( 'MAKE AN OFFICE PRICE', 'travelami' ),
                'required' => array('ap_product-office-price', '=' , true),
            ),
            array(
                'id'       => 'ap_product-office-price-form',
                'type'     => 'select',
                'title'    => esc_html__( 'Office Price Form', 'travelami' ),
                'options'  => $arr_wpform,
                'required' => array('ap_product-office-price', '=' , true),
            ),
            array(
                'id'       => 'ap_product-office-price-form-custom',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Form', 'travelami' ),
                'subtitle' => esc_html__('Insert Form Shortcode', 'travelami'),
                'required' => array('ap_product-office-price-form', '=' , 'custom'),
            ),
            array(
                'id'     => 'ap_product-custom-field-margin',
                'type'   => 'spacing',
                'mode'   => 'margin',
                'all'    => false,
                'allow_responsive'    => true,
                'units'  => array( 'em', 'px', '%' ),      // You can specify a unit value. Possible: px, em, %
                'title'  => esc_html__('Custom Field Item Margin', 'travelami'),
            ),
        )
    )
);
Templaza_API::set_subsection('settings','ap_product-page',
    array(
        'title'      => esc_html__( 'Advanced Product Related', 'travelami' ),
        'id'         => 'ap_product-single-related',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'ap_product-related',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Product Related', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'ap_product-related-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Related Title', 'travelami' ),
                'default'  => esc_html__( 'RELATED PRODUCT', 'travelami' ),
                'required' => array('ap_product-related', '=' , true),
            ),
            array(
                'id'       => 'ap_product-related-number',
                'type'     => 'spinner',
                'title'    => esc_html__('Number Product Related', 'travelami'),
                'default'  => '3',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array('ap_product-related', '=' , true),
            ),
            array(
                'id'       => 'ap_product-related-spec-limit',
                'type'     => 'spinner',
                'title'    => esc_html__('Limit Specifications', 'travelami'),
                'default'  => '3',
                'min'      => '1',
                'step'     => '1',
                'max'      => '50',
                'required' => array('ap_product-related', '=' , true),
            ),
        )
    )
);