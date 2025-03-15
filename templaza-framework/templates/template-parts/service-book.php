<?php
defined('ABSPATH') or exit();

use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $options = array();
}else{
    $options            = Functions::get_theme_options();
}
$book_form      = isset($options['travelami_service_form'])?$options['travelami_service_form']:'';
if($args){

    global $wpdb;
    $serviceID = $args['postID'];
    $posttype= get_post_type($serviceID);
    if($posttype !='service'){
        return;
    }
    ?>
        <div class="uk-flex uk-margin-top">
            <a class="templaza-btn wp-block-buttons uk-flex book-service" data-url="<?php echo esc_attr(get_the_permalink($serviceID));?>" data-title="<?php echo esc_attr(get_the_title($serviceID));?>" href="#modal-center-service-book" data-uk-toggle>
                <?php echo esc_html__('Book This Car','travelami');?>
            </a>
        </div>
    <?php
}