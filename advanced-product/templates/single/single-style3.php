<?php

defined('ADVANCED_PRODUCT') or exit();

use Advanced_Product\AP_Templates;
use Advanced_Product\AP_Functions;
use Advanced_Product\Helper\AP_Product_Helper;
use Advanced_Product\Helper\AP_Custom_Field_Helper;
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $templaza_options = array();
}else{
    $templaza_options = Functions::get_theme_options();
}
$widget_heading_style       = isset($templaza_options['widget_box_heading_style'])?$templaza_options['widget_box_heading_style']:'';
$ap_offer_price           = isset($templaza_options['ap_product-office-price'])?$templaza_options['ap_product-office-price']:true;
$ap_offer_price_label     = isset($templaza_options['ap_product-office-price-label'])?$templaza_options['ap_product-office-price-label']:'MAKE AN OFFER PRICE';
$ap_offer_price_form      = isset($templaza_options['ap_product-office-price-form'])?$templaza_options['ap_product-office-price-form']:'';
$ap_offer_form_custom     = isset($templaza_options['ap_product-office-price-form-custom'])?$templaza_options['ap_product-office-price-form-custom']:'';
$ap_offer_form_custom_url     = isset($templaza_options['ap_product-office-price-form-custom-url'])?$templaza_options['ap_product-office-price-form-custom-url']:'';
$ap_content_group     = isset($templaza_options['ap_product-single-group-content'])?$templaza_options['ap_product-single-group-content']:'';
$ap_content_group_sticky     = isset($templaza_options['ap_product-single-group-content-sticky'])?$templaza_options['ap_product-single-group-content-sticky']:false;
$ap_vendor_contact     = isset($templaza_options['ap_product-vendor-contact'])?$templaza_options['ap_product-vendor-contact']:'';
$ap_vendor_contact_custom     = isset($templaza_options['ap_product-vendor-form-custom'])?$templaza_options['ap_product-vendor-form-custom']:'';
$ap_vendor_contact_custom_url     = isset($templaza_options['ap_product-vendor-form-custom-url'])?$templaza_options['ap_product-vendor-form-custom-url']:'';
$ap_vendor_title     = isset($templaza_options['ap_product-vendor-contact-label'])?$templaza_options['ap_product-vendor-contact-label']:__('Contact Vendor','travelami');
$show_compare_button= get_field('ap_show_archive_compare_button', 'option');
$show_compare_button= $show_compare_button!==false?(bool)$show_compare_button:true;
$show_compare_button= isset($args['show_archive_compare_button'])?(bool)$args['show_archive_compare_button']:$show_compare_button;
$ap_show_vendor           = isset($templaza_options['ap_product-single-vendor'])?$templaza_options['ap_product-single-vendor']:true;
$ap_show_vendor_number    = isset($templaza_options['ap_product-single-vendor-count'])?$templaza_options['ap_product-single-vendor-count']:true;
$ap_share           = isset($templaza_options['ap_product-single-share'])?$templaza_options['ap_product-single-share']:false;
$ap_comment           = isset($templaza_options['ap_product-single-comment'])?$templaza_options['ap_product-single-comment']:true;
$ap_share_label     = isset($templaza_options['ap_product-single-share-label'])?$templaza_options['ap_product-single-share-label']:'';

$ap_form_rental     = isset($templaza_options['ap_product-form-rental'])?$templaza_options['ap_product-form-rental']:'';
$ap_rental_label     = isset($templaza_options['ap_product-form-rental-label'])?$templaza_options['ap_product-form-rental-label']:'';
$ap_rental_url     = isset($templaza_options['ap_product-form-rental-url'])?$templaza_options['ap_product-form-rental-url']:'';
$ap_rental_custom     = isset($templaza_options['ap_product-form-rental-custom'])?$templaza_options['ap_product-form-rental-custom']:'';
$ap_tour_width     = isset($templaza_options['ap_product-single-style3-width'])?$templaza_options['ap_product-single-style3-width']:'uk-container-large';
$ap_video   = get_field('ap_video', get_the_ID());
$ap_product_related = isset($templaza_options['ap_product-related']) ? $templaza_options['ap_product-related'] : true;
do_action('templaza_set_postviews',get_the_ID());
$author_id = get_post_field( 'post_author', get_the_ID() );
$ap_count = count_user_posts( $author_id,'ap_product' );

$ap_booking  = isset($templaza_options['ap_product-booking-enable'])?$templaza_options['ap_product-booking-enable']:false;
$tzbooking_adult_price = $tzbooking_child_price ='';
$adult_price  = isset($templaza_options['ap_product_data_price'])?$templaza_options['ap_product_data_price']:'';
if($adult_price){
    $tzbooking_adult_price = get_field($adult_price, get_the_ID());
}
$child_price  = isset($templaza_options['ap_product_data_child_price'])?$templaza_options['ap_product_data_child_price']:'';
if($child_price){
    $tzbooking_child_price = get_field($child_price, get_the_ID());
}
$product_type   = get_field('ap_product_type', get_the_ID());

$symbol = get_option('options_ap_currency_symbol', '$');

?>
    <div class="templaza-ap-single uk-article ap-single-style3">
        <div class="uk-inline uk-position-relative ap-single-box ap-single-box-media uk-width-1-1">
            <div class="ap-media uk-cover-container uk-width-1-1" data-uk-height-viewport="offset-top: true; offset-bottom: 20">
                <?php
                if (!empty($ap_video)) {
                    AP_Templates::load_my_layout('single.media.video');
                } else {
                    the_post_thumbnail('full', array('data-uk-cover' => ''));
                }
                ?>
            </div>
            <div class="uk-position-center ap-single-style3-banner uk-text-center">
                <div class="uk-container uk-container-small">
                    <div  class="templaza-breadcrumb uk-margin-remove-vertical">
                        <div class="travelami-breadcrumb">
                            <?php
                            do_action('templaza_breadcrumb');
                            ?>
                        </div>
                    </div>
                    <div class="templaza-heading heading-single">
                        <h1><?php the_title(); ?></h1>
                        <div class="tz-tour-review uk-flex uk-flex-center uk-margin-top">
                            <?php
                            if( class_exists( 'Comment_Rating_Output' ) ):
                                $average_rating = get_post_meta( get_the_ID(), 'tz-average-rating', true );
                                if ( empty( $average_rating ) ) {
                                    $average_rating = 0;
                                }
                                echo '<div class="tz-average-rating"><div class="tz-rating tz-rating-' . esc_attr($average_rating) . '"></div></div>';
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ap-single-style3-wrap uk-container <?php echo esc_attr($ap_tour_width);?>">
            <?php
            if($ap_content_group_sticky){
            ?>
            <div id="ap-single-wrap-sticky" class="uk-flex">
                <?php
                }
                ?>
                <div id="ap-wrap-content" class="ap-content-single " data-uk-grid>
                    <div class="uk-width-expand@m ap-content">
                        <div class="uk-width-1-3@m ap-templaza-sidebar uk-position-relative uk-hidden@m uk-position-z-index">
                            <div class="ap-sidebar-inner">
                                <div class="ap-single-price-box ap-single-side-box">
                                    <div class="ap-single-price-inner">
                                        <?php
                                        AP_Templates::load_my_layout('single.price');
                                        ?>
                                    </div>
                                    <div class="ap-single-booking-form">
                                        <?php
                                        if($ap_booking ){
                                            if(in_array('sale', $product_type)){
                                                require get_template_directory() . '/booking/templates/booking-form.php';
                                                ?>
                                                <div class="uk-text-center uk-padding-small"><?php esc_html_e('OR','travelami');?></div>
                                                <a class="highlight uk-margin-remove uk-flex uk-flex-between templaza-btn uk-flex-middle" href="#modal-enquiry" data-uk-toggle>
                                                    <?php esc_html_e('Send Enquiry','travelami');?>
                                                </a>
                                                <?php
                                            }else{
                                                if($ap_vendor_title !='' && $ap_vendor_contact !=''){
                                                    ?>
                                                    <h3 class="widget-title ap-group-title is-style-templaza-heading-style1">
                                                        <span><?php echo esc_html($ap_vendor_title);?></span>
                                                    </h3>
                                                    <?php
                                                }
                                                if($ap_vendor_contact =='custom'){
                                                    echo do_shortcode($ap_vendor_contact);
                                                }else{
                                                    ?>
                                                    <div class="ap-group-content">
                                                        <?php
                                                        echo do_shortcode('[wpforms id="' . $ap_vendor_contact . '"]');
                                                        ?>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }else{
                                            if($ap_vendor_title !='' && $ap_vendor_contact !=''){
                                                ?>
                                                <h3 class="widget-title ap-group-title is-style-templaza-heading-style1">
                                                    <span><?php echo esc_html($ap_vendor_title);?></span>
                                                </h3>
                                                <?php
                                            }
                                            if($ap_vendor_contact =='custom'){
                                                echo do_shortcode($ap_vendor_contact);
                                            }else{
                                                ?>
                                                <div class="ap-group-content">
                                                    <?php
                                                    echo do_shortcode('[wpforms id="' . $ap_vendor_contact . '"]');
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                        }

                                        ?>
                                    </div>
                                    <?php if($ap_offer_price){ ?>
                                        <div class=" hightlight-box">
                                            <a class="highlight uk-flex uk-flex-between uk-flex-middle" href="#modal-center" data-uk-toggle>
                                <span>
                                    <?php echo esc_html($ap_offer_price_label);?>
                                </span>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php
                                if($ap_show_vendor){
                                    ?>
                                    <div class="ap-single-price-box ap-single-side-box ap-single-author-box ap-single-box">
                                        <div class="uk-card">
                                            <div class="author-header">
                                                <div class="uk-grid-small uk-flex-middle" data-uk-grid>
                                                    <div class="uk-width-auto">
                                                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>">
                                                            <img class="uk-border-circle" width="70" height="70" src="<?php echo esc_url( get_avatar_url( get_the_author_meta('ID'),150) ); ?>">
                                                        </a>
                                                    </div>
                                                    <div class="uk-width-expand">
                                                        <h3 class="uk-card-title uk-margin-remove-bottom">
                                                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>">
                                                                <?php the_author();?>
                                                            </a>
                                                        </h3>
                                                        <?php
                                                        if($ap_show_vendor_number){
                                                            ?>
                                                            <p class="uk-text-meta uk-margin-remove-top"><?php echo esc_html($ap_count);?> <?php esc_html_e('Products','travelami');?></p>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="author-description">
                                                <?php the_author_meta('description'); ?>
                                                <div class="templaza-block-author-social uk-text-meta  uk-margin-top">
                                                    <?php do_action('templaza_author_social');?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="ap-single-box ap-single-content">
                            <?php
                            the_content();
                            if($ap_content_group !=''){
                                AP_Templates::load_my_layout('single.group-fields-content-style2');
                            }
                            ?>

                        </div>
                        <?php
                        if($ap_content_group ==''){
                            if($ap_comment){
                                ?>
                                <div class="templaza-single-comment ap-single-box">
                                    <?php comments_template('', true); ?>
                                </div>
                                <?php
                            }
                        }
                        ?>

                    </div>
                    <div class="uk-width-1-3@m ap-templaza-sidebar uk-visible@m">
                        <div class="ap-sidebar-inner" <?php if($ap_content_group_sticky){ ?> data-uk-sticky="end: .ap-content-single; offset:100" <?php } ?>>
                            <div class="ap-single-price-box ap-single-side-box">
                                <div class="ap-single-price-inner">
                                    <?php
                                    AP_Templates::load_my_layout('single.price');
                                    ?>
                                </div>
                                <div class="ap-single-booking-form">
                                    <?php
                                    if($ap_booking ){
                                        if(in_array('sale', $product_type)){
                                            require get_template_directory() . '/booking/templates/booking-form.php';
                                            ?>
                                            <div class="uk-text-center uk-padding-small"><?php esc_html_e('OR','travelami');?></div>
                                            <a class="highlight uk-margin-remove uk-flex uk-flex-between templaza-btn uk-flex-middle" href="#modal-enquiry" data-uk-toggle>
                                                <?php esc_html_e('Send Enquiry','travelami');?>
                                            </a>
                                            <?php
                                        }else{
                                            if($ap_vendor_title !='' && $ap_vendor_contact !=''){
                                                ?>
                                                <h3 class="widget-title ap-group-title is-style-templaza-heading-style1">
                                                    <span><?php echo esc_html($ap_vendor_title);?></span>
                                                </h3>
                                                <?php
                                            }
                                            if($ap_vendor_contact =='custom'){
                                                echo do_shortcode($ap_vendor_contact);
                                            }else{
                                                ?>
                                                <div class="ap-group-content">
                                                    <?php
                                                    echo do_shortcode('[wpforms id="' . $ap_vendor_contact . '"]');
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }else{
                                        if($ap_vendor_title !='' && $ap_vendor_contact !=''){
                                            ?>
                                            <h3 class="widget-title ap-group-title is-style-templaza-heading-style1">
                                                <span><?php echo esc_html($ap_vendor_title);?></span>
                                            </h3>
                                            <?php
                                        }
                                        if($ap_vendor_contact =='custom'){
                                            echo do_shortcode($ap_vendor_contact);
                                        }else{
                                            ?>
                                            <div class="ap-group-content">
                                                <?php
                                                echo do_shortcode('[wpforms id="' . $ap_vendor_contact . '"]');
                                                ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <?php if($ap_offer_price){ ?>
                                    <div class=" hightlight-box">
                                        <a class="highlight uk-flex uk-flex-between uk-flex-middle" href="#modal-center" data-uk-toggle>
                                <span>
                                    <?php echo esc_html($ap_offer_price_label);?>
                                </span>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                            if($ap_show_vendor){
                                ?>
                                <div class="ap-single-side-box ap-single-author-box widget">
                                    <h3 class="widget-title ap-group-title is-style-templaza-heading-style3">
                                        <span><?php esc_html_e('Vendor Profile','travelami');?></span>
                                    </h3>
                                    <div class="uk-card">
                                        <div class="author-header">
                                            <div class="uk-grid-small uk-flex-middle" data-uk-grid>
                                                <div class="uk-width-auto">
                                                    <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>">
                                                        <img class="" width="70" height="70" src="<?php echo esc_url( get_avatar_url( get_the_author_meta('ID'),150) ); ?>">
                                                    </a>
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h3 class="uk-card-title uk-margin-remove-bottom">
                                                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID')));?>">
                                                            <?php the_author();?>
                                                        </a>
                                                    </h3>
                                                    <p class="uk-text-meta uk-margin-remove-top"><?php echo esc_html($ap_count);?> <?php esc_html_e('Tours','travelami');?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="author-description">
                                            <?php the_author_meta('description'); ?>
                                            <div class="templaza-block-author-social uk-text-meta  uk-margin-top">
                                                <?php do_action('templaza_author_social');?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                if($ap_content_group_sticky){
                ?>
            </div>
        <?php
        }
        ?>
        </div>
        <?php
        if($ap_product_related){
            ?>
            <div class="uk-container <?php echo esc_attr($ap_tour_width);?>">
                <?php
                AP_Templates::load_my_layout('single.related');
                ?>
            </div>
            <?php
        }
        ?>
    </div>
<?php if($ap_offer_price){ ?>
    <div id="modal-center" class="uk-flex-top ap-modal" data-uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" data-uk-close></button>

            <div class="get-price">
                <?php
                if($ap_offer_price_form == 'custom'){
                    echo do_shortcode($ap_offer_form_custom);
                }else{
                    ?>
                    <h3 class="uk-modal-title"><?php echo esc_html(get_the_title($ap_offer_price_form)); ?></h3>
                    <?php
                    if(function_exists('wpforms')) {
                        echo do_shortcode('[wpforms id="' . $ap_offer_price_form . '"]');
                    }
                }
                ?>
            </div>

        </div>
    </div>
<?php } ?>
<?php if($ap_vendor_contact){ ?>
    <div id="modal-enquiry" class="uk-flex-top ap-modal" data-uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" data-uk-close></button>

            <div class="get-price">
                <?php
                if($ap_vendor_contact == 'custom'){
                    echo do_shortcode($ap_vendor_contact_custom);
                }else{
                    ?>
                    <h3 class="uk-modal-title"><?php echo esc_html($ap_vendor_title); ?></h3>
                    <?php
                    if(function_exists('wpforms')) {
                        echo do_shortcode('[wpforms id="' . $ap_vendor_contact . '"]');
                    }
                }
                ?>
            </div>

        </div>
    </div>
<?php } ?>