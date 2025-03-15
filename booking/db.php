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
						PRIMARY KEY  (id)
					) DEFAULT CHARSET=utf8;";
            dbDelta($tzbooking_sql);

            update_option( "tzbooking_db_version", '1.0' );
        }

    }
}

add_action("after_switch_theme", "tzbooking_create_extra_tables");
?>