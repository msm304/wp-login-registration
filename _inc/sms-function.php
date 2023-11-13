<?php

function wp_lr_add_verification_code($verification_code)
{
    global $wpdb;
    $table = $wpdb->prefix . 'lr_sms_verify_code';
    $data = [
        'verification_code' => $verification_code,
    ];
    $format = ['%s'];
    $stmt = $wpdb->insert($table, $data, $format);
    if ($stmt) {
        return $stmt;
    } else {
        false;
    }
}
