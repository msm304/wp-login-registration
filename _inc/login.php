<?php

add_action('wp_ajax_nopriv_wp_lr_auth_login', 'wp_lr_auth_login');
function wp_lr_auth_login()
{
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'])) {
        die('Access Denied !!!');
    }
    $email = sanitize_text_field($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $remember_me = rest_sanitize_boolean($_POST['remember_me']);
    // var_dump($remember_me);
    wp_lr_validate_input($email, $password);

    $user_login = get_user_by('email', $email);
    $user_login = $user_login->user_login;
    $creds = [
        'user_login' => sanitize_user($user_login),
        'user_password' => $password,
        'remember_me' => $remember_me,
    ];

    $user = wp_signon($creds, false);

    if (!is_wp_error($user)) {
        // wp_clear_auth_cookie();
        wp_set_current_user($user->ID, $user->user_login);
        // wp_set_auth_cookie($user->ID);
        wp_send_json([
            'success' => true,
            'message' => 'ورود شما موفقیت آمیز بود. در حال انتقال ...'
        ], 200);
    } else {
        wp_send_json([
            'error' => true,
            'message' => 'نام کاربری یا کلمه عبور اشتباه است.'
        ], 403);
    }

    // var_dump($_POST);
}

function wp_lr_validate_input($email, $password)
{
    if (empty($email) && empty($password)) {
        wp_send_json([
            'error' => true,
            'message' => 'تکمیل تمامی فیلد ها الزامی می باشد.'
        ], 403);
    } elseif (empty($email)) {
        wp_send_json([
            'error' => true,
            'message' => 'لطفا ایمیل خود را وارد نمایید.'
        ], 403);
    } elseif (empty($password)) {
        wp_send_json([
            'error' => true,
            'message' => 'لطفا رمز عبور خود را وارد کنید.'
        ], 403);
    } elseif (!is_email($email)) {
        wp_send_json([
            'error' => true,
            'message' => 'ایمیل وارد شده صحیح نمی باشد.'
        ], 403);
    }
}

// Set expierd auth cookie
add_filter('auth_cookie_expiration','wp_lr_set_cookie',1);

function wp_lr_set_cookie($expiration)
{
    return $expiration = 60*60*48;
}
