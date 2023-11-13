<?php

add_action('wp_ajax_nopriv_wp_lr_auth_send_verification_code', 'wp_lr_auth_send_verification_code');
add_action('wp_ajax_nopriv_wp_lr_auth_verify_verification_code', 'wp_lr_auth_verify_verification_code');

function wp_lr_auth_send_verification_code()
{
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'])) {
        die('Access Denied !!!');
    }
    $user_phone = sanitize_text_field($_POST['user_phone']);
    wp_lr_validate_phone($user_phone);
    $verification_code = generate_verification_code();
    // var_dump($verification_code);
    wp_ls_send_sms($verification_code, $user_phone, '148875');
    wp_lr_add_verification_code($verification_code);
}

function wp_lr_auth_verify_verification_code()
{
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'])) {
        die('Access Denied !!!');
    }
    $verification_code = sanitize_text_field($_POST['verification_code']);
    wp_lr_validate_verification_code($verification_code);
    wp_lr_check_user_verification_code($verification_code);
}



function wp_lr_check_user_verification_code($verification_code)
{
    global $wpdb;
    $table = $wpdb->prefix . 'lr_sms_verify_code';
    $stmt = $wpdb->get_row($wpdb->prepare("SELECT verification_code FROM {$table} WHERE verification_code = '%d'", $verification_code));
    if ($stmt) {
        wp_send_json([
            'error' => true,
            'message' => 'کد تایید معتبر می باشد.'
        ], 200);
    } else {
        wp_send_json([
            'error' => true,
            'message' => 'کد تایید معتبر نمی باشد.'
        ], 403);
    }
}

function wp_lr_validate_verification_code($verification_code)
{
    if ($verification_code == '') {
        wp_send_json([
            'error' => true,
            'message' => 'کد تایید دریافتی را وارد نمایید.'
        ], 403);
    }
    if (strlen($verification_code) !== 6) {
        wp_send_json([
            'error' => true,
            'message' => 'کد تایید باید شامل ۶ رقم باشد.'
        ], 403);
    }
}

function wp_lr_validate_phone($phone)
{
    if (!preg_match('/^(00|09|\+)[0-9]{8,12}$/', $phone)) {
        wp_send_json([
            'error' => true,
            'message' => 'لطفا شماره موبایل معتبر وارد نمایید!'
        ], 403);
    }
}
