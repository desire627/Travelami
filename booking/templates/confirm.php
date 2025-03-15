<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $templaza_options = array();
}else{
    $templaza_options = Functions::get_theme_options();
}
global $wpdb;

    if(isset( $_REQUEST['booking_no'] ) ||  isset( $_REQUEST['pin_code'] )){
        $tzbooking_order = new TZbooking_Product_Order( $_REQUEST['booking_no'], $_REQUEST['pin_code'] );
        if ( ! $tzbooking_order_data = $tzbooking_order->tzbooking_get_order_info() ) {

            exit;
        }
        if ( empty( $tzbooking_order_data['deposit_paid'] ) ) {
            /* init payment variables   */
            $tzbooking_ItemName = sprintf( esc_html__( 'Deposit for your order %d', 'travelami' ), $tzbooking_order_data['id'] );
            $tzbooking_payment_data = array();
            $tzbooking_payment_data['item_name'] = $tzbooking_ItemName;
            $tzbooking_payment_data['item_number'] = $tzbooking_order_data['id'];
            $tzbooking_payment_data['item_desc'] = get_the_title( $tzbooking_order_data['post_id'] );
            if ( ! empty( $tzbooking_order_data['date_from'] ) ) $tzbooking_payment_data['item_desc'] .= ' ' . esc_html__( 'Date', 'travelami' ) . ' ' . tzbooking_get_phptime( $tzbooking_order_data['date_from'] );
            $tzbooking_payment_data['item_qty'] = 1;
            $tzbooking_payment_data['item_price'] = $tzbooking_order_data['total_price'];
            $tzbooking_payment_data['item_total_price'] = $tzbooking_payment_data['item_qty'] * $tzbooking_payment_data['item_price'];
            $tzbooking_payment_data['grand_total'] = $tzbooking_payment_data['item_total_price'];
            $tzbooking_payment_data['currency'] = strtoupper( $tzbooking_order_data['currency_code'] );
            $tzbooking_payment_data['return_url'] = tzbooking_get_current_page_url() . '?booking_no=' . $tzbooking_order_data['booking_no'] . '&pin_code=' . $tzbooking_order_data['pin_code'] . '&payment=success';
            $tzbooking_payment_data['cancel_url'] = tzbooking_get_current_page_url() . '?booking_no=' . $tzbooking_order_data['booking_no'] . '&pin_code=' . $tzbooking_order_data['pin_code'] . '&payment=failed';
            if(isset($_REQUEST['payment_info'])){
                if($_REQUEST['payment_info'] != 'cash'){
                    $tzbooking_payment_result = tzbooking_process_payment( $tzbooking_payment_data );
                    /* after payment    */
                    if ( $tzbooking_payment_result ) {
                        if ( ! empty( $tzbooking_payment_result['success'] ) && ( $tzbooking_payment_result['method'] == 'paypal' ) ) {
                            $tzbooking_other_booking_data = array();
                            if ( ! empty( $tzbooking_order_data['other'] ) ) {
                                $tzbooking_other_booking_data = unserialize( $tzbooking_order_data['other'] );
                            }
                            $tzbooking_other_booking_data['pp_transaction_id'] = $tzbooking_payment_result['transaction_id'];
                            $tzbooking_order_data['deposit_paid'] = 1;
                            $tzbooking_update_status = $wpdb->update( $wpdb->prefix . 'tzbooking_order', array( 'deposit_paid' => $tzbooking_order_data['deposit_paid'], 'other' => serialize( $tzbooking_other_booking_data ), 'status' => 'new' ), array( 'booking_no' => $tzbooking_order_data['booking_no'], 'pin_code' => $tzbooking_order_data['pin_code'] ) );
                            if ( $tzbooking_update_status === false ) {
                                do_action( 'tzbooking_payment_update_booking_error' );
                            } elseif ( empty( $tzbooking_update_status ) ) {
                                do_action( 'tzbooking_payment_update_booking_no_row' );
                            } else {
                                do_action( 'tzbooking_payment_update_booking_success' );
                            }
                        }
                    }
                }
            }
        }

        if ( empty( $tzbooking_order_data['mail_sent'] ) ) {
            do_action('tzbooking_order_conf_mail_not_sent', $tzbooking_order_data); /* mail is not sent */
        }
    }


$tzbooking_adult_price = $tzbooking_child_price = $tzbooking_fnr_price = '';
$adult_price  = isset($templaza_options['ap_product_data_price'])?$templaza_options['ap_product_data_price']:'';
if($adult_price){
    $tzbooking_adult_price = get_field($adult_price, $tzbooking_order_data['post_id']);
}
$child_price  = isset($templaza_options['ap_product_data_child_price'])?$templaza_options['ap_product_data_child_price']:'';
if($child_price){
    $tzbooking_child_price = get_field($child_price, $tzbooking_order_data['post_id']);
}
$fnr_price  = isset($templaza_options['ap_product_data_fnr_price'])?$templaza_options['ap_product_data_fnr_price']:'';
if($fnr_price){
    $tzbooking_fnr_price = get_field($fnr_price, $tzbooking_order_data['post_id']);
}
?>
<div class="tz-product-confirm">
    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
            <div class="form_title">
                <h3><?php echo esc_html__( 'Booking summary', 'travelami' ) ?></h3>
            </div>
            <div class="step summary">
                <span><?php echo esc_html__( 'You can check via booking information with below dashboard.', 'travelami' ) ?></span>
                <table class="table confirm">
                    <tbody>
                    <tr>
                        <td><?php esc_html_e( 'Full Name', 'travelami' ); ?></td>
                        <td><?php echo esc_html( $tzbooking_order_data['first_name'] . ' ' . $tzbooking_order_data['last_name'] ); ?></td>
                    </tr>
                    <?php if ( ! empty( $tzbooking_order_data['date_from'] ) && '0000-00-00' != $tzbooking_order_data['date_from'] ) : ?>
                        <tr>
                            <td><?php esc_html_e( 'Date', 'travelami' ); ?></td>
                            <td><?php echo date( 'j F Y', strtotime( $tzbooking_order_data['date_from'] ) ); ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td><?php esc_html_e( 'Tour Name', 'travelami' ); ?></td>
                        <td><?php echo get_the_title( $tzbooking_order_data['post_id'] ); ?></td>
                    </tr>

                    <tr>
                        <td><?php esc_html_e( 'Adults', 'travelami' ); ?></td>
                        <td><?php echo esc_html($tzbooking_order_data['total_adults']).' x '.esc_html( tzbooking_price($tzbooking_adult_price) ); ?></td>
                    </tr>
                    <?php if( $tzbooking_order_data['total_kids'] != 0 ){ ?>
                        <tr>
                            <td><?php esc_html_e( 'Children', 'travelami' ); ?></td>
                            <td><?php echo esc_html($tzbooking_order_data['total_kids']).' x '.esc_html( tzbooking_price($tzbooking_child_price) ); ?></td>
                        </tr>
                    <?php } ?>
                    <?php if( $tzbooking_order_data['total_fnr'] != 0 ){ ?>
                        <tr>
                            <td><?php esc_html_e( 'FNR', 'travelami' ); ?></td>
                            <td><?php echo esc_html($tzbooking_order_data['total_fnr']).' x '.esc_html( tzbooking_price($tzbooking_fnr_price) ); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td><?php esc_html_e( 'TOTAL COST', 'travelami' ); ?></td>
                        <td ><?php echo tzbooking_price( $tzbooking_order_data['total_price'] ); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div><!--End step -->
        </div><!--End col-md-8 -->
        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
            <div class="form_title uk-margin-medium-top">
                <h3><?php esc_html_e( 'Thank you!', 'travelami' ) ?></h3>
            </div>
            <div class="step confirmed">
                <span><?php echo esc_html__( 'Your Booking Order is Confirmed Now.', 'travelami' ) ?></span>
            </div><!--End step -->
        </div>
    </div><!--End row -->
</div>