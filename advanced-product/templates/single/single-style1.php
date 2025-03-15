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
$ap_office_price           = isset($templaza_options['ap_product-office-price'])?$templaza_options['ap_product-office-price']:true;
$ap_office_price_label     = isset($templaza_options['ap_product-office-price-label'])?$templaza_options['ap_product-office-price-label']:'MAKE AN OFFICE PRICE';
$ap_office_price_form      = isset($templaza_options['ap_product-office-price-form'])?$templaza_options['ap_product-office-price-form']:'';
$ap_office_form_custom     = isset($templaza_options['ap_product-office-price-form-custom'])?$templaza_options['ap_product-office-price-form-custom']:'';
$ap_office_form_custom_url     = isset($templaza_options['ap_product-office-price-form-custom-url'])?$templaza_options['ap_product-office-price-form-custom-url']:'';
$ap_content_group     = isset($templaza_options['ap_product-single-group-content'])?$templaza_options['ap_product-single-group-content']:'';
$ap_vendor_contact     = isset($templaza_options['ap_product-vendor-contact'])?$templaza_options['ap_product-vendor-contact']:'';
$ap_vendor_contact_custom     = isset($templaza_options['ap_product-vendor-form-custom'])?$templaza_options['ap_product-vendor-form-custom']:'';
$ap_vendor_contact_custom_url     = isset($templaza_options['ap_product-vendor-form-custom-url'])?$templaza_options['ap_product-vendor-form-custom-url']:'';
$ap_vendor_title     = isset($templaza_options['ap_product-vendor-contact-label'])?$templaza_options['ap_product-vendor-contact-label']:__('Contact Vendor','travelami');
$show_compare_button= get_field('ap_show_compare_button', 'option');
$show_compare_button= $show_compare_button!==false?(bool)$show_compare_button:true;
$ap_show_vendor           = isset($templaza_options['ap_product-single-vendor'])?$templaza_options['ap_product-single-vendor']:true;
$ap_share           = isset($templaza_options['ap_product-single-share'])?$templaza_options['ap_product-single-share']:false;
$ap_share_label     = isset($templaza_options['ap_product-single-share-label'])?$templaza_options['ap_product-single-share-label']:'';
//$taxonomies=get_taxonomies('','names');
$taxonomies = get_object_taxonomies('ap_product');
$taxonomy_names = wp_get_object_terms(get_the_ID(), $taxonomies,  array("fields" => "names"));
do_action('templaza_set_postviews',get_the_ID());
$author_id = get_post_field( 'post_author', get_the_ID() );
$ap_count = count_user_posts( $author_id,'ap_product' );
?>
    <div class="templaza-ap-single uk-article">
        <div id="ap-single-wrap-sticky" class="uk-flex">
        <div id="ap-wrap-content" class="ap-content-single" data-uk-grid>
            <div class="uk-width-2-3@m uk-width-1-1 ap-content">
                <div class="ap-single-title uk-margin-medium-bottom">
                    <?php do_action('templaza_breadcrumb');
                    the_title( '<h1 class="ap-title tz-single-title">', '</h1>' );
                    ?>
                    <div class="ap-single-button-wrap uk-flex uk-flex-middle" >
                        <?php
                        if($show_compare_button) {
                            AP_Templates::load_my_layout('shortcodes.advanced-product.compare-button', true, false,
                                array('atts' => array('id' => get_the_ID())));
                        }
                        ?>
                        <?php if($ap_office_price){
                            if($ap_office_price_form == 'custom_url'){
                                ?>
                                <a class="ap-btn ap-register-form uk-flex uk-margin-small-left uk-flex-middle uk-flex-center" href="<?php echo esc_url($ap_office_form_custom_url);?>">
                                    <i class="fas fa-registered"></i>
                                    <?php echo esc_html($ap_office_price_label);?>
                                </a>
                                <?php
                            }else{
                                ?>
                                <a class="ap-btn ap-register-form uk-flex uk-margin-small-left uk-flex-middle uk-flex-center" href="#modal-center" data-uk-toggle>
                                    <i class="fas fa-registered"></i>
                                    <?php echo esc_html($ap_office_price_label);?>
                                </a>
                                <?php
                            }
                            ?>
                        <?php } ?>
                        <?php if($ap_share){ ?>
                            <div class="ap-btn ap-share uk-flex uk-flex-center  uk-flex-middle uk-animation-toggle uk-transition-toggle  uk-margin-small-left  uk-position-relative">
                                <i class="fas fa-share-alt"></i>
                                <?php echo esc_html($ap_share_label);?>
                                <div class="ap-share-item  uk-transition-slide-bottom-small">
                                    <a class="facebook" title="<?php esc_attr_e('Share on Facebook','travelami');?>" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_the_permalink(get_the_ID())); ?>">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="twitter" title="<?php esc_attr_e('Share on Twitter','travelami');?>" target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_the_permalink(get_the_ID())); ?>&text=<?php echo urlencode(get_the_title(get_the_ID())); ?>">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <?php $templaza_pin_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID())); ?>
                                    <a class="pinterest" title="<?php esc_attr_e('Share on Pinterest','travelami');?>"  data-pin-do="skipLink" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_attr($templaza_pin_image); ?>&description=<?php echo urlencode(get_the_title(get_the_ID())); ?>">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                    <a class="linkedin" title="<?php esc_attr_e('Share on Linkedin','travelami');?>"  target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=<?php the_permalink(get_the_ID()); ?>">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="ap-single-box ap-single-box-media">
                <?php AP_Templates::load_my_layout('single.media'); ?>
                </div>
                <div class="uk-width-1-3@m uk-width-1-1 ap-templaza-sidebar uk-hidden@m">
                    <div class="ap-sidebar-inner">
                        <div class="ap-single-price-box ap-single-side-box ">
                            <?php
                            AP_Templates::load_my_layout('single.price');
                            if($ap_vendor_contact == 'custom_url'){
                                ?>
                                <div class=" hightlight-box">
                                    <a target="_blank" class="highlight templaza-btn uk-flex uk-flex-between uk-flex-middle" href="<?php echo esc_url($ap_vendor_contact_custom_url);?>">
                                    <span>
                                        <?php echo esc_html($ap_vendor_title);?>
                                    </span>
                                    </a>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class=" hightlight-box">
                                    <a class="highlight templaza-btn uk-flex uk-flex-between uk-flex-middle" href="#vendor">
                                    <span>
                                        <?php echo esc_html($ap_vendor_title);?>
                                    </span>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        AP_Templates::load_my_layout('single.custom-fields');
                        ?>
                    </div>
                </div>
                <?php AP_Templates::load_my_layout('single.meta');?>

                <?php if ( !empty( get_the_content() ) ){ ?>
                    <div class="ap-single-box ap-single-content">
                        <?php
                        the_content();
                        ?>
                    </div>
                <?php
                }
                if($ap_content_group !=''){
                    AP_Templates::load_my_layout('single.group-fields-content');
                }else{
                ?>
                    <div class="templaza-single-comment ap-single-box">
                        <?php comments_template('', true); ?>
                    </div>
                    <?php
                }
                ?>
                <div class="uk-width-1-3@m uk-width-1-1 ap-templaza-sidebar uk-margin-medium-top uk-hidden@m">
                    <div class="ap-sidebar-inner">
                        <div id="vendormb"  class="ap-single-side-box ap-single-author-box  ap-single-author-box-mb widget">

                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-3@m ap-templaza-sidebar uk-visible@m">
                <div class="ap-sidebar-inner" data-uk-sticky="end: .ap-content-single; offset:150; media: @m">
                    <div class="ap-single-price-box ap-single-side-box ">
                        <?php
                        AP_Templates::load_my_layout('single.price');
                        if($ap_vendor_title !='' && $ap_vendor_contact !=''){
                            if($ap_vendor_contact == 'custom_url'){
                                ?>
                                <div class=" hightlight-box">
                                    <a target="_blank" class="highlight templaza-btn uk-flex uk-flex-between uk-flex-middle" href="<?php echo esc_url($ap_vendor_contact_custom_url);?>">
                                    <span>
                                        <?php echo esc_html($ap_vendor_title);?>
                                    </span>
                                    </a>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div class=" hightlight-box">
                                    <a class="highlight templaza-btn uk-flex uk-flex-between uk-flex-middle" href="#vendor">
                                    <span>
                                        <?php echo esc_html($ap_vendor_title);?>
                                    </span>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <?php
                    AP_Templates::load_my_layout('single.custom-fields');
                    ?>
                    <?php
                    if($ap_show_vendor || $ap_vendor_contact !=''){
                    ?>
                    <div id="vendor"  class="ap-single-side-box ap-single-author-box widget">

                        <div class="uk-card">
                            <?php
                            if($ap_show_vendor){
                                $pageid         = (int)get_option('options_dealership_dealer_page_id',0);
                                $pageid         = !empty($pageid)?$pageid:get_the_ID();
                                $user_login = get_the_author_meta('user_login');
                                $url            = get_permalink($pageid).$user_login;
                            ?>
                            <div class="author-header">
                                <div class="uk-grid-small uk-flex-middle" data-uk-grid>
                                    <div class="uk-width-auto">
                                        <a href="<?php echo esc_url($url);?>">
                                            <img class="uk-border-circle" width="100" height="100" alt="<?php the_author();?>" src="<?php echo esc_url( get_avatar_url( get_the_author_meta('ID'),150) ); ?>">
                                        </a>
                                    </div>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom">
                                            <a href="<?php echo esc_url($url);?>">
                                                <?php the_author();?>
                                            </a>
                                        </h3>
                                        <p class="uk-text-meta uk-margin-remove-top"><?php echo esc_html($ap_count);?> <?php esc_html_e('Tours','travelami');?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="author-description">
                                <?php
                                    the_author_meta('description',$author_id);
                                ?>
                                <div class="templaza-block-author-social uk-text-meta  uk-margin-top">
                                    <?php
                                    do_action('templaza_author_social');?>
                                </div>
                            </div>
                                <?php
                            }
                                ?>
                            <?php if($ap_vendor_title !='' && $ap_vendor_contact !='' && $ap_vendor_contact !='custom_url' ){
                                ?>
                                <h3 class="widget-title ap-group-title is-style-templaza-heading-style1">
                                    <span><?php echo esc_html($ap_vendor_title);?></span>
                                </h3>
                                <?php
                            }
                            ?>
                            <?php if(function_exists('wpforms') && $ap_vendor_contact !='' && $ap_vendor_contact !='custom_url') {
                                if($ap_vendor_contact =='custom'){
                                    echo do_shortcode($ap_vendor_contact_custom);
                                }else{
                                    echo do_shortcode('[wpforms id="' . $ap_vendor_contact . '"]');
                                }
                            }
                            ?>
                        </div>
                    </div>
                        <?php
                    }
                        ?>
                </div>
            </div>
        </div>
        </div>
        <?php
        AP_Templates::load_my_layout('single.related');
        ?>
    </div>
<?php if($ap_office_price && $ap_office_price_form !='custom_url'){ ?>
    <div id="modal-center" class="uk-flex-top ap-modal" data-uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" data-uk-close></button>

            <div class="get-price">
                <?php
                if($ap_office_price_form == 'custom'){
                    echo do_shortcode($ap_office_form_custom);
                }else{
                    if(function_exists('wpforms')) {
                        ?>
                        <h3 class="uk-modal-title"><?php echo esc_html(get_the_title($ap_office_price_form)); ?></h3>
                        <?php
                        echo do_shortcode('[wpforms id="' . $ap_office_price_form . '"]');
                    }
                }
                ?>
            </div>

        </div>
    </div>
<?php } ?>