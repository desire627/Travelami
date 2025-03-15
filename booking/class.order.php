<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'TZbooking_Product_Order' ) ) {
    class TZbooking_Product_Order {
        public $order_id = '';
        public $service_data;
        public function __construct() {
            $a = func_get_args();
            $i = func_num_args();
            if (method_exists($this,$f='__construct'.$i)) {
                call_user_func_array(array($this,$f),$a);
            }
        }
        public function __construct1( $order_id ) {
            $this->order_id = $order_id;
        }

        public function __construct2( $booking_no, $pin_code ) {
            $this->order_id = $this->tzbooking_get_order_id( $booking_no, $pin_code );
        }


        public static function tzbooking_get_order_id( $booking_no, $pin_code ) {
            global $wpdb;
            $order_id = $wpdb->get_var( 'SELECT tzbooking_order.id FROM ' . $wpdb->prefix . 'tzbooking_order AS tzbooking_order WHERE tzbooking_order.booking_no="' . esc_sql( $booking_no ) . '" AND tzbooking_order.pin_code="' . esc_sql( $pin_code ) . '"' );
            if ( empty( $order_id ) ) return false;
            return $order_id;
        }

        public function tzbooking_get_order_info() {
            global $wpdb;
            if ( empty( $this->order_id ) ) return false;
            $order_data = $wpdb->get_row( 'SELECT tzbooking_order.* FROM ' . $wpdb->prefix . 'tzbooking_order AS tzbooking_order WHERE tzbooking_order.id="' . esc_sql( $this->order_id ) . '"', ARRAY_A );
            if ( empty( $order_data ) ) return false;
            return $order_data;
        }

        public function tzbooking_get_products() {
            global $wpdb;
            if ( empty( $this->order_id ) ) return false;
            $product_data = $wpdb->get_row( 'SELECT tzbooking_bookings.* FROM ' . $wpdb->prefix . 'tzbooking_order AS tzbooking_order
											INNER JOIN ' . $wpdb->prefix . 'tzbooking_product_bookings AS tzbooking_bookings ON tzbooking_bookings.order_id = tzbooking_order.id
											WHERE tzbooking_order.id="' . esc_sql( $this->order_id ) . '"', ARRAY_A );
            if ( empty( $product_data ) ) return false;
            return $product_data;
        }
    }
}