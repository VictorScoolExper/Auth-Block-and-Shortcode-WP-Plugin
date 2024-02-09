<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

function is_strong_password($password) {
    // Define the criteria for a strong password.
    // Feel free to adjust these criteria based on your security requirements.
    $minLength = 8;
    $hasUppercase = preg_match('@[A-Z]@', $password);
    $hasLowercase = preg_match('@[a-z]@', $password);
    $hasNumber = preg_match('@[0-9]@', $password);
    $hasSpecialChar = preg_match('@[^\w]@', $password);

    // Check if all criteria are met.
    return strlen($password) >= $minLength && $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar;
}

//TODO: Add Name, Lastname and phone number(if possible)
function abs_rest_api_signup_handler($request)
{
    $response = ['status' => 1];
    $params = $request->get_json_params();

    if (
        !isset($params['first_name'], $params['last_name'], $params['email'], $params['username'], $params['password']) ||
        empty($params['first_name']) ||
        empty($params['last_name']) ||
        empty($params['email']) ||
        empty($params['username']) ||
        empty($params['password']) 
    ) {
        return $response;
    }

    $first_name = sanitize_text_field( $params['first_name'] );
    $last_name = sanitize_text_field( $params['last_name'] );
    $email = sanitize_email($params['email']);
    $username = sanitize_text_field($params['username']);
    $password = sanitize_text_field($params['password']);
    $user_role = sanitize_text_field( $params['userRegisterType'] );

    if (!is_strong_password($password)) {
        // You can adjust the response to include a message about password strength requirements.
        $response['status'] = 4; // Consider using a different status code or message to indicate the issue.
        $response['error'] = 'Password does not meet the strength requirements.';
        return $response;
    }

    // secure that role will not be admin
    switch($user_role){
        case 'Admin': 
            echo 'Silly, Silly, Willy... You got me... Sympathy Please!!!';
            return $response;
        case 'admin':
            echo 'Silly, Silly, Willy... You got me... Sympathy Please!!!';
            return $response;
        case 'Subscriber':
            $user_role = 'subscriber';
            break;
        case 'subscriber':
            $user_role = 'subscriber';
            break;
        case 'Customer':
            $user_role = 'customer';
            break;
        case 'customer':
            $user_role = 'customer';
            break;
        default:
            $user_role = 'subscriber';
            break;
    }

    // checks database for existing data
    if (
        username_exists($username) ||
        !is_email($email) ||
        email_exists($email)
    ) {
        return $response;
    }

    $userID = wp_insert_user([
        'user_login' => $username,
        'user_pass' => $password,
        'user_email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'role' => $user_role
    ]);

    if (is_wp_error($userID)) {
        return $response;
    }

    wp_new_user_notification($userID, null, 'user');
    wp_set_current_user($userID);
    wp_set_auth_cookie($userID);

    // gets user by id
    $user = get_user_by('id', $userID);

    // hook notifies other plugin that user logged in
    do_action('wp_login', $user->user_login, $user); 

    $response['status'] = 2;
    return $response;
}
