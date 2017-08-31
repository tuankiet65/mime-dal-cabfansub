<?php

// Add parent stylesheet
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles' );
function child_enqueue_styles() {
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

// Add translation
add_action( 'after_setup_theme', 'child_translation_setup' );
function child_translation_setup() {
    load_child_theme_textdomain( 'mime-dal-customized', get_stylesheet_directory() . '/languages');
}

// ====================================================
// Add Thumbnails in Manage Posts/Pages List
// ====================================================
function AddThumbColumn($cols) {
     $cols['thumbnail'] = __('Thumbnail', 'mime-dal-customized');
    return $cols;
}

function AddThumbValue($column_name, $post_id) {
    $width = (int)50;
    $height = (int)50;
    if ( 'thumbnail' == $column_name ) {
        $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
        $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
        if ($thumbnail_id)
            $thumb = wp_get_attachment_image($thumbnail_id, array($width, $height),true);
        elseif ($attachments) {
             foreach ( $attachments as $attachment_id => $attachment ) {
                 $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
            }
        }
        if ( isset($thumb) && $thumb ) {
            echo $thumb;
        } else {
             echo __('None', 'mime-dal-customized');
        }
    }
}
 
// for posts
add_filter('manage_posts_columns','AddThumbColumn');
add_action('manage_posts_custom_column','AddThumbValue',10, 2);
// for pages
add_filter('manage_pages_columns','AddThumbColumn');
add_action('manage_pages_custom_column','AddThumbValue',10,2);

// Change logo on login page and add favicon to login page
function login_custom_logo(){
    echo '<style type="text/css"> h1 a { background-image: url("'.get_stylesheet_directory_uri().'/materials/login-logo.png"), none !important; } </style>';
    echo '<link rel="icon" href="'.get_stylesheet_directory_uri().'/materials/header-logo.png" type="image/png"/>';
}
add_action("login_head", "login_custom_logo");

// Unhook functions
add_action("wp_loaded", "remove_unnecessary");
function remove_unnecessary(){
    // Remove "MIMIC-Project" menu item
    remove_filter('wp_nav_menu_items', 'add_mimic_link');
    // Remove Yoast SEO's title rewrite; replaced by custom title rewrite
    if (class_exists('WPSEO_Frontend')){
        remove_filter('wp_title', array(WPSEO_Frontend::get_instance(), 'title'), 15);
    }
}

// Custom title rewrite filter
add_filter('wp_title', 'title_rewrite', 10, 1);
function title_rewrite($title){
    $paged=get_query_var( 'paged', 1 );
    $page=get_query_var( 'page', 1 );
    $sep=" | ";
    $blog_name=get_bloginfo("name");
    $title=trim($title).$sep.$blog_name;
    if (is_home() || is_front_page()){
        $title=$blog_name;
        if (bloginfo("description"))
            $title=$title.$sep.bloginfo("description");
        return $title;
    }
    if (is_404()){
        $title=__("Not Found", "mime-dal").$sep.$blog_name;
        return $title;
    }
    if (is_singular())
        return $title;
    if (is_category())
        return __("Category: ", "mime-dal-customized").$title;
    if (is_tag())
        return __("Tag: ", "mime-dal-customized").$title;
    if (is_author())
        return __("Author: ", "mime-dal-customized").$title;
    if (is_date())
        return __("Date archive: ", "mime-dal-customized").$title;
    if (is_search()) {
        $title=get_search_query().$sep.$blog_name;
        return __("Search result for: ", "mime-dal-customized").$title;
    }
    if ( $paged >= 2 || $page >= 2 )
        return $sep.sprintf( __('Page %s', "mime-dal-customized"), max( $paged, $page ) );
}

// Custom credit
function noel_credit() {
    echo "
        <div id='ex-note'>
            CFS - Nơi thả hồn vào những giấc mơ.
            <br/>
            Trang web sử dụng <a href='http://wordpress.org'>WordPress</a>.
            Theme được tạo bởi <a href='http://mimic-project.com'>MIMIC-Project</a> với một số chỉnh sửa.
            <br/>
            Hình nền: <a href='https://www.pixiv.net/member_illust.php?mode=medium&illust_id=44867032'>Pixiv 44867032</a>
        </div>";
}

// Custom background
// https://developer.wordpress.org/reference/functions/add_theme_support/#custom-background
// https://codex.wordpress.org/Custom_Backgrounds
$custom_background_defaults = array(
    'default-image' => get_stylesheet_directory_uri() . '/materials/kurumi-background.jpg',
    'default-preset' => 'fill',
    'default-position-x' => 'center',
    'default-position-y' => 'top',
    'wp-head-callback' => 'custom_background_callback'
);

function custom_background_callback() {
    if (is_404() || is_front_page()) {
        return;
    } else {
        _custom_background_cb();
    }
}

add_theme_support( 'custom-background', $custom_background_defaults );
