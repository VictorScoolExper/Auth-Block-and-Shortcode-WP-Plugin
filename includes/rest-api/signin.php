<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function abs_rest_api_signin_handler($request)
{
    $response = ['status' => 1];
    $params = $request->get_json_params();

    if (
        !isset($params['user_login'], $params['password']) ||
        empty($params['user_login']) ||
        empty($params['password'])
    ) {
        return $response;
    }

    if(!isset($params['remember_me']) ||  empty($params['remember_me'])){
        $params['remember_me'] = false;
    } 

    $email = sanitize_email($params['user_login']);
    $password = sanitize_text_field($params['password']);
    $remember_me = sanitize_text_field( $params['remember_me'] );
    // $remember_me = filter_var($params['remember_me'], FILTER_VALIDATE_BOOLEAN);

    // disable remember if site handles sensitive information
    $user = wp_signon([
        'user_login' => $email,
        'user_password' => $password,
        'remember' => $remember_me
    ]);

    if (is_wp_error($user)) {
        return $response;
    }

    $response['status'] = 2;
    return $response;
}
