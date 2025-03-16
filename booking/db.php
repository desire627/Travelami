<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Create More Tables
 */
if ( ! function_exists( 'tzbooking_create_extra_tables' ) ) {
    function tzbooking_create_extra_tables() {
        global $wpdb;
        $tzbooking_installed_db_ver = get_option( "tzbooking_db_version" );
        if ( $tzbooking_installed_db_ver != '1.0' ) {
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            $tzbooking_sql = "CREATE TABLE " . $wpdb->prefix . "tzbooking_product_bookings (
						id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
						product_id bigint(20) unsigned DEFAULT NULL,
						st_id tinyint(1) DEFAULT '0',
						booking_time time DEFAULT '00:00:00',
						booking_date date DEFAULT '0000-00-00',
						adults tinyint(1) unsigned DEFAULT '0',
						kids tinyint(1) unsigned DEFAULT '0',
						people_combo tinyint(5) unsigned DEFAULT '0',
						total_price decimal(16,2) DEFAULT '0.00',
						order_id bigint(20) unsigned DEFAULT NULL,
						PRIMARY KEY  (id)
					) DEFAULT CHARSET=utf8;";
            dbDelta($tzbooking_sql);

            $tzbooking_sql = "CREATE TABLE " . $wpdb->prefix . "tzbooking_order (
						id bigint(20) NOT NULL AUTO_INCREMENT,
						first_name varchar(255) DEFAULT NULL,
						last_name varchar(255) DEFAULT NULL,
						email varchar(255) DEFAULT NULL,
						phone varchar(255) DEFAULT NULL,
						country varchar(255) DEFAULT NULL,
						address varchar(255) DEFAULT NULL,
						city varchar(255) DEFAULT NULL,
						state varchar(255) DEFAULT NULL,
						zip varchar(255) DEFAULT NULL,
						order_notes text CHARACTER SET latin1,
						name_combo varchar(255) DEFAULT NULL,
						people_combo int(5) DEFAULT '0',
						price_combo int(5) DEFAULT '0',
						total_price decimal(16,2) DEFAULT '0.00',
						total_adults int(5) DEFAULT '0',
						total_kids int(5) DEFAULT '0',
						time time DEFAULT NULL,
						date_from date DEFAULT NULL,
						date_to date DEFAULT NULL,
						post_id bigint(20) DEFAULT NULL,
						booking_no bigint(20) DEFAULT NULL,
						pin_code int(5) DEFAULT NULL,
						payment_method varchar(20) DEFAULT NULL,
						status varchar(20) DEFAULT 'new',
						deposit_paid tinyint(1) DEFAULT '0',
						currency_code varchar(8) DEFAULT NULL,
						other text CHARACTER SET latin1,
						created datetime DEFAULT NULL,
						mail_sent tinyint(1) DEFAULT '0',
						updated datetime DEFAULT NULL,
						post_type varchar(20) DEFAULT NULL,
						fnr int(11) DEFAULT '0',
						total_fnr float DEFAULT '0',
						PRIMARY KEY  (id)
					) DEFAULT CHARSET=utf8;";
            dbDelta($tzbooking_sql);

            update_option( "tzbooking_db_version", '1.0' );
        }

    }
}

add_action("after_switch_theme", "tzbooking_create_extra_tables");

// Find the version constant or variable
define('TZBOOKING_DB_VERSION', '1.1'); // Increment from previous version

// Or if it's a variable:
$tzbooking_db_version = '1.1'; // Increment from previous version

// Find the function that inserts order data
function tzbooking_insert_order($order_data) {
    global $wpdb;
    
    // Ensure FNR data is included
    $fnr = isset($order_data['fnr']) ? intval($order_data['fnr']) : 0;
    $total_fnr = isset($order_data['total_fnr']) ? floatval($order_data['total_fnr']) : 0;
    
    // Insert data into database
    $result = $wpdb->insert(
        $wpdb->prefix . 'tzbooking_order',
        array(
            // Existing fields
            'adults' => $order_data['adults'],
            'kids' => $order_data['kids'],
            'fnr' => $fnr, // Make sure this is included
            'total_adults' => $order_data['total_adults'],
            'total_kids' => $order_data['total_kids'],
            'total_fnr' => $total_fnr, // Make sure this is included
            // Other fields
        ),
        array(
            // Format specifiers - make sure to add '%d' for fnr and '%f' for total_fnr
            '%d', '%d', '%d', // adults, kids, fnr
            '%f', '%f', '%f', // total_adults, total_kids, total_fnr
            // Other format specifiers
        )
    );
    
    return $result ? $wpdb->insert_id : false;
}

// Find the function that retrieves order data
function tzbooking_get_order($booking_no, $pin_code) {
    global $wpdb;
    
    // Make sure to include fnr and total_fnr in the SELECT statement
    $sql = $wpdb->prepare(
        "SELECT id, booking_no, pin_code, product_id, date, time, 
        adults, kids, fnr, /* Make sure fnr is included */
        total_price, total_adults, total_kids, total_fnr, /* Make sure total_fnr is included */
        first_name, last_name, email, phone 
        FROM {$wpdb->prefix}tzbooking_order 
        WHERE booking_no = %s AND pin_code = %s",
        $booking_no, $pin_code
    );
    
    return $wpdb->get_row($sql);
}

// Find the function that updates order data
function tzbooking_update_order($order_id, $order_data) {
    global $wpdb;
    
    // Ensure FNR data is included
    $fnr = isset($order_data['fnr']) ? intval($order_data['fnr']) : 0;
    $total_fnr = isset($order_data['total_fnr']) ? floatval($order_data['total_fnr']) : 0;
    
    // Update data in database
    $result = $wpdb->update(
        $wpdb->prefix . 'tzbooking_order',
        array(
            // Existing fields
            'adults' => $order_data['adults'],
            'kids' => $order_data['kids'],
            'fnr' => $fnr, // Make sure this is included
            'total_adults' => $order_data['total_adults'],
            'total_kids' => $order_data['total_kids'],
            'total_fnr' => $total_fnr, // Make sure this is included
            // Other fields
        ),
        array('id' => $order_id),
        array(
            // Format specifiers
            '%d', '%d', '%d', // adults, kids, fnr
            '%f', '%f', '%f', // total_adults, total_kids, total_fnr
            // Other format specifiers
        ),
        array('%d')
    );
    
    return $result;
}
?>