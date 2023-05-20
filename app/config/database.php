<?php
return [
    'default' => get_env('DB_DEFAULT', 'mysql'), // Conexión por defecto a utilizar

    'connections' => [

        'mysql' => [ // Configuración para la conexión 'mysql'
            'driver' => 'mysql', // Driver de la base de datos
            'host' => get_env('DB_HOST', '127.0.0.1'), // Host de la base de datos
            'port' => get_env('DB_PORT', '3306'), // Puerto de la base de datos
            'database' => get_env('DB_NAME', 'forge'), // Nombre de la base de datos
            'username' => get_env('DB_USERNAME', 'forge'), // Nombre de usuario para la conexión
            'password' => get_env('DB_PASSWORD', ''), // Contraseña para la conexión
        ],

        'nowengd' => [ // Configuración para la conexión 'nowengd'
            'driver' => 'mysql', // Driver de la base de datos
            'host' => get_env('DBL_HOST', '127.0.0.1'), // Host de la base de datos
            'port' => get_env('DBL_PORT', '3306'), // Puerto de la base de datos
            'database' => get_env('DBL_NAME', 'forge'), // Nombre de la base de datos
            'username' => get_env('DBL_USERNAME', 'forge'), // Nombre de usuario para la conexión
            'password' => get_env('DBL_PASSWORD', ''), // Contraseña para la conexión
        ],
      
    ],


];

