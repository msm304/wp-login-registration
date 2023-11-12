<?php

add_action('wp_ajax_nopriv_wp_lr_auth_login', 'wp_lr_auth_login');
function wp_lr_auth_login()
{
    if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'])) {
        die('Access Denied !!!');
    }
    $email = sanitize_text_field($_POST['email']);
    $password = sanitize_text_field($_POST['password']);
    $remember_me = sanitize_text_field($_POST['remember_me']);
    wp_lr_validate_input($email, $password);


    // var_dump($_POST);
}

function wp_lr_validate_input($email, $password)
{
    if (empty($email) && empty($password)) {
        wp_send_json([
            'error' => true,
            'message' => 'تکمیل تمامی فیلد ها الزامی می باشد'
        ], 403);
    } elseif (empty($email)) {
        wp_send_json([
            'error' => true,
            'message' => 'لطفا ایمیل خود را وارد نمایید'
        ], 403);
    } elseif (empty($password)) {
        wp_send_json([
            'error' => true,
            'message' => 'لطفا رمز عبور خود را وارد کنید'
        ], 403);
    } elseif (!is_email($email)) {
        wp_send_json([
            'error' => true,
            'message' => 'ایمیل وارد شده صحیح نمی باشد'
        ], 403);
    }
}
