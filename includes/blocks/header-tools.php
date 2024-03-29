<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function abs_header_tools_render_cb($atts)
{
    $user = wp_get_current_user();
    $name = $user->exists() ? $user->user_login : 'Sign in';
    $openClass = $user->exists() ? '' : 'open-modal';

    ob_start();
    ?>
    <div class="wp-block-auth-block-shortcode-header-tools">
        <?php
        if ($atts['showAuth']) {
            ?>
            <a 
                class="signin-link <?php echo $openClass; ?>" 
                href="<?php echo $atts['signedInRedirectLink'] ?>"
                style="color: <?php echo $atts['textandIconColor'] ?>;"
                >
                <div class="signin-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="signin-text">
                    <small style="color: #000000;">Hello,
                        <?php echo $name; ?>
                    </small>
                    My Account
                </div>
            </a>
            <?php
        }
        ?>

    </div>
    <?php

    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}
