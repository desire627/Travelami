jQuery(document).ready(function (e) {
    "use strict";

    function t() {
        jQuery(".clone-wrapper").length && jQuery(".clone-wrapper").each(function (e) {
            var t = jQuery(this).find(".clone-field .remove-clone");
            t.length < 2 ? t.hide() : t.show()
        })
    }

    jQuery("#hotel_filter").select2({
        placeholder: "Filter by Hotel",
        allowClear: !0,
        width: "240px"
    }), jQuery("#date_from_filter").datepicker({dateFormat: "yy-mm-dd"}), jQuery("#date_to_filter").datepicker({dateFormat: "yy-mm-dd"}), jQuery("#hotel-order-filter").click(function () {
        var e = jQuery("#hotel_filter").val(), t = jQuery("#date_from_filter").val(),
            r = jQuery("#date_to_filter").val(), o = jQuery("#booking_no_filter").val(),
            a = jQuery("#status_filter").val(), i = "edit.php?post_type=hotel&page=orders";
        e && (i += "&post_id=" + e), t && (i += "&date_from=" + t), r && (i += "&date_to=" + r), o && (i += "&booking_no=" + o), a && (i += "&status=" + a), document.location = i
    }), jQuery("#product_filter").select2({
        placeholder: "Filter by Product",
        allowClear: !0,
        width: "240px"
    }), jQuery("#product-order-filter").click(function () {
        var e = jQuery("#product_filter").val(), t = jQuery("#date_filter").val(), r = jQuery("#booking_no_filter").val(),
            o = jQuery("#status_filter").val(), a = "edit.php?post_type=ap_product&page=product_orders";
        e && (a += "&post_id=" + e), t && (a += "&date=" + t), r && (a += "&booking_no=" + r), o && (a += "&status=" + o), document.location = a
    }), jQuery(".row-actions .delete a").click(function () {
        if (0 == confirm("It will be deleted permanetly. Do you want to delete it?")) return !1
    }), jQuery(".hotel-order-form #post_id").select2({
        placeholder: "Select a Hotel",
        width: "250px"
    }), jQuery(".product-order-form #post_id").select2({
        placeholder: "Select a Product",
        width: "250px"
    }), jQuery("#date_from").datepicker({dateFormat: "yy-mm-dd"}), jQuery("#date_to").datepicker({dateFormat: "yy-mm-dd"}), jQuery("#date").datepicker({dateFormat: "yy-mm-dd"}), jQuery("#time").timepicker({}), jQuery("#post_id").change(function () {
        jQuery.ajax({
            url: ajaxurl,
            type: "POST",
            data: {action: "hotel_order_postid_change", post_id: jQuery(this).val()},
            success: function (e) {
                1 == e.success && (jQuery(".room_hotel_id_select").each(function (t) {
                    var r = jQuery(this).val();
                    jQuery(this).html(e.room_list), jQuery(this).val(r)
                }), jQuery(".service_id_select").each(function (t) {
                    var r = jQuery(this).val();
                    jQuery(this).html(e.service_list), jQuery(this).val(r)
                }))
            }
        })
    }), t(), jQuery(".add-clone").on("click", function (e) {
        e.stopPropagation();
        var r = jQuery(this).closest(".clone-wrapper").find(".clone-field:last"), o = r.clone();
        o.insertAfter(r);
        var a = o.find("input");
        a.val(""), a.each(function (e) {
            var t = jQuery(this).attr("name").replace(/\[(\d+)\]/, function (e, t) {
                return "[" + (parseInt(t) + 1) + "]"
            });
            jQuery(this).attr("name", t)
        });
        var i = o.find("select");
        return i.each(function (e) {
            var t = i.attr("name").replace(/\[(\d+)\]/, function (e, t) {
                return "[" + (parseInt(t) + 1) + "]"
            });
            jQuery(this).attr("name", t), jQuery(this).find("option:selected").prop("selected", !1)
        }), t(), !1
    }), jQuery("body").on("click", ".remove-clone", function () {
        return !(jQuery(this).closest(".clone-wrapper").find(".clone-field").length <= 1) && (jQuery(this).closest(".clone-field").remove(), t(), !1)
    })
});
var submitting = !1;

function manage_order_validateForm() {
    "use strict";
    return 1 != submitting && ("" == jQuery("#post_id").val() ? (alert(jQuery("#order-form").data("message")), !1) : (submitting = !0, !0))
}