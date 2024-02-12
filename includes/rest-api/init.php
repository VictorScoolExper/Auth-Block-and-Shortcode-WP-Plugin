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
        'permission_callback' => function ($request) {
            // Verify the nonce passed in the 'X-WP-Nonce' header.
            // Note: This is a conceptual example. WordPress does this automatically for REST requests.
            $nonce = $request->get_header('X-WP-Nonce');
            if (!wp_verify_nonce($nonce, 'wp_rest')) {
                return new WP_Error('rest_forbidden', esc_html__('Nonce verification failed.', 'text-domain'), ['status' => 403]);
            }
            return true;
        }
    ]);

    register_rest_route('abs/v1', '/signin', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'abs_rest_api_signin_handler',
        'permission_callback' => function ($request) {
            $nonce = $request->get_header('X-WP-Nonce');
            if (!wp_verify_nonce($nonce, 'wp_rest')) {
                return new WP_Error('rest_forbidden', esc_html__('Nonce verification failed.', 'text-domain'), ['status' => 403]);
            }
            return true;
        }
    ]);
}
