<?php
defined('ABSPATH') or exit();
if($args){
    $terms = wp_get_post_terms( get_the_ID(),''.$args['taxonomy'].'',array( 'fields' => 'all' ) );
    if($terms){
        foreach ($terms as $item){
            ?>
                <a href="<?php echo esc_url(get_term_link($item->slug,$args['taxonomy']));?>">
                    <?php echo esc_html($item->name);?>
                </a>
            <?php
        }
    }
}
?>