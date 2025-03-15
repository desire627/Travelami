<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use TemPlazaFramework\Functions;
use Advanced_Product\Helper\AP_Helper;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $templaza_options = array();
}else{
    $templaza_options = Functions::get_theme_options();
}

// Get raw price values without formatting
$tzbooking_adult_price = $tzbooking_child_price = $tzbooking_fnr_price = 0;
$tzbooking_vacation_price = $tzbooking_transport_price = $tzbooking_others_price = 0;

$adult_price  = isset($templaza_options['ap_product_data_price'])?$templaza_options['ap_product_data_price']:'';
if($adult_price){
    $tzbooking_adult_price = floatval(get_field($adult_price, get_the_ID()));
}

$child_price  = isset($templaza_options['ap_product_data_child_price'])?$templaza_options['ap_product_data_child_price']:'';
if($child_price){
    $tzbooking_child_price = floatval(get_field($child_price, get_the_ID()));
}

$fnr_price  = isset($templaza_options['ap_product_data_fnr_price'])?$templaza_options['ap_product_data_fnr_price']:'';
if($fnr_price){
    $tzbooking_fnr_price = floatval(get_field($fnr_price, get_the_ID()));
}

// Get extra options prices
$vacation_price = isset($templaza_options['ap_product_data_vacation_price'])?$templaza_options['ap_product_data_vacation_price']:'';
if($vacation_price){
    $tzbooking_vacation_price = floatval(get_field($vacation_price, get_the_ID()));
}

$transport_price = isset($templaza_options['ap_product_data_transport_price'])?$templaza_options['ap_product_data_transport_price']:'';
if($transport_price){
    $tzbooking_transport_price = floatval(get_field($transport_price, get_the_ID()));
}

$others_price = isset($templaza_options['ap_product_data_others_price'])?$templaza_options['ap_product_data_others_price']:'';
if($others_price){
    $tzbooking_others_price = floatval(get_field($others_price, get_the_ID()));
}

// Get currency settings
$tzbooking_currency_symbol = get_option('options_ap_currency_symbol', 'Ugx');
$tzbooking_decimal_prec   = get_option('options_ap_price_num_decimals', 0);
$tzbooking_decimal_sep    = get_option('options_ap_price_decimal_sep', ',');
$tzbooking_thousands_sep  = get_option('options_ap_price_thousands_sep', ',');

$tzbooking_product_type = 'daily';
$tzbooking_departure_time = array('11:00', '8:30', '9:00');
$tzbooking_max_adults = 0;

?>
<div class="tz-product-booking">
    <div class="tz-product-book-form">
        <form method="get" id="booking-form" action="<?php echo esc_url( tzbooking_get_product_cart_page() ); ?>">
            <input type="hidden" name="product_id" value="<?php echo get_the_ID()?>">
            <input type="hidden" name="people_available" value="">
            <input name="last_name" value="" placeholder="" type="hidden" >
            <div class="form-group">
                <div class="book-name">
                    <input name="first_name" value="" placeholder="<?php esc_html_e('Your Name','travelami' ); ?>" type="text" required>
                </div>
            </div>
            <div class="form-group">
                <div class="book-email">
                    <input name="your_email" value="" placeholder="<?php esc_html_e('Your Email','travelami' ); ?>" type="text" required>
                </div>
            </div>
            <div class="form-group">
                <div class="book-phone">
                    <input name="your_phone" value="" placeholder="<?php esc_html_e('Phone Number','travelami' ) ?>" type="text" >
                </div>
            </div>
            <div class="form-group">
                <div class="book-departure-date">
                    <input class="date_picker form-control"  type="text" name="date" placeholder="<?php esc_html_e('Start Date','travelami') ?>">
                </div>
            </div>
            <div class="form-group uk-hidden">
                <div class="book-departure-time">
                    <select name="departure_time">
                        <option  value=""><?php esc_html_e('Choose time','travelami' ); ?></option>
                    </select>
                </div>
            </div>
            <?php if( $tzbooking_adult_price != ''){ ?>
                <div class="form-group form-price">
                    <label><?php esc_html_e('Adult','travelami' ); ?></label>
                    <div class="st_adults_children uk-flex uk-flex-middle">
                        <div class="input-number-ticket uk-position-relative">
                            <input class="input-number uk-margin-remove" name="number_adults" type="text" value="1" data-min="1" data-max="10000" min="1" max="10000"/>
                            <span class="input-number-decrement"><i class="fas fa-caret-down"></i></span><span class="input-number-increment"><i class="fas fa-caret-up"></i></span>
                            <input name="price_adults" value="<?php echo esc_attr($tzbooking_adult_price); ?>" type="hidden">
                        </div>
                        <div class="tz_price">
                            <span class="adult_price"><?php echo esc_html('×&nbsp;').AP_Helper::format_price($tzbooking_adult_price); ?></span>
                            <span class="total_price_adults"><?php echo esc_html('=&nbsp;').AP_Helper::format_price($tzbooking_adult_price); ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if( $tzbooking_child_price != '' ){ ?>
                <div class="form-group form-price">
                    <label><?php esc_html_e('Children','travelami' ); ?></label>
                    <div class="st_adults_children uk-flex uk-flex-middle">
                        <div class="input-number-ticket uk-position-relative">
                            <input class="input-number uk-margin-remove" name="number_children" type="text" value="0" data-min="0" data-max="10000" min="0" max="10000"/>
                            <span class="input-number-decrement"><i class="fas fa-caret-down"></i></span><span class="input-number-increment"><i class="fas fa-caret-up"></i></span>
                            <input name="price_child" value="<?php echo esc_attr($tzbooking_child_price); ?>" type="hidden">
                        </div>
                        <div class="tz_price">
                            <span class="child_price"><?php echo esc_html('×&nbsp;').AP_Helper::format_price($tzbooking_child_price); ?></span>
                            <span class="total_price_children"><?php echo esc_html('=&nbsp;').AP_Helper::format_price(0); ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if( $tzbooking_fnr_price != '' ){ ?>
                <div class="form-group form-price">
                    <label><?php esc_html_e('FNR','travelami' ); ?></label>
                    <div class="st_adults_children uk-flex uk-flex-middle">
                        <div class="input-number-ticket uk-position-relative">
                            <input class="input-number uk-margin-remove" name="number_fnr" type="text" value="0" data-min="0" data-max="10000" min="0" max="10000"/>
                            <span class="input-number-decrement"><i class="fas fa-caret-down"></i></span><span class="input-number-increment"><i class="fas fa-caret-up"></i></span>
                            <input name="price_fnr" value="<?php echo esc_attr($tzbooking_fnr_price); ?>" type="hidden">
                        </div>
                        <div class="tz_price">
                            <span class="fnr_price"><?php echo esc_html('×&nbsp;').AP_Helper::format_price($tzbooking_fnr_price); ?></span>
                            <span class="total_price_fnr"><?php echo esc_html('=&nbsp;').AP_Helper::format_price(0); ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if($tzbooking_child_price !='' || $tzbooking_adult_price !='' || $tzbooking_fnr_price !=''){ ?>
            <div class="tz-product-total-price">
            <?php esc_html_e('Total:','travelami');?>
                <span class="total-price">
                    <span class="total_all_price"> <?php
                        if($tzbooking_adult_price != ''){
                            $tzbooking_total_price = $tzbooking_adult_price;
                            echo AP_Helper::format_price($tzbooking_total_price);
                        }elseif($tzbooking_child_price != ''){
                            $tzbooking_total_price = $tzbooking_child_price;
                            echo AP_Helper::format_price($tzbooking_total_price);
                        }elseif($tzbooking_fnr_price != ''){
                            $tzbooking_total_price = $tzbooking_fnr_price;
                            echo AP_Helper::format_price($tzbooking_total_price);
                        }
                        ?></span>
                </span>
            </div>
            <?php } ?>
            <?php 
            // Debug output
            error_log('Vacation Price: ' . $tzbooking_vacation_price);
            error_log('Transport Price: ' . $tzbooking_transport_price);
            error_log('Others Price: ' . $tzbooking_others_price);
            
            // Check if any extra option is available
            if($tzbooking_vacation_price > 0 || $tzbooking_transport_price > 0 || $tzbooking_others_price > 0) { ?>
                <div class="form-group extra-options-section">
                    <h4><?php esc_html_e('Extra Options', 'travelami'); ?></h4>
                    <?php if($tzbooking_vacation_price > 0) { ?>
                        <div class="extra-option">
                            <label class="extra-option-label">
                                <input type="checkbox" name="extra_vacation" class="extra-checkbox" data-price="<?php echo esc_attr($tzbooking_vacation_price); ?>">
                                <span class="option-text"><?php esc_html_e('Vacation Package', 'travelami'); ?></span>
                                <span class="price">(<?php echo AP_Helper::format_price($tzbooking_vacation_price); ?>)</span>
                            </label>
                        </div>
                    <?php } ?>
                    
                    <?php if($tzbooking_transport_price > 0) { ?>
                        <div class="extra-option">
                            <label class="extra-option-label">
                                <input type="checkbox" name="extra_transport" class="extra-checkbox" data-price="<?php echo esc_attr($tzbooking_transport_price); ?>">
                                <span class="option-text"><?php esc_html_e('Transport Service', 'travelami'); ?></span>
                                <span class="price">(<?php echo AP_Helper::format_price($tzbooking_transport_price); ?>)</span>
                            </label>
                        </div>
                    <?php } ?>
                    
                    <?php if($tzbooking_others_price > 0) { ?>
                        <div class="extra-option">
                            <label class="extra-option-label">
                                <input type="checkbox" name="extra_others" class="extra-checkbox" data-price="<?php echo esc_attr($tzbooking_others_price); ?>">
                                <span class="option-text"><?php esc_html_e('Other Services', 'travelami'); ?></span>
                                <span class="price">(<?php echo AP_Helper::format_price($tzbooking_others_price); ?>)</span>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                
                <style>
                .extra-options-section {
                    margin: 20px 0;
                    padding: 15px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                }
                .extra-options-section h4 {
                    margin-bottom: 15px;
                    color: #333;
                }
                .extra-option {
                    margin-bottom: 10px;
                }
                .extra-option-label {
                    display: flex;
                    align-items: center;
                    cursor: pointer;
                }
                .extra-checkbox {
                    margin-right: 10px;
                }
                .option-text {
                    flex-grow: 1;
                }
                .price {
                    color: #666;
                    margin-left: 10px;
                }
                </style>
            <?php } ?>
            <button type="submit" class="btn_full book-now templaza-btn"><?php esc_html_e('Book This Tour','travelami');?></button>
        </form>
    </div>
    <div class="tz-booking-data" 
        data-adults-price="<?php echo esc_attr($tzbooking_adult_price); ?>" 
        data-child-price="<?php echo esc_attr($tzbooking_child_price); ?>" 
        data-fnr-price="<?php echo esc_attr($tzbooking_fnr_price); ?>"
        data-vacation-price="<?php echo esc_attr($tzbooking_vacation_price); ?>"
        data-transport-price="<?php echo esc_attr($tzbooking_transport_price); ?>"
        data-others-price="<?php echo esc_attr($tzbooking_others_price); ?>"
        data-currency-symbol="<?php echo esc_attr($tzbooking_currency_symbol); ?>"
        data-decimal-prec="<?php echo esc_attr($tzbooking_decimal_prec); ?>" 
        data-decimal-sep="<?php echo esc_attr($tzbooking_decimal_sep); ?>" 
        data-thousands-sep="<?php echo esc_attr($tzbooking_thousands_sep); ?>"
        data-departure-time='<?php echo json_encode($tzbooking_departure_time );?>'></div>
</div>
