<?php

add_action('wp_ajax_nopriv_wp_lr_recover_password', 'wp_lr_recover_password');

function wp_lr_recover_password()
{
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'])) {
        die('Access Denied !!!');
    }
    $email = sanitize_text_field($_POST['email']);
    wp_lr_validate_email($email);
    $recover_email_link = wp_lr_genarate_recover_email_link($email);
    // var_dump($recover_email);
    $send_recover_email = wp_lr_send_recover_password_email($email, $recover_email_link);
    if ($send_recover_email) {
        wp_send_json([
            'success' => true,
            'message' => 'لینک بازیابی کلمه عبور به ایمیل شما ارسال گردید.',
        ], 200);
    } else {
        wp_send_json([
            'error' => true,
            'message' => 'خطایی در ارسال ایمیل صورت گرفته است.',
        ], 403);
    }
}

function wp_lr_genarate_recover_email_link($email)
{
    $token = date('Ymd') . md5($email) . rand(100000, 999999);
    // return $recover_link = site_url('recover-password') . '?recoverToken=' . $token;
    return add_query_arg([
        'recoverToken' => $token,
    ], site_url('recover-password'));
}

function wp_lr_validate_email($email)
{
    if ($email == '') {
        wp_send_json([
            'error' => true,
            'message' => 'ایمیل خود را وارد نمایید.'
        ], 403);
    }
    if (!is_email($email)) {
        wp_send_json([
            'error' => true,
            'message' => 'ایمیل معتبر وارد نمایید.'
        ], 403);
    }
    if (!email_exists($email)) {
        wp_send_json([
            'error' => true,
            'message' => 'کاربری با ایمیل وارد شده یافت نشد.'
        ], 403);
    }
}

function wp_lr_send_recover_password_email($email, $recover_email_link)
{
    $header = ['Content-Type:text/html;charset=UTF-8'];
    wp_mail($email, 'بازیابی کلمه عبور', $recover_email_link, $header);
}
