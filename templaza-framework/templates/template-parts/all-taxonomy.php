<?php
defined('ABSPATH') or exit();
if($args){
    $terms = get_terms( array(
        'taxonomy' => ''.$args['taxonomy'].'',
        'hide_empty'   => $args['empty']
    ) );
    if($terms){
        echo '<h5>'.esc_html__('Topic', 'travelami').'</h5>';
        ?>
        <ul class="uk-nav uk-nav-default">
        <?php
        echo '<li class="uk-margin-remove uk-active" data-uk-filter-control><a href="#">'.esc_html__('Show All', 'travelami').'</a></li>';
        foreach ($terms as $item){
            ?>
            <li class="uk-margin-remove" data-uk-filter-control="[data-tag*='<?php echo esc_attr($item->slug);?>']">
                <a href="#">
                    <?php echo esc_html($item->name);?>
                </a>
            </li>
            <?php
        }
        ?>
        </ul>
<?php
    }
}
?>