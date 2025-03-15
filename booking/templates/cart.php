<?php
/* validation   */
global $tzbooking_options;
$tzbooking_required_params = array( 'product_id' );
$tzbooking_cart_check = false;
foreach ( $tzbooking_required_params as $param ) {
    if ( isset( $_REQUEST[ $param ] ) ) {
        $tzbooking_cart_check = true;
    }
}
echo '<div class="tz-product-cart">';

if($tzbooking_cart_check == false){
    echo '<h5 class="alert alert-warning">'.esc_html__( 'Your cart is currently empty.', 'travelami' ).'</h5>';
}else{
    /* init variables */
    $tzbooking_product_id            = $_REQUEST['product_id'];
    $tzbooking_people_available   = ( isset( $_REQUEST['people_available'] ) ) ? $_REQUEST['people_available'] : '';
    $tzbooking_first_name         = ( isset( $_REQUEST['first_name'] ) ) ? $_REQUEST['first_name'] : '';
    $tzbooking_last_name          = ( isset( $_REQUEST['last_name'] ) ) ? $_REQUEST['last_name'] : '';
    $tzbooking_email              = ( isset( $_REQUEST['your_email'] ) ) ? $_REQUEST['your_email'] : '';
    $tzbooking_phone              = ( isset( $_REQUEST['your_phone'] ) ) ? $_REQUEST['your_phone'] : '';
    $tzbooking_time               = ( isset( $_REQUEST['departure_time'] ) ) ? $_REQUEST['departure_time'] : '';
    $tzbooking_price_adults       = ( isset( $_REQUEST['price_adults'] ) ) ? $_REQUEST['price_adults'] : 0;
    $tzbooking_price_child        = ( isset( $_REQUEST['price_child'] ) ) ? $_REQUEST['price_child'] : 0;
    $tzbooking_product_type = 'daily';
    $tzbooking_booking_date          =  get_post_meta( $tzbooking_product_id, 'tzbooking_departure_date', true );

    $tzbooking_date = $_REQUEST['date'];

    $tzbooking_uid = $tzbooking_product_id . str_replace( array('/') , '', $tzbooking_date )  . str_replace( array(':') , '', $tzbooking_time );

    if ( $tzbooking_product_data = TZbooking_Session_Cart::tzbooking_get( $tzbooking_uid ) ) {
        /*  Number  */
        $tzbooking_adults         = $tzbooking_product_data['adults'];
        $tzbooking_kids           = $tzbooking_product_data['kids'];
        $tzbooking_fnr            = $tzbooking_product_data['fnr'];
        /*  Price  */
        if(isset($tzbooking_product_data['price_adults'])){
            $tzbooking_price_adults   = $tzbooking_product_data['price_adults'];
        }
        if(isset($tzbooking_product_data['price_child'])){
            $tzbooking_price_kids     = $tzbooking_product_data['price_child'];
        }
        if(isset($tzbooking_product_data['price_fnr'])){
            $tzbooking_price_fnr      = $tzbooking_product_data['price_fnr'];
        }
        /*  Total  */
        $tzbooking_total_price    = $tzbooking_product_data['total_price'];
        $tzbooking_total_adults   = $tzbooking_product_data['total_adults'];
        $tzbooking_total_kids     = $tzbooking_product_data['total_kids'];
        $tzbooking_total_fnr      = $tzbooking_product_data['total_fnr'];
        $tzbooking_total_extras   = $tzbooking_product_data['total_extras'];
        
        // Get extra options data
        $vacation_selected = isset($tzbooking_product_data['extra_vacation_selected']) ? $tzbooking_product_data['extra_vacation_selected'] : 0;
        $transport_selected = isset($tzbooking_product_data['extra_transport_selected']) ? $tzbooking_product_data['extra_transport_selected'] : 0;
        $others_selected = isset($tzbooking_product_data['extra_others_selected']) ? $tzbooking_product_data['extra_others_selected'] : 0;
        
        $vacation_price = isset($tzbooking_product_data['extra_vacation_price']) ? $tzbooking_product_data['extra_vacation_price'] : 0;
        $transport_price = isset($tzbooking_product_data['extra_transport_price']) ? $tzbooking_product_data['extra_transport_price'] : 0;
        $others_price = isset($tzbooking_product_data['extra_others_price']) ? $tzbooking_product_data['extra_others_price'] : 0;
    } else {
        /*  Number  */
        $tzbooking_adults         = ( isset( $_REQUEST['number_adults'] ) ) ? $_REQUEST['number_adults'] : 0;
        $tzbooking_kids           = ( isset( $_REQUEST['number_children'] ) ) ? $_REQUEST['number_children'] : 0;
        $tzbooking_fnr            = ( isset( $_REQUEST['number_fnr'] ) ) ? $_REQUEST['number_fnr'] : 0;

        /*  Price  */
        $tzbooking_price_adults   = ( isset( $_REQUEST['price_adults'] ) ) ? $_REQUEST['price_adults'] : 0;
        $tzbooking_price_kids     = ( isset( $_REQUEST['price_child'] ) ) ? $_REQUEST['price_child'] : 0;
        $tzbooking_price_fnr      = ( isset( $_REQUEST['price_fnr'] ) ) ? $_REQUEST['price_fnr'] : 0;
        /*  Total  */
        $tzbooking_total_price    = tzbooking_product_calc_product_price( $tzbooking_product_id, $tzbooking_date, $tzbooking_adults, $tzbooking_kids, $tzbooking_fnr );

        $tzbooking_total_adults   = $tzbooking_price_adults*$tzbooking_adults;
        $tzbooking_total_kids     = $tzbooking_price_kids*$tzbooking_kids;
        $tzbooking_total_fnr      = $tzbooking_price_fnr*$tzbooking_fnr;

        $tzbooking_product_data      = array(
            'adults'        => $tzbooking_adults,
            'kids'          => $tzbooking_kids,
            'fnr'           => $tzbooking_fnr,
            'name_combo'    => '',
            'people_combo'  => '',
            'price_combo'   => '',
            'price_adults'  => $tzbooking_price_adults,
            'price_child'   => $tzbooking_price_kids,
            'price_fnr'     => $tzbooking_price_fnr,
            'total_price'   => $tzbooking_total_price,
            'total_adults'  => $tzbooking_total_adults,
            'total_kids'    => $tzbooking_total_kids,
            'total_fnr'     => $tzbooking_total_fnr,
            'product_id'       => $tzbooking_product_id,
            'date'          => $tzbooking_date,
            'time'          => $tzbooking_time,
            'first_name'    => $tzbooking_first_name,
            'last_name'     => $tzbooking_last_name,
            'email'         => $tzbooking_email,
            'phone'         => $tzbooking_phone,
        );

        TZbooking_Session_Cart::tzbooking_set( $tzbooking_uid, $tzbooking_product_data );
    }

    $tzbooking_cart   = new TZbooking_Session_Cart();
    $tzbooking_product_checkout_page_url = tzbooking_get_product_checkout_page();
    /*  main function    */
    if ( ! $tzbooking_product_checkout_page_url ) { ?>
        <h5 class="alert alert-warning"><?php echo esc_html__( 'Please set checkout page in theme options panel.', 'travelami' ) ?></h5>
        <?php
    } else {
        $tzbooking_max_adults        = 10000;
        $tzbooking_max_kids          = 10000;
        $tzbooking_max_warning       ='';

        if($tzbooking_max_adults==''){
            $tzbooking_max_adults = 99999999;
        }
        if($tzbooking_max_kids==''){
            $tzbooking_max_kids = 99999999;
        }
        ?>

        <form id="product-cart" action="<?php echo esc_url( add_query_arg( array('uid'=> $tzbooking_uid), $tzbooking_product_checkout_page_url ) ); ?>">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">

                    <table class="table table-striped cart-list tour add_bottom_30">
                        <thead><tr>
                            <th><?php echo esc_html__( 'Tour', 'travelami' ) ?></th>
                            <th class=""><?php echo esc_html__( 'Adults', 'travelami' ) ?></th>
                            <th class=""><?php echo esc_html__( 'Children', 'travelami' ) ?></th>
                            <th class=""><?php echo esc_html__( 'FNR', 'travelami' ) ?></th>
                            <th><?php echo esc_html__( 'Date', 'travelami' ) ?></th>
                            <th><?php echo esc_html__( 'Total', 'travelami' ) ?></th>
                        </tr></thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="item_cart">
                                    <p data-toggle="modal" data-target="#product-<?php echo esc_attr( $tzbooking_product_id ) ?>">
                                        <?php echo esc_html( get_the_title( $tzbooking_product_id ) ); ?>
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="input-number-ticket uk-position-relative">
                                    <input class="input-number qty2 form-control product-adults" name="adults" type="text" value="<?php echo esc_attr( $tzbooking_adults ); ?>" data-min="0" data-max="<?php echo esc_attr($tzbooking_max_adults); ?>" readonly="true"/>
                                    <span class="input-number-decrement"><i class="fas fa-caret-down"></i></span><span class="input-number-increment"><i class="fas fa-caret-up"></i></span>
                                </div>
                            </td>
                            <td>
                                <div class="input-number-ticket uk-position-relative">
                                    <input class="input-number qty2 form-control product-kids" name="kids" type="text" value="<?php echo esc_attr( $tzbooking_kids ); ?>" data-min="0" data-max="<?php echo esc_attr($tzbooking_max_kids); ?>" readonly="true"/>
                                    <span class="input-number-decrement"><i class="fas fa-caret-down"></i></span><span class="input-number-increment"><i class="fas fa-caret-up"></i></span>
                                </div>
                            </td>
                            <td>
                                <div class="input-number-ticket uk-position-relative">
                                    <input class="input-number qty2 form-control product-fnr" name="fnr" type="text" value="<?php echo esc_attr( $tzbooking_fnr ); ?>" data-min="0" data-max="10000" readonly="true"/>
                                    <span class="input-number-decrement"><i class="fas fa-caret-down"></i></span><span class="input-number-increment"><i class="fas fa-caret-up"></i></span>
                                </div>
                            </td>
                            <td>
                                <div class="item_cart">
                                    <p>
                                        <?php echo date_i18n( 'j F Y', strtotime( $tzbooking_date ) ); ?>
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="item_cart">
                                    <p>
                                        <strong>
                                            <?php if ( ! empty( $tzbooking_total_price ) ) echo tzbooking_price($tzbooking_total_price);?>
                                        </strong>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p><strong><?php echo esc_html__( 'Subtotal', 'travelami' ) ?></strong></p>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <p><strong><?php if ( ! empty( $tzbooking_total_price ) ) echo tzbooking_price($tzbooking_total_price);?></strong></p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <strong><?php echo esc_html__( 'Extra Options', 'travelami' ) ?></strong>
                            </th>
                            <td colspan="4"></td>
                            <td>
                                <?php if ($vacation_selected): ?>
                                    <p>Vacation Package: <?php echo tzbooking_price($vacation_price); ?></p>
                                <?php endif; ?>
                                <?php if ($transport_selected): ?>
                                    <p>Transport Service: <?php echo tzbooking_price($transport_price); ?></p>
                                <?php endif; ?>
                                <?php if ($others_selected): ?>
                                    <p>Other Services: <?php echo tzbooking_price($others_price); ?></p>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <strong><?php echo esc_html__( 'Total', 'travelami' ) ?></strong>
                            </th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <p class="total">
                                    <strong>
                                        <?php
                                        $tzbooking_total = $tzbooking_total_price;
                                        if ( ! empty( $tzbooking_total ) ):
                                            echo tzbooking_price($tzbooking_total);
                                        endif;
                                        ?>
                                    </strong>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="actions uk-flex uk-flex-between uk-margin-medium-top">
                        <div class="cart-action-left">
                            <a class="btn_full delete-cart-btn" href="#"><?php echo esc_html__( 'Delete Cart', 'travelami' ) ?></a>
                        </div>
                        <div class="cart-action-right">
                            <a class="btn_full update-cart-btn tz-btn-hide templaza-btn" href="#"><?php echo esc_html__( 'Update Cart', 'travelami' ) ?></a>
                            <a class="btn_full book-now-btn templaza-btn" href="#"><?php echo esc_html__( 'Proceed To Checkout', 'travelami' ) ?></a>
                        </div>
                    </div>
                    <input type="hidden" name="action"      value="tzbooking_product_book">
                    <input type="hidden" name="product_id"     value="<?php echo esc_attr( $tzbooking_product_id ) ?>">
                    <?php if($tzbooking_people_available != ''){?>
                        <input type="hidden" name="people_available" value="<?php echo $tzbooking_people_available;?>">
                    <?php } ?>
                    <input type="hidden" name="date"        value="<?php echo esc_attr( $tzbooking_date ) ?>">
                    <input type="hidden" name="time"        value="<?php echo esc_attr( $tzbooking_time ) ?>">
                    <input type="hidden" name="first_name"  value="<?php echo esc_attr( $tzbooking_first_name ) ?>">
                    <input type="hidden" name="last_name"   value="<?php echo esc_attr( $tzbooking_last_name ) ?>">
                    <input type="hidden" name="your_email"  value="<?php echo esc_attr( $tzbooking_email ) ?>">
                    <input type="hidden" name="your_phone"  value="<?php echo esc_attr( $tzbooking_phone ) ?>">
                    <input type="hidden" name="name_combo"  value="">
                    <input type="hidden" name="people_combo"  value="">
                    <input type="hidden" name="price_combo" value="">
                    <input type="hidden" name="price_adults" value="<?php echo esc_attr( $tzbooking_price_adults ) ?>">
                    <input type="hidden" name="price_child" value="<?php echo esc_attr( $tzbooking_price_child ) ?>">
                    <input type="hidden" name="price_fnr" value="<?php echo esc_attr( $tzbooking_price_fnr ) ?>">
                    <input type="hidden" name="total_price" value="<?php echo esc_attr( $tzbooking_total_price ) ?>">
                    <input type="hidden" name="total_adults" value="<?php echo esc_attr( $tzbooking_total_adults ) ?>">
                    <input type="hidden" name="total_kids"  value="<?php echo esc_attr( $tzbooking_total_kids ) ?>">
                    <input type="hidden" name="total_fnr"  value="<?php echo esc_attr( $tzbooking_total_fnr ) ?>">
                    <input type="hidden" name="total_extras" value="<?php echo esc_attr( $tzbooking_total_extras ) ?>">
                    <?php if ($vacation_selected): ?>
                        <input type="hidden" name="extra_vacation_selected" value="1">
                        <input type="hidden" name="extra_vacation_price" value="<?php echo esc_attr($vacation_price); ?>">
                    <?php endif; ?>
                    <?php if ($transport_selected): ?>
                        <input type="hidden" name="extra_transport_selected" value="1">
                        <input type="hidden" name="extra_transport_price" value="<?php echo esc_attr($transport_price); ?>">
                    <?php endif; ?>
                    <?php if ($others_selected): ?>
                        <input type="hidden" name="extra_others_selected" value="1">
                        <input type="hidden" name="extra_others_price" value="<?php echo esc_attr($others_price); ?>">
                    <?php endif; ?>
                    <input type="hidden" name="cart_delete"  value="<?php echo esc_attr( tzbooking_get_product_cart_page() ); ?>">
                    <?php wp_nonce_field( 'product_update_cart' ); ?>
                </div>
            </div><!--End row -->
        </form>

        <?php
    }
}

echo '</div>';
?>