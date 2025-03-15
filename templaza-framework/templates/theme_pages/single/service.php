<?php
defined('TEMPLAZA_FRAMEWORK');
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $travelami_options = array();
}else{
    $travelami_options            = Functions::get_theme_options();
}
$args = array(
    'post_type'=> 'service',
    'numberposts' => -1
);
$services = get_posts($args);
$service_id = get_the_ID();
$book_form      = isset($travelami_options['travelami_service_form'])?$travelami_options['travelami_service_form']:'';
?>
<div id="templaza-single-<?php echo esc_attr(get_the_ID()); ?>" class="templaza-single templaza-single-<?php
echo esc_attr(get_post_type(get_the_ID())); ?>">
    <?php
    if($services ) :
    ?>
    <div data-uk-grid>
        <div class="uk-width-2-3@s">
            <div id="component-nav" class="uk-switcher single-box single-content-box">
                <?php
                foreach ( $services as $service ) :
                    $svid = $service->ID;
                    $post = get_post($svid);
                    $the_content = apply_filters('the_content', $post->post_content);

                ?>
                    <div>
                        <h1 class="single-title">
                            <?php echo get_the_title($svid); ?>
                        </h1>
                        <?php
                        if ( !empty($the_content) ) {
                            echo $the_content;
                        }
                        if($book_form){
                            ?>
                            <div class="uk-flex uk-margin-top">
                                <a class="templaza-btn wp-block-buttons uk-flex" href="#modal-center-service-book" data-uk-toggle>
                                    <?php echo esc_html__('Book This Car','travelami');?>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        </div>
        <div class="uk-width-1-3@s templaza-service-left uk-flex-first@s">
            <ul class="uk-nav single-box single-sidebar-box uk-nav-default" data-uk-switcher="connect: #component-nav;animation: uk-animation-fade">
                <?php $d=1;
                foreach ( $services as $service ) :
                    $svid = $service->ID;
                    ?>
                    <li class="title <?php if($service_id==$svid){echo 'uk-active';}?>"><a href="#"><?php echo get_the_title($svid);?><i class="fas fa-angle-right"></i></a></li>
                    <?php $d++;
                endforeach;
                ?>
            </ul>
            <div class="single-box single-sidebar-box image">
                <?php
                if (is_active_sidebar('sidebar-service')){
                    dynamic_sidebar('sidebar-service');
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    endif;
    wp_reset_postdata();
    ?>
</div>
