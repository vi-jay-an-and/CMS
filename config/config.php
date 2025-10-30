<?php
return [
    'db' => [
        'host' => getenv('CMS_DB_HOST') ?: 'localhost',
        'database' => getenv('CMS_DB_NAME') ?: 'college_management',
        'username' => getenv('CMS_DB_USER') ?: 'cms_user',
        'password' => getenv('CMS_DB_PASS') ?: 'secret',
        'charset' => 'utf8mb4',
    ],
    'notifications' => [
        'attendance_threshold' => 0.75,
    ],
];
