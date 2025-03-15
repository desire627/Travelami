"use strict";

var product_data = jQuery(".tz-booking-data");

jQuery(document).ready(function () {
    jQuery('#booking-form').on('change', 'input[name="number_adults"], input[name="number_children"], input[name="number_fnr"]', function () {
        tzbooking_update_product_price(jQuery(this));
    });

    jQuery('.date_picker').datepicker({
        dateFormat : 'mm/dd/yy'
    });
    var validation_rules = {};
    jQuery('#booking-form').validate();
});
jQuery(window).load(function () {
    jQuery('.input-number').each(function () {
        inputNumber(jQuery(this));
    });
});