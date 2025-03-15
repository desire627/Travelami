<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use TemPlazaFramework\Functions;
    if( !session_id() )
    {
        session_start();
    }

require get_template_directory() . '/booking/class.order.php';
require get_template_directory() . '/booking/session_product.php';
require get_template_directory() . '/booking/paypal.php';

/*
tzbooking_get_date_format
tzbooking_sanitize_date
tzbooking_strtotime
tzbooking_get_phptime
*/

if ( ! function_exists( 'tzbooking_get_date_format' ) ) {
    function tzbooking_get_date_format( $tzbooking_language='' ) {
        global $tzbooking_options;
        if ( isset( $tzbooking_options['date_format'] ) ) {
            if ( $tzbooking_language == 'php' ) {
                switch ( $tzbooking_options['date_format'] ) {
                    case 'dd/mm/yyyy':
                        return 'd/m/Y';
                        break;
                    case 'yyyy-mm-dd':
                        return 'Y-m-d';
                        break;
                    case 'mm/dd/yyyy':
                    default:
                        return 'm/d/Y';
                        break;
                }
            } else {
                return $tzbooking_options['date_format'];
            }
        } else {
            if ( $tzbooking_language == 'php' ) {
                return 'm/d/Y';
            } else {
                return 'mm/dd/yyyy';
            }
        }
    }
}

function tzbooking_site_date_format() {
    return apply_filters( 'tzbooking_site_date_format', get_option( 'date_format' ) );
}

/*
 * get site date format
 */
if ( ! function_exists( 'tzbooking_sanitize_date' ) ) {
    function tzbooking_sanitize_date( $tzbooking_input_date ) {
        $tzbooking_date_obj = date_create_from_format( tzbooking_get_date_format('php'), $tzbooking_input_date );
        if ( ! $tzbooking_date_obj ) {
            return '';
        }
        return sanitize_text_field( $tzbooking_input_date );
    }
}

/*
 * function to make it enable d/m/Y strtotime
 */
if ( ! function_exists( 'tzbooking_strtotime' ) ) {
    function tzbooking_strtotime( $tzbooking_input_date ) {
        if ( tzbooking_get_date_format('php') == 'd/m/Y' ) {
            $tzbooking_input_date = str_replace( '/', '-', $tzbooking_input_date );
        }
        return strtotime( $tzbooking_input_date);
    }
}

/*
 * function to make it enable d/m/Y strtotime
 */
if ( ! function_exists( 'tzbooking_get_phptime' ) ) {
    function tzbooking_get_phptime( $tzbooking_input_date ) {
        if ( ! tzbooking_strtotime( $tzbooking_input_date ) ) {
            return '';
        }
        $tzbooking_return_value =  date( tzbooking_get_date_format('php'), tzbooking_strtotime( $tzbooking_input_date ) );
        return $tzbooking_return_value;
    }
}

if ( ! function_exists( 'tzbooking_getCurrency' ) ) :
    function tzbooking_getCurrency(){

        $tzbooking_currency = '';
        $tzbooking_currency_symbol = '';
        switch( $tzbooking_currency ) {
            case 'ALL':
                $tzbooking_currency_symbol = 'L';
                break;

            case 'DZD':
                $tzbooking_currency_symbol = 'د.ج';
                break;

            case 'AFN':
                $tzbooking_currency_symbol = '؋';
                break;

            case 'ARS':
                $tzbooking_currency_symbol = '$';
                break;

            case 'AUD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'AZN':
                $tzbooking_currency_symbol = 'AZN';
                break;

            case 'BSD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'BHD':
                $tzbooking_currency_symbol = '.د.ب';
                break;

            case 'BBD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'BDT':
                $tzbooking_currency_symbol = '৳ ';
                break;

            case 'BYR':
                $tzbooking_currency_symbol = 'Br';
                break;

            case 'BZD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'BMD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'BOB':
                $tzbooking_currency_symbol = 'Bs.';
                break;

            case 'BAM':
                $tzbooking_currency_symbol = 'KM';
                break;

            case 'BWP':
                $tzbooking_currency_symbol = 'P';
                break;

            case 'BGN':
                $tzbooking_currency_symbol = 'лв.';
                break;

            case 'BRL':
                $tzbooking_currency_symbol = 'R$';
                break;

            case 'BND':
                $tzbooking_currency_symbol = '$';
                break;

            case 'KHR':
                $tzbooking_currency_symbol = '៛';
                break;

            case 'CAD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'KYD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'CLP':
                $tzbooking_currency_symbol = '$';
                break;

            case 'CNY':
                $tzbooking_currency_symbol = '¥';
                break;

            case 'COP':
                $tzbooking_currency_symbol = '$';
                break;

            case 'CRC':
                $tzbooking_currency_symbol = '₡';
                break;

            case 'HRK':
                $tzbooking_currency_symbol = 'Kn';
                break;

            case 'CUP':
                $tzbooking_currency_symbol = '$';
                break;

            case 'CZK':
                $tzbooking_currency_symbol = 'Kč';
                break;

            case 'DOP':
                $tzbooking_currency_symbol = 'RD$';
                break;

            case 'XCD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'EGP':
                $tzbooking_currency_symbol = 'EGP';
                break;

            case 'EUR':
                $tzbooking_currency_symbol = '€';
                break;

            case 'FKP':
                $tzbooking_currency_symbol = '£';
                break;

            case 'FJD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'GBP':
                $tzbooking_currency_symbol = '£';
                break;

            case 'GHC':
                $tzbooking_currency_symbol = '₵';
                break;

            case 'GIP':
                $tzbooking_currency_symbol = '£';
                break;

            case 'GTQ':
                $tzbooking_currency_symbol = 'Q';
                break;

            case 'GGP':
                $tzbooking_currency_symbol = '£';
                break;

            case 'GYD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'GEL':
                $tzbooking_currency_symbol = 'ლ';
                break;

            case 'GEL':
                $tzbooking_currency_symbol = 'ლ';
                break;

            case 'HNL':
                $tzbooking_currency_symbol = 'L';
                break;

            case 'HKD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'HUF':
                $tzbooking_currency_symbol = 'Ft';
                break;

            case 'ISK':
                $tzbooking_currency_symbol = 'kr.';
                break;

            case 'INR':
                $tzbooking_currency_symbol = '₹';
                break;

            case 'IDR':
                $tzbooking_currency_symbol = 'Rp';
                break;

            case 'IRR':
                $tzbooking_currency_symbol = '﷼';
                break;

            case 'ILS':
                $tzbooking_currency_symbol = '₪';
                break;

            case 'JMD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'JPY':
                $tzbooking_currency_symbol = '¥';
                break;

            case 'JEP':
                $tzbooking_currency_symbol = '£';
                break;

            case 'KZT':
                $tzbooking_currency_symbol = 'KZT';
                break;

            case 'KPW':
                $tzbooking_currency_symbol = '₩';
                break;

            case 'KRW':
                $tzbooking_currency_symbol = '₩';
                break;

            case 'KGS':
                $tzbooking_currency_symbol = 'сом';
                break;

            case 'KES':
                $tzbooking_currency_symbol = 'KSh';
                break;

            case 'LAK':
                $tzbooking_currency_symbol = '₭';
                break;

            case 'LBP':
                $tzbooking_currency_symbol = 'ل.ل';
                break;

            case 'LRD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'MKD':
                $tzbooking_currency_symbol = 'ден';
                break;

            case 'MYR':
                $tzbooking_currency_symbol = 'RM';
                break;

            case 'MUR':
                $tzbooking_currency_symbol = '₨';
                break;

            case 'MXN':
                $tzbooking_currency_symbol = '$';
                break;

            case 'MNT':
                $tzbooking_currency_symbol = '₮';
                break;

            case 'GEL':
                $tzbooking_currency_symbol = 'ლ';
                break;

            case 'MAD':
                $tzbooking_currency_symbol = 'د.م.';
                break;

            case 'MZN':
                $tzbooking_currency_symbol = 'MT';
                break;

            case 'NAD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'NPR':
                $tzbooking_currency_symbol = '₨';
                break;

            case 'ANG':
                $tzbooking_currency_symbol = 'ƒ';
                break;

            case 'NZD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'NIO':
                $tzbooking_currency_symbol = 'C$';
                break;

            case 'NGN':
                $tzbooking_currency_symbol = '₦';
                break;

            case 'NOK':
                $tzbooking_currency_symbol = 'kr';
                break;

            case 'OMR':
                $tzbooking_currency_symbol = 'ر.ع.';
                break;

            case 'PKR':
                $tzbooking_currency_symbol = '₨';
                break;

            case 'PAB':
                $tzbooking_currency_symbol = 'B/.';
                break;

            case 'PYG':
                $tzbooking_currency_symbol = '₲';
                break;

            case 'PEN':
                $tzbooking_currency_symbol = 'S/.';
                break;

            case 'PHP':
                $tzbooking_currency_symbol = '₱';
                break;

            case 'PLN':
                $tzbooking_currency_symbol = 'zł';
                break;

            case 'QAR':
                $tzbooking_currency_symbol = 'ر.ق';
                break;

            case 'RON':
                $tzbooking_currency_symbol = 'lei';
                break;

            case 'RUB':
                $tzbooking_currency_symbol = '₽';
                break;

            case 'SHP':
                $tzbooking_currency_symbol = '£';
                break;

            case 'SAR':
                $tzbooking_currency_symbol = 'ر.س';
                break;

            case 'RSD':
                $tzbooking_currency_symbol = 'дин.';
                break;

            case 'SCR':
                $tzbooking_currency_symbol = '₨';
                break;

            case 'SGD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'SBD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'SOS':
                $tzbooking_currency_symbol = 'Sh';
                break;

            case 'ZAR':
                $tzbooking_currency_symbol = 'R';
                break;

            case 'LKR':
                $tzbooking_currency_symbol = 'රු';
                break;

            case 'SEK':
                $tzbooking_currency_symbol = 'kr';
                break;

            case 'CHF':
                $tzbooking_currency_symbol = 'CHF';
                break;

            case 'SRD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'SYP':
                $tzbooking_currency_symbol = 'ل.س';
                break;

            case 'TWD':
                $tzbooking_currency_symbol = 'NT$';
                break;

            case 'THB':
                $tzbooking_currency_symbol = '฿';
                break;

            case 'TTD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'TRL':
                $tzbooking_currency_symbol = '₺';
                break;

            case 'UAH':
                $tzbooking_currency_symbol = '₴';
                break;

            case 'AED':
                $tzbooking_currency_symbol = 'د.إ';
                break;

            case 'USD':
                $tzbooking_currency_symbol = '$';
                break;

            case 'UYU':
                $tzbooking_currency_symbol = '$';
                break;

            case 'UZS':
                $tzbooking_currency_symbol = 'UZS';
                break;

            case 'VEF':
                $tzbooking_currency_symbol = 'Bs F';
                break;

            case 'VND':
                $tzbooking_currency_symbol = '₫';
                break;

            case 'YER':
                $tzbooking_currency_symbol = '﷼';
                break;

        }
        return $tzbooking_currency_symbol;
    }
endif;

/*
 * template locate and include function
 */
if ( ! function_exists( 'tzbooking_get_template' ) ) {
    function tzbooking_get_template( $tzbooking_template_name, $tzbooking_template_path = '' ) {
        $tzbooking_template = locate_template(
            array(
                trailingslashit( $tzbooking_template_path ) . $tzbooking_template_name,
                $tzbooking_template_name
            )
        );
        include( $tzbooking_template );
    }
}

if ( ! function_exists( 'tzbooking_get_product_cart_page' ) ) {
    function tzbooking_get_product_cart_page() {
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }
        $tzbooking_cart = isset($templaza_options['ap_product_cart_page'])?$templaza_options['ap_product_cart_page']:'';
        if ( isset($tzbooking_cart) && ! empty( $tzbooking_cart ) ) {
            return get_page_link($tzbooking_cart);
        }
        return false;
    }
}
if ( ! function_exists( 'tzbooking_get_product_checkout_page' ) ) {
    function tzbooking_get_product_checkout_page() {
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }
        $tzbooking_checkout = isset($templaza_options['ap_product_checkout_page'])?$templaza_options['ap_product_checkout_page']:'';
        if ( isset($tzbooking_checkout) && ! empty( $tzbooking_checkout ) ) {
            return get_page_link($tzbooking_checkout);
        }
        return false;
    }
}
if ( ! function_exists( 'tzbooking_get_product_wishlist_page' ) ) {
    function tzbooking_get_product_wishlist_page() {
        return false;
    }
}

if ( ! function_exists( 'tzbooking_get_product_confirm_page' ) ) {
    function tzbooking_get_product_confirm_page() {
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }
        $tzbooking_confirm = isset($templaza_options['ap_product_confirm_page'])?$templaza_options['ap_product_confirm_page']:'';
        if ( isset($tzbooking_confirm) && ! empty( $tzbooking_confirm ) ) {
            return get_page_link($tzbooking_confirm);
        }
        return false;
    }
}

if ( ! function_exists( 'tzbooking_product_calc_product_price' ) ) {
    function tzbooking_product_calc_product_price( $tzbooking_post_id, $tzbooking_date='', $tzbooking_adults=1, $tzbooking_kids=0, $tzbooking_fnr=0 ) {
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }
        $tzbooking_person_price = $tzbooking_child_price = $tzbooking_fnr_price = '';
        $adult_price  = isset($templaza_options['ap_product_data_price'])?$templaza_options['ap_product_data_price']:'';
        if($adult_price){
            $tzbooking_person_price = get_field($adult_price, $tzbooking_post_id);
        }
        $child_price  = isset($templaza_options['ap_product_data_child_price'])?$templaza_options['ap_product_data_child_price']:'';
        if($child_price){
            $tzbooking_child_price = get_field($child_price, $tzbooking_post_id);
        }
        $fnr_price  = isset($templaza_options['ap_product_data_fnr_price'])?$templaza_options['ap_product_data_fnr_price']:'';
        if($fnr_price){
            $tzbooking_fnr_price = get_field($fnr_price, $tzbooking_post_id);
        }
        if ( empty( $tzbooking_person_price ) ) $tzbooking_person_price = 0;
        if ( empty( $tzbooking_child_price ) ) $tzbooking_child_price = 0;
        if ( empty( $tzbooking_fnr_price ) ) $tzbooking_fnr_price = 0;

        $tzbooking_total = $tzbooking_person_price * $tzbooking_adults + $tzbooking_child_price * $tzbooking_kids + $tzbooking_fnr_price * $tzbooking_fnr;
        return $tzbooking_total;
    }
}

/*
 * price format
 */
if ( ! function_exists( 'tzbooking_get_price_format' ) ) {
    function tzbooking_get_price_format( $tzbooking_type = "" ) {
        $tzbooking_currency_pos = get_option('options_ap_symbol_placement', 'prepend');
        $tzbooking_format = '%1$s%2$s';
        switch ( $tzbooking_currency_pos ) {
            case 'prepend' :
                $tzbooking_format = '%1$s%2$s';
                break;
            case 'append' :
                $tzbooking_format = '%2$s%1$s';
                break;
        }

        return apply_filters( 'tzbooking_price_format', $tzbooking_format, $tzbooking_currency_pos, $tzbooking_type );
    }
}
/*
 * price function
 */
if ( ! function_exists( 'tzbooking_price' ) ) {
    function tzbooking_price( $tzbooking_amount, $tzbooking_type="" ) {

        $tzbooking_currency_symbol    = get_option('options_ap_currency_symbol', '$');
        $tzbooking_decimal_prec       = get_option('options_ap_price_num_decimals', 0);
        $tzbooking_decimal_sep        = get_option('options_ap_price_decimal_sep', ',');
        $tzbooking_thousands_sep      = get_option('options_ap_price_thousands_sep', ',');
        if ($tzbooking_decimal_prec == ''){
            $tzbooking_decimal_prec = 2;
        }
        $tzbooking_price_label = number_format((float)$tzbooking_amount, $tzbooking_decimal_prec, $tzbooking_decimal_sep, $tzbooking_thousands_sep );

        $tzbooking_format = tzbooking_get_price_format( $tzbooking_type );

        return sprintf( $tzbooking_format, $tzbooking_currency_symbol, $tzbooking_price_label );
    }
}


/*
 * get all countries
 */
if ( ! function_exists('tzbooking_get_all_countries') ) {
    function tzbooking_get_all_countries() {
        $tzbooking_countries = array(
            array(
                "code"=>"US",
                "name"=>esc_html__("United States","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"GB",
                "name"=>esc_html__("United Kingdom","travelami"),
                "d_code"=>"+44"
            ),
            array(
                "code"=>"CA",
                "name"=>esc_html__("Canada","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"AF",
                "name"=>esc_html__("Afghanistan","travelami"),
                "d_code"=>"+93"
            ),
            array(
                "code"=>"AL",
                "name"=>esc_html__("Albania","travelami"),
                "d_code"=>"+355"
            ),
            array(
                "code"=>"DZ",
                "name"=>esc_html__("Algeria","travelami"),
                "d_code"=>"+213"
            ),
            array(
                "code"=>"AS",
                "name"=>esc_html__("American Samoa","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"AD",
                "name"=>esc_html__("Andorra","travelami"),
                "d_code"=>"+376"
            ),
            array(
                "code"=>"AO",
                "name"=>esc_html__("Angola","travelami"),
                "d_code"=>"+244"
            ),
            array(
                "code"=>"AI",
                "name"=>esc_html__("Anguilla","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"AG",
                "name"=>esc_html__("Antigua","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"AR",
                "name"=>esc_html__("Argentina","travelami"),
                "d_code"=>"+54"
            ),
            array(
                "code"=>"AM",
                "name"=>esc_html__("Armenia","travelami"),
                "d_code"=>"+374"
            ),
            array(
                "code"=>"AW",
                "name"=>esc_html__("Aruba","travelami"),
                "d_code"=>"+297"
            ),
            array(
                "code"=>"AU",
                "name"=>esc_html__("Australia","travelami"),
                "d_code"=>"+61"
            ),
            array(
                "code"=>"AT",
                "name"=>esc_html__("Austria","travelami"),
                "d_code"=>"+43"
            ),
            array(
                "code"=>"AZ",
                "name"=>esc_html__("Azerbaijan","travelami"),
                "d_code"=>"+994"
            ),
            array(
                "code"=>"BH",
                "name"=>esc_html__("Bahrain","travelami"),
                "d_code"=>"+973"
            ),
            array(
                "code"=>"BD",
                "name"=>esc_html__("Bangladesh","travelami"),
                "d_code"=>"+880"
            ),
            array(
                "code"=>"BB",
                "name"=>esc_html__("Barbados","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"BY",
                "name"=>esc_html__("Belarus","travelami"),
                "d_code"=>"+375"
            ),
            array(
                "code"=>"BE",
                "name"=>esc_html__("Belgium","travelami"),
                "d_code"=>"+32"
            ),
            array(
                "code"=>"BZ",
                "name"=>esc_html__("Belize","travelami"),
                "d_code"=>"+501"
            ),
            array(
                "code"=>"BJ",
                "name"=>esc_html__("Benin","travelami"),
                "d_code"=>"+229"
            ),
            array(
                "code"=>"BM",
                "name"=>esc_html__("Bermuda","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"BT",
                "name"=>esc_html__("Bhutan","travelami"),
                "d_code"=>"+975"
            ),
            array(
                "code"=>"BO",
                "name"=>esc_html__("Bolivia","travelami"),
                "d_code"=>"+591"
            ),
            array(
                "code"=>"BA",
                "name"=>esc_html__("Bosnia and Herzegovina","travelami"),
                "d_code"=>"+387"
            ),
            array(
                "code"=>"BW",
                "name"=>esc_html__("Botswana","travelami"),
                "d_code"=>"+267"
            ),
            array(
                "code"=>"BR",
                "name"=>esc_html__("Brazil","travelami"),
                "d_code"=>"+55"
            ),
            array(
                "code"=>"IO",
                "name"=>esc_html__("British Indian Ocean Territory","travelami"),
                "d_code"=>"+246"
            ),
            array(
                "code"=>"VG",
                "name"=>esc_html__("British Virgin Islands","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"BN",
                "name"=>esc_html__("Brunei","travelami"),
                "d_code"=>"+673"
            ),
            array(
                "code"=>"BG",
                "name"=>esc_html__("Bulgaria","travelami"),
                "d_code"=>"+359"
            ),
            array(
                "code"=>"BF",
                "name"=>esc_html__("Burkina Faso","travelami"),
                "d_code"=>"+226"
            ),
            array(
                "code"=>"MM",
                "name"=>esc_html__("Burma Myanmar","travelami"),
                "d_code"=>"+95"
            ),
            array(
                "code"=>"BI",
                "name"=>esc_html__("Burundi","travelami"),
                "d_code"=>"+257"
            ),
            array(
                "code"=>"KH",
                "name"=>esc_html__("Cambodia","travelami"),
                "d_code"=>"+855"
            ),
            array(
                "code"=>"CM",
                "name"=>esc_html__("Cameroon","travelami"),
                "d_code"=>"+237"
            ),
            array(
                "code"=>"CV",
                "name"=>esc_html__("Cape Verde","travelami"),
                "d_code"=>"+238"
            ),
            array(
                "code"=>"KY",
                "name"=>esc_html__("Cayman Islands","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"CF",
                "name"=>esc_html__("Central African Republic","travelami"),
                "d_code"=>"+236"
            ),
            array(
                "code"=>"TD",
                "name"=>esc_html__("Chad","travelami"),
                "d_code"=>"+235"
            ),
            array(
                "code"=>"CL",
                "name"=>esc_html__("Chile","travelami"),
                "d_code"=>"+56"
            ),
            array(
                "code"=>"CN",
                "name"=>esc_html__("China","travelami"),
                "d_code"=>"+86"
            ),
            array(
                "code"=>"CO",
                "name"=>esc_html__("Colombia","travelami"),
                "d_code"=>"+57"
            ),
            array(
                "code"=>"KM",
                "name"=>esc_html__("Comoros","travelami"),
                "d_code"=>"+269"
            ),
            array(
                "code"=>"CK",
                "name"=>esc_html__("Cook Islands","travelami"),
                "d_code"=>"+682"
            ),
            array(
                "code"=>"CR",
                "name"=>esc_html__("Costa Rica","travelami"),
                "d_code"=>"+506"
            ),
            array(
                "code"=>"CI",
                "name"=>esc_html__("Cote d'Ivoire","travelami"),
                "d_code"=>"+225"
            ),
            array(
                "code"=>"HR",
                "name"=>esc_html__("Croatia","travelami"),
                "d_code"=>"+385"
            ),
            array(
                "code"=>"CU",
                "name"=>esc_html__("Cuba","travelami"),
                "d_code"=>"+53"
            ),
            array(
                "code"=>"CY",
                "name"=>esc_html__("Cyprus","travelami"),
                "d_code"=>"+357"
            ),
            array(
                "code"=>"CZ",
                "name"=>esc_html__("Czech Republic","travelami"),
                "d_code"=>"+420"
            ),
            array(
                "code"=>"CD",
                "name"=>esc_html__("Democratic Republic of Congo","travelami"),
                "d_code"=>"+243"
            ),
            array(
                "code"=>"DK",
                "name"=>esc_html__("Denmark","travelami"),
                "d_code"=>"+45"
            ),
            array(
                "code"=>"DJ",
                "name"=>esc_html__("Djibouti","travelami"),
                "d_code"=>"+253"
            ),
            array(
                "code"=>"DM",
                "name"=>esc_html__("Dominica","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"DO",
                "name"=>esc_html__("Dominican Republic","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"EC",
                "name"=>esc_html__("Ecuador","travelami"),
                "d_code"=>"+593"
            ),
            array(
                "code"=>"EG",
                "name"=>esc_html__("Egypt","travelami"),
                "d_code"=>"+20"
            ),
            array(
                "code"=>"SV",
                "name"=>esc_html__("El Salvador","travelami"),
                "d_code"=>"+503"
            ),
            array(
                "code"=>"GQ",
                "name"=>esc_html__("Equatorial Guinea","travelami"),
                "d_code"=>"+240"
            ),
            array(
                "code"=>"ER",
                "name"=>esc_html__("Eritrea","travelami"),
                "d_code"=>"+291"
            ),
            array(
                "code"=>"EE",
                "name"=>esc_html__("Estonia","travelami"),
                "d_code"=>"+372"
            ),
            array(
                "code"=>"ET",
                "name"=>esc_html__("Ethiopia","travelami"),
                "d_code"=>"+251"
            ),
            array(
                "code"=>"FK",
                "name"=>esc_html__("Falkland Islands","travelami"),
                "d_code"=>"+500"
            ),
            array(
                "code"=>"FO",
                "name"=>esc_html__("Faroe Islands","travelami"),
                "d_code"=>"+298"
            ),
            array(
                "code"=>"FM",
                "name"=>esc_html__("Federated States of Micronesia","travelami"),
                "d_code"=>"+691"
            ),
            array(
                "code"=>"FJ",
                "name"=>esc_html__("Fiji","travelami"),
                "d_code"=>"+679"
            ),
            array(
                "code"=>"FI",
                "name"=>esc_html__("Finland","travelami"),
                "d_code"=>"+358"
            ),
            array(
                "code"=>"FR",
                "name"=>esc_html__("France","travelami"),
                "d_code"=>"+33"
            ),
            array(
                "code"=>"GF",
                "name"=>esc_html__("French Guiana","travelami"),
                "d_code"=>"+594"
            ),
            array(
                "code"=>"PF",
                "name"=>esc_html__("French Polynesia","travelami"),
                "d_code"=>"+689"
            ),
            array(
                "code"=>"GA",
                "name"=>esc_html__("Gabon","travelami"),
                "d_code"=>"+241"
            ),
            array(
                "code"=>"GE",
                "name"=>esc_html__("Georgia","travelami"),
                "d_code"=>"+995"
            ),
            array(
                "code"=>"DE",
                "name"=>esc_html__("Germany","travelami"),
                "d_code"=>"+49"
            ),
            array(
                "code"=>"GH",
                "name"=>esc_html__("Ghana","travelami"),
                "d_code"=>"+233"
            ),
            array(
                "code"=>"GI",
                "name"=>esc_html__("Gibraltar","travelami"),
                "d_code"=>"+350"
            ),
            array(
                "code"=>"GR",
                "name"=>esc_html__("Greece","travelami"),
                "d_code"=>"+30"
            ),
            array(
                "code"=>"GL",
                "name"=>esc_html__("Greenland","travelami"),
                "d_code"=>"+299"
            ),
            array(
                "code"=>"GD",
                "name"=>esc_html__("Grenada","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"GP",
                "name"=>esc_html__("Guadeloupe","travelami"),
                "d_code"=>"+590"
            ),
            array(
                "code"=>"GU",
                "name"=>esc_html__("Guam","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"GT",
                "name"=>esc_html__("Guatemala","travelami"),
                "d_code"=>"+502"
            ),
            array(
                "code"=>"GN",
                "name"=>esc_html__("Guinea","travelami"),
                "d_code"=>"+224"
            ),
            array(
                "code"=>"GW",
                "name"=>esc_html__("Guinea-Bissau","travelami"),
                "d_code"=>"+245"
            ),
            array(
                "code"=>"GY",
                "name"=>esc_html__("Guyana","travelami"),
                "d_code"=>"+592"
            ),
            array(
                "code"=>"HT",
                "name"=>esc_html__("Haiti","travelami"),
                "d_code"=>"+509"
            ),
            array(
                "code"=>"HN",
                "name"=>esc_html__("Honduras","travelami"),
                "d_code"=>"+504"
            ),
            array(
                "code"=>"HK",
                "name"=>esc_html__("Hong Kong","travelami"),
                "d_code"=>"+852"
            ),
            array(
                "code"=>"HU",
                "name"=>esc_html__("Hungary","travelami"),
                "d_code"=>"+36"
            ),
            array(
                "code"=>"IS",
                "name"=>esc_html__("Iceland","travelami"),
                "d_code"=>"+354"
            ),
            array(
                "code"=>"IN",
                "name"=>esc_html__("India","travelami"),
                "d_code"=>"+91"
            ),
            array(
                "code"=>"ID",
                "name"=>esc_html__("Indonesia","travelami"),
                "d_code"=>"+62"
            ),
            array(
                "code"=>"IR",
                "name"=>esc_html__("Iran","travelami"),
                "d_code"=>"+98"
            ),
            array(
                "code"=>"IQ",
                "name"=>esc_html__("Iraq","travelami"),
                "d_code"=>"+964"
            ),
            array(
                "code"=>"IE",
                "name"=>esc_html__("Ireland","travelami"),
                "d_code"=>"+353"
            ),
            array(
                "code"=>"IL",
                "name"=>esc_html__("Israel","travelami"),
                "d_code"=>"+972"
            ),
            array(
                "code"=>"IT",
                "name"=>esc_html__("Italy","travelami"),
                "d_code"=>"+39"
            ),
            array(
                "code"=>"JM",
                "name"=>esc_html__("Jamaica","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"JP",
                "name"=>esc_html__("Japan","travelami"),
                "d_code"=>"+81"
            ),
            array(
                "code"=>"JO",
                "name"=>esc_html__("Jordan","travelami"),
                "d_code"=>"+962"
            ),
            array(
                "code"=>"KZ",
                "name"=>esc_html__("Kazakhstan","travelami"),
                "d_code"=>"+7"
            ),
            array(
                "code"=>"KE",
                "name"=>esc_html__("Kenya","travelami"),
                "d_code"=>"+254"
            ),
            array(
                "code"=>"KI",
                "name"=>esc_html__("Kiribati","travelami"),
                "d_code"=>"+686"
            ),
            array(
                "code"=>"XK",
                "name"=>esc_html__("Kosovo","travelami"),
                "d_code"=>"+381"
            ),
            array(
                "code"=>"KW",
                "name"=>esc_html__("Kuwait","travelami"),
                "d_code"=>"+965"
            ),
            array(
                "code"=>"KG",
                "name"=>esc_html__("Kyrgyzstan","travelami"),
                "d_code"=>"+996"
            ),
            array(
                "code"=>"LA",
                "name"=>esc_html__("Laos","travelami"),
                "d_code"=>"+856"
            ),
            array(
                "code"=>"LV",
                "name"=>esc_html__("Latvia","travelami"),
                "d_code"=>"+371"
            ),
            array(
                "code"=>"LB",
                "name"=>esc_html__("Lebanon","travelami"),
                "d_code"=>"+961"
            ),
            array(
                "code"=>"LS",
                "name"=>esc_html__("Lesotho","travelami"),
                "d_code"=>"+266"
            ),
            array(
                "code"=>"LR",
                "name"=>esc_html__("Liberia","travelami"),
                "d_code"=>"+231"
            ),
            array(
                "code"=>"LY",
                "name"=>esc_html__("Libya","travelami"),
                "d_code"=>"+218"
            ),
            array(
                "code"=>"LI",
                "name"=>esc_html__("Liechtenstein","travelami"),
                "d_code"=>"+423"
            ),
            array(
                "code"=>"LT",
                "name"=>esc_html__("Lithuania","travelami"),
                "d_code"=>"+370"
            ),
            array(
                "code"=>"LU",
                "name"=>esc_html__("Luxembourg","travelami"),
                "d_code"=>"+352"
            ),
            array(
                "code"=>"MO",
                "name"=>esc_html__("Macau","travelami"),
                "d_code"=>"+853"
            ),
            array(
                "code"=>"MK",
                "name"=>esc_html__("Macedonia","travelami"),
                "d_code"=>"+389"
            ),
            array(
                "code"=>"MG",
                "name"=>esc_html__("Madagascar","travelami"),
                "d_code"=>"+261"
            ),
            array(
                "code"=>"MW",
                "name"=>esc_html__("Malawi","travelami"),
                "d_code"=>"+265"
            ),
            array(
                "code"=>"MY",
                "name"=>esc_html__("Malaysia","travelami"),
                "d_code"=>"+60"
            ),
            array(
                "code"=>"MV",
                "name"=>esc_html__("Maldives","travelami"),
                "d_code"=>"+960"
            ),
            array(
                "code"=>"ML",
                "name"=>esc_html__("Mali","travelami"),
                "d_code"=>"+223"
            ),
            array(
                "code"=>"MT",
                "name"=>esc_html__("Malta","travelami"),
                "d_code"=>"+356"
            ),
            array(
                "code"=>"MH",
                "name"=>esc_html__("Marshall Islands","travelami"),
                "d_code"=>"+692"
            ),
            array(
                "code"=>"MQ",
                "name"=>esc_html__("Martinique","travelami"),
                "d_code"=>"+596"
            ),
            array(
                "code"=>"MR",
                "name"=>esc_html__("Mauritania","travelami"),
                "d_code"=>"+222"
            ),
            array(
                "code"=>"MU",
                "name"=>esc_html__("Mauritius","travelami"),
                "d_code"=>"+230"
            ),
            array(
                "code"=>"YT",
                "name"=>esc_html__("Mayotte","travelami"),
                "d_code"=>"+262"
            ),
            array(
                "code"=>"MX",
                "name"=>esc_html__("Mexico","travelami"),
                "d_code"=>"+52"
            ),
            array(
                "code"=>"MD",
                "name"=>esc_html__("Moldova","travelami"),
                "d_code"=>"+373"
            ),
            array(
                "code"=>"MC",
                "name"=>esc_html__("Monaco","travelami"),
                "d_code"=>"+377"
            ),
            array(
                "code"=>"MN",
                "name"=>esc_html__("Mongolia","travelami"),
                "d_code"=>"+976"
            ),
            array(
                "code"=>"ME",
                "name"=>esc_html__("Montenegro","travelami"),
                "d_code"=>"+382"
            ),
            array(
                "code"=>"MS",
                "name"=>esc_html__("Montserrat","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"MA",
                "name"=>esc_html__("Morocco","travelami"),
                "d_code"=>"+212"
            ),
            array(
                "code"=>"MZ",
                "name"=>esc_html__("Mozambique","travelami"),
                "d_code"=>"+258"
            ),
            array(
                "code"=>"NA",
                "name"=>esc_html__("Namibia","travelami"),
                "d_code"=>"+264"
            ),
            array(
                "code"=>"NR",
                "name"=>esc_html__("Nauru","travelami"),
                "d_code"=>"+674"
            ),
            array(
                "code"=>"NP",
                "name"=>esc_html__("Nepal","travelami"),
                "d_code"=>"+977"
            ),
            array(
                "code"=>"NL",
                "name"=>esc_html__("Netherlands","travelami"),
                "d_code"=>"+31"
            ),
            array(
                "code"=>"AN",
                "name"=>esc_html__("Netherlands Antilles","travelami"),
                "d_code"=>"+599"
            ),
            array(
                "code"=>"NC",
                "name"=>esc_html__("New Caledonia","travelami"),
                "d_code"=>"+687"
            ),
            array(
                "code"=>"NZ",
                "name"=>esc_html__("New Zealand","travelami"),
                "d_code"=>"+64"
            ),
            array(
                "code"=>"NI",
                "name"=>esc_html__("Nicaragua","travelami"),
                "d_code"=>"+505"
            ),
            array(
                "code"=>"NE",
                "name"=>esc_html__("Niger","travelami"),
                "d_code"=>"+227"
            ),
            array(
                "code"=>"NG",
                "name"=>esc_html__("Nigeria","travelami"),
                "d_code"=>"+234"
            ),
            array(
                "code"=>"NU",
                "name"=>esc_html__("Niue","travelami"),
                "d_code"=>"+683"
            ),
            array(
                "code"=>"NF",
                "name"=>esc_html__("Norfolk Island","travelami"),
                "d_code"=>"+672"
            ),
            array(
                "code"=>"KP",
                "name"=>esc_html__("North Korea","travelami"),
                "d_code"=>"+850"
            ),
            array(
                "code"=>"MP",
                "name"=>esc_html__("Northern Mariana Islands","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"NO",
                "name"=>esc_html__("Norway","travelami"),
                "d_code"=>"+47"
            ),
            array(
                "code"=>"OM",
                "name"=>esc_html__("Oman","travelami"),
                "d_code"=>"+968"
            ),
            array(
                "code"=>"PK",
                "name"=>esc_html__("Pakistan","travelami"),
                "d_code"=>"+92"
            ),
            array(
                "code"=>"PW",
                "name"=>esc_html__("Palau","travelami"),
                "d_code"=>"+680"
            ),
            array(
                "code"=>"PS",
                "name"=>esc_html__("Palestine","travelami"),
                "d_code"=>"+970"
            ),
            array(
                "code"=>"PA",
                "name"=>esc_html__("Panama","travelami"),
                "d_code"=>"+507"
            ),
            array(
                "code"=>"PG",
                "name"=>esc_html__("Papua New Guinea","travelami"),
                "d_code"=>"+675"
            ),
            array(
                "code"=>"PY",
                "name"=>esc_html__("Paraguay","travelami"),
                "d_code"=>"+595"
            ),
            array(
                "code"=>"PE",
                "name"=>esc_html__("Peru","travelami"),
                "d_code"=>"+51"
            ),
            array(
                "code"=>"PH",
                "name"=>esc_html__("Philippines","travelami"),
                "d_code"=>"+63"
            ),
            array(
                "code"=>"PL",
                "name"=>esc_html__("Poland","travelami"),
                "d_code"=>"+48"
            ),
            array(
                "code"=>"PT",
                "name"=>esc_html__("Portugal","travelami"),
                "d_code"=>"+351"
            ),
            array(
                "code"=>"PR",
                "name"=>esc_html__("Puerto Rico","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"QA",
                "name"=>esc_html__("Qatar","travelami"),
                "d_code"=>"+974"
            ),
            array(
                "code"=>"CG",
                "name"=>esc_html__("Republic of the Congo","travelami"),
                "d_code"=>"+242"
            ),
            array(
                "code"=>"RE",
                "name"=>esc_html__("Reunion","travelami"),
                "d_code"=>"+262"
            ),
            array(
                "code"=>"RO",
                "name"=>esc_html__("Romania","travelami"),
                "d_code"=>"+40"
            ),
            array(
                "code"=>"RU",
                "name"=>esc_html__("Russia","travelami"),
                "d_code"=>"+7"
            ),
            array(
                "code"=>"RW",
                "name"=>esc_html__("Rwanda","travelami"),
                "d_code"=>"+250"
            ),
            array(
                "code"=>"BL",
                "name"=>esc_html__("Saint Barthelemy","travelami"),
                "d_code"=>"+590"
            ),
            array(
                "code"=>"SH",
                "name"=>esc_html__("Saint Helena","travelami"),
                "d_code"=>"+290"
            ),
            array(
                "code"=>"KN",
                "name"=>esc_html__("Saint Kitts and Nevis","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"MF",
                "name"=>esc_html__("Saint Martin","travelami"),
                "d_code"=>"+590"
            ),
            array(
                "code"=>"PM",
                "name"=>esc_html__("Saint Pierre and Miquelon","travelami"),
                "d_code"=>"+508"
            ),
            array(
                "code"=>"VC",
                "name"=>esc_html__("Saint Vincent and the Grenadines","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"WS",
                "name"=>esc_html__("Samoa","travelami"),
                "d_code"=>"+685"
            ),
            array(
                "code"=>"SM",
                "name"=>esc_html__("San Marino","travelami"),
                "d_code"=>"+378"
            ),
            array(
                "code"=>"ST",
                "name"=>esc_html__("Sao Tome and Principe","travelami"),
                "d_code"=>"+239"
            ),
            array(
                "code"=>"SA",
                "name"=>esc_html__("Saudi Arabia","travelami"),
                "d_code"=>"+966"
            ),
            array(
                "code"=>"SN",
                "name"=>esc_html__("Senegal","travelami"),
                "d_code"=>"+221"
            ),
            array(
                "code"=>"RS",
                "name"=>esc_html__("Serbia","travelami"),
                "d_code"=>"+381"
            ),
            array(
                "code"=>"SC",
                "name"=>esc_html__("Seychelles","travelami"),
                "d_code"=>"+248"
            ),
            array(
                "code"=>"SL",
                "name"=>esc_html__("Sierra Leone","travelami"),
                "d_code"=>"+232"
            ),
            array(
                "code"=>"SG",
                "name"=>esc_html__("Singapore","travelami"),
                "d_code"=>"+65"
            ),
            array(
                "code"=>"SK",
                "name"=>esc_html__("Slovakia","travelami"),
                "d_code"=>"+421"
            ),
            array(
                "code"=>"SI",
                "name"=>esc_html__("Slovenia","travelami"),
                "d_code"=>"+386"
            ),
            array(
                "code"=>"SB",
                "name"=>esc_html__("Solomon Islands","travelami"),
                "d_code"=>"+677"
            ),
            array(
                "code"=>"SO",
                "name"=>esc_html__("Somalia","travelami"),
                "d_code"=>"+252"
            ),
            array(
                "code"=>"ZA",
                "name"=>esc_html__("South Africa","travelami"),
                "d_code"=>"+27"
            ),
            array(
                "code"=>"KR",
                "name"=>esc_html__("South Korea","travelami"),
                "d_code"=>"+82"
            ),
            array(
                "code"=>"ES",
                "name"=>esc_html__("Spain","travelami"),
                "d_code"=>"+34"
            ),
            array(
                "code"=>"LK",
                "name"=>esc_html__("Sri Lanka","travelami"),
                "d_code"=>"+94"
            ),
            array(
                "code"=>"LC",
                "name"=>esc_html__("St. Lucia","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"SD",
                "name"=>esc_html__("Sudan","travelami"),
                "d_code"=>"+249"
            ),
            array(
                "code"=>"SR",
                "name"=>esc_html__("Suriname","travelami"),
                "d_code"=>"+597"
            ),
            array(
                "code"=>"SZ",
                "name"=>esc_html__("Swaziland","travelami"),
                "d_code"=>"+268"
            ),
            array(
                "code"=>"SE",
                "name"=>esc_html__("Sweden","travelami"),
                "d_code"=>"+46"
            ),
            array(
                "code"=>"CH",
                "name"=>esc_html__("Switzerland","travelami"),
                "d_code"=>"+41"
            ),
            array(
                "code"=>"SY",
                "name"=>esc_html__("Syria","travelami"),
                "d_code"=>"+963"
            ),
            array(
                "code"=>"TW",
                "name"=>esc_html__("Taiwan","travelami"),
                "d_code"=>"+886"
            ),
            array(
                "code"=>"TJ",
                "name"=>esc_html__("Tajikistan","travelami"),
                "d_code"=>"+992"
            ),
            array(
                "code"=>"TZ",
                "name"=>esc_html__("Tanzania","travelami"),
                "d_code"=>"+255"
            ),
            array(
                "code"=>"TH",
                "name"=>esc_html__("Thailand","travelami"),
                "d_code"=>"+66"
            ),
            array(
                "code"=>"BS",
                "name"=>esc_html__("The Bahamas","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"GM",
                "name"=>esc_html__("The Gambia","travelami"),
                "d_code"=>"+220"
            ),
            array(
                "code"=>"TL",
                "name"=>esc_html__("Timor-Leste","travelami"),
                "d_code"=>"+670"
            ),
            array(
                "code"=>"TG",
                "name"=>esc_html__("Togo","travelami"),
                "d_code"=>"+228"
            ),
            array(
                "code"=>"TK",
                "name"=>esc_html__("Tokelau","travelami"),
                "d_code"=>"+690"
            ),
            array(
                "code"=>"TO",
                "name"=>esc_html__("Tonga","travelami"),
                "d_code"=>"+676"
            ),
            array(
                "code"=>"TT",
                "name"=>esc_html__("Trinidad and Tobago","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"TN",
                "name"=>esc_html__("Tunisia","travelami"),
                "d_code"=>"+216"
            ),
            array(
                "code"=>"TR",
                "name"=>esc_html__("Turkey","travelami"),
                "d_code"=>"+90"
            ),
            array(
                "code"=>"TM",
                "name"=>esc_html__("Turkmenistan","travelami"),
                "d_code"=>"+993"
            ),
            array(
                "code"=>"TC",
                "name"=>esc_html__("Turks and Caicos Islands","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"TV",
                "name"=>esc_html__("Tuvalu","travelami"),
                "d_code"=>"+688"
            ),
            array(
                "code"=>"UG",
                "name"=>esc_html__("Uganda","travelami"),
                "d_code"=>"+256"
            ),
            array(
                "code"=>"UA",
                "name"=>esc_html__("Ukraine","travelami"),
                "d_code"=>"+380"
            ),
            array(
                "code"=>"AE",
                "name"=>esc_html__("United Arab Emirates","travelami"),
                "d_code"=>"+971"
            ),
            array(
                "code"=>"UY",
                "name"=>esc_html__("Uruguay","travelami"),
                "d_code"=>"+598"
            ),
            array(
                "code"=>"VI",
                "name"=>esc_html__("US Virgin Islands","travelami"),
                "d_code"=>"+1"
            ),
            array(
                "code"=>"UZ",
                "name"=>esc_html__("Uzbekistan","travelami"),
                "d_code"=>"+998"
            ),
            array(
                "code"=>"VU",
                "name"=>esc_html__("Vanuatu","travelami"),
                "d_code"=>"+678"
            ),
            array(
                "code"=>"VA",
                "name"=>esc_html__("Vatican City","travelami"),
                "d_code"=>"+39"
            ),
            array(
                "code"=>"VE",
                "name"=>esc_html__("Venezuela","travelami"),
                "d_code"=>"+58"
            ),
            array(
                "code"=>"VN",
                "name"=>esc_html__("Vietnam","travelami"),
                "d_code"=>"+84"
            ),
            array(
                "code"=>"WF",
                "name"=>esc_html__("Wallis and Futuna","travelami"),
                "d_code"=>"+681"
            ),
            array(
                "code"=>"YE",
                "name"=>esc_html__("Yemen","travelami"),
                "d_code"=>"+967"
            ),
            array(
                "code"=>"ZM",
                "name"=>esc_html__("Zambia","travelami"),
                "d_code"=>"+260"
            ),
            array(
                "code"=>"ZW",
                "name"=>esc_html__("Zimbabwe","travelami"),
                "d_code"=>"+263"
            ),
        );
        return $tzbooking_countries;
    }
}

/*
 * Get current user info
 */
if ( ! function_exists( 'tzbooking_get_current_user_info' ) ) {
    function tzbooking_get_current_user_info( ) {
        $tzbooking_user_info = array(
            'display_name'  => '',
            'login'         => '',
            'first_name'    => '',
            'last_name'     => '',
            'email'         => '',
            'description'   => '',
            'country_code'  => '',
            'phone'         => '',
            'address'       => '',
            'city'          => '',
            'state'         => '',
            'zip'           => '',
            'country'       => '',
            'company'       => '',
            'photo_url'     => '',
            'order_notes'   => ''
        );
        if ( is_user_logged_in() ) {
            $tzbooking_current_user = wp_get_current_user();
            $tzbooking_user_id = $tzbooking_current_user->ID;
            $tzbooking_user_info['display_name']     = $tzbooking_current_user->user_firstname;
            $tzbooking_user_info['login']            = $tzbooking_current_user->user_login;
            $tzbooking_user_info['first_name']       = $tzbooking_current_user->user_firstname;
            $tzbooking_user_info['last_name']        = $tzbooking_current_user->user_lastname;
            $tzbooking_user_info['email']            = $tzbooking_current_user->user_email;
            $tzbooking_user_info['description']      = $tzbooking_current_user->description;
            $tzbooking_user_info['country_code']     = get_user_meta( $tzbooking_user_id, 'country_code', true );
            $tzbooking_user_info['phone']            = get_user_meta( $tzbooking_user_id, 'phone', true );
            $tzbooking_user_info['address']          = get_user_meta( $tzbooking_user_id, 'address', true );
            $tzbooking_user_info['city']             = get_user_meta( $tzbooking_user_id, 'city', true );
            $tzbooking_user_info['state']            = get_user_meta( $tzbooking_user_id, 'state', true );
            $tzbooking_user_info['zip']              = get_user_meta( $tzbooking_user_id, 'zip', true );
            $tzbooking_user_info['city']        		= get_user_meta( $tzbooking_user_id, 'city', true );
            $tzbooking_user_info['company']          = get_user_meta( $tzbooking_user_id, 'company', true );
            $tzbooking_user_info['order_notes']      = get_user_meta( $tzbooking_user_id, 'order_notes', true );
            $tzbooking_user_info['photo_url']        = ( isset( $tzbooking_current_user->photo_url ) && ! empty( $tzbooking_current_user->photo_url ) ) ? $tzbooking_current_user->photo_url : '';
        }
        return $tzbooking_user_info;
    }
}

/*
 * Update Cart Action
 */

add_action( 'wp_ajax_tzbooking_product_update_cart', 'tzbooking_product_update_cart' );
add_action( 'wp_ajax_nopriv_tzbooking_product_update_cart', 'tzbooking_product_update_cart' );

if ( ! function_exists( 'tzbooking_product_update_cart' ) ) {
    function tzbooking_product_update_cart() {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'product_update_cart' ) ) {
            print esc_html__( 'Sorry, your nonce did not verify.', 'travelami' );
            exit;
        }
        // validation
        if ( ! isset( $_POST['product_id'] ) || ! isset( $_POST['date'] ) ) {
            wp_send_json( array( 'success'=>0, 'message'=>esc_html__( 'Some validation error is occurred while calculate price.', 'travelami' ) ) );
        }

        // init variables
        $tzbooking_product_id = $_POST['product_id'];
        $tzbooking_date = $_POST['date'];
        $tzbooking_time = $_POST['time'];
        $tzbooking_first_name = $_POST['first_name'];
        $tzbooking_last_name = '';
        $tzbooking_email = $_POST['your_email'];
        $tzbooking_phone = $_POST['your_phone'];
        $tzbooking_total_adults = 222;
        $tzbooking_total_kids = 1111;
        $tzbooking_name_combo = ( isset( $_POST['name_combo'] ) ) ? $_POST['name_combo'] : '';
        $tzbooking_people_combo = ( isset( $_POST['people_combo'] ) ) ? $_POST['people_combo'] : '';
        $tzbooking_price_combo = ( isset( $_POST['price_combo'] ) ) ? $_POST['price_combo'] : 0;
        $tzbooking_adults = ( isset( $_POST['adults'] ) ) ? $_POST['adults'] : 1;
        $tzbooking_kids = ( isset( $_POST['kids'] ) ) ? $_POST['kids'] : 0;
        $total_price = tzbooking_product_calc_product_price( $tzbooking_product_id, $tzbooking_date, $tzbooking_adults, $tzbooking_kids );
        if( $tzbooking_price_combo != '' && $tzbooking_price_combo != 'custom' ){
            $total_price = intval($tzbooking_price_combo);
        }
//		$tzbooking_uid = $tzbooking_product_id . $tzbooking_date;
        $tzbooking_uid = $tzbooking_product_id . str_replace( array('/') , '', $tzbooking_date )  . str_replace( array(':') , '', $tzbooking_time );
        $cart_data = array();

        // function
        $tzbooking_product_data = array();
        $tzbooking_product_data['adults'] 	    = $tzbooking_adults;
        $tzbooking_product_data['kids'] 		= $tzbooking_kids;
        $tzbooking_product_data['product_id'] 	    = $tzbooking_product_id;
        $tzbooking_product_data['date']         = $tzbooking_date;
        $tzbooking_product_data['time']         = $tzbooking_time;
        $tzbooking_product_data['first_name']   = $tzbooking_first_name;
        $tzbooking_product_data['last_name']    = $tzbooking_last_name;
        $tzbooking_product_data['email']        = $tzbooking_email;
        $tzbooking_product_data['phone']        = $tzbooking_phone;
        $tzbooking_product_data['name_combo']   = $tzbooking_name_combo;
        $tzbooking_product_data['people_combo'] = $tzbooking_people_combo;
        $tzbooking_product_data['price_combo']  = $tzbooking_price_combo;
        $tzbooking_product_data['total_price']  = $total_price;
        $tzbooking_product_data['total_adults'] = $tzbooking_total_adults;
        $tzbooking_product_data['total_kids']   = $tzbooking_total_kids;
        TZbooking_Session_Cart::tzbooking_set( $tzbooking_uid, $tzbooking_product_data );
        wp_send_json( array( 'success'=>1, 'message'=>esc_html__('success','travelami'), 'uid'=>$tzbooking_uid,'time'=>$tzbooking_time,'tourdata'=>$tzbooking_product_data ) );
    }
}

/*
 * Delete Cart Action
 */

add_action( 'wp_ajax_tzbooking_product_delete_cart', 'tzbooking_product_delete_cart' );
add_action( 'wp_ajax_nopriv_tzbooking_product_delete_cart', 'tzbooking_product_delete_cart' );

if ( ! function_exists( 'tzbooking_product_delete_cart' ) ) {
    function tzbooking_product_delete_cart() {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'product_update_cart' ) ) {
            print esc_html__( 'Sorry, your nonce did not verify.', 'travelami' );
            exit;
        }
        // validation
        if ( ! isset( $_POST['product_id'] ) || ! isset( $_POST['date'] ) ) {
            wp_send_json( array( 'success'=>0, 'message'=>__( 'Some validation error is occurred while calculate price.', 'travelami' ) ) );
        }

        // init variables
        $tzbooking_product_id = $_POST['product_id'];
        $tzbooking_date = $_POST['date'];
        $tzbooking_time = $_POST['time'];
//		$tzbooking_uid = $tzbooking_product_id . $tzbooking_date;
        $tzbooking_uid = $tzbooking_product_id . str_replace( array('/') , '', $tzbooking_date )  . str_replace( array(':') , '', $tzbooking_time );

        TZbooking_Session_Cart::tzbooking_unset( $tzbooking_uid);
        wp_send_json( array( 'success'=>1, 'message'=>'success'));
    }
}

/*
 * Add to Wishlist Action
 */

add_action( 'wp_ajax_add_to_wishlist', 'tzbooking_ajax_add_wishlist' );
add_action( 'wp_ajax_nopriv_add_to_wishlist', 'tzbooking_ajax_add_wishlist' );

if ( ! function_exists( 'tzbooking_ajax_add_wishlist' ) ) {
    function tzbooking_ajax_add_wishlist() {
        $tzbooking_result_json = array( 'success' => 0, 'result' => array(), 'order_id' => 0 );
        if ( ! is_user_logged_in() ) {
            $tzbooking_result_json['success'] = 0;
            $tzbooking_result_json['result'] = esc_html__( 'Please login to update your wishlist.', 'travelami' );
            wp_send_json( $tzbooking_result_json );
        }
        $tzbooking_user_id = get_current_user_id();
        $tzbooking_new_item_id = sanitize_text_field( $_POST['post_id'] );
        $tzbooking_wishlist = get_user_meta( $tzbooking_user_id, 'wishlist', true );
        if ( isset( $_POST['remove'] ) ) {
            //remove
            $tzbooking_wishlist = array_diff( $tzbooking_wishlist, array( $tzbooking_new_item_id ) );
            if ( update_user_meta( $tzbooking_user_id, 'wishlist', $tzbooking_wishlist ) ) {
                $tzbooking_result_json['success'] = 1;
                $tzbooking_result_json['result'] = esc_html__( 'This post has removed from your wishlist successfully.', 'travelami' );
            } else {
                $tzbooking_result_json['success'] = 0;
                $tzbooking_result_json['result'] = esc_html__( 'Sorry, An error occurred while update wishlist.', 'travelami' );
            }
        } else {
            //add
            if ( empty( $tzbooking_wishlist ) ) $tzbooking_wishlist = array();
            if ( ! in_array( $tzbooking_new_item_id, $tzbooking_wishlist) ) {
                array_push( $tzbooking_wishlist, $tzbooking_new_item_id );
                if ( update_user_meta( $tzbooking_user_id, 'wishlist', $tzbooking_wishlist ) ) {
                    $tzbooking_result_json['success'] = 1;
                    $tzbooking_result_json['result'] = esc_html__( 'This post has added to your wishlist successfully.', 'travelami' );
                } else {
                    $tzbooking_result_json['success'] = 0;
                    $tzbooking_result_json['result'] = esc_html__( 'Sorry, An error occurred while update wishlist.', 'travelami' );
                }
            } else {
                $tzbooking_result_json['success'] = 1;
                $tzbooking_result_json['result'] = esc_html__( 'Already exists in your wishlist.', 'travelami' );
            }
        }
        wp_send_json( $tzbooking_result_json );
    }
}

/*
 * get order default values
 */
if ( ! function_exists( 'tzbooking_order_default_order_data' ) ) {
    function tzbooking_order_default_order_data( $tzbooking_type='new' ) {
        $tzbooking_default_order_data = array(
            'first_name'        	=> '',
            'last_name'         	=> '',
            'email'             	=> '',
            'phone'             	=> '',
            'address'           	=> '',
            'city'              	=> '',
            'state'              	=> '',
            'zip'               	=> '',
            'country'           	=> '',
            'order_notes' 			=> '',
            'post_id'  				=> '',
            'name_combo'            => '',
            'people_combo'          => '',
            'price_combo'           => '',
            'total_adults'          => '',
            'total_kids'            => '',
            'total_price'       	=> '',
            'currency_code'     	=> '',
            'deposit_paid'      	=> 1,
            'time'         			=> '',
            'date_from'         	=> '',
            'date_to'           	=> '',
            'booking_no'        	=> '',
            'pin_code'          	=> '',
            'payment_method'        => '',
            'status'            	=> 'new',
            'updated'           	=> date( 'Y-m-d H:i:s' ),
        );
        if ( $tzbooking_type == 'new' ) {
            $tzbooking_a = array(
                'created' 	=> date( 'Y-m-d H:i:s' ),
                'mail_sent' => '',
                'other' 	=> '',
                'id' 	=> '' );
            $tzbooking_default_order_data = array_merge( $tzbooking_default_order_data, $tzbooking_a );
        }

        return $tzbooking_default_order_data;
    }
}

function tzbooking_parse_paypal_response( $tzbooking_response ) {
    $tzbooking_result = array();
    $tzbooking_enteries = explode( '&', $tzbooking_response['body'] );

    foreach ( $tzbooking_enteries as $tzbooking_nvp ) {
        $tzbooking_pair = explode( '=', $tzbooking_nvp );
        if ( count( $tzbooking_pair ) > 1 )
            $tzbooking_result[urldecode($tzbooking_pair[0])] = urldecode( $tzbooking_pair[1] );
    }

    return $tzbooking_result;
}

/*
 * Credit Card Paypal
 */
if ( ! function_exists( 'tzbooking_credit_card_paypal_process_payment' ) ) {
    function tzbooking_credit_card_paypal_process_payment( $tzbooking_order_data ) {

        global $wpdb;
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }

        $tzbooking_PayPalApiUsername = isset($templaza_options['ap_product_payment_api_username'])?$templaza_options['ap_product_payment_api_username']:'';
        $tzbooking_PayPalApiPassword = isset($templaza_options['ap_product_payment_api_pass'])?$templaza_options['ap_product_payment_api_pass']:'';
        $tzbooking_PayPalApiSignature = isset($templaza_options['ap_product_payment_api_signature'])?$templaza_options['ap_product_payment_api_signature']:'';
        $tzbooking_paypalmode = ( empty( $templaza_options['ap_product_payment_paypal_sandbox'] ) ? '' : 'sandbox' );

        $tzbooking_gatewayRequestData = array(
            'PAYMENTACTION' => 'Sale',
            'VERSION' 		=> '84.0',
            'METHOD' 		=> 'DoDirectPayment',
            'USER' 			=> $tzbooking_PayPalApiUsername,
            'PWD' 			=> $tzbooking_PayPalApiPassword,
            'SIGNATURE' 	=> $tzbooking_PayPalApiSignature,
            'AMT' 			=> $tzbooking_order_data['total_price'],
            'FIRSTNAME' 	=> $tzbooking_order_data['first_name'],
            'LASTNAME' 		=> $tzbooking_order_data['last_name'],
            'CITY' 			=> $tzbooking_order_data['city'],
            'STATE' 		=> $tzbooking_order_data['state'],
            'ZIP' 			=> $tzbooking_order_data['zip'],
            'IPADDRESS' 	=> $_SERVER['REMOTE_ADDR'],
            'CREDITCARDTYPE' => $_POST['billing_cardtype'],
            'ACCT' 			=> $_POST['billing_credircard'],
            'CVV2' 			=> $_POST['billing_ccvnumber'],
            'EXPDATE' 		=> sprintf( '%s%s', $_POST['billing_expdatemonth'], $_POST['billing_expdateyear'] ),
            'STREET' 		=> sprintf( '%s', $tzbooking_order_data['address']),
            'CURRENCYCODE' 	=> urlencode(strtoupper( $tzbooking_order_data['currency_code'] ) ),
            'BUTTONSOURCE' 	=> 'TipsandTricks_SP',
        );
        $tzbooking_result = array();
        $tzbooking_erroMessage = "";
        $tzbooking_api_url = "https://api-3t." . $tzbooking_paypalmode . ".paypal.com/nvp";
        $tzbooking_request = array(
            'method' => 'POST',
            'httpversion' => '1.0',
            'timeout' => 100,
            'blocking' => true,
            //'sslverify' => empty( $tzbooking_options['tzbooking_paypal_sandbox'] ) ? true : false,
            'body' => $tzbooking_gatewayRequestData
        );

        $tzbooking_response = wp_remote_post( $tzbooking_api_url, $tzbooking_request );

        if ( ! is_wp_error( $tzbooking_response ) ) {

            $tzbooking_parsedResponse = tzbooking_parse_paypal_response( $tzbooking_response );

            if ( array_key_exists( 'ACK', $tzbooking_parsedResponse ) ) {
                switch ($tzbooking_parsedResponse['ACK']) {
                    case 'Success':
                    case 'SuccessWithWarning':
                        $tzbooking_other_booking_data = array();
                        if ( ! empty( $tzbooking_order_data['other'] ) ) {
                            $tzbooking_other_booking_data = unserialize( $tzbooking_order_data['other'] );
                        }

                        $tzbooking_other_booking_data['pp_transaction_id'] = $tzbooking_parsedResponse['TRANSACTIONID'];
                        $tzbooking_order_data['deposit_paid'] = 1;
                        $tzbooking_update_status = $wpdb->update( $wpdb->prefix . 'tzbooking_order', array( 'deposit_paid' => $tzbooking_order_data['deposit_paid'], 'other' => serialize( $tzbooking_other_booking_data ), 'status' => 'new' ), array( 'booking_no' => $tzbooking_order_data['booking_no'], 'pin_code' => $tzbooking_order_data['pin_code'] ) );

                        if ( $tzbooking_update_status === false ) {
                            $tzbooking_result['success'] = 0;
                            $tzbooking_result['errormsg'] = esc_html__( 'Sorry, An error occurred while add your order.', 'travelami' );
                            do_action( 'tzbooking_payment_update_booking_error' );
                        } elseif ( empty( $tzbooking_update_status ) ) {
                            $tzbooking_result['success'] = 0;
                            $tzbooking_result['errormsg'] = esc_html__( 'Sorry, An error occurred because no rows are matched in database.', 'travelami' );
                            do_action( 'tzbooking_payment_update_booking_no_row' );
                        } else {
                            $tzbooking_result['success'] = 1;
                            do_action( 'tzbooking_payment_update_booking_success' );
                        }
                        break;

                    default:
                        $tzbooking_result['success'] = 0;
                        $tzbooking_result['errormsg'] = $tzbooking_parsedResponse['L_LONGMESSAGE0'];
                        break;
                }
            }
        } else {
            // Uncomment to view the http error
            //$tzbooking_result['errormsg'] = print_r($tzbooking_response->errors, true);
            $tzbooking_result['success'] = 0;
            $tzbooking_result['errormsg'] = esc_html__( 'Something went wrong while performing your request. Please contact website administrator to report this problem.', 'travelami' );
        }

        return $tzbooking_result;
    }
}

/*
 * Handle submit booking ajax request
 */
add_action( 'wp_ajax_tzbooking_product_submit_booking', 'tzbooking_product_submit_booking' );
add_action( 'wp_ajax_nopriv_tzbooking_product_submit_booking', 'tzbooking_product_submit_booking' );

if ( ! function_exists( 'tzbooking_product_submit_booking' ) ) {
    function tzbooking_product_submit_booking() {
        global $wpdb, $tzbooking_options;

        // validation
        $tzbooking_result_json = array( 'success' => 0, 'result' => array(), 'order_id' => 0 );
        $tzbooking_latest_order_id = $wpdb->get_var( 'SELECT id FROM ' . $wpdb->prefix . 'tzbooking_order ORDER BY id DESC LIMIT 1' );
        $tzbooking_booking_no = mt_rand( 1000, 9999 );
        $tzbooking_booking_no .= $tzbooking_latest_order_id;
        $tzbooking_pin_code = mt_rand( 1000, 9999 );

        if ( isset( $_POST['order_id'] ) && empty( $_POST['order_id'] ) ) {
            if ( ! isset( $_POST['uid'] ) || ! TZbooking_Session_Cart::tzbooking_get( $_POST['uid'] ) ) {
                $tzbooking_result_json['success'] = 0;
                $tzbooking_result_json['result'] = esc_html__( 'Sorry, some error occurred on input data validation.', 'travelami' );
                wp_send_json( $tzbooking_result_json );
            }
            if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'checkout' ) ) {
                $tzbooking_result_json['success'] = 0;
                $tzbooking_result_json['result'] = esc_html__( 'Sorry, your nonce did not verify.', 'travelami' );
                wp_send_json( $tzbooking_result_json );
            }

            if ( isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'cc' ) {
                if ( ! tzbooking_is_valid_card_number( $_POST['billing_credircard'] ) ) {
                    $tzbooking_result_json['success'] = 0;
                    $tzbooking_result_json['result'] = esc_html__( 'Credit card number you entered is invalid.', 'travelami' );
                    wp_send_json( $tzbooking_result_json );
                }
                if ( ! tzbooking_is_valid_card_type( $_POST['billing_cardtype'] ) ) {
                    $tzbooking_result_json['success'] = 0;
                    $tzbooking_result_json['result'] = esc_html__( 'Card type is not valid.', 'travelami' );
                    wp_send_json( $tzbooking_result_json );
                }
                if ( ! tzbooking_is_valid_expiry( $_POST['billing_expdatemonth'], $_POST['billing_expdateyear'] ) ) {
                    $tzbooking_result_json['success'] = 0;
                    $tzbooking_result_json['result'] = esc_html__( 'Card expiration date is not valid.', 'travelami' );
                    wp_send_json( $tzbooking_result_json );
                }
                if ( ! tzbooking_is_valid_cvv_number( $_POST['billing_ccvnumber'] ) ) {
                    $tzbooking_result_json['success'] = 0;
                    $tzbooking_result_json['result'] = esc_html__( 'Card verification number (CVV) is not valid. You can find this number on your credit card.', 'travelami' );
                    wp_send_json( $tzbooking_result_json );
                }
            }

            // init variables
            $tzbooking_payment_method = '';
            if ( isset( $_POST['payment_info'] )) {
                $tzbooking_payment_method = $_POST['payment_info'];
            }
            $tzbooking_uid = $_POST['uid'];
            $tzbooking_post_fields = array( 'first_name', 'last_name', 'country', 'address', 'city', 'zip', 'email', 'phone', 'state', 'order_notes');
            $tzbooking_order_info = tzbooking_order_default_order_data( 'new' );
            foreach ( $tzbooking_post_fields as $tzbooking_post_field ) {
                if ( ! empty( $_POST[ $tzbooking_post_field ] ) ) {
                    $tzbooking_order_info[ $tzbooking_post_field ] = sanitize_text_field( $_POST[ $tzbooking_post_field ] );
                }
            }
            $tzbooking_cart_data = TZbooking_Session_Cart::tzbooking_get( $tzbooking_uid );
            $tzbooking_discount = get_field( 'tzbooking_product_discount','',$tzbooking_cart_data['product_id'],'' );
            if( $tzbooking_cart_data['price_combo'] != '' && $tzbooking_cart_data['price_combo'] != 'custom' ){
                $tzbooking_order_info['name_combo'] 	    = $tzbooking_cart_data['name_combo'];
                $tzbooking_order_info['people_combo'] 	= $tzbooking_cart_data['people_combo'];
                $tzbooking_order_info['price_combo'] 	= $tzbooking_cart_data['price_combo'];
            }
            $tzbooking_order_info['total_price'] 	= round($tzbooking_cart_data['total_price']*(100-$tzbooking_discount)/100);
            $tzbooking_order_info['total_adults'] 	= $tzbooking_cart_data['adults'];
            $tzbooking_order_info['total_kids'] 		= $tzbooking_cart_data['kids'];
            $tzbooking_order_info['payment_method']  = $tzbooking_payment_method;
            $tzbooking_order_info['status'] 			= 'new'; // new
            $tzbooking_order_info['deposit_paid'] 	= 1;
            $tzbooking_order_info['mail_sent'] 		= 0;
            $tzbooking_order_info['post_id'] 		= $tzbooking_cart_data['product_id'];
            $tzbooking_order_info['time'] 		    = $tzbooking_cart_data['time'];
            if ( ! empty( $tzbooking_cart_data['date'] ) ) $tzbooking_order_info['date_from'] = date( 'Y-m-d', tzbooking_strtotime( $tzbooking_cart_data['date'] ) );
            $tzbooking_order_info['booking_no'] 		= $tzbooking_booking_no;
            $tzbooking_order_info['pin_code'] 		= $tzbooking_pin_code;
            $tzbooking_order_info['currency_code'] 	= get_option('options_ap_currency', 'USD');

//			 if payment enabled set deposit price field
            $tzbooking_result_json['result']['is_payment'] = tzbooking_is_payment_enabled();
            if ( tzbooking_is_payment_enabled() ) {
                $tzbooking_decimal_prec   = get_option('options_ap_price_num_decimals', 0);
                $tzbooking_order_info['deposit_paid'] = 0; // set unpaid if payment enabled
                $tzbooking_order_info['status'] 		= 'pending';
            }
            $tzbooking_order_info['created'] = date( 'Y-m-d H:i:s' );
            $tzbooking_order_info['post_type'] = 'ap_product';

            if ( $wpdb->insert( $wpdb->prefix . 'tzbooking_order', $tzbooking_order_info ) ) {
                TZbooking_Session_Cart::tzbooking_unset( $tzbooking_uid );
                $tzbooking_order_id = $wpdb->insert_id;
                /*	Save Data To Booking_Product	*/
                $product_booking_info = array();
                $product_booking_info['order_id'] 		= $tzbooking_order_id;
                $product_booking_info['product_id'] 		= $tzbooking_cart_data['product_id'];
                $product_booking_info['booking_time'] 	= $tzbooking_cart_data['time'];
                $product_booking_info['booking_date'] 	= $tzbooking_cart_data['date'];
                $product_booking_info['adults'] 		= $tzbooking_cart_data['adults'];
                $product_booking_info['kids'] 			= $tzbooking_cart_data['kids'];
                $product_booking_info['people_combo'] 	= $tzbooking_cart_data['people_combo'];
                $product_booking_info['total_price'] 	= $tzbooking_cart_data['total_price']*(100-$tzbooking_discount)/100;
                $wpdb->insert( $wpdb->prefix . 'tzbooking_product_bookings', $product_booking_info );

                if ( ( isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'cash' ) || ( ! isset( $_POST['payment_info'] ) ) ) {
                    $tzbooking_result_json['success'] 				= 1;
                    $tzbooking_result_json['result']['payment_info'] = 'cash';
                    $tzbooking_result_json['result']['order_id'] 	= $tzbooking_order_id;
                    $tzbooking_result_json['result']['booking_no'] 	= $tzbooking_booking_no;
                    $tzbooking_result_json['result']['pin_code'] 	= $tzbooking_pin_code;
                } elseif ( ( isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'paypal' ) ) {
                    $tzbooking_result_json['success'] 				= 1;
                    $tzbooking_result_json['result']['payment_info'] = 'paypal';
                    $tzbooking_result_json['result']['order_id'] 	= $tzbooking_order_id;
                    $tzbooking_result_json['result']['booking_no'] 	= $tzbooking_booking_no;
                    $tzbooking_result_json['result']['pin_code'] 	= $tzbooking_pin_code;
                } else if ( isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'cc' ) {
                    $tzbooking_payment_process_result = tzbooking_credit_card_paypal_process_payment( $tzbooking_order_info );

                    if ( $tzbooking_payment_process_result['success'] == 1 ) {
                        $tzbooking_result_json['success'] 				= 1;
                        $tzbooking_result_json['result']['payment_info'] = 'cc';
                        $tzbooking_result_json['result'] 				= array();
                        $tzbooking_result_json['result']['order_id'] 	= $tzbooking_order_id;
                        $tzbooking_result_json['result']['booking_no'] 	= $tzbooking_booking_no;
                        $tzbooking_result_json['result']['pin_code'] 	= $tzbooking_pin_code;
                    } else {
                        $tzbooking_result_json['success'] 	= 0;
                        $tzbooking_result_json['result'] 	= $tzbooking_payment_process_result['errormsg'];
                        $tzbooking_result_json['data'] = $tzbooking_payment_process_result['data'];
                        $tzbooking_result_json['url'] = $tzbooking_payment_process_result['url'];
                        $tzbooking_result_json['request'] = $tzbooking_payment_process_result['request'];
                        $tzbooking_result_json['response'] = $tzbooking_payment_process_result['response'];
                        $tzbooking_result_json['ack'] = $tzbooking_payment_process_result['ack'];
                        $tzbooking_result_json['order_id'] 	= $tzbooking_order_id;
                    }
                }
            } else {
                $tzbooking_result_json['success'] = 0;
                $tzbooking_result_json['result'] = esc_html__( 'Sorry, An error occurred while add your order.', 'travelami' );
            }
        } else if ( isset( $_POST['order_id'] ) && ! empty( $_POST['order_id'] ) && isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'cc'  ) {
            $tzbooking_order = new TZbooking_Product_Order( $_POST['order_id'] );
            $tzbooking_order_info = $tzbooking_order->tzbooking_get_order_info();

            $tzbooking_payment_process_result = tzbooking_credit_card_paypal_process_payment( $tzbooking_order_info );

            if ( $tzbooking_payment_process_result['success'] == 1 ) {
                $tzbooking_result_json['success'] 				= 1;
                $tzbooking_result_json['result'] 				= array();
                $tzbooking_result_json['result']['order_id'] 	= $tzbooking_order->order_id;
                $tzbooking_result_json['result']['booking_no'] 	= $tzbooking_booking_no;
                $tzbooking_result_json['result']['pin_code'] 	= $tzbooking_pin_code;
            } else {
                $tzbooking_result_json['success'] 				= 0;
                $tzbooking_result_json['result'] 				= $tzbooking_payment_process_result['errormsg'];
                $tzbooking_result_json['order_id'] 				= $tzbooking_order->order_id;
            }
        }
        wp_send_json( $tzbooking_result_json );
    }
}

/*
 * Check Product Availability
 * */

if ( ! function_exists( 'tzbooking_product_check_availability' ) ) {
    function tzbooking_product_check_availability( $post_id ) {
//        $tzbooking_check = '';
//        $tzbooking_availability = '';
        // validation
        if ( empty( $post_id ) || 'ap_product' != get_post_type( $post_id ) ) return esc_html__( 'Invalide Product ID.', 'travelami' ); //invalid data

//        $tzbooking_product_type = tzbooking_metabox( 'tzbooking_product_type','',$post_id,'' );
        $tzbooking_product_type = 'daily';
        $tzbooking_allow_manager_people = 1;
        $tzbooking_total_people = 20;
        $tzbooking_total_people_booked = 0;

        global $wpdb;
        // Count Adults Booked
        $where = "1=1";
        $where .= " AND product_id=" . $post_id;
//        if ( ! empty( $is_repeated ) ) $where .= " AND booking_date='" . esc_sql( date( 'Y-m-d', tzbooking_strtotime( $date ) ) ) . "'";
        $tzbooking_sql_adult = "SELECT SUM(adults) FROM " . $wpdb->prefix . "tzbooking_product_bookings WHERE $where";
        $tzbooking_count_adults = $wpdb->get_var( $tzbooking_sql_adult );

        // Count Kids Booked
        $tzbooking_sql_kids = "SELECT SUM(kids) FROM " . $wpdb->prefix . "tzbooking_product_bookings WHERE $where";
        $tzbooking_count_kids = $wpdb->get_var( $tzbooking_sql_kids );

        // Count People Combo Booked
        $tzbooking_sql_people_combo = "SELECT SUM(people_combo) FROM " . $wpdb->prefix . "tzbooking_product_bookings WHERE $where";
        $tzbooking_count_people_combo = $wpdb->get_var( $tzbooking_sql_people_combo );

        if( $tzbooking_count_adults != '' || $tzbooking_count_kids != '' || $tzbooking_count_people_combo != ''){
            $tzbooking_total_people_booked = $tzbooking_count_adults + $tzbooking_count_kids + $tzbooking_count_people_combo;
        }

        if($tzbooking_allow_manager_people == 1){
            if($tzbooking_total_people == ''){
                return array('1',$tzbooking_total_people_booked,'');
            }else{
                if($tzbooking_total_people == '0'){
                    return array('0','','');
                }else{
                    if ( $tzbooking_total_people_booked < $tzbooking_total_people ) {
                        return array('1',$tzbooking_total_people_booked,$tzbooking_total_people - $tzbooking_total_people_booked);
                    } else {
                        return array('0','','');
                    }
                }
            }
        }else{
            return array('1',$tzbooking_total_people_booked,'');
        }
    }
}

/*
 * Check Product Availability advance
 * */
if ( ! function_exists( 'tzbooking_product_check_availability_advance' ) ) {
    function tzbooking_product_check_availability_advance( $post_id, $date, $time ) {
        global $tzbooking_options;
        if ( empty( $post_id ) || 'ap_product' != get_post_type( $post_id ) ) return esc_html__( 'Invalide Product ID.', 'travelami' ); //invalid data

//        $tzbooking_product_type = tzbooking_metabox( 'tzbooking_product_type','',$post_id,'' );
        $tzbooking_product_type = 'daily';
        $tzbooking_allow_manager_people = 1;
        $tzbooking_total_people = 20;
        $tzbooking_total_people_booked = 0;
        $tzbooking_product_max_adult        = isset( $tzbooking_options['tzbooking_product_detail_max_adults'] ) ? $tzbooking_options['tzbooking_product_detail_max_adults'] : '';
        $tzbooking_product_max_kid        = isset( $tzbooking_options['tzbooking_product_detail_max_kids'] ) ? $tzbooking_options['tzbooking_product_detail_max_kids'] : '';
        $tzbooking_total_per_book = intval($tzbooking_product_max_adult) + intval($tzbooking_product_max_kid);
        global $wpdb;
        // Count Adults Booked
        if($tzbooking_product_max_adult==''){
            $tzbooking_product_max_adult = 99999999;
        }
        if($tzbooking_product_max_kid==''){
            $tzbooking_product_max_kid = 99999999;
        }
        $where = "1=1";
        $where .= " AND product_id=" . $post_id;

        if($time != ''){
            $where .= " AND booking_time='" . $time . "'";
        }

        if($date != ''){
            $where .= " AND booking_date='" . esc_sql( date( 'Y-m-d', tzbooking_strtotime( $date ) ) ) . "'";
        }

        $tzbooking_sql_adult = "SELECT SUM(adults) FROM " . $wpdb->prefix . "tzbooking_product_bookings WHERE $where";
        $tzbooking_count_adults = $wpdb->get_var( $tzbooking_sql_adult );

        // Count Kids Booked
        $tzbooking_sql_kids = "SELECT SUM(kids) FROM " . $wpdb->prefix . "tzbooking_product_bookings WHERE $where";
        $tzbooking_count_kids = $wpdb->get_var( $tzbooking_sql_kids );

        // Count People Combo Booked
        $tzbooking_sql_people_combo = "SELECT SUM(people_combo) FROM " . $wpdb->prefix . "tzbooking_product_bookings WHERE $where";
        $tzbooking_count_people_combo = $wpdb->get_var( $tzbooking_sql_people_combo );

        if( $tzbooking_count_adults != '' || $tzbooking_count_kids != '' || $tzbooking_count_people_combo != ''){
            $tzbooking_total_people_booked = $tzbooking_count_adults + $tzbooking_count_kids + $tzbooking_count_people_combo;
        }

        if($tzbooking_allow_manager_people == 1){
            if($tzbooking_total_people == ''){
                return array('1',$tzbooking_total_people_booked,'');
            }else{
                if($tzbooking_total_people == '0'){
                    return array('0','','');
                }else{
                    if ( $tzbooking_total_people_booked < $tzbooking_total_people ) {
                        return array('1',$tzbooking_total_people_booked,$tzbooking_total_people - $tzbooking_total_people_booked);
                    } else {
                        return array('0','','');
                    }
                }
            }
        }else{
            return array('1',$tzbooking_total_per_book,'');
        }
    }
}

add_action( 'wp_ajax_tzbooking_product_check_availability_ajax', 'tzbooking_product_check_availability_ajax' );
add_action( 'wp_ajax_nopriv_tzbooking_product_check_availability_ajax', 'tzbooking_product_check_availability_ajax' );

if ( ! function_exists( 'tzbooking_product_check_availability_ajax' ) ) {
    function tzbooking_product_check_availability_ajax() {

        // validation
        if ( ! isset( $_POST['product_id'] )) {
            wp_send_json( array( 'success'=>0, 'message'=>esc_html__( 'Some validation error is occurred while calculate price.', 'travelami' ) ) );
        }

        // init variables
        $tzbooking_product_id = $_POST['product_id'];
        $tzbooking_booking_date = $_POST['booking_date'];
        $tzbooking_booking_time = isset($_POST['booking_time']) ?  $_POST['booking_time']: '';

        $tzbooking_allow_manager_people = tzbooking_metabox( 'tzbooking_product_manager_people','',$tzbooking_product_id,'' );
        $tzbooking_total_people = tzbooking_metabox( 'tzbooking_product_total_people','',$tzbooking_product_id,'' );
        $tzbooking_total_people_booked = 0;

//        global $wpdb;
//        // Count Adults Booked
//        $where = "1=1";
//        $where .= " AND product_id=" . $tzbooking_product_id;
//        if($tzbooking_booking_date != ''){
//            $where .= " AND booking_date='" . esc_sql( date( 'Y-m-d', tzbooking_strtotime( $tzbooking_booking_date ) ) ) . "'";
//        }
//        if($tzbooking_booking_time != ''){
//            $where .= " AND booking_time='" . $tzbooking_booking_time . "'";
//        }
//
//        $tzbooking_sql_adult = "SELECT SUM(adults) FROM " . $wpdb->prefix . "tzbooking_product_bookings WHERE $where";
//        $tzbooking_count_adults = $wpdb->get_var( $tzbooking_sql_adult );
//
//        // Count Kids Booked
//        $tzbooking_sql_kids = "SELECT SUM(kids) FROM " . $wpdb->prefix . "tzbooking_product_bookings WHERE $where";
//        $tzbooking_count_kids = $wpdb->get_var( $tzbooking_sql_kids );
//
//        // Count People Combo Booked
//        $tzbooking_sql_people_combo = "SELECT SUM(people_combo) FROM " . $wpdb->prefix . "tzbooking_product_bookings WHERE $where";
//        $tzbooking_count_people_combo = $wpdb->get_var( $tzbooking_sql_people_combo );
//
//        if( $tzbooking_count_adults != '' || $tzbooking_count_kids != '' || $tzbooking_count_people_combo != ''){
//            $tzbooking_total_people_booked = $tzbooking_count_adults + $tzbooking_count_kids + $tzbooking_count_people_combo;
//        }

        $tzbooking_product_test = tzbooking_product_check_availability_advance( $tzbooking_product_id, $tzbooking_booking_date, $tzbooking_booking_time );

//        if($tzbooking_allow_manager_people == 1){
//            if($tzbooking_total_people == ''){
//                return array('1',$tzbooking_total_people_booked,'');
//            }else{
//                if($tzbooking_total_people == '0'){
//                    return array('0','','');
//                }else{
//                    if ( $tzbooking_total_people_booked < $tzbooking_total_people ) {
//                        return array('1',$tzbooking_total_people_booked,$tzbooking_total_people - $tzbooking_total_people_booked);
//                    } else {
//                        return array('0','','');
//                    }
//                }
//            }
//        }else{
//            return array('1',$tzbooking_total_people_booked,'');
//        }
        wp_send_json( array( 'success'=>1, 'message'=>esc_html__('success','travelami'), 'booked'=> $tzbooking_product_test ) );
    }
}


/****	Page Thank You	****/

/*
 * process payment
 */
if ( ! function_exists( 'tzbooking_process_payment' ) ) {
    function tzbooking_process_payment( $tzbooking_payment_data ) {

        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }

        $tzbooking_success = 0;
        if ( tzbooking_is_paypal_enabled() ) {
            // validation
            if ( empty( $templaza_options['ap_product_payment_api_username'] ) || empty( $templaza_options['ap_product_payment_api_pass'] ) || empty( $templaza_options['ap_product_payment_api_signature'] ) ) {
                return false;
            }

            $tzbooking_PayPalApiUsername = isset($templaza_options['ap_product_payment_api_username'])?$templaza_options['ap_product_payment_api_username']:'';
            $tzbooking_PayPalApiPassword = isset($templaza_options['ap_product_payment_api_pass'])?$templaza_options['ap_product_payment_api_pass']:'';
            $tzbooking_PayPalApiSignature = isset($templaza_options['ap_product_payment_api_signature'])?$templaza_options['ap_product_payment_api_signature']:'';
            $tzbooking_PayPalMode = ( empty( $templaza_options['ap_product_payment_paypal_sandbox'] ) ? 'live' : 'sandbox' );


            // SetExpressCheckOut
            if ( ! isset( $_GET["token"] ) || ! isset( $_GET["PayerID"] ) ) { 
                $tzbooking_padata = 	'&METHOD=SetExpressCheckout'.
                    '&RETURNURL='.urlencode($tzbooking_payment_data['return_url'] ).
                    '&CANCELURL='.urlencode($tzbooking_payment_data['cancel_url']).
                    '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                    '&L_PAYMENTREQUEST_0_NAME0='.urlencode($tzbooking_payment_data['item_name']).
                    '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($tzbooking_payment_data['item_number']).
                    '&L_PAYMENTREQUEST_0_DESC0='.urlencode($tzbooking_payment_data['item_desc']).
                    '&L_PAYMENTREQUEST_0_AMT0='.urlencode($tzbooking_payment_data['item_price']).
                    '&L_PAYMENTREQUEST_0_QTY0='. urlencode($tzbooking_payment_data['item_qty']).
                    '&NOSHIPPING=1'.
                    '&SOLUTIONTYPE=Sole'.
                    '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($tzbooking_payment_data['item_total_price']).
                    '&PAYMENTREQUEST_0_AMT='.urlencode($tzbooking_payment_data['grand_total']).
                    '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode( $tzbooking_payment_data['currency'] ) .
                    '&LOCALECODE=US'.
                    '&CARTBORDERCOLOR=FFFFFF'.
                    '&ALLOWNOTE=1';
                //We need to execute the "SetExpressCheckOut" method to obtain paypal token
                $tzbooking_paypal= new TZbooking_PayPal();
                $tzbooking_httpParsedResponseAr = $tzbooking_paypal->TZbooking_PPHttpPost('SetExpressCheckout', $tzbooking_padata, $tzbooking_PayPalApiUsername, $tzbooking_PayPalApiPassword, $tzbooking_PayPalApiSignature, $tzbooking_PayPalMode);

                //Respond according to message we receive from Paypal
                if ( "SUCCESS" == strtoupper($tzbooking_httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($tzbooking_httpParsedResponseAr["ACK"])) {
                    //Redirect user to PayPal store with Token received.
                    $tzbooking_PayPalMode = ($tzbooking_PayPalMode=='sandbox') ? '.sandbox' : '';
                    $tzbooking_paypalurl ='https://www'.$tzbooking_PayPalMode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$tzbooking_httpParsedResponseAr["TOKEN"].'';
                    echo '<script> location.replace("'.esc_js($tzbooking_paypalurl).'"); </script>';
                    exit;
                } else {
                    //Show error message
                    echo '<div class="alert alert-warning"><b>'.esc_html__("Error : ","travelami").'</b>' . urldecode($tzbooking_httpParsedResponseAr["L_LONGMESSAGE0"]) . '<span class="close"></span></div>';
                    echo '<pre>';
                    print_r($tzbooking_httpParsedResponseAr);
                    echo '</pre>';
                    exit;
                }
            }

            // DoExpressCheckOut
            if ( isset( $_GET["token"] ) && isset( $_GET["PayerID"] ) ) {

                $tzbooking_token = $_GET["token"];
                $tzbooking_payer_id = $_GET["PayerID"];

                $tzbooking_padata = 	'&TOKEN='.urlencode($tzbooking_token).
                    '&PAYERID='.urlencode($tzbooking_payer_id).
                    '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("Sale").
                    '&L_PAYMENTREQUEST_0_NAME0='.urlencode($tzbooking_payment_data['item_name']).
                    '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($tzbooking_payment_data['item_number']).
                    '&L_PAYMENTREQUEST_0_DESC0='.urlencode($tzbooking_payment_data['item_desc']).
                    '&L_PAYMENTREQUEST_0_AMT0='.urlencode($tzbooking_payment_data['item_price']).
                    '&L_PAYMENTREQUEST_0_QTY0='. urlencode($tzbooking_payment_data['item_qty']).
                    '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($tzbooking_payment_data['item_total_price']).
                    '&PAYMENTREQUEST_0_AMT='.urlencode($tzbooking_payment_data['grand_total']).
                    '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($tzbooking_payment_data['currency']);

                //execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
                $tzbooking_paypal = new TZbooking_PayPal();
                $tzbooking_httpParsedResponseAr = $tzbooking_paypal->TZbooking_PPHttpPost('DoExpressCheckoutPayment', $tzbooking_padata, $tzbooking_PayPalApiUsername, $tzbooking_PayPalApiPassword, $tzbooking_PayPalApiSignature, $tzbooking_PayPalMode);

                //Check if everything went ok..
                if ( "SUCCESS" == strtoupper( $tzbooking_httpParsedResponseAr["ACK"] ) || "SUCCESSWITHWARNING" == strtoupper( $tzbooking_httpParsedResponseAr["ACK"] ) ) {

                    echo '<div class="alert alert-success">' . esc_html__( 'Payment Received Successfully! Your Transaction ID : ', 'travelami' ) . urldecode($tzbooking_httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]) . '<span class="close"></span></div>';

                    $transation_id = urldecode( $tzbooking_httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"] );

                    // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
                    $tzbooking_padata = '&TOKEN='.urlencode($tzbooking_token);
                    $tzbooking_paypal= new TZbooking_PayPal();
                    $tzbooking_httpParsedResponseAr = $tzbooking_paypal->TZbooking_PPHttpPost('GetExpressCheckoutDetails', $tzbooking_padata, $tzbooking_PayPalApiUsername, $tzbooking_PayPalApiPassword, $tzbooking_PayPalApiSignature, $tzbooking_PayPalMode);

                    if ( "SUCCESS" == strtoupper($tzbooking_httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($tzbooking_httpParsedResponseAr["ACK"])) {
                        $tzbooking_success = 1;
                        return array( 'success'=>1, 'method'=>'paypal', 'transaction_id' => $transation_id );
                    } else  {
                        echo '<div class="alert alert-warning"><b>'.esc_html__("GetTransactionDetails failed:","travelami").'</b>' . urldecode($tzbooking_httpParsedResponseAr["L_LONGMESSAGE0"]) . '<span class="close"></span></div>';
                        echo '<pre>';
                        print_r($tzbooking_httpParsedResponseAr);
                        echo '</pre>';
                        exit;
                    }
                } else {
                    echo '<div class="alert alert-warning"><b>'.esc_html__("Error : ","travelami").'</b>' . urldecode($tzbooking_httpParsedResponseAr["L_LONGMESSAGE0"]) . '<span class="close"></span></div>';
                    echo '<pre>';
                    print_r($tzbooking_httpParsedResponseAr);
                    echo '</pre>';
                    exit;
                }
            }
        }
        return false;
    }
}

/*
 * check if any payment is enabled
 */
if ( ! function_exists( 'tzbooking_is_payment_enabled' ) ) {
    function tzbooking_is_payment_enabled() {
        return apply_filters( 'tzbooking_is_payment_enabled', false );
    }
}

/*
 * get current page url
 */
if ( ! function_exists( 'tzbooking_get_current_page_url' ) ) {
    function tzbooking_get_current_page_url() {
        global $wp;
        return esc_url( home_url(add_query_arg(array(),$wp->request)) );
    }
}


/*
 * echo deposit payment not paid notice on confirmation page
 */
add_action( 'tzbooking_order_deposit_payment_not_paid', 'tzbooking_order_deposit_payment_not_paid' );
if ( ! function_exists( 'tzbooking_order_deposit_payment_not_paid' ) ) {
    function tzbooking_order_deposit_payment_not_paid( $tzbooking_order_data ) {
        echo '<div class="alert alert-warning">' . esc_html__( 'Deposit payment is not paid.', 'travelami' ) . '<span class="close"></span></div>';
    }
}

/*
 * send confirmation email
 */
add_action( 'tzbooking_order_conf_mail_not_sent', 'tzbooking_order_conf_send_mail' );
if ( ! function_exists( 'tzbooking_order_conf_send_mail' ) ) {
    function tzbooking_order_conf_send_mail( $tzbooking_order_data ) {
        global $wpdb;
        $tzbooking_mail_sent = 0;
        if ( tzbooking_order_send_email( $tzbooking_order_data['booking_no'], $tzbooking_order_data['pin_code'], 'new' ) ) {
            $tzbooking_mail_sent = 1;
            $wpdb->update( $wpdb->prefix . 'tzbooking_order', array( 'mail_sent' => $tzbooking_mail_sent ), array( 'booking_no' => $tzbooking_order_data['booking_no'], 'pin_code' => $tzbooking_order_data['pin_code'] ), array( '%d' ), array( '%d','%d' ) );
        }
    }
}

/*
 * send booking confirmation email function
 */
if ( ! function_exists( 'tzbooking_order_send_email' ) ) {
    function tzbooking_order_send_email( $tzbooking_booking_no, $tzbooking_booking_pincode, $tzbooking_type='new', $tzbooking_subject='', $tzbooking_description='' ) {
        $tzbooking_order = new TZbooking_Product_Order( $tzbooking_booking_no, $tzbooking_booking_pincode );
        $tzbooking_order_data = $tzbooking_order->tzbooking_get_order_info();
        if ( ! empty( $tzbooking_order_data ) ) {
            $tzbooking_post_type = get_post_type( $tzbooking_order_data['post_id'] );
            if ( 'ap_product' == $tzbooking_post_type ) {
                return tzbooking_product_generate_conf_mail( $tzbooking_order, $tzbooking_type );
            }
        }
        return false;
    }
}

/*
 * send booking confirmation email function
 */
if ( ! function_exists( 'tzbooking_product_generate_conf_mail' ) ) {
    function tzbooking_product_generate_conf_mail( $tzbooking_order, $type='new' ) {
        global $wpdb, $tzbooking_options;
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }
        $tzbooking_order_data = $tzbooking_order->tzbooking_get_order_info();
        if ( ! empty( $tzbooking_order_data ) ) {
            // server variables
            $tzbooking_admin_email = get_option('admin_email');
            $tzbooking_home_url = esc_url( home_url('/') );
            $tzbooking_site_name = $_SERVER['SERVER_NAME'];
            $tzbooking_logo_url = esc_url( Functions::get_theme_default_logo_url('logo'));
            $tzbooking_order_data['product_id'] = $tzbooking_order_data['post_id'];

            // product info
            $tzbooking_product_name = get_the_title( $tzbooking_order_data['product_id'] );
            $tzbooking_booking_no = $tzbooking_order_data['booking_no'];
            $tzbooking_booking_date = $tzbooking_order_data['date_from'];
            $tzbooking_booking_time = $tzbooking_order_data['time'];
            $tzbooking_booking_adults = $tzbooking_order_data['total_adults'];
            $tzbooking_booking_kids = $tzbooking_order_data['total_kids'];
            $tzbooking_booking_fnr = $tzbooking_order_data['total_fnr'];
            $tzbooking_name_combo = $tzbooking_order_data['name_combo'];
            $tzbooking_booking_total_price = $tzbooking_order_data['total_price'];
            $tzbooking_order_payment_method = $tzbooking_order_data['payment_method'];

            // customer info
            $tzbooking_customer_first_name = $tzbooking_order_data['first_name'];
            $tzbooking_customer_last_name = $tzbooking_order_data['last_name'];
            $tzbooking_customer_email = $tzbooking_order_data['email'];
            $tzbooking_customer_country_code = $tzbooking_order_data['country'];
            $tzbooking_customer_phone = $tzbooking_order_data['phone'];
            $tzbooking_customer_address = $tzbooking_order_data['address'];
            $tzbooking_customer_city = $tzbooking_order_data['city'];
            $tzbooking_customer_state = $tzbooking_order_data['state'];
            $tzbooking_customer_zip = $tzbooking_order_data['zip'];
            $tzbooking_customer_country = $tzbooking_order_data['country'];
            $tzbooking_customer_order_notes = $tzbooking_order_data['order_notes'];

            $tzbooking_variables = array( 'home_url',
                'site_name',
                'logo_url',
                'product_name',
                'product_url',
                'product_thumbnail',
                'product_address',
                'product_email',
                'product_phone',
                'booking_services',
                'booking_no',
                'booking_pincode',
                'booking_date',
                'booking_adults',
                'booking_kids',
                'booking_fnr',
                'booking_total_price',
                'customer_first_name',
                'customer_last_name',
                'customer_email',
                'customer_country_code',
                'customer_phone',
                'customer_address',
                'customer_city',
                'customer_zip',
                'customer_country',
                'customer_order_notes',
            );

            if ( empty( $tzbooking_subject ) ) {
                $tzbooking_subject = empty( $templaza_options['ap_product_email_subject_customer'] ) ? esc_html__('Booking Confirmation Email Subject','travelami') : $templaza_options['ap_product_email_subject_customer'];
            }

            if ( empty( $tzbooking_description ) ) {
                $tzbooking_description = empty( $templaza_options['ap_product_email_description_customer'] ) ? esc_html__('Booking Confirmation Email Description','travelami') : $templaza_options['ap_product_email_description_customer'];
            }

            foreach ( $tzbooking_variables as $tzbooking_variable ) {
                $tzbooking_subject = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_subject );
                $tzbooking_description = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_description );
                $tzbooking_product_name = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_product_name );
                $tzbooking_booking_no = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_booking_no );
                $tzbooking_booking_date = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_booking_date );
                $tzbooking_booking_adults = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_booking_adults );
                $tzbooking_booking_kids = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_booking_kids );
                $tzbooking_name_combo = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_name_combo );
                $tzbooking_booking_total_price = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_booking_total_price );
                $tzbooking_order_payment_method = str_replace( "[" . $tzbooking_variable . "]", $tzbooking_variable, $tzbooking_order_payment_method );
            }
            $tzbooking_customer_order_option = ((!isset($templaza_options['ap_product_email_confirm_customer_order_and_billing'])) || empty($templaza_options['ap_product_email_confirm_customer_order_and_billing'])) ? true : $templaza_options['ap_product_email_confirm_customer_order_and_billing'];
            $tzbooking_customer_order_position = ((!isset($templaza_options['ap_product_email_confirm_customer_order_billing_position'])) || empty($templaza_options['ap_product_email_confirm_customer_order_billing_position'])) ? true : $templaza_options['ap_product_email_confirm_customer_order_billing_position'];

            $tzbooking_mail_sent = tzbooking_send_mail( $tzbooking_site_name,$tzbooking_customer_email, $tzbooking_admin_email, $tzbooking_customer_email, $tzbooking_subject, $tzbooking_description, $tzbooking_booking_no, $tzbooking_product_name, $tzbooking_booking_date, $tzbooking_booking_time, $tzbooking_booking_adults, $tzbooking_booking_kids, $tzbooking_booking_fnr, $tzbooking_name_combo, $tzbooking_booking_total_price, $tzbooking_order_payment_method, $tzbooking_customer_first_name, $tzbooking_customer_last_name, $tzbooking_customer_phone, $tzbooking_customer_address, $tzbooking_customer_city, $tzbooking_customer_state, $tzbooking_customer_zip, $tzbooking_customer_country, $tzbooking_customer_order_notes, $tzbooking_customer_order_option, $tzbooking_customer_order_position );

            /* mailing function to admin */

            return true;
        }
        return false;
    }
}
/*
 * send mail functions
 */

if ( ! function_exists('tzbooking_send_mail') ) {
    function tzbooking_send_mail( $tzbooking_from_name,$tzbooking_customer_email, $tzbooking_from_address, $tzbooking_to_address, $tzbooking_subject, $tzbooking_description, $tzbooking_booking_no, $tzbooking_product_name, $tzbooking_booking_date, $tzbooking_booking_time, $tzbooking_booking_adults, $tzbooking_booking_kids, $tzbooking_booking_fnr, $tzbooking_name_combo, $tzbooking_booking_total_price, $tzbooking_order_payment_method, $tzbooking_customer_first_name, $tzbooking_customer_last_name, $tzbooking_customer_phone, $tzbooking_customer_address, $tzbooking_customer_city, $tzbooking_customer_state, $tzbooking_customer_zip, $tzbooking_customer_country, $tzbooking_customer_order_notes , $tzbooking_order_option, $tzbooking_order_position ) {
        switch ($tzbooking_customer_country) {
            case 'US':
                $tzbooking_customer_country_name = 'United States';
                break;

            case 'GB':
                $tzbooking_customer_country_name = 'United Kingdom';
                break;

            case 'CA':
                $tzbooking_customer_country_name = 'Canada';
                break;

            case 'AF':
                $tzbooking_customer_country_name = 'Afghanistan';
                break;

            case 'AL':
                $tzbooking_customer_country_name = 'Albania';
                break;

            case 'DZ':
                $tzbooking_customer_country_name = 'Algeria';
                break;

            case 'AS':
                $tzbooking_customer_country_name = 'American Samoa';
                break;

            case 'AD':
                $tzbooking_customer_country_name = 'Andorra';
                break;

            case 'AO':
                $tzbooking_customer_country_name = 'Angola';
                break;

            case 'AI':
                $tzbooking_customer_country_name = 'Anguilla';
                break;

            case 'AG':
                $tzbooking_customer_country_name = 'Antigua';
                break;

            case 'AR':
                $tzbooking_customer_country_name = 'Argentina';
                break;

            case 'AM':
                $tzbooking_customer_country_name = 'Armenia';
                break;

            case 'AW':
                $tzbooking_customer_country_name = 'Aruba';
                break;

            case 'AU':
                $tzbooking_customer_country_name = 'Australia';
                break;

            case 'AT':
                $tzbooking_customer_country_name = 'Austria';
                break;

            case 'AZ':
                $tzbooking_customer_country_name = 'Azerbaijan';
                break;

            case 'BH':
                $tzbooking_customer_country_name = 'Bahrain';
                break;

            case 'BD':
                $tzbooking_customer_country_name = 'Bangladesh';
                break;

            case 'BB':
                $tzbooking_customer_country_name = 'Barbados';
                break;

            case 'BY':
                $tzbooking_customer_country_name = 'Belarus';
                break;

            case 'BE':
                $tzbooking_customer_country_name = 'Belgium';
                break;

            case 'BZ':
                $tzbooking_customer_country_name = 'Belize';
                break;

            case 'BJ':
                $tzbooking_customer_country_name = 'Benin';
                break;

            case 'BM':
                $tzbooking_customer_country_name = 'Bermuda';
                break;

            case 'BT':
                $tzbooking_customer_country_name = 'Bhutan';
                break;

            case 'BO':
                $tzbooking_customer_country_name = 'Bolivia';
                break;

            case 'BA':
                $tzbooking_customer_country_name = 'Bosnia and Herzegovina';
                break;

            case 'BW':
                $tzbooking_customer_country_name = 'Botswana';
                break;

            case 'BR':
                $tzbooking_customer_country_name = 'Brazil';
                break;

            case 'IO':
                $tzbooking_customer_country_name = 'British Indian Ocean Territory';
                break;

            case 'VG':
                $tzbooking_customer_country_name = 'British Virgin Islands';
                break;

            case 'BN':
                $tzbooking_customer_country_name = 'Brunei';
                break;

            case 'BG':
                $tzbooking_customer_country_name = 'Bulgaria';
                break;

            case 'BF':
                $tzbooking_customer_country_name = 'Burkina Faso';
                break;

            case 'MM':
                $tzbooking_customer_country_name = 'Burma Myanmar';
                break;

            case 'BI':
                $tzbooking_customer_country_name = 'Burundi';
                break;

            case 'KH':
                $tzbooking_customer_country_name = 'Cambodia';
                break;

            case 'CM':
                $tzbooking_customer_country_name = 'Cameroon';
                break;

            case 'CV':
                $tzbooking_customer_country_name = 'Cape Verde';
                break;

            case 'KY':
                $tzbooking_customer_country_name = 'Cayman Islands';
                break;

            case 'CF':
                $tzbooking_customer_country_name = 'Central African Republic';
                break;

            case 'TD':
                $tzbooking_customer_country_name = 'Chad';
                break;

            case 'CL':
                $tzbooking_customer_country_name = 'Chile';
                break;

            case 'CN':
                $tzbooking_customer_country_name = 'China';
                break;

            case 'CO':
                $tzbooking_customer_country_name = 'Colombia';
                break;

            case 'KM':
                $tzbooking_customer_country_name = 'Comoros';
                break;

            case 'CK':
                $tzbooking_customer_country_name = 'Cook Islands';
                break;

            case 'CR':
                $tzbooking_customer_country_name = 'Costa Rica';
                break;

            case 'CI':
                $tzbooking_customer_country_name = "Cote d\'Ivoire";
                break;

            case 'HR':
                $tzbooking_customer_country_name = 'Croatia';
                break;

            case 'CU':
                $tzbooking_customer_country_name = 'Cuba';
                break;

            case 'CY':
                $tzbooking_customer_country_name = 'Cyprus';
                break;

            case 'CZ':
                $tzbooking_customer_country_name = 'Czech Republic';
                break;

            case 'CD':
                $tzbooking_customer_country_name = 'Democratic Republic of Congo';
                break;

            case 'DK':
                $tzbooking_customer_country_name = 'Denmark';
                break;

            case 'DJ':
                $tzbooking_customer_country_name = 'Djibouti';
                break;

            case 'DM':
                $tzbooking_customer_country_name = 'Dominica';
                break;

            case 'DO':
                $tzbooking_customer_country_name = 'Dominican Republic';
                break;

            case 'EC':
                $tzbooking_customer_country_name = 'Ecuador';
                break;

            case 'EG':
                $tzbooking_customer_country_name = 'Egypt';
                break;

            case 'SV':
                $tzbooking_customer_country_name = 'El Salvador';
                break;

            case 'GQ':
                $tzbooking_customer_country_name = 'Equatorial Guinea';
                break;

            case 'ER':
                $tzbooking_customer_country_name = 'Eritrea';
                break;

            case 'EE':
                $tzbooking_customer_country_name = 'Estonia';
                break;

            case 'ET':
                $tzbooking_customer_country_name = 'Ethiopia';
                break;

            case 'FK':
                $tzbooking_customer_country_name = 'Falkland Islands';
                break;

            case 'FO':
                $tzbooking_customer_country_name = 'Faroe Islands';
                break;

            case 'FM':
                $tzbooking_customer_country_name = 'Federated States of Micronesia';
                break;

            case 'FJ':
                $tzbooking_customer_country_name = 'Fiji';
                break;

            case 'FI':
                $tzbooking_customer_country_name = 'Finland';
                break;

            case 'FR':
                $tzbooking_customer_country_name = 'France';
                break;

            case 'GF':
                $tzbooking_customer_country_name = 'French Guiana';
                break;

            case 'PF':
                $tzbooking_customer_country_name = 'French Polynesia';
                break;

            case 'GA':
                $tzbooking_customer_country_name = 'Gabon';
                break;

            case 'GE':
                $tzbooking_customer_country_name = 'Georgia';
                break;

            case 'DE':
                $tzbooking_customer_country_name = 'Germany';
                break;

            case 'GH':
                $tzbooking_customer_country_name = 'Ghana';
                break;

            case 'GI':
                $tzbooking_customer_country_name = 'Gibraltar';
                break;

            case 'GR':
                $tzbooking_customer_country_name = 'Greece';
                break;

            case 'GL':
                $tzbooking_customer_country_name = 'Greenland';
                break;

            case 'GD':
                $tzbooking_customer_country_name = 'Grenada';
                break;

            case 'GP':
                $tzbooking_customer_country_name = 'Guadeloupe';
                break;

            case 'GU':
                $tzbooking_customer_country_name = 'Guam';
                break;

            case 'GT':
                $tzbooking_customer_country_name = 'Guatemala';
                break;

            case 'GN':
                $tzbooking_customer_country_name = 'Guinea';
                break;

            case 'GW':
                $tzbooking_customer_country_name = 'Guinea-Bissau';
                break;

            case 'GY':
                $tzbooking_customer_country_name = 'Guyana';
                break;

            case 'HT':
                $tzbooking_customer_country_name = 'Haiti';
                break;

            case 'HN':
                $tzbooking_customer_country_name = 'Honduras';
                break;

            case 'HK':
                $tzbooking_customer_country_name = 'Hong Kong';
                break;

            case 'HU':
                $tzbooking_customer_country_name = 'Hungary';
                break;

            case 'IS':
                $tzbooking_customer_country_name = 'Iceland';
                break;

            case 'IN':
                $tzbooking_customer_country_name = 'India';
                break;

            case 'ID':
                $tzbooking_customer_country_name = 'Indonesia';
                break;

            case 'IR':
                $tzbooking_customer_country_name = 'Iran';
                break;

            case 'IQ':
                $tzbooking_customer_country_name = 'Iraq';
                break;

            case 'IE':
                $tzbooking_customer_country_name = 'Ireland';
                break;

            case 'IL':
                $tzbooking_customer_country_name = 'Israel';
                break;

            case 'IT':
                $tzbooking_customer_country_name = 'Italy';
                break;

            case 'JM':
                $tzbooking_customer_country_name = 'Jamaica';
                break;

            case 'JP':
                $tzbooking_customer_country_name = 'Japan';
                break;

            case 'JO':
                $tzbooking_customer_country_name = 'Jordan';
                break;

            case 'KZ':
                $tzbooking_customer_country_name = 'Kazakhstan';
                break;

            case 'KE':
                $tzbooking_customer_country_name = 'Kenya';
                break;

            case 'KI':
                $tzbooking_customer_country_name = 'Kiribati';
                break;

            case 'XK':
                $tzbooking_customer_country_name = 'Kosovo';
                break;

            case 'KW':
                $tzbooking_customer_country_name = 'Kuwait';
                break;

            case 'KG':
                $tzbooking_customer_country_name = 'Kyrgyzstan';
                break;

            case 'LA':
                $tzbooking_customer_country_name = 'Laos';
                break;

            case 'LV':
                $tzbooking_customer_country_name = 'Latvia';
                break;

            case 'LB':
                $tzbooking_customer_country_name = 'Lebanon';
                break;

            case 'LS':
                $tzbooking_customer_country_name = 'Lesotho';
                break;

            case 'LR':
                $tzbooking_customer_country_name = 'Liberia';
                break;

            case 'LY':
                $tzbooking_customer_country_name = 'Libya';
                break;

            case 'LI':
                $tzbooking_customer_country_name = 'Liechtenstein';
                break;

            case 'LT':
                $tzbooking_customer_country_name = 'Lithuania';
                break;

            case 'LU':
                $tzbooking_customer_country_name = 'Luxembourg';
                break;

            case 'MO':
                $tzbooking_customer_country_name = 'Macau';
                break;

            case 'MK':
                $tzbooking_customer_country_name = 'Macedonia';
                break;

            case 'MG':
                $tzbooking_customer_country_name = 'Madagascar';
                break;

            case 'MW':
                $tzbooking_customer_country_name = 'Malawi';
                break;

            case 'MY':
                $tzbooking_customer_country_name = 'Malaysia';
                break;

            case 'MV':
                $tzbooking_customer_country_name = 'Maldives';
                break;

            case 'ML':
                $tzbooking_customer_country_name = 'Mali';
                break;

            case 'MT':
                $tzbooking_customer_country_name = 'Malta';
                break;

            case 'MH':
                $tzbooking_customer_country_name = 'Marshall Islands';
                break;

            case 'MQ':
                $tzbooking_customer_country_name = 'Martinique';
                break;

            case 'MR':
                $tzbooking_customer_country_name = 'Mauritania';
                break;

            case 'MU':
                $tzbooking_customer_country_name = 'Mauritius';
                break;

            case 'YT':
                $tzbooking_customer_country_name = 'Mayotte';
                break;

            case 'MX':
                $tzbooking_customer_country_name = 'Mexico';
                break;

            case 'MD':
                $tzbooking_customer_country_name = 'Moldova';
                break;

            case 'MC':
                $tzbooking_customer_country_name = 'Monaco';
                break;

            case 'MN':
                $tzbooking_customer_country_name = 'Mongolia';
                break;

            case 'ME':
                $tzbooking_customer_country_name = 'Montenegro';
                break;

            case 'MS':
                $tzbooking_customer_country_name = 'Montserrat';
                break;

            case 'MA':
                $tzbooking_customer_country_name = 'Morocco';
                break;

            case 'MZ':
                $tzbooking_customer_country_name = 'Mozambique';
                break;

            case 'NA':
                $tzbooking_customer_country_name = 'Namibia';
                break;

            case 'NR':
                $tzbooking_customer_country_name = 'Nauru';
                break;

            case 'NP':
                $tzbooking_customer_country_name = 'Nepal';
                break;

            case 'NL':
                $tzbooking_customer_country_name = 'Netherlands';
                break;

            case 'AN':
                $tzbooking_customer_country_name = 'Netherlands Antilles';
                break;

            case 'NC':
                $tzbooking_customer_country_name = 'New Caledonia';
                break;
            case 'NZ':
                $tzbooking_customer_country_name = 'New Zealand';
                break;

            case 'NI':
                $tzbooking_customer_country_name = 'Nicaragua';
                break;

            case 'NE':
                $tzbooking_customer_country_name = 'Niger';
                break;

            case 'NG':
                $tzbooking_customer_country_name = 'Nigeria';
                break;

            case 'NU':
                $tzbooking_customer_country_name = 'Niue';
                break;

            case 'NF':
                $tzbooking_customer_country_name = 'Norfolk Island';
                break;

            case 'KP':
                $tzbooking_customer_country_name = 'North Korea';
                break;

            case 'MP':
                $tzbooking_customer_country_name = 'Northern Mariana Islands';
                break;

            case 'NO':
                $tzbooking_customer_country_name = 'Norway';
                break;

            case 'OM':
                $tzbooking_customer_country_name = 'Oman';
                break;

            case 'PK':
                $tzbooking_customer_country_name = 'Pakistan';
                break;

            case 'PW':
                $tzbooking_customer_country_name = 'Palau';
                break;

            case 'PS':
                $tzbooking_customer_country_name = 'Palestine';
                break;

            case 'PA':
                $tzbooking_customer_country_name = 'Panama';
                break;

            case 'PG':
                $tzbooking_customer_country_name = 'Papua New Guinea';
                break;

            case 'PY':
                $tzbooking_customer_country_name = 'Paraguay';
                break;

            case 'PE':
                $tzbooking_customer_country_name = 'Peru';
                break;

            case 'PH':
                $tzbooking_customer_country_name = 'Philippines';
                break;

            case 'PL':
                $tzbooking_customer_country_name = 'Poland';
                break;

            case 'PT':
                $tzbooking_customer_country_name = 'Portugal';
                break;

            case 'PR':
                $tzbooking_customer_country_name = 'Puerto Rico';
                break;

            case 'QA':
                $tzbooking_customer_country_name = 'Qatar';
                break;

            case 'CG':
                $tzbooking_customer_country_name = 'Republic of the Congo';
                break;

            case 'RE':
                $tzbooking_customer_country_name = 'Reunion';
                break;

            case 'RO':
                $tzbooking_customer_country_name = 'Romania';
                break;

            case 'RU':
                $tzbooking_customer_country_name = 'Russia';
                break;

            case 'RW':
                $tzbooking_customer_country_name = 'Rwanda';
                break;

            case 'BL':
                $tzbooking_customer_country_name = 'Saint Barthelemy';
                break;

            case 'SH':
                $tzbooking_customer_country_name = 'Saint Helena';
                break;

            case 'KN':
                $tzbooking_customer_country_name = 'Saint Kitts and Nevis';
                break;

            case 'MF':
                $tzbooking_customer_country_name = 'Saint Martin';
                break;

            case 'PM':
                $tzbooking_customer_country_name = 'Saint Pierre and Miquelon';
                break;

            case 'VC':
                $tzbooking_customer_country_name = 'Saint Vincent and the Grenadines';
                break;

            case 'WS':
                $tzbooking_customer_country_name = 'Samoa';
                break;

            case 'SM':
                $tzbooking_customer_country_name = 'San Marino';
                break;

            case 'ST':
                $tzbooking_customer_country_name = 'Sao Tome and Principe';
                break;

            case 'SA':
                $tzbooking_customer_country_name = 'Saudi Arabia';
                break;

            case 'SN':
                $tzbooking_customer_country_name = 'Senegal';
                break;

            case 'RS':
                $tzbooking_customer_country_name = 'Serbia';
                break;

            case 'SC':
                $tzbooking_customer_country_name = 'Seychelles';
                break;

            case 'SL':
                $tzbooking_customer_country_name = 'Sierra Leone';
                break;

            case 'SG':
                $tzbooking_customer_country_name = 'Singapore';
                break;

            case 'SK':
                $tzbooking_customer_country_name = 'Slovakia';
                break;

            case 'SI':
                $tzbooking_customer_country_name = 'Slovenia';
                break;

            case 'SB':
                $tzbooking_customer_country_name = 'Solomon Islands';
                break;

            case 'SO':
                $tzbooking_customer_country_name = 'Somalia';
                break;

            case 'ZA':
                $tzbooking_customer_country_name = 'South Africa';
                break;

            case 'KR':
                $tzbooking_customer_country_name = 'South Korea';
                break;

            case 'ES':
                $tzbooking_customer_country_name = 'Spain';
                break;

            case 'LK':
                $tzbooking_customer_country_name = 'Sri Lanka';
                break;

            case 'LC':
                $tzbooking_customer_country_name = 'St. Lucia';
                break;

            case 'SD':
                $tzbooking_customer_country_name = 'Sudan';
                break;

            case 'SR':
                $tzbooking_customer_country_name = 'Suriname';
                break;

            case 'SZ':
                $tzbooking_customer_country_name = 'Swaziland';
                break;

            case 'SE':
                $tzbooking_customer_country_name = 'Sweden';
                break;

            case 'CH':
                $tzbooking_customer_country_name = 'Switzerland';
                break;

            case 'SY':
                $tzbooking_customer_country_name = 'Syria';
                break;

            case 'TW':
                $tzbooking_customer_country_name = 'Taiwan';
                break;

            case 'TJ':
                $tzbooking_customer_country_name = 'Tajikistan';
                break;

            case 'TZ':
                $tzbooking_customer_country_name = 'Tanzania';
                break;

            case 'TH':
                $tzbooking_customer_country_name = 'Thailand';
                break;

            case 'BS':
                $tzbooking_customer_country_name = 'The Bahamas';
                break;

            case 'GM':
                $tzbooking_customer_country_name = 'The Gambia';
                break;

            case 'TL':
                $tzbooking_customer_country_name = 'Timor-Leste';
                break;

            case 'TG':
                $tzbooking_customer_country_name = 'Togo';
                break;

            case 'TK':
                $tzbooking_customer_country_name = 'Tokelau';
                break;

            case 'TO':
                $tzbooking_customer_country_name = 'Tonga';
                break;

            case 'TT':
                $tzbooking_customer_country_name = 'Trinidad and Tobago';
                break;

            case 'TN':
                $tzbooking_customer_country_name = 'Tunisia';
                break;

            case 'TR':
                $tzbooking_customer_country_name = 'Turkey';
                break;

            case 'TM':
                $tzbooking_customer_country_name = 'Turkmenistan';
                break;

            case 'TC':
                $tzbooking_customer_country_name = 'Turks and Caicos Islands';
                break;

            case 'TV':
                $tzbooking_customer_country_name = 'Tuvalu';
                break;

            case 'UG':
                $tzbooking_customer_country_name = 'Uganda';
                break;

            case 'UA':
                $tzbooking_customer_country_name = 'Ukraine';
                break;

            case 'AE':
                $tzbooking_customer_country_name = 'United Arab Emirates';
                break;

            case 'UY':
                $tzbooking_customer_country_name = 'Uruguay';
                break;

            case 'VI':
                $tzbooking_customer_country_name = 'US Virgin Islands';
                break;

            case 'UZ':
                $tzbooking_customer_country_name = 'Uzbekistan';
                break;

            case 'VU':
                $tzbooking_customer_country_name = 'Vanuatu';
                break;

            case 'VA':
                $tzbooking_customer_country_name = 'Vatican City';
                break;

            case 'VE':
                $tzbooking_customer_country_name = 'Venezuela';
                break;

            case 'VN':
                $tzbooking_customer_country_name = 'Vietnam';
                break;

            case 'WF':
                $tzbooking_customer_country_name = 'Wallis and Futuna';
                break;

            case 'YE':
                $tzbooking_customer_country_name = 'Yemen';
                break;

            case 'ZM':
                $tzbooking_customer_country_name = 'Zambia';
                break;

            case 'ZW':
                $tzbooking_customer_country_name = 'Zimbabwe';
                break;

            default:
                $tzbooking_customer_country_name = 'United States';
                break;
        }

        switch ($tzbooking_order_payment_method){
            case 'cash':
                $tzbooking_order_payment_method_name = 'Payment by cash';
                break;

            case 'paypal':
                $tzbooking_order_payment_method_name = 'Payment by paypal';
                break;

            case 'cc':
                $tzbooking_order_payment_method_name = 'Payment by credit card';
                break;

            default:
                $tzbooking_order_payment_method_name = '';
                break;
        }

        $tzbooking_to_address2 = '';
        if ($tzbooking_to_address == $tzbooking_from_address){
            $tzbooking_to_address2 = $tzbooking_customer_email;
        }else{
            $tzbooking_to_address2 = $tzbooking_to_address;
        }
        // Order & Billing address output
        $tzbooking_order_output = "";
        $tzbooking_order_output .= "<h4>". esc_html__('Order Details','travelami') ."</h4>\n";
        $tzbooking_order_output .= "<table'>
        <tr>
            <th>".esc_html__('Tour','travelami')."</th>
            <th>".esc_html__('Date','travelami')."</th>
            <th>".esc_html__('Time','travelami')."</th>
            <th>".esc_html__('Adults','travelami')."</th>
            <th>".esc_html__('Children','travelami')."</th>
            <th>".esc_html__('FNR','travelami')."</th>
            <th>".esc_html__('Total','travelami')."</th>
            <th>".esc_html__('Payment Method','travelami')."</th>
        </tr>
        <tr>
            <td>". $tzbooking_product_name ."</td>
            <td>". $tzbooking_booking_date ."</td>
            <td>". $tzbooking_booking_time ."</td>
            <td>". $tzbooking_booking_adults ."</td>
            <td>". $tzbooking_booking_kids ."</td>
            <td>". $tzbooking_booking_fnr ."</td>
            <td>". $tzbooking_booking_total_price ."</td>
            <td>". $tzbooking_order_payment_method_name ."</td>              
        </tr>
        </table>\n";
        $tzbooking_order_output .= "<h4>". esc_html__('Billing address','travelami') ."</h4>\n";
        $tzbooking_order_output .= "<table'>
        <tr>
            <th>".esc_html__('Name','travelami')."</th>
            <th>".esc_html__('Email','travelami')."</th>
            <th>".esc_html__('Phone','travelami')."</th>
            <th>".esc_html__('Address','travelami')."</th>
            <th>".esc_html__('City','travelami')."</th>
            <th>".esc_html__('State','travelami')."</th>
            <th>".esc_html__('Postal Code','travelami')."</th>
            <th>".esc_html__('Country','travelami')."</th>
            <th>".esc_html__('Order notes','travelami')."</th>
        </tr>
        <tr>
            <td>". $tzbooking_customer_first_name." ". $tzbooking_customer_last_name ."</td>
            <td>". $tzbooking_to_address2 ."</td>           
            <td>". $tzbooking_customer_phone ."</td>              
            <td>". $tzbooking_customer_address ."</td>              
            <td>". $tzbooking_customer_city ."</td>                           
            <td>". $tzbooking_customer_state ."</td>              
            <td>". $tzbooking_customer_zip ."</td>              
            <td>". $tzbooking_customer_country_name ."</td>              
            <td>". $tzbooking_customer_order_notes ."</td>              
        </tr>
        </table>\n";

        //Create Email Headers
        $tzbooking_headers = "MIME-Version: 1.0" . "\r\n";
        $tzbooking_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $tzbooking_headers .= "From: ".$tzbooking_from_name." <".$tzbooking_from_address.">\n";
        $tzbooking_headers .= "Reply-To: ".$tzbooking_from_name." <".$tzbooking_from_address.">\n";
        $tzbooking_message = "<html>\n";
        $tzbooking_message .= "<head>
                                <style>
                                table {
                                    border-collapse: collapse;
                                }
                                
                                td, th {
                                    border: 1px solid #dddddd;
                                    text-align: left;
                                    padding: 8px;
                                }
                                </style>
                            </head>";
        $tzbooking_message .= "<body>\n";
        if($tzbooking_order_option == true && $tzbooking_order_position == 'before'){
            $tzbooking_message .= $tzbooking_order_output;
        }
        $tzbooking_message .= $tzbooking_description . "\n";
        if($tzbooking_order_option == true && $tzbooking_order_position == 'after'){
            $tzbooking_message .= $tzbooking_order_output;
        }
        $tzbooking_message .= "</body>\n";
        $tzbooking_message .= "</html>\n";
        $tzbooking_mailsent = wp_mail( $tzbooking_to_address, $tzbooking_subject, $tzbooking_message, $tzbooking_headers );
        return ($tzbooking_mailsent)?(true):(false);
    }
}
/****	End Page Thank You	****/


/*
 * get language count
 */
if ( ! function_exists( 'tzbooking_get_lang_count' ) ) {
    function tzbooking_get_lang_count() {
        $language_count = 1;
        // wpml variables
        if ( defined('ICL_LANGUAGE_CODE') ) {
            $languages = icl_get_languages('skip_missing=1');
            $language_count = count( $languages );
        }
        return $language_count;
    }
}

/*
 * get default language
 */
if ( ! function_exists( 'tzbooking_get_default_language' ) ) {
    function tzbooking_get_default_language() {
        global $sitepress;

        if ( $sitepress ) {
            return $sitepress->get_default_language();
        } elseif ( defined(WPLANG) ) {
            return WPLANG;
        }

        return "en";
    }
}

/****	End Page Thank You	****/

/****	Tour List & Grid	****/

/*  Form Booking Ajax  */
function tzbooking_ajax_booking_form () {
    global $tzbooking_options;
    $tzbooking_product_id        = $_POST['post_id'];
    $tzbooking_people_available = $_POST['people_available'];
    $tzbooking_product_type      = $_POST['product_type'];
    $tzbooking_max_adults     = $_POST['max_adults'];
    $tzbooking_max_kids       = $_POST['max_kids'];
    $tzbooking_adult_price    = $_POST['adults_price'];
    $tzbooking_child_price    = $_POST['child_price'];

    $tzbooking_discount    					= $_POST['discount'];
    $tzbooking_product_available_days    		= $_POST['available'];
    $tzbooking_product_start_date_milli_sec    	= $_POST['start_date'];
    $tzbooking_product_end_date_milli_sec    	= $_POST['end_date'];
    $tzbooking_product_departure_time    	    = isset($_POST['departure_time']) ? $_POST['departure_time']: '';

    $tzbooking_decimal_prec       = get_option('options_ap_price_num_decimals', 0);
    $tzbooking_decimal_sep        = get_option('options_ap_price_decimal_sep', ',');
    $tzbooking_thousands_sep      = get_option('options_ap_price_thousands_sep', ',');

    $tzbooking_day_start_week = get_option('start_of_week');

    ?>
    <div class="tz-close-form-booking bg"></div>
    <div class="tz-product-booking">
        <div class="tz-product-book-form">
            <div class="tz-product-price">
				<span class="tz-product-total-price">
					<?php echo esc_html__('Total:','travelami');?>

                    <span class="total-price">
						<span class="total_all_price">
							<?php
                            //							$tzbooking_total_price           =   $tzbooking_adult_price;
                            //							if( isset($tzbooking_total_price) ){
                            //								echo tzbooking_price($tzbooking_total_price);
                            //							}
                            ?>

                            <?php
                            if($tzbooking_adult_price != ''){
                                echo tzbooking_price($tzbooking_adult_price);
                            }elseif($tzbooking_child_price != ''){
                                echo tzbooking_price($tzbooking_child_price);'';
                            }
                            ?>
						</span>
					</span>
				</span>
                <span class="tz-product-price-per-person">
					<?php echo esc_html__('From','travelami');?>
                    <span class="price-per-person">
						<?php
                        //						if( isset($tzbooking_adult_price) ){
                        //							echo tzbooking_price($tzbooking_adult_price);
                        //						}
                        ?>

                        <?php
                        if($tzbooking_adult_price != ''){
                            echo tzbooking_price($tzbooking_adult_price);
                        }elseif($tzbooking_child_price != ''){
                            echo tzbooking_price($tzbooking_child_price);
                        }?>
					</span>
                    <?php echo esc_html__('/person','travelami');?>
				</span>
            </div>
            <form method="get" id="booking-form" action="<?php echo esc_url( tzbooking_get_product_cart_page() ); ?>">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($tzbooking_product_id);?>">
                <!--                --><?php //if($tzbooking_people_available != NULL){?>
                <input type="hidden" name="people_available" value="<?php echo $tzbooking_people_available;?>">
                <!--                --><?php //} ?>
                <div class="form-group">
                    <label><?php esc_html_e('First Name','travelami') ?></label>
                    <div class="book-name">
                        <input name="first_name" value="" placeholder="<?php esc_html_e('First name','travelami') ?>" type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php esc_html_e('Last Name','travelami') ?></label>
                    <div class="book-name">
                        <input name="last_name" value="" placeholder="<?php esc_html_e('Last name','travelami') ?>" type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php esc_html_e('Email','travelami') ?></label>
                    <div class="book-email">
                        <input name="your_email" value="" placeholder="<?php esc_html_e('Email','travelami') ?>" type="text" required>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php esc_html_e('Phone','travelami') ?></label>
                    <div class="book-phone">
                        <input name="your_phone" value="" placeholder="<?php esc_html_e('Phone','travelami') ?>" type="text" required>
                    </div>
                </div>
                <?php if($tzbooking_product_type == 'daily'):?>
                    <div class="form-group">
                        <label><?php esc_html_e('Departure Date','travelami') ?></label>
                        <div class="book-departure-date">
                            <input class="date-pick form-control" data-locale="<?php echo esc_attr(get_locale()); ?>" data-day-start-week= "<?php echo esc_attr($tzbooking_day_start_week);?>" data-date-format="yyyy-mm-dd" type="text" name="date" placeholder="<?php esc_html_e('mm/dd/yyyy','travelami') ?>">
                        </div>
                    </div>
                <?php endif;?>
                <?php if ( ! empty( $tzbooking_product_departure_time ) ) :?>
                    <div class="form-group">
                        <label><?php esc_html_e('Departure Time','travelami') ?></label>
                        <div class="book-departure-time">
                            <select name="departure_time">
                                <option  value=""><?php esc_html_e('Choose departure time','travelami' ); ?></option>
                                <?php

                                foreach ( $tzbooking_product_departure_time as $tzbooking_time ) {
                                    echo '<option  value="' . esc_attr( $tzbooking_time ) . '">'. esc_html( $tzbooking_time ) .'</option>';
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                <?php endif;?>

                <p class="our-of-stock-message"><?php echo esc_html__('Out of stock','travelami'); ?></p>


                <?php if( isset($tzbooking_adult_price) && $tzbooking_adult_price != '' ){ ?>
                    <div class="form-group">
                        <label><?php esc_html_e('Adults','travelami') ?></label>
                        <div class="st_adults_children">
                            <div class="input-number-ticket">
                                <input class="input-number" name="number_adults" type="text" value="1" min="1" max="<?php echo esc_attr($tzbooking_max_adults); ?>" data-min="1" data-max="<?php echo esc_attr($tzbooking_max_adults); ?>"/>
                                <span class="input-number-decrement"><i class="fas fa-caret-left"></i></span><span class="input-number-increment"><i class="fas fa-caret-right"></i></span>
                                <input name="price_adults" value="<?php echo esc_html($tzbooking_adult_price); ?>" type="hidden">
                            </div>
                            <div class="tz_price">
                                <span class="adult_price"><?php if( isset($tzbooking_adult_price) ) echo esc_html('×&nbsp;').tzbooking_price($tzbooking_adult_price); ?></span>
                                <span class="total_price_adults"><?php if( isset($tzbooking_adult_price) ) echo esc_html('=&nbsp;').tzbooking_price($tzbooking_adult_price); ?></span>
                            </div>
                        </div>
                    </div>
                <?php }?>
                <?php if( isset($tzbooking_child_price) && $tzbooking_child_price != '' ){ ?>
                    <div class="form-group ">
                        <label><?php esc_html_e('Children','travelami') ?></label>
                        <div class="st_adults_children">
                            <div class="input-number-ticket">
                                <input class="input-number" name="number_children" type="text" value="0" min="0" max="<?php echo esc_attr($tzbooking_max_kids); ?>" data-min="0" data-max="<?php echo esc_attr($tzbooking_max_kids); ?>"/>
                                <span class="input-number-decrement"><i class="fas fa-caret-left"></i></span><span class="input-number-increment"><i class="fas fa-caret-right"></i></span>
                                <input name="price_child" value="<?php echo esc_html($tzbooking_child_price); ?>" type="hidden">
                            </div>
                            <div class="tz_price">
                                <span class="child_price"><?php if( isset($tzbooking_child_price) ) echo esc_html('×&nbsp;').tzbooking_price($tzbooking_child_price); ?></span>
                                <span class="total_price_children"><?php echo esc_html('=&nbsp;').tzbooking_price(0); ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <p class="book-message 333">
                    <?php echo esc_html__('Exceed the maximum number of people for this tour. The number of seats available is ','travelami')?>
                    <span class="book-number-available">10</span>
                </p>
                <button type="submit" class="btn_full book-now"><?php echo esc_html__( 'Booking now', 'travelami' ) ?></button>
            </form>
            <span class="tz-close-form-booking"><i class="fas fa-times"></i></span>
        </div>
        <div class="tz-booking-data" data-adults-price="<?php if($tzbooking_adult_price != ''){ echo esc_attr( $tzbooking_adult_price ); }else{ echo '0';} ?>" data-child-price="<?php if($tzbooking_child_price != ''){ echo esc_attr( $tzbooking_child_price ); }else{ echo '0';} ?>" data-discount="<?php echo esc_attr( $tzbooking_discount ); ?>" data-available-days='<?php echo json_encode($tzbooking_product_available_days );?>' data-start-date="<?php echo esc_attr($tzbooking_product_start_date_milli_sec); ?>" data-end-date="<?php echo esc_attr($tzbooking_product_end_date_milli_sec); ?>" data-decimal-prec="<?php echo esc_attr($tzbooking_decimal_prec); ?>" data-decimal-sep="<?php echo esc_attr($tzbooking_decimal_sep); ?>" data-thousands-sep="<?php echo esc_attr($tzbooking_thousands_sep); ?>" data-departure-time='<?php echo json_encode($tzbooking_product_departure_time );?>'></div>
    </div>
    <?php
    wp_die();
}

if ( is_user_logged_in() ) {
    add_action('wp_ajax_tzbooking_ajax_booking_form','tzbooking_ajax_booking_form');
}else{
    add_action('wp_ajax_nopriv_tzbooking_ajax_booking_form','tzbooking_ajax_booking_form');
}
/*  End Form Booking Ajax  */

/*  Review Lightbox Ajax  */
function tzbooking_review_lightbox () {
    $tzbooking_post_id       = $_POST['post_id'];

    $tzbooking_args = array(
        'post_id' => $tzbooking_post_id,
        'hierarchical' => true,
        'meta_query' => array(
            array(
                'key' => 'tz-rating',
                'value' => 0,
                'compare' => '!='
            )
        )
    );
    $tzbooking_comments = get_comments( $tzbooking_args );
    $tzbooking_comments_number = tzbooking_parent_comment_counter($tzbooking_post_id);

    echo '<div class="tz-close-preview bg"></div>';
    echo '<div class="reviews">';
    if( isset($tzbooking_comments) && !empty($tzbooking_comments) ){
        if( $tzbooking_comments_number > 2 ){
            echo '<h2 class="comments-title">'.esc_html($tzbooking_comments_number).esc_html__(' Reviews','travelami').'</h2>';
        }else{
            echo '<h2 class="comments-title">'.esc_html($tzbooking_comments_number).esc_html__(' Review','travelami').'</h2>';
        }
        echo '<ol class="comment-list">';
        foreach($tzbooking_comments as $tzbooking_comment) {
            $tzbooking_comment_ID = $tzbooking_comment->comment_ID;
            ?>
            <li id="li-comment-<?php echo esc_attr($tzbooking_comment_ID); ?>">
                <div id="comment-<?php echo esc_attr($tzbooking_comment_ID); ?>" class="comments">
                    <div class="comment-meta comment-author vcard">
                        <?php echo get_avatar( $tzbooking_comment, 75 ); ?>
                    </div>

                    <?php if ( '0' == $tzbooking_comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation"><?php  esc_html_e( 'Your comment is awaiting moderation.', 'travelami'); ?></p>
                    <?php endif; ?>

                    <div class="comment-content">
                        <?php
                        /*	Get Author	*/
                        $tzbooking_author_url    = $tzbooking_comment->comment_author_url;
                        $tzbooking_author  		= $tzbooking_comment->comment_author;
                        if ( empty( $tzbooking_author_url ) || 'http://' == $tzbooking_author_url ){
                            echo '<h5 class="fn">'.esc_attr($tzbooking_author).'</h5>';
                        }else{
                            echo '<h5 class="fn"><a href="'.esc_url($tzbooking_author_url).'" rel="external nofollow" class="url">'.esc_html($tzbooking_author).'</a></h5>';
                        }

                        /*	Get Time	*/
                        $tzbooking_comment_date = false ? $tzbooking_comment->comment_date_gmt : $tzbooking_comment->comment_date;
                        $tzbooking_date = mysql2date(get_option('time_format'), $tzbooking_comment_date, true);

                        ?>

                        <div class="content">
                            <span class="time"><?php echo esc_attr($tzbooking_date); ?></span>
                            <span class="sp"> <?php echo esc_html__('-','travelami'); ?></span>
                            <span class="date"><?php comment_date('',$tzbooking_comment_ID); ?></span>
                        </div>
                        <?php
                        comment_text($tzbooking_comment_ID);

                        // Get rating
                        $tzbooking_rating = get_comment_meta( $tzbooking_comment_ID, 'tz-rating', true );
                        $tzbooking_rating = ( empty( $tzbooking_rating ) ? 0 : $tzbooking_rating );

                        // Build rating HTML
                        if( $tzbooking_rating == 5 ){
                            echo '<div class="tz-average-rating rating"><div class="tz-rating tz-rating-50">' . esc_html($tzbooking_rating) . '</div></div>';
                        }else{
                            echo '<div class="tz-average-rating rating"><div class="tz-rating tz-rating-' . esc_attr($tzbooking_rating) . '">' . esc_html($tzbooking_rating) . '</div></div>';
                        }
                        ?>

                    </div><!-- .comment-content -->
                    <div class="clearfix"></div>
                </div><!-- #comment-## -->
            </li>
            <?php
        }
        echo '</ol>'; ?>
        <?php
    }else{
        echo '<h2 class="comments-title notdata">'.esc_html__('Did not find review', 'travelami').'</h2>';
    }
    echo '<a class="permalink" href="'.get_the_permalink($tzbooking_post_id).'" target="_blank">'.esc_html__('Go To Reviews','travelami').'</a>';
    echo '<div class="tz-close-preview"><i class="fas fa-times"></i></div>';
    echo '</div>';

    wp_die();
}

if ( is_user_logged_in() ) {
    add_action('wp_ajax_tzbooking_review_lightbox','tzbooking_review_lightbox');
}else{
    add_action('wp_ajax_nopriv_tzbooking_review_lightbox','tzbooking_review_lightbox');
}
/*  End Form Review Ajax  */

/****	End Tour List & Grid	****/

/****	Tour Woocommerce	****/

/*
 * Add Tour product to WooCommerce Cart
 */
if ( ! function_exists( 'tzbooking_add_product_to_woo_cart' ) ) {
    function tzbooking_add_product_to_woo_cart() {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'product_update_cart' ) ) {
            print esc_html__( 'Sorry, your nonce did not verify.', 'travelami' );
            exit;
        }

        // init variables
        $product_id = $_POST['product_id'];
        $booking_date = $_POST['date'];
        $booking_time = $_POST['time'];
//        $uid = $product_id . $booking_date;
        $uid = $product_id . str_replace( array('/') , '', $booking_date )  . str_replace( array(':') , '', $booking_time );

        $product_product_id = tzbooking_create_product_product( $product_id, $uid );

        if ( !$product_product_id || is_wp_error( $product_product_id ) ) {
            wp_send_json( array( 'success'=>0, 'message'=>'Can not add Tour to Cart. Please try again later' ) );
        }

        global $woocommerce;

        $cart = $woocommerce->cart->get_cart();
        $in_cart = false;
        // check if product already in cart
        if ( count( $cart ) > 0 ) {
            foreach ( $cart as $cart_item_key => $values ) {
                $_product = $values['data'];
                if ( $_product->id == $product_product_id ) {
                    $in_cart = true;
                }
            }
            if ( ! $in_cart ) {
                $woocommerce->cart->add_to_cart( $product_product_id );
            }
        } else {
            $woocommerce->cart->add_to_cart( $product_product_id );
        }
        $cart = $woocommerce->cart->get_cart();

        wp_send_json( array( 'success'=>1, 'message'=>'success' ) );
    }
}

add_action( 'wp_ajax_tzbooking_add_product_to_woo_cart', 'tzbooking_add_product_to_woo_cart' );
add_action( 'wp_ajax_nopriv_tzbooking_add_product_to_woo_cart', 'tzbooking_add_product_to_woo_cart' );


/*
 * Create product for selected Tour
 */
if ( ! function_exists( 'tzbooking_create_product_product' ) ) {
    function tzbooking_create_product_product( $tzbooking_product_id, $tzbooking_uid ) {

        $tzbooking_discount = get_post_meta( $tzbooking_product_id, 'tzbooking_product_discount', true );
        $tzbooking_discount = empty( $tzbooking_discount ) ? 0 : $tzbooking_discount;

        $tzbooking_cart = new TZbooking_Session_Cart();
        $tzbooking_cart_info = $tzbooking_cart->tzbooking_get( $tzbooking_uid );

        $tzbooking_date          =   $tzbooking_cart_info['date'];
        $tzbooking_time          =   $tzbooking_cart_info['time'];
        $tzbooking_adults        =   $tzbooking_cart_info['adults'];
        $tzbooking_kids          =   $tzbooking_cart_info['kids'];
        $tzbooking_name_combo    =   $tzbooking_cart_info['name_combo'];
        $tzbooking_people_combo  =   $tzbooking_cart_info['people_combo'];
        $tzbooking_price_combo   =   $tzbooking_cart_info['price_combo'];
        $tzbooking_total_price   =   $tzbooking_cart_info['total_price'];
        $tzbooking_total_adults  =   $tzbooking_cart_info['total_adults'];
        $tzbooking_total_kids    =   $tzbooking_cart_info['total_kids'];

        $product_product = array(
            'post_title'        => get_the_title( $tzbooking_product_id ),
            'post_content'      => '',
            'post_status'       => 'publish',
            'post_type'         => 'product',
            'comment_status'    => 'closed',
            'import_id'         => 125,
        );
        //Create Tour Product
        $product_product_id = wp_insert_post( $product_product );

        if( $product_product_id ) {
            $attach_id = get_post_meta( $tzbooking_product_id, "_thumbnail_id", true );
            update_post_meta( $product_product_id, '_thumbnail_id', $attach_id );

            wp_set_object_terms( $product_product_id, 'tour', 'product_cat' );
            wp_set_object_terms( $product_product_id, 'simple_product', 'product_type' );
//            update_post_meta( $product_product_id, 'product_type', 'simple_product' );

            $default_attributes = array();
            update_post_meta( $product_product_id, '_sku', 'sku' . $tzbooking_uid );
            update_post_meta( $product_product_id, '_stock_status', 'instock' );
            update_post_meta( $product_product_id, '_visibility', 'visible' );
            update_post_meta( $product_product_id, '_virtual', 'yes');
            update_post_meta( $product_product_id, '_default_attributes', $default_attributes );
            update_post_meta( $product_product_id, '_manage_stock', 'no' );
            update_post_meta( $product_product_id, '_backorders', 'no' );



            $tzbooking_booking_price = $tzbooking_total_price * (100-$tzbooking_discount)/100;

            if( $tzbooking_price_combo != '' && $tzbooking_price_combo != 'custom' ){
                $tzbooking_booking_price = intval($tzbooking_price_combo) * (100-$tzbooking_discount)/100;
            }

            update_post_meta( $product_product_id, '_regular_price', $tzbooking_booking_price );
            update_post_meta( $product_product_id, '_sale_price', $tzbooking_booking_price );
            update_post_meta( $product_product_id, '_price', $tzbooking_booking_price );

            update_post_meta( $product_product_id, 'tzbooking_post_id', $tzbooking_product_id );
            update_post_meta( $product_product_id, 'tzbooking_booking_date', $tzbooking_date );
            update_post_meta( $product_product_id, 'tzbooking_booking_time', $tzbooking_time );
            update_post_meta( $product_product_id, 'tzbooking_total_price', $tzbooking_booking_price );

            $booking_info = array();

            $booking_info['product_id']        = $tzbooking_product_id;
            $booking_info['name_combo']     = $tzbooking_name_combo;
            $booking_info['people_combo']   = $tzbooking_people_combo;
            $booking_info['adults']         = $tzbooking_adults;
            $booking_info['kids']           = $tzbooking_kids;
            $booking_info['price_combo'] 	= $tzbooking_price_combo;
            $booking_info['total_adults']   = $tzbooking_total_adults;
            $booking_info['total_kids']     = $tzbooking_total_kids;
            $booking_info['total_price']    = $tzbooking_booking_price;

            update_post_meta( $product_product_id, 'tzbooking_booking_info', $booking_info );

        }

        return $product_product_id;
//        return $tzbooking_cart_info;
    }
}


/**
 * Apply a different tax rate based on the user role.
 */
function tzbooking_diff_rate_for_user( $tax_class, $product ) {
    $product_id = $product->get_id();
    $product_cats = wp_get_post_terms($product_id, 'product_cat');
    foreach ($product_cats as $cat){
        if( $cat->name == 'Tours' ){
            $tax_class = 'Zero Rate';
        }
    }
    return $tax_class;
}
add_filter( 'woocommerce_product_get_tax_class', 'tzbooking_diff_rate_for_user', 1, 2 );

/****	End Tour Woocommerce	****/

/*****  End Tour Function   *****/