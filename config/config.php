<?php
// Основные настройки
define('APP_NAME',    'Probio-Clean');
define('APP_URL',     'http://probio-clean.ru');
define('APP_LOCALE',  'ru_RU');
define('CURRENCY',    '₽');

// Пути к данным
define('DATA_PRODUCTS',    DATA . '/products/products.json');
define('DATA_CATEGORIES',  DATA . '/products/categories.json');
define('DATA_ORDERS',      DATA . '/orders/orders.json');
define('DATA_USERS',       DATA . '/users/users.json');
define('DATA_REVIEWS',     DATA . '/products/reviews.json');

// Сессия
define('SESSION_USER_KEY', 'auth_user');

// Пагинация каталога
define('PRODUCTS_PER_PAGE', 12);

// Типы клиентов
define('CLIENT_PRIVATE',  'private');   // физлицо
define('CLIENT_BUSINESS', 'business'); // юрлицо / бизнес

// Сессия админа
define('SESSION_ADMIN_KEY', 'auth_admin');

// Админ — логин/пароль хеш (сгенерируй через: php -r "echo password_hash('твой_пароль', PASSWORD_BCRYPT);")
define('ADMIN_LOGIN',    'admin');
define('ADMIN_PASSWORD_HASH', '$2y$10$AE8a3lm.xOXvKmTuJNGpCuIs0yJoELHjZr7bHoa2Jnk3q8O7yoSC6cr087350'); // = "password"

// B2B лиды
define('DATA_B2B_LEADS', DATA . '/b2b/leads.json');

// Email уведомления
define('MAIL_HOST',     'smtp.mail.ru');
define('MAIL_PORT',     465);
define('MAIL_USER',     'baranova-alenka221098@mail.ru');
define('MAIL_PASSWORD', 'CPHLnMGLoPNhHYrwWirQ');
define('MAIL_FROM',     'baranova-alenka221098@mail.ru');
define('MAIL_NAME',     'Probio-Clean');
define('ADMIN_EMAIL',   'baranova-alenka221098@mail.ru');
