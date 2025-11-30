<?php

return [
    'home' => [
        'about' => 'Візуалізуйте та контролюйте ключові компоненти міської інфраструктури в режимі реального часу. Наша платформа надає централізований інтерфейс на основі карти для гостей, операторів та адміністраторів.',
        'map_title' => 'Інтерактивна карта інфраструктури',
        'heatmap' => 'Теплова карта',
        'login' => 'Увійти',
        'logout' => 'Вийти',
        'register' => 'Зареєструватись',
        'dashboard' => 'Адмін-панель',
        'profile' => 'Профіль',
    ],
    'register' => [
        'title' => 'Створити акаунт',
        'subtitle' => 'Зареєструйтесь, щоб отримати доступ до свого акаунту.',
        'first_name' => __('fields.first_name'),
        'last_name' => __('fields.last_name'),
        'email_address' => __('fields.email_address'),
        'city' => __('fields.city'),
        'city_placeholder' => 'Почніть вводити...',
        'password' => __('fields.password'),
        'password_confirmation' => __('fields.password_confirmation'),
        'register' => 'Зареєструватися',
        'already_have_account' => 'Вже маєте акаунт? Увійти',
        'registered_successfully' => 'Ви успішно зареєструвалися!',
    ],
    'login' => [
        'title' => 'Ласкаво просимо назад!',
        'subtitle' => 'Увійдіть, щоб отримати доступ до свого акаунту.',
        'email_address' => __('fields.email_address'),
        'password' => __('fields.password'),
        'login' => 'Увійти',
        'forgot_password' => 'Не можете увійти?',
    ],
    'forget_password' => [
        'title' => 'Забули пароль?',
        'subtitle' => 'Введіть свою електронну пошту, щоб отримати посилання для скидання пароля.',
        'email_address' => __('fields.email_address'),
        'send_link' => 'Надіслати посилання для скидання',
        'back' => 'Назад до входу',
    ],
    'reset_password' => [
        'title' => 'Скидання пароля',
        'email_address' => __('fields.email_address'),
        'new_password' => __('fields.new_password'),
        'password_confirmation' => __('fields.password_confirmation'),
        'reset' => 'Скинути пароль',
    ],
    'profile' => [
        'menu' => [
            'my_requests' => 'Мої запити',
            'new_request' => 'Новий запит',
            'my_profile' => 'Мій профіль',
        ],
        'my_profile' => [
            'new_password_placeholder' => 'Залиште порожнім, щоб зберегти поточний',
            'updated_successfully' => 'Профіль успішно оновлено',
            'profile_photo' => 'Фото профілю',
        ],
        'new_request' => [
            'title' => 'Новий запит',
            'title_field' => __('fields.title'),
            'description' => __('fields.description'),
            'infrastructure_object' => "Об'єкт інфраструктури",
            'photo' => 'Фото',
            'submit' => 'Надіслати запит',
            'saved_successfully' => 'Ваш запит було успішно надіслано!',
            'not_authorized_dashboard' => 'Ви не маєте прав доступу до панелі керування.',
        ],
    ],
    'dashboard' => [
        'route_build_failed' => 'Не вдалося побудувати маршрут: :error',
        'requests' => [
            'updated_successfully' => 'Запит успішно оновлено.',
            'deleted_successfully' => 'Запит успішно видалено.',
        ],
        'objects' => [
            'created_successfully' => 'Об’єкт інфраструктури успішно створено.',
            'updated_successfully' => 'Об’єкт інфраструктури успішно оновлено.',
            'deleted_successfully' => 'Об’єкт інфраструктури успішно видалено.',
        ],
        'users' => [
            'deleted_successfully' => 'Користувача успішно видалено.',
        ]
    ],
];