<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function abs_auth_modal_render_cb($atts)
{
    if(is_user_logged_in()){
        return '';
    }

    $nonce = wp_create_nonce('wp_rest');

    ob_start();
    ?>
    <div class='wp-block-auth-block-shortcode-auth-modal'>
        <div class='modal-container'>
            <div class='modal-overlay'></div>

            <span class='modal-trick'>&#8203;</span>

            <div class='modal-content'>
                <button class='modal-btn-close' type='button'>
                    <i class='bi bi-x'></i>
                </button>
                <!-- Tabs -->
                <ul class='tabs'>
                    <!-- Login Tab -->
                    <li>
                        <a href='#signin-tab' class='active-tab'>
                            <i class='bi bi-key'></i>Sign in
                        </a>
                    </li>
                    <?php
                    if ($atts['showRegister']) {
                        ?>
                        <!-- Register Tab -->
                        <li>
                            <a href='#signup-tab'>
                                <i class='bi bi-person-plus-fill'></i>Sign up
                            </a>
                        </li>
                        <?php
                    }
                    ?>

                </ul>
                <div class='modal-body'>
                    <!-- Login Form -->
                    <form id='signin-tab' style='display: block;'>

                        <!-- Include the nonce here for non-AJAX fallback or clarity -->
                        <input type='hidden' name='wp_rest_nonce' value='<?php echo esc_attr($nonce); ?>' />

                        <div id='signin-status'></div>
                        <fieldset>
                            <label for="si-email"><?php esc_html_e('Email', 'auth-block-shortcode'); ?></label>
                            <input type='email' id='si-email' placeholder='<?php echo esc_attr__('johndoe@example.com', 'auth-block-shortcode'); ?>' required/>

                            <label for="si-password"><?php esc_html_e('Password', 'auth-block-shortcode'); ?></label>
                            <input type='password' id='si-password' required/>

                            <label for="si-remember-me">
                                <?php esc_html_e('Remember Me', 'auth-block-shortcode'); ?>
                                <input type='checkbox' id='si-remember-me' style='width: 30px;'>
                            </label>

                            <button type='submit'><?php esc_html_e('Sign in', 'auth-block-shortcode'); ?></button>
                        </fieldset>
                    </form>
                    <?php
                    if ($atts['showRegister']) {
                        ?>
                        <!-- Register Form -->
                        <form id='signup-tab'>

                            <!-- Include the nonce here for non-AJAX fallback or clarity -->
                            <input type='hidden' name='wp_rest_nonce' value='<?php echo esc_attr($nonce); ?>' />

                            <div id='signup-status'></div>
                           
                            <fieldset>
                                <h3 id='su-user-type'><?php echo esc_html($atts['userRegisterType']); ?></h3>

                                <label for="su-first-name"><?php esc_html_e('First Name', 'auth-block-shortcode'); ?></label>
                                <input type='text' id='su-first-name' 
                                        placeholder='<?php echo esc_attr__('John', 'auth-block-shortcode'); ?>' 
                                        required>

                                <label for="su-last-name"><?php esc_html_e('Last Name', 'auth-block-shortcode'); ?></label>
                                <input type='text' id='su-last-name' 
                                        placeholder='<?php echo esc_attr__('Doe', 'auth-block-shortcode'); ?>'
                                        required>

                                <label for="su-username"><?php esc_html_e('Username', 'auth-block-shortcode'); ?></label>
                                <input type='text' id='su-username' 
                                        placeholder='<?php echo esc_attr__('John123', 'auth-block-shortcode'); ?>' 
                                        required>

                                <label for="su-email"><?php esc_html_e('Email address', 'auth-block-shortcode'); ?></label>
                                <input type='email' id='su-email' 
                                        placeholder='<?php echo esc_attr__('johndoe@example.com', 'auth-block-shortcode'); ?>' 
                                        required>

                                <label for='su-password'><?php esc_html_e('Password', 'auth-block-shortcode'); ?></label>
                                <input type='password' id='su-password' 
                                    pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}' 
                                    title='<?php echo esc_attr__('Password must contain at least one number, one uppercase and lowercase letter, and at least 8 or more characters', 'auth-block-shortcode'); ?>' 
                                    required>
                                
                                <div class="woocommerce-privacy-policy-text">
                                    <p><?php echo esc_html__('Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our', 'your-text-domain'); ?> <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>" class="woocommerce-privacy-policy-link" target="_blank"><?php echo esc_html__('privacy policy', 'your-text-domain'); ?></a>.</p>
                                </div>


                                <button type='submit'><?php esc_html_e('Sign up', 'auth-block-shortcode'); ?></button>
                            </fieldset>
                        </form>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
    <?php

    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}