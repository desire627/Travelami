"use strict";
jQuery(function($){
    $(document).ready(function(){
        $('.templaza-mobile-btn span').on('click',function(){

            $(this).parent().toggleClass('active');
            $('.templaza-basic-navbar').toggleClass('active');
        })
    })
});