<?php
if(!class_exists('travelami_Theme_Functions')){
    class travelami_Theme_Functions{
        public function __construct(){
            $this -> hook();
        }
        public static function locate_my_template($template_names, $load = false, $require_once = true, $args = array()){
            $located    = '';
            foreach ( (array) $template_names as &$template_name ) {
                if ( ! $template_name ) {
                    continue;
                }
                if(!preg_match('/\.php$/i', $template_name)){
                    $template_name  .= '.php';
                }
                if ( file_exists( get_template_directory() . '/templaza-framework/templates/' . $template_name ) ) {
                    $located = get_template_directory() . '/templaza-framework/templates/' . $template_name;
                    break;
                }
            }
            if($load && $located != '') {
                load_template($located, $require_once, $args);
            }

            return $located;
        }
        public function load_my_layout($partial, $load = true, $require_once = true, $args = array()){
            $partial    = str_replace('.', '/', $partial);
            $located    = self::locate_my_template((array) $partial, $load, $require_once, $args);
            return $located;
        }
        public function hook(){
            add_filter('user_contactmethods', array($this, 'templaza_modify_contact_methods'));
            add_filter('wp_kses_allowed_html', array($this, 'templaza_wpkses_post_tags'), 10, 2);
            add_filter('upload_mimes', array($this, 'templaza_mime_types'));
            add_filter('edit_post_link', array($this, 'templaza_edit_post_link'),10,3);
            add_filter('the_content_more_link', array($this, 'templaza_modify_read_more_link'));

            add_action('templaza_get_postviews',array($this,'templaza_get_post_views'));
            add_action('templaza_set_postviews',array($this,'templaza_set_post_views'));
            add_action('templaza_get_commentcount_post',array($this,'templaza_get_comment_count_post'));
            add_action('templaza_breadcrumb',array($this,'templaza_breadcrumbs'));
            add_action('templaza_share_post',array($this,'templaza_get_share_social'));
            add_action('templaza_pagination',array($this,'templaza_pagination'));
            add_action('templaza_gallery_post',array($this,'templaza_get_gallery_post'));
            add_action('templaza_image_post',array($this,'templaza_get_image_post'));
            add_action('templaza_video_post',array($this,'templaza_get_video_post'));
            add_action('templaza_audio_post',array($this,'templaza_get_audio_post'));
            add_action('templaza_title_post',array($this,'templaza_get_title_post'));
            add_action('templaza_meta_post_header',array($this,'templaza_get_meta_post_header'));
            add_action('templaza_meta_post_footer',array($this,'templaza_get_meta_post_footer'));
            add_action('templaza_link_post',array($this,'templaza_get_link_post'));
            add_action('templaza_quote_post',array($this,'templaza_get_quote_post'));
            add_action('templaza_excerpt_post',array($this,'templaza_get_excerpt_post'));
            add_action('templaza_readmore_post',array($this,'templaza_get_readmore_post'));
            add_action('templaza_single_title_post',array($this,'templaza_single_get_title_post'));
            add_action('templaza_single_meta_post',array($this,'templaza_single_get_meta_post'));
            add_action('templaza_single_tag_post',array($this,'templaza_single_get_tag_post'));
            add_action('templaza_single_next_post',array($this,'templaza_single_get_next_post'));
            add_action('templaza_single_author_post',array($this,'templaza_single_get_author_post'));
            add_action('templaza_single_related_post',array($this,'templaza_single_get_related_post'));
            add_action('templaza_author_social',array($this,'templaza_author_social'));
            add_action('templaza_search_no_result',array($this,'templaza_search_no_result'));
            add_action('templaza_archive_no_result',array($this,'templaza_archive_no_result'));
            add_action('templaza_all_taxonomy',array($this,'templaza_all_taxonomy'),10,2);
            add_action('templaza_post_taxonomy',array($this,'templaza_post_taxonomy'),10,1);
            add_filter('templaza_service_book',array($this,'templaza_service_book'),10,1);
            add_action('templaza_cause_donate_archive',array($this,'templaza_cause_donate_archive'),10,1);

        }
        public function templaza_modify_contact_methods($profile_fields)
        {
            $profile_fields['phone'] = esc_html__('Phone','travelami');
            $profile_fields['job'] = esc_html__('Job','travelami');
            $profile_fields['facebook'] = esc_html__('Facebook URL','travelami');
            $profile_fields['twitter'] = esc_html__('Twitter URL','travelami');
            $profile_fields['instagram'] = esc_html__('Instagram URL','travelami');
            $profile_fields['dribbble'] = esc_html__('Dribbble URL','travelami');
            $profile_fields['linkedin'] = esc_html__('Linkedin URL','travelami');
            $profile_fields['pinterest'] = esc_html__('Pinterest URL','travelami');
            $profile_fields['youtube'] = esc_html__('Youtube URL','travelami');
            $profile_fields['vimeo'] = esc_html__('Vimeo URL','travelami');
            $profile_fields['flickr'] = esc_html__('Flickr URL','travelami');
            $profile_fields['tumblr'] = esc_html__('Tumblr URL','travelami');
            $profile_fields['whatsapp'] = esc_html__('WhatsApp URL','travelami');
            return $profile_fields;
        }
        public function templaza_modify_read_more_link() {
            return '';
        }

        public function templaza_get_post_views($postID)
        {
            $args   = get_defined_vars();
            $this->load_my_layout('template-parts.content-views',true,false,$args);
        }

        function templaza_set_post_views($postID)
        {
            $count_key = 'post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if ($count == '') {
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            } else {
                $count++; // Incremental view
                update_post_meta($postID, $count_key, $count); // update count
            }
        }

        public function templaza_get_comment_count_post()
        {
            $templaza_comment_count = wp_count_comments(get_the_ID());
            if ($templaza_comment_count->approved == 1) {
                echo esc_html__('Comment:','travelami').' '.esc_html($templaza_comment_count->approved);
            }else{
                echo esc_html__('Comments:','travelami').' '.esc_html($templaza_comment_count->approved);
            }
        }

        public function templaza_wpkses_post_tags( $tags, $context ) {
            if ( 'post' === $context ) {
                $tags['iframe'] = array(
                    'src'             => true,
                    'height'          => true,
                    'width'           => true,
                    'frameborder'     => true,
                    'allowfullscreen' => true,
                    'data-uk-responsive' => true,
                    'data-uk-video' => true,
                );
                $tags['form'] = array(
                    'action'         => true,
                    'class'          => true,
                    'id'             => true,
                    'accept'         => true,
                    'accept-charset' => true,
                    'enctype'        => true,
                    'method'         => true,
                    'name'           => true,
                    'data-formid'         => true,
                    'target'         => true,
                    'novalidate'         => true,
                    'data-token'         => true,
                );
                $tags['input'] = array(
                    'class' => true,
                    'id'    => true,
                    'name'  => true,
                    'value' => true,
                    'type'  => true,
                    'placeholder'  => true,
                    'step'  => true,
                    'min'  => true,
                    'max'  => true,
                    'title'  => true,
                    'size'  => true,
                    'inputmode'  => true,
                    'autocomplete'  => true,
                );
                $tags['svg']      = array(
                    'id'           => true,
                    'class'        => true,
                    'width'        => true,
                    'height'       => true,
                    'viewbox'      => true,
                    'fill'         => true,
                    'xmlns'        => true,
                    'aria-hidden'  => true,
                    'stroke'       => true,
                    'stroke-width' => true,
                );
                $tags['path']     = array(
                    'd'               => true,
                    'fill'            => true,
                    'stroke'          => true,
                    'clip-rule'       => true,
                    'fill-rule'       => true,
                    'stroke-linecap'  => true,
                    'stroke-linejoin' => true,
                );
                $tags['g']        = array(
                    'clip-path' => true,
                );
                $tags['clipPath'] = array(
                    'id' => true,
                );
                $tags['defs']     = array();
                $tags['rect']     = array(
                    'id'     => true,
                    'width'  => true,
                    'height' => true,
                    'fill'   => true,
                );
            }

            return $tags;
        }

        function templaza_author_social () {
            $author_social = array(
                    'phone' => esc_html__('Phone','travelami'),
                    'facebook' => esc_html__('Join with US','travelami'),
                    'twitter' => esc_html__('Follow US','travelami'),
                    'instagram' => esc_html__('Our Instagram','travelami'),
                    'dribbble' => esc_html__('Our Dribbble','travelami'),
                    'linkedin' => esc_html__('Our Linkedin','travelami'),
                    'pinterest' => esc_html__('Our Pinterest','travelami'),
                    'youtube' => esc_html__('Our Youtube','travelami'),
                    'vimeo' => esc_html__('Our Vimeo','travelami'),
                    'flickr' => esc_html__('Our Flickr','travelami'),
                    'tumblr' => esc_html__('Our Tumblr','travelami'),
                    'whatsapp' => esc_html__('Our whatsapp','travelami')
            );
            foreach($author_social as $key=>$item){
                if(get_the_author_meta($key)){
                    if($key =='phone'){
                        ?>
                        <a class="uk-margin-right" href="tel:<?php echo esc_url(get_the_author_meta($key));?>" target="_blank">
                            <i class="fas fa-<?php echo esc_attr($key);?>"></i> <span><?php echo esc_html($item);?></span>
                        </a>
                        <?php
                    }else{
                    ?>
                        <a class="uk-margin-right" href="<?php echo esc_url(get_the_author_meta($key));?>" target="_blank">
                            <i class="fab fa-<?php echo esc_attr($key);?>"></i> <span><?php echo esc_html($item);?></span>
                        </a>
                    <?php
                    }
                }
            }
        }

        public function templaza_mime_types( $mimes ){
            $mimes['svg'] = 'image/svg+xml';
            return $mimes;
        }

        public function templaza_pagination() {
            the_posts_pagination( array(
                'type' => 'plain',
                'mid_size' => 2,
                'prev_text' => ent2ncr('<i class="fa fa-angle-double-left"></i>'),
                'next_text' => ent2ncr('<i class="fa fa-angle-double-right"></i>'),
                'screen_reader_text' => '',
            ) );
        }
        public function templaza_edit_post_link($link, $post_id, $text) {
            if ( is_admin() ) {
                return $link;
            }

            $edit_url = get_edit_post_link( $post_id );

            if ( ! $edit_url ) {
                return;
            }

            return '<span class="post-edit"><a href="' . esc_url( $edit_url ) . '">' . esc_html__('Edit','travelami') . '</a></span>';
        }

        public function templaza_get_share_social () {
            $this->load_my_layout('template-parts.content-share',true,false);
        }

        public function templaza_breadcrumbs() {
            $this->load_my_layout('template-parts.breadcrumb_html',true,false);
        }

        public function templaza_get_gallery_post() {
            $this->load_my_layout('template-parts.content-gallery',true,false);
        }

        public function templaza_get_image_post() {
            $this->load_my_layout('template-parts.content-image',true,false);
        }

        public function templaza_get_video_post() {
            $this->load_my_layout('template-parts.content-video',true,false);
        }

        public function templaza_get_audio_post() {
            $this->load_my_layout('template-parts.content-audio',true,false);
        }

        public function templaza_get_title_post() {

            $this->load_my_layout('template-parts.content-title',true,false);
        }

        public function templaza_get_meta_post_header() {
            $this->load_my_layout('template-parts.content-meta-header',true,false);
        }
	    public function templaza_get_meta_post_footer() {
		    $this->load_my_layout('template-parts.content-meta-footer',true,false);
	    }

        public function templaza_get_link_post() {
            $this->load_my_layout('template-parts.content-link',true,false);
        }

        public function templaza_get_quote_post() {
            $this->load_my_layout('template-parts.content-quote',true,false);
        }

        public function templaza_get_excerpt_post() {
            $this->load_my_layout('template-parts.content-excerpt',true,false);
        }

        public function templaza_get_readmore_post() {
            $this->load_my_layout('template-parts.content-readmore',true,false);
        }

        public function templaza_single_get_title_post() {
            $this->load_my_layout('template-parts.content-single-title',true,false);
        }

        public function templaza_single_get_meta_post() {
            $this->load_my_layout('template-parts.content-single-meta',true,false);
        }

        public function templaza_single_get_tag_post() {
            $this->load_my_layout('template-parts.content-single-tag',true,false);
        }

        public function templaza_single_get_next_post() {
            $this->load_my_layout('template-parts.content-single-next-preview',true,false);
        }

        public function templaza_single_get_author_post() {
            $this->load_my_layout('template-parts.content-single-author',true,false);
        }

        public function templaza_single_get_related_post() {
            $this->load_my_layout('template-parts.content-single-related',true,false);
        }

        public  function templaza_search_no_result( ) {
            $this->load_my_layout('template-parts.content-search-no-result', true, false);
        }

        public  function templaza_archive_no_result( ) {
            $this->load_my_layout('template-parts.content-archive-no-result', true, false);
        }

        public  function templaza_all_taxonomy( $taxonomy,$empty) {
            $args   = get_defined_vars();
            $this->load_my_layout('template-parts.all-taxonomy', true, false,$args);
        }

        public  function templaza_post_taxonomy( $taxonomy) {
            $args   = get_defined_vars();
            $this->load_my_layout('template-parts.post-taxonomy', true, false,$args);
        }

        public  function templaza_service_book($postID) {
            $args   = get_defined_vars();
            ob_start();
            $this->load_my_layout('template-parts.service-book', true, false,$args);
            $service_book = ob_get_contents();
            ob_end_clean();
            return $service_book;
        }

        public  function templaza_cause_donate_archive($postID) {
            $args   = get_defined_vars();
            $this->load_my_layout('template-parts.cause-donate', true, false,$args);
        }

    }

    $travelami_theme_functions = new travelami_Theme_Functions();

}