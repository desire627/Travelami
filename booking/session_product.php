<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'TZbooking_Session_Cart' ) ) {
	class TZbooking_Session_Cart {
		public function __construct() {
			if ( empty( $_SESSION['cart'] ) ) $_SESSION['cart'] = array();
		}

		public static function tzbooking_set( $tzbooking_uid, $tzbooking_data ) {
			if ( empty( $tzbooking_uid ) );
			$_SESSION['cart'][$tzbooking_uid] = $tzbooking_data;
		}
		public static function tzbooking_get( $tzbooking_uid=0 ) {
			if ( ! empty( $_SESSION['cart'] ) && ! empty( $_SESSION['cart'][$tzbooking_uid] ) ) return $_SESSION['cart'][$tzbooking_uid];
			return false;
		}
		public static function tzbooking_unset( $tzbooking_uid=0 ) {
			if ( ! empty( $_SESSION['cart'] ) && ! empty( $_SESSION['cart'][$tzbooking_uid] ) ) {
				unset( $_SESSION['cart'][$tzbooking_uid] );
			}
		}
		public function tzbooking_get_field( $tzbooking_uid=0, $tzbooking_field='total_price' ) {
			$tzbooking_cart = $this->tzbooking_get( $tzbooking_uid );
			if ( $tzbooking_cart && ! empty( $tzbooking_cart[$tzbooking_field] ) ) return $tzbooking_cart[$tzbooking_field];
			return 0;
		}
	}
}