<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function abs_rest_api_init()
{
    // route example: example.com/wp-json/abs/v1/signup
    register_rest_route('abs/v1', '/signup', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'abs_rest_api_signup_handler',
        'permission_callback' => '__return_true'
    ]);

    register_rest_route('abs/v1', '/signin', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'abs_rest_api_signin_handler',
        'permission_callback' => '__return_true'
    ]);
}
