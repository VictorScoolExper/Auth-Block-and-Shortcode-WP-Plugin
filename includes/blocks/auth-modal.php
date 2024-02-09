<?php

function abs_auth_modal_render_cb($atts)
{
    if(is_user_logged_in()){
        return '';
    }

    ob_start();
    ?>
    <div class="wp-block-auth-block-shortcode-auth-modal">
        <div class="modal-container">
            <div class="modal-overlay"></div>

            <span class="modal-trick">&#8203;</span>

            <div class="modal-content">
                <button class="modal-btn-close" type="button">
                    <i class="bi bi-x"></i>
                </button>
                <!-- Tabs -->
                <ul class="tabs">
                    <!-- Login Tab -->
                    <li>
                        <a href="#signin-tab" class="active-tab">
                            <i class="bi bi-key"></i>Sign in
                        </a>
                    </li>
                    <?php
                    if ($atts['showRegister']) {
                        ?>
                        <!-- Register Tab -->
                        <li>
                            <a href="#signup-tab">
                                <i class="bi bi-person-plus-fill"></i>Sign up
                            </a>
                        </li>
                        <?php
                    }
                    ?>

                </ul>
                <div class="modal-body">
                    <!-- Login Form -->
                    <form id="signin-tab" style="display: block; ">
                        <div id="signin-status"></div>
                        <fieldset>
                            <label>Name/Email</label>
                            <input type="text" id="si-email" placeholder="johndoe@example.com" />

                            <label>Password</label>
                            <input type="password" id="si-password" />

                            <label>
                                Remember Me
                                <input type="checkbox" id="si-remember-me" style="width: 30px;">
                            </label>

                            <button type="submit">Sign in</button>
                        </fieldset>
                    </form>
                    <?php
                    if ($atts['showRegister']) {
                        ?>
                        <!-- Register Form -->
                        <form id="signup-tab">
                            <div id="signup-status"></div>
                            <fieldset>
                                <h3 id="su-user-type"><?php echo $atts['userRegisterType'] ?></h3>

                                <label>First Name</label>
                                <input type="text" id="su-first-name" placeholder="John" />

                                <label>Last Name</label>
                                <input type="text" id="su-last-name" placeholder="Doe" />

                                <label>Username</label>
                                <input type="text" id="su-username" placeholder="John123" />

                                <label>Email address</label>
                                <input type="email" id="su-email" placeholder="johndoe@example.com" />

                                <label for="su-password">Password</label>
                                <input type="password" id="su-password" />

                                <button type="submit">Sign up</button>
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