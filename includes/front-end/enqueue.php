<?php 
    // If this file is called directly, abort.
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }


    function abs_enqueue_scripts(){
        
        // $authURLs = json_encode([
        //     'signup' => esc_url_raw(rest_url('abs/v1/signup')),
        //     'signin' => esc_url_raw(rest_url('abs/v1/signin'))
        // ]);
    
        // wp_add_inline_script( 
        //     'auth-block-shortcode-auth-modal-script',
        //     "const abs_auth_rest = {$authURLs}",
        //     'before' // we can change this to 'after', if you want to load after
        // );

         // URLs and nonce for REST API
        $script_data = array(
            'urls' => array(
                'signup' => esc_url_raw(rest_url('abs/v1/signup')),
                'signin' => esc_url_raw(rest_url('abs/v1/signin'))
            ),
            'nonce' => wp_create_nonce('wp_rest') // Generate the nonce here
        );

        // Properly localize the script
        wp_localize_script('auth-block-shortcode-auth-modal-script', 'abs_auth_rest', $script_data);

        // Enqueue the script
        wp_enqueue_script('auth-block-shortcode-auth-modal-script');
    }
