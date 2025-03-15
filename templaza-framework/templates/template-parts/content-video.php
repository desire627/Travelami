<?php
defined('ABSPATH') or exit();
$video_embed        =   get_post_meta(get_the_ID(), '_format_video_embed', true);
$video_autoplay     =   get_post_meta(get_the_ID(), '_format_video_autoplay', true);
$video_loop         =   get_post_meta(get_the_ID(), '_format_video_loop', true);
$video_muted        =   get_post_meta(get_the_ID(), '_format_video_muted', true);
$video_autopause    =   get_post_meta(get_the_ID(), '_format_video_autopause', true);
$video_byline       =   get_post_meta(get_the_ID(), '_format_video_byline', true);
$video_title        =   get_post_meta(get_the_ID(), '_format_video_title', true);
$video_portrait     =   get_post_meta(get_the_ID(), '_format_video_portrait', true);
$video_controls     =   get_post_meta(get_the_ID(), '_format_video_controls', true);
$video_related      =   get_post_meta(get_the_ID(), '_format_video_related', true);
$video_cookie       =   get_post_meta(get_the_ID(), '_format_video_cookie', true);
if ($video_embed != ''):
	$autoplay       =   (isset($video_autoplay)) ? $video_autoplay : 0;
	$loop           =   (isset($video_loop)) ? $video_loop : 0;
	$muted          =   (isset($video_muted)) ? $video_muted : 0;
	$autopause      =   (isset($video_autopause)) ? $video_autopause : 1;
	$byline         =   (isset($video_byline)) ? $video_byline : 1;
	$video_title    =   (isset($video_title)) ? $video_title : 1;
	$portrait       =   (isset($video_portrait)) ? $video_portrait : 1;
	$controls       =   (isset($video_controls)) ? $video_controls : 1;
	$no_cookie      =   (isset($video_cookie)) ? $video_cookie : 0;
	$show_rel_video =   (isset($video_related) && $video_related) ? '&rel=1' : '&rel=0';
	$attrb[]  = 'autoplay='.$autoplay;
	$attrb[]  = 'loop='.$loop;
	$attrb[]  = 'muted='.$muted;
	$attrb[]  = 'mute='.$muted;
	$attrb[]  = 'autopause='.$autopause;
	$attrb[]  = 'title='.$video_title;
	$attrb[]  = 'byline='.$byline;
	$attrb[]  = 'portrait='.$portrait;
	$attrb[]  = 'controls='.$controls;
    ?>
    <div class="templaza-blog-item-media templaza-blog-item-video">
        <?php
        if (wp_oembed_get($video_embed)) :
	        $video = parse_url($video_embed);
	        $youtube_no_cookie = $no_cookie ? '-nocookie' : '';
	        switch($video['host']) {
		        case 'youtu.be':
			        $id = trim($video['path'],'/');
			        $src = '//www.youtube'.$youtube_no_cookie.'.com/embed/' . $id .'?iv_load_policy=3'.$show_rel_video.'&amp;'.implode('&amp;', $attrb).($loop ? '&amp;playlist='. $id : '');
			        break;

		        case 'www.youtube.com':
		        case 'youtube.com':
			        parse_str($video['query'], $query);
			        $id = $query['v'];
			        $src = '//www.youtube'.$youtube_no_cookie.'.com/embed/' . $id .'?iv_load_policy=3'.$show_rel_video.'&amp;'.implode('&amp;', $attrb).($loop ? '&amp;playlist='. $id : '');
			        break;

		        case 'vimeo.com':
		        case 'www.vimeo.com':
			        $id = trim($video['path'],'/');
			        $src = "//player.vimeo.com/video/{$id}?".implode('&amp;', $attrb);
	        }
	        echo '<div class="tz-embed-responsive tz-embed-responsive-16by9">';
	        echo '<iframe class="tz-embed-responsive-item" src="'.esc_url($src).'" allowFullScreen loading="lazy"></iframe>';
	        echo '</div>';
         else :
             echo wp_kses_post($video_embed);
        endif;
        ?>
    </div>
<?php endif; ?>