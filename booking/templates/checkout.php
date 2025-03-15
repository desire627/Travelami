<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
use TemPlazaFramework\Functions;
global $tzbooking_options;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $templaza_options = array();
}else{
    $templaza_options = Functions::get_theme_options();
}
$ap_product_payment_cash = isset($templaza_options['ap_product_payment_cash'])?$templaza_options['ap_product_payment_cash']:true;
$ap_product_payment_paypal = isset($templaza_options['ap_product_payment_paypal'])?$templaza_options['ap_product_payment_paypal']:true;
$ap_product_payment_paypal_card = isset($templaza_options['ap_product_payment_paypal_card'])?$templaza_options['ap_product_payment_paypal_card']:true;
/* validation*/

$tzbooking_required_params = array( 'uid' );

$tzbooking_options['tzbooking_payment_in_cash'] = true;

/* init variables   */
$tzbooking_uid = $_REQUEST['uid'];

if ( ! TZbooking_Session_Cart::tzbooking_get( $tzbooking_uid ) ) {
    echo '<div class="tz-product-checkout">';
    echo '<h5 class="alert alert-warning">'.esc_html__( 'Your cart is empty. Data will be loaded by check out page from Cart page.', 'travelami' ).'</h5>';
    echo '</div>';
}else{

    /* init variables*/
    $tzbooking_cart          =   new TZbooking_Session_Cart();
    $tzbooking_product_id       =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'product_id' );
    $tzbooking_date          =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'date' );
    $tzbooking_time          =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'time' );
    $tzbooking_adults        =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'adults' );
    $tzbooking_kids          =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'kids' );
    $tzbooking_name_combo    =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'name_combo' );
    $tzbooking_people_combo  =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'people_combo' );
    $tzbooking_price_combo   =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'price_combo' );
    $tzbooking_total_price   =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'total_price' );
    $tzbooking_total_adults  =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'total_adults' );
    $tzbooking_total_kids    =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'total_kids' );
    $tzbooking_total_fnr     =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'total_fnr' );
    $tzbooking_total_extras  =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'total_extras' );
    $tzbooking_first_name    =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'first_name' );
    $tzbooking_last_name     =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'last_name' );
    $tzbooking_email         =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'email' );
    $tzbooking_phone         =   $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'phone' );
    $tzbooking_countries     =   tzbooking_get_all_countries();
    $tzbooking_user_info     =   tzbooking_get_current_user_info();

    // Get extra options data
    $vacation_selected = $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'extra_vacation_selected' );
    $transport_selected = $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'extra_transport_selected' );
    $others_selected = $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'extra_others_selected' );
    
    $vacation_price = $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'extra_vacation_price' );
    $transport_price = $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'extra_transport_price' );
    $others_price = $tzbooking_cart->tzbooking_get_field( $tzbooking_uid, 'extra_others_price' );

    $tzbooking_total = $tzbooking_total_price;
    ?>
    <div class="tz-product-checkout">
        <?php
        if ( ! tzbooking_get_product_confirm_page() ) { ?>
            <h5 class="alert alert-warning"><?php esc_html_e( 'Please set booking confirmation page in theme options panel.', 'travelami' ) ?></h5>
        <?php } else { ?>
            <form id="booking-form" action="<?php echo esc_url( tzbooking_get_product_confirm_page() ); ?>">
                <div class="uk-grid" data-uk-grid>
                    <div class="tz-checkout-left uk-width-2-3">
                        <div class="form_title">
                            <h3><?php esc_html_e( 'Billing address', 'travelami' ) ?></h3>
                        </div>
                        <div class="form_content">
                            <input type="hidden" class="form-control" name="last_name" value="<?php echo esc_attr( $tzbooking_last_name != '' ? $tzbooking_last_name : $tzbooking_user_info['last_name'] ) ?>">
                            <div class="form-group">
                                <label><?php esc_html_e( 'Your Name', 'travelami' ) ?></label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo esc_attr( $tzbooking_first_name != '' ? $tzbooking_first_name : $tzbooking_user_info['first_name'] ) ?>">
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e( 'Company Name', 'travelami' ) ?></label>
                                <input type="text" class="form-control" name="company" value="<?php echo esc_attr( $tzbooking_user_info['company'] ) ?>">
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e( 'Country', 'travelami' ) ?></label>
                                <select class="form-control" name="country" id="country">
                                    <option value="" selected><?php esc_html_e( 'Select your country', 'travelami' ) ?></option>
                                    <?php foreach ( $tzbooking_countries as $tzbooking_country ) { ?>
                                        <option value="<?php echo esc_attr( $tzbooking_country['code'] ) ?>" <?php selected( $tzbooking_user_info['country_code'], $tzbooking_country['code'] ); ?>><?php echo esc_html( $tzbooking_country['name'] ) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e( 'Address', 'travelami' ) ?></label>
                                <input type="text" class="form-control" name="address" value="<?php echo esc_attr( $tzbooking_user_info['address'] ) ?>">
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e( 'Town / City', 'travelami' ) ?></label>
                                <input type="text" class="form-control" name="city" value="<?php echo esc_attr( $tzbooking_user_info['city'] ) ?>">
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e( 'State', 'travelami' ) ?></label>
                                <input type="text" class="form-control" name="state" value="<?php echo esc_attr( $tzbooking_user_info['state'] ) ?>">
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e( 'Postcode', 'travelami' ) ?></label>
                                <input type="text" class="form-control" name="zip" value="<?php echo esc_attr( $tzbooking_user_info['zip'] ) ?>">
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e( 'Email Address', 'travelami' ) ?></label>
                                <input type="text" class="form-control" name="email" value="<?php echo esc_attr( $tzbooking_email != '' ? $tzbooking_email : $tzbooking_user_info['email'] ) ?>">
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e( 'Phone', 'travelami' ) ?></label>
                                <input type="text" class="form-control" name="phone" value="<?php echo esc_attr( $tzbooking_phone != '' ? $tzbooking_phone : $tzbooking_user_info['phone'] ) ?>">
                            </div>
                            <div class="form-group">
                                <label><?php esc_html_e( 'Order Notes', 'travelami' ) ?></label>
                                <textarea class="form-control" name="order_notes" placeholder="<?php echo esc_attr( $tzbooking_user_info['order_notes'] ) ?>"></textarea>
                            </div>
                        </div><!--End step -->
                    </div>
                    <div class="tz-checkout-right uk-width-1-3">
                        <div class="tz-checkout-right-inner" data-uk-sticky="end: .tz-product-checkout; offset:100">
                            <div class="item tz_order">
                                <div class="form_title">
                                    <h3><?php esc_html_e( 'Your Order', 'travelami' ) ?></h3>
                                </div>
                                <div class="box">
                                    <div class="box-item info uk-flex uk-flex-between uk-flex-middle">
                                        <div class="tz-checkout-product-info">
                                            <p><?php echo esc_html( get_the_title( $tzbooking_product_id ) ); ?></p>
                                            <?php if($tzbooking_date != ''){ ?>
                                                <p><?php echo esc_html__('Booking Date: ','travelami').esc_html( $tzbooking_date ); ?></p>
                                            <?php }?>
                                            
                                            <?php if ($vacation_selected || $transport_selected || $others_selected): ?>
                                                <div class="extra-options">
                                                    <p><strong><?php esc_html_e('Extra Options:', 'travelami'); ?></strong></p>
                                                    <?php if ($vacation_selected): ?>
                                                        <p>- <?php esc_html_e('Vacation Package', 'travelami'); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($transport_selected): ?>
                                                        <p>- <?php esc_html_e('Transport Service', 'travelami'); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($others_selected): ?>
                                                        <p>- <?php esc_html_e('Other Services', 'travelami'); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="price">
                                            <?php echo esc_html(tzbooking_price($tzbooking_total_price)); ?>
                                            <?php if ($tzbooking_total_extras > 0): ?>
                                                <div class="extras-breakdown">
                                                    <?php if ($vacation_selected): ?>
                                                        <p class="extra-price"><?php echo esc_html__('Vacation: ', 'travelami') . esc_html(tzbooking_price($vacation_price)); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($transport_selected): ?>
                                                        <p class="extra-price"><?php echo esc_html__('Transport: ', 'travelami') . esc_html(tzbooking_price($transport_price)); ?></p>
                                                    <?php endif; ?>
                                                    <?php if ($others_selected): ?>
                                                        <p class="extra-price"><?php echo esc_html__('Others: ', 'travelami') . esc_html(tzbooking_price($others_price)); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="box-item total uk-flex uk-flex-between">
                                        <span class="title"><?php esc_html_e('Total ','travelami'); ?></span>
                                        <span class="price"><?php echo esc_html(tzbooking_price($tzbooking_total)); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if( ! empty( $ap_product_payment_cash ) || ! empty( $ap_product_payment_paypal ) || ! empty( $ap_product_payment_paypal_card ) ):
                                ?>
                                <div class="item tz_payment">
                                    <div class="form_title">
                                        <h3><?php esc_html_e( 'Payment Method', 'travelami' ) ?></h3>
                                    </div>
                                    <div class="tz_paypal">

                                        <?php if ( ! empty( $ap_product_payment_cash ) ) : ?>
                                            <div class="form-group">
                                                <input class="form-radio-control" type="radio" name="payment_info" id="cash_payment" value="cash" checked="checked">
                                                <label for="paypal_payment"><?php esc_html_e( 'Cash', 'travelami' ) ?></label>
                                            </div>
                                        <?php endif; ?>
                                        <?php
                                        if ( ! empty( $ap_product_payment_paypal ) ) :
                                            ?>
                                            <div class="form-group">
                                                <input class="form-radio-control" type="radio" name="payment_info" id="paypal_payment" value="paypal">
                                                <label for="paypal_payment"><?php esc_html_e( 'Paypal', 'travelami' ) ?></label>
                                            </div>
                                            <div id="paypal-container">
                                                <img src="<?php echo esc_url( get_template_directory_uri() .'/booking/assets/images/paypal_mastercard_maestro.png'); ?>" alt="<?php esc_html_e('PayPal Acceptance Mark','travelami'); ?>" width="319" height="110"/>
                                                <a href="<?php echo esc_url('https://www.paypal.com/us/webapps/mpp/paypal-popup') ?>" class="about_paypal" target="_blank" title="What is PayPal?"><?php esc_html_e( 'What is PayPal?', 'travelami' ) ?></a>
                                                <p class="paypal_desc"><?php esc_html_e( 'Pay via PayPal; you can pay with your credit card if you don\'t have a PayPal account.', 'travelami' ) ?></p>
                                            </div>
                                        <?php endif;?>
                                        <?php
                                        if ( ! empty( $ap_product_payment_paypal_card ) ) :
                                            ?>

                                            <div class="form-group">
                                                <input class="form-radio-control" type="radio" name="payment_info" id="cc_payment" value="cc">
                                                <label for="cc_payment"><?php echo esc_html__( 'Credit Card', 'travelami' ) ?></label>
                                            </div>

                                            <?php $billing_credircard = isset($_REQUEST['billing_credircard'])? esc_attr($_REQUEST['billing_credircard']) : ''; ?>
                                            <!-- Credit Card Payment -->
                                            <div id="cc-container">
                                                <div class="form-group">
                                                    <label><?php echo esc_html__( 'Card Number', 'travelami' ) ?></label>
                                                    <input class="form-control" type="text" size="19" maxlength="19" name="billing_credircard" value="<?php echo $billing_credircard; ?>" />
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo esc_html__( 'Card Type', 'travelami' ) ?></label>
                                                    <select name="billing_cardtype" class="form-control">
                                                        <option value="Visa" selected="selected">Visa</option>
                                                        <option value="MasterCard">MasterCard</option>
                                                        <option value="Discover">Discover</option>
                                                        <option value="Amex">American Express</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo esc_html__( 'Expiration Date', 'travelami' ) ?></label>
                                                    <div class="uk-flex uk-flex-between">
                                                        <div class="uk-width-1-2">
                                                            <select name="billing_expdatemonth" class="form-control">
                                                                <option value=1>01</option>
                                                                <option value=2>02</option>
                                                                <option value=3>03</option>
                                                                <option value=4>04</option>
                                                                <option value=5>05</option>
                                                                <option value=6>06</option>
                                                                <option value=7>07</option>
                                                                <option value=8>08</option>
                                                                <option value=9>09</option>
                                                                <option value=10>10</option>
                                                                <option value=11>11</option>
                                                                <option value=12>12</option>
                                                            </select>
                                                        </div>
                                                        <div class="uk-width-1-2">
                                                            <select name="billing_expdateyear" class="form-control">
                                                                <?php
                                                                $today = (int)date('Y', time());
                                                                for($i = 0; $i < 8; $i++) {
                                                                    ?>
                                                                    <option value="<?php echo $today; ?>"><?php echo $today; ?></option>
                                                                    <?php
                                                                    $today++;
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label><?php echo esc_html__( 'Card Verification Number (CVV)', 'travelami' ) ?></label>
                                                    <input class="form-control" type="text" size="4" maxlength="4" name="billing_ccvnumber" value="" />
                                                </div>
                                            </div>
                                        <?php
                                        endif;
                                        ?>
                                        <!-- End Credit Card Payment -->
                                        <div class="tz-checkout-btn uk-margin-medium-top">
                                            <button type="submit" class="btn_full book-now-btn templaza-btn"><?php echo esc_html__( 'Place Order', 'travelami' ) ?></button>
                                        </div>

                                        <input type="hidden" name="action" value="tzbooking_product_submit_booking">
                                        <input type="hidden" name="order_id" id="order_id" value="0">
                                        <input type="hidden" name="uid" value="<?php echo esc_attr( $tzbooking_uid ) ?>">
                                        <?php wp_nonce_field( 'checkout' ); ?>
                                    </div><!--End step -->
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div><!--End row -->
            </form>
        <?php } ?>
    </div>

<?php }