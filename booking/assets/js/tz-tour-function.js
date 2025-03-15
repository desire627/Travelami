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

        function updateValue(el, newValue) {
            if (newValue >= min && (!max || newValue <= max)) {
                el.val(newValue);
                el.trigger('change');
            }
        }

        el.each(function() {
            var $input = jQuery(this);
            
            // Handle manual input
            $input.on('input', function() {
                var value = parseInt($input.val()) || 0;
                updateValue($input, value);
            });

            // Handle increment
            els.inc.on('click', function(e) {
                e.preventDefault();
                var value = parseInt($input.val()) || 0;
                updateValue($input, value + 1);
            });

            // Handle decrement
            els.dec.on('click', function(e) {
                e.preventDefault();
                var value = parseInt($input.val()) || 0;
                updateValue($input, value - 1);
            });
        });
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
    }else if( booking_form.find('select[name="departure_time"]').length ){
        var booking_time = booking_form.find('select[name="departure_time"]').val();
        if(booking_time){
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
function tzbooking_update_product_price(obj) {
    var booking_form = obj.closest('.tz-product-booking');
    var tour_data = booking_form.find(".tz-booking-data");

    // Get raw prices as floats
    var adults_price = parseFloat(tour_data.data("adults-price")) || 0;
    var child_price = parseFloat(tour_data.data("child-price")) || 0;
    var fnr_price = parseFloat(tour_data.data("fnr-price")) || 0;
    
    // Get extra options prices
    var vacation_price = parseFloat(tour_data.data("vacation-price")) || 0;
    var transport_price = parseFloat(tour_data.data("transport-price")) || 0;
    var others_price = parseFloat(tour_data.data("others-price")) || 0;

    // Get quantities
    var adults_number = parseInt(booking_form.find('input[name="number_adults"]').val()) || 0;
    var kids_number = parseInt(booking_form.find('input[name="number_children"]').val()) || 0;
    var fnr_number = parseInt(booking_form.find('input[name="number_fnr"]').val()) || 0;

    // Check which extras are selected
    var vacation_selected = booking_form.find('input[name="extra_vacation"]').is(':checked');
    var transport_selected = booking_form.find('input[name="extra_transport"]').is(':checked');
    var others_selected = booking_form.find('input[name="extra_others"]').is(':checked');

    // Calculate raw totals
    var total_adults_price = adults_price * adults_number;
    var total_child_price = child_price * kids_number;
    var total_fnr_price = fnr_price * fnr_number;
    
    // Add selected extras
    var total_extras = 0;
    if (vacation_selected) total_extras += vacation_price;
    if (transport_selected) total_extras += transport_price;
    if (others_selected) total_extras += others_price;
    
    var total_all_price = total_adults_price + total_child_price + total_fnr_price + total_extras;

    // Get formatting options
    var currency_symbol = tour_data.data("currency-symbol") || 'Ugx';
    var decimal_prec = parseInt(tour_data.data("decimal-prec")) || 0;
    var decimal_sep = tour_data.data("decimal-sep") || '.';
    var thousands_sep = tour_data.data("thousands-sep") || ',';

    // Format individual prices for display
    var formatted_adults = tzbooking_number_format(total_adults_price, decimal_prec, decimal_sep, thousands_sep);
    var formatted_child = tzbooking_number_format(total_child_price, decimal_prec, decimal_sep, thousands_sep);
    var formatted_fnr = tzbooking_number_format(total_fnr_price, decimal_prec, decimal_sep, thousands_sep);
    var formatted_extras = tzbooking_number_format(total_extras, decimal_prec, decimal_sep, thousands_sep);
    var formatted_total = tzbooking_number_format(total_all_price, decimal_prec, decimal_sep, thousands_sep);

    console.log('Price Calculation:', {
        'Raw Prices': { adults_price, child_price, fnr_price, vacation_price, transport_price, others_price },
        'Quantities': { adults_number, kids_number, fnr_number },
        'Extras Selected': { vacation_selected, transport_selected, others_selected },
        'Raw Totals': { total_adults_price, total_child_price, total_fnr_price, total_extras, total_all_price },
        'Formatted': { formatted_adults, formatted_child, formatted_fnr, formatted_extras, formatted_total }
    });

    // Update display text
    if(adults_price > 0) {
        booking_form.find('.total_price_adults').text('= ' + currency_symbol + formatted_adults);
    }
    if(child_price > 0) {
        booking_form.find('.total_price_children').text('= ' + currency_symbol + formatted_child);
    }
    if(fnr_price > 0) {
        booking_form.find('.total_price_fnr').text('= ' + currency_symbol + formatted_fnr);
    }
    booking_form.find('.total_all_price').text(currency_symbol + formatted_total);

    // Store raw values in hidden inputs
    booking_form.find('input[name="total_price"]').val(total_all_price);
    booking_form.find('input[name="total_adults"]').val(total_adults_price);
    booking_form.find('input[name="total_kids"]').val(total_child_price);
    booking_form.find('input[name="total_fnr"]').val(total_fnr_price);
    booking_form.find('input[name="total_extras"]').val(total_extras);

    // Add hidden inputs for selected extras to pass to cart
    var extraInputs = booking_form.find('.extra-options-hidden-inputs');
    if (extraInputs.length === 0) {
        extraInputs = jQuery('<div class="extra-options-hidden-inputs"></div>');
        booking_form.append(extraInputs);
    }
    extraInputs.empty();

    if (vacation_selected) {
        extraInputs.append('<input type="hidden" name="extra_vacation_selected" value="1">');
        extraInputs.append('<input type="hidden" name="extra_vacation_price" value="' + vacation_price + '">');
    }
    if (transport_selected) {
        extraInputs.append('<input type="hidden" name="extra_transport_selected" value="1">');
        extraInputs.append('<input type="hidden" name="extra_transport_price" value="' + transport_price + '">');
    }
    if (others_selected) {
        extraInputs.append('<input type="hidden" name="extra_others_selected" value="1">');
        extraInputs.append('<input type="hidden" name="extra_others_price" value="' + others_price + '">');
    }
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

// Add event listeners for all inputs that affect price
jQuery(document).ready(function() {
    var booking_form = jQuery('.tz-product-booking');
    
    // Listen for changes on number inputs
    booking_form.find('input[name="number_adults"], input[name="number_children"], input[name="number_fnr"]').on('change', function() {
        tzbooking_update_product_price(jQuery(this));
    });

    // Listen for changes on extra option checkboxes
    booking_form.find('.extra-checkbox').on('change', function() {
        tzbooking_update_product_price(jQuery(this));
    });

    // Initialize price calculation
    tzbooking_update_product_price(booking_form);
});