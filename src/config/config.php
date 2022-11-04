<?php
return [
    'default' => 'bcrypt',
    'driver'  => [
        'bcrypt'   => [
            'rounds' => env( 'BCRYPT_ROUNDS',10 ),
        ],
        'argon'    => [
            'memory'  => 65536,
            'threads' => 1,
            'time'    => 4,
        ],
        'argon2id' => [
            'memory'  => 1024,
            'threads' => 2,
            'time'    => 2,
        ],
    ],
];
