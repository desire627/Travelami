<?php

defined('TEMPLAZA_FRAMEWORK');

use TemPlazaFramework\Functions;
use TemPlazaFramework\Templates;
use TemPlazaFramework\CSS;
if ( class_exists( 'TemPlazaFramework\TemPlazaFramework' ) ) {
$options            = Functions::get_theme_options();
$travelami_color = isset($options['theme-color'])?$options['theme-color']:'#0BBA48';
$button_color           = isset($options['button-color'])?$options['button-color']:'#ffffff';
$button_color_hover     = isset($options['button-color-hover'])?$options['button-color-hover']:'#ffffff';
$button_bg_color        = isset($options['button-background-color'])?$options['button-background-color']:'#0BBA48';
$button_bg_color_hover  = isset($options['button-background-color-hover'])?$options['button-background-color-hover']:'#222222';
$adv_single_price_bg  = isset($options['ap-single-price-bg'])?$options['ap-single-price-bg']:'';
$body_link_color_hover  = isset($options['body-link-hover-color'])?$options['body-link-hover-color']:'';

$button_color           = CSS::make_color_rgba_redux($button_color);
$button_bg_color        = CSS::make_color_rgba_redux($button_bg_color);
$button_color_hover     = CSS::make_color_rgba_redux($button_color_hover);
$button_bg_color_hover  = CSS::make_color_rgba_redux($button_bg_color_hover);
$adv_single_price_bg  = CSS::make_color_rgba_redux($adv_single_price_bg);
$body_link_color_hover  = CSS::make_color_rgba_redux($body_link_color_hover);

    if ($travelami_color != '') {
        $theme_color = CSS::make_color_rgba_redux($travelami_color);
        $travelami_css = '        
        blockquote.wp-block-quote::before,
        ul.wp-block-archives li.current-cat::before, ul.wp-block-archives li:hover::before,
        ul.widget_meta li.current-cat::before, ul.widget_meta li:hover::before,
        ul.wp-block-page-list li.current-cat::before, ul.wp-block-page-list li:hover::before,
        ul.wp-block-categories li.current-cat::before, ul.wp-block-categories li:hover::before,
        ul.wp-block-categories__list li.current-cat::before, ul.wp-block-categories__list li:hover::before,
        .header-block-item i, .top-header i,
        .uk-slider .uk-slidenav,ul.products li.product .price,
        ul.products li.product .price ins,
        ul.wp-block-archives li::before, ul.widget_meta li::before, ul.wp-block-page-list li::before, ul.wp-block-categories li::before, ul.wp-block-categories__list li::before,
        ul.wp-block-archives li.current-cat > a, ul.wp-block-archives li:hover > a, ul.widget_meta li.current-cat > a, ul.widget_meta li:hover > a, ul.wp-block-page-list li.current-cat > a, ul.wp-block-page-list li:hover > a, ul.wp-block-categories li.current-cat > a, ul.wp-block-categories li:hover > a, ul.wp-block-categories__list li.current-cat > a, ul.wp-block-categories__list li:hover > a,
        ul.wp-block-archives li.current-cat, ul.wp-block-archives li:hover, ul.widget_meta li.current-cat, ul.widget_meta li:hover, ul.wp-block-page-list li.current-cat, ul.wp-block-page-list li:hover, ul.wp-block-categories li.current-cat, ul.wp-block-categories li:hover, ul.wp-block-categories__list li.current-cat, ul.wp-block-categories__list li:hover,
        .templaza-post-navigation .previous-post:hover i, .templaza-post-navigation .previous-post:hover span,
        .templaza-blog-share a:hover,
        .templaza-single-tags a:hover,
        .templaza-blog-share a:hover i, .templaza-blog-share a:hover span,
        .ap-item.ap-item-style2 .ap-inner .ap-meta-top,
        .templaza-ap-single.ap-single-style2 .ap-single-price-box .price,
        .templaza-ap-single.ap-single-style2 .ap-single-top-fields .ap-custom-fields .ap-field-value,
        .templaza-ap-single .ap-single-side-box .highlight .currency,
        .ap-item.ap-item-style3 .ap-inner .ap-info-author a,
        .ap-item.ap-item-style3 .ap-inner .ap-info-bottom .ap-price-box span.ap-price,
        .templaza-archive .templaza-archive-item .templaza-blog-item-content .templaza-blog-item-info-top span i,
        div.templaza-single .templaza-blog-item-info span i,
        .templaza-related-posts .templaza-post-meta span i,
        .single-product-extra-content ul li::before,
        .elementor-widget-tabs .elementor-tabs .elementor-tab-content > ul li::before, .elementor-widget-tabs .elementor-tabs .elementor-tab-content > ol li::before,
        .wp-block-search .wp-block-search__button.wp-block-search__button:hover,
        .wp-block-search .wp-block-search__button.wp-block-search__button:active,
        .ap-item .ap-inner .ap-price-box,
        .ap-item.ap-item-style6 .ap-inner .ap-readmore-box .ap-price-box .ap-price,
        .ap-item.ap-item-style6 .ap-inner .ap-readmore-box .before-price, .ap-item.ap-item-style6 .ap-inner .ap-readmore-box .after-price,
        ul.products li.product .woocommerce-loop-product__title a:hover, ul.products li.product .meta-cat:hover,
        .ap-item.ap-item-style5 .ap-inner .ap-price-box .ap-price,
        .templaza-ap-single .ap-content-group-scroll .uk-active .ap-scroll-item,
        .templaza-ap-single .ap-content-group-scroll .ap-scroll-item:hover, blockquote:before, .templaza-sticky-add-to-cart__content-price,
        .wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper .wp-block-search__button.has-icon:hover,
         .wp-block-search .wp-block-search__input .wp-block-search__button.has-icon:hover,
         div.templaza-sidebar .wp-block-latest-posts>li>a:hover,
         .templaza-archive .templaza-archive-item span.category a:hover, .templaza-archive .templaza-archive-item span.author a:hover,
          .templaza-archive .templaza-archive-item span.tag a:hover,
          .templaza-post-meta>span a:hover, .ui-posts .uk-article-meta>span a:hover,
          .templaza-related-posts .templaza-post-meta span a:hover,
          .templaza-ap-single .ap-single-button-wrap .ap-btn:hover .ap-share-item a:hover i, .templaza-ap-single .ap-single-button-wrap .ap-btn:hover .ap-share-item i:hover i,
          .woocommerce-checkout .checkout-form-col .woocommerce-info a,
          .dealer-page .dealer-nav li.uk-active a, .templaza-archive .templaza-archive-item .readmore:hover,
          .templaza-archive .templaza-archive-item .readmore:hover i,
          .ap-item.ap-item-style5 .ap-inner .ap-specification.ap-specification-style5 .ap-spec-item .ap-spec-value a:hover,
          .module-latest-posts .module-latest-info .ap-price,
          .comment-list>.comment .reply a,
          .travelami-breadcrumb ul li a:hover, .templaza-heading ul li a:hover,
          .travelami-breadcrumb ul li.item-current span, .templaza-heading ul li.item-current span,
          div.templaza-ap-single.ap-single-style3 .ap-content-group-scroll.uk-sticky.uk-active .uk-nav li.uk-active a, 
          div.templaza-ap-single.ap-single-style3 .ap-content-group-scroll.uk-sticky.uk-active .uk-nav li:hover a
        {color: ' . $theme_color . ';}';
        $travelami_css .= '
        .product_list_widget > li .amount bdi, .product_list_widget > li .amount bdi span,
        .widget_shopping_cart_content .woocommerce-mini-cart__buttons .templaza-btn.templaza-btn-outline:hover,
        .templaza-btn-outline:hover, .single-product div.product .templaza-wishlist-button:hover i
        {color: ' . $theme_color . ' !important;}';
        $travelami_css .= '
        .wp-block-search.wp-block-search__button-inside .wp-block-search__inside-wrapper .wp-block-search__button.has-icon:hover svg,
         .wp-block-search .wp-block-search__input .wp-block-search__button.has-icon:hover svg
        {fill: ' . $theme_color . ' ;}';

        $travelami_css .= '
        .templaza-footer .templaza-social li a:hover,
        .elementor-widget-tabs .elementor-tabs .elementor-tab-title.elementor-active::after, .elementor-widget-tabs .elementor-tabs .elementor-tab-title:hover::after,
        div.templaza-sidebar .widget:hover > h1::after, div.templaza-sidebar .widget:hover > h2::after, div.templaza-sidebar .widget:hover > h3::after, div.templaza-sidebar .widget:hover > h4::after, div.templaza-sidebar .widget:hover > h5::after, div.templaza-sidebar .widget:hover > h6::after,        
        div.templaza-sidebar .widget:hover .widget-content > h1::after, div.templaza-sidebar .widget:hover .widget-content > h2::after, div.templaza-sidebar .widget:hover .widget-content > h3::after, div.templaza-sidebar .widget:hover .widget-content > h4::after, div.templaza-sidebar .widget:hover .widget-content > h5::after, div.templaza-sidebar .widget:hover .widget-content > h6::after, div.templaza-sidebar .widget:hover .wp-block-group > h1::after, div.templaza-sidebar .widget:hover .wp-block-group > h2::after, div.templaza-sidebar .widget:hover .wp-block-group > h3::after, div.templaza-sidebar .widget:hover .wp-block-group > h4::after, div.templaza-sidebar .widget:hover .wp-block-group > h5::after, div.templaza-sidebar .widget:hover .wp-block-group > h6::after, div.templaza-sidebar .widget:hover .wp-block-group__inner-container > h1::after, div.templaza-sidebar .widget:hover .wp-block-group__inner-container > h2::after, div.templaza-sidebar .widget:hover .wp-block-group__inner-container > h3::after, div.templaza-sidebar .widget:hover .wp-block-group__inner-container > h4::after, div.templaza-sidebar .widget:hover .wp-block-group__inner-container > h5::after, div.templaza-sidebar .widget:hover .wp-block-group__inner-container > h6::after,
        .uk-slider .uk-slidenav:hover,
        .products-filter--checkboxes .products-filter__option.selected > .products-filter__option-name::before, .products-filter--checkboxes .products-filter__option:hover > .products-filter__option-name::before, .products-filter--ranges .products-filter__option.selected > .products-filter__option-name::before,
         .products-filter--ranges .products-filter__option:hover > .products-filter__option-name::before,
         .woocommerce-tabs > ul.tabs > li > a::after,
         div.templaza-sidebar .widget .widget-content > h1::after, div.templaza-sidebar .widget .widget-content > h2::after, div.templaza-sidebar .widget .widget-content > h3::after, div.templaza-sidebar .widget .widget-content > h4::after, div.templaza-sidebar .widget .widget-content > h5::after, div.templaza-sidebar .widget .widget-content > h6::after, div.templaza-sidebar .widget .wp-block-group > h1::after, div.templaza-sidebar .widget .wp-block-group > h2::after, div.templaza-sidebar .widget .wp-block-group > h3::after, div.templaza-sidebar .widget .wp-block-group > h4::after, div.templaza-sidebar .widget .wp-block-group > h5::after, div.templaza-sidebar .widget .wp-block-group > h6::after, div.templaza-sidebar .widget .wp-block-group__inner-container > h1::after, div.templaza-sidebar .widget .wp-block-group__inner-container > h2::after, div.templaza-sidebar .widget .wp-block-group__inner-container > h3::after, div.templaza-sidebar .widget .wp-block-group__inner-container > h4::after, div.templaza-sidebar .widget .wp-block-group__inner-container > h5::after, div.templaza-sidebar .widget .wp-block-group__inner-container > h6::after,
         .ap-item.ap-item-style2 .ap-inner .ap-specification.ap-specification-style2 .ap-spec-item::before,
         .advanced-product-search-form .uk-form-controls ul li:hover input[type="checkbox"],
         .templaza-ap-single .ap-single-side-box .highlight,
         .templaza-ap-single.ap-single-style2 .ap-single-content-tab .ap-tab-title li::before,
         .ap-button-info .ap-button:hover, .ap-button-info .ap-button.ap-in-compare-list,
         div.templaza-sidebar .widget .widget-content > h1::before, div.templaza-sidebar .widget .widget-content > h2::before, div.templaza-sidebar .widget .widget-content > h3::before, div.templaza-sidebar .widget .widget-content > h4::before, div.templaza-sidebar .widget .widget-content > h5::before, div.templaza-sidebar .widget .widget-content > h6::before, div.templaza-sidebar .widget .wp-block-group > h1::before, div.templaza-sidebar .widget .wp-block-group > h2::before, div.templaza-sidebar .widget .wp-block-group > h3::before, div.templaza-sidebar .widget .wp-block-group > h4::before, div.templaza-sidebar .widget .wp-block-group > h5::before, div.templaza-sidebar .widget .wp-block-group > h6::before, div.templaza-sidebar .widget .wp-block-group__inner-container > h1::before, div.templaza-sidebar .widget .wp-block-group__inner-container > h2::before, div.templaza-sidebar .widget .wp-block-group__inner-container > h3::before, div.templaza-sidebar .widget .wp-block-group__inner-container > h4::before, div.templaza-sidebar .widget .wp-block-group__inner-container > h5::before, div.templaza-sidebar .widget .wp-block-group__inner-container > h6::before,
         .templaza-single .templaza-single-box .box-title::before,
         .templaza-single .templaza-single-box .box-title::after,
         .templaza-ap-single .ap-single-side-box .widget-title::before,
         .templaza-ap-single .ap-single-side-box .widget-title::after,
         .box-title::before, .box-title::after,
         .ap-item.ap-item-style1 .ap-inner .ap-specification .ap-spec-item:first-child,
         .ap-archive-btn-action .uk-icon-button:hover, .header-cart a .counter,
         .ui-slider .ui-slider-range, #ap-product-modal__quickview .product-more-infor,
         .templaza-ap-archive-view span.switcher_btn:hover, .templaza-ap-archive-view span.switcher_btn.uk-active,
         .templaza-ap-single .ap-single-button-wrap .ap-btn:hover, .templaza-ap-single .ap-single-button-wrap .ap-btn.ap-in-compare-list,
         .templaza-ap-single .ap-content-group-scroll .uk-active .ap-scroll-item:after,
         .templaza-ap-single .ap-content-group-scroll .ap-scroll-item:hover:after,
         .templaza-ap-single .ap-content-group-scroll.uk-sticky.uk-active .uk-active a,
         .single-product div.product section.products .swiper-scrollbar-drag,
         .ap-compare-btn-wrap.closed .ap-compare-close,
         #dealership_login .dls-field input.checkbox:checked, #dealership_login .dls-field input.checkbox:hover,
         form input[type="radio"]:checked, form input[type="checkbox"]:checked,
         .tz-theme-bg-color, .advanced-product-search-form .uk-form-controls ul li input[type="checkbox"]:checked,
         .templaza-ap-single .ap-slideshow .uk-slidenav:hover,
         .templaza-ap-single .ap-content-group-scroll.uk-sticky.uk-active .ap-scroll-item:hover,
         .templaza-error-page .searchform button, .templaza-loading:before,
         .templaza-ap-single .ap-custom-fields-style3.ap-custom-field-file .ap-field-value a:hover,
         .templaza-ap-product-filter.uk-sticky-fixed .ap-filter-btn,
         .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, .advanced-product-search-form a.ui-button:active,
          .advanced-product-search-form .ui-button:active, .advanced-product-search-form .ui-button.ui-state-active:hover,
          .uk-dotnav > .uk-active > ::before, .uk-dotnav li:hover > ::before,
          body .templaza-header .navbar-nav .menu-item:hover>a.item-level-1:before, 
          body .templaza-header .navbar-nav .menu-item:hover>a.item-level-1:after,
          body .templaza-header .navbar-nav .menu-item>.sub-menu li.menu-item>a:hover:before, 
          body .templaza-header .navbar-nav .menu-item>.sub-menu li.menu-item>a:hover:after,
          div.templaza-ap-single.ap-single-style3 .ap-content-group-scroll.uk-sticky.uk-active .uk-nav li.uk-active a::after, 
          div.templaza-ap-single.ap-single-style3 .ap-content-group-scroll.uk-sticky.uk-active .uk-nav li:hover a::after,
          body .templaza-header .navbar-nav .menu-item.current-menu-item > a.item-level-1::before, 
          body .templaza-header .navbar-nav .menu-item.current-menu-item > a.item-level-1::after, 
          body .templaza-header .navbar-nav .menu-item.current-menu-ancestor > a.item-level-1::before,
           body .templaza-header .navbar-nav .menu-item.current-menu-ancestor > a.item-level-1::after,
           .sc_heading .sub-heading:before, .sc_heading .sub-heading:after
        {background-color: ' . $theme_color . ';}';

        $travelami_css .= '
        .products-filter--checkboxes .products-filter__option.selected > .products-filter__option-name::before, .products-filter--checkboxes .products-filter__option:hover > .products-filter__option-name::before, .products-filter--ranges .products-filter__option.selected > .products-filter__option-name::before,
         .products-filter--ranges .products-filter__option:hover > .products-filter__option-name::before,
         .ap-button-info .ap-button:hover, .ap-button-info .ap-button.ap-in-compare-list,
         .wp-block-tag-cloud a:hover, .tagcloud a:hover,
         .templaza-single-tags a:hover,
         .navigation .nav-links .page-numbers:hover, .navigation .nav-links .page-numbers.current,
         .woocommerce-pagination ul.page-numbers a:hover, .woocommerce-pagination ul.page-numbers a.current,
          .woocommerce-pagination ul.page-numbers span:hover, .woocommerce-pagination ul.page-numbers span.current,
          .templaza-single .templaza-single-author,
          .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, .advanced-product-search-form a.ui-button:active,
           .advanced-product-search-form .ui-button:active, .advanced-product-search-form .ui-button.ui-state-active:hover,
           .uk-dotnav > .uk-active > *, .uk-dotnav li:hover > *,
           body div.wpforms-container-full .wpforms-form input[type=text]:focus,
           body div.wpforms-container-full .wpforms-form input[type=email]:focus,
           body div.wpforms-container-full .wpforms-form input[type=number]:focus,
           body div.wpforms-container-full input[type="checkbox"]:checked::before, body div.wpforms-container-full input[type="radio"]:checked::before, body div.wpforms-container-full input[type="checkbox"]:focus::before, 
           body div.wpforms-container-full input[type="radio"]:focus::before,
           body div.wpforms-container-full input[type="checkbox"]:checked::after, 
           body div.wpforms-container-full input[type="checkbox"]:focus::after
        {border-color: ' . $theme_color . ';}';

        $travelami_css .= '
        .widget_shopping_cart_content .woocommerce-mini-cart__buttons .templaza-btn.templaza-btn-outline:hover,
        .templaza-btn-outline:hover
        {border-color: ' . $theme_color . ' !important;}';

        Templates::add_inline_style($travelami_css);
    }
    $travelami_btn_css = '';
    if($button_color !=''){
        $travelami_btn_css .='
        .templaza-btn:not(:hover):not(:active):not(.has-text-color),
        body .wpem-theme-button:not(:hover):not(:active):not(.has-background),
        body .wpem-theme-button:hover span,
        .event_listings a.load_more_events, .wpem-tab-pane a.load_more_events,
        .templaza-single-content .wpem-single-event-page .wpem-single-event-wrapper .wpem-single-event-body .wpem-single-event-body-sidebar .registration_button,
        ul.products.product-loop-layout-2 li.product .product-thumbnail > .tz-loop-button,
        .comment-form .form-submit input,.woocommerce-cart .cart-collaterals .wc-proceed-to-checkout a.button,
        .woocommerce-pagination ul.page-numbers a:hover,
        .woocommerce-pagination ul.page-numbers a.current,
         .woocommerce-pagination ul.page-numbers span:hover,
        .woocommerce-pagination ul.page-numbers span.current,
        .navigation .nav-links .page-numbers:hover,
        .navigation .nav-links .page-numbers.current,
        .woocommerce-pagination .nav-links .page-numbers:hover,
        .woocommerce-pagination .nav-links .page-numbers.current,
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav,
        .wp-block-tag-cloud a:hover, .tagcloud a:hover,
        .ap-compare-btn-wrap .uk-button,
        .ap-compare-btn-wrap .uk-button:hover,
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav.uk-slidenav-previous,
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav.uk-slidenav-next,
        .tz-slideshow-control .prev, .tz-slideshow-control .next, .tz-slideshow-control-thumb .prev, .tz-slideshow-control-thumb .next,
        .templaza-sticky-add-to-cart.product_variable_button .templaza-sticky-add-to-cart__content-button,
        form.comment-form .form-submit input,
        .templaza-sticky-add-to-cart__content-button,
        body div.wpforms-container-full .wpforms-form input[type="submit"]:not(:hover):not(:active):not(.has-background), body div.wpforms-container-full .wpforms-form button[type="submit"]:not(:hover):not(:active):not(.has-background), body div.wpforms-container-full .wpforms-form .wpforms-page-button:not(:hover):not(:active):not(.has-background)
        
        {color: ' . $button_color . ';}';
    }
    if($button_color_hover !=''){
        $travelami_btn_css .='
        .templaza-btn:hover,
        body .wpem-theme-button:hover span,
        .event_listings a.load_more_events:hover, .wpem-tab-pane a.load_more_events:hover,
        .templaza-single-content .wpem-single-event-page .wpem-single-event-wrapper .wpem-single-event-body .wpem-single-event-body-sidebar .registration_button:hover,
        .comment-form .form-submit input:hover,
        .woocommerce-pagination ul.page-numbers a:hover,
        .woocommerce-pagination ul.page-numbers a.current,
        .woocommerce-pagination ul.page-numbers span:hover,
        .woocommerce-pagination ul.page-numbers span.current,        
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav:hover,
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav.uk-slidenav-previous:hover,
         .templaza-blog-item .templaza-archive-gallery .uk-slidenav.uk-slidenav-next:hover,
         .tz-slideshow-control .prev:hover, .tz-slideshow-control .next:hover, .tz-slideshow-control-thumb .prev:hover, .tz-slideshow-control-thumb .next:hover,
         .templaza-sticky-add-to-cart.product_variable_button .templaza-sticky-add-to-cart__content-button:hover,
         form.comment-form .form-submit input:hover,
         .templaza-sticky-add-to-cart__content-button:hover,
         body div.wpforms-container-full .wpforms-form input[type="submit"]:hover, body div.wpforms-container-full .wpforms-form input[type="submit"]:active, body div.wpforms-container-full .wpforms-form button[type="submit"]:hover, body div.wpforms-container-full .wpforms-form button[type="submit"]:active, body div.wpforms-container-full .wpforms-form .wpforms-page-button:hover, body div.wpforms-container-full .wpforms-form .wpforms-page-button:active
        {color: ' . $button_color_hover . ';}';
    }
    if($button_bg_color !=''){
        $travelami_btn_css .='
        .templaza-btn:not(:hover):not(:active):not(.has-background),
         .wp-element-button:not(:hover):not(:active):not(.has-background),
          .wp-block-button__link:not(:hover):not(:active):not(.has-background),
        .templaza-btn:not(:hover):not(:active):not(.has-text-color),
        body .wpem-theme-button:not(:hover):not(:active):not(.has-background),
        .event_listings a.load_more_events, .wpem-tab-pane a.load_more_events,
        .templaza-single-content .wpem-single-event-page .wpem-single-event-wrapper .wpem-single-event-body .wpem-single-event-body-sidebar .registration_button,
        ul.products.product-loop-layout-2 li.product .product-thumbnail > .tz-loop-button,
        .comment-form .form-submit input,.woocommerce-cart .cart-collaterals .wc-proceed-to-checkout a.button,
        .woocommerce-pagination ul.page-numbers a:hover,
        .woocommerce-pagination ul.page-numbers a.current,
        .woocommerce-pagination ul.page-numbers span:hover,
        .woocommerce-pagination ul.page-numbers span.current,         
        .navigation .nav-links .page-numbers:hover,
        .navigation .nav-links .page-numbers.current,
        .woocommerce-pagination .nav-links .page-numbers:hover,
        .woocommerce-pagination .nav-links .page-numbers.current,
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav,
        .wp-block-tag-cloud a:hover, .tagcloud a:hover,
        .ap-compare-btn-wrap .uk-button,
        .ap-compare-btn-wrap .uk-button:hover,
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav.uk-slidenav-previous,
         .templaza-blog-item .templaza-archive-gallery .uk-slidenav.uk-slidenav-next,
         .tz-slideshow-control .prev, .tz-slideshow-control .next, .tz-slideshow-control-thumb .prev, .tz-slideshow-control-thumb .next,
         .templaza-sticky-add-to-cart.product_variable_button .templaza-sticky-add-to-cart__content-button,
         form.comment-form .form-submit input,
         .templaza-sticky-add-to-cart__content-button,
         body div.wpforms-container-full .wpforms-form input[type="submit"]:not(:hover):not(:active):not(.has-background), body div.wpforms-container-full .wpforms-form button[type="submit"]:not(:hover):not(:active):not(.has-background), body div.wpforms-container-full .wpforms-form .wpforms-page-button:not(:hover):not(:active):not(.has-background),
         .ap-item.ap-item-style6 .ap-inner .ap-readmore-box:hover,
         ul.products.product-loop-layout-9 li.product .product-summary .tz-loop_atc_button:hover,
          ul.products.product-loop-layout-9 li.product .product-summary .product-quick-shop-button:hover,
          .ap-item.ap-item-style5 .ap-inner .ap-readmore-box .templaza-btn:hover,
          table.shop_table td.product-add-to-cart a, .ap-item.ap-item-style2 .ap-inner .ap-readmore-box .templaza-btn
        {background-color: ' . $button_bg_color . ';}';
    }
    if($button_bg_color_hover !=''){
        $travelami_btn_css .='
        .templaza-btn:hover,
        body .wpem-theme-button:hover,
        .event_listings a.load_more_events:hover, .wpem-tab-pane a.load_more_events:hover,
        .templaza-single-content .wpem-single-event-page .wpem-single-event-wrapper .wpem-single-event-body .wpem-single-event-body-sidebar .registration_button:hover,
        .comment-form .form-submit input:hover,
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav:hover,
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav.uk-slidenav-previous:hover,
        .templaza-blog-item .templaza-archive-gallery .uk-slidenav.uk-slidenav-next:hover,
        .tz-slideshow-control .prev:hover, .tz-slideshow-control .next:hover, .tz-slideshow-control-thumb .prev:hover, .tz-slideshow-control-thumb .next:hover,
        .templaza-sticky-add-to-cart.product_variable_button .templaza-sticky-add-to-cart__content-button:hover,
        form.comment-form .form-submit input:hover,
        .templaza-sticky-add-to-cart__content-button:hover,
        body div.wpforms-container-full .wpforms-form input[type="submit"]:hover, body div.wpforms-container-full .wpforms-form input[type="submit"]:active, body div.wpforms-container-full .wpforms-form button[type="submit"]:hover, body div.wpforms-container-full .wpforms-form button[type="submit"]:active, body div.wpforms-container-full .wpforms-form .wpforms-page-button:hover, body div.wpforms-container-full .wpforms-form .wpforms-page-button:active
        
        {background-color: ' . $button_bg_color_hover . ';}';
    }
    if($adv_single_price_bg !=''){
        $travelami_btn_css .='        
        div.templaza-ap-single.ap-single-style3 .ap-single-side-box.ap-single-price-box .ap-single-price-inner
        
        {background-color: ' . $adv_single_price_bg . ';}';
    }
    if($body_link_color_hover !=''){
        $travelami_btn_css .='        
        div.templaza-ap-single.ap-single-style3 .ap-group-content .field-value .ap-field-value a:hover
        
        {color: ' . $body_link_color_hover . ';}';
    }
    Templates::add_inline_style($travelami_btn_css);
}