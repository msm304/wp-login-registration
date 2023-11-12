<?php
function wp_ls_register_menu()
{
    add_options_page(
        'تنظیمات پلاگین لایک مطالب',
        'لایک مطالب',
        'manage_options',
        'like-post-setting',
        'wp_ls_like_post_admin_layout',

    );
}

include_once LS_PLUGIN_DIR . '_inc/setting/setting.php';
add_action('admin_menu', 'wp_ls_register_menu');