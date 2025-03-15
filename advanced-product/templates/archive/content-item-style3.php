<?php

defined('ADVANCED_PRODUCT') or exit();

use Advanced_Product\AP_Templates;
use Advanced_Product\AP_Functions;
use Advanced_Product\Helper\AP_Product_Helper;
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $templaza_options = array();
}else{
    $templaza_options = Functions::get_theme_options();
}
$price = get_field('ap_price', get_the_ID());
$ap_category = wp_get_object_terms( get_the_ID(), 'ap_category', array( 'fields' => 'names' ) );
$show_compare_button= get_field('ap_show_archive_compare_button', 'option');
$show_compare_button= $show_compare_button!==false?(bool)$show_compare_button:true;
$show_compare_button= isset($args['show_archive_compare_button'])?(bool)$args['show_archive_compare_button']:$show_compare_button;
$pid            = get_the_ID();
$compare_layout  = isset($args['compare_layout'])?$args['compare_layout']:'';
if(isset($args['ap_class'])){
    $ap_class = $args['ap_class'];
}else{
    $ap_class = ' templazaFadeInUp';
}
$ap_tax_before     = isset($templaza_options['ap_product-tax-style6'])?$templaza_options['ap_product-tax-style6']:'';
if($ap_tax_before !=''){
    $ap_taxs = get_the_terms( $pid, $ap_tax_before );
    $terms_string = join(', ', wp_list_pluck($ap_taxs, 'name'));
}else{
    $terms_string = '';
}

?>
<div class="ap-item ap-item-style3 <?php echo esc_attr($ap_class);?>">
    <div class="ap-inner ">
        <div class="ap-info">
            <div class="uk-inline uk-width-1-1 uk-position-relative ap-media-box">
                <?php AP_Templates::load_my_layout('archive.badges'); ?>
                <?php AP_Templates::load_my_layout('archive.media',true,false,array('compare_layout'    => $compare_layout)); ?>
            </div>
            <div class="ap-info-inner ap-info-top">
                <div class="ap-title-info">
                    <?php
                    if($terms_string !=''){
                        ?>
                        <span class="ap-before-title"><?php echo esc_html($terms_string);?></span>
                        <?php
                    }
                    ?>
                    <h2 class="ap-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                </div>
            </div>
            <div class="ap-info-inner ap-info-price">
                <?php AP_Templates::load_my_layout('archive.price');?>
                <div class="uk-flex uk-flex-middle ap-rating-box">
                    <?php
                    if (class_exists('Comment_Rating_Output')):
                        $aventura_rating = new Comment_Rating_Output();
                        $aventura_rating_html = $aventura_rating->display_average_rating('');
                        $aventura_count_rating_html = $aventura_rating->display_count_rating();
                        echo wp_kses($aventura_rating_html,'post');
                        echo wp_kses($aventura_count_rating_html,'post');
                    endif;
                    ?>
                </div>
            </div>
            <div class="ap-info-inner ap-info-fields ap-info-bottom">
                <?php AP_Templates::load_my_layout('archive.custom-fields-style3'); ?>
            </div>

        </div>
    </div>
</div>
<?php