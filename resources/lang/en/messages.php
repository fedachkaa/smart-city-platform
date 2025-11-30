<?php

return [
    'home' => [
        'about' => 'Visualize and monitor key urban infrastructure components in real-time. Our platform provides a centralized, map-based interface for Guests, Operators, and Administrators!',
        'map_title' => 'Interactive Infrastructure Map',
        'heatmap' => 'Heatmap',
        'login' => 'Login',
        'logout' => 'Logout',
        'register' => 'Register',
        'dashboard' => 'Dashboard',
        'profile' => 'Profile',
    ],
    'register' => [
        'title' => 'Create Account',
        'subtitle' => 'Sign up to access your account.',
        'first_name' => __('fields.first_name'),
        'last_name' => __('fields.last_name'),
        'email_address' => __('fields.email_address'),
        'city' => __('fields.city'),
        'city_placeholder' => 'Start typing...',
        'password' => __('fields.password'),
        'password_confirmation' => __('fields.password_confirmation'),
        'register' => 'Register',
        'already_have_account' => 'Already have an account? Login',
        'registered_successfully' => 'You have been successfully registered!',
    ],
    'login' => [
        'title' => 'Welcome Back!',
        'subtitle' => 'Sign in to access your account.',
        'email_address' => __('fields.email_address'),
        'password' => __('fields.password'),
        'login' => 'Login',
        'forgot_password' => 'Trouble logging in?',
        'not_authorized_dashboard' => 'You are not authorized to access the dashboard.',
    ],
    'forget_password' => [
        'title' => 'Forgot Your Password?',
        'subtitle' => 'Enter your email address to receive a password reset link.',
        'email_address' => __('fields.email_address'),
        'send_link' => 'Send Reset Link',
        'back' => 'Back to Login',
    ],
    'reset_password' => [
        'title' => 'Reset your password',
        'email_address' => __('fields.email_address'),
        'new_password' => __('fields.new_password'),
        'password_confirmation' => __('fields.password_confirmation'),
        'reset' => 'Reset Password',
    ],
    'profile' => [
        'menu' => [
            'my_requests' => 'My Requests',
            'new_request' => 'New Request',
            'my_profile' => 'My Profile',
        ],
        'my_profile' => [
            'new_password_placeholder' => 'Leave blank to keep current',
            'updated_successfully' => 'Profile updated successfully',
            'profile_photo' => 'Profile photo',
        ],
        'new_request' => [
            'title' => 'Create New Request',
            'title_field' => __('fields.title'),
            'description' => __('fields.description'),
            'infrastructure_object' => 'Infrastructure object',
            'photo' => 'Photo',
            'submit' => 'Submit request',
            'saved_successfully' => 'Your request has been submitted successfully!'
        ],
    ],
    'dashboard' => [
        'route_build_failed' => 'Failed to build route: :error',
        'requests' => [
            'updated_successfully' => 'Request updated successfully.',
            'deleted_successfully' => 'Request deleted successfully.',
        ],
        'objects' => [
            'created_successfully' => 'Infrastructure object created successfully.',
            'updated_successfully' => 'Infrastructure object updated successfully.',
            'deleted_successfully' => 'Infrastructure object deleted successfully.',
        ],
        'users' => [
            'deleted_successfully' => 'User has been successfully deleted.',
        ],
        'profile' => [
            'updated_successfully' => 'Profile has been updated successfully.',
        ],
    ],
];