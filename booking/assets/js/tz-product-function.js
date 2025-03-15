"use strict";

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
                var input = jQuery(this).parent().find('.input-number');
                tzbooking_update_product_price(input);
                // Trigger change event to ensure cart updates
                input.trigger('change');
            });
            els.inc.on('click', function(){
                increment();
                var input = jQuery(this).parent().find('.input-number');
                tzbooking_update_product_price(input);
                // Trigger change event to ensure cart updates
                input.trigger('change');
            });

            function decrement() {
                var value = el[0].value;
                value--;
                if(!min || value >= min) {
                    el.parent().find('.input-number').attr("value", value);
                    el[0].value = value;
                    jQuery ('p.book-message-max').css('display','none');
                }
            }

            function increment() {
                var value = el[0].value;
                value++;
                if(!max || value <= max) {
                    el.parent().find('.input-number').attr("value", value);
                    el[0].value = value;
                }else{
                    jQuery ('p.book-message-max span').html(max);
                    jQuery ('p.book-message-max').css('display','block');
                }
            }
        }
    }
})();

/* check allow people */

function tzbooking_check_allow_select_people(){
    var booking_form = jQuery('.tz-product-booking');
    if ( booking_form.find('input.date-pick').length && booking_form.find('select[name="departure_time"]').length ) {
        var booking_date = booking_form.find('input[name="date"]').val();
        var booking_time = booking_form.find('select[name="departure_time"]').val();

        if(booking_date && booking_time){
            tzbooking_product_check_availability_ajax();
        }else{
            booking_form.find('select[name="price_combo"]').parent().parent().addClass('disabled');
            booking_form.find('input[name="number_adults"]').parent().parent().parent().addClass('disabled');
            booking_form.find('input[name="number_children"]').parent().parent().parent().addClass('disabled');
            booking_form.find('input[name="number_fnr"]').parent().parent().parent().addClass('disabled');
            booking_form.find('p.our-of-stock-message').css('display','none');
            booking_form.find('p.book-message').css('display','none');
            booking_form.find('button.book-now').addClass('disabled');
        }
    }else if( booking_form.find('input.date-pick').length ){
        var booking_date = booking_form.find('input[name="date"]').val();
        if(booking_date){
            tzbooking_product_check_availability_ajax();
        }else{
            booking_form.find('select[name="price_combo"]').parent().parent().addClass('disabled');
            booking_form.find('input[name="number_adults"]').parent().parent().parent().addClass('disabled');
            booking_form.find('input[name="number_children"]').parent().parent().parent().addClass('disabled');
            booking_form.find('input[name="number_fnr"]').parent().parent().parent().addClass('disabled');
            booking_form.find('p.our-of-stock-message').css('display','none');
            booking_form.find('p.book-message').css('display','none');
            booking_form.find('button.book-now').addClass('disabled');
        }
    }else{
        booking_form.find('p.require-date-time-message').css('display','none');
    }
}

function tzbooking_product_check_availability_ajax(){
    var booking_form = jQuery('.tz-product-booking');
    var product_id = booking_form.find('input[name="product_id"]').val();
    var booking_date = booking_form.find('input[name="date"]').val();
    var booking_time = booking_form.find('select[name="departure_time"]').val();

    jQuery.ajax({
        url: tzbooking_ajax.url,
        type: 'POST',
        data: ({
            action: 'tzbooking_product_check_availability_ajax',
            product_id: product_id,
            booking_date: booking_date,
            booking_time: booking_time
        }),
        success: function(response){
            if (response.success == 1) {
                var info_product = response.booked;
                var booking_form = jQuery('.tz-product-booking');
                if(info_product[0] == '1'){
                    booking_form.find('input[name="people_available"]').val(info_product[2]);
                    booking_form.find('select[name="price_combo"]').parent().parent().removeClass('disabled');
                    booking_form.find('input[name="number_adults"]').parent().parent().parent().removeClass('disabled');
                    booking_form.find('input[name="number_children"]').parent().parent().parent().removeClass('disabled');
                    booking_form.find('input[name="number_fnr"]').parent().parent().parent().removeClass('disabled');
                    booking_form.find('p.our-of-stock-message').css('display','none');
                    booking_form.find('p.book-message').css('display','none');
                    booking_form.find('button.book-now').removeClass('disabled');
                }else{
                    booking_form.find('select[name="price_combo"]').parent().parent().addClass('disabled');
                    booking_form.find('input[name="number_adults"]').parent().parent().parent().addClass('disabled');
                    booking_form.find('input[name="number_children"]').parent().parent().parent().addClass('disabled');
                    booking_form.find('input[name="number_fnr"]').parent().parent().parent().addClass('disabled');
                    booking_form.find('p.our-of-stock-message').css('display','block');
                    booking_form.find('p.book-message').css('display','none');
                    booking_form.find('button.book-now').addClass('disabled');
                }

            } else {
                alert(response.message);
            }
        }
    });
}

/*  Get Price Value   */
function tzbooking_update_product_price( obj ) {
    var booking_form    = obj.closest('.tz-product-booking');
    var product_data    = booking_form.find(".tz-booking-data");
    var adults_price    = product_data.data("adults-price");
    var child_price     = product_data.data("child-price");
    var fnr_price       = product_data.data("fnr-price");
    var decimal_prec    = product_data.data("decimal-prec");
    var decimal_sep     = product_data.data("decimal-sep");
    var thousands_sep   = product_data.data("thousands-sep");

    /* Adult Number */
    var adults_number   = 0;
    if ( booking_form.find('input[name="number_adults"]').length ) {
        adults_number   = parseInt( booking_form.find('input[name="number_adults"]').val() ) || 0;
    }

    /* Kids Number */
    var kids_number     = 0;
    if ( booking_form.find('input[name="number_children"]').length ) {
        kids_number = parseInt( booking_form.find('input[name="number_children"]').val() ) || 0;
    }

    /* FNR Number */
    var fnr_number     = 0;
    if ( booking_form.find('input[name="number_fnr"]').length ) {
        fnr_number = parseInt( booking_form.find('input[name="number_fnr"]').val() ) || 0;
    }

    // Remove currency symbol and commas from prices
    adults_price = String(adults_price).replace(/[^0-9.]/g, '');
    child_price = String(child_price).replace(/[^0-9.]/g, '');
    fnr_price = String(fnr_price).replace(/[^0-9.]/g, '');

    // Convert to numbers
    adults_price = parseFloat(adults_price) || 0;
    child_price = parseFloat(child_price) || 0;
    fnr_price = parseFloat(fnr_price) || 0;

    // Calculate totals
    var total_adults_price = adults_price * adults_number;
    var total_child_price = child_price * kids_number;
    var total_fnr_price = fnr_price * fnr_number;
    var total_all_price = total_adults_price + total_child_price + total_fnr_price;

    // Format prices
    total_adults_price = tzbooking_number_format(total_adults_price, decimal_prec, decimal_sep, thousands_sep);
    total_child_price = tzbooking_number_format(total_child_price, decimal_prec, decimal_sep, thousands_sep);
    total_fnr_price = tzbooking_number_format(total_fnr_price, decimal_prec, decimal_sep, thousands_sep);
    total_all_price = tzbooking_number_format(total_all_price, decimal_prec, decimal_sep, thousands_sep);

    // Update display text
    booking_form.find('.total_price_adults').text('Ugx' + total_adults_price);
    booking_form.find('.total_price_children').text('Ugx' + total_child_price);
    booking_form.find('.total_price_fnr').text('Ugx' + total_fnr_price);
    booking_form.find('.total_all_price').text('Ugx' + total_all_price);

    // Update hidden inputs
    booking_form.find('input[name="total_price"]').val(total_all_price);
    booking_form.find('input[name="total_adults"]').val(total_adults_price);
    booking_form.find('input[name="total_kids"]').val(total_child_price);
    booking_form.find('input[name="total_fnr"]').val(total_fnr_price);
}

/*  Number Format   */
function tzbooking_number_format (number, decimals, dec_point, thousands_sep) {
    /* Strip all characters but numerical ones.*/
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    /* Fix for IE parseFloat(0.55).toFixed(0) = 0;*/
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}