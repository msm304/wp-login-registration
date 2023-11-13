<?php

/*
Plugin Name: پلاگین لاگین و ثبت نام
Plugin URI: https://owebra.com/plugins/wp-login-registration
Description: پلاگین لاگین و ثبت نام به صورت پیامکی
Author: Amirhosein Soltani
Version: 1.0.0
Licence: GPLv2 or Later
Author URI: https://owebra.com/resume
*/

defined('ABSPATH') || exit;

define('LR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LR_PLUGIN_URL', plugin_dir_url(__FILE__));

function wp_lr_register_assets()
{
    // css
    wp_register_style('slick', LR_PLUGIN_URL . '/assets/css/front/slick.css', '', '1.6.0');
    wp_enqueue_style('slick');

    wp_register_style('slick-theme', LR_PLUGIN_URL . '/assets/css/front/slick-theme.css', '', '1.6.0');
    wp_enqueue_style('slick-theme');

    wp_register_style('lr-style', LR_PLUGIN_URL . '/assets/css/front/front-style.css', '', '1.0.0');
    wp_enqueue_style('lr-style');

    // script
    wp_register_script('toast-js', LR_PLUGIN_URL . '/assets/js/front/jquery.toast.js', ['jquery'], '1.0.0', true);
    wp_enqueue_script('toast-js');

    wp_register_script('slick', LR_PLUGIN_URL . '/assets/js/front/slick.js', ['jquery'], '1.6.0', true);
    wp_enqueue_script('slick');

    wp_register_script('lr-main-js', LR_PLUGIN_URL . '/assets/js/front/main.js', ['jquery'], '1.0.0', true);
    wp_enqueue_script('lr-main-js');

    wp_enqueue_script('lr-ajax-js', LR_PLUGIN_URL . '/assets/js/front/ajax.js', ['jquery'], '1.0.0', true);

    wp_localize_script('lr-ajax-js', 'lr_ajax', [
        'lr_ajaxurl' => admin_url('admin-ajax.php'),
        '_lr_nonce' => wp_create_nonce(),
    ]);
}

function wp_lr_register_assets_admin()
{
    // css
    wp_register_style('lr-admin-style', LR_PLUGIN_URL . '/assets/css/admin/admin-style.css', '', '1.0.0');
    wp_enqueue_style('lr-admin-style');

    // js
    wp_register_script('lr-admin-js', LR_PLUGIN_URL . '/assets/js/admin/admin-js.js', ['jquery'], '1.0.0', true);
    wp_enqueue_script('lr-admin-js');
};

add_action('wp_enqueue_scripts', 'wp_lr_register_assets');
add_action('admin_enqueue_scripts', 'wp_lr_register_assets_admin');

// Inc files
include_once LR_PLUGIN_DIR . '/view/front/login.php';
include_once LR_PLUGIN_DIR . '/_inc/register.php';
include_once LR_PLUGIN_DIR . '/_inc/login.php';
include_once LR_PLUGIN_DIR . '/_inc/sendSms.php';
include_once LR_PLUGIN_DIR . '/_inc/helper.php';
include_once LR_PLUGIN_DIR . '/_inc/sms-function.php';

register_activation_hook(__FILE__, 'wp_lr_set_setting');
register_deactivation_hook(__FILE__, 'wp_lr_delete_setting');


