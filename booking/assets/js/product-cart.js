"use strict";

jQuery.noConflict();
jQuery(document).ready(function(){

    // Function to update total price
    function updateTotalPrice() {
        // Get quantities
        var adults_number = parseInt(jQuery('input[name="adults"]').val()) || 0;
        var kids_number = parseInt(jQuery('input[name="kids"]').val()) || 0;
        var fnr_number = parseInt(jQuery('input[name="fnr"]').val()) || 0;
        
        // Get raw prices and convert to numbers
        var adults_price = parseFloat(jQuery('input[name="price_adults"]').val().replace(/[^0-9.]/g, '')) || 0;
        var kids_price = parseFloat(jQuery('input[name="price_child"]').val().replace(/[^0-9.]/g, '')) || 0;
        var fnr_price = parseFloat(jQuery('input[name="price_fnr"]').val().replace(/[^0-9.]/g, '')) || 0;
        
        // Get extra options prices
        var vacation_price = parseFloat(jQuery('input[name="extra_vacation_price"]').val() || 0);
        var transport_price = parseFloat(jQuery('input[name="extra_transport_price"]').val() || 0);
        var others_price = parseFloat(jQuery('input[name="extra_others_price"]').val() || 0);
        
        // Check which extras are selected
        var vacation_selected = jQuery('input[name="extra_vacation_selected"]').length > 0;
        var transport_selected = jQuery('input[name="extra_transport_selected"]').length > 0;
        var others_selected = jQuery('input[name="extra_others_selected"]').length > 0;
        
        console.log('Cart Calculation:', {
            'Raw Prices': { adults_price, kids_price, fnr_price },
            'Extra Prices': { vacation_price, transport_price, others_price },
            'Quantities': { adults_number, kids_number, fnr_number },
            'Selected Extras': { vacation_selected, transport_selected, others_selected }
        });
        
        // Calculate raw totals
        var total_adults = adults_price * adults_number;
        var total_kids = kids_price * kids_number;
        var total_fnr = fnr_price * fnr_number;
        
        // Add selected extras
        var total_extras = 0;
        if (vacation_selected) total_extras += vacation_price;
        if (transport_selected) total_extras += transport_price;
        if (others_selected) total_extras += others_price;
        
        var total_price = total_adults + total_kids + total_fnr + total_extras;
        
        console.log('Cart Totals:', {
            total_adults,
            total_kids,
            total_fnr,
            total_extras,
            total_price
        });
        
        // Update hidden inputs with raw values
        jQuery('input[name="total_adults"]').val(total_adults);
        jQuery('input[name="total_kids"]').val(total_kids);
        jQuery('input[name="total_fnr"]').val(total_fnr);
        jQuery('input[name="total_extras"]').val(total_extras);
        jQuery('input[name="total_price"]').val(total_price);
        
        // Update displayed totals using the theme's price formatter
        jQuery('.total strong').text(tzbooking_price(total_price));
        jQuery('p strong').text(tzbooking_price(total_price));
    }

    jQuery('#product-cart input').change(function(){
        jQuery('.update-cart-btn').removeClass('tz-btn-hide');
        jQuery('.delete-cart-btn').addClass('tz-btn-hide');
        updateTotalPrice();
    });

    jQuery('#product-cart select').change(function(){
        var name_combo      = jQuery(this).find(":selected").text();
        var people_combo    = jQuery(this).find(":selected").data("people-combo");
        var price_combo     = jQuery(this).find(":selected").val();

        if( price_combo != 'custom' ){
            jQuery(".cart_has_combo").css("opacity",0);
        }else{
            jQuery(".cart_has_combo").css("opacity",1);
        }
        // jQuery(this).closest('#product-cart').find('.change_name_combo').text(name_combo);
        jQuery(this).closest('#product-cart').find('input[name="name_combo"]').val(name_combo);
        jQuery(this).closest('#product-cart').find('input[name="people_combo"]').val(people_combo);
        jQuery(this).closest('#product-cart').find('input[name="price_combo"]').val(price_combo);
        jQuery('.update-cart-btn').removeClass('tz-btn-hide');
        jQuery('.delete-cart-btn').addClass('tz-btn-hide');

        tzbooking_check_product_available_people_cart();
    });

    jQuery('.update-cart-btn').on("click", function(e){
        e.preventDefault();
        jQuery('input[name="action"]').val('tzbooking_product_update_cart');
        jQuery.ajax({
            url: tzbooking_ajax.url,
            type: "POST",
            data: jQuery('#product-cart').serialize(),
            success: function(response){
                if (response.success == 1) {
                    location.reload();
                    console.log(response.uid);
                } else {
                    alert(response.message);
                }
            }
        });
        jQuery('.delete-cart-btn').removeClass('tz-btn-hide');
        jQuery('.update-cart-btn').addClass('tz-btn-hide');
        return false;
    });

    jQuery('.delete-cart-btn').on("click", function(e){
        e.preventDefault();
        jQuery('input[name="action"]').val('tzbooking_product_delete_cart');
        jQuery.ajax({
            url: tzbooking_ajax.url,
            type: "POST",
            data: jQuery('#product-cart').serialize(),
            success: function(response){
                if (response.success == 1) {
                    window.location.href = jQuery('input[name="cart_delete"]').val();
                } else {
                    alert(response.message);
                }
            }
        });
    });
    jQuery('.book-now-btn').on("click", function(e){
        e.preventDefault();
        document.location.href=jQuery("#product-cart").attr('action');
    });

    jQuery('.input-number').each(function(){
        inputNumber(jQuery(this));
    });
});

/*
 * Change Input number Value
 */
(function() {

    window.inputNumber = function(el) {

        var min = el.data('min') || '0';
        var max = el.data('max') || '999999999';

        var els = {};

        /*els.dec = el.prev();*/
        /*els.inc = el.next();*/
        els.dec = el.parent().find('.input-number-decrement');
        els.inc = el.parent().find('.input-number-increment');

        el.each(function() {
            init(jQuery(this));
        });

        function init(el) {

            els.dec.on('click', function(){
                decrement();
                tzbooking_check_product_available_people_cart();
                jQuery('.update-cart-btn').removeClass('tz-btn-hide');
                jQuery('.delete-cart-btn').addClass('tz-btn-hide');
            });
            els.inc.on('click', function(){
                increment();
                tzbooking_check_product_available_people_cart();
                jQuery('.update-cart-btn').removeClass('tz-btn-hide');
                jQuery('.delete-cart-btn').addClass('tz-btn-hide');
            });

            function decrement() {
                var value = el[0].value;
                value--;
                if(!min || value >= min) {
                    el[0].value = value;
                    jQuery ('p.book-message-max').css('display','none');
                }
            }

            function increment() {
                var value = el[0].value;
                value++;
                if(!max || value <= max) {
                    el[0].value = value++;
                }else{
                    jQuery ('p.book-message-max span').html(max);
                    jQuery ('p.book-message-max').css('display','block');
                }
            }
        }
    }
})();

/* check tour available people */

function tzbooking_check_product_available_people_cart(){
    var booking_form    = jQuery('.tz-product-cart');
    var combo_option = '';
    if(booking_form.find("#select_combo").length){
        var combo_option    = booking_form.find("#select_combo option:selected").val();
        var peole_combo     = booking_form.find("#select_combo option:selected").data("people-combo");
    }

    /* Adult Number */
    var adults_number   = parseInt(booking_form.find('input[name="adults"]').val()) || 0;

    /* Kids Number */
    var kids_number     = parseInt(booking_form.find('input[name="kids"]').val()) || 0;

    /* FNR Number */
    var fnr_number     = parseInt(booking_form.find('input[name="fnr"]').val()) || 0;

    var people_available = parseInt(booking_form.find('input[name="people_available"]').val()) || 0;

    if(combo_option !== 'custom'){
        if(people_available !== '' && people_available < peole_combo){
            booking_form.find('.book-number-available').html(people_available);
            booking_form.find('p.book-message').css('display','block');
            booking_form.find('.book-now-btn').addClass('tz-btn-disable');
            booking_form.find('.delete-cart-btn').addClass('tz-btn-disable');
            booking_form.find('.update-cart-btn').addClass('tz-btn-disable');
        }else{
            booking_form.find('p.book-message').css('display','none');
            booking_form.find('.book-now-btn').removeClass('tz-btn-disable');
            booking_form.find('.delete-cart-btn').removeClass('tz-btn-disable');
            booking_form.find('.update-cart-btn').removeClass('tz-btn-disable');
        }
    }else{
        if(people_available !== '' && people_available < (adults_number + kids_number + fnr_number)){
            booking_form.find('.book-number-available').html(people_available);
            booking_form.find('p.book-message').css('display','block');
            booking_form.find('.book-now-btn').addClass('tz-btn-disable');
            booking_form.find('.delete-cart-btn').addClass('tz-btn-disable');
            booking_form.find('.update-cart-btn').addClass('tz-btn-disable');
        }else{
            booking_form.find('p.book-message').css('display','none');
            booking_form.find('.book-now-btn').removeClass('tz-btn-disable');
            booking_form.find('.delete-cart-btn').removeClass('tz-btn-disable');
            booking_form.find('.update-cart-btn').removeClass('tz-btn-disable');
        }
    }
    
    // Update total price whenever quantities change
    updateTotalPrice();
}