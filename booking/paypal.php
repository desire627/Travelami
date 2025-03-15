<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use TemPlazaFramework\Functions;
if ( ! class_exists( 'TZbooking_PayPal' ) ) {
    class TZbooking_PayPal
    {
        function TZbooking_PPHttpPost($tzbooking_methodName_, $tzbooking_nvpStr_, $tzbooking_ApiUsername, $tzbooking_ApiPassword, $tzbooking_ApiSignature, $tzbooking_Mode)
        {
            /* Set up your API credentials, PayPal end point, and API version. */
            $tzbooking_API_UserName = urlencode($tzbooking_ApiUsername);
            $tzbooking_API_Password = urlencode($tzbooking_ApiPassword);
            $tzbooking_API_Signature = urlencode($tzbooking_ApiSignature);

            $tzbooking_paypalmode = ($tzbooking_Mode == 'sandbox') ? '.sandbox' : '';

            $tzbooking_API_Endpoint = "https://api-3t" . $tzbooking_paypalmode . ".paypal.com/nvp";
            $tzbooking_version = urlencode('124.0');

            /* Set the curl parameters. */
            $tzbooking_ch = curl_init();

            curl_setopt($tzbooking_ch, CURLOPT_URL, $tzbooking_API_Endpoint);
            curl_setopt($tzbooking_ch, CURLOPT_VERBOSE, 1);
            /* Turn off the server and peer verification (TrustManager Concept). */
            curl_setopt($tzbooking_ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            curl_setopt($tzbooking_ch, CURLOPT_SSL_VERIFYHOST, FALSE);

            curl_setopt($tzbooking_ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($tzbooking_ch, CURLOPT_POST, 1);

            /* Set the API operation, version, and API signature in the request. */
            $tzbooking_nvpreq = "METHOD=$tzbooking_methodName_&VERSION=$tzbooking_version&PWD=$tzbooking_API_Password&USER=$tzbooking_API_UserName&SIGNATURE=$tzbooking_API_Signature$tzbooking_nvpStr_";
            /* Set the request as a POST FIELD for curl. */
            curl_setopt($tzbooking_ch, CURLOPT_POSTFIELDS, $tzbooking_nvpreq);
            $tzbooking_httpResponse = curl_exec($tzbooking_ch);


            /* Get response from the server. */
            if (!$tzbooking_httpResponse) {
                exit("$tzbooking_methodName_ failed: " . curl_error($tzbooking_ch) . '(' . curl_errno($tzbooking_ch) . ')');
            }

            /* Extract the response details. */
            $tzbooking_httpResponseAr = explode("&", $tzbooking_httpResponse);

            $tzbooking_httpParsedResponseAr = array();
            foreach ($tzbooking_httpResponseAr as $tzbooking_i => $tzbooking_value) {
                $tzbooking_tmpAr = explode("=", $tzbooking_value);
                if (sizeof($tzbooking_tmpAr) > 1) {
                    $tzbooking_httpParsedResponseAr[$tzbooking_tmpAr[0]] = $tzbooking_tmpAr[1];
                }
            }

            if ((0 == sizeof($tzbooking_httpParsedResponseAr)) || !array_key_exists('ACK', $tzbooking_httpParsedResponseAr)) {
                exit("Invalid HTTP Response for POST request($tzbooking_nvpreq) to $tzbooking_API_Endpoint.");
            }

            return $tzbooking_httpParsedResponseAr;
        }
    }
}

/*
 * check if paypal payment is enabled
 */
if ( ! function_exists( 'tzbooking_is_paypal_enabled' ) ) {
    function tzbooking_is_paypal_enabled() {
        if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
            $templaza_options = array();
        }else{
            $templaza_options = Functions::get_theme_options();
        }
        return ! empty( $templaza_options['ap_product_payment_paypal'] );
    }
}

/*
 * payment enabled status filter
 */
if ( ! function_exists( 'tzbooking_pp_is_payment_enabled' ) ) {
    function tzbooking_pp_is_payment_enabled( $tzbooking_status ) {
        return $tzbooking_status || tzbooking_is_paypal_enabled();
    }
}

add_filter( 'tzbooking_is_payment_enabled', 'tzbooking_pp_is_payment_enabled' );


/*  Credit Card */
function tzbooking_is_valid_card_number($tzbooking_toCheck) {
    if (!is_numeric($tzbooking_toCheck))
        return false;

    $tzbooking_number = preg_replace('/[^0-9]+/', '', $tzbooking_toCheck);
    $tzbooking_strlen = strlen($tzbooking_number);
    $tzbooking_sum = 0;

    if ($tzbooking_strlen < 13)
        return false;

    for ($tzbooking_i = 0; $tzbooking_i < $tzbooking_strlen; $tzbooking_i++) {
        $tzbooking_digit = substr($tzbooking_number, $tzbooking_strlen - $tzbooking_i - 1, 1);
        if ($tzbooking_i % 2 == 1) {
            $tzbooking_sub_total = $tzbooking_digit * 2;
            if ($tzbooking_sub_total > 9) {
                $tzbooking_sub_total = 1 + ($tzbooking_sub_total - 10);
            }
        } else {
            $tzbooking_sub_total = $tzbooking_digit;
        }
        $tzbooking_sum += $tzbooking_sub_total;
    }

    if ($tzbooking_sum > 0 AND $tzbooking_sum % 10 == 0)
        return true;

    return false;
}

function tzbooking_is_valid_card_type($tzbooking_toCheck) {
    $tzbooking_acceptable_cards = array(
        "Visa",
        "MasterCard",
        "Discover",
        "Amex"
    );

    return $tzbooking_toCheck AND in_array($tzbooking_toCheck, $tzbooking_acceptable_cards);
}

function tzbooking_is_valid_expiry($tzbooking_month, $tzbooking_year) {
    $tzbooking_now = time();
    $tzbooking_thisYear = (int) date('Y', $tzbooking_now);
    $tzbooking_thisMonth = (int) date('m', $tzbooking_now);

    if (is_numeric($tzbooking_year) && is_numeric($tzbooking_month)) {
        $tzbooking_thisDate = mktime(0, 0, 0, $tzbooking_thisMonth, 1, $tzbooking_thisYear);
        $tzbooking_expireDate = mktime(0, 0, 0, $tzbooking_month, 1, $tzbooking_year);

        return $tzbooking_thisDate <= $tzbooking_expireDate;
    }

    return false;
}

function tzbooking_is_valid_cvv_number($tzbooking_toCheck) {
    $tzbooking_length = strlen($tzbooking_toCheck);
    return is_numeric($tzbooking_toCheck) AND $tzbooking_length > 2 AND $tzbooking_length < 5;
}

add_filter( 'http_request_timeout', 'tzbooking_wp9838c_timeout_extend' );

function tzbooking_wp9838c_timeout_extend( $time )
{
    /* Default timeout is 5 */
    return 200;
}