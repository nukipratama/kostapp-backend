<?php

return [
    'registration' => [
        'reward' => [
            'regular_user' => env('CREDIT_REWARD_REGULAR_USER', 20),
            'premium_user' => env('CREDIT_REWARD_REGULAR_USER', 40),
        ]
    ],
    'monthly' => [
        'reward' => [
            'regular_user' => env('CREDIT_REWARD_REGULAR_USER', 20),
            'premium_user' => env('CREDIT_REWARD_REGULAR_USER', 40),
        ]
    ],
];
