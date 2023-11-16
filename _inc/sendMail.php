<?php
function wp_lr_send_mail($phpmailer)
{
    $phpmailer->isSMTP();
    $phpmailer->Host = 'mail.owebra.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 587;
    $phpmailer->Username = 'test@owebra.com';
    $phpmailer->Password = 'Amir204204';
    $phpmailer->From = 'info@owebra.com';
    $phpmailer->FromName = 'owebra';
}

add_action('phpmailer_init', 'wp_lr_send_mail');
