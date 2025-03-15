<?php
defined('TEMPLAZA_FRAMEWORK') or exit();
use TemPlazaFramework\Functions;
use Advanced_Product\Helper\AP_Custom_Field_Helper;

$Field_Helper = new AP_Custom_Field_Helper();

$type_exists = method_exists($Field_Helper, 'get_acf_fields_by_type');
if($type_exists){
    $number_fields = AP_Custom_Field_Helper::get_acf_fields_by_type(array('number'));
}else{
    $number_fields = array();
}

$price_arr = array();
if(!empty($number_fields)){
    foreach($number_fields as $i =>$field){
        $price_arr[$i] = $field;
    }
}
$arr_wpform = array();
if(function_exists('wpforms')){
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'wpforms'
    );

    $wpforms = get_posts( $args );
    if ( $wpforms && !is_wp_error($wpforms) ) {
        foreach ( $wpforms as $post ){
            $arr_wpform[$post->ID] = $post->post_title;
        }
        wp_reset_postdata();
    }
}
$arr_wpform['custom'] = esc_html__('Custom','travelami');
Templaza_API::add_field_arguments('settings', 'blog-page',
    array(
        'blog-page-layout' => array(
            'options' => array(
                'columns' => 'Columns',
                'list' => 'List',
                'grid' => 'Grid',
            )
        ),
    )
);
Templaza_API::set_fields('settings', 'blog-page',
    array(
        array(
            'id'       => 'blog-page-column-gap',
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
            'required' => array('blog-page-layout', '=' , array('grid','columns'))
        ),
        array(
            'id'       => 'blog-page-card-size',
            'type'     => 'select',
            'title'    => esc_html__('Card Size', 'travelami'),
            'options'  => array(
                'default' => esc_html__('Default','travelami'),
                'small' => esc_html__('Small','travelami'),
                'large' => esc_html__('Large','travelami'),
                'custom' => esc_html__('Custom','travelami'),
            ),
            'default'  => 'default',
            'required' => array('blog-page-layout', '=' , 'grid')
        ),
        array(
            'id'       => 'blog-page-card-custom',
            'type'     => 'spacing',
            'allow_responsive'    => true,
            'title'    => esc_html__('Card custom', 'travelami'),
            'default'  => '',
            'required' => array('blog-page-card-size', '=' , 'custom')
        ),
        array(
            'id'       => 'blog-page-image-cover',
            'type'     => 'switch',
            'title'    => esc_html__( 'Cover image', 'travelami' ),
            'default'  => true,
        ),
        array(
            'id'       => 'blog-page-thumbnail-height',
            'type'     => 'spinner',
            'title'    => esc_html__('Thumbnail height', 'travelami'),
            'default'  => '300',
            'min'      => '100',
            'step'     => '1',
            'max'      => '1000',
            'required' => array('blog-page-image-cover', '=' , true)
        ),
    )
);

Templaza_API::set_subsection('settings', 'colors',
    array(
        'title'      => esc_html__( 'Theme Color', 'travelami' ),
        'id'         => 'colors-theme-color',
        'desc'       => esc_html__( 'Select colors for theme', 'travelami' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'theme-color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Theme color', 'travelami' ),
                'subtitle' => esc_html__( 'Set the color of theme', 'travelami' ),
            ),
        ),
    )
);

Templaza_API::set_subsection('settings', 'advanced-products-options',
    array(
        'title'      => esc_html__( 'Payment Options', 'travelami' ),
        'id'         => 'ap_product-booking',
        'desc'       => esc_html__( 'Options for booking form and payment', 'travelami' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'ap_product-booking-enable',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Booking', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'ap_product-booking-page-functions',
                'type'     => 'section',
                'title'    => esc_html__( 'Choose Page functions', 'travelami' ),
                'indent'  => true,
                'required' => array('ap_product-booking-enable', '=' , true)
            ),
            array(
                'id' => 'ap_product_cart_page',
                'type' => 'select',
                'title' => esc_html__('Tour Cart Page', 'travelami'),
                'subtitle' => esc_html__('This sets the base page of your tour booking. Please add [tz_booking_cart] shortcode in the page content.', 'travelami'),
                'data' => 'pages',
                'args' => array(
                    'sort_order' => esc_html__('asc', 'travelami'),
                    'sort_column' => esc_html__('post_title', 'travelami'),
                ),
            ),
            array(
                'id' => 'ap_product_checkout_page',
                'type' => 'select',
                'title' => esc_html__('Tour Checkout Page', 'travelami'),
                'subtitle' => esc_html__('This sets the tour Checkout Page. Please add [tz_booking_checkout] shortcode in the page content.', 'travelami'),
                'data' => 'pages',
                'args' => array(
                    'sort_order' => esc_html__('asc', 'travelami'),
                    'sort_column' => esc_html__('post_title', 'travelami'),
                ),
            ),
            array(
                'id' => 'ap_product_confirm_page',
                'type' => 'select',
                'title' => esc_html__('Tour Booking Confirmation Page', 'travelami'),
                'subtitle' => esc_html__('This sets the tour booking confirmation Page. Please add [tz_booking_confirm] shortcode in the page content.', 'travelami'),
                'data' => 'pages',
                'args' => array(
                    'sort_order' => esc_html__('asc', 'travelami'),
                    'sort_column' => esc_html__('post_title', 'travelami'),
                ),
            ),
            array(
                'id'       => 'ap_product-booking-data',
                'type'     => 'section',
                'title'    => esc_html__( 'Config Data', 'travelami' ),
                'indent'  => true,
                'required' => array('ap_product-booking-enable', '=' , true)
            ),
            array(
                'id' => 'ap_product_data_price',
                'type' => 'select',
                'title' => esc_html__('Select Field adult Price', 'travelami'),
                'subtitle' => esc_html__('Select field (type number) to calculator price.', 'travelami'),
                'options'  => $price_arr,
            ),
            array(
                'id' => 'ap_product_data_child_price',
                'type' => 'select',
                'title' => esc_html__('Select Field Child Price', 'travelami'),
                'subtitle' => esc_html__('Select field (type number) to calculator child price.', 'travelami'),
                'options'  => $price_arr,
            ),
            array(
                'id' => 'ap_product_data_fnr_price',
                'type' => 'select',
                'title' => esc_html__('Select Field FNR Price', 'travelami'),
                'subtitle' => esc_html__('Select field (type number) to calculator FNR price.', 'travelami'),
                'options'  => $price_arr,
            ),
            array(
                'id' => 'ap_product_data_vacation_price',
                'type' => 'select',
                'title' => esc_html__('Select Field Vacation Package Price', 'travelami'),
                'subtitle' => esc_html__('Select field (type number) to calculator vacation package price.', 'travelami'),
                'options'  => $price_arr,
            ),
            array(
                'id' => 'ap_product_data_transport_price',
                'type' => 'select',
                'title' => esc_html__('Select Field Transport Service Price', 'travelami'),
                'subtitle' => esc_html__('Select field (type number) to calculator transport service price.', 'travelami'),
                'options'  => $price_arr,
            ),
            array(
                'id' => 'ap_product_data_others_price',
                'type' => 'select',
                'title' => esc_html__('Select Field Other Services Price', 'travelami'),
                'subtitle' => esc_html__('Select field (type number) to calculator other services price.', 'travelami'),
                'options'  => $price_arr,
            ),
            array(
                'id'       => 'ap_product-booking-payment',
                'type'     => 'section',
                'title'    => esc_html__( 'Config Payment', 'travelami' ),
                'indent'  => true,
                'required' => array('ap_product-booking-enable', '=' , true)
            ),
            array(
                'id'       => 'ap_product_payment_cash',
                'type'     => 'switch',
                'title'    => esc_html__( 'Payment In Cash', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'ap_product_payment_paypal',
                'type'     => 'switch',
                'title'    => esc_html__( 'PayPal Integration ', 'travelami' ),
                'subtitle'    => esc_html__( 'Enable payment through PayPal in booking step. ', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'ap_product_payment_paypal_card',
                'type'     => 'switch',
                'title'    => esc_html__( 'Credit Card Payment', 'travelami' ),
                'subtitle'    => esc_html__( 'Enable Credit Card payment through PayPal in booking step. Please note your paypal account should be business pro.', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'ap_product_payment_paypal_sandbox',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sandbox Mode ', 'travelami' ),
                'subtitle'    => esc_html__( 'Enable PayPal sandbox for testing', 'travelami' ),
                'default'  => true,
            ),
            array(
                'id'       => 'ap_product_payment_api_username',
                'type'     => 'text',
                'title'    => esc_html__( 'PayPal API Username', 'templaza-framework' ),
            ),
            array(
                'id'       => 'ap_product_payment_api_pass',
                'type'     => 'text',
                'title'    => esc_html__( 'PayPal API Password', 'templaza-framework' ),
            ),
            array(
                'id'       => 'ap_product_payment_api_signature',
                'type'     => 'text',
                'title'    => esc_html__( 'PayPal API Signature', 'templaza-framework' ),
            ),
            array(
                'id'       => 'ap_product-booking-email',
                'type'     => 'section',
                'title'    => esc_html__( 'Config Email', 'travelami' ),
                'indent'  => true,
                'required' => array('ap_product-booking-enable', '=' , true)
            ),
            array(
                'title' => esc_html__('Subject', 'travelami'),
                'subtitle' => esc_html__('Subject of email confirm send to customer.', 'travelami'),
                'id' => 'ap_product_email_subject_customer',
                'default' => '',
                'type' => 'text'
            ),
            array(
                'title' => esc_html__('Content', 'travelami'),
                'subtitle' => esc_html__('Content of email confirm send to customer.', 'travelami'),
                'id' => 'ap_product_email_description_customer',
                'default' => '',
                'type' => 'editor'
            ),
            array(
                'title' => esc_html__('Order and Billing address option', 'travelami'),
                'subtitle' => 'For email to customer',
                'id' => 'ap_product_email_confirm_customer_order_and_billing',
                'default' => true,
                'type' => 'switch'
            ),
            array(
                'id' => 'ap_product_email_confirm_customer_order_billing_position',
                'type' => 'select',
                'title' => esc_html__(' Position of Order and Billing Adress', 'travelami'),
                'subtitle' => '',
                'default' => 'after',
                'options' => array(
                    'after' => esc_html__('After Content', 'travelami'),
                    'before' => esc_html__('Before Content', 'travelami'),
                ),
                'required' => array('ap_product_email_confirm_customer_order_and_billing', '=', true),
            ),
        ),
    )
);
Templaza_API::set_fields('settings', 'service-subsections',
    array(
        array(
            'id'       => 'travelami_service_form',
            'type'     => 'select',
            'title'    => esc_html__( 'Service Book Form', 'travelami' ),
            'options'  => $arr_wpform,
        ),
        array(
            'id'       => 'travelami_service_form_custom',
            'type'     => 'text',
            'title'    => esc_html__( 'Custom Form', 'travelami' ),
            'subtitle' => esc_html__('Insert Form Shortcode', 'travelami'),
            'required' => array('travelami_service_form', '=' , 'custom'),
        ),
    )
);