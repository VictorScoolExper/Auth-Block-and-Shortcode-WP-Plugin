<?php 
    // If this file is called directly, abort.
    if ( ! defined( 'ABSPATH' ) ) {
        exit; // Exit if accessed directly.
    }


    function abs_enqueue_scripts(){
        
        $authURLs = json_encode([
            'signup' => esc_url_raw(rest_url('abs/v1/signup')),
            'signin' => esc_url_raw(rest_url('abs/v1/signin'))
        ]);
    
        wp_add_inline_script( 
            'auth-block-shortcode-auth-modal-script',
            "const abs_auth_rest = {$authURLs}",
            'before' // we can change this to 'after', if you want to load after
        );
    }
