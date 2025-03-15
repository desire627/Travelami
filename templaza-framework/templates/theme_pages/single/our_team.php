<?php
defined('TEMPLAZA_FRAMEWORK');
use TemPlazaFramework\Functions;
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $travelami_options = array();
}else{
    $travelami_options            = Functions::get_theme_options();
}
?>
<div id="templaza-single-<?php echo esc_attr(get_the_ID()); ?>" class="templaza-single templaza-single-<?php
echo esc_attr(get_post_type(get_the_ID())); ?>">
    <div class="single-box single-content-box">
        <?php the_content();?>
    </div>
</div>
