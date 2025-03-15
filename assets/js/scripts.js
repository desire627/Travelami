jQuery(function($){
    "use strict";
    $(document).ready(function(){
        if ($("body").hasClass('home')){
            $('.section_heading').addClass('home-heading');
        }

        if ($('.has-content-area').length) {
            let colReg = /col-lg-(.+)/i,
                contentColumn = $('.has-content-area > .templaza-content-column'),
                colContent = colReg.exec($('.has-content-area > .templaza-content-column').attr('class')),
                content_column = parseInt(colContent[1]);
            $('.has-content-area').find('>.templaza-column').each(function (i, el) {
                if ($(el).html().trim() === '') {

                    let colNum = colReg.exec($(el).attr('class'));
                    if (colNum !== null) {
                        content_column    +=  parseInt(colNum[1]);
                        contentColumn.addClass('col-lg-'+content_column);
                    }
                    $(el).remove();
                }
            });
        }
        if ($('.templaza-single-content').length) {
            $('.templaza-single-content').find('iframe').each(
                function () {
                    var $thisIframe = $( this ),
                        width       = $thisIframe.attr( 'width' ),
                        height      = $thisIframe.attr( 'height' ),
                        newHeight   = $thisIframe.width() / width * height; // rendered width divided by aspect ratio

                    $thisIframe.css( 'height', newHeight );
                }
            );
        }

        if($('.progress-bar').length){
            $('.progress-bar').loading();
        }

        if($('.header-search').length){
            $('.header-search span').on('click', function(){
                $(this).parent().find('.searchform').toggleClass('active');
            });
        }
        $('iframe').removeAttr('frameborder');
        UIkit.util.on('.book-service', 'click', function (index) {
            $('.service_title input').val($(this).attr('data-title')+' '+$(this).attr('data-url'));
        });

    });
    $(window).on("load resize",function(e){
        if($('.single-ap_product').length){
            if($( window ).width() < 960){
                $('#vendor .uk-card').appendTo('.ap-single-author-box-mb');
                if($('.templaza-btn.highlight').attr('href')==='#vendor'){
                    $('.templaza-btn.highlight').attr('href','#vendormb');
                }
            }
        }
    });
});