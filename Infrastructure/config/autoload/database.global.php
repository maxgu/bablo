<?php

return [
    'db' => [
        'driver' => 'Pdo',
        'dsn' => "mysql:dbname=bablo;host=db",
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ],
        'username' => 'bablo',
        'password' => '111',
    ]
];