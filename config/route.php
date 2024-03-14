<?php

return [
    '/user' => [
        'GET' => 'User::registration',
    ],
    '/user/add' => [
        'POST' => 'User::add',
    ],
    '/user/login' => [
        'GET' => 'User::login',
    ],
    '/user/authorized' => [
        'POST' => 'User::authorized',
    ],
    '/user/logout' => [
        'POST' => 'User::logout',
    ],
    '/user/{id}' => [
        'GET' => 'User::profile',
    ],

    '/admin/user' => [
        'GET' => 'Admin::list',
    ],
    '/admin/user/{id}' => [
        'GET' => 'Admin::show',
        'DELETE' => 'Admin::delete',
        'PUT' => 'Admin::update',
    ],

    '/file/load' => [
        'GET' => 'File::load',
        'POST' => 'File::upload',
    ],
    '/file/download' => [
        'GET' => 'File::download',
    ],
    '/file/delete' => [
        'DELETE' => 'File::delete',
    ],

    '/password/forgot' => [
        'POST' => 'Password::send'
    ],
    '/password/newpass' => [
        'POST' => 'Password::newpassword'
    ],
    // ещё нужно добавить директорию
];
