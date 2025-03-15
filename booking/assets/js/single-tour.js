"use strict";

var tour_data = jQuery(".tz-booking-data");

jQuery(document).ready(function () {
    // Handle direct input changes
    jQuery('#booking-form').on('change', 'input[name="number_adults"], input[name="number_children"], input[name="number_fnr"]', function () {
        tzbooking_update_product_price(jQuery(this));
    });

    jQuery('.date_picker').datepicker({
        dateFormat : 'mm/dd/yy'
    });

    var validation_rules = {};
    jQuery('#booking-form').validate({
        rules: validation_rules
    });
});

// Initialize number inputs on page load
jQuery(window).load(function () {
    jQuery('.input-number').each(function () {
        var $this = jQuery(this);
        if(!$this.val()) {
            $this.val(0);
        }
        inputNumber($this);
        tzbooking_update_product_price($this);
    });
});