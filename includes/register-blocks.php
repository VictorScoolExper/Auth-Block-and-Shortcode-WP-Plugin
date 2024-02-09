<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

function abs_register_blocks()
{
    $blocks = [
        [
            'name' => 'header-tools',
            'options' => [
                // render_callback is for server rendering
                'render_callback' => 'abs_header_tools_render_cb'
            ]
        ],
        [
            'name' => 'auth-modal',
            'options' => [
                'render_callback' => 'abs_auth_modal_render_cb'
            ]
        ]
    ];

    foreach ($blocks as $block) {
        register_block_type(
            ABS_PLUGIN_DIR . 'build/blocks/' . $block['name'],
            isset($block['options']) ? $block['options'] : []
        );
    }
}

