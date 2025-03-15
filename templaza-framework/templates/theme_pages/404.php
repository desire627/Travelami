<?php
use TemPlazaFramework\CSS;
use TemPlazaFramework\Functions;
use TemPlazaFramework\Templates;

$error = new WP_Error();
if ( !class_exists( 'TemPlazaFramework\TemPlazaFramework' )){
    $options = array();
}else{
    $options            = Functions::get_theme_options();
}
$errorContent   = isset($options['404-content'])?$options['404-content']:'';
$errorButton    = isset($options['404-call-to-action'])?$options['404-call-to-action']:'Back to Home';
// Background Image
$background_setting_404    = isset($options['404-background-setting'])?$options['404-background-setting']:0;
$background_overlay    = isset($options['404-background-overlay'])?$options['404-background-overlay']:'';
$title_color    = isset($options['404-title-color'])?$options['404-title-color']:'';
$title_color     = CSS::make_color_rgba_redux($title_color);
$text_color    = isset($options['404-text-color'])?$options['404-text-color']:'';
$text_color     = CSS::make_color_rgba_redux($text_color);
$input_bg_color    = isset($options['404-input-bg'])?$options['404-input-bg']:'';
$input_bg_color     = CSS::make_color_rgba_redux($input_bg_color);
$input_color    = isset($options['404-input-color'])?$options['404-input-color']:'';
$input_color     = CSS::make_color_rgba_redux($input_color);
$styles = '';
$style_overlay = '';
$video  = [];
$color_css = [];
if (!empty($title_color)) {
    $color_css[]    = '
    .templaza-error-page h1 span{color:' . $title_color . ';}';
}
if (!empty($text_color)) {
    $color_css[]    = '
    .templaza-error-page h3, .templaza-error-page {color:' . $text_color . ';}';
}
if (!empty($input_bg_color)) {
    $color_css[]    = '
    .templaza-error-page .searchform input[type="text"]{background-color:' . $input_bg_color . ';}';
}
if (!empty($input_color)) {
    $color_css[]    = '
    .templaza-error-page .searchform input[type="text"]{color:' . $input_color . ';}';
}
if (!empty($color_css)) {
    Templates::add_inline_style(implode('', $color_css));
}
if($background_setting_404){
    if($background_setting_404 =="color"){
        $background_color_404 = isset($options['404-background-color'])?$options['404-background-color']:'';

        if (!empty($background_color_404)) {
            $bg_color   = CSS::make_color_rgba($background_color_404['color'], $background_color_404['alpha'],
                $background_color_404['rgba']);
            if(!empty($bg_color)) {
                $styles = 'background-color:' . $bg_color;
            }
        }
    }
    if($background_setting_404 =="image"){
        $background_404 = isset($options['404-background'])?$options['404-background']:array();
        if(count($background_404)){
            $styles .= CSS::background('', $background_404['background-image'],
                $background_404['background-repeat'], $background_404['background-attachment'],
                $background_404['background-position'], $background_404['background-size']);
        }
    }

    if($background_setting_404 =="video"){
        $attributes = [];
        $background_video_404 = isset($options['404-background-video'])?$options['404-background-video']:array();

        if (count($background_video_404) && !empty($background_video_404['url'])) {
            $attributes['data-templaza-video-bg'] = $background_video_404['url'];
            wp_enqueue_script('tzfrm_templazavideobg', Functions::get_my_url().'/assets/js/vendor/jquery.templazavideobg.js');
        }

        $return = [];
        foreach ($attributes as $key => $value) {
            $return[] = $key . '="' . $value . '"';
        }
        $video =  $return;
    }
    if (!empty($background_overlay)) {
        $bg_overlay   = CSS::make_color_rgba($background_overlay['color'], $background_overlay['alpha'],
            $background_overlay['rgba']);
        if(!empty($bg_overlay)) {
            $style_overlay = 'background-color:' . $bg_overlay;
        }
    }

    if(!empty($styles)){
        Templates::add_inline_style('.templaza-error-page{'.$styles.'}');
    }
    if(!empty($style_overlay)){
        Templates::add_inline_style('.templaza-error-page::before{'.$style_overlay.'}');
    }
}
?>
    <div class="templaza-error-page uk-text-center">
        <div class="uk-flex uk-flex-middle uk-height-1-1" data-uk-height-viewport="">
            <div class="page-404">
            <?php
            if (!empty($errorContent)) {
                $errorContent   = str_replace('{errorcode}', $error -> get_error_code(), $errorContent);
                $errorContent   = str_replace('{errormessage}', htmlspecialchars($error ->get_error_message(), ENT_QUOTES, 'UTF-8'), $errorContent);
                echo  wp_kses($errorContent,'post');
                get_search_form();
            } else{
            ?>
                <h1 class="uk-heading-2xlarge"><?php esc_html_e('4','travelami');?><span><?php esc_html_e('0','travelami');?></span><?php esc_html_e('4','travelami');?></h1>
                <h3 class="uk-heading-small"><?php esc_html_e('Opps !!! Sorry, This Page is not Found','travelami');?></h3>
                <?php get_search_form(); ?>
            <?php
            }
            ?>
            <div class="uk-margin-medium-top ">
                <a class="templaza-btn btn-backtohome" href="<?php echo esc_url(get_home_url()); ?>" role="button"><?php echo esc_html($errorButton); ?></a>
            </div>

            </div>
        </div>
    </div>
